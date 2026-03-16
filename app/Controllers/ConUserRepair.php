<?php

namespace App\Controllers;
use App\Libraries\Datethai;
use CodeIgniter\Files\File;

// error_reporting(-1);
// ini_set('display_errors', 1);

class ConUserRepair extends BaseController
{  

    function __construct(){
       
    }

    /**
     * ดึง Email ของเจ้าหน้าที่ตามชื่องาน (หัวหน้า + เจ้าหน้าที่)
     * @param string $departmentName ชื่องาน เช่น "งานแจ้งซ่อม", "งานอาคารสถานที่"
     * @return array รายชื่อ Email
     */
    private function getStaffEmailsByDepartment($departmentName)
    {
        $database = \Config\Database::connect();
        $DBpers = \Config\Database::connect('personnel');
        
        // ดึง user_id ของเจ้าหน้าที่ในงานที่ระบุ
        $staffIds = $database->table('tb_admin_rloes')
            ->select('admin_rloes_userid')
            ->where('admin_rloes_nanetype', $departmentName)
            ->where('admin_rloes_userid !=', '') // ไม่เอาแถวที่ยังไม่มีคนรับผิดชอบ
            ->get()
            ->getResult();
        
        if (empty($staffIds)) {
            return [];
        }
        
        // ดึง Email (pers_username) ของแต่ละคน
        $emails = [];
        foreach ($staffIds as $staff) {
            $person = $DBpers->table('tb_personnel')
                ->select('pers_username')
                ->where('pers_id', $staff->admin_rloes_userid)
                ->where('pers_status', 'กำลังใช้งาน')
                ->get()
                ->getRow();
            
            if ($person && !empty($person->pers_username)) {
                $emails[] = $person->pers_username;
            }
        }
        
        return array_unique($emails); // ลบ Email ซ้ำ
    }

    /**
     * ดึงข้อมูลบุคลากรจาก pers_id
     * @param string $persId รหัสบุคลากร
     * @return object|null ข้อมูลบุคลากร
     */
    private function getPersonnelInfo($persId)
    {
        $DBpers = \Config\Database::connect('personnel');
        return $DBpers->table('tb_personnel')
            ->select('pers_prefix, pers_firstname, pers_lastname, pers_username')
            ->where('pers_id', $persId)
            ->get()
            ->getRow();
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
        $data['title']="ระบบงานแจ้งซ่อมออนไลน์";
        $data['description']="หน้าแรกระบบงานแจ้งซ่อมออนไลน์";
        $data['UrlMenuMain'] = 'Repair';
        $data['UrlMenuSub'] = '';
        $data['Datethai'] = new Datethai();

        $data['DictationAll'] = $builder->countAll();
        
        // Year Filter
        $year = $this->request->getVar('year') ?? date('Y');
        $data['selectedYear'] = $year;
        // Generate year range (current - 2 to current + 1)
        $currentYear = date('Y');
        $data['years'] = range($currentYear - 2, $currentYear + 1);

        $TBrepair = $database->table('tb_repair');
        $data['TotalRepair'] = $TBrepair->where("YEAR(repair_datetime)", $year)->countAllResults();
        $data['StatusPending'] = $TBrepair->where('repair_status', 'รอดำเนินการ')->where("YEAR(repair_datetime)", $year)->countAllResults();
        $data['StatusProcess'] = $TBrepair->where('repair_status', 'กำลังดำเนินการ')->where("YEAR(repair_datetime)", $year)->countAllResults();
        $data['StatusSuccess'] = $TBrepair->where('repair_status', 'ดำเนินการเรียบร้อย')->where("YEAR(repair_datetime)", $year)->countAllResults();    
        $data['StatusCancel'] = $TBrepair->where('repair_status', 'ยกเลิก')->where("YEAR(repair_datetime)", $year)->countAllResults();

        return view('User/UserRepair/UserRepairMain', $data);
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

       // Math Captcha Generation
       $data['num1'] = rand(1, 9);
       $data['num2'] = rand(1, 9);
       session()->set('captcha_answer', $data['num1'] + $data['num2']);


        return view('User/UserRepair/UserRepairAdd', $data);
    } 


    public function CheckPosiUser(){
        $DBpers = \Config\Database::connect('personnel');
        $TBPres = $DBpers->table('tb_personnel');

        $this->request->getVar('repair_posi');
        $data = $TBPres->select('pers_id,pers_prefix,pers_firstname,pers_lastname,pers_phone')
        ->where('pers_position',$this->request->getVar('repair_posi'))
        ->where('pers_status','กำลังใช้งาน')
        ->get()->getResult();
        
        echo json_encode($data);
    }

    private function sendLineMessage($userId, $messageText)
    {
        // ไม่ส่งถ้าไม่ใช่ production หรือเป็น localhost
        if (ENVIRONMENT !== 'production' || in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1'])) {
            return null;
        }
        $accessToken = '7gfC9gYjR4S/xRSGeqlOuXo9ZVR5TSvyAUSdgDRMDn4los6yawPmupV+iq47du3cwHjMYzG9SeWz97kGTGsNm+tVww6pHgHQNk7xA3HNHUatjywK/0Pfq98hW5EmM0Xg9PpGHcRZ3zpnQ7evs8yYWwdB04t89/1O/w1cDnyilFU=';

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


    public function RepairInsert(){

        // var_dump($_POST);
        // var_dump($_FILES);
        // exit;

        $DBrepair = \Config\Database::connect();
        $TBrepair = $DBrepair->table('tb_repair');
        $Datethai = new Datethai();
        

        // Math Captcha Verification
        $captchaInput = $this->request->getPost('captcha_input');
        $captchaSession = session()->get('captcha_answer');

        if (empty($captchaInput) || $captchaInput != $captchaSession) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ผลลัพธ์การบวกเลขไม่ถูกต้อง กรุณาลองใหม่ (' . $captchaInput . ' vs ' . $captchaSession . ')'
            ]);
        }
        
        // Clear captcha session after use (optional, but good for security)
        // session()->remove('captcha_answer');
       
      

            $data = $TBrepair->select('repair_order')->orderBy('repair_ID ','DESC')->get()->getResult();
            if(!empty($data)){
            $sub = explode('_',$data[0]->repair_order);             
                $OrderNumber = $sub[0].'_'.sprintf("%08d",$sub[1]+1);
            }else{
                $OrderNumber = "SKJRP_".date('Y')."0001";
            }
            $DateTimeToday = date('Y-m-d H:i:s');
            
            $image = $this->request->getFile('repair_imguser');

            if (!empty($image) && $image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                $image->move(ROOTPATH . 'uploads/admin/Repair/User/', $newName);
        
                $this->resizeImage('uploads/admin/Repair/User/' . $newName, 2048, 1024);
            }

            $dataInsert = [
                'repair_order' => $OrderNumber,
                'repair_datetime' => $DateTimeToday,
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
                'repair_imguser' => isset($newName) ? $newName : "",
                'repair_usersignature' => $this->request->getPost('Signature') // เก็บเป็น PNG Base64
            ];
            if($TBrepair->insert($dataInsert)){
                $DBpers = \Config\Database::connect('personnel');
                $TBPres = $DBpers->table('tb_personnel');

                $Repair = $TBrepair->select('repair_order')
                ->orderBy('repair_order',"DESC")
                ->limit(1)
                ->get()->getRow();

                // ดึงข้อมูลผู้แจ้งเพื่อใช้ใน Email/Line
                $Requester = $TBPres->select('pers_prefix,pers_firstname,pers_lastname,pers_username')
                    ->where('pers_id', $this->request->getVar('repair_userID'))
                    ->get()->getRow();
                $RequesterName = $Requester ? $Requester->pers_prefix.$Requester->pers_firstname.' '.$Requester->pers_lastname : 'ไม่ระบุ';
                $RequesterEmail = ($Requester && !empty($Requester->pers_username)) ? $Requester->pers_username : 'noreply@skj.ac.th';
                
                // 2. สร้างข้อความ
                $msg = "🛠️ มีงานแจ้งซ่อมมาใหม่\n";
                $msg .= "📌 ประเภท: {$this->request->getVar('repair_caselist')}\n";
                $msg .= "📍 สถานที่: {$this->request->getVar('repair_building')} ชั้น {$this->request->getVar('repair_class')} ห้อง {$this->request->getVar('repair_room')}\n";
                $msg .= "📝 รายละเอียด: {$this->request->getVar('repair_detail')}\n";
                $msg .= "👤 ผู้แจ้ง: {$RequesterName}\n";
                $msg .= "📅 วันที่แจ้ง: {$Datethai->thai_date_fullmonth(strtotime(date('Y-m-d H:i:s')))}\n";
                $msg .= "👉 รับงาน: " . base_url("/Repair/View/".$Repair->repair_order);

                // ไม่ส่งแจ้งเตือนถ้าเป็น development environment หรือเป็น localhost
                if (ENVIRONMENT === 'production' && !in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1'])) {
                    // 3. ส่งข้อความ Line (ใช้ userId หรือ groupId ของช่าง)
                    $this->sendLineMessage('C17a681261a4c021435e323ffc81cedea', $msg);

                    // 4. ส่ง Email - ดึงรายชื่อจากตาราง tb_admin_rloes
                    if($this->request->getVar('repair_caselist') == "งานอาคารสถานที่"){
                        // ส่งไปที่หัวหน้าและเจ้าหน้าที่งานอาคารสถานที่
                        $MailAdmin = $this->getStaffEmailsByDepartment('งานอาคารสถานที่');
                    }else{
                        // ส่งไปที่หัวหน้าและเจ้าหน้าที่งานแจ้งซ่อม
                        $MailAdmin = $this->getStaffEmailsByDepartment('งานแจ้งซ่อม');
                    }
                    
                    // ถ้าไม่พบ Email จาก roles ให้ใช้ fallback
                    if (empty($MailAdmin)) {
                        $MailAdmin = ['dekpiano@skj.ac.th'];
                    }
                    
                    $email = \Config\Services::email();
                    // ผู้ส่งคือผู้แจ้งซ่อม
                    $email->setFrom($RequesterEmail, $RequesterName . ' (แจ้งซ่อมผ่านระบบ)');
                    $email->setTo($MailAdmin);
                    $email->setSubject('[แจ้งซ่อม] ' . $this->request->getVar('repair_caselist') . ' - ' . $RequesterName);

                    // กำหนดข้อความในรูปแบบ HTML
                    $htmlMessage = '<h4>📧 แจ้งซ่อมใหม่จากระบบ</h4>';
                    $htmlMessage .= '<hr>';
                    $htmlMessage .= '<p><strong>ใบแจ้งซ่อม:</strong> '.$OrderNumber.'</p>';
                    $htmlMessage .= '<p><strong>วันที่แจ้งซ่อม:</strong> '.$Datethai->thai_date_and_time(strtotime($DateTimeToday)).'</p>';
                    $htmlMessage .= '<p><strong>ผู้แจ้งซ่อม:</strong> '.$RequesterName.'</p>';
                    $htmlMessage .= '<p><strong>เบอร์โทรติดต่อ:</strong> '.$this->request->getVar('repair_phone').'</p>';
                    $htmlMessage .= '<hr>';
                    $htmlMessage .= '<p><strong>รายการแจ้งซ่อม:</strong> '.$this->request->getVar('repair_caselist').'</p>';
                    $htmlMessage .= '<p><strong>รายละเอียด:</strong> '.$this->request->getVar('repair_detail').'</p>';
                    $htmlMessage .= '<p><strong>สถานที่:</strong> อาคาร '.$this->request->getVar('repair_building').' ชั้น '.$this->request->getVar('repair_class').' ห้อง '.$this->request->getVar('repair_room').'</p>';
                    $htmlMessage .= '<hr>';
                    $htmlMessage .= '<p><a href="'.base_url('Repair/View/'.$OrderNumber).'" style="background: #696cff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">👉 ดูรายละเอียดและรับงาน</a></p>';

                    $email->setMessage($htmlMessage);
                    $email->setMailType('html');

                    $email->send();
                }

                return $this->response->setJSON([
                    'status' => 'success', 
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                    'repair_order' => $OrderNumber
                ]);
                
            }else{
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'ไม่สามารถบันทึกข้อมูลลงฐานข้อมูลได้'
                ]);
            }
       
    }

    public function DataTableShowRepari(){
        $session = session();
        $DBrepair = \Config\Database::connect();
        $TBrepair = $DBrepair->table('tb_repair');
        $DBpers = \Config\Database::connect('personnel');
        $TBPres = $DBpers->table('tb_personnel');
        $Datethai = new Datethai();

       $year = $this->request->getVar('year') ?? date('Y');

       $S_data = $TBrepair->select('
       repair_ID,repair_order,repair_datetime,repair_userID,repair_phone,repair_caselist,repair_status,pers_prefix,pers_firstname,pers_lastname
       ')
       ->join('skjacth_personnel.tb_personnel','tb_repair.repair_userID = tb_personnel.pers_id')
       ->where("YEAR(repair_datetime)", $year) // Filter by year
       ->orderBy('repair_order', 'DESC')
       ->get()->getResult();

       $data = array();
       foreach ($S_data as $row) {
           $data[] = array(
                "repair_ID"=>$row->repair_ID,
              "repair_order"=>$row->repair_order,
              "repair_datetime"=>$Datethai->thai_date_fullmonth(strtotime($row->repair_datetime)),
              "repair_userID"=>$row->repair_userID,
              "repair_caselist"=>$row->repair_caselist,
              "repair_status"=>$row->repair_status,
              'UserFullname'=>$row->pers_prefix.$row->pers_firstname.' '.$row->pers_lastname
           );
        }

        $response = array(           
           "aaData" => $data,
           "data" => $data
        );
        echo json_encode($response);
    }

    public function ViewOrder($IDorder){
        $session = session();
        $data = $this->DataMain();
        $data['title'] = "รายละเอียดการแจ้งซ่อม";
        $data['description']="รายละเอียดการแจ้งซ่อม";
        $data['UrlMenuMain'] = 'Repair';
        $data['UrlMenuSub'] = 'ViewOrder';
        $data['Datethai'] = new Datethai();

        $DBrepair = \Config\Database::connect();
        $TBrepair = $DBrepair->table('tb_repair');
        $DBpers = \Config\Database::connect('personnel');
        $TBpers = $DBpers->table('tb_personnel');

        $data['RepaiUser'] = $TBrepair->select('tb_repair.*,tb_position.posi_name,tb_personnel.pers_prefix,tb_personnel.pers_firstname,tb_personnel.pers_lastname')
        ->where('repair_order',$IDorder)
        ->join('skjacth_personnel.tb_personnel','tb_repair.repair_userID = tb_personnel.pers_id')
        ->join('skjacth_skj.tb_position','tb_repair.repair_posi = tb_position.posi_id')
        ->get()->getResult();

        $data['Repairman'] = $TBpers->select("CONCAT(pers_prefix,pers_firstname,' ',pers_lastname) AS Repairman")
            ->where('pers_id',$data['RepaiUser'][0]->repair_Repairman)
            ->get()->getResult();

        $data['Order'] = array_merge($data['RepaiUser'],$data['Repairman']);

        //echo "<pre>"; print_r($data['Order']); exit();
        
        return view('User/UserRepair/UserRepairView', $data);

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
        try {
            $DBrepair = \Config\Database::connect();
            $TBrepair = $DBrepair->table('tb_repair');
            $Datethai = new Datethai();       
            $image = $this->request->getFile('repair_imgwork');
            
            $imgWorkPost = $this->request->getVar('imgwork');
            if (!empty($imgWorkPost)) {
                $filePath = ROOTPATH .'uploads/admin/Repair/'.$imgWorkPost;
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

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
                    'repair_adminsignature' => $this->request->getPost('Signature') // เก็บเป็น PNG Base64
                ];
            } else {
                $data = [
                    'repair_status' => $this->request->getPost('repair_status'),
                    'repair_datework' => $this->request->getPost('repair_datework'),
                    'repair_Repairman' => $this->request->getPost('repair_Repairman'),
                    'repair_cause' => $this->request->getPost('repair_cause'),
                    'repair_adminsignature' => $this->request->getPost('Signature') // เก็บเป็น PNG Base64
                ];
            }

            if ($TBrepair->where('repair_order', $this->request->getPost('repair_order'))->update($data)) {
                 // ไม่ส่งแจ้งเตือนถ้าไม่ใช่ production หรือเป็น localhost
                 $host = explode(':', $_SERVER['HTTP_HOST'])[0];
                 if (ENVIRONMENT === 'production' && !in_array($host, ['localhost', '127.0.0.1'])) {
                    $DBpers = \Config\Database::connect('personnel');
                    $TBpers = $DBpers->table('tb_personnel');
                    
                    $RepairInfo = $DBrepair->table('tb_repair')
                        ->select('repair_userID, repair_order, repair_caselist, repair_detail, repair_building, repair_class, repair_room')
                        ->where('repair_order', $this->request->getPost('repair_order'))
                        ->get()->getRow();

                    if ($RepairInfo) {
                        $Requester = $TBpers->select('pers_username, pers_prefix, pers_firstname, pers_lastname')
                            ->where('pers_id', $RepairInfo->repair_userID)
                            ->get()->getRow();

                        if ($Requester && !empty($Requester->pers_username)) {
                             $RequesterName = $Requester->pers_prefix . $Requester->pers_firstname . ' ' . $Requester->pers_lastname;
                             $currentStatus = $this->request->getPost('repair_status');
                             
                             // ดึงข้อมูลเจ้าหน้าที่รับงาน (ผู้ส่ง Email)
                             $repairmanId = $this->request->getPost('repair_Repairman');
                             $Repairman = $TBpers->select('pers_prefix, pers_firstname, pers_lastname, pers_username')
                                 ->where('pers_id', $repairmanId)
                                 ->get()->getRow();
                             
                             $RepairmanName = $Repairman ? $Repairman->pers_prefix . $Repairman->pers_firstname . ' ' . $Repairman->pers_lastname : 'เจ้าหน้าที่ซ่อม';
                             $RepairmanEmail = ($Repairman && !empty($Repairman->pers_username)) ? $Repairman->pers_username : 'noreply@skj.ac.th';
                             
                             try {
                                 $email = \Config\Services::email();
                                 // ผู้ส่งคือเจ้าหน้าที่รับงาน
                                 $email->setFrom($RepairmanEmail, $RepairmanName . ' (งานแจ้งซ่อม)');
                                 $email->setTo($Requester->pers_username);
                                 $email->setSubject('[อัปเดตสถานะ] ' . $RepairInfo->repair_caselist . ' - ' . $currentStatus);

                                 $htmlMessage = '<h4>📧 แจ้งอัปเดตสถานะการซ่อม</h4>';
                                 $htmlMessage .= '<p>เรียน ' . $RequesterName . '</p>';
                                 $htmlMessage .= '<p>รายการแจ้งซ่อมของท่านมีการอัปเดตสถานะเป็น: <strong style="color: #696cff;">' . $currentStatus . '</strong></p>';
                                 $htmlMessage .= '<hr>';
                                 $htmlMessage .= '<p><strong>เลขที่ใบแจ้งซ่อม:</strong> ' . $RepairInfo->repair_order . '</p>';
                                 $htmlMessage .= '<p><strong>รายการ:</strong> ' . $RepairInfo->repair_caselist . '</p>';
                                 $htmlMessage .= '<p><strong>รายละเอียดปัญหา:</strong> ' . $RepairInfo->repair_detail . '</p>';
                                 $htmlMessage .= '<p><strong>สถานที่:</strong> ' . $RepairInfo->repair_building . ' ชั้น ' . $RepairInfo->repair_class . ' ห้อง ' . $RepairInfo->repair_room . '</p>';
                                 
                                 if(!empty($this->request->getPost('repair_cause'))) {
                                    $htmlMessage .= '<p><strong>บันทึกจากเจ้าหน้าที่:</strong> ' . $this->request->getPost('repair_cause') . '</p>';
                                 }
                                 
                                 $htmlMessage .= '<hr>';
                                 $htmlMessage .= '<p><strong>ผู้ดำเนินการ:</strong> ' . $RepairmanName . '</p>';
                                 $htmlMessage .= '<p><strong>วันที่อัปเดต:</strong> ' . $Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s'))) . '</p>';
                                 $htmlMessage .= '<hr>';
                                 $htmlMessage .= '<p><a href="' . base_url('Repair/View/' . $RepairInfo->repair_order) . '" style="background: #696cff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">👉 ดูรายละเอียด</a></p>';

                                 $email->setMessage($htmlMessage);
                                 $email->setMailType('html');
                                 $email->send();
                             } catch (\Exception $e) {
                                 log_message('error', 'Repair Email Error: ' . $e->getMessage());
                             }
                        }
                    }
                 }
                 return $this->response->setJSON([
                     'status' => 'success',
                     'message' => 'บันทึกข้อมูลการซ่อมและส่งการแจ้งเตือนเรียบร้อยแล้ว'
                 ]);
            } else {
                 return $this->response->setJSON([
                     'status' => 'error',
                     'message' => 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง'
                 ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'RepairUpdateWork Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดภายในระบบ: ' . $e->getMessage()
            ]);
        }
    }

    public function CleanupImages()
    {
        // Check permissions (Admin only)
        $session = session();
        $checkRloes = explode(",", @$_SESSION['rloes']);
        if (empty($_SESSION['username']) || (!in_array("งานแจ้งซ่อม", $checkRloes) && !in_array("งานอาคารสถานที่", $checkRloes))) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์เข้าถึงฟังก์ชันนี้']);
        }

        $db = \Config\Database::connect();
        $tbrepair = $db->table('tb_repair');
        
        $repairData = $tbrepair->select('repair_imguser, repair_imgwork')->get()->getResult();
        
        $usedImages = [];
        foreach ($repairData as $row) {
            if (!empty($row->repair_imguser)) $usedImages[] = $row->repair_imguser;
            if (!empty($row->repair_imgwork)) $usedImages[] = $row->repair_imgwork;
        }
        
        $paths = [
            'uploads/admin/Repair/' => 'repair_imgwork',
            'uploads/admin/Repair/User/' => 'repair_imguser'
        ];
        
        $deletedCount = 0;
        $deletedFiles = [];

        foreach ($paths as $relPath => $type) {
            $absPath = ROOTPATH . $relPath;
            if (is_dir($absPath)) {
                $files = array_diff(scandir($absPath), array('.', '..', 'index.html', '.htaccess'));
                foreach ($files as $file) {
                    if (is_file($absPath . $file) && !in_array($file, $usedImages)) {
                        // Check if it's an image
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                            if (@unlink($absPath . $file)) {
                                $deletedCount++;
                                $deletedFiles[] = $relPath . $file;
                            }
                        }
                    }
                }
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => "ล้างไฟล์ขยะเรียบร้อยแล้ว จำนวน {$deletedCount} ไฟล์",
            'deletedCount' => $deletedCount
        ]);
    }

    private function resizeImage($path, $width, $height)
    {
        try {
            $image = \Config\Services::image()
                ->withFile(ROOTPATH . $path)
                ->resize($width, $height, true)
                ->save(ROOTPATH . $path);
        } catch (\Exception $e) {
            // หากไม่มี GD หรือประมวลผลรูปไม่ได้ ให้ข้ามการ Resize ไปเพื่อให้ระบบยังทำงานต่อได้
            log_message('error', 'Image Resizing Error: ' . $e->getMessage());
        }
    }

    
    public function PrintOrder($RepairId){
        require SHARED_LIB_PATH . '/mpdf/vendor/autoload.php';

        $DBrepair = \Config\Database::connect();
        $TBrepair = $DBrepair->table('tb_repair');
        $DBpers = \Config\Database::connect('personnel');
        $TBpers = $DBpers->table('tb_personnel');
        $data['Datethai'] = new Datethai();

        $data['RepairUser'] = $TBrepair->select('tb_repair.*,tb_position.posi_name,tb_personnel.pers_prefix,tb_personnel.pers_firstname,tb_personnel.pers_lastname')        
        ->join('skjacth_personnel.tb_personnel','tb_repair.repair_userID = tb_personnel.pers_id')
        ->join('skjacth_skj.tb_position','tb_repair.repair_posi = tb_position.posi_id')
        ->where('repair_order', urldecode($RepairId))
        ->get()->getResult();

        if($data['RepairUser'][0]->repair_Repairman != ''){
            $data['Repairman'] = $TBpers->select('pers_prefix,pers_firstname,pers_lastname')
            ->where('pers_id',$data['RepairUser'][0]->repair_Repairman)
            ->get()->getResult();
           
        }else{
            $data['Repairman'] = 'pers_prefix,pers_firstname,pers_lastname';
        }

       
        $mpdf = new \Mpdf\Mpdf(
            array(
                'format' => 'A4',
                'mode' => 'utf-8',
                'default_font' => 'thsarabun',
                'default_font_size' => 16,
                'margin_top' => 5, // ให้ header ชิดบนสุด
                'margin_bottom' => 40, // ปรับให้กระชับขึ้นเพื่อให้เนื้อหาด้านบนขยายได้อีก
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_footer' => 5 // ให้ footer อยู่ต่ำเกือบสุด (5mm จากขอบล่าง)
            )
        );

        
       
        // ย้ายการจัดการ Footer ไปไว้ใน View เพื่อให้ signatures อยู่ล่างสุดเสมอร่วมกับ footer text
       
        $html = view('User/UserRepair/UserRepairPrintOrder',$data);
         // เพิ่ม HTML เข้าไปใน PDF
         $mpdf->WriteHTML($html);
 
         // สร้างไฟล์ PDF
         $this->response->setHeader('Content-Type', 'application/pdf');

         $mpdf->Output('example.pdf', 'I');
    
    }

    public function RepairBuildingMemo()
    {
        $session = session();
        $DBskj = \Config\Database::connect('skj');
        $Skj = $DBskj->table('tb_position');

        $data = $this->DataMain();
        $data['title']="บันทึกข้อความ (งานอาคารสถานที่)";
        $data['description']="สร้างบันทึกข้อความราชการเพื่อขอซ่อมแซมอาคารสถานที่";
        $data['UrlMenuMain'] = 'Repair';
        $data['UrlMenuSub'] = '';

        $data['Posi'] = $Skj->get()->getResult();
        $data['Datethai'] = new Datethai();

        $order = $this->request->getVar('order');
        $data['repair_order'] = $order;
        $data['memo_data_db'] = null;
        $data['repair_info'] = null;
        
        $db = \Config\Database::connect();
        if ($order) {
            if ($db->tableExists('tb_repair_memo')) {
                $memo_data = $db->table('tb_repair_memo')->where('repair_order', $order)->get()->getRowArray();
                if ($memo_data) {
                    $data['memo_data_db'] = $memo_data;
                }
            }
            if (!$data['memo_data_db']) {
                $repair_info = $db->table('tb_repair')->where('repair_order', $order)->get()->getRowArray();
                if ($repair_info) {
                    $data['repair_info'] = $repair_info;
                    $DBpers = \Config\Database::connect('personnel');
                    $pers = $DBpers->table('tb_personnel')->where('pers_id', $repair_info['repair_userID'])->get()->getRowArray();
                    if ($pers) {
                        $data['repair_pers'] = $pers;
                    }
                }
            }
        }

        return view('User/UserRepair/UserRepairBuildingMemo', $data);
    }

    public function RepairBuildingMemoPrint()
    {
        require SHARED_LIB_PATH . '/mpdf/vendor/autoload.php';
        
        $data['Datethai'] = new Datethai();
        $data['memo_data'] = $this->request->getPost();
        
        // Find position name based on position ID selected
        if (!empty($data['memo_data']['memo_posi'])) {
            $DBskj = \Config\Database::connect('skj');
            $posiRecord = $DBskj->table('tb_position')->where('posi_id', $data['memo_data']['memo_posi'])->get()->getRow();
            if ($posiRecord) {
                $data['memo_data']['memo_posi'] = $posiRecord->posi_name;
            }
        }

        // Handle Images
        $image1 = $this->request->getFile('memo_image1');
        $image2 = $this->request->getFile('memo_image2');
        
        $data['img1'] = "";
        $data['img2'] = "";

        // Ensure directory exists
        if (!is_dir(ROOTPATH . 'uploads/admin/Repair/Memo/')) {
            mkdir(ROOTPATH . 'uploads/admin/Repair/Memo/', 0777, true);
        }

        if (!empty($image1) && $image1->isValid() && !$image1->hasMoved()) {
            $newName = $image1->getRandomName();
            $image1->move(ROOTPATH . 'uploads/admin/Repair/Memo/', $newName);
            $data['img1'] = 'uploads/admin/Repair/Memo/' . $newName;
        }
        
        if (!empty($image2) && $image2->isValid() && !$image2->hasMoved()) {
            $newName2 = $image2->getRandomName();
            $image2->move(ROOTPATH . 'uploads/admin/Repair/Memo/', $newName2);
            $data['img2'] = 'uploads/admin/Repair/Memo/' . $newName2;
        }

        $db = \Config\Database::connect();
        
        // 1. Create table if not exists
        if (!$db->tableExists('tb_repair_memo')) {
            $forge = \Config\Database::forge();
            $forge->addField([
                'memo_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'repair_order' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                    'unique'     => true,
                ],
                'memo_agency' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'memo_no' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'memo_date' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'memo_subject' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'memo_to' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'memo_location' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'memo_reason' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                'memo_budget' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'memo_fullname' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'memo_posi' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'memo_img1' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'memo_img2' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
                'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            ]);
            $forge->addKey('memo_id', true);
            $forge->createTable('tb_repair_memo');
        }

        // 2. Prepare data for DB
        $repair_order = $this->request->getPost('repair_order');
        if ($repair_order) {
            $dbData = [
                'memo_agency' => $data['memo_data']['memo_agency'] ?? null,
                'memo_no' => $data['memo_data']['memo_no'] ?? null,
                'memo_date' => $data['memo_data']['memo_date'] ?? null,
                'memo_subject' => $data['memo_data']['memo_subject'] ?? null,
                'memo_to' => $data['memo_data']['memo_to'] ?? null,
                'memo_location' => $data['memo_data']['memo_location'] ?? null,
                'memo_reason' => $data['memo_data']['memo_reason'] ?? null,
                'memo_budget' => $data['memo_data']['memo_budget'] ?? null,
                'memo_fullname' => $data['memo_data']['memo_fullname'] ?? null,
                'memo_posi' => $data['memo_data']['memo_posi'] ?? null,
            ];

            $existing = $db->table('tb_repair_memo')->where('repair_order', $repair_order)->get()->getRow();
            
            // For images: if new image is uploaded, use it. Otherwise, if updating, retain old image for DB and PDF generating.
            if (!empty($data['img1'])) {
                $dbData['memo_img1'] = $data['img1'];
            } elseif ($existing && !empty($existing->memo_img1)) {
                $data['img1'] = $existing->memo_img1; // Retain in PDF
            }
            
            if (!empty($data['img2'])) {
                $dbData['memo_img2'] = $data['img2'];
            } elseif ($existing && !empty($existing->memo_img2)) {
                $data['img2'] = $existing->memo_img2; // Retain in PDF
            }

            if ($existing) {
                // Update
                $db->table('tb_repair_memo')->where('repair_order', $repair_order)->update($dbData);
            } else {
                // Insert
                $dbData['repair_order'] = $repair_order;
                $db->table('tb_repair_memo')->insert($dbData);
            }
        }

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'mode' => 'utf-8',
            'default_font' => 'thsarabun',
            'default_font_size' => 16,
            'margin_top' => 15, // 1.5 cm from top edge for Garuda
            'margin_bottom' => 15,
            'margin_left' => 30, // 3 cm
            'margin_right' => 20, // 2 cm
        ]);

        $html = view('User/UserRepair/UserRepairBuildingMemoPrint', $data);
        $mpdf->WriteHTML($html);
        
        return $this->response->setHeader('Content-Type', 'application/pdf')->setBody($mpdf->Output('memo_building.pdf', 'I'));
    }

    public function RepairStatistics(){
        $session = session();
        $data = $this->DataMain();
        $data['title']="สถิติการแจ้งซ่อม";
        $data['description']="สถิติการแจ้งซ่อม";
        $data['UrlMenuMain'] = 'Repair';
        $data['UrlMenuSub'] = 'RepairStatistics';
        $data['Datethai'] = new Datethai();

        return view('User/UserRepair/UserRepairStatistics', $data);
    }

    public function RepairStatisticsCaselist(){
        $session = session();
        $database = \Config\Database::connect();
        $DBRepair = $database->table('tb_repair');

        $data['Bar'] = $DBRepair
        ->select('repair_caselist, COUNT(*) as total')
        ->groupBy('repair_caselist')
        ->get()
        ->getResult();

        $data['Pie'] = $DBRepair
        ->select('repair_status, COUNT(*) as total')
        ->groupBy('repair_status')
        ->get()
        ->getResult();

        return $this->response->setJSON($data);
    }

    /**
     * API: ดึงรายการแจ้งซ่อมทั้งหมด (รองรับการกรองตามปี และสถานะ)
     */
    public function getRepairList()
    {
        $database = \Config\Database::connect();
        $builder = $database->table('tb_repair');
        $Datethai = new Datethai();

        $year = $this->request->getVar('year') ?? date('Y');
        $status = $this->request->getVar('status');

        $builder->select('
            tb_repair.repair_ID, 
            tb_repair.repair_order, 
            tb_repair.repair_datetime, 
            tb_repair.repair_userID, 
            tb_repair.repair_phone, 
            tb_repair.repair_caselist, 
            tb_repair.repair_status, 
            tb_repair.repair_building, 
            tb_repair.repair_class, 
            tb_repair.repair_room,
            tb_repair.repair_detail,
            tb_repair.repair_cause,
            tb_repair.repair_imguser,
            tb_repair.repair_imgwork,
            tb_personnel.pers_prefix, 
            tb_personnel.pers_firstname, 
            tb_personnel.pers_lastname
        ');
        $builder->join('skjacth_personnel.tb_personnel', 'tb_repair.repair_userID = tb_personnel.pers_id');
        $builder->where("YEAR(tb_repair.repair_datetime)", $year);
        $builder->where('tb_repair.repair_caselist !=', 'งานอาคารสถานที่');

        if (!empty($status)) {
            $builder->where('tb_repair.repair_status', $status);
        }

        $builder->orderBy('tb_repair.repair_order', 'DESC');
        $results = $builder->get()->getResult();

        $data = [];
        foreach ($results as $row) {
            $data[] = [
                "id" => $row->repair_ID,
                "order_no" => $row->repair_order,
                "datetime" => $row->repair_datetime,
                "datetime_th" => $Datethai->thai_date_fullmonth(strtotime($row->repair_datetime)),
                "user_id" => $row->repair_userID,
                "user_fullname" => $row->pers_prefix . $row->pers_firstname . ' ' . $row->pers_lastname,
                "phone" => $row->repair_phone,
                "category" => $row->repair_caselist,
                "detail" => $row->repair_detail,
                "repair_cause" => $row->repair_cause,
                "status" => $row->repair_status,
                "location" => [
                    "building" => $row->repair_building,
                    "class" => $row->repair_class,
                    "room" => $row->repair_room
                ],
                "images" => [
                    "user_upload" => $row->repair_imguser ? base_url('uploads/admin/Repair/User/' . $row->repair_imguser) : null,
                    "work_finish" => $row->repair_imgwork ? base_url('uploads/admin/Repair/' . $row->repair_imgwork) : null
                ]
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'count' => count($data),
            'data' => $data
        ]);
    }

    /**
     * API: ดึงรายละเอียดการแจ้งซ่อมตาม ID หรือ Order Number
     */
    public function getRepairDetail($id)
    {
        $database = \Config\Database::connect();
        $DBpers = \Config\Database::connect('personnel');
        $builder = $database->table('tb_repair');
        $Datethai = new Datethai();

        $builder->select('tb_repair.*, tb_position.posi_name, tb_personnel.pers_prefix, tb_personnel.pers_firstname, tb_personnel.pers_lastname');
        $builder->join('skjacth_personnel.tb_personnel', 'tb_repair.repair_userID = tb_personnel.pers_id');
        $builder->join('skjacth_skj.tb_position', 'tb_repair.repair_posi = tb_position.posi_id');
        
        if (is_numeric($id)) {
            $builder->where('repair_ID', $id);
        } else {
            $builder->where('repair_order', $id);
        }
        
        $repair = $builder->get()->getRow();

        if (!$repair) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ไม่พบข้อมูลการแจ้งซ่อมที่ระบุ'
            ])->setStatusCode(404);
        }

        // ดึงชื่อช่าง (ถ้ามี)
        $repairmanName = "รอดำเนินการ";
        if (!empty($repair->repair_Repairman)) {
            $repairman = $DBpers->table('tb_personnel')
                ->select("CONCAT(pers_prefix, pers_firstname, ' ', pers_lastname) AS fullname")
                ->where('pers_id', $repair->repair_Repairman)
                ->get()
                ->getRow();
            if ($repairman) {
                $repairmanName = $repairman->fullname;
            }
        }

        $data = [
            "id" => $repair->repair_ID,
            "order_no" => $repair->repair_order,
            "datetime" => $repair->repair_datetime,
            "datetime_th" => $Datethai->thai_date_fullmonth(strtotime($repair->repair_datetime)),
            "user" => [
                "id" => $repair->repair_userID,
                "fullname" => $repair->pers_prefix . $repair->pers_firstname . ' ' . $repair->pers_lastname,
                "phone" => $repair->repair_phone,
                "position" => $repair->posi_name
            ],
            "category" => $repair->repair_caselist,
            "detail" => $repair->repair_detail,
            "status" => $repair->repair_status,
            "location" => [
                "building" => $repair->repair_building,
                "class" => $repair->repair_class,
                "room" => $repair->repair_room
            ],
            "repairman" => $repairmanName,
            "date_work" => $repair->repair_datework,
            "cause" => $repair->repair_cause,
            "images" => [
                "user_upload" => $repair->repair_imguser ? base_url('uploads/admin/Repair/User/' . $repair->repair_imguser) : null,
                "work_finish" => $repair->repair_imgwork ? base_url('uploads/admin/Repair/' . $repair->repair_imgwork) : null,
                "user_signature" => $repair->repair_usersignature ?: null,
                "admin_signature" => $repair->repair_adminsignature ?: null
            ]
        ];

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
