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

    function thaidate_to_mysql($dateStr) {
        $parts = explode('/', $dateStr);
        if (count($parts) === 3) {
            return ($parts[2] - 543) . '-' . str_pad($parts[1], 2, '0', STR_PAD_LEFT) . '-' . str_pad($parts[0], 2, '0', STR_PAD_LEFT);
        }
        return null;
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
        $DBSchoolCar = $database->table('tb_school_car');
        $DBCarReservation = $database->table('tb_car_reservation');
        $data['CountCarAll'] = $DBSchoolCar->countAll();
        $data['CountCarReservationAll'] = $DBCarReservation->countAll();

        $data['NumRowsWaitApprove'] = $DBCarReservation->where('car_reserv_status !=','อนุมัติ')->get()->getNumRows();
        $data['NumRowsApprove'] = $DBCarReservation->where('car_reserv_status','อนุมัติ')->get()->getNumRows();

        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingMain')
                .view('User/UserLeyout/UserFooter');
    }

    private function sendLineMessage($userId, $messageText)
    {
        $accessToken = 'sNlR5f0V6R5ymIr7KPd5Xp8orbv7moKfar4WUYQF2uOwLvIVJrl0QYkd6vdNArphKzH9Uu0kIeOyjIXOjYkAnXcLmdCR0zJeAOakv8LrwTjlqXi9i0nJrYe/9aBFQsSuvybozfMDE6Ao/C1kmaqDgAdB04t89/1O/w1cDnyilFU=';

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

    
    public function CarBookingCheckCar()
    {
        $data = $this->DataMain();
        $data['title']="เช็ครถก่อนทำการจอง";
        $data['description']="เช็ครถก่อนทำการจอง";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingCheck';
        $session = session();
      

        $database = \Config\Database::connect();
        $builder = $database->table('tb_school_car');
        $data['CheckCar'] = $builder->get()->getResult();
         //echo "<pre>";print_r($data['CheckCar']); exit();
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingCheck')
                .view('User/UserLeyout/UserFooter');
    }

    public function CarBookingDataTableView(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        $DBpers = \Config\Database::connect('personnel');
       $DBpersonnel = $DBpers->table('tb_personnel');

       $S_data = $DBCarReservation->select('
       skjacth_general.tb_car_reservation.*,
        skjacth_general.tb_school_car.car_img,
        skjacth_general.tb_school_car.car_registration,
        skjacth_general.tb_school_car.car_province,
        skjacth_general.tb_school_car.car_category,
        skjacth_personnel.tb_personnel.pers_prefix,
        skjacth_personnel.tb_personnel.pers_firstname,
        skjacth_personnel.tb_personnel.pers_lastname
       ')
       ->join('skjacth_general.tb_school_car','skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
       ->join('skjacth_personnel.tb_personnel',"skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID")
       ->get()->getResult();
       $data = array();
        foreach ($S_data as $key => $value) {
            $CheckDriver = $DBpersonnel->select('pers_prefix,pers_firstname,pers_lastname')->where('pers_id',$value->car_reserv_driver)->get()->getResult();
            if($value->car_reserv_driver){
                $Fullname = $CheckDriver[0]->pers_prefix.$CheckDriver[0]->pers_firstname.' '.$CheckDriver[0]->pers_lastname;
            }else{
                $Fullname = '';
            }

            $data[]=[
                'car_reserv_order' => $value->car_reserv_order,
                'car_reserv_carID' => $value->car_reserv_carID,
                'car_registration' => $value->car_registration,
                'car_reserv_driver' => $Fullname,
                'car_province' => $value->car_province,
                'car_category' => $value->car_category,
                'car_reserv_location' => $value->car_reserv_location,
                'car_reserv_detail' => $value->car_reserv_detail,
                'car_reserv_memberID' => $value->car_reserv_memberID,
                'car_reserv_status' => $value->car_reserv_status,
                'car_img' => $value->car_img,
                'Member' => $value->pers_prefix.$value->pers_firstname.' '.$value->pers_lastname,
                'Date' => $Datethai->thai_date_fullmonth(strtotime($value->car_reserv_StartDate)).':'.$value->car_reserv_StartTime.' ถึง '.$Datethai->thai_date_fullmonth(strtotime($value->car_reserv_EndDate)).' '.$value->car_reserv_EndTime
            ];        
        }
        $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
    } 


    public function CarBookingAdd($CarID = null)
    {
        $session = session();
        if(!$session->get('username')){
            header("Location:".base_url()); exit();
        } 
        $session = session();
        $data = $this->DataMain();
        $data['title']="จองห้อง / สถานที่";
        $data['description']="จองห้องสำหรับใช้ภายในโรงเรียน";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingAdd'; 
        $data['Datethai'] = new Datethai();      
      
        $database = \Config\Database::connect();
        $DBSchoolCar = $database->table('tb_school_car');
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $DBpers->table('tb_personnel');
        $data['SelPres'] = $DBpersonnel->where('pers_status','กำลังใช้งาน')
        ->orderBy('pers_position','ASC')
        ->get()->getResult();
        //echo '<pre>';print_r($SelPres); exit();
        $DBCarReservation = $database->table('tb_car_reservation');
        $myTime = Time::now('asia/bangkok', 'th_TH');

        $data['Car'] = $DBSchoolCar->where('car_ID',$CarID)->get()->getRow();
       
        $data['CarBookingNow'] = $DBCarReservation->orderBy('car_reserv_id','DESC')->get()->getRow();
       
        if(isset($data['CarBookingNow']->car_reserv_order) == ""){
            $data['car_reserv_order'] = "OrderCar_".date('Y')."0001";
        }else{
           $sub = explode('_',$data['CarBookingNow']->car_reserv_order);          
           $data['car_reserv_order'] = $sub[0]."_".(((int)$sub[1])+1);
        }
        
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingAdd')
                .view('User/UserLeyout/UserFooter');
    }

    public function CarBookingInsert(){

        $session = session();
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $DBpers->table('tb_personnel');
        $Datethai = new Datethai();
        
        $Car_dateStart = $this->thaidate_to_mysql($this->request->getVar('car_reserv_StartDate'));
        $Car_dateEnd = $this->thaidate_to_mysql($this->request->getVar('car_reserv_EndDate'));

        $data = [
            'car_reserv_order' => $this->request->getVar('car_reserv_order'),
            'car_reserv_memberID' => $this->request->getVar('car_reserv_memberID'),
            'car_reserv_location' => $this->request->getVar('car_reserv_location'),
            'car_reserv_detail' => $this->request->getVar('car_reserv_detail'),
            'car_reserv_number' => $this->request->getVar('car_reserv_number'),
            'car_reserv_StartDate' => $Car_dateStart,
            'car_reserv_StartTime' => $this->request->getVar('car_reserv_StartTime'),
            'car_reserv_EndDate' => $Car_dateEnd,
            'car_reserv_EndTime' => $this->request->getVar('car_reserv_EndTime'),
            'car_reserv_carID' => $this->request->getVar('car_reserv_carID'),
            'car_reserv_phone' => $this->request->getVar('car_reserv_phone'),            
            'car_reserv_status' => "รอตรวจสอบ" 
        ];
        //print_r($this->request->getVar('car_reserv_order'));exit();
      

        if($DBCarReservation->insert($data)){
            $DataNow = $database->insertID();            

            $Car = $DBCarReservation->select('
            skjacth_general.tb_school_car.car_registration,
            skjacth_general.tb_school_car.car_province,
            skjacth_general.tb_school_car.car_category,
            skjacth_general.tb_car_reservation.car_reserv_location,
            skjacth_general.tb_car_reservation.car_reserv_memberID,
            skjacth_general.tb_car_reservation.car_reserv_created_at,
            skjacth_general.tb_car_reservation.car_reserv_detail,
            skjacth_personnel.tb_personnel.pers_prefix,
            skjacth_personnel.tb_personnel.pers_firstname,
            skjacth_personnel.tb_personnel.pers_lastname,
            skjacth_general.tb_car_reservation.car_reserv_number,
            skjacth_general.tb_car_reservation.car_reserv_StartDate,
            skjacth_general.tb_car_reservation.car_reserv_StartTime,
            skjacth_general.tb_car_reservation.car_reserv_EndDate,
            skjacth_general.tb_car_reservation.car_reserv_EndTime
            ')
            ->join('skjacth_general.tb_school_car','skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
            ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID')
            ->where('tb_car_reservation.car_reserv_id', $DataNow)
            ->get()->getRowArray();


            // 2. สร้างข้อความ
            $msg = "📣 แจ้งเตือนการขอใช้รถราชการ\n";
            $msg .= "👤 ผู้ขอ: {$Car['pers_prefix']}{$Car['pers_firstname']} {$Car['pers_lastname']}\n";
            $msg .= "📅 วันที่ใช้: {$Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_StartDate']))} - {$Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_EndDate']))}\n";
            
            $msg .= "🚗 รถ: {$Car['car_category']} {$Car['car_registration']} {$Car['car_province']}\n";
            $msg .= "🎯 วัตถุประสงค์: {$Car['car_reserv_detail']}\n";
            $msg .= "👉 รับงาน: " . base_url("/CarBooking/Approve/Admin");

            // 3. ส่งข้อความ (ใช้ userId หรือ groupId ของช่าง)

            $this->sendLineMessage('C8d6e31d23796ce4a9d17c9ee7b419ec8', $msg);
            echo 1;
        }

        // if($Check){
           
        //     $email = \Config\Services::email(); // loading for use
           
        //     $email->setFrom('adminCarBooking@skj.ac.th',"ระบบการจองยานพาหนะ");
     
        //     // Send to Users     
        //     $email->setTo([
        //         "dekpiano@skj.ac.th"//,"panwad.r@skj.ac.th"
        //     ]);

        //     $email->setSubject("แจ้งการจองยานพาหนะ เลขที่ ".$this->request->getVar('car_reserv_order'));

        //     $html = "<a href='https://general.skj.ac.th/CarBooking/Approve/Admin' traget='_blank'>ตรวจสอบข้อมูลที่นี่</a>";
        //     $email->setMessage($html);

        //     // Send email
        //     if ($email->send()) {
        //         echo 1;
        //     } else {
        //         $data = $email->printDebugger(['headers']);
        //         print_r($data);
        //     }
        // }
        

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

    // --------------- ของแอดมิน อนุมัตื ApproveAdmin ---------------------------

    public function CarBookingDataTableApproveAdmin(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        $DBpers = \Config\Database::connect('personnel');
       $DBpersonnel = $DBpers->table('tb_personnel');

       $S_data = $DBCarReservation->select('
       skjacth_general.tb_car_reservation.*,
        skjacth_general.tb_school_car.car_img,
        skjacth_general.tb_school_car.car_registration,
        skjacth_general.tb_school_car.car_province,
        skjacth_general.tb_school_car.car_category,
        CONCAT(p1.pers_prefix, p1.pers_firstname, " ", p1.pers_lastname) AS carReservMemberID,
        CONCAT(p2.pers_prefix, p2.pers_firstname, " ", p2.pers_lastname) AS carReservDriver,
        CONCAT(p3.pers_prefix, p3.pers_firstname, " ", p3.pers_lastname) AS carReservApprover
       ')
       ->join('skjacth_general.tb_school_car','skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
       ->join('skjacth_personnel.tb_personnel AS p1', 'tb_car_reservation.car_reserv_memberID = p1.pers_id')
        ->join('skjacth_personnel.tb_personnel AS p2', 'tb_car_reservation.car_reserv_driver = p2.pers_id', 'left')
        ->join('skjacth_personnel.tb_personnel AS p3', 'tb_car_reservation.car_reserv_approver = p3.pers_id', 'left')

       ->get()->getResult();

       

       

       $data = array();
        foreach ($S_data as $key => $value) {

            // $CheckDriver = $DBpersonnel->select('pers_prefix,pers_firstname,pers_lastname')->where('pers_id',$value->car_reserv_driver)->get()->getResult();
            // if($value->car_reserv_driver){
            //     $Fullname = $CheckDriver[0]->pers_prefix.$CheckDriver[0]->pers_firstname.' '.$CheckDriver[0]->pers_lastname;
            // }else{
            //     $Fullname = '';
            // }

            $data[]=[
                'car_reserv_order' => $value->car_reserv_order,
                'car_reserv_carID' => $value->car_reserv_carID,
                'car_reserv_id' => $value->car_reserv_id,
                'car_registration' => $value->car_registration,
                'car_reserv_driver' =>  $value->carReservDriver,
                'car_province' => $value->car_province,
                'car_category' => $value->car_category,
                'car_reserv_location' => $value->car_reserv_location,
                'car_reserv_detail' => $value->car_reserv_detail,
                'car_reserv_memberID' => $value->car_reserv_memberID,
                'car_reserv_status' => $value->car_reserv_status,
                'car_img' => $value->car_img,
                'Member' => $value->carReservMemberID,
                'car_reserv_approver' => $value->carReservApprover,
                'Date' => $Datethai->thai_date_fullmonth(strtotime($value->car_reserv_StartDate)).':'.$value->car_reserv_StartTime.' ถึง '.$Datethai->thai_date_fullmonth(strtotime($value->car_reserv_EndDate)).' '.$value->car_reserv_EndTime
            ];        
        }
        $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
    } 

    // ---------- ขอ แอดมิน อนุมัตื --------------------

    public function CarBookingView(){

        $session = session();
        $data = $this->DataMain();
        $data['title']="ตารางการจองรถ";
        $data['description']="ดูตารางการจองรถ";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingView';     
        $data['Datethai'] = new Datethai();   

        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');

        $DBpersonnel = $database->table('personnel');

        //echo '<pre>';print_r($DBpersonnel); exit();

        $DBpers = \Config\Database::connect('personnel');


        $data['CarBooking'] =  $DBCarReservation->orderBy('car_reserv_id','DESC')->get()->getResult();
      
        //echo '<pre>';print_r($data['CarBooking']); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserCarBooking/UserCarBookingView')
                .view('User/UserLeyout/UserFooter');
    }

    public function CarBookingApproveAdmin(){
        $session = session();
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');

        $data = array(
            'car_reserv_driver' => $this->request->getVar('Driver'),
            'car_reserv_status' => 'อนุมัติ',
            'car_reserv_approver' => $_SESSION['id']
        );
        $DBCarReservation->where('car_reserv_id',$this->request->getVar('carbookingID'));
        echo $DBCarReservation->update($data);
    }

    public function CarBookingNoApproveAdmin(){
        $session = session();
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');

        $data = array(
            'car_reserv_driver' => "",
            'car_reserv_status' => 'ไม่อนุมัติ',
            'car_reserv_approver' => $_SESSION['id']
        );
        $DBCarReservation->where('car_reserv_id',$this->request->getVar('carbookingID'));
        echo $DBCarReservation->update($data);
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
        $DBCarReservation = $database->table('tb_car_reservation');

       $S_data = $DBCarReservation->select('
       tb_car_reservation.car_reserv_StartDate,
        tb_car_reservation.car_reserv_StartTime,
        tb_car_reservation.car_reserv_EndDate,
        tb_car_reservation.car_reserv_EndTime,
        tb_car_reservation.car_reserv_detail,
        tb_car_reservation.car_reserv_id,
        tb_car_reservation.car_reserv_location,
        tb_car_reservation.car_reserv_status,
        tb_car_reservation.car_reserv_carID,
        tb_school_car.car_registration,
        tb_school_car.car_province,
        tb_school_car.car_category
       ')
       ->join('tb_school_car','tb_school_car.car_ID = tb_car_reservation.car_reserv_carID')
    //    ->where('booking_admin_approve','อนุมัติ')
    //    ->where('booking_executive_approve','อนุมัติ')
       ->get()->getResult();

        foreach ($S_data as $key => $value) {
            switch ($value->car_reserv_status) {
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
                'id' => $value->car_reserv_id,
                'title'=> $value->car_category.' '.$value->car_registration.' '.$value->car_province.' ไปที่'.$value->car_reserv_location.' เพื่อ'.$value->car_reserv_detail,
                'start' => $value->car_reserv_StartDate.' '.$value->car_reserv_StartTime,
                'end' => date("Y-m-d", strtotime($value->car_reserv_EndDate)).' '.$value->car_reserv_EndTime,
                'approved' => $value->car_reserv_status
            ];        
        }

        return $this->response->setJSON($data, true);
    }

    // ------------------เช็ควันที่ แปลงวันที่ -------------------
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

    public function CheckDateCarBooking(){
        // print_r($this->request->getVar());
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_car_reservation');
        $CarID              = $this->request->getPost('car_reserv_carID');
        $dateStart          = $this->request->getPost('car_reserv_StartDate');
        $timeStart          = $this->request->getPost('car_reserv_StartTime');
        $dateEnd            = $this->request->getPost('car_reserv_EndDate');
        $timeEnd            = $this->request->getPost('car_reserv_EndTime');

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

        $CheckDateCarBookign = $DBbooking
        ->where('car_reserv_carID', $CarID)
        ->where("STR_TO_DATE(CONCAT(car_reserv_StartDate, ' ', car_reserv_StartTime), '%Y-%m-%d %H:%i:%s') < '$proposedEnd'", null, false)
        ->where("STR_TO_DATE(CONCAT(car_reserv_EndDate, ' ', car_reserv_EndTime), '%Y-%m-%d %H:%i:%s') > '$proposedStart'", null, false)
        ->get()->getResult();
        //print_r($CheckDateBookign);
        if(!$CheckDateCarBookign){
            return $this->response->setJSON([
                'status' => 1,
                'message' => '✔️สามารถทำการจองวันและเวลาที่เลือกได้',
                'class' => 'alert alert-success'
            ]);
        }else{
            return $this->response->setJSON([
                'status' => 0,
                'message' => '❌ มีการจองในช่วงเวลานี้แล้ว กรุณาเลือกวันและเวลาที่ว่าง หรือเลือกยานพาหนะอื่น',
                'class' => 'alert alert-danger'
            ]);
        }
       
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
        $data['title']="ดูข้อมูลจองรถ (Admin)";
        $data['description']="ดูข้อมูลจองรถ (Admin)";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingView';     
        $data['Datethai'] = new Datethai();   

        $database = \Config\Database::connect();
        $DBCarDriver= $database->table('tb_car_driver');
        $DBpersonnel = $database->table('personnel');
        $DBpers = \Config\Database::connect('personnel');

       
        $data['CarDriver'] =  $DBCarDriver->select('
            skjacth_general.tb_car_driver.cardriver_id,
            skjacth_personnel.tb_personnel.pers_prefix,
            skjacth_personnel.tb_personnel.pers_firstname,
            skjacth_personnel.tb_personnel.pers_lastname,
            skjacth_personnel.tb_personnel.pers_phone,
            skjacth_personnel.tb_personnel.pers_img,
            skjacth_personnel.tb_personnel.pers_id
        ')
        ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_driver.cardriver_userID')
        ->get()->getResult();
      
       //echo '<pre>';print_r($data['CarDriver']); exit();
        
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

  

    public function CarBookingDataTableApproveExecutive(){
        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

       $S_data = $DBbooking->select('booking_id,booking_order,booking_telephone,booking_Booker,booking_locationroom,booking_title,booking_dateStart,booking_dateEnd,booking_timeStart,booking_timeEnd,booking_admin_approve,booking_admin_reason,location_name,pers_prefix,pers_firstname,pers_lastname,booking_executive_approve,booking_executive_reason')
       ->join('tb_school_car','tb_booking.booking_locationroom = tb_school_car.location_ID')
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

    public function PrintApproveCarBooking($KeyCarBooking){

        $session = session();
        $Datethai = new Datethai();  
        $database = \Config\Database::connect();
        $DBCarBooking = $database->table('tb_car_reservation');
        $DBAdminRloe = $database->table('tb_admin_rloes');
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $DBpers->table('tb_personnel');
        $DBskj = \Config\Database::connect('skj');
        $DBposition = $DBpers->table('tb_position');
        //print_r($DBposition);exit();

        $ViewCarBooking = $DBCarBooking->select("     
        CONCAT(driver.pers_prefix,driver.pers_firstname,' ',driver.pers_lastname) AS DriverName,
        driverPosi.posi_name AS DriverPosi,
        CONCAT(booker.pers_prefix,booker.pers_firstname,' ',booker.pers_lastname) AS BookerName,
        bookerPosi.posi_name AS BookerPosi,
        CONCAT(approver.pers_prefix,approver.pers_firstname,' ',approver.pers_lastname) AS ApproverName,
        approverPosi.posi_name AS ApproverPosi,
        skjacth_general.tb_car_reservation.*,
        skjacth_general.tb_school_car.car_registration,
        skjacth_general.tb_school_car.car_province,
        skjacth_general.tb_school_car.car_category,
        skjacth_general.tb_school_car.car_brand,
        skjacth_general.tb_school_car.car_model
        ")
        ->join('skjacth_personnel.tb_personnel AS driver','driver.pers_id = skjacth_general.tb_car_reservation.car_reserv_driver')
        ->join('skjacth_personnel.tb_personnel AS booker','booker.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID')
        ->join('skjacth_personnel.tb_personnel AS approver','approver.pers_id = skjacth_general.tb_car_reservation.car_reserv_approver')
        ->join('skjacth_general.tb_school_car','skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
        ->join('skjacth_skj.tb_position AS driverPosi','driverPosi.posi_id = driver.pers_position')
        ->join('skjacth_skj.tb_position AS bookerPosi','bookerPosi.posi_id = booker.pers_position')
        ->join('skjacth_skj.tb_position AS approverPosi','approverPosi.posi_id = approver.pers_position')
        ->where('skjacth_general.tb_car_reservation.car_reserv_id',$KeyCarBooking)
        ->get()->getRow();

       
        $ExecutiveGeneral = $DBAdminRloe->select('
        CONCAT(skjacth_personnel.tb_personnel.pers_prefix,skjacth_personnel.tb_personnel.pers_firstname," ",skjacth_personnel.tb_personnel.pers_lastname) AS ExecutiveName,
        skjacth_skj.tb_position.posi_name,
        skjacth_personnel.tb_personnel.pers_academic
        ')
        ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_admin_rloes.admin_rloes_userid')
        ->join('skjacth_skj.tb_position','skjacth_skj.tb_position.posi_id = skjacth_personnel.tb_personnel.pers_position')
        ->where('admin_rloes_nanetype','หัวหน้าบริหารทั่วไป')
        ->get()->getRow();

        $DeputyDirectorGeneral = $DBAdminRloe->select('
        CONCAT(skjacth_personnel.tb_personnel.pers_prefix,skjacth_personnel.tb_personnel.pers_firstname," ",skjacth_personnel.tb_personnel.pers_lastname) AS ExecutiveName,
        skjacth_skj.tb_position.posi_name,
        skjacth_personnel.tb_personnel.pers_academic
        ')
        ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_admin_rloes.admin_rloes_userid')
        ->join('skjacth_skj.tb_position','skjacth_skj.tb_position.posi_id = skjacth_personnel.tb_personnel.pers_position')
        ->where('admin_rloes_nanetype','รองผู้อำนวยการบริหารทั่วไป')
        ->get()->getRow();

        $DeputyDirector = $DBAdminRloe->select('
        CONCAT(skjacth_personnel.tb_personnel.pers_prefix,skjacth_personnel.tb_personnel.pers_firstname," ",skjacth_personnel.tb_personnel.pers_lastname) AS ExecutiveName,
        skjacth_skj.tb_position.posi_name,
        skjacth_personnel.tb_personnel.pers_academic
        ')
        ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_admin_rloes.admin_rloes_userid')
        ->join('skjacth_skj.tb_position','skjacth_skj.tb_position.posi_id = skjacth_personnel.tb_personnel.pers_position')
        ->where('admin_rloes_nanetype','ผู้อำนวยการโรงเรียน')
        ->get()->getRow();
        //echo '<pre>';print_r($DeputyDirectorGeneral);exit();

        $path = (dirname(dirname(dirname(dirname(dirname(__FILE__))))));
		require $path . '/librarie_skj/mpdf/vendor/autoload.php';
        $session = session();
        $mpdf = new \Mpdf\Mpdf(
            array(
                'format' => 'A4',
                'mode' => 'utf-8',
                'default_font' => 'thsarabun',
                'default_font_size' => 16
            )
        );
        
        $mpdf->SetTitle('แบบคำขอใช้อาคารสถานที่ ของ ');

        $html = '
        <style>
        @page {
            margin-top: 10mm;  /* ระยะห่างจากขอบบน */
            margin-bottom: 10mm; /* ระยะห่างจากขอบล่าง */
        }
            </style>
        <h3 style="text-align: center;margin-top:-20px">ใบขออนุญาตใช้รถส่วนกลาง</h3>

            <div style="margin-left:18rem;">องค์การบริหารส่วนจังหวัดนครสวรรค์</div>
            <div style="margin-left:18rem;">'.$Datethai->thai_date_fullmonth_ALL(strtotime($ViewCarBooking->car_reserv_created_at)).'</div>
         

            <div style="margin-top:-5px">เรียน: ผู้อำนวยการสถานศึกษา โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</div>
            <div style="margin-left:3rem;">ข้าพเจ้า '.$ViewCarBooking->BookerName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ตำแหน่ง '.$ViewCarBooking->BookerPosi.'</div>

            <div>ขออนุญาตใช้รถยนต์ส่วนกลางไปที่ '.$ViewCarBooking->car_reserv_location.'</div>
            <div>เพื่อปฏิบัติงานเรื่อง  '.$ViewCarBooking->car_reserv_detail.'</div>

            <div> จำนวนผู้ไปปฏิบัติงาน '.$ViewCarBooking->car_reserv_number.' คน </div>
            <div>ออกเดินทางใน'.$Datethai->thai_date_fullmonth_ALL(strtotime($ViewCarBooking->car_reserv_StartDate)).' เวลา '.date('H:i',strtotime($ViewCarBooking->car_reserv_StartTime)).' น. ถึง'.$Datethai->thai_date_fullmonth_ALL(strtotime($ViewCarBooking->car_reserv_EndDate)).' เวลา '.date('H:i',strtotime($ViewCarBooking->car_reserv_EndTime)).' น. </div>
          
            <div style="margin-left:18rem;margin-top:10px;">
                <div style="text-align:center;">
                    <div>(ลงชื่อ) ............................................ ผู้ขออนุญาต</div>
                    <div style="margin-left:0px;">('.$ViewCarBooking->BookerName.')</div>
                    <div >ตำแหน่ง '.$ViewCarBooking->BookerPosi.'</div>
                </div>            
            </div>

            <div style="position: absolute;">
                <div style="text-align:left;">
                    <div style="text-align:center;">(ลงชื่อ) ............................................ หัวหน้าฝ่ายบริหารทั่วไป</div>
                    <div style="margin-left:28px;">('.$ExecutiveGeneral->ExecutiveName.')</div>
                    <div style="margin-left:40px;">ตำแหน่ง '.$ExecutiveGeneral->posi_name.' '.$ExecutiveGeneral->pers_academic.'</div>
                </div>            
            </div>

            <div style="margin-top:5rem;">
                <div>(ลงชื่อ) ............................................ หัวหน้าส่วนราชการประจำหน่วยการบริหารราชการส่วนท้องถิ่น/หรือผู้แทน</div>
                <div style="margin-left:28px;">('.$DeputyDirectorGeneral->ExecutiveName.')</div>
                <div style="margin-left:0px;">ตำแหน่ง '.$DeputyDirectorGeneral->posi_name.' '.$DeputyDirectorGeneral->pers_academic.'</div>
            </div>

            <div style="margin-top:1rem;">
                <div>สมควรจ่ายรถยนต์ ยี่ห้อ '.$ViewCarBooking->car_brand.' หมายเลขทะเบียน  '.$ViewCarBooking->car_registration.' '.$ViewCarBooking->car_province.' โดยให้ '.$ViewCarBooking->DriverName.' เป็นผู้รับ </div>
            </div>
           
            <div style="margin-left:17rem;margin-top:10px;">
                <div style="text-align:center;">
                    <div>(ลงชื่อ) ............................................ พนักงานขับรถยนต์</div>
                    <div style="margin-left:-30px;">('.$ViewCarBooking->DriverName.')</div>
                    <div style="margin-left:-30px;">ตำแหน่ง '.$ViewCarBooking->DriverPosi.'</div>
                </div>            
            </div>

            <div style="margin-left:17rem;margin-top:40px;">
                <div style="text-align:center;">
                    <div>(ลงชื่อ) ............................................ ผู้อนุญาต</div>
                    <div style="margin-left:-20px;">('.$DeputyDirector->ExecutiveName.')</div>
                    <div style="margin-left:-30px; font-size:17px;">
                    ผู้อำนวยการสถานศึกษา โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
                    </div>
                </div>            
            </div>

            <div style="margin-top:20px;"> 
            เล่มที่.......... เลขที่.......... ลงวันที่...........................
            </div>
    
        ';

        // เพิ่ม HTML เข้าไปใน PDF
        $mpdf->WriteHTML($html);

        // สร้างไฟล์ PDF
        $this->response->setHeader('Content-Type', 'application/pdf');

        $mpdf->Output('example.pdf', 'I');
    }


    public function BookingCarChart(){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_car_reservation');

        $pie = $DBbooking->select('car_reserv_carID, COUNT(*) as count,car_registration,car_category')
                    ->join('tb_school_car','tb_school_car.car_ID = tb_car_reservation.car_reserv_carID')
                    ->groupBy('car_reserv_carID')
                    ->get()->getResult();

                    $pieLabels = [];
                    $pieSeries = [];
                    foreach ($pie as $row) {
                        $pieLabels[] = $row->car_registration.' '.$row->car_category;
                        $pieSeries[] = (int)$row->count;
                    }

         // ตัวอย่างข้อมูล Top ผู้ใช้งาน
        $bar = $DBbooking->select('car_reserv_memberID, COUNT(*) as total,pers_prefix,pers_firstname,pers_lastname')
                ->join('skjacth_personnel.tb_personnel','tb_car_reservation.car_reserv_memberID = skjacth_personnel.tb_personnel.pers_id')
                ->groupBy('car_reserv_memberID')
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
            $PieApprove = $DBbooking->select('car_reserv_status, COUNT(*) as total')                
            ->groupBy('car_reserv_status')
            ->orderBy('total', 'DESC')
            ->get()->getResult();
            $ApproveLabels = [];
            $ApproveSeries = [];
            foreach ($PieApprove as $row) {
                $ApproveLabels[] = $row->car_reserv_status;
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