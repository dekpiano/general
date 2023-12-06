<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Libraries\Datethai; // Import library

class ConUserCarBooking extends BaseController
{

    function __construct(){
        
    }

    public function DataMain(){
       $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       $data['uri'] = service('uri'); 
       
        return $data;
    }

    public function CarBookingMain()
    {
        $session = session();
        $data = $this->DataMain();
        $data['title']="หน้าแรก | จองรถ";
        $data['description']="ระบบสำหรับจองรถภายในโรงเรียน";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingMain';

        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $data['CountLocationRoomAll'] = $builder->countAll();

        $DBbooking = $database->table('tb_booking');
        $data['CountbookingAll'] = $DBbooking->countAll();
        $data['NumRowsWaitApprove'] = $DBbooking->where('booking_admin_approve','ไม่อนุมัติ')->get()->getNumRows();
        $data['NumRowsApprove'] = $DBbooking->where('booking_admin_approve','อนุมัติ')->get()->getNumRows();

        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingMain')
                .view('User/UserLeyout/UserFooter');
    }
    
    public function CarBookingCheckCar()
    {
        $data = $this->DataMain();
        $data['title']="เช็ครถก่อนทำการจอง";
        $data['description']="เช็ครถก่อนทำการจอง";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingCheck';
        $session = session();
      

        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $data['LocationRoomAll'] = $builder->get()->getResult();
         //echo "<pre>";print_r($data['LocationRoomAll']); exit();
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingCheck')
                .view('User/UserLeyout/UserFooter');
    }

    public function CarBookingAdd($LocationID = null)
    {
        $session = session();
        $data = $this->DataMain();
        $data['title']="จองห้อง / สถานที่";
        $data['description']="จองห้องสำหรับใช้ภายในโรงเรียน";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingAdd'; 
        $data['Datethai'] = new Datethai();      
      
        $database = \Config\Database::connect();
        $DBlocation = $database->table('tb_location');
        $tb_booking = $database->table('tb_booking');
        $myTime = Time::now('asia/bangkok', 'th_TH');

        $data['loca'] = $DBlocation->where('location_ID',$LocationID)->get()->getRow();
        $data['BookignToday'] = $tb_booking
        ->select('booking_title,booking_dateStart,booking_timeStart,booking_dateEnd,booking_timeEnd')        
        ->where('booking_locationroom',$LocationID)
        ->get()->getResult();
        $data['CarBookingNow'] = $tb_booking->orderBy('booking_id','DESC')->get()->getRow();
       
        if(isset($data['CarBookingNow']->booking_order) == ""){
            $data['BookLatest'] = "BK_".date('Y')."0001";
        }else{
           $sub = explode('_',$data['CarBookingNow']->booking_order);          
           $data['BookLatest'] = $sub[0]."_".(((int)$sub[1])+1);
        }
        
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingAdd')
                .view('User/UserLeyout/UserFooter');
    }

    public function CarBookingInsert(){

        $session = session();
        $database = \Config\Database::connect();
        $DBlocation = $database->table('tb_booking');
        
        if($this->request->getVar('booking_equipment') != ""){
          $equipment = implode('|',$this->request->getVar('booking_equipment'));
        }else{
            $equipment = "";
        }
        $data = [
            'booking_locationroom' => $this->request->getVar('booking_locationroom'),
            'booking_order' => $this->request->getVar('booking_order'),
            'booking_number' => $this->request->getVar('booking_number'),
            'booking_title' => $this->request->getVar('booking_title'),
            'booking_dateStart' => $this->request->getVar('booking_dateStart'),
            'booking_timeStart' => $this->request->getVar('booking_timeStart'),
            'booking_dateEnd' => $this->request->getVar('booking_dateEnd'),
            'booking_timeEnd' => $this->request->getVar('booking_timeEnd'),
            'booking_typeuse' => $this->request->getVar('booking_typeuse'),
            'booking_other' => $this->request->getVar('booking_other'),
            'booking_Booker' => $this->request->getVar('booking_Booker'),
            'booking_telephone' => $this->request->getVar('booking_telephone'),
            'booking_equipment' => $equipment,
            'booking_admin_approve' => "รอตรวจสอบ" 
        ];
   
        if($DBlocation->insert($data)){
            $email = \Config\Services::email(); // loading for use
           
            $email->setFrom('admin_booking@skj.ac.th',"ระบบการจองอาคารสถานที่");
     
            // Send to Users     
            $email->setTo([
                "dekpiano@skj.ac.th","juthaporn.p@skj.ac.th"
            ]);

            $email->setSubject("แจ้งการจอง เลขที่ ".$this->request->getVar('booking_order'));

            $html = "<a href='https://general.skj.ac.th/CarBooking/Approve/Admin' traget='_blank'>ตรวจสอบข้อมูลที่นี่</a>";
            $email->setMessage($html);

            // Send email
            if ($email->send()) {
                echo $this->request->getVar('booking_locationroom');
            } else {
                $data = $email->printDebugger(['headers']);
                print_r($data);
            }
        }
        

        //echo $this->request->getVar('booking_locationroom');
        //print_r($this->request->getVar());
    }

    public function CarBookingUpdate(){

        $session = session();
        $database = \Config\Database::connect();
        $DBlocation = $database->table('tb_booking');
        
        if($this->request->getVar('booking_equipment') != ""){
          $equipment = implode('|',$this->request->getVar('booking_equipment'));
        }else{
            $equipment = "";
        }
        $data = [
            'booking_locationroom' => $this->request->getVar('booking_locationroom'),
            'booking_order' => $this->request->getVar('booking_order'),
            'booking_number' => $this->request->getVar('booking_number'),
            'booking_title' => $this->request->getVar('booking_title'),
            'booking_dateStart' => $this->request->getVar('booking_dateStart'),
            'booking_timeStart' => $this->request->getVar('booking_timeStart'),
            'booking_dateEnd' => $this->request->getVar('booking_dateEnd'),
            'booking_timeEnd' => $this->request->getVar('booking_timeEnd'),
            'booking_typeuse' => $this->request->getVar('booking_typeuse'),
            'booking_other' => $this->request->getVar('booking_other'),
            'booking_Booker' => $this->request->getVar('booking_Booker'),
            'booking_telephone' => $this->request->getVar('booking_telephone'),
            'booking_equipment' => $equipment,
            'booking_admin_approve' => "รอตรวจสอบ" 
        ];

        $DBlocation->where('booking_id',$this->request->getVar('booking_id'));
        if($DBlocation->update($data)){
            echo $this->request->getVar('booking_locationroom');
        }
     
        //print_r($this->request->getVar());
    }

    public function CarBookingView($Key){

        $session = session();
        $data = $this->DataMain();
        $data['title']="ดูข้อมูลจองห้องประชุมและสถานที่";
        $data['description']="ดูข้อมูลจองห้องประชุมและสถานที่";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingView';     
        $data['Datethai'] = new Datethai();   

        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $DBpersonnel = $database->table('personnel');

        //echo '<pre>';print_r($DBpersonnel); exit();

        $DBpers = \Config\Database::connect('personnel');

        if(isset($_SESSION['id']) == 1){
            if($Key == 'All'){
                $data['All'] = $Key;
                $data['CheckAll'] = 1;
            }else{
                $array =['booking_locationroom'=> $Key,'booking_Booker'=>$_SESSION['id']];
                $Where = $DBbooking->where($array);
                $data['CheckAll'] = 0;
            }            
        }else{
            if($Key == 'All'){
                $data['All'] = $Key;
                $data['CheckAll'] = 1;
            }else{
                $array =['booking_locationroom'=> $Key];
                $Where = $DBbooking->where($array);
                $data['CheckAll'] = 0;
            }
           
        }
      
       $DBbooking
        ->select('booking_order,booking_telephone,booking_title,booking_locationroom,booking_Booker,booking_admin_approve,booking_admin_reason,booking_id,location_name,booking_dateStart,booking_timeStart,booking_dateEnd,booking_timeEnd,booking_typeuse,pers_prefix,pers_firstname,pers_lastname');
        $DBbooking->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID');
        $DBbooking->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id");
        $Where;
        $data['CarBooking'] =  $DBbooking->orderBy('booking_id','DESC')->get()->getResult();
      
        //echo '<pre>';print_r($data['CarBooking']); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingView')
          
          
                .view('User/UserLeyout/UserFooter');
    }

    public function CarBookingEdit($Key){

        $session = session();
        $data = $this->DataMain();
        $data['title']="แก้ไขข้อมูลจองห้องประชุมและสถานที่";
        $data['description']="แก้ไขข้อมูลจองห้องประชุมและสถานที่";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'Edit';     
        $data['Datethai'] = new Datethai();   

        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $DBpersonnel = $database->table('personnel');

        //echo '<pre>';print_r($DBpersonnel); exit();

        $DBpers = \Config\Database::connect('personnel');

        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $data['LocationList'] = $builder->select('location_ID,location_name')->get()->getResult();
      
       $DBbooking
        ->select('tb_booking.*,location_ID,location_name,location_img,location_detail,pers_prefix,pers_firstname,pers_lastname');
        $DBbooking->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID');
        $DBbooking->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id");
        $DBbooking->where('booking_id',$Key);
        $data['CarBooking'] =  $DBbooking->orderBy('booking_id','DESC')->get()->getResult();
      
       //echo '<pre>';print_r($data['CarBooking']); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingEdit')
                .view('User/UserLeyout/UserFooter');
    }

    public function CarBookingCancel(){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $data = [
            'booking_admin_approve' => 'ยกเลิกโดยผู้จอง'
        ];        
        $DBbooking->where('booking_id', $this->request->getVar('KeyID'));
        echo $DBbooking->update($data);
    }

    public function ShowTimeCarBooking(){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

       $S_data = $DBbooking->select('booking_locationroom,booking_title,booking_dateStart,booking_dateEnd,booking_timeStart,booking_timeEnd,location_name')
       ->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID')
       ->where('booking_admin_approve','อนุมัติ')
       ->where('booking_executive_approve','อนุมัติ')
       ->get()->getResult();

        foreach ($S_data as $key => $value) {
            $data[]=[
                'id' => $value->booking_locationroom,
                'title'=> date('H:i',strtotime($value->booking_timeStart)).' - '.date('H:i',strtotime($value->booking_timeEnd)).' '.$value->booking_title.' '.$value->location_name,
                'start' => $value->booking_dateStart.' '.$value->booking_timeStart,
                'end' => date("Y-m-d", strtotime("+1 day",strtotime($value->booking_dateEnd))).' '.$value->booking_timeEnd
            ];        
        }

        return $this->response->setJSON($data, true);
    }

    public function CheckDateCarBooking(){
        // print_r($this->request->getVar());
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $CheckDateBookign = $DBbooking
        ->where('booking_dateStart',$this->request->getVar('booking_dateStart'))
        ->where('booking_timeStart <=',$this->request->getVar('booking_timeStart'))
        ->get()->getNumRows();
        echo $CheckDateBookign;
    }

    public function CheckTimeCarBooking(){
        // print_r($this->request->getVar());
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $CheckDateBookign = $DBbooking
        ->where('booking_dateEnd',$this->request->getVar('booking_dateEnd'))
        ->where('booking_timeEnd >=',$this->request->getVar('booking_timeEnd'))
        ->get()->getNumRows();
        echo $CheckDateBookign;
    }

    public function DictationInsert()
    {  
        helper(['form', 'url']);
         
        $database = \Config\Database::connect();
        $builder = $database->table('tb_dictation');
        $validateImage = $this->validate([
            'file' => [
                'uploaded[dicta_file]',
                'max_size[dicta_file, 10000]',
            ],
        ]);
    
        $response = [
            'success' => false,
            'data' => '',
            'msg' => "อัพโหลดไฟล์ไม่ถูกต้อง"
        ];
        if ($validateImage) {
            $imageFile = $this->request->getFile('dicta_file');
            $type = $imageFile->getMimeType();
            $newName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'uploads/User/dictation/',$newName);
            $data = [
                'dicta_year' => $this->request->getPost('dicta_year'),
                'dicta_number' => $this->request->getPost('dicta_number'),
                'dicta_createdate' => $this->request->getPost('dicta_createdate'),
                'dicta_title' => $this->request->getPost('dicta_title'),
                'dicta_file'  => $newName
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

    public function DictationShowData(){
      
        $database = \Config\Database::connect();
        $builder = $database->table('tb_dictation');

        $DictationRecords = $builder->get()->getResult();
        $data = array();
        foreach ($DictationRecords as $row) {
            $data[] = array(
               "dicta_year"=>$row->dicta_year,
               "dicta_number"=>$row->dicta_number,
               "dicta_createdate"=>$row->dicta_createdate,
               "dicta_title"=>$row->dicta_title,
               "dicta_file"=>$row->dicta_file
            );
         }

         $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
       // echo '<pre>'; print_r($data);

    }

    public function CarBookingViewApproveAdmin(){
        $session = session();
        if(!$session->get('username') && $session->get('status') != "admin" && $session->get('status') != "manager"){
            header("Location:".base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])); exit();
        } 
        $data = $this->DataMain();
        $data['title']="ดูข้อมูลจองห้องประชุมและสถานที่ (Admin)";
        $data['description']="ดูข้อมูลจองห้องประชุมและสถานที่ (Admin)";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingView';     
        $data['Datethai'] = new Datethai();   

        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');
        $DBpersonnel = $database->table('personnel');
        $DBpers = \Config\Database::connect('personnel');

        $data['CarBooking'] =  $DBbooking->orderBy('booking_id','DESC')->get()->getResult();
      
       // echo '<pre>';print_r($data['CarBooking']); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingViewAdmin')
                .view('User/UserLeyout/UserFooter');
    }

    public function CarBookingViewApproveExecutive(){
        $session = session();
        $data = $this->DataMain();
        $data['title']="ดูข้อมูลจองห้องประชุมและสถานที่ (ผู้บริหาร)";
        $data['description']="ดูข้อมูลจองห้องประชุมและสถานที่ (ผู้บริหาร)";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingView';     
        $data['Datethai'] = new Datethai();   

        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');
        $DBpersonnel = $database->table('personnel');
        $DBpers = \Config\Database::connect('personnel');

        $data['CarBooking'] =  $DBbooking->orderBy('booking_id','DESC')->get()->getResult();
      
       // echo '<pre>';print_r($data['CarBooking']); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingViewExecutive')
                .view('User/UserLeyout/UserFooter');
    }

    public function CarBookingDataTableApproveAdmin(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

       $S_data = $DBbooking->select('booking_id,booking_order,booking_telephone,booking_Booker,booking_locationroom,booking_title,booking_dateStart,booking_dateEnd,booking_timeStart,booking_timeEnd,booking_admin_approve,booking_admin_reason,location_name,pers_prefix,pers_firstname,pers_lastname')
       ->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID')
       ->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id")
       //->where('booking_admin_approve','อนุมัติ')
       ->get()->getResult();
       $data = array();
        foreach ($S_data as $key => $value) {
            $data[]=[
                'booking_id' => $value->booking_id,
                'booking_order' => $value->booking_order,
                'booking_title' => $value->booking_title,
                'booking_dateStart' => $Datethai->thai_date_and_time_short(strtotime($value->booking_dateStart)),
                'booking_dateEnd' => $Datethai->thai_date_and_time_short(strtotime($value->booking_dateEnd)),
                'booking_timeStart' => $value->booking_timeStart,
                'booking_timeEnd' => $value->booking_timeEnd,
                'location_name' => $value->location_name,
                'booking_Booker' => $value->booking_Booker,
                'booking_admin_approve' => $value->booking_admin_approve,
                'booking_admin_reason' => $value->booking_admin_reason,
                'booking_telephone' => $value->booking_telephone,
                'booker' => $value->pers_prefix.$value->pers_firstname.' '.$value->pers_lastname
            ];        
        }

        $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
    } 

    public function CarBookingDataTableApproveExecutive(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

       $S_data = $DBbooking->select('booking_id,booking_order,booking_telephone,booking_Booker,booking_locationroom,booking_title,booking_dateStart,booking_dateEnd,booking_timeStart,booking_timeEnd,booking_admin_approve,booking_admin_reason,location_name,pers_prefix,pers_firstname,pers_lastname,booking_executive_approve,booking_executive_reason')
       ->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID')
       ->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id")
       //->where('booking_admin_approve','อนุมัติ')
       ->get()->getResult();
       $data = array();
        foreach ($S_data as $key => $value) {
            $data[]=[
                'booking_id' => $value->booking_id,
                'booking_order' => $value->booking_order,
                'booking_title' => $value->booking_title,
                'booking_dateStart' => $Datethai->thai_date_and_time_short(strtotime($value->booking_dateStart)),
                'booking_dateEnd' => $Datethai->thai_date_and_time_short(strtotime($value->booking_dateEnd)),
                'booking_timeStart' => $value->booking_timeStart,
                'booking_timeEnd' => $value->booking_timeEnd,
                'location_name' => $value->location_name,
                'booking_Booker' => $value->booking_Booker,
                'booking_admin_approve' => $value->booking_admin_approve,
                'booking_admin_reason' => $value->booking_admin_reason,
                'booking_executive_approve' => $value->booking_executive_approve,
                'booking_executive_reason' => $value->booking_executive_reason,
                'booking_telephone' => $value->booking_telephone,
                'booker' => $value->pers_prefix.$value->pers_firstname.' '.$value->pers_lastname
            ];        
        }

        $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
    } 

    public function CarBookingCheckApproveAdmin(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        if($_SESSION['status'] === "ExecutiveGeneral"){
            $Approve = ['booking_executive_approve'=>'อนุมัติ','booking_executive_reason'=>'','booking_executive_datecheck'=>date("Y-m-d H:i:s"),'booking_executive_check'=>$_SESSION['id']];
        }elseif($_SESSION['status'] === "AdminGeneral"){
            $Approve = ['booking_admin_approve'=>'อนุมัติ','booking_admin_reason'=>'','booking_admin_datecheck'=>date("Y-m-d H:i:s"),'booking_admin_check'=>$_SESSION['id']];
        }

        $upApprove = $DBbooking->where('booking_id',$this->request->getPost('CarBookingID'))
        ->update($Approve);
        if($upApprove){
            $email = \Config\Services::email(); // loading for use
           
            $email->setFrom('admin_booking@skj.ac.th',"ระบบการจองอาคารสถานที่");
     
            // Send to Users     
            $email->setTo([
                "dekpiano@skj.ac.th"
            ]);

            $email->setSubject("การจองรออนุมัติจากผู้บริหาร");

            $html = "<a href='https://general.skj.ac.th/CarBooking/Approve/Admin' traget='_blank'>ตรวจสอบข้อมูลที่นี่</a>";
            $email->setMessage($html);

            // Send email
            if ($email->send()) {
                echo $this->request->getVar('booking_locationroom');
            } else {
                $data = $email->printDebugger(['headers']);
                print_r($data);
            }
        }
            

    }

    public function CarBookingNoApproveAdmin(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        if($_SESSION['status'] === "ExecutiveGeneral"){
            $NoApprove = ['booking_executive_approve'=>'ไม่อนุมัติ','booking_executive_reason'=>$this->request->getPost('booking_admin_reason'),'booking_executive_datecheck'=>date("Y-m-d H:i:s"),'booking_executive_check'=>$_SESSION['id']];
        }elseif($_SESSION['status'] === "AdminGeneral"){
            $NoApprove = ['booking_admin_approve'=>'ไม่อนุมัติ','booking_admin_reason'=>$this->request->getPost('booking_admin_reason'),'booking_admin_datecheck'=>date("Y-m-d H:i:s"),'booking_admin_check'=>$_SESSION['id']];
        }

        echo $DBbooking->where('booking_id',$this->request->getPost('CarBookingID'))->update($NoApprove);
    }

}