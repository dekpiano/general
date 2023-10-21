<?php

namespace App\Controllers;
use App\Libraries\Datethai; // Import library

class ConUserRepair extends BaseController
{  

    function __construct(){
       
    }


    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   
        $data['uri'] = service('uri'); 
        return $data;
    }

    public function RepairMain()
    {
        $session = session();
        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');

        $data = $this->DataMain();
        $data['title']="ระบบงานแจ้งซ่อม";
        $data['description']="หน้าแรกระบบงานแจ้งซ่อม";
        $data['UrlMenuMain'] = 'Repair';
        $data['UrlMenuSub'] = '';
        $data['Datethai'] = new Datethai();

        $data['DictationAll'] = $builder->countAll();
       
       

        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserRepair/UserRepairMain')
                .view('User/UserLeyout/UserFooter');
    }

    public function RepairAdd()
    {
        $session = session();
        $database = \Config\Database::connect();
        $DBpers = \Config\Database::connect('personnel');
        $DBskj = \Config\Database::connect('skj');
        $Skj = $DBskj->table('tb_position');
        $builder = $database->table('tb_location');

        $data = $this->DataMain();
        $data['title']="เพิ่มข้อมูลงานแจ้งซ่อม";
        $data['description']="บันทึกงานแจ้งซ่อม";
        $data['UrlMenuMain'] = 'Repair';
        $data['UrlMenuSub'] = '';

       $data['Posi'] = $Skj->get()->getResult();
       
       $data['Datethai'] = new Datethai();
       //echo '<pre>'; print_r($data['Datethai']); exit();


        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserRepair/UserRepairAdd')
                .view('User/UserLeyout/UserFooter');
    } 


    public function CheckPosiUser(){
        $DBpers = \Config\Database::connect('personnel');
        $TBPres = $DBpers->table('tb_personnel');

        $this->request->getVar('repair_posi');
        $data = $TBPres->select('pers_id,pers_prefix,pers_firstname,pers_lastname')
        ->where('pers_position',$this->request->getVar('repair_posi'))
        ->where('pers_status','กำลังใช้งาน')
        ->get()->getResult();
        
        echo json_encode($data);
    }


    public function RepairInsert(){

        $DBrepair = \Config\Database::connect();
        $TBrepair = $DBrepair->table('tb_repair');

        // Your form submission handler
        $hCaptchaSecretKey = 'ES_47c9a8452c844bf6b5bf834237aacb8d'; // Replace with your secret key
        $hCaptchaResponse = $_POST['h-captcha-response'];

        $response = file_get_contents("https://hcaptcha.com/siteverify?secret=$hCaptchaSecretKey&response=$hCaptchaResponse");
        $responseData = json_decode($response);
        if ($responseData->success) {       

            $data = $TBrepair->select('repair_order')->orderBy('repair_ID ','DESC')->get()->getResult();
            if(!empty($data)){
            $sub = explode('_',$data[0]->repair_order);             
                $OrderNumber = $sub[0].'_'.sprintf("%08d",$sub[1]+1);
            }else{
                $OrderNumber = "SKJRP_".date('Y')."0001";
            }
            //echo '<pre>'; print_r($data[0]->repair_order); 
        // exit();
            $data = [
                'repair_order' => $OrderNumber,
                'repair_datetime' => date('Y-m-d H:i:s'),
                'repair_posi' => $this->request->getVar('repair_posi'),
                'repair_userID' => $this->request->getVar('repair_userID'),
                'repair_phone' => $this->request->getVar('repair_phone'),
                'repair_building' => $this->request->getVar('repair_building'),
                'repair_class' => $this->request->getVar('repair_class'),
                'repair_room' => $this->request->getVar('repair_room'),
                'repair_caselist' => $this->request->getVar('repair_caselist'),
                'repair_detail' => $this->request->getVar('repair_detail'),
                'repair_status' => 'รอดำเนินการ',
                'repair_Repairman' => '',
            ];
                    
            echo $TBrepair->insert($data);

        } else {
            echo 0;
        }
    }

    public function DataTableShowRepari(){
        $session = session();
        $DBrepair = \Config\Database::connect();
        $TBrepair = $DBrepair->table('tb_repair');
        $DBpers = \Config\Database::connect('personnel');
        $TBPres = $DBpers->table('tb_personnel');
        $Datethai = new Datethai();

       $S_data = $TBrepair->select('
       repair_ID,repair_order,repair_datetime,repair_userID,repair_phone,repair_caselist,repair_status,pers_prefix,pers_firstname,pers_lastname
       ')
       ->join('skjacth_personnel.tb_personnel','tb_repair.repair_userID = tb_personnel.pers_id')
       ->get()->getResult();

       $data = array();
       foreach ($S_data as $row) {
           $data[] = array(
                "repair_ID"=>$row->repair_ID,
              "repair_order"=>$row->repair_order,
              "repair_datetime"=>$Datethai->thai_date_and_time(strtotime($row->repair_datetime)),
              "repair_userID"=>$row->repair_userID,
              "repair_caselist"=>$row->repair_caselist,
              "repair_status"=>$row->repair_status,
              'UserFullname'=>$row->pers_prefix.$row->pers_firstname.' '.$row->pers_lastname
           );
        }

        $response = array(           
           "aaData" => $data
        );
        echo json_encode($response);
    }

    public function CheckRepairFullDetail(){
        $DBrepair = \Config\Database::connect();
        $TBrepair = $DBrepair->table('tb_repair');
        $DBpers = \Config\Database::connect('personnel');
        $TBpers = $DBpers->table('tb_personnel');

        $json = [];
        $data = $TBrepair->select('tb_repair.*,tb_position.posi_name,tb_personnel.pers_prefix,tb_personnel.pers_firstname,tb_personnel.pers_lastname')
        ->where('repair_ID',$this->request->getVar('RepairId'))
        ->join('skjacth_personnel.tb_personnel','tb_repair.repair_userID = tb_personnel.pers_id')
        ->join('skjacth_skj.tb_position','tb_repair.repair_posi = tb_position.posi_id')
        ->get()->getResult();
        array_push($json,$data);
       
        if($data[0]->repair_Repairman != ''){
            $check = $TBpers->select('pers_prefix,pers_firstname,pers_lastname')
            ->where('pers_id',$data[0]->repair_Repairman)
            ->get()->getResult();
            array_push($json,$check);
        }else{
            array_push($json,'pers_prefix,pers_firstname,pers_lastname');
        }

        echo json_encode($json);
    }
  
    public function RepairUpdateWork(){
        $DBrepair = \Config\Database::connect();
        $TBrepair = $DBrepair->table('tb_repair');       
        $image = $this->request->getFile('repair_imgwork');
        if (!empty($image) && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'uploads/admin/Repair/', $newName);
    
            $this->resizeImage('uploads/admin/Repair/' . $newName, 2048, 1024);
    
            $data = [
                'repair_status' => $this->request->getPost('repair_status'),
                'repair_datework' => $this->request->getPost('repair_datework'),
                'repair_Repairman' => $this->request->getPost('repair_Repairman'),
                'repair_cause' => $this->request->getPost('repair_cause'),
                'repair_imgwork'  => $newName,
                'repair_usersignature' => $this->request->getPost('Signature')
            ];
        } else {
            $data = [
                'repair_status' => $this->request->getPost('repair_status'),
                'repair_datework' => $this->request->getPost('repair_datework'),
                'repair_Repairman' => $this->request->getPost('repair_Repairman'),
                'repair_cause' => $this->request->getPost('repair_cause'),
                'repair_usersignature' => $this->request->getPost('Signature')
            ];
        }
            $TBrepair->where('repair_order', $this->request->getPost('repair_order'));
       echo $TBrepair->update($data);

    }

    private function resizeImage($path, $width, $height)
    {
        $image = \Config\Services::image()
            ->withFile(ROOTPATH . $path)
            ->resize($width, $height, true) // ให้สมส่วน
            ->save(ROOTPATH . $path);
    }

    
}
