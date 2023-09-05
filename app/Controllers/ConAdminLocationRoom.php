<?php

namespace App\Controllers;

class ConAdminLocationRoom extends BaseController
{
    public function __construct(){
        $session = session();
        if(!$session->get('username')){
            header("Location:".base_url()); exit();
        } 
    }
    
    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $data['uri'] = service('uri'); 
        return $data;
    }

    public function LocationRoomMain()
    {
        $data = $this->DataMain();
        $data['title']="จัดการข้อมูลห้องประชุมและสถานที่";

        return view('Admin/AdminLeyout/AdminHeader',$data)
                .view('Admin/AdminLeyout/AdminMenuLeft')
                .view('Admin/AdminMeetingRoom/AdminMeetingRoomMain')
                .view('Admin/AdminLeyout/AdminFooter');
    }

    public function LocationRoomInsert()
    {  
        helper(['form', 'url']);
         
        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $validateImage = $this->validate([
            'file' => [
                'uploaded[location_img]',
                'max_size[location_img, 10000]',
            ],
        ]);
    
        $response = [
            'success' => false,
            'data' => '',
            'msg' => "อัพโหลดไฟล์ไม่ถูกต้อง"
        ];
        if ($validateImage) {
            $imageFile = $this->request->getFile('location_img');
            $type = $imageFile->getMimeType();
            $newName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'uploads/admin/LocationRoom/',$newName);
            $data = [
                'location_name' => $this->request->getPost('location_name'),
                'location_detail' => $this->request->getPost('location_detail'),
                'location_number' => $this->request->getPost('location_number'),
                'location_seats' => $this->request->getPost('location_seats'),
                'location_img'  => $newName,
                'location_create' => date("Y-m-d H:i:s"),
                'location_Admin' => $_SESSION['id']

            ];
            $save = $builder->insert($data);
            $response = [
                'success' => true,
                'data' => $save,
                'msg' => "บันทึกข้อมูลเรียบร้อย"
            ];
        }
        return $this->response->setJSON($response);
    }

    public function LocationRoomShowData(){
      
        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');

        $DictationRecords = $builder->get()->getResult();
        $data = array();
        foreach ($DictationRecords as $row) {
            $data[] = array(
                "location_ID"=>$row->location_ID ,
               "location_name"=>$row->location_name,
               "location_detail"=>$row->location_detail,
               "location_number"=>$row->location_number,
               "location_seats"=>$row->location_seats,
               "location_img"=>$row->location_img
            );
         }

         $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
       // echo '<pre>'; print_r($data);

    }

    public function LocationRoomDelete(){
        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $DelKey = $this->request->getVar('DelKey');

        $delImg = $builder->select('location_img')->where('location_ID',$DelKey)->get()->getFirstRow();
        $img = $delImg->location_img;
        $path_to_file = './uploads/admin/LocationRoom/'.$img;
        if(unlink($path_to_file)) {
            $builder->delete(['location_img' => $img]);
            echo true;
        }
        else{
            echo false;
        }


       //echo base_url('/uploads/admin/LocationRoom/'.$delImg[0]->location_img);

    }
}