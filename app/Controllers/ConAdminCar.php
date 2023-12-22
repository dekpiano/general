<?php

namespace App\Controllers;

class ConAdminCar extends BaseController
{
    public function __construct(){
        $session = session();
        if(!$session->get('username') && $session->get('status') != "admin" && $session->get('status') != "manager"){
            header("Location:".base_url()); exit();
        } 
    }
    
    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $data['uri'] = service('uri'); 
        return $data;
    }

    private function resizeImage($path, $width, $height)
    {
        $image = \Config\Services::image()
            ->withFile(ROOTPATH . $path)
            ->resize($width, $height, true) // ให้สมส่วน
            ->save(ROOTPATH . $path);
    }

    public function CarMain()
    {
        $data = $this->DataMain();
        $data['title']="ข้อมูลรถยนต์";

        $f = file_get_contents('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_province.json');
        $data['Province'] = json_decode( $f );

       // echo '<pre>';print_r($v[0]->name_th);exit();

        return view('Admin/AdminLeyout/AdminHeader',$data)
                .view('Admin/AdminLeyout/AdminMenuLeft')
                .view('Admin/AdminCar/AdminCarMain')
                .view('Admin/AdminLeyout/AdminFooter');
    }

    public function CarInsert()
    {  
        helper(['form', 'url']);
         
        $database = \Config\Database::connect();
        $builder = $database->table('tb_car_data');
        
        $imageFile = $this->request->getFile('CarD_Img');
        
        if (!empty($imageFile) && $imageFile->isValid() && !$imageFile->hasMoved()) {
            
            $type = $imageFile->getMimeType();
            $newName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'uploads/admin/Car/',$newName);
            $this->resizeImage('uploads/admin/Car/' . $newName, 2048, 1024);

            $data = [
                'CarD_Register' => $this->request->getPost('CarD_Register'),
                'CarD_Province' => $this->request->getPost('CarD_Province'),
                'CarD_Category' => $this->request->getPost('CarD_Category'),
                'CarD_Brand' => $this->request->getPost('CarD_Brand'),
                'CarD_Model' => $this->request->getPost('CarD_Model'),
                'CarD_NumberSeats' => $this->request->getPost('CarD_NumberSeats'),
                'CarD_Details' => $this->request->getPost('CarD_Details'),
                'CarD_Img'  => $newName,
                'CarD_AdminID' => $_SESSION['id']

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

    public function CarShowData(){
      
        $database = \Config\Database::connect();
        $builder = $database->table('tb_car_data');

        $CarRecords = $builder->get()->getResult();
        $data = array();
        foreach ($CarRecords as $row) {
            $data[] = array(
                "CarD_ID"=>$row->CarD_ID ,
               "CarD_Register"=>$row->CarD_Register,
               "CarD_Province"=>$row->CarD_Province,
               "CarD_Category"=>$row->CarD_Category,
               "CarD_Brand"=>$row->CarD_Brand,
               "CarD_Model"=>$row->CarD_Model,
               "CarD_NumberSeats"=>$row->CarD_NumberSeats,
               "CarD_Details"=>$row->CarD_Details,
               "CarD_Img"=>$row->CarD_Img,
            );
         }

         $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
       // echo '<pre>'; print_r($data);

    }

    public function CarDelete(){
        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $DelKey = $this->request->getVar('DelKey');

        $delImg = $builder->select('location_img')->where('location_ID',$DelKey)->get()->getFirstRow();
        $img = $delImg->location_img;
        $path_to_file = './uploads/admin/Car/'.$img;
        if(unlink($path_to_file)) {
            $builder->delete(['location_img' => $img]);
            echo true;
        }
        else{
            echo false;
        }


       //echo base_url('/uploads/admin/Car/'.$delImg[0]->location_img);

    }
}