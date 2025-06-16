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

    private function sendLineMessage($userId, $messageText)
    {
        $accessToken = '6uPLX8E6wzICMzMr16kab9Qrf1gorrrbHBJHJ4rK7HFCsP/258uqhgqbf8i9VoopJX4o/4T9Go4gfKzQmxQryJG+LvnYfD3tHtrKXJ24SfsFEKXcW6xFBepKWOGRsoito2pr5neKVHNmSfjfDdwNowdB04t89/1O/w1cDnyilFU=';

        $data = [
            'to' => $userId,
            'messages' => [[
                'type' => 'text',
                'text' => $messageText
            ]]
        ];

        $ch = curl_init('https://api.line.me/v2/bot/message/push');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
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
        $data['NumRowsWaitApprove'] = $DBbooking->where('booking_admin_approve','ไม่อนุมัติ')->get()->getNumRows();
        $data['NumRowsApprove'] = $DBbooking->where('booking_admin_approve','อนุมัติ')->get()->getNumRows();

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
        if(!$session->get('username')){
            header("Location:".base_url()); exit();
        } 

        $data = $this->DataMain();
        $data['title']="จองห้อง / สถานที่";
        $data['description']="จองห้องสำหรับใช้ภายในโรงเรียน";
        $data['UrlMenuMain'] = 'Booking';
        $data['UrlMenuSub'] = 'BookingAdd'; 
        $data['Datethai'] = new Datethai();      

        $databasepers = \Config\Database::connect('personnel');
        $DBpers = $databasepers->table('tb_personnel');
      
        $database = \Config\Database::connect();
        $DBlocation = $database->table('tb_location');
        $tb_booking = $database->table('tb_booking');
        $myTime = Time::now('asia/bangkok', 'th_TH');

        $data['loca'] = $DBlocation->where('location_ID',$LocationID)->get()->getRow();
        $data['BookignToday'] = $tb_booking
        ->select('booking_title,booking_dateStart,booking_timeStart,booking_dateEnd,booking_timeEnd')        
        ->where('booking_locationroom',$LocationID)
        ->get()->getResult();

        $data['BookingNow'] = $tb_booking->orderBy('booking_id','DESC')->get()->getRow();
       
       
        if(isset($data['BookingNow']->booking_order) == ""){
            $data['BookLatest'] = "BK_".date('Y')."0001";
        }else{
           $sub = explode('_',$data['BookingNow']->booking_order);      
          
           $data['BookLatest'] = $sub[0]."_".(((int)$sub[1])+1);
        }
        
        $data['ListUser'] = $DBpers->select('pers_id,pers_prefix,pers_firstname,pers_lastname')
        ->where('pers_status','กำลังใช้งาน')
        ->orderBy('pers_position','ASC')
        ->orderBy('pers_learning','ASC')
        ->get()->getResult();

        //print_r($data['ListUser']);exit();


        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingAdd')
                .view('User/UserLeyout/UserFooter');
    }

    function thaidate_to_mysql($dateStr) {
        $parts = explode('/', $dateStr);
        if (count($parts) === 3) {
            return ($parts[2] - 543) . '-' . str_pad($parts[1], 2, '0', STR_PAD_LEFT) . '-' . str_pad($parts[0], 2, '0', STR_PAD_LEFT);
        }
        return null;
    }

    public function BookingInsert(){

        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');
        $Datethai = new Datethai();
        
        if($this->request->getVar('booking_equipment') != ""){
          $equipment = implode('|',$this->request->getVar('booking_equipment'));
        }else{
            $equipment = "";
        }
            $base64 = $this->request->getPost('booking_imgWork');
            if($base64){
                $data = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $base64));
                $filename = 'img_' . time() . '.png';
                $path = 'uploads/User/Booking/';
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }
                file_put_contents($path . $filename, $data);
            }else{
                $filename = "";
            }

            $booking_dateStart = $this->thaidate_to_mysql($this->request->getVar('booking_dateStart'));
            $booking_dateEnd = $this->thaidate_to_mysql($this->request->getVar('booking_dateEnd'));

        $data = [
            'booking_locationroom' => $this->request->getVar('booking_locationroom'),
            'booking_order' => $this->request->getVar('booking_order'),
            'booking_number' => $this->request->getVar('booking_number'),
            'booking_title' => $this->request->getVar('booking_title'),
            'booking_dateStart' =>  $booking_dateStart,
            'booking_timeStart' => $this->request->getVar('booking_timeStart'),
            'booking_dateEnd' => $booking_dateEnd,
            'booking_timeEnd' => $this->request->getVar('booking_timeEnd'),
            'booking_typeuse' => $this->request->getVar('booking_typeuse'),
            'booking_other' => $this->request->getVar('booking_other'),
            'booking_Booker' => $this->request->getVar('booking_Booker'),
            'booking_telephone' => $this->request->getVar('booking_telephone'),
            'booking_equipment' => $equipment,
            'booking_admin_approve' => "รอตรวจสอบ",
            'booking_imgWork' => $filename
        ];
   
        if($DBbooking->insert($data)){
            $DataNow = $database->insertID();

            $Booking = $DBbooking->select('
            skjacth_personnel.tb_personnel.pers_prefix,
            skjacth_personnel.tb_personnel.pers_firstname,
            skjacth_personnel.tb_personnel.pers_lastname,
            skjacth_general.tb_location.location_name,
            skjacth_general.tb_booking.booking_title,
            skjacth_general.tb_booking.booking_dateStart,
            skjacth_general.tb_booking.booking_dateEnd,
            skjacth_general.tb_booking.booking_typeuse
            ')
            ->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID')
            ->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id")
            ->where('booking_id',$DataNow)
            ->get()->getRowArray();
            
            $msg = "📣 แจ้งเตือนการขอใช้อาคารสถานที่ SKJ\n";
            $msg .= "👤 ผู้ขอ: {$Booking['pers_prefix']}{$Booking['pers_firstname']} {$Booking['pers_lastname']}\n";
            $msg .= "📅 วันที่ขอ: {$Datethai->thai_date_and_time_short(strtotime($Booking['booking_dateStart']))} - {$Datethai->thai_date_and_time_short(strtotime($Booking['booking_dateEnd']))}\n";
            $msg .= "⛪ สถานที่: {$Booking['location_name']}\n";
            $msg .= "🎯 วัตถุประสงค์: {$Booking['booking_title']}\n";
            $msg .= "👉 รับงาน: " . base_url("/Booking/Approve/Admin");

            // 3. ส่งข้อความ (ใช้ userId หรือ groupId ของช่าง)

            $this->sendLineMessage('C135052df1f6c6de703cc6a2a9758b872', $msg);
            echo 1;
        }
        
            // $email = \Config\Services::email(); // loading for use
           
            // $email->setFrom('admin_booking@skj.ac.th',"ระบบการจองอาคารสถานที่");
     
            // // Send to Users     
            // $email->setTo([
            //     "dekpiano@skj.ac.th"
            // ]);

            // $email->setSubject("แจ้งการจอง เลขที่ ".$this->request->getVar('booking_order'));

            // $html = "<a href='https://general.skj.ac.th/Booking/Approve/Admin' traget='_blank'>ตรวจสอบข้อมูลที่นี่</a>";
            // $email->setMessage($html);

            // // Send email
            // if ($email->send()) {
            //     echo $this->request->getVar('booking_locationroom');
            // } else {
            //     $data = $email->printDebugger(['headers']);
            //     print_r($data);
            // }

        //echo $this->request->getVar('booking_locationroom');
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
        ->select('booking_order,booking_telephone,booking_title,booking_locationroom,booking_Booker,booking_admin_approve,booking_admin_reason,booking_id,location_name,booking_dateStart,booking_timeStart,booking_dateEnd,booking_timeEnd,booking_typeuse,pers_prefix,pers_firstname,pers_lastname');
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
            'booking_admin_approve' => 'ยกเลิกโดยผู้จอง'
        ];        
        $DBbooking->where('booking_id', $this->request->getVar('KeyID'));
        echo $DBbooking->update($data);
    }

    public function ShowTimeBooking(){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

       $S_data = $DBbooking->select('booking_locationroom,booking_title,booking_dateStart,booking_dateEnd,booking_timeStart,booking_timeEnd,booking_admin_approve,location_name,booking_admin_reason')
       ->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID')
       //->where('booking_admin_approve','อนุมัติ')
       //->where('booking_executive_approve','อนุมัติ')
       ->get()->getResult();

      

        foreach ($S_data as $key => $value) {
            $color = '';
            switch ($value->booking_admin_approve) {
                case 'รอตรวจสอบ':
                    $color = '#ffab00';
                    $icon = '⏳';
                    break;
                case 'อนุมัติ':
                    $color = '#71dd37';
                    $icon = '✔';
                    break;
                case 'ไม่อนุมัติ':
                    $color = '#ff3e1d';
                    $icon = '⨉';
                    break;                
                default:
                    $color = '#fd7e14'; // สีเริ่มต้น
            }
            
            

            $data[]=[
                'id' => $value->booking_locationroom,
                'title'=> $icon.' '.date('H:i',strtotime($value->booking_timeStart)).' - '.date('H:i',strtotime($value->booking_timeEnd)).' '.$value->location_name.' '.$value->booking_title,
                'start' => $value->booking_dateStart.' '.$value->booking_timeStart,
                'end' => date("Y-m-d", strtotime("+1 day",strtotime($value->booking_dateEnd))).' '.$value->booking_timeEnd,
                'backgroundColor' => $color,
                'booking_admin_approve' => $value->booking_admin_approve,
                'booking_admin_reason' => $value->booking_admin_reason
            ];        
        }

        return $this->response->setJSON($data, true);
    }

    function convertBuddhistToGregorian($dateStr)
    {
        // รับรูปแบบ: 03/04/2568
        $parts = explode('/', $dateStr);
        
        if (count($parts) === 3) {
            // ดึงวัน/เดือน/ปี
            $day = (int)$parts[0];
            $month = (int)$parts[1];
            $year = (int)$parts[2];

            // แปลง พ.ศ. → ค.ศ.
            if ($year > 2400) {
                $year -= 543;
            }

            // คืนค่าในรูปแบบ Y-m-d
            return sprintf('%04d-%02d-%02d', $year, $month, $day);
        }

        return null; // รูปแบบไม่ถูกต้อง
    }

    public function CheckDateBooking(){
        // print_r($this->request->getVar());
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');
        $locationroom       = $this->request->getPost('booking_locationroom');
        $dateStart          = $this->request->getPost('booking_dateStart');
        $timeStart          = $this->request->getPost('booking_timeStart');
        $dateEnd            = $this->request->getPost('booking_dateEnd');
        $timeEnd            = $this->request->getPost('booking_timeEnd');

         // ถ้ายังไม่กรอกครบ ให้ส่งข้อความว่า "รอตรวจสอบ"
        if (!$dateStart || !$timeStart || !$dateEnd || !$timeEnd) {
            return $this->response->setJSON([
                'status' => null,
                'message' => '🕐 เลือกวันและเวลาให้ครบก่อนระบบจะตรวจสอบการจอง',
                'class' => 'alert alert-warning'
            ]);
        }

        $gDateStart = $this->convertBuddhistToGregorian($dateStart);
        $gDateEnd   = $this->convertBuddhistToGregorian($dateEnd);

        $proposedStart = date('Y-m-d H:i:s',strtotime($gDateStart . ' ' . $timeStart));
        $proposedEnd   = date('Y-m-d H:i:s',strtotime($gDateEnd   . ' ' . $timeEnd));

        $CheckDateBookign = $DBbooking
        ->where('booking_locationroom', $locationroom)
        ->where("STR_TO_DATE(CONCAT(booking_dateStart, ' ', booking_timeStart), '%Y-%m-%d %H:%i:%s') < '$proposedEnd'", null, false)
        ->where("STR_TO_DATE(CONCAT(booking_dateEnd, ' ', booking_timeEnd), '%Y-%m-%d %H:%i:%s') > '$proposedStart'", null, false)
        ->get()->getResult();
        //print_r($CheckDateBookign);
        if(!$CheckDateBookign){
            return $this->response->setJSON([
                'status' => 1,
                'message' => '✔️สามารถทำการจองวันและเวลาที่เลือกได้',
                'class' => 'alert alert-success'
            ]);
        }else{
            return $this->response->setJSON([
                'status' => 0,
                'message' => '❌ มีการจองในช่วงเวลานี้แล้ว กรุณาเลือกวันและเวลาที่ว่าง หรือเลือกห้องสถานที่อื่น',
                'class' => 'alert alert-danger'
            ]);
        }
       
    }

    public function CheckTimeBooking(){
        // print_r($this->request->getVar());
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $CheckDateBookign = $DBbooking
        ->where('booking_locationroom',$this->request->getVar('booking_locationroom'))
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
        if(!$session->get('username') && $session->get('status') != "admin" && $session->get('status') != "manager"){
            header("Location:".base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])); exit();
        } 
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

    public function BookingViewApproveExecutive(){
        $session = session();
        $data = $this->DataMain();
        $data['title']="ดูข้อมูลจองห้องประชุมและสถานที่ (ผู้บริหาร)";
        $data['description']="ดูข้อมูลจองห้องประชุมและสถานที่ (ผู้บริหาร)";
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
                .view('User/UserBooking/UserBookingViewExecutive')
                .view('User/UserLeyout/UserFooter');
    }

    public function BookingDataTableApproveAdmin(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

       $S_data = $DBbooking->select('booking_id,booking_order,booking_telephone,booking_Booker,booking_locationroom,booking_title,booking_dateStart,booking_dateEnd,booking_timeStart,booking_timeEnd,booking_admin_approve,booking_admin_reason,booking_executive_approve,location_name,booking_imgWork,
        CONCAT(p1.pers_prefix, p1.pers_firstname, " ", p1.pers_lastname) AS booker_name,
        CONCAT(p2.pers_prefix, p2.pers_firstname, " ", p2.pers_lastname) AS admin_name,
        CONCAT(p3.pers_prefix, p3.pers_firstname, " ", p3.pers_lastname) AS executive_name')
       ->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID')
       ->join('skjacth_personnel.tb_personnel AS p1', 'tb_booking.booking_Booker = p1.pers_id')
        ->join('skjacth_personnel.tb_personnel AS p2', 'tb_booking.booking_admin_check = p2.pers_id', 'left')
        ->join('skjacth_personnel.tb_personnel AS p3', 'tb_booking.booking_executive_approve = p3.pers_id', 'left')
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
                'booking_telephone' => $value->booking_telephone,
                'booker' => $value->booker_name,
                'admin_name' => $value->admin_name,
                'executive_name' => $value->executive_name,
                'booking_imgWork' => $value->booking_imgWork,
            ];        
        }

        $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
    } 

    public function BookingDataTableApproveExecutive(){
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

    public function BookingCheckApproveAdmin(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');
        $DBpersonnel = \Config\Database::connect('personnel');
        $DBpers = $DBpersonnel->table('personnel'); 

      

        if($_SESSION['status'] === "ExecutiveGeneral"){
            $Approve = ['booking_executive_approve'=>'อนุมัติ','booking_executive_reason'=>'','booking_executive_datecheck'=>date("Y-m-d H:i:s"),'booking_executive_check'=>$_SESSION['id']];
        }else if($_SESSION['status'] === "AdminGeneral"){
             $Approve = ['booking_admin_approve'=>'อนุมัติ','booking_admin_reason'=>'','booking_admin_datecheck'=>date("Y-m-d H:i:s"),'booking_admin_check'=>$_SESSION['id']];             
        }

        $upApprove = $DBbooking->where('booking_id',$this->request->getPost('BookingID'))->update($Approve);
        if($upApprove){
            
            $CheckUserForEmail = $DBbooking->select('
            skjacth_personnel.tb_personnel.pers_username,
            skjacth_general.tb_booking.booking_order,
            skjacth_personnel.tb_personnel.pers_prefix,
            skjacth_personnel.tb_personnel.pers_firstname,
            skjacth_personnel.tb_personnel.pers_lastname,
            skjacth_general.tb_booking.booking_dateStart,
            skjacth_general.tb_booking.booking_dateEnd,
            skjacth_general.tb_location.location_name,
            skjacth_general.tb_booking.booking_title')
            ->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id")
            ->join('skjacth_general.tb_location','skjacth_general.tb_booking.booking_locationroom = skjacth_general.tb_location.location_ID')
            ->where('booking_id',$this->request->getPost('BookingID'))
            ->get()->getRow();
            
            //echo '<pre>';print_r(); exit();
            $email = \Config\Services::email(); // loading for use
           
            $email->setFrom($_SESSION['email'],"ระบบการจองอาคารสถานที่");
     
            // Send to Users     
            $email->setTo([
                $CheckUserForEmail->pers_username
            ]);

            $email->setSubject("การจองรออนุมัติจากผู้ดูและระบบ เลขที่ ".$CheckUserForEmail->booking_order);

            // $html = "<a class='' href='https://general.skj.ac.th/Booking/Approve/Admin' traget='_blank'>ตรวจสอบข้อมูลที่นี่</a>";

            $html = '
                <!DOCTYPE html>
                <html>
                <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>แจ้งเตือนการขอใช้อาคารสถานที่ SKJ</title>
                </head>
                <body style="font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7fa; margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">
                    <div class="email-container" style="max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); overflow: hidden; border: 1px solid #e0e0e0;">
                        <div class="header" style="background-color: #007bff; color: #ffffff; padding: 25px 30px; text-align: center; font-size: 24px; font-weight: bold;">
                            <span class="icon" style="font-size: 30px; margin-right: 10px; vertical-align: middle;">📣</span> แจ้งเตือนการขอใช้อาคารสถานที่ SKJ
                        </div>
                        <div class="content" style="padding: 30px; color: #333333; line-height: 1.6;">
                            <p style="margin-bottom: 15px; font-size: 16px;">เรียน '.$CheckUserForEmail->pers_prefix.$CheckUserForEmail->pers_firstname." ".$CheckUserForEmail->pers_lastname.',</p>
                            <p style="margin-bottom: 15px; font-size: 16px;">การขอใช้อาคารสถานที่ได้รับการอนุมัติแล้ว </p>

                            <table class="info-table" role="presentation" cellspacing="0" cellpadding="0" border="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                                
                                <tr>
                                    <td style="padding: 12px 0; vertical-align: top; border-bottom: 1px solid #eeeeee; font-weight: bold; color: #555555; width: 120px;">📅 วันที่ขอ:</td>
                                    <td style="padding: 12px 0; vertical-align: top; border-bottom: 1px solid #eeeeee;">'.$Datethai->thai_date_fullmonth(strtotime($CheckUserForEmail->booking_dateStart)).' - '.$Datethai->thai_date_fullmonth(strtotime($CheckUserForEmail->booking_dateEnd)).'</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; vertical-align: top; border-bottom: 1px solid #eeeeee; font-weight: bold; color: #555555; width: 120px;">⛪ สถานที่:</td>
                                    <td style="padding: 12px 0; vertical-align: top; border-bottom: 1px solid #eeeeee;">'.$CheckUserForEmail->location_name.'</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; vertical-align: top; border-bottom: none; font-weight: bold; color: #555555; width: 120px;">🎯 วัตถุประสงค์:</td>
                                    <td style="padding: 12px 0; vertical-align: top; border-bottom: none;">'.$CheckUserForEmail->booking_title.'</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; vertical-align: top; border-bottom: 1px solid #eeeeee; font-weight: bold; color: #555555; width: 120px;">👤 เจ้าหน้าที่ผู้อนุมัติ:</td>
                                    <td style="padding: 12px 0; vertical-align: top; border-bottom: 1px solid #eeeeee;">'.$_SESSION['username'].'</td>
                                </tr>
                            </table>

                            <p style="margin-top: 30px; margin-bottom: 15px; font-size: 16px;">ขอบคุณครับ/ค่ะ</p>
                            <p style="margin-bottom: 15px; font-size: 16px;">ระบบการจองอาคารสถานที่ SKJ</p>
                        </div>
                        <div class="button-container" style="text-align: center; padding: 20px 30px 30px;">
                            <a href="https://general.skj.ac.th/Booking/View/All" class="button" target="_blank" style="display: inline-block; background-color: #28a745; color: #ffffff; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 17px; transition: background-color 0.3s ease;">ตรวจสอบข้อมูลและอนุมัติ</a>
                        </div>
                        <div class="footer" style="text-align: center; padding: 20px; font-size: 13px; color: #999999; border-top: 1px solid #eeeeee; margin-top: 20px;">
                            <p style="margin: 0;">อีเมลนี้ถูกส่งโดยระบบอัตโนมัติ กรุณาอย่าตอบกลับ</p>
                            <p style="margin: 5px 0 0;">&copy; 2025 SKJ. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>';

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

    public function BookingNoApproveAdmin(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        if($_SESSION['status'] === "ExecutiveGeneral"){
            $NoApprove = ['booking_executive_approve'=>'ไม่อนุมัติ','booking_executive_reason'=>$this->request->getPost('booking_admin_reason'),'booking_executive_datecheck'=>date("Y-m-d H:i:s"),'booking_executive_check'=>$_SESSION['id']];
        }
        //elseif($_SESSION['status'] === "AdminGeneral"){
            $NoApprove = ['booking_admin_approve'=>'ไม่อนุมัติ','booking_admin_reason'=>$this->request->getPost('booking_admin_reason'),'booking_admin_datecheck'=>date("Y-m-d H:i:s"),'booking_admin_check'=>$_SESSION['id']];
        //}

        echo $DBbooking->where('booking_id',$this->request->getPost('BookingID'))->update($NoApprove);
    }

    public function BookingRequestform($IDBooking){
        $path = (dirname(dirname(dirname(dirname(dirname(__FILE__))))));
		require $path . '/librarie_skj/mpdf/vendor/autoload.php';
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');
        $DBAdminRloes = $database->table('tb_admin_rloes');
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $database->table('personnel'); 
        $DBSkj = \Config\Database::connect('skj');
        $DBposition = $DBSkj->table('tb_position');

        $DBbooking
        ->select('booking_order,booking_telephone,booking_number,booking_title,booking_locationroom,booking_Booker,booking_other ,booking_admin_approve,booking_equipment,booking_admin_reason,booking_id,location_name,booking_dateStart,booking_timeStart,booking_dateEnd,booking_timeEnd,booking_typeuse,pers_prefix,pers_firstname,pers_lastname,posi_name,DATEDIFF(booking_dateEnd,booking_dateStart) AS SUMDAY,lear_namethai');
        $DBbooking->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID');
        $DBbooking->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id");
        $DBbooking->join('skjacth_skj.tb_learning',"skjacth_skj.tb_learning.lear_id = skjacth_personnel.tb_personnel.pers_learning","left");
        $DBbooking->join('skjacth_skj.tb_position',"skjacth_personnel.tb_personnel.pers_position = skjacth_skj.tb_position.posi_id");
        $DBbooking->Where('booking_id',$IDBooking);
        $Booking =  $DBbooking->get()->getRow();

        

        $DeputyManege = $DBAdminRloes->select('pers_prefix,pers_firstname,pers_lastname')
        ->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id")
        ->where('admin_rloes_level','1/หัวหน้า')
        ->where('admin_rloes_nanetype',"งานอาคารสถานที่")
        ->get()->getRow();
       
        $DeputyExecutive = $DBAdminRloes->select('pers_prefix,pers_firstname,pers_lastname')
        ->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id","left")
        ->where('admin_rloes_nanetype',"รองผู้อำนวยการบริหารทั่วไป")->get()->getRow();

        $DeputyDirector = $DBAdminRloes->select('pers_prefix,pers_firstname,pers_lastname')
        ->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id","left")
        ->where('admin_rloes_nanetype',"ผู้อำนวยการโรงเรียน")->get()->getRow();
        //print_r($DeputyExecutive); exit();
       

        $mpdf = new \Mpdf\Mpdf(
            array(
                'format' => 'A4',
                'mode' => 'utf-8',
                'default_font' => 'thsarabun',
                'default_font_size' => 16
            )
        );
        $mpdf->SetTitle('แบบคำขอใช้อาคารสถานที่ ของ '.$Booking->pers_prefix.$Booking->pers_firstname.' '.$Booking->pers_lastname);

        $html = "<div style='text-align: center;font-size:24px;'><b>แบบคำขอใช้อาคารสถานที่</b></div>";
        $html .= "<div style='text-align: right; margin-top: 10px;'>เขียนที่ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</div>";
        $html .= "<div style='text-align: right; margin-right: 130px;'>".$Datethai->thai_date_fullmonth_ALL(strtotime($Booking->booking_dateStart))."</div>";
        $html .= "<div style='margin-top: 20px;'>เรียน ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</div>";
        $html .= "<div style='margin-top: 10px;text-indent: 50px;'>ข้าพเจ้า ".$Booking->pers_prefix.$Booking->pers_firstname.' '.$Booking->pers_lastname."   ตำแหน่ง ".$Booking->posi_name."  ฝ่าย/กลุ่มงาน/กลุ่มสาระการเรียนรู้ ".$Booking->lear_namethai."  เบอร์โทรศัพท์ที่สามารถติดต่อได้ ".$Booking->booking_telephone."</div>";
        $html .= "<div style='margin-top: 0px;'>มีความประสงค์ขอใช้อาคารสถานที่ของโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ดังต่อไปนี้</div>";
        $html .= "<div style='margin-top: 0px;text-indent: 20px;'><b>".$Booking->location_name."</b>  เพื่อ ".$Booking->booking_title."</div>";
        $html .= "<div style='margin-top: 0px;text-indent: 0px;'>กำหนดเวลา ".(($Booking->SUMDAY)+1)." วัน  ใน".$Datethai->thai_date_fullmonth_ALL(strtotime($Booking->booking_dateStart)). " ตั้งแต่เวลา ".date('H.i',strtotime($Booking->booking_timeStart))." น. ถึง ".$Datethai->thai_date_fullmonth_ALL(strtotime($Booking->booking_dateEnd))." เวลา ".date('H.i',strtotime($Booking->booking_timeEnd))." น. โดยมีบุคคลจะมาร่วมใช้อาคารสถานที่ประมาณ ".$Booking->booking_number." คน</div>";
       
        $html .= "<div style='margin-top: 0px;text-indent: 0px;'>วัสดุ/ครุภัณฑ์ที่ต้องการใช้</div>";

        $subEqui = explode("|",$Booking->booking_equipment);
        foreach ($subEqui as $key => $v_subEqui) {
           if($v_subEqui == "เครื่องคอมพิวเตอร์"){
            $CheckMarkCom = "<img src='uploads/admin/check-mark.png' style='width:20px;' />";
           }elseif($v_subEqui == "จอโปรเจ็คเตอร์"){
            $CheckMarkProject = "<img src='uploads/admin/check-mark.png' style='width:20px;' />";
           }elseif($v_subEqui == "เครื่องฉายแผ่นใส"){
            $CheckMarkVision= "<img src='uploads/admin/check-mark.png' style='width:20px;' />";
           }elseif($v_subEqui == "เครื่องขยายเสียง"){
            $CheckMarkAudio= "<img src='uploads/admin/check-mark.png' style='width:20px;' />";
           }

           if($Booking->booking_other != ""){
            $CheckMarkAOther= "<img src='uploads/admin/check-mark.png' style='width:20px;' />";
           }

        }

        $html .= "<div style='margin-top: 0px;text-indent: 50px;'>( ".@$CheckMarkAudio." ) เครื่องเสียง  ( ".@$CheckMarkProject." ) จอโปรเจคเตอร์  ( ".@$CheckMarkVision." ) เครื่องฉายแผ่นใส ( ".@$CheckMarkCom." ) เครื่องคอมพิวเตอร์</div>";      
        $html .= "<div style='margin-top: 0px;text-indent: 50px;'>( ".@$CheckMarkAOther." )  อื่นๆ  ".$Booking->booking_other."</div>";
        $html .= "<div style='margin-top: 0px;text-indent: 50px;'>โดยข้าพเจ้ายินดีจะปฏิบัติตามระเบียบการใช้สถานที่ดังกล่าวอย่างเคร่งครัดและจะรับผิดชอบต่อความเสียหาย ของทรัพย์สินทั้งหมดและระหว่างการปฏิบัติงาน และดูแลสถานที่ดังกล่าวให้อยู่สภาพเรียบร้อยทุกประการ</div>";

        $html .= "<div style='margin-top: 40px;text-align:right'>ลงชื่อ.......................................................ผู้ยื่นคำขอ</div>";
        $html .= "<div style='margin-top: 0px;margin-right: 60px;text-align:right'>(".$Booking->pers_prefix.$Booking->pers_firstname.' '.$Booking->pers_lastname.")</div>";

        $html .="
        <style>
        table, th, td {
            margin-top: 60px;
            width: 100%; /* ตารางกว้าง 100% */
            border: 1px solid black; /* เพิ่มเส้นขอบ */
            border-collapse: collapse; /* ให้เส้นขอบรวมกัน */;
            
        }
        th, td {
            padding: 10px; /* เพิ่มระยะห่างภายใน */
            text-align: center; /* จัดข้อความชิดซ้าย */
            font-size:1.7rem;
        }
        .center-text{
            text-align:center;
        }
        </style>
        <table>
            <tr> <!-- สร้างแถว -->
                <td>
                    ความเห็นของหัวหน้างานอาคารสถานที่ฯ
                    .............................................................................................. <br>
                    ..............................................................................................
                    <br>
                    <br>
                    <div class='center-text'>
                    ลงชื่อ...................................................... <br>
                    (".$DeputyManege->pers_prefix.$DeputyManege->pers_firstname.' '.$DeputyManege->pers_lastname.")
                    </div>

                </td>
                <td>
                    ความเห็นของรองผู้อำนวยการฝ่ายบริหารทั่วไป
                    .............................................................................................. <br>
                    ..............................................................................................
                    <br>
                    <br>
                    <div class='center-text'>
                    ลงชื่อ...................................................... <br>
                    (".$DeputyExecutive->pers_prefix.$DeputyExecutive->pers_firstname.' '.$DeputyExecutive->pers_lastname.")
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    ความเห็นของผู้อำนวยการสถานศึกษา  <br>
                    ............................................................................................................................................................................................ <br>
                    ............................................................................................................................................................................................
                    <br>
                    <br>
                    <div class='center-text'>
                    ลงชื่อ.............................................................ผู้อนุญาต<br>
                    (".$DeputyDirector->pers_prefix.$DeputyDirector->pers_firstname.' '.$DeputyDirector->pers_lastname.")<br>                   
	ผู้อำนวยการสถานศึกษา โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์

                    </div>
                </td>
            </tr>
        </table>
        ";

          // เพิ่ม HTML เข้าไปใน PDF
          $mpdf->WriteHTML($html);
 
          // สร้างไฟล์ PDF
          $this->response->setHeader('Content-Type', 'application/pdf');
 
          $mpdf->Output('example.pdf', 'I');
    }

    //--------- ลายเซ็น Admin ------------
    public function BookingSignatureAdminSave(){

        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $SignatureAdmin = $this->request->getPost('signature');
        $BookingID = $this->request->getPost('BookingID');

        if (!empty($SignatureAdmin) && !empty($BookingID)) {
            
            $data = array(
                'booking_admin_signature' => $SignatureAdmin
            );

            $DBbooking->where('booking_id',$BookingID)->update($data);

            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error']);
    }

    public function BookingSignatureAdminShow($IDBooking){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $SelSignature = $DBbooking->select('booking_admin_signature')->where('booking_id',$IDBooking)->get()->getRow();

        return $this->response->setJSON($SelSignature);

    }

    //--------- ลายเซ็นผู้บริหาร ------------
    public function BookingSignatureExecutiveSave(){

        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $SignatureExecutive = $this->request->getPost('signature');
        $BookingID = $this->request->getPost('BookingID');

        if (!empty($SignatureExecutive) && !empty($BookingID)) {
            
            $data = array(
                'booking_executive_signature' => $SignatureExecutive
            );

            $DBbooking->where('booking_id',$BookingID)->update($data);

            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error']);
    }

    public function BookingSignatureExecutiveShow($IDBooking){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $SelSignature = $DBbooking->select('booking_executive_signature')->where('booking_id',$IDBooking)->get()->getRow();

        return $this->response->setJSON($SelSignature);

    }


    // ----------------- สถิติ ---------------------

    public function BookingChart(){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $pie = $DBbooking->select('booking_locationroom, COUNT(*) as count,location_name')
                    ->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID')
                    ->groupBy('booking_locationroom')
                    ->get()->getResult();

                    $pieLabels = [];
                    $pieSeries = [];
                    foreach ($pie as $row) {
                        $pieLabels[] = $row->location_name;
                        $pieSeries[] = (int)$row->count;
                    }

         // ตัวอย่างข้อมูล Top ผู้ใช้งาน
        $bar = $DBbooking->select('booking_Booker, COUNT(*) as total,pers_prefix,pers_firstname,pers_lastname')
                ->join('skjacth_personnel.tb_personnel',"skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id")
                ->groupBy('booking_Booker')
                ->orderBy('total', 'DESC')
                ->limit(5)
                ->get()->getResult();
                $barLabels = [];
                $barSeries = [];
                foreach ($bar as $row) {
                    $barLabels[] = $row->pers_firstname;
                    $barSeries[] = (int)$row->total;
                }

                 // ตัวอย่างข้อมูล การอนุมัติ
            $PieApprove = $DBbooking->select('booking_admin_approve, COUNT(*) as total')                
                ->groupBy('booking_admin_approve')
                ->orderBy('total', 'DESC')
                ->get()->getResult();
                $ApproveLabels = [];
                $ApproveSeries = [];
                foreach ($PieApprove as $row) {
                    $ApproveLabels[] = $row->booking_admin_approve;
                    $ApproveSeries[] = (int)$row->total;
                }

        $data = [
            'pie' => ['labels' => $pieLabels, 'series' => $pieSeries],
            'bar' => ['categories' => $barLabels, 'series' => $barSeries],
            'Approve' => ['labels' => $ApproveLabels, 'series' => $ApproveSeries]
        ];
        return $this->response->setJSON($data);
    }


}