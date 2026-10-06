<?php

namespace App\Controllers;
use App\Libraries\Datethai;
use CodeIgniter\Files\File;
use App\Libraries\NotificationService;

// error_reporting(-1);
// ini_set('display_errors', 1);

class ConUserRepair extends BaseController
{  

    function __construct(){
       
    }

    private $oneSignalAppId = 'be488231-0e72-4fe0-962d-fcb32cb761e7';
    private $oneSignalApiKey = 'os_v2_app_xzeiemioojh6bfrn7szszn3b46vk2igzrooeom4rtulcfh2t47lyy6rf6mccwtbxfwgzhvpjurm4trrduldx73e3wwz35nwjtsgyhwa';

    private function sendPushNotification($title, $message, $url = null, $tags = null, $userIds = null)
    {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $isLocal = (strpos($host, 'localhost') !== false || $host === '127.0.0.1');
        if ($isLocal) {
            return null;
        }

        $content = array(
            "en" => $message,
            "th" => $message
        );
        $headings = array(
            "en" => $title,
            "th" => $title
        );

        $fields = array(
            'app_id' => $this->oneSignalAppId,
            'headings' => $headings,
            'contents' => $content,
            'chrome_web_badge' => base_url('assets/img/icons/icon-192x192.png'),
            'chrome_web_icon' => base_url('assets/img/icons/icon-512x512.png'),
            'firefox_icon' => base_url('assets/img/icons/icon-512x512.png')
        );

        if ($url) {
            $fields['url'] = $url;
        }

        if ($userIds) {
            $fields['include_external_user_ids'] = is_array($userIds) ? $userIds : array($userIds);
        } elseif ($tags) {
            $fields['filters'] = array();
            $first = true;
            foreach ($tags as $key => $value) {
                if (!$first) {
                    $fields['filters'][] = array("operator" => "OR");
                }
                if (is_array($value)) {
                    foreach ($value as $v) {
                        if (!$first) $fields['filters'][] = array("operator" => "OR");
                        $fields['filters'][] = array("field" => "tag", "key" => $key, "relation" => "=", "value" => $v);
                        $first = false;
                    }
                } else {
                    $fields['filters'][] = array("field" => "tag", "key" => $key, "relation" => "=", "value" => $value);
                    $first = false;
                }
            }
        } else {
            $fields['included_segments'] = array('All');
        }

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $this->oneSignalApiKey
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
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

        $data = $this->DataMain();
        $data['title'] = "เลือกประเภทการแจ้งซ่อมออนไลน์";
        $data['description'] = "เลือกหมวดหมู่งานซ่อมที่ต้องการแจ้งซ่อมออนไลน์ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
        $data['UrlMenuMain'] = 'Repair';
        $data['UrlMenuSub'] = 'RepairMain';
        $data['Datethai'] = new Datethai();

        $TBrepair = $database->table('tb_repair');
        
        // Overall statistics
        $totalCount = $TBrepair->countAllResults(false);
        $pendingCount = $database->table('tb_repair')->where('repair_status', 'รอดำเนินการ')->countAllResults();
        $processCount = $database->table('tb_repair')->where('repair_status', 'กำลังดำเนินการ')->countAllResults();
        $successCount = $database->table('tb_repair')->groupStart()
            ->like('repair_status', 'เรียบร้อย')
            ->orLike('repair_status', 'เสร็จสิ้น')
            ->groupEnd()
            ->countAllResults();

        $data['TotalRepair'] = $totalCount;
        $data['StatusPending'] = $pendingCount;
        $data['StatusProcess'] = $processCount;
        $data['StatusSuccess'] = $successCount;

        // My repairs count (if logged in)
        $myRepairsCount = 0;
        if (!empty($_SESSION['id'])) {
            $myRepairsCount = $database->table('tb_repair')->where('repair_userID', $_SESSION['id'])->countAllResults();
        }
        $data['MyRepairsCount'] = $myRepairsCount;

        // Category stats (Active & Pending breakdown)
        $catCounts = [];
        $catQuery = $database->query("
            SELECT repair_caselist, COUNT(*) as total,
                   SUM(CASE WHEN repair_status = 'รอดำเนินการ' THEN 1 ELSE 0 END) as pending,
                   SUM(CASE WHEN repair_status = 'กำลังดำเนินการ' THEN 1 ELSE 0 END) as in_progress,
                   SUM(CASE WHEN repair_status LIKE '%เรียบร้อย%' OR repair_status LIKE '%เสร็จสิ้น%' THEN 1 ELSE 0 END) as completed
            FROM tb_repair
            WHERE repair_caselist IS NOT NULL AND repair_caselist != ''
            GROUP BY repair_caselist
        ")->getResultArray();

        foreach ($catQuery as $cq) {
            $catCounts[$cq['repair_caselist']] = [
                'total' => (int)$cq['total'],
                'pending' => (int)$cq['pending'],
                'in_progress' => (int)$cq['in_progress'],
                'completed' => (int)$cq['completed']
            ];
        }
        $data['CategoryStats'] = $catCounts;

        // Define Category Cards with Large Graphic Illustrations
        $data['RepairCategories'] = [
            [
                'id' => 'computer',
                'title' => 'คอมพิวเตอร์ / โปรเจคเตอร์',
                'sub_title' => 'Computer & Projector',
                'caselist' => 'คอมพิวเตอร์/โปรเจคเตอร์',
                'icon' => 'bx bx-desktop',
                'image' => 'https://cdn-icons-png.flaticon.com/512/3039/3039387.png',
                'color' => '#696cff',
                'gradient' => 'linear-gradient(135deg, #696cff 0%, #4345bb 100%)',
                'bg_light' => 'rgba(105, 108, 255, 0.08)',
                'border_color' => 'rgba(105, 108, 255, 0.25)',
                'badge' => 'IT Support',
                'description' => 'บริการซ่อมคอมพิวเตอร์ PC, แล็ปท็อป/โน้ตบุ๊ก, จอภาพ, โปรเจคเตอร์ห้องเรียน, อุปกรณ์ต่อพ่วง และระบบปฏิบัติการ/โปรแกรมการเรียนการสอน',
                'tags' => ['จอเปิดไม่ติด', 'เครื่องค้าง/ดับเอง', 'โปรเจคเตอร์ไม่มีภาพ', 'ลงโปรแกรม/OS', 'อุปกรณ์ต่อพ่วงเสีย']
            ],
            [
                'id' => 'printer',
                'title' => 'ปริ้นเตอร์ / สแกนเนอร์',
                'sub_title' => 'Printer & Scanner',
                'caselist' => 'ปริ้นเตอร์/สแกนเนอร์',
                'icon' => 'bx bx-printer',
                'image' => 'https://cdn-icons-png.flaticon.com/512/2888/2888704.png',
                'color' => '#03c3ec',
                'gradient' => 'linear-gradient(135deg, #03c3ec 0%, #0192b1 100%)',
                'bg_light' => 'rgba(3, 195, 236, 0.08)',
                'border_color' => 'rgba(3, 195, 236, 0.25)',
                'badge' => 'Printing',
                'description' => 'บริการซ่อมเครื่องพิมพ์เอกสาร, เครื่องสแกนเนอร์, เครื่องมัลติฟังก์ชัน, ปัญหากระดาษติด, หมึกหมด/หมึกจาง และเชื่อมต่อระบบสั่งพิมพ์',
                'tags' => ['กระดาษติด', 'หมึกหมด/หมึกจาง', 'สแกนไม่ได้', 'พิมพ์ไม่ออก', 'ลงไดรเวอร์ใหม่']
            ],
            [
                'id' => 'network',
                'title' => 'ระบบเครือข่าย & อินเทอร์เน็ต',
                'sub_title' => 'Network & Internet',
                'caselist' => 'ระบบเครือข่าย',
                'icon' => 'bx bx-wifi',
                'image' => 'https://cdn-icons-png.flaticon.com/512/900/900782.png',
                'color' => '#71dd37',
                'gradient' => 'linear-gradient(135deg, #71dd37 0%, #4ca71a 100%)',
                'bg_light' => 'rgba(113, 221, 55, 0.08)',
                'border_color' => 'rgba(113, 221, 55, 0.25)',
                'badge' => 'Network',
                'description' => 'บริการแก้ไขปัญหาสัญญาณอินเทอร์เน็ต Wi-Fi หลุดบ่อย, สาย LAN ขาด/หัวต่อชำรุด, จุดเชื่อมต่อ Access Point ดับ หรือความเร็วอินเทอร์เน็ตไม่ปกติ',
                'tags' => ['Wi-Fi เข้าไม่ได้', 'เน็ตหลุดบ่อย', 'หัวต่อ LAN เสีย', 'Access Point ไม่ทำงาน', 'ความเร็วเน็ตช้า']
            ],
            [
                'id' => 'av',
                'title' => 'โสตทัศนอุปกรณ์ & เครื่องเสียง',
                'sub_title' => 'Audio & Visual Systems',
                'caselist' => 'โสตทัศนอุปกรณ์',
                'icon' => 'bx bx-volume-full',
                'image' => 'https://cdn-icons-png.flaticon.com/512/3174/3174780.png',
                'color' => '#ffab00',
                'gradient' => 'linear-gradient(135deg, #ffab00 0%, #cc8800 100%)',
                'bg_light' => 'rgba(255, 171, 0, 0.08)',
                'border_color' => 'rgba(255, 171, 0, 0.25)',
                'badge' => 'Audio & AV',
                'description' => 'บริการแจ้งซ่อมและปรับจูนระบบเครื่องเสียงห้องประชุม, ไมโครโฟนไร้สาย/มีสาย, ลำโพง, มิกเซอร์, แอมป์ขยายเสียง และระบบภาพเสียงกิจกรรม',
                'tags' => ['ไมค์ไม่มีเสียง/เสียงหอน', 'ลำโพงแตก', 'มิกเซอร์ไม่ทำงาน', 'สายสัญญาณชำรุด', 'ระบบภาพเสียงกิจกรรม']
            ],
            [
                'id' => 'building',
                'title' => 'งานอาคารสถานที่ & สาธารณูปโภค',
                'sub_title' => 'Building & Maintenance',
                'caselist' => 'งานอาคารสถานที่',
                'icon' => 'bx bx-building-house',
                'image' => 'https://cdn-icons-png.flaticon.com/512/2933/2933948.png',
                'color' => '#ff3e1d',
                'gradient' => 'linear-gradient(135deg, #ff5e3a 0%, #c4290d 100%)',
                'bg_light' => 'rgba(255, 62, 29, 0.08)',
                'border_color' => 'rgba(255, 62, 29, 0.25)',
                'badge' => 'Facility (บันทึกข้อความ)',
                'description' => 'บริการซ่อมระบบไฟฟ้า, หลอดไฟส่องสว่าง, เครื่องปรับอากาศ, ระบบประปา/สุขภัณฑ์, ประตูหน้าต่าง, โต๊ะ เก้าอี้ และงานบำรุงรักษาอาคารสถานที่',
                'tags' => ['หลอดไฟดับ/กะพริบ', 'แอร์ไม่เย็น/น้ำหยด', 'ก๊อกน้ำรั่ว/ท่อตัน', 'ประตู/หน้าต่างชำรุด', 'โต๊ะเก้าอี้เสียหาย']
            ]
        ];

        return view('User/UserRepair/UserRepairMain', $data);
    }

    public function RepairDashboard()
    {
        $session = session();
        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');

        $data = $this->DataMain();
        $data['title'] = "แดชบอร์ดและรายการแจ้งซ่อม";
        $data['description'] = "แดชบอร์ดภาพรวมและรายการแจ้งซ่อมออนไลน์ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
        $data['UrlMenuMain'] = 'Repair';
        $data['UrlMenuSub'] = 'RepairDashboard';
        $data['Datethai'] = new Datethai();

        $data['DictationAll'] = $builder->countAll();
        
        // Extract available years from tb_repair
        $yearsResult = $database->query("
            SELECT DISTINCT YEAR(repair_datetime) as yr 
            FROM tb_repair 
            WHERE repair_datetime IS NOT NULL AND repair_datetime != '0000-00-00 00:00:00'
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

        $TBrepair = $database->table('tb_repair');
        if ($selectedYear !== 'all' && is_numeric($selectedYear)) {
            $TBrepair->where("YEAR(repair_datetime)", (int)$selectedYear);
        }

        $repairs = $TBrepair->get()->getResult();

        $totalCount = count($repairs);
        $pendingCount = 0;
        $processCount = 0;
        $successCount = 0;
        $cancelCount = 0;

        $monthlyCounts = array_fill(1, 12, 0);
        $caselistCounts = [];

        foreach ($repairs as $r) {
            $st = $r->repair_status;
            if ($st == 'รอดำเนินการ') {
                $pendingCount++;
            } else if ($st == 'กำลังดำเนินการ') {
                $processCount++;
            } else if (strpos($st, 'เรียบร้อย') !== false || strpos($st, 'เสร็จสิ้น') !== false) {
                $successCount++;
            } else {
                $cancelCount++;
            }

            if (!empty($r->repair_datetime)) {
                $m = (int)date('n', strtotime($r->repair_datetime));
                if ($m >= 1 && $m <= 12) {
                    $monthlyCounts[$m]++;
                }
            }

            $case = $r->repair_caselist ?: 'อื่นๆ';
            if (!isset($caselistCounts[$case])) {
                $caselistCounts[$case] = 0;
            }
            $caselistCounts[$case]++;
        }

        arsort($caselistCounts);
        $topCaselists = array_slice($caselistCounts, 0, 5, true);

        $data['TotalRepair'] = $totalCount;
        $data['StatusPending'] = $pendingCount;
        $data['StatusProcess'] = $processCount;
        $data['StatusSuccess'] = $successCount;
        $data['StatusCancel'] = $cancelCount;
        $data['stats'] = [
            'total' => $totalCount,
            'pending' => $pendingCount,
            'process' => $processCount,
            'success' => $successCount,
            'cancel' => $cancelCount,
            'monthly' => array_values($monthlyCounts),
            'topCaselists' => [
                'labels' => array_keys($topCaselists),
                'series' => array_values($topCaselists)
            ]
        ];

        return view('User/UserRepair/UserRepairDashboard', $data);
    }

    public function RepairAdd()
    {
        $session = session();
        $database = \Config\Database::connect();
        $DBskj = \Config\Database::connect('skj');
        $Skj = $DBskj->table('tb_position');
        $builder = $database->table('tb_location');

        $data = $this->DataMain();
        $data['title'] = "เพิ่มข้อมูลงานแจ้งซ่อม";
        $data['description'] = "บันทึกงานแจ้งซ่อม";
        $data['UrlMenuMain'] = 'Repair';
        $data['UrlMenuSub'] = 'RepairAdd';

        $data['Posi'] = $Skj->get()->getResult();
        $data['Datethai'] = new Datethai();

        // Support category pre-selection from GET parameter
        $data['selectedCategory'] = $this->request->getGet('category') ?? '';

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
        $data = $TBPres->select('pers_id,pers_prefix,pers_firstname,pers_lastname,pers_phone,pers_academic')
        ->where('pers_position',$this->request->getVar('repair_posi'))
        ->where('pers_status','กำลังใช้งาน')
        ->get()->getResult();
        
        echo json_encode($data);
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
            
            $files = $this->request->getFileMultiple('repair_imguser');
            $imageNames = [];

            if ($files) {
                foreach ($files as $image) {
                    if ($image && $image->isValid() && !$image->hasMoved()) {
                        $newName = $image->getRandomName();
                        $image->move(ROOTPATH . 'uploads/user/Repair/', $newName);
                        $this->resizeImage('uploads/user/Repair/' . $newName, 2048, 1024);
                        $imageNames[] = $newName;
                    }
                }
            }

            // Fallback for single file (if sent without array notation)
            if (empty($imageNames)) {
                $image = $this->request->getFile('repair_imguser');
                if ($image && $image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $image->move(ROOTPATH . 'uploads/user/Repair/', $newName);
                    $this->resizeImage('uploads/user/Repair/' . $newName, 2048, 1024);
                    $imageNames[] = $newName;
                }
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
                'repair_imguser' => implode(',', $imageNames),
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

                // ส่งการแจ้งเตือนแบบใหม่
                $notificationService = new NotificationService();

                // เช็คว่าเป็นงานซ่อมเกี่ยวกับอาคารสถานที่หรือไม่
                $isBuilding = ($this->request->getVar('repair_caselist') == "งานอาคารสถานที่");

                // 2. ส่ง OneSignal Push Notification หาเจ้าหน้าที่และหัวหน้างาน
                $targetRoles = ['admin_repair', 'head_repair'];
                if ($isBuilding) {
                    $targetRoles[] = 'admin_building';
                    $targetRoles[] = 'head_building';
                }

                $notificationService->sendPush(
                    "🛠️ มีงานแจ้งซ่อมมาใหม่!",
                    "โดย {$RequesterName} - {$this->request->getVar('repair_caselist')}",
                    base_url("/Repair/View/".$Repair->repair_order),
                    ['role' => $targetRoles]
                );

                // ดึงรูปภาพแรก (ถ้ามี) เพื่อส่งรูปภาพไปยัง Telegram
                $telegramImageUrl = null;
                if (!empty($imageNames)) {
                    $telegramImageUrl = base_url('uploads/user/Repair/' . $imageNames[0]);
                }

                // ส่ง Telegram แจ้งเตือนกลุ่มงานแจ้งซ่อม
                $notificationService->sendTelegram('repair', $msg, $telegramImageUrl);
                // ถ้าเป็นงานอาคารสถานที่ ให้แจ้งเข้า Telegram กลุ่มอาคารสถานที่ด้วย
                if ($isBuilding) {
                    $notificationService->sendTelegram('booking', $msg, $telegramImageUrl);
                }

                // 3. ดึงรายชื่อ Email เจ้าหน้าที่และหัวหน้างาน
                $MailAdmin = $notificationService->getStaffEmailsByDepartment('งานแจ้งซ่อม');
                if ($isBuilding) {
                    // รวม Email ของงานอาคารสถานที่เข้าไปด้วย
                    $buildingEmails = $notificationService->getStaffEmailsByDepartment('งานอาคารสถานที่');
                    $MailAdmin = array_unique(array_merge($MailAdmin, $buildingEmails));
                }

                if (empty($MailAdmin)) {
                    $MailAdmin = ['dekpiano@skj.ac.th'];
                }

                $emailData = [
                    'header_title' => 'มีงานแจ้งซ่อมมาใหม่',
                    'header_sub'   => 'ระบบแจ้งซ่อมออนไลน์ (Repair Service)',
                    'fields' => [
                        ['label' => 'ผู้แจ้งซ่อม', 'value' => $RequesterName],
                        ['label' => 'ประเภทงานซ่อม', 'value' => $this->request->getVar('repair_caselist')],
                        ['label' => 'ใบแจ้งซ่อมเลขที่', 'value' => $OrderNumber],
                    ],
                    'columns' => [
                        ['label' => 'เบอร์โทรติดต่อ', 'value' => $this->request->getVar('repair_phone')],
                        ['label' => 'วันที่แจ้ง', 'value' => $Datethai->thai_date_and_time(strtotime($DateTimeToday))]
                    ],
                    'detail_label' => 'รายละเอียดและสถานที่',
                    'detail_text'  => 'สถานที่: อาคาร ' . $this->request->getVar('repair_building') . ' ชั้น ' . $this->request->getVar('repair_class') . ' ห้อง ' . $this->request->getVar('repair_room') . "\nรายละเอียด: " . $this->request->getVar('repair_detail'),
                    'status' => [
                        'text' => '⏳ รอดำเนินการ',
                        'bg' => '#ffe5d9',
                        'color' => '#ff6b35'
                    ],
                    'cta_text' => '👉 ดูรายละเอียดและรับงาน',
                    'cta_url'  => base_url('Repair/View/'.$OrderNumber)
                ];

                $notificationService->sendEmail(
                    $MailAdmin,
                    '[แจ้งซ่อม] ' . $this->request->getVar('repair_caselist') . ' - ' . $RequesterName,
                    'repair',
                    $emailData,
                    $RequesterEmail,
                    $RequesterName . ' (แจ้งซ่อมผ่านระบบ)'
                );

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
       repair_ID,repair_order,repair_datetime,repair_userID,repair_phone,repair_caselist,repair_status,repair_detail,repair_building,repair_class,repair_room,repair_imguser,repair_imgwork,pers_prefix,pers_firstname,pers_lastname
       ')
       ->join('skjacth_personnel.tb_personnel','tb_repair.repair_userID = tb_personnel.pers_id', 'left')
       ->where(($year !== 'all' && is_numeric($year)) ? "YEAR(repair_datetime) = " . (int)$year : "1=1")
       ->orderBy('repair_datetime', 'DESC')
       ->orderBy('repair_ID', 'DESC')
       ->get()->getResult();

       $data = array();
       foreach ($S_data as $row) {
           $data[] = array(
                "repair_ID"=>$row->repair_ID,
              "repair_order"=>$row->repair_order,
              "repair_datetime_raw"=>$row->repair_datetime,
              "repair_timestamp"=>(!empty($row->repair_datetime) && $row->repair_datetime !== '0000-00-00 00:00:00') ? strtotime($row->repair_datetime) : 0,
              "repair_datetime"=>$Datethai->thai_date_fullmonth(strtotime($row->repair_datetime)),
              "repair_userID"=>$row->repair_userID,
              "repair_phone"=>$row->repair_phone,
              "repair_caselist"=>$row->repair_caselist,
              "repair_status"=>$row->repair_status,
              "repair_detail"=>isset($row->repair_detail) ? $row->repair_detail : '',
              "repair_building"=>isset($row->repair_building) ? $row->repair_building : '',
              "repair_class"=>isset($row->repair_class) ? $row->repair_class : '',
              "repair_room"=>isset($row->repair_room) ? $row->repair_room : '',
              "repair_imguser"=>isset($row->repair_imguser) ? $row->repair_imguser : '',
              "repair_imgwork"=>isset($row->repair_imgwork) ? $row->repair_imgwork : '',
              'UserFullname'=>(!empty($row->pers_firstname) ? ($row->pers_prefix . $row->pers_firstname . ' ' . $row->pers_lastname) : 'เจ้าหน้าที่')
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
        ->where('repair_order', $IDorder)
        ->join('skjacth_personnel.tb_personnel', 'tb_repair.repair_userID = tb_personnel.pers_id', 'left')
        ->join('skjacth_skj.tb_position', 'tb_repair.repair_posi = tb_position.posi_id', 'left')
        ->get()->getResult();

        if (empty($data['RepaiUser'])) {
            $rawOrder = $TBrepair->where('repair_order', $IDorder)->get()->getResult();
            if (!empty($rawOrder)) {
                $data['RepaiUser'] = $rawOrder;
            } else {
                return redirect()->to(base_url('Repair'))->with('error', 'ไม่พบข้อมูลรายการแจ้งซ่อม');
            }
        }

        $isIT = (strpos($data['RepaiUser'][0]->repair_cause ?? '', 'IT Support') !== false || preg_match('/\[IT-\d{6}-\d{4}\]/', $data['RepaiUser'][0]->repair_detail ?? ''));

        // Make sure joined fields are not null and not raw IDs
        if (!empty($data['RepaiUser'])) {
            if (empty($data['RepaiUser'][0]->pers_firstname) || $data['RepaiUser'][0]->pers_firstname === '0000' || is_numeric($data['RepaiUser'][0]->pers_firstname)) {
                $data['RepaiUser'][0]->pers_prefix = '';
                $data['RepaiUser'][0]->pers_firstname = $isIT ? 'ผู้ดูแลระบบ IT Support' : 'เจ้าหน้าที่';
                $data['RepaiUser'][0]->pers_lastname = '';
            }
            if (empty($data['RepaiUser'][0]->posi_name)) {
                $data['RepaiUser'][0]->posi_name = !empty($data['RepaiUser'][0]->repair_posi) ? $data['RepaiUser'][0]->repair_posi : 'เจ้าหน้าที่กองการศึกษา';
            }
        }

        $repairmanName = '';
        $repairmanId = $data['RepaiUser'][0]->repair_Repairman ?? '';
        if (!empty($repairmanId)) {
            $man = $TBpers->select("CONCAT(pers_prefix,pers_firstname,' ',pers_lastname) AS Repairman")
                ->where('pers_id', $repairmanId)
                ->get()->getRow();
            if ($man && !empty(trim($man->Repairman))) {
                $repairmanName = trim($man->Repairman);
            } elseif ($repairmanId === '0000' || is_numeric($repairmanId)) {
                $repairmanName = $isIT ? 'ผู้ดูแลระบบ IT Support' : 'เจ้าหน้าที่ปฏิบัติงาน';
            } else {
                $repairmanName = $repairmanId;
            }
        } else {
            $repairmanName = $isIT ? 'ผู้ดูแลระบบ IT Support' : '-';
        }

        // สำหรับรายการที่ซิงค์มาจาก IT Support API: รูปภาพทั้งหมดคือรูปภาพประกอบงาน (ภาพการดำเนินงานต้องไม่มี)
        if (!empty($data['RepaiUser'])) {
            if ($isIT && !empty($data['RepaiUser'][0]->repair_imgwork)) {
                $TBrepair->where('repair_order', $IDorder)->update(['repair_imgwork' => '']);
                $data['RepaiUser'][0]->repair_imgwork = '';
            }
        }

        $data['RepairmanName'] = $repairmanName;
        $data['Repairman'] = [(object)['Repairman' => $repairmanName]];
        $data['Order'] = array_merge($data['RepaiUser'], $data['Repairman']);
        $data['Order'][0]->repair_RepairmanFullName = $repairmanName;

        // ตรวจสอบว่ามีการประเมินไปแล้วหรือยัง
        $data['Evaluation'] = $DBrepair->table('tb_repair_evaluations')
            ->where('repair_order', $IDorder)
            ->get()->getRow();

        // ดึงข้อมูลบันทึกข้อความ (ถ้ามี)
        $data['MemoData'] = $DBrepair->table('tb_repair_memo')
            ->where('repair_order', $IDorder)
            ->get()->getRow();

        return view('User/UserRepair/UserRepairView', $data);
    }

    public function CheckRepairFullDetail(){
        $DBrepair = \Config\Database::connect();
        $TBrepair = $DBrepair->table('tb_repair');
        $DBpers = \Config\Database::connect('personnel');
        $TBpers = $DBpers->table('tb_personnel');

        $json = [];
        $data = $TBrepair->select('tb_repair.*,tb_position.posi_name,tb_personnel.pers_prefix,tb_personnel.pers_firstname,tb_personnel.pers_lastname')
        ->where('repair_ID', $this->request->getVar('RepairId'))
        ->join('skjacth_personnel.tb_personnel', 'tb_repair.repair_userID = tb_personnel.pers_id', 'left')
        ->join('skjacth_skj.tb_position', 'tb_repair.repair_posi = tb_position.posi_id', 'left')
        ->get()->getResult();

        if (!empty($data)) {
            if (empty($data[0]->posi_name)) {
                $data[0]->posi_name = $data[0]->repair_posi ?: 'เจ้าหน้าที่กองการศึกษา';
            }
            if (empty($data[0]->pers_firstname)) {
                $data[0]->pers_prefix = '';
                $data[0]->pers_firstname = $data[0]->repair_Repairman ?: 'เจ้าหน้าที่';
                $data[0]->pers_lastname = '';
            }
        }
        array_push($json, $data);
       
        if (!empty($data) && !empty($data[0]->repair_Repairman)) {
            $check = $TBpers->select('pers_prefix,pers_firstname,pers_lastname')
            ->where('pers_id', $data[0]->repair_Repairman)
            ->get()->getResult();
            if (!empty($check)) {
                array_push($json, $check);
            } else {
                array_push($json, [(object)[
                    'pers_prefix' => '',
                    'pers_firstname' => $data[0]->repair_Repairman,
                    'pers_lastname' => ''
                ]]);
            }
        } else {
            array_push($json, 'pers_prefix,pers_firstname,pers_lastname');
        }

        echo json_encode($json);
    }
  public function RepairUpdateWork(){
        try {
            $DBrepair = \Config\Database::connect();
            $TBrepair = $DBrepair->table('tb_repair');
            $Datethai = new Datethai();       
            $files = $this->request->getFileMultiple('repair_imgwork');
            $imageNames = [];

            $imgWorkPost = $this->request->getVar('imgwork');
            if (!empty($imgWorkPost)) {
                $oldImgs = explode(',', $imgWorkPost);
                foreach($oldImgs as $oldImg) {
                    if (empty($oldImg)) continue;
                    $filePath = ROOTPATH .'uploads/admin/Repair/'.$oldImg;
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
            }

            if ($files) {
                foreach ($files as $image) {
                    if ($image && $image->isValid() && !$image->hasMoved()) {
                        $newName = $image->getRandomName();
                        $image->move(ROOTPATH . 'uploads/admin/Repair/', $newName);
                        $this->resizeImage('uploads/admin/Repair/' . $newName, 2048, 1024);
                        $imageNames[] = $newName;
                    }
                }
            }

            // Fallback for single file
            if (empty($imageNames)) {
                $image = $this->request->getFile('repair_imgwork');
                if ($image && $image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $image->move(ROOTPATH . 'uploads/admin/Repair/', $newName);
                    $this->resizeImage('uploads/admin/Repair/' . $newName, 2048, 1024);
                    $imageNames[] = $newName;
                }
            }

            $data = [
                'repair_status' => $this->request->getPost('repair_status'),
                'repair_datework' => $this->request->getPost('repair_datework'),
                'repair_Repairman' => $this->request->getPost('repair_Repairman'),
                'repair_cause' => $this->request->getPost('repair_cause'),
                'repair_adminsignature' => $this->request->getPost('Signature') // เก็บเป็น PNG Base64
            ];

            if (!empty($imageNames)) {
                $data['repair_imgwork'] = implode(',', $imageNames);
            }

            if ($TBrepair->where('repair_order', $this->request->getPost('repair_order'))->update($data)) {
                 // บล็อกเฉพาะ localhost เท่านั้น
                 $host = $_SERVER['HTTP_HOST'] ?? '';
                 $isLocal = (strpos($host, 'localhost') !== false || $host === '127.0.0.1');
                 if (!$isLocal) {
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
                                 $notificationService = new NotificationService();
                                 $statusColors = ($currentStatus === 'ดำเนินการเรียบร้อย') 
                                     ? ['bg' => '#e8f5e9', 'color' => '#2e7d32'] 
                                     : ['bg' => '#ffe5d9', 'color' => '#ff6b35'];

                                 $emailData = [
                                     'header_title' => 'อัปเดตสถานะการซ่อม',
                                     'header_sub'   => 'ระบบแจ้งซ่อมออนไลน์ (Repair Service)',
                                     'fields' => [
                                         ['label' => 'เรียน', 'value' => $RequesterName],
                                         ['label' => 'รายการแจ้งซ่อม', 'value' => $RepairInfo->repair_caselist],
                                         ['label' => 'ใบแจ้งซ่อมเลขที่', 'value' => $RepairInfo->repair_order],
                                     ],
                                     'columns' => [
                                         ['label' => 'ผู้ดำเนินการ', 'value' => $RepairmanName],
                                         ['label' => 'วันที่อัปเดต', 'value' => $Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')))]
                                     ],
                                     'detail_label' => 'รายละเอียดและบันทึกจากเจ้าหน้าที่',
                                     'detail_text'  => 'สถานที่: อาคาร ' . $RepairInfo->repair_building . ' ชั้น ' . $RepairInfo->repair_class . ' ห้อง ' . $RepairInfo->repair_room 
                                         . "\nรายละเอียดปัญหา: " . $RepairInfo->repair_detail 
                                         . (!empty($this->request->getPost('repair_cause')) ? "\nบันทึกจากเจ้าหน้าที่: " . $this->request->getPost('repair_cause') : ""),
                                     'status' => [
                                         'text' => $currentStatus,
                                         'bg' => $statusColors['bg'],
                                         'color' => $statusColors['color']
                                     ],
                                     'cta_text' => '👉 ดูรายละเอียด',
                                     'cta_url'  => base_url('Repair/View/' . $RepairInfo->repair_order)
                                 ];

                                 $notificationService->sendEmail(
                                     $Requester->pers_username,
                                     '[อัปเดตสถานะ] ' . $RepairInfo->repair_caselist . ' - ' . $currentStatus,
                                     ($currentStatus === 'ดำเนินการเรียบร้อย' ? 'approved' : 'update'),
                                     $emailData,
                                     $RepairmanEmail,
                                     $RepairmanName . ' (งานแจ้งซ่อม)'
                                 );

                                  $notificationService->sendPush(
                                      "🛠️ อัปเดตสถานะการซ่อม",
                                      "รายการ: {$RepairInfo->repair_caselist} สถานะ: {$currentStatus}",
                                      base_url('Repair/View/' . $RepairInfo->repair_order),
                                      null,
                                      $RepairInfo->repair_userID
                                  );

                                  // ส่ง Telegram แจ้งอัปเดตสถานะ
                                  $telegramMsg = "🔄 อัปเดตสถานะการซ่อม\n";
                                  $telegramMsg .= "📌 รายการ: {$RepairInfo->repair_caselist}\n";
                                  $telegramMsg .= "📍 สถานที่: อาคาร {$RepairInfo->repair_building} ชั้น {$RepairInfo->repair_class} ห้อง {$RepairInfo->repair_room}\n";
                                  $telegramMsg .= "👤 ผู้แจ้ง: {$RequesterName}\n";
                                  $telegramMsg .= "🔧 ผู้ดำเนินการ: {$RepairmanName}\n";
                                  $telegramMsg .= "📊 สถานะ: {$currentStatus}\n";
                                  $telegramMsg .= "👉 ดูรายละเอียด: " . base_url('Repair/View/' . $RepairInfo->repair_order);
                                  $notificationService->sendTelegram('repair', $telegramMsg);

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
        if (empty($_SESSION['username']) || (!in_array("งานแจ้งซ่อม", $checkRloes) && !in_array("งานอาคารสถานที่", $checkRloes) && @$_SESSION['status'] != 'AdminGeneral' && @$_SESSION['status'] != 'superadmin')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์เข้าถึงฟังก์ชันนี้']);
        }

        $db = \Config\Database::connect();
        $tbrepair = $db->table('tb_repair');
        
        $repairData = $tbrepair->select('repair_imguser, repair_imgwork')->get()->getResult();
        
        $usedImages = [];
        foreach ($repairData as $row) {
            if (!empty($row->repair_imguser)) {
                $imgs = explode(',', $row->repair_imguser);
                foreach($imgs as $img) {
                    if (!empty($img)) $usedImages[] = $img;
                }
            }
            if (!empty($row->repair_imgwork)) {
                $imgs_w = explode(',', $row->repair_imgwork);
                foreach($imgs_w as $img_w) {
                    if (!empty($img_w)) $usedImages[] = $img_w;
                }
            }
        }
        
        $paths = [
            'uploads/admin/Repair/' => 'repair_imgwork',
            'uploads/user/Repair/' => 'repair_imguser'
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
        require_once ROOTPATH . 'vendor/autoload.php';

        $DBrepair = \Config\Database::connect();
        $TBrepair = $DBrepair->table('tb_repair');
        $DBpers = \Config\Database::connect('personnel');
        $TBpers = $DBpers->table('tb_personnel');
        $data['Datethai'] = new Datethai();

        $data['RepairUser'] = $TBrepair->select('tb_repair.*,tb_position.posi_name,tb_personnel.pers_prefix,tb_personnel.pers_firstname,tb_personnel.pers_lastname')        
        ->join('skjacth_personnel.tb_personnel','tb_repair.repair_userID = tb_personnel.pers_id', 'left')
        ->join('skjacth_skj.tb_position','tb_repair.repair_posi = tb_position.posi_id', 'left')
        ->where('repair_order', urldecode($RepairId))
        ->get()->getResult();

        if($data['RepairUser'][0]->repair_Repairman != ''){
            $data['Repairman'] = $TBpers->select('pers_prefix,pers_firstname,pers_lastname')
            ->where('pers_id',$data['RepairUser'][0]->repair_Repairman)
            ->get()->getResult();
           
        }else{
            $data['Repairman'] = 'pers_prefix,pers_firstname,pers_lastname';
        }

       
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf(
            array(
                'format' => 'A4',
                'mode' => 'utf-8',
                'default_font' => 'thsarabun',
                'default_font_size' => 16,
                'curlAllowUnsafeSslRequests' => true,
                'margin_top' => 5,
                'margin_bottom' => 40,
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_footer' => 5,
                'fontDir' => array_merge($fontDirs, [
                    ROOTPATH . 'vendor/mpdf/mpdf/ttfonts',
                ]),
                'fontdata' => $fontData + [
                    'thsarabun' => [
                        'R' => 'THSarabunNew.ttf',
                        'B' => 'THSarabunNew Bold.ttf',
                        'I' => 'THSarabunNew Italic.ttf',
                        'BI' => 'THSarabunNew BoldItalic.ttf'
                    ]
                ],
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
        require_once ROOTPATH . 'vendor/autoload.php';
        $db = \Config\Database::connect();
        $data['Datethai'] = new Datethai();
        
        // Get POST data
        $postData = $this->request->getPost();
        $repair_order = $this->request->getVar('order') ?? $this->request->getPost('repair_order');

        if (!empty($postData['memo_subject'])) {
            $data['memo_data'] = $postData;
            // Prefer explicit position name if sent from hidden field
            if (!empty($postData['memo_posi_name'])) {
                $data['memo_data']['memo_posi'] = $postData['memo_posi_name'];
            }
        } elseif (!empty($repair_order)) {
            $dbMemo = $db->table('tb_repair_memo')->where('repair_order', $repair_order)->get()->getRowArray();
            if ($dbMemo) {
                $data['memo_data'] = $dbMemo;
                $data['img1'] = $dbMemo['memo_img1'] ?? '';
                $data['img2'] = $dbMemo['memo_img2'] ?? '';
            } else {
                $repair_info = $db->table('tb_repair')->where('repair_order', $repair_order)->get()->getRowArray();
                if ($repair_info) {
                    $DBpers = \Config\Database::connect('personnel');
                    $pers = $DBpers->table('tb_personnel')->where('pers_id', $repair_info['repair_userID'])->get()->getRowArray();
                    $DBskj = \Config\Database::connect('skj');
                    $posi = $DBskj->table('tb_position')->where('posi_id', $repair_info['repair_posi'])->get()->getRowArray();
                    
                    $locArr = array_filter([$repair_info['repair_building'] ?? '', !empty($repair_info['repair_class']) ? 'ชั้น '.$repair_info['repair_class'] : '', !empty($repair_info['repair_room']) ? 'ห้อง '.$repair_info['repair_room'] : '']);

                    $data['memo_data'] = [
                        'memo_agency' => 'กลุ่มบริหารทั่วไป งานอาคารสถานที่ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ โทร. ๐-๕๖๐๐-๙๖๖๗',
                        'memo_no' => '',
                        'memo_date' => $data['Datethai']->thai_date_fullmonth(strtotime($repair_info['repair_datetime'] ?? date('Y-m-d'))),
                        'memo_subject' => 'ขออนุมัติซ่อมแซมอาคารสถานที่',
                        'memo_to' => 'ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์',
                        'memo_location' => implode(' ', $locArr),
                        'memo_reason' => $repair_info['repair_detail'] ?? '',
                        'memo_budget' => '',
                        'memo_fullname' => $pers ? ($pers['pers_prefix'].$pers['pers_firstname'].' '.$pers['pers_lastname']) : '',
                        'memo_posi' => $posi ? $posi['posi_name'] : ($repair_info['repair_posi'] ?? ''),
                    ];
                } else {
                    $data['memo_data'] = $postData;
                }
            }
        } else {
            $data['memo_data'] = $postData;
        }

        // Find position name based on position ID selected if still numeric
        if (!empty($data['memo_data']['memo_posi']) && is_numeric($data['memo_data']['memo_posi'])) {
            $DBskj = \Config\Database::connect('skj');
            $posiRecord = $DBskj->table('tb_position')->where('posi_id', $data['memo_data']['memo_posi'])->get()->getRow();
            if ($posiRecord) {
                $data['memo_data']['memo_posi'] = $posiRecord->posi_name;
            }
        }

        // Format Academic Standing (วิทยฐานะ) for teachers
        if (!empty($data['memo_data']['memo_fullname']) && !empty($data['memo_data']['memo_posi'])) {
            $curPosi = trim($data['memo_data']['memo_posi']);
            if (($curPosi === 'ครู' || mb_strpos($curPosi, 'ครู') !== false) && mb_strpos($curPosi, 'ผู้อำนวยการ') === false && mb_strpos($curPosi, 'วิทยฐานะ') === false) {
                $DBpers = \Config\Database::connect('personnel');
                $nameParts = explode(' ', trim($data['memo_data']['memo_fullname']));
                $fnameClean = preg_replace('/^(นาย|นางสาว|นาง|ว่าที่ร้อยตรี|ดร\.)/', '', $nameParts[0]);
                $pQuery = $DBpers->table('tb_personnel')->like('pers_firstname', $fnameClean);
                if (count($nameParts) > 1) {
                    $pQuery->like('pers_lastname', end($nameParts));
                }
                $pRow = $pQuery->get()->getRow();
                if ($pRow && !empty($pRow->pers_academic) && $pRow->pers_academic !== 'ไม่มี' && $pRow->pers_academic !== '-') {
                    $ac = trim($pRow->pers_academic);
                    if (mb_strpos($ac, 'วิทยฐานะ') !== false) {
                        $data['memo_data']['memo_posi'] = $curPosi . ' ' . $ac;
                    } elseif (mb_strpos($ac, 'ครู') === 0) {
                        $data['memo_data']['memo_posi'] = $curPosi . ' วิทยฐานะ' . $ac;
                    } else {
                        $data['memo_data']['memo_posi'] = $curPosi . ' วิทยฐานะครู' . $ac;
                    }
                }
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
            ]);
            $forge->addField("created_at DATETIME DEFAULT CURRENT_TIMESTAMP");
            $forge->addField("updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
            $forge->addKey('memo_id', true);
            $forge->createTable('tb_repair_memo', true);
        }

        // 2. Prepare data for DB
        $repair_order = trim($this->request->getPost('repair_order'));
        if (!empty($repair_order)) {
            $dbData = [
                'memo_agency'   => $this->request->getPost('memo_agency'),
                'memo_no'       => $this->request->getPost('memo_no'),
                'memo_date'     => $this->request->getPost('memo_date'),
                'memo_subject'  => $this->request->getPost('memo_subject'),
                'memo_to'       => $this->request->getPost('memo_to'),
                'memo_location' => $this->request->getPost('memo_location'),
                'memo_reason'   => $this->request->getPost('memo_reason'),
                'memo_budget'   => $this->request->getPost('memo_budget'),
                'memo_fullname' => $this->request->getPost('memo_fullname'),
                'memo_posi'     => $data['memo_data']['memo_posi'] ?? $this->request->getPost('memo_posi'),
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
                $db->table('tb_repair_memo')->where('repair_order', $repair_order)->update($dbData);
            } else {
                $dbData['repair_order'] = $repair_order;
                $db->table('tb_repair_memo')->insert($dbData);
            }
        }

        // Fetch Official Names from Database
        $DBAdminRloes = $db->table('tb_admin_rloes');
        
        $data['HeadBuildings'] = $DBAdminRloes->select('pers_prefix, pers_firstname, pers_lastname')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id', 'left')
            ->where('admin_rloes_nanetype', 'งานอาคารสถานที่')
            ->where('admin_rloes_level LIKE', '1/%')
            ->get()->getRow();

        $data['DeputyExecutive'] = $DBAdminRloes->select('pers_prefix, pers_firstname, pers_lastname')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id', 'left')
            ->where('admin_rloes_nanetype', 'รองผู้อำนวยการบริหารทั่วไป')
            ->get()->getRow();

        $data['Director'] = $DBAdminRloes->select('pers_prefix, pers_firstname, pers_lastname')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id', 'left')
            ->where('admin_rloes_nanetype', 'ผู้อำนวยการโรงเรียน')
            ->get()->getRow();

        // Prepare images array for view
        $memoImages = [];
        if (!empty($data['img1'])) {
            $memoImages[] = (strpos($data['img1'], 'http') === 0) ? $data['img1'] : base_url($data['img1']);
        }
        if (!empty($data['img2'])) {
            $memoImages[] = (strpos($data['img2'], 'http') === 0) ? $data['img2'] : base_url($data['img2']);
        }
        // Fallback: If no memo image was uploaded, check if original repair record has images
        if (empty($memoImages) && !empty($repair_order)) {
            $rInfo = $db->table('tb_repair')->where('repair_order', $repair_order)->get()->getRowArray();
            if (!empty($rInfo['repair_imguser'])) {
                $userImgs = explode(',', $rInfo['repair_imguser']);
                foreach ($userImgs as $ui) {
                    $ui = trim($ui);
                    if (!empty($ui)) {
                        $memoImages[] = base_url('uploads/user/Repair/' . $ui);
                    }
                }
            }
        }
        $data['memo_data']['images'] = $memoImages;

        return view('User/UserRepair/UserRepairBuildingMemoPrint', $data);
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
        $builder->join('skjacth_personnel.tb_personnel', 'tb_repair.repair_userID = tb_personnel.pers_id', 'left');
        $builder->where("YEAR(tb_repair.repair_datetime)", $year);
        $builder->where('tb_repair.repair_caselist !=', 'งานอาคารสถานที่');

        if (!empty($status)) {
            $builder->where('tb_repair.repair_status', $status);
        }

        $builder->orderBy('tb_repair.repair_datetime', 'DESC')
                ->orderBy('tb_repair.repair_ID', 'DESC');
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
        $builder->join('skjacth_personnel.tb_personnel', 'tb_repair.repair_userID = tb_personnel.pers_id', 'left');
        $builder->join('skjacth_skj.tb_position', 'tb_repair.repair_posi = tb_position.posi_id', 'left');
        
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
    public function MigrateImages()
    {
        // Check permissions (Admin only)
        $session = session();
        $checkRloes = explode(",", @$_SESSION['rloes']);
        if (empty($_SESSION['username']) || (!in_array("งานแจ้งซ่อม", $checkRloes) && !in_array("งานอาคารสถานที่", $checkRloes) && @$_SESSION['status'] != 'AdminGeneral' && @$_SESSION['status'] != 'superadmin')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์เข้าถึงฟังก์ชันนี้']);
        }

        $db = \Config\Database::connect();
        $tbrepair = $db->table('tb_repair');
        $rows = $tbrepair->select('repair_imguser, repair_imgwork')->get()->getResult();
        
        $userTarget = ROOTPATH . 'uploads/user/Repair/';
        $adminTarget = ROOTPATH . 'uploads/admin/Repair/';
        
        // Ensure target directories exist
        if (!is_dir($userTarget)) @mkdir($userTarget, 0777, true);
        if (!is_dir($adminTarget)) @mkdir($adminTarget, 0777, true);
        
        $movedUser = 0;
        $movedAdmin = 0;
        
        foreach ($rows as $row) {
            // 1. Move User Images (repair_imguser)
            if (!empty($row->repair_imguser)) {
                $imgs = explode(',', $row->repair_imguser);
                foreach($imgs as $img) {
                    if (empty($img)) continue;
                    
                    // Possible source locations for user images
                    $sources = [
                        ROOTPATH . 'uploads/admin/Repair/User/' . $img,
                        ROOTPATH . 'uploads/admin/Repair/' . $img
                    ];
                    
                    foreach($sources as $src) {
                        if (file_exists($src) && $src !== ($userTarget . $img)) {
                            if (@rename($src, $userTarget . $img)) {
                                $movedUser++;
                                break; // Found and moved
                            }
                        }
                    }
                }
            }
            
            // 2. Move Admin Images (repair_imgwork)
            if (!empty($row->repair_imgwork)) {
                $imgs_w = explode(',', $row->repair_imgwork);
                foreach($imgs_w as $img_w) {
                    if (empty($img_w)) continue;
                    
                    // Possible source locations for admin images (maybe accidentally put in User folder)
                    $src = ROOTPATH . 'uploads/admin/Repair/User/' . $img_w;
                    if (file_exists($src) && $src !== ($adminTarget . $img_w)) {
                        if (@rename($src, $adminTarget . $img_w)) {
                            $movedAdmin++;
                        }
                    }
                }
            }
        }
        
        return $this->response->setJSON([
            'status' => 'success', 
            'message' => "ย้ายไฟล์เข้าโฟลเดอร์ที่ถูกต้องเรียบร้อยแล้ว (User: $movedUser ไฟล์, Admin: $movedAdmin ไฟล์)"
        ]);
    }

    public function RepairSaveEvaluation()
    {
        try {
            $db = \Config\Database::connect();
            $repair_order = $this->request->getPost('repair_order');

            // เช็คก่อนว่าเคยประเมินหรือยัง
            $exists = $db->table('tb_repair_evaluations')
                ->where('repair_order', $repair_order)
                ->countAllResults();

            if ($exists > 0) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'คุณได้ประเมินรายการนี้ไปเรียบร้อยแล้ว'
                ]);
            }

            $dataInsert = [
                'repair_order' => $repair_order,
                'eval_score_speed' => $this->request->getPost('score_speed'),
                'eval_score_quality' => $this->request->getPost('score_quality'),
                'eval_score_service' => $this->request->getPost('score_service'),
                'eval_comment' => $this->request->getPost('comment'),
                'eval_datetime' => date('Y-m-d H:i:s')
            ];

            if ($db->table('tb_repair_evaluations')->insert($dataInsert)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'ขอบคุณสำหรับคะแนนการประเมินและข้อเสนอแนะของคุณ!'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * เข้าสู่ระบบเจ้าหน้าที่รับงาน (Staff Login)
     * ตรวจสอบ username/password กับ tb_personnel และสิทธิ์งานแจ้งซ่อม/งานอาคารสถานที่
     */
    public function StaffLogin()
    {
        try {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $repairOrder = $this->request->getPost('repair_order');

            if (empty($username) || empty($password)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน'
                ]);
            }

            // ตรวจสอบกับฐานข้อมูลบุคลากร
            $dbPers = \Config\Database::connect('personnel');
            $person = $dbPers->table('tb_personnel')
                ->where('pers_username', $username)
                ->get()->getRow();

            if (!$person) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'
                ]);
            }

            // ตรวจสอบรหัสผ่าน (md5 ตามระบบเดิม หรือ password_verify ถ้าเป็น hash ใหม่)
            $passwordValid = false;
            if (!empty($person->pers_password)) {
                if ($person->pers_password === md5($password)) {
                    $passwordValid = true;
                } elseif (password_verify($password, $person->pers_password)) {
                    $passwordValid = true;
                }
            }

            if (!$passwordValid) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'
                ]);
            }

            // ตรวจสอบสิทธิ์ — ต้องมี rloes ที่มี "งานแจ้งซ่อม" หรือ "งานอาคารสถานที่"
            $rloes = !empty($person->pers_rloes) ? explode(',', $person->pers_rloes) : [];
            $hasPermission = in_array('งานแจ้งซ่อม', $rloes) || in_array('งานอาคารสถานที่', $rloes);

            if (!$hasPermission) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'คุณไม่มีสิทธิ์เข้าใช้งานส่วนนี้ ต้องมีสิทธิ์ "งานแจ้งซ่อม" หรือ "งานอาคารสถานที่"'
                ]);
            }

            // Login สำเร็จ — สร้าง session
            $session = session();
            $session->set([
                'id'         => $person->pers_id,
                'username'   => $person->pers_username,
                'fullname'   => $person->pers_prefix . $person->pers_firstname . ' ' . $person->pers_lastname,
                'rloes'      => $person->pers_rloes,
                'isLoggedIn' => true,
                'staffLogin' => true, // ระบุว่า login ผ่านหน้าเจ้าหน้าที่
            ]);

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'เข้าสู่ระบบสำเร็จ',
                'redirect' => base_url('Repair/View/' . $repairOrder)
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * ออกจากระบบเจ้าหน้าที่
     */
    public function StaffLogout()
    {
        $session = session();
        $session->destroy();
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'ออกจากระบบแล้ว'
        ]);
    }

        /**
     * ดึงข้อมูลรายการแจ้งซ่อม/งานบริการจากระบบ IT Support (PAO-Erc API)
     */
        public function FetchITSupport()
    {
        $session = session();
        $isAuth = $session->get('isLoggedIn') || $session->get('staffLogin') || $session->get('logged_in') || $session->get('id');
        if (!$isAuth) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'กรุณาเข้าสู่ระบบก่อนทำรายการ'
            ]);
        }

        try {
            $limit = (int)($this->request->getVar('limit') ?? $this->request->getGet('limit') ?? 50);
            $search = $this->request->getVar('search') ?? $this->request->getGet('search') ?? '';
            $category = $this->request->getVar('category') ?? $this->request->getGet('category') ?? '';

            // ตรวจสอบ URL ของ IT Support API (รองรับทั้งผ่าน .env และ fallback อัตโนมัติ)
            $envApiUrl = env('IT_SUPPORT_API_URL') ?: (getenv('IT_SUPPORT_API_URL') ?: '');
            $apiKey = env('IT_SUPPORT_API_KEY') ?: (getenv('IT_SUPPORT_API_KEY') ?: 'pao-erc-itsupport-api-key-2026');

            // รายการ URL ที่จะทดสอบเชื่อมต่อตามลำดับความเหมาะสม (Server จริง / .env / Localhost / Docker)
            $candidateUrls = [];
            if (!empty($envApiUrl)) {
                $candidateUrls[] = rtrim($envApiUrl, '/');
            }
            // รายการ Candidate สำหรับ Production Server และสภาพแวดล้อมต่างๆ
            $candidateUrls[] = 'http://paoerc_app/api/itsupport';
            $candidateUrls[] = 'http://pao-erc-app/api/itsupport';
            $candidateUrls[] = 'https://localhost:9443/api/itsupport';
            $candidateUrls[] = 'http://localhost:9000/api/itsupport';
            $candidateUrls[] = 'http://localhost/api/itsupport';
            $candidateUrls[] = 'https://host.docker.internal:9443/api/itsupport';

            $queryParams = '?limit=' . $limit;
            if (!empty($search)) {
                $queryParams .= '&search=' . urlencode($search);
            }
            if (!empty($category)) {
                $queryParams .= '&category=' . urlencode($category);
            }

            $response = false;
            $lastErr = '';

            foreach ($candidateUrls as $baseUrl) {
                $targetUrl = (strpos($baseUrl, '?') !== false) ? ($baseUrl . '&limit=' . $limit) : ($baseUrl . $queryParams);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $targetUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 6);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'X-API-KEY: ' . $apiKey,
                    'Accept: application/json'
                ]);

                $res = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curlErr = curl_error($ch);
                curl_close($ch);

                if (!$curlErr && ($httpCode === 200 || $httpCode === 201)) {
                    $jsonTest = json_decode($res, true);
                    if ($jsonTest && (isset($jsonTest['status']) || isset($jsonTest['data']))) {
                        $response = $res;
                        break;
                    }
                } else {
                    $lastErr = $curlErr ? $curlErr : ('HTTP ' . $httpCode);
                }
            }

            if (!$response) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'เชื่อมต่อ IT Support API ไม่สำเร็จ (' . ($lastErr ?: 'ไม่พบ Endpoint') . ') กรุณาระบุ IT_SUPPORT_API_URL ในไฟล์ .env ของระบบ'
                ]);
            }

            $apiData = json_decode($response, true);
            $isSuccess = $apiData && (
                (isset($apiData['status']) && ($apiData['status'] === 'success' || $apiData['status'] === 200 || $apiData['status'] == '200')) ||
                (isset($apiData['success']) && $apiData['success'] === true)
            );

            if (!$isSuccess) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $apiData['message'] ?? 'ไม่สามารถดึงข้อมูลจาก IT Support API ได้'
                ]);
            }

            // ตรวจสอบกับฐานข้อมูล tb_repair ว่า Ticket ไหนเคยถูกนำเข้าแล้วบ้าง
            $db = \Config\Database::connect();
            $existingRepairs = $db->table('tb_repair')
                ->select('repair_order, repair_detail, repair_datetime')
                ->get()
                ->getResultArray();

            $tickets = $apiData['data'] ?? [];
            foreach ($tickets as &$ticket) {
                $ticketCode = $ticket['ticket_code'] ?? '';
                $isImported = false;
                $matchedOrder = null;

                foreach ($existingRepairs as $er) {
                    if (!empty($ticketCode) && strpos($er['repair_detail'], $ticketCode) !== false) {
                        $isImported = true;
                        $matchedOrder = $er['repair_order'];
                        break;
                    }
                }

                $ticket['is_imported'] = $isImported;
                $ticket['matched_repair_order'] = $matchedOrder;
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'meta'    => $apiData['meta'] ?? [],
                'data'    => $tickets
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ]);
        }
    }

        public function SyncITSupport()
    {
        $session = session();
        $isAuth = $session->get('isLoggedIn') || $session->get('staffLogin') || $session->get('logged_in') || $session->get('id');
        if (!$isAuth) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'กรุณาเข้าสู่ระบบก่อนทำรายการ'
            ]);
        }

        try {
            $rawPayload = $this->request->getVar('tickets');
            if (empty($rawPayload)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'ไม่พบข้อมูลรายการที่ส่งมานำเข้า'
                ]);
            }

            $tickets = is_string($rawPayload) ? json_decode($rawPayload, true) : $rawPayload;
            if (!is_array($tickets) || empty($tickets)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'รูปแบบข้อมูลรายการไม่ถูกต้อง'
                ]);
            }

            $db = \Config\Database::connect();
            $tbRepair = $db->table('tb_repair');

            $importedCount = 0;
            $skippedCount = 0;
            $newOrders = [];

            foreach ($tickets as $item) {
                $ticketCode = $item['ticket_code'] ?? '';
                $task = $item['task'] ?? '';
                $ticketDate = $item['date'] ?? date('Y-m-d H:i:s');
                $category = $item['category'] ?? '';
                $location = $item['location'] ?? '';
                $recordedBy = $item['recorded_by'] ?? '';

                // 1. ตรวจสอบว่าเคยนำเข้า Ticket นี้แล้วหรือไม่ ถ้ามีแล้วให้อัปเดตผู้ดำเนินการซ่อมเป็นผู้ที่กดซิงค์
                $syncOperator = !empty($session->get('id')) && $session->get('id') !== '0000' ? $session->get('id') : ($session->get('fullname') ?: ($session->get('username') ?: 'ผู้ดูแลระบบ IT Support'));
                if (!empty($ticketCode)) {
                    $existing = $tbRepair->like('repair_detail', $ticketCode)->get()->getRow();
                    if ($existing) {
                        $tbRepair->where('repair_ID', $existing->repair_ID)->update([
                            'repair_Repairman' => $syncOperator,
                            'repair_posi'      => !empty($item['recorded_by_position']) ? $item['recorded_by_position'] : (!empty($item['position']) ? $item['position'] : $existing->repair_posi),
                            'repair_imguser'   => $imgStored,
                            'repair_imgwork'   => ''
                        ]);
                        $skippedCount++;
                        continue;
                    }
                }

                // 2. ออกเลขที่ใบงาน repair_order อัตโนมัติ (SKJRP_YYYYXXXX)
                $lastRecord = $db->table('tb_repair')->select('repair_order')->orderBy('repair_ID', 'DESC')->get()->getRow();
                if (!empty($lastRecord) && !empty($lastRecord->repair_order)) {
                    $sub = explode('_', $lastRecord->repair_order);
                    $seq = isset($sub[1]) ? ((int)$sub[1] + 1) : 1;
                    $orderNumber = $sub[0] . '_' . sprintf("%08d", $seq);
                } else {
                    $orderNumber = "SKJRP_" . date('Y') . "0001";
                }

                // 3. จัดหมวดหมู่งานซ่อม (Caselist)
                $caseList = 'ระบบคอมพิวเตอร์/เครือข่าย';
                $catLower = mb_strtolower($category . ' ' . $task, 'UTF-8');
                if (mb_strpos($catLower, 'เครื่องเสียง') !== false || mb_strpos($catLower, 'ภาพและเสียง') !== false || mb_strpos($catLower, 'led') !== false || mb_strpos($catLower, 'streaming') !== false) {
                    $caseList = 'ระบบโสตทัศนูปกรณ์';
                } elseif (mb_strpos($catLower, 'อินเทอร์เน็ต') !== false || mb_strpos($catLower, 'ระบบเครือข่าย') !== false || mb_strpos($catLower, 'wifi') !== false || mb_strpos($catLower, 'network') !== false) {
                    $caseList = 'ระบบอินเทอร์เน็ต/เครือข่าย';
                } elseif (mb_strpos($catLower, 'เครื่องพิมพ์') !== false || mb_strpos($catLower, 'ปริ้นเตอร์') !== false || mb_strpos($catLower, 'หมึกพิมพ์') !== false || mb_strpos($catLower, 'printer') !== false) {
                    $caseList = 'เครื่องพิมพ์/อุปกรณ์ต่อพ่วง';
                } elseif (mb_strpos($catLower, 'โปรแกรม') !== false || mb_strpos($catLower, 'ติดตั้งโปรแกรม') !== false || mb_strpos($catLower, 'it') !== false || mb_strpos($catLower, 'ระบบสารสนเทศ') !== false || mb_strpos($catLower, 'windows') !== false || mb_strpos($catLower, 'ระบบปฏิบัติการ') !== false) {
                    $caseList = 'ซอฟต์แวร์/ระบบปฏิบัติการ';
                }

                // 4. นำ Array ของ URL รูปภาพตัวเต็มจาก IT Support API มาจัดเก็บ
                $savedImages = [];
                $images = $item['images'] ?? [];
                if (!empty($images) && is_array($images)) {
                    foreach ($images as $imgObj) {
                        $imgUrl = is_array($imgObj) ? ($imgObj['url'] ?? '') : $imgObj;
                        if (!empty($imgUrl)) {
                            if (strpos($imgUrl, 'http') !== 0) {
                                $imgUrl = 'https://erc.nsnpao.go.th/' . ltrim($imgUrl, '/');
                            }
                            $savedImages[] = $imgUrl;
                        }
                    }
                }

                // จัดเก็บ URL รูปภาพเป็น JSON Array หรือ comma-separated string
                $imgStored = !empty($savedImages) ? json_encode($savedImages, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : '';

                // 5. ดึงตำแหน่งของเจ้าหน้าที่จาก IT Support API
                $staffPosition = !empty($item['recorded_by_position']) ? $item['recorded_by_position'] : (!empty($item['position']) ? $item['position'] : 'ผู้ช่วยนักวิชาการคอมพิวเตอร์');

                // เตรียมข้อมูลและบันทึกลง tb_repair
                $detailFormatted = (!empty($ticketCode) ? "[$ticketCode] " : "") . $task;

                $insertData = [
                    'repair_order'        => $orderNumber,
                    'repair_datetime'     => $ticketDate,
                    'repair_posi'         => $staffPosition,
                    'repair_userID'       => $session->get('id') ?: '0000',
                    'repair_phone'        => '-',
                    'repair_building'     => !empty($location) ? $location : 'อบจ.นครสวรรค์',
                    'repair_class'        => '',
                    'repair_room'         => '',
                    'repair_caselist'     => $caseList,
                    'repair_detail'       => $detailFormatted,
                    'repair_status'       => 'ดำเนินการเรียบร้อย',
                    // ผู้ดำเนินการซ่อม = ผู้ที่กดซิงค์ข้อมูล
                    'repair_Repairman'    => !empty($session->get('id')) && $session->get('id') !== '0000' ? $session->get('id') : ($session->get('fullname') ?: ($session->get('username') ?: 'ผู้ดูแลระบบ IT Support')),
                    'repair_datework'     => $ticketDate,
                    'repair_cause'        => 'นำเข้าจากประวัติงาน IT Support (' . $ticketCode . ')',
                    'repair_imguser'      => $imgStored,
                    'repair_imgwork'      => '',
                    'repair_usersignature'=> ''
                ];

                if ($tbRepair->insert($insertData)) {
                    $importedCount++;
                    $newOrders[] = [
                        'order'       => $orderNumber,
                        'ticket_code' => $ticketCode
                    ];
                }
            }

            return $this->response->setJSON([
                'status'         => 'success',
                'message'        => "นำเข้าข้อมูลสำเร็จ $importedCount รายการ (ข้ามรายการที่เคยนำเข้าแล้ว $skippedCount รายการ)",
                'imported_count' => $importedCount,
                'skipped_count'  => $skippedCount,
                'orders'         => $newOrders
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'เกิดข้อผิดพลาดในการนำเข้าข้อมูล: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * ลบข้อมูลการแจ้งซ่อม ลบไฟล์รูปภาพที่เกี่ยวข้อง และข้อมูลประเมิน/บันทึกข้อความ
     */
    public function DeleteOrder()
    {
        $session = session();
        $isAuth = $session->get('isLoggedIn') || $session->get('staffLogin') || $session->get('logged_in') || $session->get('id');
        if (!$isAuth) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'กรุณาเข้าสู่ระบบก่อนทำรายการ'
            ]);
        }

        $repairOrder = $this->request->getVar('repair_order');
        if (empty($repairOrder)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ไม่พบรหัสเลขที่ใบงานที่ต้องการลบ'
            ]);
        }

        $db = \Config\Database::connect();
        $repair = $db->table('tb_repair')->where('repair_order', $repairOrder)->get()->getRow();
        if (!$repair) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ไม่พบข้อมูลใบงานในระบบ'
            ]);
        }

        // ลบไฟล์รูปภาพในเครื่อง (ถ้าไม่ใช่ URL ภายนอก)
        $cleanImgs = function($raw) {
            if (empty($raw)) return [];
            $raw = trim($raw);
            if (strpos($raw, '[') === 0) {
                $j = json_decode($raw, true);
                if (is_array($j)) return $j;
            }
            return explode(',', $raw);
        };

        $allImages = array_merge(
            $cleanImgs($repair->repair_imguser ?? ''),
            $cleanImgs($repair->repair_imgwork ?? '')
        );

        $uploadDirs = [
            ROOTPATH . 'uploads/user/Repair/',
            ROOTPATH . 'uploads/User/Repair/',
            ROOTPATH . 'uploads/admin/Repair/'
        ];

        foreach ($allImages as $img) {
            $img = trim($img);
            if (empty($img)) continue;
            // ถ้าไม่ใช่ http/https url ให้ลบไฟล์ในเครื่อง
            if (strpos($img, 'http://') !== 0 && strpos($img, 'https://') !== 0) {
                foreach ($uploadDirs as $dir) {
                    $filePath = $dir . $img;
                    if (file_exists($filePath) && is_file($filePath)) {
                        @unlink($filePath);
                    }
                }
            }
        }

        // ลบข้อมูลการประเมิน
        if ($db->tableExists('tb_repair_evaluations')) {
            $db->table('tb_repair_evaluations')->where('repair_order', $repairOrder)->delete();
        }

        // ลบข้อมูลบันทึกข้อความ
        if ($db->tableExists('tb_repair_memo')) {
            $db->table('tb_repair_memo')->where('repair_order', $repairOrder)->delete();
        }

        // ลบใบงานหลัก
        $db->table('tb_repair')->where('repair_order', $repairOrder)->delete();

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'ลบข้อมูลการแจ้งซ่อมและไฟล์ที่เกี่ยวข้องเรียบร้อยแล้ว',
            'redirect' => base_url('Repair/Dashboard')
        ]);
    }
}
