<?php

namespace App\Controllers;

class ConAdminCar extends BaseController
{
    public function __construct(){
        $session = session();
        $status = $session->get('status');
        if(!$session->get('username') && $status != "admin" && $status != "manager" && $status != "superadmin"){
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

        // รายการจังหวัดทั้งหมดของประเทศไทย
        $data['Province'] = $this->getThaiProvinces();

        return view('Admin/AdminCar/AdminCarMain', $data);
    }

    /**
     * คืนค่ารายชื่อจังหวัดทั้ง 77 จังหวัดของประเทศไทย
     */
    private function getThaiProvinces()
    {
        $provinces = [
            'กระบี่', 'กรุงเทพมหานคร', 'กาญจนบุรี', 'กาฬสินธุ์', 'กำแพงเพชร',
            'ขอนแก่น', 'จันทบุรี', 'ฉะเชิงเทรา', 'ชลบุรี', 'ชัยนาท',
            'ชัยภูมิ', 'ชุมพร', 'เชียงราย', 'เชียงใหม่', 'ตรัง',
            'ตราด', 'ตาก', 'นครนายก', 'นครปฐม', 'นครพนม',
            'นครราชสีมา', 'นครศรีธรรมราช', 'นครสวรรค์', 'นนทบุรี', 'นราธิวาส',
            'น่าน', 'บึงกาฬ', 'บุรีรัมย์', 'ปทุมธานี', 'ประจวบคีรีขันธ์',
            'ปราจีนบุรี', 'ปัตตานี', 'พระนครศรีอยุธยา', 'พังงา', 'พัทลุง',
            'พิจิตร', 'พิษณุโลก', 'เพชรบุรี', 'เพชรบูรณ์', 'แพร่',
            'พะเยา', 'ภูเก็ต', 'มหาสารคาม', 'มุกดาหาร', 'แม่ฮ่องสอน',
            'ยโสธร', 'ยะลา', 'ร้อยเอ็ด', 'ระนอง', 'ระยอง',
            'ราชบุรี', 'ลพบุรี', 'ลำปาง', 'ลำพูน', 'เลย',
            'ศรีสะเกษ', 'สกลนคร', 'สงขลา', 'สตูล', 'สมุทรปราการ',
            'สมุทรสงคราม', 'สมุทรสาคร', 'สระแก้ว', 'สระบุรี', 'สิงห์บุรี',
            'สุโขทัย', 'สุพรรณบุรี', 'สุราษฎร์ธานี', 'สุรินทร์', 'หนองคาย',
            'หนองบัวลำภู', 'อ่างทอง', 'อุดรธานี', 'อุทัยธานี', 'อุตรดิตถ์',
            'อุบลราชธานี', 'อำนาจเจริญ'
        ];
        
        // แปลงเป็น object เพื่อให้ใช้งานเหมือนเดิม
        $result = [];
        foreach ($provinces as $province) {
            $obj = new \stdClass();
            $obj->name_th = $province;
            $result[] = $obj;
        }
        
        return $result;
    }

    public function CarInsert()
    {  
        helper(['form', 'url']);
         
        $database = \Config\Database::connect();
        $builder = $database->table('tb_school_car');
        
        $imageFile = $this->request->getFile('CarD_Img');
        
        if (!empty($imageFile) && $imageFile->isValid() && !$imageFile->hasMoved()) {
            
            $type = $imageFile->getMimeType();
            $newName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'uploads/admin/Car/',$newName);
            $this->resizeImage('uploads/admin/Car/' . $newName, 2048, 1024);

            $data = [
                'car_registration' => $this->request->getPost('CarD_Register'),
                'car_province' => $this->request->getPost('CarD_Province'),
                'car_category' => $this->request->getPost('CarD_Category'),
                'car_brand' => $this->request->getPost('CarD_Brand'),
                'car_model' => $this->request->getPost('CarD_Model'),
                'car_seats' => $this->request->getPost('CarD_NumberSeats'),
                'car_detail' => $this->request->getPost('CarD_Details'),
                'car_status' => $this->request->getPost('CarD_Status') ?: 'ใช้งานได้',
                'car_img'  => $newName,
                'car_AdminID' => $_SESSION['id']

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

    public function CarUpdate()
    {
        helper(['form', 'url']);
         
        $database = \Config\Database::connect();
        $builder = $database->table('tb_school_car');
        
        $carId = $this->request->getPost('CarD_ID');
        if (empty($carId)) {
            return $this->response->setJSON(['success' => false, 'msg' => 'ไม่พบข้อมูลรถยนต์']);
        }

        $data = [
            'car_registration' => $this->request->getPost('CarD_Register'),
            'car_province' => $this->request->getPost('CarD_Province'),
            'car_category' => $this->request->getPost('CarD_Category'),
            'car_brand' => $this->request->getPost('CarD_Brand'),
            'car_model' => $this->request->getPost('CarD_Model'),
            'car_seats' => $this->request->getPost('CarD_NumberSeats'),
            'car_detail' => $this->request->getPost('CarD_Details'),
            'car_status' => $this->request->getPost('CarD_Status') ?: 'ใช้งานได้',
            'car_AdminID' => $_SESSION['id']
        ];

        $imageFile = $this->request->getFile('CarD_Img');
        
        if (!empty($imageFile) && $imageFile->isValid() && !$imageFile->hasMoved()) {
            
            // ลบรูปเก่า (ถ้ามี)
            $oldImgData = $builder->select('car_img')->where('car_ID', $carId)->get()->getRow();
            if ($oldImgData && $oldImgData->car_img && file_exists('./uploads/admin/Car/' . $oldImgData->car_img)) {
                unlink('./uploads/admin/Car/' . $oldImgData->car_img);
            }

            $type = $imageFile->getMimeType();
            $newName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'uploads/admin/Car/',$newName);
            $this->resizeImage('uploads/admin/Car/' . $newName, 2048, 1024);

            $data['car_img'] = $newName;
        }

        $builder->where('car_ID', $carId)->update($data);
        
        $response = [
            'success' => true,
            'msg' => "อัปเดตข้อมูลเรียบร้อย"
        ];
        
        return $this->response->setJSON($response);
    }

    public function CarShowData(){
      
        $database = \Config\Database::connect();
        $builder = $database->table('tb_school_car');

        $CarRecords = $builder->get()->getResult();
        $data = array();
        foreach ($CarRecords as $row) {
            $data[] = array(
                "car_ID"=>$row->car_ID  ,
               "car_registration"=>$row->car_registration,
               "car_province"=>$row->car_province,
               "car_category"=>$row->car_category,
               "car_brand"=>$row->car_brand,
               "car_model"=>$row->car_model,
               "car_seats"=>$row->car_seats,
               "car_detail"=>$row->car_detail,
               "car_status"=>$row->car_status,
               "car_img"=>$row->car_img,
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
        $builder = $database->table('tb_school_car');
        $DelKey = $this->request->getVar('DelKey');

        $delImg = $builder->select('car_img')->where('car_ID',$DelKey)->get()->getFirstRow();
        $img = $delImg->car_img;
        // print_r($img);
        // exit();
        $path_to_file = './uploads/admin/Car/'.$img;
        if(unlink($path_to_file)) {
            $builder->where('car_ID', $DelKey)->delete();
            echo true;
        }
        else{
            echo false;
        }


       //echo base_url('/uploads/admin/Car/'.$delImg[0]->location_img);

    }

    // ------------------------ คนขับรถ ------------------------------
    public function CarDriver(){
        $data = $this->DataMain();
        $data['title']="ข้อมูลคนขับรถยนต์";
        
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $DBpers->table('tb_personnel');

        $data['CheckDriver'] = $DBpersonnel->select('pers_id,pers_prefix,pers_firstname,pers_lastname,pers_phone')
        ->where('pers_status','กำลังใช้งาน')
        ->get()->getResult();

        //echo '<pre>';print_r($CheckDriver); exit();

        return view('Admin/AdminCar/AdminCarDriver', $data);

    }

    public function CarDriverShowData(){
      
        $database = \Config\Database::connect();
        $DBCarDriver = $database->table('tb_car_driver');
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $DBpers->table('tb_personnel');

        $CarDriverRecords = $DBCarDriver->select('
            skjacth_general.tb_car_driver.cardriver_id,
            skjacth_personnel.tb_personnel.pers_prefix,
            skjacth_personnel.tb_personnel.pers_firstname,
            skjacth_personnel.tb_personnel.pers_lastname,
            skjacth_personnel.tb_personnel.pers_phone,
            skjacth_personnel.tb_personnel.pers_img
        ')
        ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_driver.cardriver_userID')
        ->get()->getResult();
        $data = array();
        foreach ($CarDriverRecords as $row) {
            $data[] = array(
                "cardriver_id"=>$row->cardriver_id  ,
               "cardriver_Fullname"=>$row->pers_prefix.$row->pers_firstname.' '.$row->pers_lastname,
               "cardriver_phone" => $row->pers_phone,
               "cardriver_img" => $row->pers_img
            );
         }

         $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
       // echo '<pre>'; print_r($data);

    }

    public function CarDriverInsert()
    {  
        helper(['form', 'url']);
         
        $database = \Config\Database::connect();
        $DBCarDriver = $database->table('tb_car_driver');
       
            $data = [
                'cardriver_userID' => $this->request->getPost('cardriver_userID')
            ];
            $save = $DBCarDriver->insert($data);
            $response = [
                'success' => true,
                'data' => $save,
                'msg' => "บันทึกข้อมูลเรียบร้อย"
            ];
       
        return $this->response->setJSON($response);
    }

    public function CarDriverDelete(){
        $database = \Config\Database::connect();
        $CarDriver = $database->table('tb_car_driver');
        $DelKey = $this->request->getVar('DelKey');

       echo $CarDriver->where('cardriver_id', $DelKey)->delete();

    }

}