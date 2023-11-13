<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Libraries\Datethai; // Import library

class ConUserBooking extends BaseController
{

    function __construct(){
        
    }

    public function DataMain(){
       $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       $data['uri'] = service('uri'); 
       
        return $data;
    }

    public function BookingMain()
    {
        $session = session();
        $data = $this->DataMain();
        $data['title']="จองห้อง / สถานที่";
        $data['description']="ระบบสำหรับจองห้อง / สถานที่ ภายในโรงเรียน";
        $data['UrlMenuMain'] = 'Booking';
        $data['UrlMenuSub'] = 'BookingMain';

        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $data['CountLocationRoomAll'] = $builder->countAll();

        $DBbooking = $database->table('tb_booking');
        $data['CountbookingAll'] = $DBbooking->countAll();
        $data['NumRowsWaitApprove'] = $DBbooking->where('booking_status','ไม่อนุมัติ')->get()->getNumRows();
        $data['NumRowsApprove'] = $DBbooking->where('booking_status','อนุมัติ')->get()->getNumRows();

        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingMain')
                .view('User/UserLeyout/UserFooter');
    }
    
    public function BookingSelect()
    {
        $data = $this->DataMain();
        $data['title']="เลือกห้อง / สถานที่";
        $data['description']="เลือกห้องสำหรับใช้ภายในโรงเรียน";
        $data['UrlMenuMain'] = 'Booking';
        $data['UrlMenuSub'] = 'BookingSelect';
        $session = session();
      

        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $data['LocationRoomAll'] = $builder->get()->getResult();
         //echo "<pre>";print_r($data['LocationRoomAll']); exit();
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingSelect')
                .view('User/UserLeyout/UserFooter');
    }

    public function BookingAdd($LocationID = null)
    {
        $session = session();
        $data = $this->DataMain();
        $data['title']="จองห้อง / สถานที่";
        $data['description']="จองห้องสำหรับใช้ภายในโรงเรียน";
        $data['UrlMenuMain'] = 'Booking';
        $data['UrlMenuSub'] = 'BookingAdd'; 
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
        //echo "<pre>";print_r($data['BookignToday']); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingAdd')
                .view('User/UserLeyout/UserFooter');
    }

    public function BookingInsert(){

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
            'booking_status' => "รอตรวจสอบ" 
        ];
        
        $DBlocation->insert($data);
        echo $this->request->getVar('booking_locationroom');
        //print_r($this->request->getVar());
    }

    public function BookingUpdate(){

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
            'booking_status' => "รอตรวจสอบ" 
        ];

        $DBlocation->where('booking_id',$this->request->getVar('booking_id'));
        if($DBlocation->update($data)){
            echo $this->request->getVar('booking_locationroom');
        }
     
        //print_r($this->request->getVar());
    }

    public function BookingView($Key){

        $session = session();
        $data = $this->DataMain();
        $data['title']="ดูข้อมูลจองห้องประชุมและสถานที่";
        $data['description']="ดูข้อมูลจองห้องประชุมและสถานที่";
        $data['UrlMenuMain'] = 'Booking';
        $data['UrlMenuSub'] = 'BookingView';     
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
        ->select('booking_title,booking_locationroom,booking_Booker,booking_status,booking_reason,booking_id,location_name,booking_dateStart,booking_timeStart,booking_dateEnd,booking_timeEnd,booking_typeuse,pers_prefix,pers_firstname,pers_lastname');
        $DBbooking->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID');
        $DBbooking->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id");
        $Where;
        $data['Booking'] =  $DBbooking->orderBy('booking_id','DESC')->get()->getResult();
      
        //echo '<pre>';print_r($data['Booking']); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingView')
          
          
                .view('User/UserLeyout/UserFooter');
    }

    public function BookingEdit($Key){

        $session = session();
        $data = $this->DataMain();
        $data['title']="แก้ไขข้อมูลจองห้องประชุมและสถานที่";
        $data['description']="แก้ไขข้อมูลจองห้องประชุมและสถานที่";
        $data['UrlMenuMain'] = 'Booking';
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
        $data['Booking'] =  $DBbooking->orderBy('booking_id','DESC')->get()->getResult();
      
       //echo '<pre>';print_r($data['Booking']); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingEdit')
                .view('User/UserLeyout/UserFooter');
    }

    public function BookingCancel(){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $data = [
            'booking_status' => 'ยกเลิกโดยผู้จอง'
        ];        
        $DBbooking->where('booking_id', $this->request->getVar('KeyID'));
        echo $DBbooking->update($data);
    }

    public function ShowTimeBooking(){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

       $S_data = $DBbooking->select('booking_locationroom,booking_title,booking_dateStart,booking_dateEnd,booking_timeStart,booking_timeEnd,location_name')
       ->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID')
       ->where('booking_status','อนุมัติ')
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

    public function CheckDateBooking(){
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

    public function CheckTimeBooking(){
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

    public function BookingViewApproveAdmin(){
        $session = session();
        $data = $this->DataMain();
        $data['title']="ดูข้อมูลจองห้องประชุมและสถานที่ (Admin)";
        $data['description']="ดูข้อมูลจองห้องประชุมและสถานที่ (Admin)";
        $data['UrlMenuMain'] = 'Booking';
        $data['UrlMenuSub'] = 'BookingView';     
        $data['Datethai'] = new Datethai();   

        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');
        $DBpersonnel = $database->table('personnel');
        $DBpers = \Config\Database::connect('personnel');

        $data['Booking'] =  $DBbooking->orderBy('booking_id','DESC')->get()->getResult();
      
       // echo '<pre>';print_r($data['Booking']); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingViewAdmin')
                .view('User/UserLeyout/UserFooter');
    }

    public function BookingDataTableApproveAdmin(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

       $S_data = $DBbooking->select('booking_id,booking_Booker,booking_locationroom,booking_title,booking_dateStart,booking_dateEnd,booking_timeStart,booking_timeEnd,booking_status,booking_reason,location_name,pers_prefix,pers_firstname,pers_lastname')
       ->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID')
       ->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id")
       //->where('booking_status','อนุมัติ')
       ->get()->getResult();
       $data = array();
        foreach ($S_data as $key => $value) {
            $data[]=[
                'booking_id' => $value->booking_id,
                'booking_title' => $value->booking_title,
                'booking_dateStart' => $Datethai->thai_date_and_time_short(strtotime($value->booking_dateStart)),
                'booking_dateEnd' => $Datethai->thai_date_and_time_short(strtotime($value->booking_dateEnd)),
                'booking_timeStart' => $value->booking_timeStart,
                'booking_timeEnd' => $value->booking_timeEnd,
                'location_name' => $value->location_name,
                'booking_Booker' => $value->booking_Booker,
                'booking_status' => $value->booking_status,
                'booking_reason' => $value->booking_reason,
                'booker' => $value->pers_prefix.$value->pers_firstname.' '.$value->pers_lastname
            ];        
        }

        $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
    } 

    public function BookingCheckApproveAdmin(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        echo $DBbooking->where('booking_id',$this->request->getPost('BookingID'))
        ->update(['booking_status'=>'อนุมัติ','booking_reason'=>'','booking_datecheck'=>date("Y-m-d H:i:s")]);

    }

    public function BookingNoApproveAdmin(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        echo $DBbooking->where('booking_id',$this->request->getPost('BookingID'))->update(['booking_status'=>'ไม่อนุมัติ','booking_reason'=>$this->request->getPost('booking_reason'),'booking_datecheck'=>date("Y-m-d H:i:s")]);
    }

}
