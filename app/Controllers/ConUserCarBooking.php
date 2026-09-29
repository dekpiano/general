<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Libraries\Datethai; // Import library
use App\Libraries\NotificationService;

class ConUserCarBooking extends BaseController
{

    function __construct()
    {

    }

    public function DataMain()
    {
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['uri'] = service('uri');

        return $data;
    }

    function thaidate_to_mysql($dateStr)
    {
        if (!$dateStr) return null;
        
        // If already in Y-m-d format (Gregorian AD)
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateStr)) {
            $year = (int)substr($dateStr, 0, 4);
            if ($year > 2400) {
                return ($year - 543) . substr($dateStr, 4);
            }
            return $dateStr;
        }

        // Handle d/m/Y or d-m-Y (BE or AD)
        $separator = strpos($dateStr, '/') !== false ? '/' : '-';
        $parts = explode($separator, $dateStr);
        if (count($parts) === 3) {
            // Check if year is first or last
            if (strlen($parts[0]) === 4) { // Y-m-d or Y/m/d
                $year = (int)$parts[0];
                $month = $parts[1];
                $day = $parts[2];
            } else { // d/m/Y or d-m-Y
                $day = $parts[0];
                $month = $parts[1];
                $year = (int)$parts[2];
            }

            if ($year > 2400) {
                $year -= 543;
            }
            return $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
        }

        return $dateStr;
    }

    public function CarBookingMain()
    {
        $session = session();
        $userId = $session->get('id');
        $database = \Config\Database::connect();

        // ตรวจสอบว่าผู้ใช้ที่ล็อกอินเป็นคนขับรถหรือไม่
        $isDriver = false;
        if ($userId) {
            $isDriver = $database->table('tb_car_driver')->where('cardriver_userID', $userId)->countAllResults() > 0;
        }

        // หากเป็นคนขับรถ ให้ไปที่หน้าสำหรับคนขับรถโดยตรงเพื่อดูงานและรถที่ระบบเลือกให้ขับ
        if ($isDriver) {
            return redirect()->to(base_url('CarBooking/Driver'));
        }

        $data = $this->DataMain();
        $data['title'] = "ระบบจองยานพาหนะ";
        $data['description'] = "ระบบสำหรับจองยานพาหนะภายในโรงเรียน";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingMain';

        $DBSchoolCar = $database->table('tb_school_car');
        $DBCarReservation = $database->table('tb_car_reservation');
        $data['CountCarAll'] = $DBSchoolCar->countAll();
        $data['CountCarReservationAll'] = $DBCarReservation->where('car_reserv_memberID', $userId)->countAllResults();

        $data['NumRowsWaitApprove'] = $DBCarReservation->where('car_reserv_status', 'รอตรวจสอบ')->countAllResults();
        $data['NumRowsApprove'] = $DBCarReservation->where('car_reserv_status', 'อนุมัติ')->countAllResults();

        // Fetch Car List for Mini Calendars
        $data['CarList'] = $DBSchoolCar->get()->getResult();

        return view('User/UserCarBooking/UserCarBookingMain', $data);
    }



    public function CarBookingCheckCar()
    {
        $session = session();
        $userId = $session->get('id');
        $database = \Config\Database::connect();

        $isDriver = false;
        if ($userId) {
            $isDriver = $database->table('tb_car_driver')->where('cardriver_userID', $userId)->countAllResults() > 0;
        }

        $data = $this->DataMain();
        $data['title'] = "เช็ครถก่อนทำการจอง";
        $data['description'] = "เช็ครถก่อนทำการจอง";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingCheck';

        $builder = $database->table('tb_school_car');
        if ($isDriver) {
            // ดึงเฉพาะรถที่ระบบเลือกให้คนขับคนนี้ขับ
            $assigned = $database->table('tb_car_reservation')
                ->select('car_reserv_carID')
                ->where('car_reserv_driver', $userId)
                ->where('car_reserv_status', 'อนุมัติ')
                ->groupBy('car_reserv_carID')
                ->get()->getResultArray();
            $carIds = array_column($assigned, 'car_reserv_carID');
            if (!empty($carIds)) {
                $data['CheckCar'] = $builder->whereIn('car_ID', $carIds)->get()->getResult();
            } else {
                $data['CheckCar'] = [];
            }
        } else {
            $data['CheckCar'] = $builder->get()->getResult();
        }

        return view('User/UserCarBooking/UserCarBookingCheck', $data);
    }

    public function CarBookingDataTableView()
    {
        $session = session();
        $Datethai = new Datethai();
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $DBpers->table('tb_personnel');

        $isDriver = false;
        if ($session->get('id')) {
            $isDriver = $database->table('tb_car_driver')->where('cardriver_userID', $session->get('id'))->countAllResults() > 0;
        }

        $queryBuilder = $DBCarReservation->select('
       skjacth_general.tb_car_reservation.*,
        skjacth_general.tb_school_car.car_img,
        skjacth_general.tb_school_car.car_registration,
        skjacth_general.tb_school_car.car_province,
        skjacth_general.tb_school_car.car_category,
        skjacth_personnel.tb_personnel.pers_prefix,
        skjacth_personnel.tb_personnel.pers_firstname,
        skjacth_personnel.tb_personnel.pers_lastname
       ')
            ->join('skjacth_general.tb_school_car', 'skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
            ->join('skjacth_personnel.tb_personnel', "skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID");

        if ($isDriver) {
            $queryBuilder->where('skjacth_general.tb_car_reservation.car_reserv_driver', $session->get('id'));
        }

        $S_data = $queryBuilder->orderBy('car_reserv_id', 'DESC')->get()->getResult();
        $data = array();
        foreach ($S_data as $key => $value) {
            $CheckDriver = $DBpersonnel->select('pers_prefix,pers_firstname,pers_lastname')->where('pers_id', $value->car_reserv_driver)->get()->getResult();
            if ($value->car_reserv_driver) {
                $Fullname = $CheckDriver[0]->pers_prefix . $CheckDriver[0]->pers_firstname . ' ' . $CheckDriver[0]->pers_lastname;
            }
            else {
                $Fullname = '';
            }

            $data[] = [
                'car_reserv_id' => $value->car_reserv_id,
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
                'Member' => $value->pers_prefix . $value->pers_firstname . ' ' . $value->pers_lastname,
                'Date' => $Datethai->thai_date_fullmonth(strtotime($value->car_reserv_StartDate)) . ':' . $value->car_reserv_StartTime . ' ถึง ' . $Datethai->thai_date_fullmonth(strtotime($value->car_reserv_EndDate)) . ' ' . $value->car_reserv_EndTime
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
        if (!$session->get('username')) {
            header("Location:" . base_url());
            exit();
        }
        $session = session();
        $data = $this->DataMain();
        $data['title'] = "จองห้อง / สถานที่";
        $data['description'] = "จองห้องสำหรับใช้ภายในโรงเรียน";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingAdd';
        $data['Datethai'] = new Datethai();

        $database = \Config\Database::connect();
        $DBSchoolCar = $database->table('tb_school_car');
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $DBpers->table('tb_personnel');
        $data['SelPres'] = $DBpersonnel->where('pers_status', 'กำลังใช้งาน')
            ->orderBy('pers_position', 'ASC')
            ->get()->getResult();
        //echo '<pre>';print_r($SelPres); exit();
        $DBCarReservation = $database->table('tb_car_reservation');
        $myTime = Time::now('asia/bangkok', 'th_TH');

        $data['Car'] = $DBSchoolCar->where('car_ID', $CarID)->get()->getRow();

        $data['CarBookingNow'] = $DBCarReservation->orderBy('car_reserv_id', 'DESC')->get()->getRow();

        if (isset($data['CarBookingNow']->car_reserv_order) == "") {
            $data['car_reserv_order'] = "OrderCar_" . date('Y') . "0001";
        }
        else {
            $sub = explode('_', $data['CarBookingNow']->car_reserv_order);
            $data['car_reserv_order'] = $sub[0] . "_" . (((int)$sub[1]) + 1);
        }


        return view('User/UserCarBooking/UserCarBookingAdd', $data);
    }

    public function CarBookingInsert()
    {

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
        if (empty($order) || empty($memberID) || empty($carID) || empty($startDate) || empty($endDate)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
        }

        $Car_dateStart = $this->thaidate_to_mysql($startDate);
        $Car_dateEnd = $this->thaidate_to_mysql($endDate);

        // Check Overlap
        $proposedStart = date('Y-m-d H:i:s', strtotime($Car_dateStart . ' ' . $this->request->getVar('car_reserv_StartTime')));
        $proposedEnd = date('Y-m-d H:i:s', strtotime($Car_dateEnd . ' ' . $this->request->getVar('car_reserv_EndTime')));

        $isOverlap = $DBCarReservation
            ->where('car_reserv_carID', $carID)
            ->where("TIMESTAMP(car_reserv_StartDate, car_reserv_StartTime) < '$proposedEnd'", null, false)
            ->where("TIMESTAMP(car_reserv_EndDate, car_reserv_EndTime) > '$proposedStart'", null, false)
            ->whereNotIn('car_reserv_status', ['ไม่อนุมัติ', 'ยกเลิก'])
            ->countAllResults();

        if ($isOverlap > 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'มีการจองในช่วงเวลานี้แล้ว']);
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
            'car_reserv_status' => "รอตรวจสอบ",
            'fuel_request' => $this->request->getVar('fuel_request'),
            'fuel_type' => $this->request->getVar('fuel_type'),
            'fuel_amount' => $this->request->getVar('fuel_amount') ?: null,
            'fuel_other_desc' => $this->request->getVar('fuel_other_desc')
        ];


        if ($DBCarReservation->insert($data)) {
            $DataNow = $database->insertID();

            try {
                // Fetch information for notification
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
                    ->join('skjacth_general.tb_school_car', 'skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
                    ->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID')
                    ->where('tb_car_reservation.car_reserv_id', $DataNow)
                    ->get()->getRowArray();

                if ($Car) {
                    $notificationService = new NotificationService();
                    $requesterName = $Car['pers_prefix'] . $Car['pers_firstname'] . ' ' . $Car['pers_lastname'];
                    $requesterEmail = $Car['pers_username'] ?? '';
                    $dateRange = $Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_StartDate'])) . ' - ' . $Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_EndDate']));

                    // Check if recorded by someone else (e.g. Officer / Admin booking for a teacher)
                    $recorderId = $session->get('id');
                    $isBookedByOther = ($recorderId && $recorderId != $Car['car_reserv_memberID']);
                    $recorderPerson = $recorderId ? $notificationService->getPersonnelInfo($recorderId) : null;
                    $recorderName = $recorderPerson ? $notificationService->getFullName($recorderPerson) : ($session->get('username') ?: 'เจ้าหน้าที่');
                    $recorderEmail = $session->get('email') ?: ($recorderPerson ? $recorderPerson->pers_username : '');

                    // 1. ข้อความแจ้งเตือน Telegram เมื่อมีคำขอจองใหม่
                    $msg = "🚗 <b>มีคำขอจองยานพาหนะใหม่</b>\n";
                    $msg .= "👤 ผู้ขอจอง: {$requesterName}\n";
                    if ($isBookedByOther) {
                        $msg .= "✍️ ผู้บันทึกข้อมูล: {$recorderName} (จองแทน)\n";
                    }
                    $msg .= "🚘 ยานพาหนะ: {$Car['car_category']} {$Car['car_registration']} {$Car['car_province']}\n";
                    $msg .= "📍 สถานที่ไป: {$Car['car_reserv_location']}\n";
                    $msg .= "📝 วัตถุประสงค์: {$Car['car_reserv_detail']}\n";
                    $msg .= "👥 จำนวนผู้ร่วมเดินทาง: {$Car['car_reserv_number']} คน\n";
                    $msg .= "📅 วันที่ใช้: {$dateRange}\n";
                    $msg .= "📊 สถานะ: ⏳ รอการอนุมัติ\n";
                    $msg .= "👉 ตรวจสอบ/อนุมัติ: " . base_url("/CarBooking/Approve/Admin");

                    // 2. ส่ง Telegram แจ้งเตือนกลุ่มงานยานพาหนะทันที
                    try {
                        $notificationService->sendTelegram('car', $msg);
                    } catch (\Exception $e) {
                        log_message('error', 'Car Booking Telegram Error: ' . $e->getMessage());
                    }

                    // 3. ส่ง OneSignal Push Notification หาผู้ดูแลระบบยานพาหนะ
                    try {
                        $notificationService->sendPush(
                            "มีคำขอจองยานพาหนะใหม่!",
                            "โดย {$requesterName} ({$Car['car_category']} {$Car['car_registration']})",
                            base_url("/CarBooking/Approve/Admin"),
                            ['role' => 'admin_car']
                        );
                    } catch (\Exception $e) {
                        log_message('error', 'Car Booking Push Error: ' . $e->getMessage());
                    }

                    // 4. ส่ง Email หาผู้ขอจอง (ครู/บุคลากรที่ขอใช้รถ)
                    try {
                        if (!empty($requesterEmail)) {
                            $userEmailFields = [
                                ['label' => 'เรียน', 'value' => $requesterName],
                                ['label' => 'รถที่ขอใช้', 'value' => $Car['car_category'] . ' ' . $Car['car_registration'] . ' ' . $Car['car_province']],
                                ['label' => 'วัตถุประสงค์', 'value' => $Car['car_reserv_detail']],
                            ];
                            if ($isBookedByOther) {
                                $userEmailFields[] = ['label' => 'ผู้บันทึกข้อมูล', 'value' => $recorderName . ' (จองแทน)'];
                            }

                            $emailData = [
                                'header_title' => 'ได้รับคำขอจองยานพาหนะแล้ว',
                                'header_sub'   => $isBookedByOther 
                                    ? "ระบบจองยานพาหนะออนไลน์ (เจ้าหน้าที่ {$recorderName} ได้ทำการบันทึกข้อมูลการจองให้ท่าน)" 
                                    : 'ระบบจองยานพาหนะออนไลน์ (Vehicle Booking Service)',
                                'fields' => $userEmailFields,
                                'columns' => [
                                    ['label' => 'เลขที่คำขอ', 'value' => $Car['car_reserv_order']],
                                    ['label' => 'ช่วงเวลาที่ใช้', 'value' => $dateRange]
                                ],
                                'status' => [
                                    'text' => '⏳ รอการตรวจสอบ',
                                    'bg' => '#fff3e0',
                                    'color' => '#e65100'
                                ],
                                'cta_text' => '👉 ตรวจสอบสถานะการจอง',
                                'cta_url'  => base_url("CarBooking/View")
                            ];

                            $notificationService->sendEmail(
                                $requesterEmail,
                                "แจ้งการจองยานพาหนะ: รอการตรวจสอบ (" . $Car['car_category'] . ")",
                                'car',
                                $emailData,
                                'noreply@skj.ac.th',
                                "ระบบจองยานพาหนะ SKJ"
                            );
                        }
                    } catch (\Exception $e) {
                        log_message('error', 'Car Booking Requester Email Error: ' . $e->getMessage());
                    }

                    // 5. ส่ง Email แจ้งผู้บันทึกข้อมูล (กรณีเจ้าหน้าที่/แอดมินบันทึกจองแทนผู้อื่น)
                    try {
                        if ($isBookedByOther && !empty($recorderEmail) && $recorderEmail !== $requesterEmail) {
                            $recorderEmailData = [
                                'header_title' => 'บันทึกการจองยานพาหนะสำเร็จ',
                                'header_sub'   => "ระบบจองยานพาหนะออนไลน์ (ท่านได้ทำรายการจองแทน {$requesterName})",
                                'fields' => [
                                    ['label' => 'ผู้บันทึกข้อมูล', 'value' => $recorderName . ' (ท่าน)'],
                                    ['label' => 'ผู้ขอใช้บริการ', 'value' => $requesterName],
                                    ['label' => 'รถที่ขอใช้', 'value' => $Car['car_category'] . ' ' . $Car['car_registration'] . ' ' . $Car['car_province']],
                                    ['label' => 'วัตถุประสงค์', 'value' => $Car['car_reserv_detail']],
                                ],
                                'columns' => [
                                    ['label' => 'เลขที่คำขอ', 'value' => $Car['car_reserv_order']],
                                    ['label' => 'ช่วงเวลาที่ใช้', 'value' => $dateRange]
                                ],
                                'status' => [
                                    'text' => '⏳ รอการตรวจสอบ',
                                    'bg' => '#fff3e0',
                                    'color' => '#e65100'
                                ],
                                'cta_text' => '👉 ดูรายการจองทั้งหมด',
                                'cta_url'  => base_url("CarBooking/View")
                            ];

                            $notificationService->sendEmail(
                                $recorderEmail,
                                "บันทึกการจองยานพาหนะสำเร็จ (จองแทน: {$requesterName})",
                                'car',
                                $recorderEmailData,
                                'noreply@skj.ac.th',
                                "ระบบจองยานพาหนะ SKJ"
                            );
                        }
                    } catch (\Exception $e) {
                        log_message('error', 'Car Booking Recorder Email Error: ' . $e->getMessage());
                    }

                    // 6. ส่ง Email หาเจ้าหน้าที่และหัวหน้างานยานพาหนะ
                    try {
                        $staffEmailsCar = $notificationService->getStaffEmailsByDepartment('งานยานพาหนะ');
                        if (!empty($staffEmailsCar)) {
                            $adminEmailFields = [
                                ['label' => 'ผู้ขอจอง', 'value' => $requesterName],
                            ];
                            if ($isBookedByOther) {
                                $adminEmailFields[] = ['label' => 'ผู้บันทึกข้อมูล', 'value' => $recorderName . ' (จองแทน)'];
                            }
                            $adminEmailFields[] = ['label' => 'รถที่ขอใช้', 'value' => $Car['car_category'] . ' ' . $Car['car_registration'] . ' ' . $Car['car_province']];
                            $adminEmailFields[] = ['label' => 'วัตถุประสงค์', 'value' => $Car['car_reserv_detail']];

                            $adminEmailDataCar = [
                                'header_title' => 'มีคำขอจองยานพาหนะใหม่',
                                'header_sub'   => 'ระบบจองยานพาหนะออนไลน์ (Vehicle Booking Service)',
                                'fields' => $adminEmailFields,
                                'columns' => [
                                    ['label' => 'เลขที่คำขอ', 'value' => $Car['car_reserv_order']],
                                    ['label' => 'ช่วงเวลาที่ใช้', 'value' => $dateRange]
                                ],
                                'status' => [
                                    'text' => '⏳ รออนุมัติ',
                                    'bg' => '#ffe5d9',
                                    'color' => '#ff6b35'
                                ],
                                'cta_text' => '👉 ไปหน้าอนุมัติการจองรถ',
                                'cta_url'  => base_url('CarBooking/Approve/Admin')
                            ];

                            $notificationService->sendEmail(
                                $staffEmailsCar,
                                "แจ้งการจองยานพาหนะใหม่: " . $Car['car_category'] . " (" . $requesterName . ")",
                                'car',
                                $adminEmailDataCar,
                                'noreply@skj.ac.th',
                                "ระบบจองยานพาหนะ SKJ"
                            );
                        }
                    } catch (\Exception $e) {
                        log_message('error', 'Car Booking Staff Email Error: ' . $e->getMessage());
                    }
                }
            }
            catch (\Exception $e) {
                // Log and ignore to ensure success response is returned
                log_message('error', 'Notification Error: ' . $e->getMessage());
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลการจองเรียบร้อยแล้ว']);
        }
        else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
        }

    }

    public function CarBookingEdit($id = null)
    {
        $session = session();
        if (!$session->get('username')) {
            return redirect()->to(base_url('LoginOfficerGeneral?return_to=' . urlencode(current_url())));
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

        $isPrivileged = in_array($userStatus, ['superadmin', 'admin', 'manager', 'ExecutiveGeneral', 'AdminGeneral'])
            || in_array('งานยานพาหนะ', $userRoles);

        if ($booking->car_reserv_memberID != $currentUserId && !$isPrivileged) {
            echo "
            <script>
                alert('คุณไม่มีสิทธิ์แก้ไขข้อมูลการจองนี้ เฉพาะผู้จองหรือผู้ดูแลระบบเท่านั้น');
                window.location.href = '" . base_url('CarBooking') . "';
            </script>
            ";
            exit();
        }

        // Block editing if Approved (for non-admins)
        if ($booking->car_reserv_status == 'อนุมัติ' && !$isPrivileged) {
            echo "
            <script>
                alert('รายการนี้ได้รับการอนุมัติแล้ว ไม่สามารถแก้ไขได้ กรุณาติดต่อเจ้าหน้าที่');
                window.location.href = '" . base_url('CarBooking') . "';
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
        $data['SelPres'] = $DBpersonnel->where('pers_status', 'กำลังใช้งาน')
            ->orderBy('pers_position', 'ASC')
            ->get()->getResult();

        $data['Booking'] = $booking;

        // Pass info about the booked car specifically
        $data['Car'] = $DBSchoolCar->where('car_ID', $booking->car_reserv_carID)->get()->getRow();

        return view('User/UserCarBooking/UserCarBookingEdit', $data);
    }

    public function CarBookingUpdate()
    {

        $session = session();
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');

        $id = $this->request->getVar('car_reserv_id');
        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบ ID การจอง']);
        }

        $Car_dateStart = $this->thaidate_to_mysql($this->request->getVar('car_reserv_StartDate'));
        $Car_dateEnd = $this->thaidate_to_mysql($this->request->getVar('car_reserv_EndDate'));
        $carID = $this->request->getVar('car_reserv_carID');

        // Check Overlap (excluding this booking)
        $proposedStart = date('Y-m-d H:i:s', strtotime($Car_dateStart . ' ' . $this->request->getVar('car_reserv_StartTime')));
        $proposedEnd = date('Y-m-d H:i:s', strtotime($Car_dateEnd . ' ' . $this->request->getVar('car_reserv_EndTime')));

        $isOverlap = $DBCarReservation
            ->where('car_reserv_carID', $carID)
            ->where('car_reserv_id !=', $id)
            ->where("TIMESTAMP(car_reserv_StartDate, car_reserv_StartTime) < '$proposedEnd'", null, false)
            ->where("TIMESTAMP(car_reserv_EndDate, car_reserv_EndTime) > '$proposedStart'", null, false)
            ->whereNotIn('car_reserv_status', ['ไม่อนุมัติ', 'ยกเลิก'])
            ->countAllResults();

        if ($isOverlap > 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'มีการจองในช่วงเวลานี้แล้ว']);
        }

        $data = [
            'car_reserv_carID' => $carID,
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
            'car_reserv_status' => "รอตรวจสอบ",
            'fuel_request' => $this->request->getVar('fuel_request'),
            'fuel_type' => $this->request->getVar('fuel_type'),
            'fuel_amount' => $this->request->getVar('fuel_amount') ?: null,
            'fuel_other_desc' => $this->request->getVar('fuel_other_desc')
        ];

        $DBCarReservation->where('car_reserv_id', $id);
        if ($DBCarReservation->update($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'แก้ไขข้อมูลการจองเรียบร้อยแล้ว',
                'car_id' => $this->request->getVar('car_reserv_carID')
            ]);
        }
        else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล'
            ]);
        }
    }

    // --------------- พิมพ์แบบฟอร์ม ---------------------------
    public function CarBookingPrint($id = null)
    {
        $session = session();
        if (!$session->get('username')) {
            return redirect()->to(base_url('LoginOfficerGeneral?return_to=' . urlencode(current_url())));
        }

        $data = $this->DataMain();
        $data['title'] = "พิมพ์ใบอนุญาตใช้รถส่วนกลาง";
        $data['Datethai'] = new Datethai();

        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        
        $booking = $DBCarReservation->select('
                skjacth_general.tb_car_reservation.*,
                skjacth_general.tb_school_car.car_registration,
                skjacth_general.tb_school_car.car_province,
                skjacth_general.tb_school_car.car_category,
                p1.pers_prefix as req_prefix, p1.pers_firstname as req_firstname, p1.pers_lastname as req_lastname,
                p1.pers_academic as req_academic,
                p1.pers_position as req_pers_position,
                p1.pers_learning as req_pers_learning,
                p1.pers_workother_id as req_pers_workother,
                bookerPosi.posi_name as req_position,
                bookerPosiMain.work_name as req_position_main,
                p2.pers_prefix as drv_prefix, p2.pers_firstname as drv_firstname, p2.pers_lastname as drv_lastname,
                p2.pers_academic as drv_academic,
                p2.pers_position as drv_pers_position,
                drvPosiMain.work_name as drv_position_main,
                p3.pers_prefix as approver_prefix, p3.pers_firstname as approver_firstname, p3.pers_lastname as approver_lastname,
                p3.pers_academic as approver_academic,
                approverPosi.posi_name as approver_position
            ')
            ->join('skjacth_general.tb_school_car', 'skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID', 'left')
            ->join('skjacth_personnel.tb_personnel AS p1', 'tb_car_reservation.car_reserv_memberID = p1.pers_id', 'left')
            ->join('skjacth_skj.tb_position AS bookerPosi', 'bookerPosi.posi_id = p1.pers_position', 'left')
            ->join('skjacth_skj.tb_position_main AS bookerPosiMain', 'bookerPosiMain.work_id = p1.pers_workother_id', 'left')
            ->join('skjacth_personnel.tb_personnel AS p2', 'tb_car_reservation.car_reserv_driver = p2.pers_id', 'left')
            ->join('skjacth_skj.tb_position_main AS drvPosiMain', 'drvPosiMain.work_id = p2.pers_workother_id', 'left')
            ->join('skjacth_personnel.tb_personnel AS p3', 'tb_car_reservation.car_reserv_approver = p3.pers_id', 'left')
            ->join('skjacth_skj.tb_position AS approverPosi', 'approverPosi.posi_id = p3.pers_position', 'left')
            ->where('car_reserv_id', $id)
            ->get()->getRow();

        if (!$booking) {
            return redirect()->to(base_url('CarBooking'))->with('error', 'ไม่พบข้อมูลการจอง');
        }

        $data['Booking'] = $booking;
        
        $dbGeneral = \Config\Database::connect();
        $dbPersonnel = \Config\Database::connect('personnel');

        // 1. รองผู้อำนวยการกลุ่มบริหารทั่วไป (หัวหน้าฝ่าย)
        $DeputyDirectorGeneral = $dbGeneral->table('tb_admin_rloes')
            ->select('
                CONCAT(skjacth_personnel.tb_personnel.pers_prefix, skjacth_personnel.tb_personnel.pers_firstname, " ", skjacth_personnel.tb_personnel.pers_lastname) AS ExecutiveName,
                skjacth_skj.tb_position.posi_name,
                skjacth_personnel.tb_personnel.pers_academic
            ')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id', 'left')
            ->join('skjacth_skj.tb_position', 'skjacth_skj.tb_position.posi_id = skjacth_personnel.tb_personnel.pers_position', 'left')
            ->groupStart()
                ->like('admin_rloes_nanetype', 'รองผู้อำนวยการบริหารทั่วไป')
                ->orLike('admin_rloes_nanetype', 'บริหารทั่วไป')
            ->groupEnd()
            ->get()->getRow();

        // 2. ผู้อำนวยการโรงเรียน (ผู้มีอำนาจสั่งใช้รถ)
        $Director = $dbGeneral->table('tb_admin_rloes')
            ->select('
                CONCAT(skjacth_personnel.tb_personnel.pers_prefix, skjacth_personnel.tb_personnel.pers_firstname, " ", skjacth_personnel.tb_personnel.pers_lastname) AS DirectorName,
                skjacth_skj.tb_position.posi_name,
                skjacth_personnel.tb_personnel.pers_academic
            ')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id', 'left')
            ->join('skjacth_skj.tb_position', 'skjacth_skj.tb_position.posi_id = skjacth_personnel.tb_personnel.pers_position', 'left')
            ->like('admin_rloes_nanetype', 'ผู้อำนวยการ')
            ->get()->getRow();

        // Fallback: หากยังไม่ได้ผูกใน tb_admin_rloes ให้ดึงจากตำแหน่งใน tb_personnel
        if (!$DeputyDirectorGeneral) {
            $DeputyDirectorGeneral = $dbPersonnel->table('tb_personnel')
                ->select('
                    CONCAT(pers_prefix, pers_firstname, " ", pers_lastname) AS ExecutiveName,
                    skjacth_skj.tb_position.posi_name,
                    pers_academic
                ')
                ->join('skjacth_skj.tb_position', 'skjacth_personnel.tb_personnel.pers_position = skjacth_skj.tb_position.posi_id', 'left')
                ->where('skjacth_skj.tb_position.posi_name LIKE', '%รองผู้อำนวยการ%')
                ->where('pers_status', 'กำลังใช้งาน')
                ->get()->getRow();
        }

        if (!$Director) {
            $Director = $dbPersonnel->table('tb_personnel')
                ->select('
                    CONCAT(pers_prefix, pers_firstname, " ", pers_lastname) AS DirectorName,
                    skjacth_skj.tb_position.posi_name,
                    pers_academic
                ')
                ->join('skjacth_skj.tb_position', 'skjacth_personnel.tb_personnel.pers_position = skjacth_skj.tb_position.posi_id', 'left')
                ->where('skjacth_skj.tb_position.posi_name LIKE', '%ผู้อำนวยการโรงเรียน%')
                ->where('pers_status', 'กำลังใช้งาน')
                ->get()->getRow();
        }

        $data['DeputyDirectorGeneral'] = $DeputyDirectorGeneral;
        $data['Director'] = $Director;
        
        // เราสามารถเพิ่มการเรียกตารางแผนกของ User ตรงนี้ได้ถ้ามี
        $data['req_department'] = "โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";

        return view('User/UserCarBooking/UserCarBookingPrint', $data);
    }

    // --------------- ของแอดมิน อนุมัตื ApproveAdmin ---------------------------

    public function CarBookingDataTableApproveAdmin()
    {
        $session = session();
        $Datethai = new Datethai();
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        $DBpers = \Config\Database::connect('personnel');
        $DBpersonnel = $DBpers->table('tb_personnel');

        $S_data = $DBCarReservation->select('
        tb_car_reservation.car_reserv_id,
        tb_car_reservation.car_reserv_order,
        tb_car_reservation.car_reserv_carID,
        tb_car_reservation.car_reserv_memberID,
        tb_car_reservation.car_reserv_driver,
        tb_car_reservation.car_reserv_location,
        tb_car_reservation.car_reserv_detail,
        tb_car_reservation.car_reserv_status,
        tb_car_reservation.car_reserv_StartDate,
        tb_car_reservation.car_reserv_StartTime,
        tb_car_reservation.car_reserv_EndDate,
        tb_car_reservation.car_reserv_EndTime,
        skjacth_general.tb_school_car.car_img,
        skjacth_general.tb_school_car.car_registration,
        skjacth_general.tb_school_car.car_province,
        skjacth_general.tb_school_car.car_category,
        CONCAT(p1.pers_prefix, p1.pers_firstname, " ", p1.pers_lastname) AS carReservMemberID,
        CONCAT(p2.pers_prefix, p2.pers_firstname, " ", p2.pers_lastname) AS carReservDriver,
        CONCAT(p3.pers_prefix, p3.pers_firstname, " ", p3.pers_lastname) AS carReservApprover
       ')
            ->join('skjacth_general.tb_school_car', 'skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
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

            $data[] = [
                'car_reserv_order' => $value->car_reserv_order,
                'car_reserv_carID' => $value->car_reserv_carID,
                'car_reserv_id' => $value->car_reserv_id,
                'car_registration' => $value->car_registration,
                'car_reserv_driver' => $value->carReservDriver,
                'car_province' => $value->car_province,
                'car_category' => $value->car_category,
                'car_reserv_location' => $value->car_reserv_location,
                'car_reserv_detail' => $value->car_reserv_detail,
                'car_reserv_memberID' => $value->car_reserv_memberID,
                'car_reserv_status' => $value->car_reserv_status,
                'car_img' => $value->car_img,
                'Member' => $value->carReservMemberID,
                'car_reserv_approver' => $value->carReservApprover,
                'Date' => $Datethai->thai_date_fullmonth(strtotime($value->car_reserv_StartDate)) . ':' . $value->car_reserv_StartTime . ' ถึง ' . $Datethai->thai_date_fullmonth(strtotime($value->car_reserv_EndDate)) . ' ' . $value->car_reserv_EndTime
            ];
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
    }

    // ---------- ขอ แอดมิน อนุมัตื --------------------

    public function CarBookingView()
    {
        $session = session();
        $data = $this->DataMain();
        $data['title'] = "แดชบอร์ดการจองยานพาหนะ";
        $data['description'] = "ดูภาพรวม สถิติ และตารางการจองยานพาหนะประจำปี";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingView';
        $data['Datethai'] = new Datethai();

        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');

        // Extract available years from tb_car_reservation
        $yearsResult = $database->query("
            SELECT DISTINCT YEAR(car_reserv_StartDate) as yr 
            FROM tb_car_reservation 
            WHERE car_reserv_StartDate IS NOT NULL AND car_reserv_StartDate != '0000-00-00'
            ORDER BY yr DESC
        ")->getResultArray();

        $availableYears = [];
        foreach ($yearsResult as $yRow) {
            if (!empty($yRow['yr'])) {
                $availableYears[] = (int)$yRow['yr'];
            }
        }

        $currentYear = (int)date('Y');
        if (!in_array($currentYear, $availableYears)) {
            array_unshift($availableYears, $currentYear);
        }
        rsort($availableYears);

        // Get selected year filter from GET query
        $selectedYear = $this->request->getGet('year');
        if ($selectedYear === null || $selectedYear === '') {
            $selectedYear = $currentYear;
        }

        $data['availableYears'] = $availableYears;
        $data['selectedYear'] = $selectedYear;

        // Query reservations with car and member details
        $builder = $database->table('tb_car_reservation')
            ->select('
                skjacth_general.tb_car_reservation.*,
                skjacth_general.tb_school_car.car_img,
                skjacth_general.tb_school_car.car_registration,
                skjacth_general.tb_school_car.car_province,
                skjacth_general.tb_school_car.car_category,
                skjacth_personnel.tb_personnel.pers_prefix,
                skjacth_personnel.tb_personnel.pers_firstname,
                skjacth_personnel.tb_personnel.pers_lastname
            ')
            ->join('skjacth_general.tb_school_car', 'skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID', 'left')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID', 'left');

        if ($selectedYear !== 'all' && is_numeric($selectedYear)) {
            $builder->where('YEAR(car_reserv_StartDate)', (int)$selectedYear);
        }

        $isDriver = false;
        if ($session->get('id')) {
            $isDriver = $database->table('tb_car_driver')->where('cardriver_userID', $session->get('id'))->countAllResults() > 0;
        }
        if ($isDriver) {
            $builder->where('skjacth_general.tb_car_reservation.car_reserv_driver', $session->get('id'));
        }

        $data['CarBooking'] = $builder->orderBy('car_reserv_id', 'DESC')->get()->getResult();

        // Calculate statistics
        $totalBookings = count($data['CarBooking']);
        $approvedCount = 0;
        $pendingCount = 0;
        $rejectedCount = 0;

        $monthlyCounts = array_fill(1, 12, 0);
        $vehicleCounts = [];

        foreach ($data['CarBooking'] as $b) {
            $status = $b->car_reserv_status;
            if ($status == 'อนุมัติ') {
                $approvedCount++;
            } else if ($status == 'รอตรวจสอบ') {
                $pendingCount++;
            } else {
                $rejectedCount++;
            }

            if (!empty($b->car_reserv_StartDate)) {
                $m = (int)date('n', strtotime($b->car_reserv_StartDate));
                if ($m >= 1 && $m <= 12) {
                    $monthlyCounts[$m]++;
                }
            }

            $carLabel = ($b->car_category ? $b->car_category . ' ' : '') . ($b->car_registration ?: 'อื่นๆ');
            if (!isset($vehicleCounts[$carLabel])) {
                $vehicleCounts[$carLabel] = 0;
            }
            $vehicleCounts[$carLabel]++;
        }

        arsort($vehicleCounts);
        $topVehicles = array_slice($vehicleCounts, 0, 5, true);

        $data['stats'] = [
            'total' => $totalBookings,
            'approved' => $approvedCount,
            'pending' => $pendingCount,
            'rejected' => $rejectedCount,
            'monthly' => array_values($monthlyCounts),
            'topVehicles' => [
                'labels' => array_keys($topVehicles),
                'series' => array_values($topVehicles)
            ]
        ];

        return view('User/UserCarBooking/UserCarBookingView', $data);
    }

    public function CarBookingApproveAdmin()
    {
        $session = session();

        // ตรวจสอบ session ก่อนดำเนินการ
        if (!$session->get('id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');

        $data = array(
            'car_reserv_driver' => $this->request->getVar('Driver'),
            'car_reserv_status' => 'อนุมัติ',
            'car_reserv_approver' => $session->get('id')
        );
        $DBCarReservation->where('car_reserv_id', $this->request->getVar('carbookingID'));
        if ($DBCarReservation->update($data)) {
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
                skjacth_personnel.tb_personnel.pers_lastname,
                skjacth_personnel.tb_personnel.pers_username
            ')
                ->join('skjacth_general.tb_school_car', 'skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
                ->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID')
                ->where('tb_car_reservation.car_reserv_id', $this->request->getVar('carbookingID'))
                ->get()->getRowArray();

            if ($Car) {
                try {
                    $Datethai = new Datethai();
                    $notificationService = new NotificationService();
                    $requesterName = $Car['pers_prefix'] . $Car['pers_firstname'] . ' ' . $Car['pers_lastname'];
                    $dateRange = $Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_StartDate'])) . ' - ' . $Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_EndDate']));
                    $approverName = $session->get('username') ?: 'เจ้าหน้าที่';

                    // 2. ส่ง Email ด้วย template กลาง (Approved)
                    $userEmail = $session->get('email');
                    if ($userEmail && !empty($Car['pers_username'])) {
                        $emailData = [
                            'header_title' => 'การจองยานพาหนะได้รับการอนุมัติแล้ว',
                            'header_sub'   => 'ระบบจองยานพาหนะออนไลน์ (Vehicle Booking Service)',
                            'fields' => [
                                ['label' => 'เรียน', 'value' => $requesterName],
                                ['label' => 'รถที่ได้รับอนุมัติ', 'value' => $Car['car_category'] . ' ' . $Car['car_registration'] . ' ' . $Car['car_province']],
                            ],
                            'columns' => [
                                ['label' => 'เลขที่จอง', 'value' => $Car['car_reserv_order']],
                                ['label' => 'ช่วงเวลาที่ใช้', 'value' => $dateRange]
                            ],
                            'status' => [
                                'text' => '✅ อนุมัติแล้ว',
                                'bg' => '#e8f5e9',
                                'color' => '#2e7d32'
                            ],
                            'cta_text' => '👉 ตรวจสอบสถานะการจอง',
                            'cta_url'  => base_url("CarBooking/View")
                        ];

                        $notificationService->sendEmail(
                            $Car['pers_username'],
                            "ผลการจองยานพาหนะ: อนุมัติ",
                            'approved',
                            $emailData,
                            $userEmail,
                            "ระบบจองยานพาหนะ SKJ"
                        );
                    }
                }
                catch (\Exception $e) {
                    log_message('error', 'Approve Notification Error: ' . $e->getMessage());
                }

                // ส่ง Telegram แจ้งอนุมัติการจองยานพาหนะ
                try {
                    $approverPerson = $notificationService->getPersonnelInfo($session->get('id') ?? '');
                    $approverFullName = $approverPerson ? $notificationService->getFullName($approverPerson) : ($session->get('username') ?: 'เจ้าหน้าที่');

                    $telegramMsg = "✅ <b>อนุมัติการจองยานพาหนะเรียบร้อย</b>\n";
                    $telegramMsg .= "👤 ผู้ขอจอง: {$requesterName}\n";
                    $telegramMsg .= "🚘 ยานพาหนะ: {$Car['car_category']} {$Car['car_registration']} {$Car['car_province']}\n";
                    $telegramMsg .= "📅 ช่วงเวลา: {$dateRange}\n";
                    $telegramMsg .= "👨‍💼 ผู้อนุมัติ: {$approverFullName}\n";
                    $telegramMsg .= "📊 สถานะ: ✅ อนุมัติแล้ว\n";
                    $telegramMsg .= "👉 ดูรายละเอียด: " . base_url("CarBooking/View");
                    $notificationService->sendTelegram('car', $telegramMsg);
                } catch (\Exception $e) {
                    log_message('error', 'Approve Telegram Error: ' . $e->getMessage());
                }
            }
            return $this->response->setJSON(['status' => 'success', 'message' => 'อนุมัติการจองเรียบร้อยแล้ว']);
        }
        else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถดำเนินการได้']);
        }
    }

    public function CarBookingNoApproveAdmin()
    {
        $session = session();

        // ตรวจสอบ session ก่อนดำเนินการ
        if (!$session->get('id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');
        $Datethai = new Datethai();

        $status = $this->request->getVar('status') ?: 'ไม่อนุมัติ';

        $data = array(
            'car_reserv_driver' => "",
            'car_reserv_status' => $status,
            'car_reserv_approver' => $session->get('id')
        );
        $DBCarReservation->where('car_reserv_id', $this->request->getVar('carbookingID'));
        if ($DBCarReservation->update($data)) {

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
                ->join('skjacth_general.tb_school_car', 'skjacth_general.tb_school_car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
                ->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID')
                ->where('tb_car_reservation.car_reserv_id', $this->request->getVar('carbookingID'))
                ->get()->getRowArray();

            if ($Car) {
                try {
                    $notificationService = new NotificationService();
                    $requesterName = $Car['pers_prefix'] . $Car['pers_firstname'] . ' ' . $Car['pers_lastname'];
                    $dateRange = $Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_StartDate'])) . ' - ' . $Datethai->thai_date_and_time_short(strtotime($Car['car_reserv_EndDate']));
                    
                    $statusText = ($status === 'ยกเลิก') ? 'ยกเลิกการจอง' : 'ไม่อนุมัติ';
                    $reasonText = ($status === 'ยกเลิก') ? 'การจองนี้ถูกยกเลิกโดยผู้ดูแลระบบ' : 'กรุณาติดต่อเจ้าหน้าที่เพื่อสอบถามรายละเอียดเพิ่มเติม';

                    // 2. ส่ง Email ด้วย template กลาง (Rejected)
                    $userEmail = $session->get('email');
                    if ($userEmail && !empty($Car['pers_username'])) {
                        $emailData = [
                            'header_title' => ($status === 'ยกเลิก') ? 'การจองยานพาหนะถูกยกเลิก' : 'การจองยานพาหนะไม่ได้รับการอนุมัติ',
                            'header_sub'   => 'ระบบจองยานพาหนะออนไลน์ (Vehicle Booking Service)',
                            'fields' => [
                                ['label' => 'เรียน', 'value' => $requesterName],
                                ['label' => 'รถที่จอง', 'value' => $Car['car_category'] . ' ' . $Car['car_registration']],
                            ],
                            'columns' => [
                                ['label' => 'เลขที่จอง', 'value' => $Car['car_reserv_order']],
                                ['label' => 'ช่วงเวลาที่ขอ', 'value' => $dateRange]
                            ],
                            'reason' => [
                                'label' => 'บันทึกจากระบบ',
                                'text' => $reasonText
                            ],
                            'status' => [
                                'text' => ($status === 'ยกเลิก') ? '❌ ยกเลิกการจอง' : '❌ ไม่อนุมัติ',
                                'bg' => '#ffeacc',
                                'color' => '#ff3e1d'
                            ],
                            'cta_text' => '👉 ตรวจสอบสถานะการจอง',
                            'cta_url'  => base_url("CarBooking/View")
                        ];

                        $notificationService->sendEmail(
                            $Car['pers_username'],
                            "ผลการจองยานพาหนะ: " . $statusText,
                            'rejected',
                            $emailData,
                            $userEmail,
                            "ระบบจองยานพาหนะ SKJ"
                        );
                    }
                }
                catch (\Exception $e) {
                    log_message('error', 'No-Approve Email Error: ' . $e->getMessage());
                }

                // ส่ง Telegram แจ้งไม่อนุมัติ/ยกเลิกการจองยานพาหนะ
                try {
                    $processorPerson = $notificationService->getPersonnelInfo($session->get('id') ?? '');
                    $processorFullName = $processorPerson ? $notificationService->getFullName($processorPerson) : ($session->get('username') ?: 'เจ้าหน้าที่');

                    $telegramMsg = "❌ <b>{$statusText}การจองยานพาหนะ</b>\n";
                    $telegramMsg .= "👤 ผู้ขอจอง: {$requesterName}\n";
                    $telegramMsg .= "🚘 ยานพาหนะ: {$Car['car_category']} {$Car['car_registration']}\n";
                    $telegramMsg .= "📝 เหตุผล: {$reasonText}\n";
                    $telegramMsg .= "👨‍💼 ผู้ดำเนินการ: {$processorFullName}\n";
                    $telegramMsg .= "👉 ดูรายละเอียด: " . base_url("CarBooking/View");
                    $notificationService->sendTelegram('car', $telegramMsg);
                } catch (\Exception $e) {
                    log_message('error', 'No-Approve Telegram Error: ' . $e->getMessage());
                }
            }

            return $this->response->setJSON(['status' => 'success', 'message' => $statusText . 'เรียบร้อยแล้ว']);
        }
        else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถดำเนินการได้']);
        }
    }

    public function CarBookingResetStatus()
    {
        $session = session();
        if (!$session->get('username')) {
            echo 0;
            return;
        }

        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');

        $data = array(
            'car_reserv_driver' => "",
            'car_reserv_status' => 'รอตรวจสอบ',
            'car_reserv_approver' => ""
        );

        $carbookingID = $this->request->getVar('carbookingID');
        $DBCarReservation->where('car_reserv_id', $carbookingID);

        if ($DBCarReservation->update($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'รีเซ็ตสถานะเรียบร้อยแล้ว']);
        }
        else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถดำเนินการได้']);
        }
    }

    public function CarBookingCancel()
    {
        $session = session();
        $database = \Config\Database::connect();
        $DBCarReservation = $database->table('tb_car_reservation');

        $id = $this->request->getVar('car_reserv_id');
        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบ ID การจอง']);
        }

        $data = [
            'car_reserv_status' => 'ยกเลิก'
        ];
        $DBCarReservation->where('car_reserv_id', $id);
        if ($DBCarReservation->update($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'ยกเลิกการจองเรียบร้อยแล้ว']);
        }
        else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถยกเลิกได้']);
        }
    }

    public function ShowTimeCarBooking()
    {
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
            ->join('skjacth_general.tb_school_car as car', 'car.car_ID = skjacth_general.tb_car_reservation.car_reserv_carID')
            ->join('skjacth_personnel.tb_personnel as p', 'p.pers_id = skjacth_general.tb_car_reservation.car_reserv_memberID', 'left')
            ->whereNotIn('car_reserv_status', ['ไม่อนุมัติ', 'ยกเลิก'])
            ->get()->getResult();

        $data = array();
        foreach ($S_data as $key => $value) {
            $startTime = trim($value->car_reserv_StartTime ?: '00:00:00');
            $endTime = trim($value->car_reserv_EndTime ?: '00:00:00');
            
            $start = $value->car_reserv_StartDate . ' ' . $startTime;
            $end = $value->car_reserv_EndDate . ' ' . $endTime;

            $data[] = [
                'id' => $value->car_reserv_id,
                'title' => $value->car_reserv_location,
                'start' => $start,
                'end' => $end,
                'approved' => trim($value->car_reserv_status),
                'car_id' => trim($value->car_reserv_carID),
                'member_id' => $value->car_reserv_memberID,
                'detail' => $value->car_reserv_detail,
                'color' => $this->getStatusColor($value->car_reserv_status),
                'car_info' => $value->car_category . ' ' . $value->car_registration . ' ' . $value->car_province,
                'location' => $value->car_reserv_location,
                'booker_name' => $value->pers_prefix . $value->pers_firstname . ' ' . $value->pers_lastname,
                'passenger' => $value->car_reserv_number
            ];
        }
        return $this->response->setJSON($data);
    }

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'รอตรวจสอบ':
                return '#ffab00';
            case 'อนุมัติ':
                return '#71dd37';
            case 'ไม่อนุมัติ':
                return '#ff3e1d';
            default:
                return '#fd7e14';
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

    public function CheckDateCarBooking()
    {
        // print_r($this->request->getVar());
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_car_reservation');
        $CarID = $this->request->getPost('car_reserv_carID');
        $dateStart = $this->request->getPost('car_reserv_StartDate');
        $timeStart = $this->request->getPost('car_reserv_StartTime');
        $dateEnd = $this->request->getPost('car_reserv_EndDate');
        $timeEnd = $this->request->getPost('car_reserv_EndTime');

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
        $gDateEnd = (strpos($dateEnd, '-') !== false) ? $dateEnd : $this->convertBuddhistToGregorian($dateEnd);

        $proposedStart = date('Y-m-d H:i:s', strtotime($gDateStart . ' ' . $timeStart));
        $proposedEnd = date('Y-m-d H:i:s', strtotime($gDateEnd . ' ' . $timeEnd));

        $excludeBookingId = $this->request->getPost('exclude_booking_id');

        $CheckDateCarBookign = $DBbooking
            ->where('car_reserv_carID', $CarID)
            ->where("TIMESTAMP(car_reserv_StartDate, car_reserv_StartTime) < '$proposedEnd'", null, false)
            ->where("TIMESTAMP(car_reserv_EndDate, car_reserv_EndTime) > '$proposedStart'", null, false)
            ->whereNotIn('car_reserv_status', ['ไม่อนุมัติ', 'ยกเลิก']);

        if ($excludeBookingId) {
            $CheckDateCarBookign->where('car_reserv_id !=', $excludeBookingId);
        }

        $CheckDateCarBookign = $CheckDateCarBookign->get()->getRow();

        if (!$CheckDateCarBookign) {
            return $this->response->setJSON([
                'status' => 1,
                'message' => '✔️สามารถทำการจองวันและเวลาที่เลือกได้',
                'class' => 'alert alert-success'
            ]);
        }
        else {
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
            $imageFile->move(ROOTPATH . 'uploads/User/dictation/', $newName);
            $data = [
                'dicta_year' => $this->request->getPost('dicta_year'),
                'dicta_number' => $this->request->getPost('dicta_number'),
                'dicta_createdate' => $this->request->getPost('dicta_createdate'),
                'dicta_title' => $this->request->getPost('dicta_title'),
                'dicta_file' => $newName
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

    public function DictationShowData()
    {

        $database = \Config\Database::connect();
        $builder = $database->table('tb_dictation');

        $DictationRecords = $builder->get()->getResult();
        $data = array();
        foreach ($DictationRecords as $row) {
            $data[] = array(
                "dicta_year" => $row->dicta_year,
                "dicta_number" => $row->dicta_number,
                "dicta_createdate" => $row->dicta_createdate,
                "dicta_title" => $row->dicta_title,
                "dicta_file" => $row->dicta_file
            );
        }

        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
    // echo '<pre>'; print_r($data);

    }

    public function CarBookingViewApproveAdmin()
    {
        $session = session();
        if (!$session->get('username') && $session->get('status') != "admin" && $session->get('status') != "manager" && $session->get('status') != "superadmin") {
            header("Location:" . base_url('LoginOfficerGeneral?return_to=' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
            exit();
        }
        $data = $this->DataMain();
        $data['title'] = "ดูข้อมูลจองยานพาหนะ (Admin)";
        $data['description'] = "ดูข้อมูลจองยานพาหนะ (Admin)";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingAdmin';
        $data['Datethai'] = new Datethai();

        $database = \Config\Database::connect();
        $DBCarDriver = $database->table('tb_car_driver');
        $DBpersonnel = $database->table('personnel');
        $DBpers = \Config\Database::connect('personnel');


        $data['CarDriver'] = $DBCarDriver->select('
            skjacth_general.tb_car_driver.cardriver_id,
            skjacth_personnel.tb_personnel.pers_prefix,
            skjacth_personnel.tb_personnel.pers_firstname,
            skjacth_personnel.tb_personnel.pers_lastname,
            skjacth_personnel.tb_personnel.pers_phone,
            skjacth_personnel.tb_personnel.pers_img,
            skjacth_personnel.tb_personnel.pers_id
        ')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = skjacth_general.tb_car_driver.cardriver_userID')
            ->get()->getResult();

        //echo '<pre>';print_r($data['CarDriver']); exit();

        return view('User/UserCarBooking/UserCarBookingViewAdmin', $data);
    }

    public function CarBookingViewApproveExecutive()
    {
        $session = session();
        $data = $this->DataMain();
        $data['title'] = "ดูข้อมูลจองห้องประชุมและสถานที่ (ผู้บริหาร)";
        $data['description'] = "ดูข้อมูลจองห้องประชุมและสถานที่ (ผู้บริหาร)";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingView';
        $data['Datethai'] = new Datethai();

        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');
        $DBpersonnel = $database->table('personnel');
        $DBpers = \Config\Database::connect('personnel');

        $data['CarBooking'] = $DBbooking->orderBy('booking_id', 'DESC')->get()->getResult();

        // echo '<pre>';print_r($data['CarBooking']); exit();

        return view('User/UserCarBooking/UserCarBookingViewExecutive', $data);
    }



    public function BookingCarChart()
    {
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

    public function CarBookingDataTableApproveExecutive()
    {
        $session = session();
        $Datethai = new Datethai();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $S_data = $DBbooking->select('booking_id,booking_order,booking_telephone,booking_Booker,booking_locationroom,booking_title,booking_dateStart,booking_dateEnd,booking_timeStart,booking_timeEnd,booking_admin_approve,booking_admin_reason,location_name,pers_prefix,pers_firstname,pers_lastname,booking_executive_approve,booking_executive_reason')
            ->join('tb_school_car', 'tb_booking.booking_locationroom = tb_school_car.location_ID')
            ->join('skjacth_personnel.tb_personnel', "skjacth_general.tb_booking.booking_Booker = skjacth_personnel.tb_personnel.pers_id")
            //->where('booking_admin_approve','อนุมัติ')
            ->get()->getResult();
        $data = array();
        foreach ($S_data as $key => $value) {
            $data[] = [
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
                'booker' => $value->pers_prefix . $value->pers_firstname . ' ' . $value->pers_lastname
            ];
        }

        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
    }

    public function CarBookingCheckApproveAdmin()
    {
        $session = session();
        $Datethai = new Datethai();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        if ($_SESSION['status'] === "ExecutiveGeneral") {
            $Approve = ['booking_executive_approve' => 'อนุมัติ', 'booking_executive_reason' => '', 'booking_executive_datecheck' => date("Y-m-d H:i:s"), 'booking_executive_check' => $_SESSION['id']];
        }
        elseif ($_SESSION['status'] === "AdminGeneral" || $_SESSION['status'] === "superadmin") {
            $Approve = ['booking_admin_approve' => 'อนุมัติ', 'booking_admin_reason' => '', 'booking_admin_datecheck' => date("Y-m-d H:i:s"), 'booking_admin_check' => $_SESSION['id']];
        }

        $upApprove = $DBbooking->where('booking_id', $this->request->getPost('CarBookingID'))
            ->update($Approve);
        if ($upApprove) {
            $email = \Config\Services::email(); // loading for use

            $email->setFrom('admin_booking@skj.ac.th', "ระบบการจองอาคารสถานที่");

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
                }
                else {
                    $data = $email->printDebugger(['headers']);
                    print_r($data);
                }
            }
            else {
                echo $this->request->getVar('booking_locationroom');
            }
        }


    }

    public function PrintApproveCarBooking($KeyCarBooking)
    {
        return $this->CarBookingPrint($KeyCarBooking);
    }

    // =========================================================================
    // ระบบคนขับรถ (Driver Portal)
    // =========================================================================

    public function CarBookingDriverPortal()
    {
        $session = session();
        $isLoggedIn = !empty($session->get('username'));
        $userId = $session->get('id') ?: '';
        $userStatus = $session->get('status') ?: '';
        $userRoles = json_decode($session->get('rloes') ?? '[]', true) ?: [];

        $database = \Config\Database::connect();

        // ตรวจสอบว่าผู้ใช้อยู่ในตารางคนขับรถหรือไม่
        $isRegisteredDriver = false;
        $isAdmin = false;

        if ($isLoggedIn && $userId) {
            $isRegisteredDriver = $database->table('tb_car_driver')->where('cardriver_userID', $userId)->countAllResults() > 0;
            // เป็น Admin ยานพาหนะ (และไม่ใช่คนขับรถ)
            $isAdmin = (in_array($userStatus, ['admin', 'manager', 'superadmin']) || in_array('งานยานพาหนะ', $userRoles)) && !$isRegisteredDriver;
        }

        // รายชื่อคนขับรถทั้งหมด (สำหรับฟิลเตอร์ของ Admin และการแสดงรายชื่อคนขับ)
        $allDrivers = $database->table('tb_car_driver')
            ->select('
                skjacth_general.tb_car_driver.cardriver_id,
                skjacth_general.tb_car_driver.cardriver_userID,
                p.pers_prefix, p.pers_firstname, p.pers_lastname, p.pers_phone, p.pers_img
            ')
            ->join('skjacth_personnel.tb_personnel AS p', 'p.pers_id = skjacth_general.tb_car_driver.cardriver_userID', 'left')
            ->get()->getResult();

        $data = $this->DataMain();
        $data['title'] = "คนขับรถ & ภารกิจการเดินทาง";
        $data['description'] = "ตรวจสอบรายชื่อคนขับรถและภารกิจการเดินทาง";
        $data['UrlMenuMain'] = 'CarBooking';
        $data['UrlMenuSub'] = 'CarBookingDriver';
        $data['Datethai'] = new Datethai();
        $data['isAdmin'] = $isAdmin;
        $data['isLoggedIn'] = $isLoggedIn;
        $data['isRegisteredDriver'] = $isRegisteredDriver;
        $data['currentUserId'] = $userId;
        $data['allDrivers'] = $allDrivers;

        return view('User/UserCarBooking/UserCarBookingDriver', $data);
    }

    public function CarBookingDriverGetTrips()
    {
        $session = session();
        $isLoggedIn = !empty($session->get('username'));
        $userId = $session->get('id') ?: '';
        $userStatus = $session->get('status') ?: '';
        $userRoles = json_decode($session->get('rloes') ?? '[]', true) ?: [];
        $database = \Config\Database::connect();

        $isRegisteredDriver = false;
        $isAdmin = false;
        if ($isLoggedIn && $userId) {
            $isRegisteredDriver = $database->table('tb_car_driver')->where('cardriver_userID', $userId)->countAllResults() > 0;
            $isAdmin = (in_array($userStatus, ['admin', 'manager', 'superadmin']) || in_array('งานยานพาหนะ', $userRoles)) && !$isRegisteredDriver;
        }

        $filterStatus = $this->request->getVar('status') ?: 'all'; // all, today, upcoming, completed
        $selectedDriver = $this->request->getVar('driver_id');

        $builder = $database->table('tb_car_reservation')
            ->select('
                tb_car_reservation.*,
                skjacth_general.tb_school_car.car_registration,
                skjacth_general.tb_school_car.car_province,
                skjacth_general.tb_school_car.car_category,
                skjacth_general.tb_school_car.car_brand,
                skjacth_general.tb_school_car.car_model,
                skjacth_general.tb_school_car.car_img,
                booker.pers_prefix AS req_prefix, booker.pers_firstname AS req_firstname, booker.pers_lastname AS req_lastname,
                booker.pers_phone AS req_phone,
                driver.pers_prefix AS drv_prefix, driver.pers_firstname AS drv_firstname, driver.pers_lastname AS drv_lastname,
                driver.pers_phone AS drv_phone,
                driver.pers_img AS drv_img,
                recorder.pers_prefix AS rec_prefix, recorder.pers_firstname AS rec_firstname, recorder.pers_lastname AS rec_lastname
            ')
            ->join('skjacth_general.tb_school_car', 'skjacth_general.tb_school_car.car_ID = tb_car_reservation.car_reserv_carID', 'left')
            ->join('skjacth_personnel.tb_personnel AS booker', 'booker.pers_id = tb_car_reservation.car_reserv_memberID', 'left')
            ->join('skjacth_personnel.tb_personnel AS driver', 'driver.pers_id = tb_car_reservation.car_reserv_driver', 'left')
            ->join('skjacth_personnel.tb_personnel AS recorder', 'recorder.pers_id = tb_car_reservation.mileage_recorded_by', 'left')
            ->where('tb_car_reservation.car_reserv_status', 'อนุมัติ');

        // กรองคนขับ:
        // ถ้าเป็นคนขับรถที่ล็อกอินอยู่ ให้ล็อกเฉพาะงานที่ตัวเองขับ
        if ($isRegisteredDriver) {
            $builder->where('tb_car_reservation.car_reserv_driver', $userId);
        } else {
            // กรณีเป็น Admin หรือผู้ใช้ทั่วไป/ยังไม่ได้ล็อกอิน: สามารถเลือกกรองตามคนขับ หรือดูทั้งหมดได้
            if (!empty($selectedDriver) && $selectedDriver !== 'all') {
                $builder->where('tb_car_reservation.car_reserv_driver', $selectedDriver);
            }
        }

        $today = date('Y-m-d');
        if ($filterStatus === 'today') {
            $builder->where('tb_car_reservation.car_reserv_StartDate <=', $today)
                    ->where('tb_car_reservation.car_reserv_EndDate >=', $today);
        } elseif ($filterStatus === 'upcoming') {
            $builder->where('tb_car_reservation.car_reserv_StartDate >', $today);
        } elseif ($filterStatus === 'completed') {
            $builder->groupStart()
                        ->where('tb_car_reservation.return_mileage >', 0)
                        ->orWhere('tb_car_reservation.car_reserv_EndDate <', $today)
                    ->groupEnd();
        }

        $trips = $builder->orderBy('tb_car_reservation.car_reserv_StartDate', 'DESC')
                         ->orderBy('tb_car_reservation.car_reserv_StartTime', 'DESC')
                         ->get()->getResult();

        $Datethai = new Datethai();

        $processed = [];
        $totalDistance = 0;
        $countToday = 0;
        $countUpcoming = 0;
        $countCompleted = 0;

        foreach ($trips as $t) {
            $sDate = $t->car_reserv_StartDate;
            $eDate = $t->car_reserv_EndDate;
            $depMile = (int)$t->departure_mileage;
            $retMile = (int)$t->return_mileage;
            $dist = ($retMile > 0 && $depMile > 0 && $retMile >= $depMile) ? ($retMile - $depMile) : 0;

            if ($dist > 0) {
                $totalDistance += $dist;
            }

            $isToday = ($sDate <= $today && $eDate >= $today);
            $isUpcoming = ($sDate > $today);
            $isFinished = ($retMile > 0 || $eDate < $today);

            if ($isToday) $countToday++;
            if ($isUpcoming) $countUpcoming++;
            if ($isFinished) $countCompleted++;

            $t->booker_fullname = trim(($t->req_prefix ?? '') . ($t->req_firstname ?? '') . ' ' . ($t->req_lastname ?? ''));
            $t->driver_fullname = trim(($t->drv_prefix ?? '') . ($t->drv_firstname ?? '') . ' ' . ($t->drv_lastname ?? ''));

            $recFullname = trim(($t->rec_prefix ?? '') . ($t->rec_firstname ?? '') . ' ' . ($t->rec_lastname ?? ''));
            $t->recorder_fullname = $recFullname ?: (!empty($t->mileage_recorded_by) ? 'เจ้าหน้าที่ (' . $t->mileage_recorded_by . ')' : '');
            $t->is_recorded_by_staff = !empty($t->mileage_recorded_by) && ($t->mileage_recorded_by !== $t->car_reserv_driver);
            $t->mileage_recorded_at_thai = !empty($t->mileage_recorded_at) ? $Datethai->thai_date_fullmonth(strtotime($t->mileage_recorded_at)) . ' ' . date('H:i', strtotime($t->mileage_recorded_at)) . ' น.' : '';

            $t->date_range_thai = $Datethai->thai_date_fullmonth(strtotime($sDate)) . ($sDate !== $eDate ? ' - ' . $Datethai->thai_date_fullmonth(strtotime($eDate)) : '');
            $t->time_range = substr($t->car_reserv_StartTime, 0, 5) . ' - ' . substr($t->car_reserv_EndTime, 0, 5) . ' น.';
            $t->distance_km = $dist;
            $t->is_today = $isToday;
            $t->is_upcoming = $isUpcoming;
            $t->is_finished = $isFinished;

            $processed[] = $t;
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $processed,
            'summary' => [
                'total_trips' => count($trips),
                'count_today' => $countToday,
                'count_upcoming' => $countUpcoming,
                'count_completed' => $countCompleted,
                'total_distance' => $totalDistance
            ]
        ]);
    }

    public function CarBookingDriverUpdateTrip()
    {
        $session = session();
        if (!$session->get('username')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาเข้าสู่ระบบ']);
        }

        $id = $this->request->getPost('car_reserv_id');
        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบรหัสการจอง']);
        }

        $database = \Config\Database::connect();
        $booking = $database->table('tb_car_reservation')->where('car_reserv_id', $id)->get()->getRow();
        if (!$booking) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลใบงาน']);
        }

        $userId = $session->get('id');
        $userStatus = $session->get('status');
        $userRoles = json_decode($session->get('rloes') ?? '[]', true) ?: [];
        $isAdmin = in_array($userStatus, ['admin', 'manager', 'superadmin']) || in_array('งานยานพาหนะ', $userRoles);

        // ตรวจสอบสิทธิ์ (ต้องเป็น Admin หรือคนขับที่ได้รับมอบหมาย)
        if (!$isAdmin && $booking->car_reserv_driver !== $userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ท่านไม่มีสิทธิ์บันทึกข้อมูลใบงานนี้']);
        }

        $departure_mileage = $this->request->getPost('departure_mileage');
        $return_mileage = $this->request->getPost('return_mileage');
        $fuel_po_book = $this->request->getPost('fuel_po_book');
        $fuel_po_number = $this->request->getPost('fuel_po_number');
        $fuel_po_date = $this->request->getPost('fuel_po_date');

        if ($departure_mileage !== null && $departure_mileage !== '' && !is_numeric($departure_mileage)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เลขไมล์ออกเดินทางต้องเป็นตัวเลข']);
        }

        if ($return_mileage !== null && $return_mileage !== '' && !is_numeric($return_mileage)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เลขไมล์เมื่อกลับถึงต้องเป็นตัวเลข']);
        }

        if ($departure_mileage !== '' && $return_mileage !== '' && $departure_mileage !== null && $return_mileage !== null) {
            if ((int)$return_mileage < (int)$departure_mileage) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เลขไมล์กลับถึงสำนักงานต้องไม่น้อยกว่าเลขไมล์ออกเดินทาง']);
            }
        }

        $fuel_request = $this->request->getPost('fuel_request') ?: 'no';
        $fuel_type_post = $this->request->getPost('fuel_type');
        $fuel_other_desc = $this->request->getPost('fuel_other_desc');
        $fuel_amount = $this->request->getPost('fuel_amount');

        $final_fuel_type = null;
        if ($fuel_request === 'yes') {
            $final_fuel_type = ($fuel_type_post === 'อื่นๆ') ? trim($fuel_other_desc ?? '') : trim($fuel_type_post ?? '');
        }

        $updateData = [
            'departure_mileage'   => ($departure_mileage !== '' && $departure_mileage !== null) ? (int)$departure_mileage : null,
            'return_mileage'      => ($return_mileage !== '' && $return_mileage !== null) ? (int)$return_mileage : null,
            'fuel_request'        => $fuel_request,
            'fuel_type'           => $final_fuel_type ?: null,
            'fuel_amount'         => ($fuel_request === 'yes' && $fuel_amount !== '' && $fuel_amount !== null) ? (float)$fuel_amount : null,
            'fuel_po_book'        => trim($fuel_po_book ?? '') ?: null,
            'fuel_po_number'      => trim($fuel_po_number ?? '') ?: null,
            'fuel_po_date'        => trim($fuel_po_date ?? '') ?: null,
            'mileage_recorded_by' => $userId,
            'mileage_recorded_at' => date('Y-m-d H:i:s'),
        ];

        $database->table('tb_car_reservation')->where('car_reserv_id', $id)->update($updateData);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'บันทึกข้อมูลการเดินทาง เลขไมล์ และการใช้น้ำมันเรียบร้อยแล้ว'
        ]);
    }

}