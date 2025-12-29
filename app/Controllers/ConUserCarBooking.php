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
        $data['title']="ระบบจองยานพาหนะ";
        $data['description']="ระบบสำหรับจองยานพาหนะภายในโรงเรียน";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingMain';

        $database = \Config\Database::connect();
        $DBSchoolCar = $database->table('tb_school_car');
        $DBCarReservation = $database->table('tb_car_reservation');
        $data['CountCarAll'] = $DBSchoolCar->countAll();
        $data['CountCarReservationAll'] = $DBCarReservation->where('car_reserv_memberID', $session->get('id'))->countAllResults();

        $data['NumRowsWaitApprove'] = $DBCarReservation->where('car_reserv_status','รอตรวจสอบ')->countAllResults();
        $data['NumRowsApprove'] = $DBCarReservation->where('car_reserv_status','อนุมัติ')->countAllResults();

        // Fetch Car List for Mini Calendars
        $data['CarList'] = $DBSchoolCar->get()->getResult();

        return view('User/UserCarBooking/UserCarBookingMain', $data);
    }

    private function sendLineMessage($userId, $messageText)
    {
        if (ENVIRONMENT !== 'production') {
            return null;
        }
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
        return view('User/UserCarBooking/UserCarBookingCheck', $data);
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
       ->orderBy('car_reserv_id', 'DESC')
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
        
        
        return view('User/UserCarBooking/UserCarBookingAdd', $data);
    }

    public function CarBookingInsert(){

        $session = session();
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $DBpers->table('tb_personnel');
        $Datethai = new Datethai();

        $order = $this->request->getVar('car_reserv_order');
        $memberID = $this->request->getVar('car_reserv_memberID');
        $carID = $this->request->getVar('car_reserv_carID');
        $startDate = $this->request->getVar('car_reserv_StartDate');
        $endDate = $this->request->getVar('car_reserv_EndDate');

        // Validation: Check if critical fields are present
        if(empty($order) || empty($memberID) || empty($carID) || empty($startDate) || empty($endDate)){
            echo 0; // Return 0 (Error) if data is missing
            return;
        }
        
        $Car_dateStart = $this->thaidate_to_mysql($startDate);
        $Car_dateEnd = $this->thaidate_to_mysql($endDate);

        // Check Overlap
        $proposedStart = date('Y-m-d H:i:s',strtotime($Car_dateStart . ' ' . $this->request->getVar('car_reserv_StartTime')));
        $proposedEnd   = date('Y-m-d H:i:s',strtotime($Car_dateEnd   . ' ' . $this->request->getVar('car_reserv_EndTime')));
        
        $isOverlap = $DBCarReservation
            ->where('car_reserv_carID', $carID)
            ->where("TIMESTAMP(car_reserv_StartDate, car_reserv_StartTime) < '$proposedEnd'", null, false)
            ->where("TIMESTAMP(car_reserv_EndDate, car_reserv_EndTime) > '$proposedStart'", null, false)
            ->where('car_reserv_status !=', 'ไม่อนุมัติ')
            ->countAllResults();
            
        if($isOverlap > 0){
             echo 0;
             return;
        }

        $data = [
            'car_reserv_order' => $order,
            'car_reserv_memberID' => $memberID,
            'car_reserv_location' => $this->request->getVar('car_reserv_location'),
            'car_reserv_detail' => $this->request->getVar('car_reserv_detail'),
            'car_reserv_number' => $this->request->getVar('car_reserv_number'),
            'car_reserv_StartDate' => $Car_dateStart,
            'car_reserv_StartTime' => $this->request->getVar('car_reserv_StartTime'),
            'car_reserv_EndDate' => $Car_dateEnd,
            'car_reserv_EndTime' => $this->request->getVar('car_reserv_EndTime'),
            'car_reserv_carID' => $carID,
            'car_reserv_phone' => $this->request->getVar('car_reserv_phone'),            
            'car_reserv_status' => "รอตรวจสอบ" 
        ];
      

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
            skjacth_general.tb_car_reservation.car_reserv_EndTime,
            skjacth_personnel.tb_personnel.pers_username
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

            // 3. ส่งข้อความ
            if (ENVIRONMENT === 'production' && !in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1'])) {
                $this->sendLineMessage('C8d6e31d23796ce4a9d17c9ee7b419ec8', $msg);
                
                // Send Email to Booker
                $email = \Config\Services::email(); 
                $email->setFrom($_SESSION['email'], "ระบบจองยานพาหนะ SKJ");
                $email->setTo($Car['pers_username']);
                $email->setSubject("แจ้งการจองยานพาหนะ: รอการตรวจสอบ");
                
                $html = "
                <div style='font-family: sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
                    <h2 style='color: #ffab00;'>⏳ ได้รับคำขอจองยานพาหนะแล้ว</h2>
                    <p>เรียน {$Car['pers_prefix']}{$Car['pers_firstname']} {$Car['pers_lastname']}</p>
                    <p>ระบบได้รับข้อมูลการจองของท่านแล้ว อยู่ระหว่างรอการตรวจสอบจากเจ้าหน้าที่</p>
                    <hr>
                    <p><strong>รายละเอียด:</strong></p>
                    <ul>
                        <li><strong>เลขที่:</strong> {$Car['car_reserv_order']}</li>
                        <li><strong>รถ:</strong> {$Car['car_category']} {$Car['car_registration']}</li>
                        <li><strong>วันที่:</strong> {$Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_StartDate']))} - {$Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_EndDate']))}</li>
                        <li><strong>วัตถุประสงค์:</strong> {$Car['car_reserv_detail']}</li>
                    </ul>
                    <p><a href='".base_url("CarBooking/View")."'>ตรวจสอบสถานะการจอง</a></p>
                </div>";
                
                $email->setMessage($html);
                $email->send();
            }
            echo 1;
        }

    }

    public function CarBookingEdit($id = null)
    {
        $session = session();
        if(!$session->get('username')){
            return redirect()->to(base_url('LoginOfficerGeneral?return_to='.urlencode(current_url())));
        }

        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        $booking = $DBCarReservation->where('car_reserv_id', $id)->get()->getRow();

        if (!$booking) {
            return redirect()->to(base_url('CarBooking'))->with('error', 'ไม่พบข้อมูลการจอง');
        }

        // Permission Check
        $currentUserId = $session->get('id');
        $userStatus = $session->get('status');
        $userRoles = $session->get('rloes') ? explode(',', $session->get('rloes')) : [];
        
        $isPrivileged = in_array($userStatus, ['admin', 'manager', 'ExecutiveGeneral', 'AdminGeneral']) 
                        || in_array('งานยานพาหนะ', $userRoles);
        
        if ($booking->car_reserv_memberID != $currentUserId && !$isPrivileged) {
            echo "
            <script>
                alert('คุณไม่มีสิทธิ์แก้ไขข้อมูลการจองนี้ เฉพาะผู้จองหรือผู้ดูแลระบบเท่านั้น');
                window.location.href = '".base_url('CarBooking')."';
            </script>
            ";
            exit();
        }

        // Block editing if Approved (for non-admins)
        if ($booking->car_reserv_status == 'อนุมัติ' && !$isPrivileged) {
             echo "
            <script>
                alert('รายการนี้ได้รับการอนุมัติแล้ว ไม่สามารถแก้ไขได้ กรุณาติดต่อเจ้าหน้าที่');
                window.location.href = '".base_url('CarBooking')."';
            </script>
            ";
            exit();
        }

        $data = $this->DataMain();
        $data['title'] = "แก้ไขการจองยานพาหนะ";
        $data['description'] = "แก้ไขข้อมูลการจองยานพาหนะ";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingEdit';
        $data['Datethai'] = new Datethai();

        $DBSchoolCar = $database->table('tb_school_car');
        $data['CarList'] = $DBSchoolCar->get()->getResult(); // List of cars for dropdown if needed

        // Fetch Personnel for Dropdown (SelPres)
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $DBpers->table('tb_personnel');
        $data['SelPres'] = $DBpersonnel->where('pers_status','กำลังใช้งาน')
        ->orderBy('pers_position','ASC')
        ->get()->getResult();

        $data['Booking'] = $booking;
        
        // Pass info about the booked car specifically
        $data['Car'] = $DBSchoolCar->where('car_ID', $booking->car_reserv_carID)->get()->getRow();

        return view('User/UserCarBooking/UserCarBookingEdit', $data);
    }
    
    public function CarBookingUpdate(){

        $session = session();
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        
        $id = $this->request->getVar('car_reserv_id');
        if(!$id){
            return $this->response->setJSON(['status'=>'error', 'message'=>'ไม่พบ ID การจอง']);
        }
        
        $Car_dateStart = $this->thaidate_to_mysql($this->request->getVar('car_reserv_StartDate'));
        $Car_dateEnd = $this->thaidate_to_mysql($this->request->getVar('car_reserv_EndDate'));

        $data = [
            'car_reserv_carID' => $this->request->getVar('car_reserv_carID'),
            // 'car_reserv_order' => $this->request->getVar('car_reserv_order'), // Don't update order
            'car_reserv_memberID' => $this->request->getVar('car_reserv_memberID'),
            'car_reserv_location' => $this->request->getVar('car_reserv_location'),
            'car_reserv_detail' => $this->request->getVar('car_reserv_detail'),
            'car_reserv_number' => $this->request->getVar('car_reserv_number'),
            'car_reserv_StartDate' => $Car_dateStart,
            'car_reserv_StartTime' => $this->request->getVar('car_reserv_StartTime'),
            'car_reserv_EndDate' => $Car_dateEnd,
            'car_reserv_EndTime' => $this->request->getVar('car_reserv_EndTime'),
            'car_reserv_phone' => $this->request->getVar('car_reserv_phone'),
            'car_reserv_status' => "รอตรวจสอบ" 
        ];

        $DBCarReservation->where('car_reserv_id', $id);
        if($DBCarReservation->update($data)){
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'แก้ไขข้อมูลการจองเรียบร้อยแล้ว',
                'car_id' => $this->request->getVar('car_reserv_carID')
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล'
            ]);
        }
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
       ->orderBy('car_reserv_id', 'DESC')
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
        $data['title']="ตารางการจองยานพาหนะ";
        $data['description']="ดูตารางการจองยานพาหนะ";
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
        
        return view('User/UserCarBooking/UserCarBookingView', $data);
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
        if($DBCarReservation->update($data)){
             $Car = $DBCarReservation->select('
                skjacth_general.tb_school_car.car_registration,
                skjacth_general.tb_school_car.car_province,
                skjacth_general.tb_school_car.car_category,
                skjacth_general.tb_car_reservation.car_reserv_location,
                skjacth_general.tb_car_reservation.car_reserv_detail,
                skjacth_general.tb_car_reservation.car_reserv_StartDate,
                skjacth_general.tb_car_reservation.car_reserv_EndDate,
                skjacth_general.tb_car_reservation.car_reserv_order,
                skjacth_personnel.tb_personnel.pers_prefix,
                skjacth_personnel.tb_personnel.pers_firstname,
                skjacth_personnel.tb_personnel.pers_firstname,
                skjacth_personnel.tb_personnel.pers_lastname,
                skjacth_personnel.tb_personnel.pers_username
            ')
            ->join('skjacth_general.tb_school_car','skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
            ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID')
            ->where('tb_car_reservation.car_reserv_id', $this->request->getVar('carbookingID'))
            ->get()->getRowArray();

            if($Car){
                 $Datethai = new Datethai();
                 $msg = "✅ การจองยานพาหนะได้รับการอนุมัติแล้ว!\n";
                 $msg .= "เลขที่จอง: {$Car['car_reserv_order']}\n";
                 $msg .= "ผู้ขอ: {$Car['pers_prefix']}{$Car['pers_firstname']} {$Car['pers_lastname']}\n";
                 $msg .= "🚗 รถ: {$Car['car_category']} {$Car['car_registration']} {$Car['car_province']}\n";
                 $msg .= "📅 วันที่: {$Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_StartDate']))} - {$Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_EndDate']))}\n";
                 $msg .= "อนุมัติโดย: {$_SESSION['username']}\n";
                 $msg .= "ตรวจสอบสถานะ: " . base_url("CarBooking/View");

                if (ENVIRONMENT === 'production' && !in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1'])) {
                    $this->sendLineMessage('C8d6e31d23796ce4a9d17c9ee7b419ec8', $msg);

                    // Send Email to Booker (Approved)
                    $email = \Config\Services::email(); 
                    $email->setFrom($_SESSION['email'], "ระบบจองยานพาหนะ SKJ");
                    $email->setTo($Car['pers_username']);
                    $email->setSubject("ผลการจองยานพาหนะ: อนุมัติ");
                    
                    $html = "
                    <div style='font-family: sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 5px; border-top: 5px solid #71dd37;'>
                        <h2 style='color: #71dd37;'>✅ การจองของคุณได้รับการอนุมัติ</h2>
                        <p>เรียน {$Car['pers_prefix']}{$Car['pers_firstname']} {$Car['pers_lastname']}</p>
                        <p>เจ้าหน้าที่ได้ทำการอนุมัติรายการจองยานพาหนะของท่านเรียบร้อยแล้ว</p>
                        <hr>
                        <p><strong>รายละเอียด:</strong></p>
                        <ul>
                            <li><strong>เลขที่:</strong> {$Car['car_reserv_order']}</li>
                            <li><strong>รถ:</strong> {$Car['car_category']} {$Car['car_registration']}</li>
                            <li><strong>วันที่:</strong> {$Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_StartDate']))} - {$Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_EndDate']))}</li>
                        </ul>
                    </div>";
                    
                    $email->setMessage($html);
                    $email->send();
                }
            }
            echo 1;
        } else {
            echo 0;
        }
    }

    public function CarBookingNoApproveAdmin(){
        $session = session();
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        $Datethai = new Datethai();

        $data = array(
            'car_reserv_driver' => "",
            'car_reserv_status' => 'ไม่อนุมัติ',
            'car_reserv_approver' => $_SESSION['id']
        );
        $DBCarReservation->where('car_reserv_id',$this->request->getVar('carbookingID'));
        if($DBCarReservation->update($data)){
            
            // Fetch for Email
             $Car = $DBCarReservation->select('
                skjacth_general.tb_school_car.car_registration,
                skjacth_general.tb_school_car.car_category,
                skjacth_general.tb_car_reservation.car_reserv_location,
                skjacth_general.tb_car_reservation.car_reserv_detail,
                skjacth_general.tb_car_reservation.car_reserv_StartDate,
                skjacth_general.tb_car_reservation.car_reserv_EndDate,
                skjacth_general.tb_car_reservation.car_reserv_order,
                skjacth_personnel.tb_personnel.pers_prefix,
                skjacth_personnel.tb_personnel.pers_firstname,
                skjacth_personnel.tb_personnel.pers_lastname,
                skjacth_personnel.tb_personnel.pers_username
            ')
            ->join('skjacth_general.tb_school_car','skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
            ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID')
            ->where('tb_car_reservation.car_reserv_id', $this->request->getVar('carbookingID'))
            ->get()->getRowArray();

             if($Car){
                if (ENVIRONMENT === 'production' && !in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1'])) {
                    $email = \Config\Services::email();
                    $email->setFrom($_SESSION['email'], "ระบบจองยานพาหนะ SKJ");
                    $email->setTo($Car['pers_username']);
                    $email->setSubject("ผลการจองยานพาหนะ: ไม่อนุมัติ");
                    
                    $html = "
                    <div style='font-family: sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 5px; border-top: 5px solid #ff3e1d;'>
                        <h2 style='color: #ff3e1d;'>❌ การจองของคุณไม่ผ่านการอนุมัติ</h2>
                        <p>เรียน {$Car['pers_prefix']}{$Car['pers_firstname']} {$Car['pers_lastname']}</p>
                        <p>รายการจองยานพาหนะของท่านไม่ได้รับการอนุมัติ</p>
                        <hr>
                        <p><strong>รายละเอียด:</strong></p>
                        <ul>
                            <li><strong>เลขที่:</strong> {$Car['car_reserv_order']}</li>
                            <li><strong>รถ:</strong> {$Car['car_category']} {$Car['car_registration']}</li>
                            <li><strong>วันที่:</strong> {$Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_StartDate']))} - {$Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_EndDate']))}</li>
                        </ul>
                        <p>กรุณาติดต่อเจ้าหน้าที่เพื่อสอบถามรายละเอียดเพิ่มเติม</p>
                    </div>";
                    
                    $email->setMessage($html);
                    $email->send();
                }
            }

            echo 1;
        } else {
            echo 0;
        }
    }

    public function CarBookingResetStatus(){
        $session = session();
        if(!$session->get('username')){
            echo 0; return;
        }

        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        
        $data = array(
            'car_reserv_driver' => "",
            'car_reserv_status' => 'รอตรวจสอบ',
            'car_reserv_approver' => ""
        );
        
        $DBCarReservation->where('car_reserv_id', $this->request->getVar('carbookingID'));
        if($DBCarReservation->update($data)){
            echo 1;
        } else {
            echo 0;
        }
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
        skjacth_general.tb_car_reservation.*,
        car.car_registration,
        car.car_province,
        car.car_category,
        p.pers_prefix,
        p.pers_firstname,
        p.pers_lastname
       ')
       ->join('skjacth_general.tb_school_car as car','car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
       ->join('skjacth_personnel.tb_personnel as p','p.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID', 'left')
       ->where('car_reserv_status !=', 'ไม่อนุมัติ')
       ->get()->getResult();

        $data = array();
        foreach ($S_data as $key => $value) {
            $start = $value->car_reserv_StartDate.' '.$value->car_reserv_StartTime;
            $end = $value->car_reserv_EndDate.' '.$value->car_reserv_EndTime;

             $data[]=[
                'id' => $value->car_reserv_id,
                // Title for calendar view (short)
                'title'=> $value->car_reserv_location, 
                'start' => $start,
                'end' => $end,
                'approved' => $value->car_reserv_status,
                'car_id' => $value->car_reserv_carID,
                'member_id' => $value->car_reserv_memberID,
                'detail' => $value->car_reserv_detail,
                'color' => $this->getStatusColor($value->car_reserv_status),
                // Additional info for popup
                'car_info' => $value->car_category.' '.$value->car_registration.' '.$value->car_province,
                'location' => $value->car_reserv_location,
                'booker_name' => $value->pers_prefix.$value->pers_firstname.' '.$value->pers_lastname,
                'passenger' => $value->car_reserv_number
            ];    
        }
        return $this->response->setJSON($data);
    }

    private function getStatusColor($status) {
         switch ($status) {
            case 'รอตรวจสอบ': return '#ffab00';
            case 'อนุมัติ': return '#71dd37';
            case 'ไม่อนุมัติ': return '#ff3e1d';
            default: return '#fd7e14';
        }
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

        // Check if date format is already Y-m-d (from flatpickr fallback) or d/m/Y (Thai)
        $gDateStart = (strpos($dateStart, '-') !== false) ? $dateStart : $this->convertBuddhistToGregorian($dateStart);
        $gDateEnd   = (strpos($dateEnd, '-') !== false) ? $dateEnd : $this->convertBuddhistToGregorian($dateEnd);

        $proposedStart = date('Y-m-d H:i:s',strtotime($gDateStart . ' ' . $timeStart));
        $proposedEnd   = date('Y-m-d H:i:s',strtotime($gDateEnd   . ' ' . $timeEnd));

        $excludeBookingId = $this->request->getPost('exclude_booking_id');

        $CheckDateCarBookign = $DBbooking
        ->where('car_reserv_carID', $CarID)
        ->where("TIMESTAMP(car_reserv_StartDate, car_reserv_StartTime) < '$proposedEnd'", null, false)
        ->where("TIMESTAMP(car_reserv_EndDate, car_reserv_EndTime) > '$proposedStart'", null, false)
        ->where('car_reserv_status !=', 'ไม่อนุมัติ');

        if ($excludeBookingId) {
            $CheckDateCarBookign->where('car_reserv_id !=', $excludeBookingId);
        }

        $CheckDateCarBookign = $CheckDateCarBookign->get()->getRow();

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
        $data['title']="ดูข้อมูลจองยานพาหนะ (Admin)";
        $data['description']="ดูข้อมูลจองยานพาหนะ (Admin)";
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
        
        return view('User/UserCarBooking/UserCarBookingViewAdmin', $data);
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
        
        return view('User/UserCarBooking/UserCarBookingViewExecutive', $data);
    }

  

    public function BookingCarChart(){
         $session = session();
         $database = \Config\Database::connect();
         $DBCarReservation = $database->table('tb_car_reservation');
         $DBpers = \Config\Database::connect('personnel');
         
         // 1. Pie Chart - สัดส่วนการใช้ทรัพยากร (จำนวนการจองต่อรถแต่ละคัน)
         $pieData = $DBCarReservation->select('
             skjacth_general.tb_school_car.car_registration,
             COUNT(tb_car_reservation.car_reserv_id) as count
         ')
         ->join('skjacth_general.tb_school_car', 'skjacth_general.tb_school_car.car_ID = tb_car_reservation.car_reserv_carID')
         ->groupBy('tb_car_reservation.car_reserv_carID')
         ->get()->getResult();
         
         $pieLabels = [];
         $pieSeries = [];
         foreach ($pieData as $row) {
             $pieLabels[] = $row->car_registration;
             $pieSeries[] = (int)$row->count;
         }
         
         // 2. Bar Chart - ผู้ใช้งานสูงสุด 5 อันดับ
         $barData = $DBCarReservation->select('
             CONCAT(skjacth_personnel.tb_personnel.pers_prefix, skjacth_personnel.tb_personnel.pers_firstname, " ", skjacth_personnel.tb_personnel.pers_lastname) as fullname,
             COUNT(tb_car_reservation.car_reserv_id) as count
         ')
         ->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = tb_car_reservation.car_reserv_memberID')
         ->groupBy('tb_car_reservation.car_reserv_memberID')
         ->orderBy('count', 'DESC')
         ->limit(5)
         ->get()->getResult();
         
         $barCategories = [];
         $barSeries = [];
         foreach ($barData as $row) {
             $barCategories[] = $row->fullname;
             $barSeries[] = (int)$row->count;
         }
         
         // 3. Donut Chart - สถานะการอนุมัติ
         $approveData = $DBCarReservation->select('car_reserv_status, COUNT(*) as count')
         ->groupBy('car_reserv_status')
         ->get()->getResult();
         
         $approveLabels = [];
         $approveSeries = [];
         foreach ($approveData as $row) {
             $approveLabels[] = $row->car_reserv_status;
             $approveSeries[] = (int)$row->count;
         }
         
         $data = [
             'pie' => [
                 'labels' => $pieLabels,
                 'series' => $pieSeries
             ],
             'bar' => [
                 'categories' => $barCategories,
                 'series' => $barSeries
             ],
             'Approve' => [
                 'labels' => $approveLabels,
                 'series' => $approveSeries
             ]
         ];
         
         return $this->response->setJSON($data);
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

            if (ENVIRONMENT === 'production') {
                if ($email->send()) {
                    echo $this->request->getVar('booking_locationroom');
                } else {
                    $data = $email->printDebugger(['headers']);
                    print_r($data);
                }
            } else {
                echo $this->request->getVar('booking_locationroom');
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

        require SHARED_LIB_PATH . '/mpdf/vendor/autoload.php';
        $session = session();
        $mpdf = new \Mpdf\Mpdf(
            array(
                'format' => 'A4',
                'mode' => 'utf-8',
                'default_font' => 'thsarabun',
                'default_font_size' => 16
            )
        );
        
        $mpdf->SetTitle('ใบขออนุญาตใช้รถส่วนกลาง');

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
         
            <div style="margin-top:10px">เรียน: ผู้อำนวยการสถานศึกษา โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</div>
            <div style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ข้าพเจ้า '.$ViewCarBooking->BookerName.' &nbsp;&nbsp;&nbsp; ตำแหน่ง '.$ViewCarBooking->BookerPosi.' &nbsp;&nbsp;&nbsp;&nbsp; 

            ขออนุญาตใช้รถยนต์ส่วนกลางไปที่ '.$ViewCarBooking->car_reserv_location.' เพื่อปฏิบัติงานเรื่อง  '.$ViewCarBooking->car_reserv_detail.'
            

            จำนวนผู้ไปปฏิบัติงาน '.$ViewCarBooking->car_reserv_number.' คน 
            ออกเดินทางใน'.$Datethai->thai_date_fullmonth_ALL(strtotime($ViewCarBooking->car_reserv_StartDate)).' เวลา '.date('H:i',strtotime($ViewCarBooking->car_reserv_StartTime)).' น. ถึง'.$Datethai->thai_date_fullmonth_ALL(strtotime($ViewCarBooking->car_reserv_EndDate)).' เวลา '.date('H:i',strtotime($ViewCarBooking->car_reserv_EndTime)).' น. </div>
          
            <div style="margin-left:18rem;margin-top:30px;">
                <div style="text-align:center;">
                    <div>(ลงชื่อ) ............................................ ผู้ขออนุญาต</div>
                    <div style="margin-left:0px;">('.$ViewCarBooking->BookerName.')</div>
                    <div >ตำแหน่ง '.$ViewCarBooking->BookerPosi.'</div>
                </div>            
            </div>

            <div style="position: absolute;">
                <div style="text-align:left;">
                    <div style="text-align:center;">(ลงชื่อ) ............................................ หัวหน้าฝ่ายบริหารทั่วไป</div>
                    <div style="margin-left:40px;">('.$ExecutiveGeneral->ExecutiveName.')</div>
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
        ';

        $mpdf->WriteHTML($html);
        // สร้างไฟล์ PDF
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('ใบขออนุญาตใช้รถส่วนกลาง.pdf', 'I');
    }

}