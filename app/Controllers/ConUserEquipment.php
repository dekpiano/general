<?php

namespace App\Controllers;

use App\Models\EquipmentModel;
use App\Models\EquipmentBorrowModel;
use App\Libraries\Datethai;

class ConUserEquipment extends BaseController
{
    protected $equipmentModel;
    protected $borrowModel;
    protected $datethai;

    public function __construct()
    {
        $this->equipmentModel = new EquipmentModel();
        $this->borrowModel = new EquipmentBorrowModel();
        $this->datethai = new Datethai();
    }

    public function DataMain()
    {
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['uri'] = service('uri');
        $data['UrlMenuMain'] = 'Equipment';
        return $data;
    }

    // หน้าแรก / แคตตาล็อกพัสดุอุปกรณ์ที่เปิดให้ยืม
    public function index()
    {
        $session = session();
        $data = $this->DataMain();
        $data['UrlMenuSub'] = 'EquipmentMain';
        $data['title'] = 'ระบบยืม-คืนพัสดุอุปกรณ์';
        $data['description'] = 'รายการพัสดุ อุปกรณ์โสตทัศนูปกรณ์ เครื่องมือช่าง และอุปกรณ์ส่วนกลางสำหรับยืมใช้งาน';

        $data['categories'] = $this->equipmentModel->getCategories();
        
        $categoryId = $this->request->getGet('category') ?? 'all';
        $keyword = $this->request->getGet('q');
        
        $data['selectedCategory'] = $categoryId;
        $data['keyword'] = $keyword;
        $data['equipments'] = $this->equipmentModel->getEquipmentsWithCategory($categoryId, 'active', $keyword);

        $db = \Config\Database::connect();
        // สถิติภาพรวม
        $data['countPending']  = $db->table('tb_equipment_borrows')->where('status', 'pending')->countAllResults();
        $data['countApproved'] = $db->table('tb_equipment_borrows')->where('status', 'approved')->countAllResults();
        $data['countBorrowed'] = $db->table('tb_equipment_borrows')->where('status', 'borrowed')->countAllResults();
        $data['countReturned'] = $db->table('tb_equipment_borrows')->where('status', 'returned')->countAllResults();

        // ดึงรายการคำขอยืมล่าสุดทั้งหมด (ทั้งคนในและคนนอก) สูงสุด 20 รายการ
        $data['recentBorrows'] = $this->borrowModel->getBorrowList(null, 'all', 'all', null);

        // นับสถิติภาพรวมของผู้ใช้ปัจจุบัน (ถ้าล็อกอิน)
        $userId = $session->get('id');
        $data['myActiveBorrows'] = 0;
        if ($userId) {
            $data['myActiveBorrows'] = $db->table('tb_equipment_borrows')
                ->where('user_id', $userId)
                ->whereIn('status', ['pending', 'approved', 'borrowed'])
                ->countAllResults();
        }

        return view('User/UserEquipment/UserEquipmentMain', $data);
    }

    // หน้าแบบฟอร์มยื่นคำขอยืม
    public function add()
    {
        $session = session();
        $data = $this->DataMain();
        $data['UrlMenuSub'] = 'EquipmentAdd';
        $data['title'] = 'ยื่นคำขอยืมพัสดุอุปกรณ์';
        $data['description'] = 'แบบฟอร์มสำหรับบุคลากรภายในและหน่วยงานภายนอกในการขอยืมพัสดุอุปกรณ์';

        $data['categories'] = $this->equipmentModel->getCategories();
        $data['equipments'] = $this->equipmentModel->where('eq_status', 'active')->where('available_qty >', 0)->findAll();

        $selectedEqId = $this->request->getGet('item_id');
        $data['preselectedItem'] = null;
        if ($selectedEqId) {
            $data['preselectedItem'] = $this->equipmentModel->find($selectedEqId);
        }

        // ดึงข้อมูลบุคลากรพร้อมชื่อกลุ่มสาระภาษาไทย (lear_namethai)
        $userId = $session->get('id');
        $data['userPersonnel'] = null;
        if ($userId) {
            $dbPers = \Config\Database::connect('personnel');
            $pers = $dbPers->table('tb_personnel')
                           ->select('tb_personnel.*, skjacth_skj.tb_learning.lear_namethai, skjacth_skj.tb_position.posi_name')
                           ->join('skjacth_skj.tb_learning', 'skjacth_skj.tb_learning.lear_id = tb_personnel.pers_learning', 'left')
                           ->join('skjacth_skj.tb_position', 'skjacth_skj.tb_position.posi_id = tb_personnel.pers_position', 'left')
                           ->where('tb_personnel.pers_id', $userId)
                           ->get()
                           ->getRowArray();
            $data['userPersonnel'] = $pers;
        }

        // ระบบแคปช่าคณิตศาสตร์ง่ายๆ (Math Captcha)
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $session->set('equipment_captcha', $num1 + $num2);
        $data['num1'] = $num1;
        $data['num2'] = $num2;

        return view('User/UserEquipment/UserEquipmentAdd', $data);
    }

    // หน้าประวัติและติดตามสถานะการยืม (ทั้งคนในและคนนอก)
    public function history()
    {
        $session = session();
        $data = $this->DataMain();
        $data['UrlMenuSub'] = 'EquipmentHistory';
        $data['title'] = 'ติดตามสถานะ & ประวัติการยืม-คืนพัสดุ';
        $data['description'] = 'ตรวจสอบสถานะคำขอยืมและประวัติการส่งคืนพัสดุอุปกรณ์';

        $userId = $session->get('id');
        $status = $this->request->getGet('status') ?? 'all';
        $type   = $this->request->getGet('type') ?? 'all';
        $search = $this->request->getGet('search');

        $data['selectedStatus'] = $status;
        $data['selectedType']   = $type;
        $data['search']         = $search;

        $filterUserId = ($type === 'my' && $userId) ? $userId : null;
        $data['borrowList'] = $this->borrowModel->getBorrowList($filterUserId, $status, $type, $search);

        return view('User/UserEquipment/UserEquipmentHistory', $data);
    }

    // หน้ารายละเอียดคำขอ & พิมพ์ใบยืม
    public function detail($borrowId)
    {
        $data = $this->DataMain();
        $data['UrlMenuSub'] = 'EquipmentDetail';
        $data['title'] = 'รายละเอียดคำขอยืมพัสดุ';
        $data['description'] = 'รายละเอียดข้อมูลและสถานะคำขอยืม-คืนพัสดุอุปกรณ์';

        $borrow = $this->borrowModel->getBorrowWithItems($borrowId);
        if (!$borrow) {
            return redirect()->to(base_url('Equipment'))->with('error', 'ไม่พบข้อมูลคำขอยืม');
        }

        $data['borrow'] = $borrow;
        return view('User/UserEquipment/UserEquipmentDetail', $data);
    }

    // หน้า Print ใบคำขอยืม
    public function printOrder($borrowId)
    {
        $borrow = $this->borrowModel->getBorrowWithItems($borrowId);
        if (!$borrow) {
            return redirect()->to(base_url('Equipment'))->with('error', 'ไม่พบข้อมูล');
        }

        $borrowerPosition = '';
        if (!empty($borrow['user_id'])) {
            $dbPers = \Config\Database::connect('personnel');
            $pers = $dbPers->table('tb_personnel')
                           ->select('skjacth_skj.tb_position.posi_name')
                           ->join('skjacth_skj.tb_position', 'skjacth_skj.tb_position.posi_id = tb_personnel.pers_position', 'left')
                           ->where('tb_personnel.pers_id', $borrow['user_id'])
                           ->get()
                           ->getRowArray();
            $borrowerPosition = $pers['posi_name'] ?? '';
        }

        // ดึงรายชื่อผู้มีอำนาจลงนาม / พิจารณาความเห็นจากฐานข้อมูล
        $dbGeneral = \Config\Database::connect();
        $dbPersonnel = \Config\Database::connect('personnel');

        // 1. หัวหน้างานอาคารสถานที่
        $headBuildings = $dbGeneral->table('tb_admin_rloes')
            ->select('pers_prefix, pers_firstname, pers_lastname')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id', 'left')
            ->groupStart()
                ->like('admin_rloes_nanetype', 'งานอาคารสถานที่')
                ->orLike('admin_rloes_nanetype', 'อาคารสถานที่')
                ->orLike('admin_rloes_nanetype', 'งานพัสดุและอุปกรณ์')
            ->groupEnd()
            ->where('admin_rloes_level LIKE', '1/%')
            ->get()->getRow();

        // 2. รองผู้อำนวยการบริหารทั่วไป
        $deputyExecutive = $dbGeneral->table('tb_admin_rloes')
            ->select('pers_prefix, pers_firstname, pers_lastname')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id', 'left')
            ->groupStart()
                ->like('admin_rloes_nanetype', 'รองผู้อำนวยการบริหารทั่วไป')
                ->orLike('admin_rloes_nanetype', 'บริหารทั่วไป')
            ->groupEnd()
            ->get()->getRow();

        // 3. ผู้อำนวยการโรงเรียน
        $director = $dbGeneral->table('tb_admin_rloes')
            ->select('pers_prefix, pers_firstname, pers_lastname')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id', 'left')
            ->like('admin_rloes_nanetype', 'ผู้อำนวยการ')
            ->get()->getRow();

        // Fallback: หากใน tb_admin_rloes ยังไม่ได้ตั้งค่าไว้ ให้ค้นหาจากตำแหน่งใน tb_personnel โดยตรง
        if (!$director) {
            $director = $dbPersonnel->table('tb_personnel')
                ->select('pers_prefix, pers_firstname, pers_lastname')
                ->join('skjacth_skj.tb_position', 'skjacth_personnel.tb_personnel.pers_position = skjacth_skj.tb_position.posi_id', 'left')
                ->where('skjacth_skj.tb_position.posi_name LIKE', '%ผู้อำนวยการโรงเรียน%')
                ->where('pers_status', 'กำลังใช้งาน')
                ->get()->getRow();
        }

        if (!$deputyExecutive) {
            $deputyExecutive = $dbPersonnel->table('tb_personnel')
                ->select('pers_prefix, pers_firstname, pers_lastname')
                ->join('skjacth_skj.tb_position', 'skjacth_personnel.tb_personnel.pers_position = skjacth_skj.tb_position.posi_id', 'left')
                ->where('skjacth_skj.tb_position.posi_name LIKE', '%รองผู้อำนวยการ%')
                ->where('pers_status', 'กำลังใช้งาน')
                ->get()->getRow();
        }

        $data['HeadBuildings'] = $headBuildings;
        $data['DeputyExecutive'] = $deputyExecutive;
        $data['Director'] = $director;

        $data['title'] = 'แบบขอยืมพัสดุอุปกรณ์ - ' . ($borrow['borrow_code'] ?? '');
        $data['description'] = 'เอกสารแบบฟอร์มขอยืมพัสดุอุปกรณ์';
        $data['Datethai'] = $this->datethai;
        $data['borrow'] = $borrow;
        $data['borrowerPosition'] = $borrowerPosition;
        return view('User/UserEquipment/UserEquipmentPrint', $data);
    }

    // หน้าตรวจสอบและอนุมัติคำขอยืม (สำหรับเจ้าหน้าที่ / แสดงในหน้าบ้าน UserLayout)
    public function approveList()
    {
        $session = session();
        $rawRoles = $session->get('rloes') ?? '';
        $userRoles = is_string($rawRoles) ? array_map('trim', explode(',', $rawRoles)) : (json_decode($rawRoles, true) ?: []);
        $userStatus = $session->get('status') ?? '';
        $isLoggedIn = $session->has('id') || $session->has('username');
        $isStaff = $isLoggedIn && (
            in_array($userStatus, ['superadmin', 'admin', 'AdminGeneral', 'ManagerGeneral', 'ExecutiveGeneral']) ||
            in_array('งานพัสดุและอุปกรณ์', $userRoles) ||
            !empty($session->get('is_admin'))
        );

        if (!$isStaff) {
            return redirect()->to(base_url('Equipment'))->with('error', 'เฉพาะเจ้าหน้าที่งานพัสดุและผู้ดูแลระบบเท่านั้นที่สามารถเข้าถึงหน้านี้ได้');
        }

        $data = $this->DataMain();
        $data['UrlMenuSub'] = 'EquipmentApprove';
        $data['title'] = 'รายการอนุมัติ & รับ-ส่งคืนพัสดุ';
        $data['description'] = 'ตรวจสอบคำขอ พิจารณาอนุมัติ ส่งมอบพัสดุ และตรวจรับคืน';
        $data['Datethai'] = $this->datethai;

        $db = \Config\Database::connect();
        $data['countPending']  = $db->table('tb_equipment_borrows')->where('status', 'pending')->countAllResults();
        $data['countApproved'] = $db->table('tb_equipment_borrows')->where('status', 'approved')->countAllResults();
        $data['countBorrowed'] = $db->table('tb_equipment_borrows')->where('status', 'borrowed')->countAllResults();
        $data['countReturned'] = $db->table('tb_equipment_borrows')->where('status', 'returned')->countAllResults();

        $status = $this->request->getGet('status') ?? 'all';
        $type   = $this->request->getGet('type') ?? 'all';
        $search = $this->request->getGet('search');

        $data['selectedStatus'] = $status;
        $data['selectedType']   = $type;
        $data['search']         = $search;
        $data['borrowList']     = $this->borrowModel->getBorrowList(null, $status, $type, $search);

        return view('User/UserEquipment/UserEquipmentApprove', $data);
    }

    // หน้าจัดการสต็อกพัสดุ (สำหรับเจ้าหน้าที่ / แสดงในหน้าบ้าน UserLayout)
    public function manageStock()
    {
        $session = session();
        $rawRoles = $session->get('rloes') ?? '';
        $userRoles = is_string($rawRoles) ? array_map('trim', explode(',', $rawRoles)) : (json_decode($rawRoles, true) ?: []);
        $userStatus = $session->get('status') ?? '';
        $isLoggedIn = $session->has('id') || $session->has('username');
        $isStaff = $isLoggedIn && (
            in_array($userStatus, ['superadmin', 'admin', 'AdminGeneral', 'ManagerGeneral', 'ExecutiveGeneral']) ||
            in_array('งานพัสดุและอุปกรณ์', $userRoles) ||
            !empty($session->get('is_admin'))
        );

        if (!$isStaff) {
            return redirect()->to(base_url('Equipment'))->with('error', 'เฉพาะเจ้าหน้าที่งานพัสดุและผู้ดูแลระบบเท่านั้นที่สามารถเข้าถึงหน้านี้ได้');
        }

        $data = $this->DataMain();
        $data['UrlMenuSub'] = 'EquipmentManage';
        $data['title'] = 'จัดการสต็อกพัสดุอุปกรณ์';
        $data['description'] = 'เพิ่ม แก้ไข ลบ และตรวจสอบสต็อกพัสดุคงเหลือ';

        $category = $this->request->getGet('category') ?? 'all';
        $search   = $this->request->getGet('search');

        $data['selectedCategory'] = $category;
        $data['search']           = $search;
        $data['categories']       = $this->equipmentModel->getCategories();
        $data['equipments']       = $this->equipmentModel->getEquipmentsWithCategory($category, $search);

        return view('User/UserEquipment/UserEquipmentStock', $data);
    }

    // หน้ารายละเอียดคำขอสำหรับเจ้าหน้าที่ (UserLayout)
    public function staffDetail($borrowId)
    {
        $data = $this->DataMain();
        $data['UrlMenuSub'] = 'EquipmentApprove';
        $data['title'] = 'รายละเอียดคำขอยืม (เจ้าหน้าที่)';
        $data['description'] = 'ตรวจสอบคำขอ บันทึกจ่ายของ และบันทึกรับคืนพัสดุ';
        $data['Datethai'] = $this->datethai;

        $borrow = $this->borrowModel->getBorrowWithItems($borrowId);
        if (!$borrow) {
            return redirect()->to(base_url('Equipment/Approve'))->with('error', 'ไม่พบข้อมูลคำขอยืม');
        }

        $data['borrow'] = $borrow;
        return view('User/UserEquipment/UserEquipmentStaffDetail', $data);
    }

    // Action: บันทึกยื่นคำขอยืม (AJAX / POST)
    public function insertBorrow()
    {
        $session = session();
        $request = $this->request;

        $borrowerType = $request->getPost('borrower_type') ?? 'internal';
        $borrowerName = trim($request->getPost('borrower_name') ?? '');
        $borrowerOrg  = trim($request->getPost('borrower_org') ?? '');
        $borrowerTel  = trim($request->getPost('borrower_tel') ?? '');
        $borrowerIdcard = trim($request->getPost('borrower_idcard') ?? '');
        // ฟังก์ชันช่วยแปลงวันที่จากรูปแบบต่างๆ (เช่น 2569-08-19 หรือ 19/08/2569 หรือ 2026-08-19) ให้เป็น Y-m-d (ค.ศ.) เสมอ
        $parseDate = function($inputDate) {
            if (empty($inputDate)) return date('Y-m-d');
            $inputDate = trim($inputDate);

            // ถ้ามาเป็น d/m/Y (เช่น 19/08/2569 หรือ 19/08/2026)
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $inputDate, $matches)) {
                $day   = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
                $year  = (int)$matches[3];
                if ($year > 2400) {
                    $year -= 543; // แปลง พ.ศ. เป็น ค.ศ.
                }
                return sprintf('%04d-%02d-%02d', $year, $month, $day);
            }

            // ถ้ามาเป็น Y-m-d (เช่น 2569-08-19 หรือ 2026-08-19)
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $inputDate, $matches)) {
                $year  = (int)$matches[1];
                $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
                $day   = str_pad($matches[3], 2, '0', STR_PAD_LEFT);
                if ($year > 2400) {
                    $year -= 543; // แปลง พ.ศ. เป็น ค.ศ.
                }
                return sprintf('%04d-%02d-%02d', $year, $month, $day);
            }

            $ts = strtotime($inputDate);
            return ($ts !== false && $ts > 0) ? date('Y-m-d', $ts) : date('Y-m-d');
        };

        $borrowDate = $parseDate($request->getPost('borrow_date'));
        $dueDate    = $parseDate($request->getPost('due_date'));

        $purpose      = trim($request->getPost('purpose') ?? '');
        $location     = trim($request->getPost('location') ?? '');
        $items        = $request->getPost('items'); // Array of items

        // บังคับตรวจสอบ Login สำหรับบุคลากรภายใน
        $userId = $session->get('id');
        if ($borrowerType === 'internal' && empty($userId)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'สำหรับบุคลากรภายในโรงเรียน กรุณาเข้าสู่ระบบก่อนทำรายการ'
            ]);
        }

        // ตรวจสอบแคปช่า (สำหรับบุคคลภายนอก หรือผู้ที่ไม่ได้เข้าสู่ระบบ)
        if ($borrowerType === 'external' || empty($userId)) {
            $captchaInput = (int)$request->getPost('captcha_input');
            $captchaExpected = (int)$session->get('equipment_captcha');
            $captchaClientAnswer = (int)$request->getPost('captcha_answer'); // fallback
            
            $isValidCaptcha = false;
            if ($captchaExpected > 0 && $captchaInput === $captchaExpected) {
                $isValidCaptcha = true;
            } elseif ($captchaClientAnswer > 0 && $captchaInput === $captchaClientAnswer) {
                $isValidCaptcha = true;
            }

            if (!$isValidCaptcha) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'ผลลัพธ์แคปช่า (ตัวเลขกันบอท) ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง'
                ]);
            }
        }

        if (empty($borrowerName) || empty($borrowerTel) || empty($purpose) || empty($items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณากรอกข้อมูลและเลือกรายการพัสดุให้ครบถ้วน']);
        }

        if (strtotime($dueDate) < strtotime($borrowDate)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'วันที่ส่งคืนต้องไม่น้อยกว่าวันที่ยืม']);
        }

        // จัดการอัปโหลดไฟล์รูปภาพประกอบ (สูงสุด 5 รูป) ไปยัง Remote Server (เหมือนระบบอื่น)
        $docFiles = $this->request->getFileMultiple('doc_ref_file');
        $uploadedImages = [];

        if ($docFiles) {
            $count = 0;
            foreach ($docFiles as $file) {
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    if ($count >= 5) break; // จำกัดสูงสุด 5 รูป
                    $uploadedName = \App\Libraries\RemoteUploadService::upload($file, 'general/Equipment/docs', 'doc');
                    if ($uploadedName) {
                        $uploadedImages[] = $uploadedName;
                        $count++;
                    }
                }
            }
        }

        // กรณีส่งไฟล์เดี่ยว (Fallback)
        if (empty($uploadedImages)) {
            $singleFile = $this->request->getFile('doc_ref_file');
            if ($singleFile && $singleFile->isValid() && !$singleFile->hasMoved()) {
                $uploadedName = \App\Libraries\RemoteUploadService::upload($singleFile, 'general/Equipment/docs', 'doc');
                if ($uploadedName) {
                    $uploadedImages[] = $uploadedName;
                }
            }
        }

        $docFileName = !empty($uploadedImages) ? implode(',', $uploadedImages) : null;

        $borrowCode = $this->borrowModel->generateBorrowCode();
        $userId = ($borrowerType === 'internal') ? ($session->get('id') ?? $request->getPost('user_id')) : null;

        $borrowData = [
            'borrow_code'     => $borrowCode,
            'borrower_type'   => $borrowerType,
            'user_id'         => $userId,
            'borrower_name'   => $borrowerName,
            'borrower_org'    => $borrowerOrg,
            'borrower_tel'    => $borrowerTel,
            'borrower_idcard' => $borrowerIdcard,
            'doc_ref_file'    => $docFileName,
            'borrow_date'     => $borrowDate,
            'due_date'        => $dueDate,
            'purpose'         => $purpose,
            'location'        => $location,
            'status'          => 'pending',
            'created_at'      => date('Y-m-d H:i:s'),
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        $this->borrowModel->ensureColumns();
        $borrowId = $this->borrowModel->insert($borrowData);

        // บันทึกรายการพัสดุ (รองรับทั้งเลือกจากระบบ หรือพิมพ์ชื่อเอง)
        foreach ($items as $item) {
            $eqId     = !empty($item['eq_id']) ? (int)$item['eq_id'] : null;
            $itemName = trim($item['item_name'] ?? '');
            $qty      = (int)($item['qty'] ?? 1);
            $itemUnit = trim($item['item_unit'] ?? 'ชิ้น');

            if ($qty > 0) {
                if ($eqId) {
                    // กรณีเลือกจากรายการในระบบ
                    $eq = $this->equipmentModel->find($eqId);
                    $db->table('tb_equipment_borrow_items')->insert([
                        'borrow_id'             => $borrowId,
                        'eq_id'                 => $eqId,
                        'item_name'             => $eq ? $eq['eq_name'] : $itemName,
                        'qty'                   => $qty,
                        'item_unit'             => $eq ? $eq['eq_unit'] : $itemUnit,
                        'item_condition_before' => 'สภาพปกติพร้อมใช้งาน',
                    ]);
                } elseif (!empty($itemName)) {
                    // กรณีพิมพ์ชื่อรายการพัสดุเอง
                    $db->table('tb_equipment_borrow_items')->insert([
                        'borrow_id'             => $borrowId,
                        'eq_id'                 => null,
                        'item_name'             => $itemName,
                        'qty'                   => $qty,
                        'item_unit'             => !empty($itemUnit) ? $itemUnit : 'ชิ้น',
                        'item_condition_before' => 'สภาพปกติพร้อมใช้งาน',
                    ]);
                }
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาลองใหม่อีกครั้ง']);
        }

        return $this->response->setJSON([
            'status'      => 'success',
            'message'     => 'ยื่นคำขอยืมพัสดุเรียบร้อยแล้ว เลขที่คำขอ: ' . $borrowCode,
            'borrow_id'   => $borrowId,
            'borrow_code' => $borrowCode
        ]);
    }

    // Action: ยกเลิกคำขอยืม (เฉพาะสถานะ pending)
    public function cancelBorrow()
    {
        $borrowId = $this->request->getPost('borrow_id');
        $borrow = $this->borrowModel->find($borrowId);

        if (!$borrow) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลคำขอยืม']);
        }

        if ($borrow['status'] !== 'pending') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถยกเลิกคำขอที่ผ่านการดำเนินการแล้วได้']);
        }

        $this->borrowModel->update($borrowId, [
            'status'     => 'cancelled',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'ยกเลิกคำขอยืมเรียบร้อยแล้ว']);
    }

    // Action: ลบไฟล์รูปภาพขยะทั้งหมดที่ไม่มีชื่ออยู่ในฐานข้อมูล (Cleanup Orphan Files)
    public function cleanupOrphanImages()
    {
        $session = session();
        $rawRoles = $session->get('rloes') ?? '';
        $userRoles = is_string($rawRoles) ? array_map('trim', explode(',', $rawRoles)) : (json_decode($rawRoles, true) ?: []);
        $userStatus = $session->get('status') ?? '';
        $isLoggedIn = $session->has('id') || $session->has('username');
        $isStaff = $isLoggedIn && (
            in_array($userStatus, ['superadmin', 'admin', 'AdminGeneral', 'ManagerGeneral', 'ExecutiveGeneral']) ||
            in_array('งานพัสดุและอุปกรณ์', $userRoles) ||
            !empty($session->get('is_admin'))
        );

        if (!$isStaff) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์ดำเนินการนี้ กรุณาเข้าสู่ระบบด้วยบัญชีเจ้าหน้าที่']);
        }

        $db = \Config\Database::connect();
        
        // 1. ดึงชื่อไฟล์รูปภาพทั้งหมดที่ใช้งานอยู่ใน tb_equipment_borrows
        $borrows = $db->table('tb_equipment_borrows')
            ->select('doc_ref_file, pickup_photo, return_photo')
            ->get()->getResultArray();

        $activeFiles = [];
        foreach ($borrows as $b) {
            foreach (['doc_ref_file', 'pickup_photo', 'return_photo'] as $field) {
                if (!empty($b[$field])) {
                    $parts = explode(',', $b[$field]);
                    foreach ($parts as $p) {
                        $p = trim($p);
                        if (!empty($p)) {
                            $activeFiles[] = $p;
                        }
                    }
                }
            }
        }

        // 2. ดึงชื่อไฟล์รูปภาพพัสดุใน tb_equipments
        $equipments = $db->table('tb_equipments')
            ->select('eq_image')
            ->get()->getResultArray();
        foreach ($equipments as $eq) {
            if (!empty($eq['eq_image'])) {
                $activeFiles[] = trim($eq['eq_image']);
            }
        }

        $activeFiles = array_unique($activeFiles);

        // 3. สั่งให้ RemoteUploadService ลบไฟล์ขยะ
        $resDocs = \App\Libraries\RemoteUploadService::cleanupOrphanFiles($activeFiles, 'general/Equipment/docs');
        $resItems = \App\Libraries\RemoteUploadService::cleanupOrphanFiles($activeFiles, 'general/Equipment/items');

        $totalDeleted = $resDocs['deleted_count'] + $resItems['deleted_count'];

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => "ตรวจสอบและล้างไฟล์ขยะเรียบร้อยแล้ว (ลบไฟล์ขยะออกทั้งหมด {$totalDeleted} ไฟล์)",
            'deleted_count' => $totalDeleted,
            'details' => [
                'docs'  => $resDocs,
                'items' => $resItems
            ]
        ]);
    }

    // API ดึงรายการพัสดุพร้อมยืม (สำหรับ Dropdown/Select2 ในฟอร์ม)
    public function getAvailableItems()
    {
        $categoryId = $this->request->getGet('category_id');
        $builder = $this->equipmentModel->where('eq_status', 'active')->where('available_qty >', 0);
        if ($categoryId && $categoryId !== 'all') {
            $builder->where('category_id', $categoryId);
        }
        $items = $builder->findAll();
        return $this->response->setJSON($items);
    }
}
