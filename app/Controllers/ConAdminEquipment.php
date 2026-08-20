<?php

namespace App\Controllers;

use App\Models\EquipmentModel;
use App\Models\EquipmentBorrowModel;
use App\Libraries\Datethai;

class ConAdminEquipment extends BaseController
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

    protected function isStaff()
    {
        $session = session();
        $rawRoles = $session->get('rloes') ?? '';
        $userRoles = is_string($rawRoles) ? array_map('trim', explode(',', $rawRoles)) : (json_decode($rawRoles, true) ?: []);
        $userStatus = $session->get('status') ?? '';
        $isLoggedIn = $session->has('id') || $session->has('username');
        return $isLoggedIn && (
            in_array($userStatus, ['superadmin', 'admin', 'AdminGeneral', 'ManagerGeneral', 'ExecutiveGeneral']) ||
            in_array('งานพัสดุและอุปกรณ์', $userRoles) ||
            !empty($session->get('is_admin'))
        );
    }

    // หน้ารายการคำขอยืม-คืนทั้งหมด สำหรับแอดมิน (อนุมัติ, จ่ายของ, ตรวจรับคืน)
    public function approveList()
    {
        $session = session();
        $data = $this->DataMain();
        $data['UrlMenuSub'] = 'EquipmentApprove';
        $data['title'] = 'จัดการรายการยืม-คืนพัสดุอุปกรณ์';

        $status = $this->request->getGet('status') ?? 'all';
        $borrowerType = $this->request->getGet('type') ?? 'all';
        $search = $this->request->getGet('search');

        $data['selectedStatus'] = $status;
        $data['selectedType'] = $borrowerType;
        $data['search'] = $search;

        $data['borrowList'] = $this->borrowModel->getBorrowList(null, $status, $borrowerType, $search);

        // นับสถิติภาพรวม
        $db = \Config\Database::connect();
        $data['countPending']  = $db->table('tb_equipment_borrows')->where('status', 'pending')->countAllResults();
        $data['countApproved'] = $db->table('tb_equipment_borrows')->where('status', 'approved')->countAllResults();
        $data['countBorrowed'] = $db->table('tb_equipment_borrows')->where('status', 'borrowed')->countAllResults();
        $data['countReturned'] = $db->table('tb_equipment_borrows')->where('status', 'returned')->countAllResults();

        return view('Admin/AdminEquipment/AdminEquipmentList', $data);
    }

    // หน้าจัดการทะเบียนพัสดุและสต็อก
    public function manageStock()
    {
        $data = $this->DataMain();
        $data['UrlMenuSub'] = 'EquipmentManage';
        $data['title'] = 'ทะเบียนและสต็อกพัสดุอุปกรณ์';

        $categoryId = $this->request->getGet('category') ?? 'all';
        $search = $this->request->getGet('search');

        $data['selectedCategory'] = $categoryId;
        $data['search'] = $search;
        $data['categories'] = $this->equipmentModel->getCategories(false);
        $data['equipments'] = $this->equipmentModel->getEquipmentsWithCategory($categoryId, null, $search);

        return view('Admin/AdminEquipment/AdminEquipmentStock', $data);
    }

    // หน้ารายละเอียดคำขอยืม (Admin Detail)
    public function detail($borrowId)
    {
        $data = $this->DataMain();
        $data['UrlMenuSub'] = 'EquipmentDetail';
        $data['title'] = 'รายละเอียดคำขอยืม-คืน';

        $borrow = $this->borrowModel->getBorrowWithItems($borrowId);
        if (!$borrow) {
            return redirect()->to(base_url('Admin/Equipment/Approve'))->with('error', 'ไม่พบข้อมูล');
        }

        $data['borrow'] = $borrow;
        return view('Admin/AdminEquipment/AdminEquipmentDetail', $data);
    }

    // Action: อนุมัติคำขอยืม
    public function approveBorrow()
    {
        if (!$this->isStaff()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์ดำเนินการนี้ กรุณาเข้าสู่ระบบด้วยบัญชีเจ้าหน้าที่']);
        }

        $session = session();
        $borrowId = $this->request->getPost('borrow_id');
        $approverName = $session->get('fullname') ?? 'เจ้าหน้าที่งานพัสดุ';

        $borrow = $this->borrowModel->find($borrowId);
        if (!$borrow) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลคำขอยืม']);
        }

        $this->borrowModel->update($borrowId, [
            'status'      => 'approved',
            'approved_by' => $approverName,
            'approved_at' => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'อนุมัติคำขอยืมเรียบร้อยแล้ว']);
    }

    // Action: ไม่อนุมัติคำขอยืม
    public function rejectBorrow()
    {
        if (!$this->isStaff()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์ดำเนินการนี้ กรุณาเข้าสู่ระบบด้วยบัญชีเจ้าหน้าที่']);
        }

        $session = session();
        $borrowId = $this->request->getPost('borrow_id');
        $rejectReason = trim($this->request->getPost('reject_reason') ?? '');
        $approverName = $session->get('fullname') ?? 'เจ้าหน้าที่งานพัสดุ';

        if (empty($rejectReason)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาระบุเหตุผลที่ไม่อนุมัติ']);
        }

        $this->borrowModel->update($borrowId, [
            'status'        => 'rejected',
            'approved_by'   => $approverName,
            'approved_at'   => date('Y-m-d H:i:s'),
            'reject_reason' => $rejectReason,
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกสถานะไม่อนุมัติเรียบร้อยแล้ว']);
    }

    // Action: บันทึกการส่งมอบ (จ่ายของ) พร้อมแนบรูปถ่ายหลักฐานตอนยืม
    public function savePickup()
    {
        if (!$this->isStaff()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์ดำเนินการนี้ กรุณาเข้าสู่ระบบด้วยบัญชีเจ้าหน้าที่']);
        }

        $session = session();
        $borrowId = $this->request->getPost('borrow_id');
        $pickupOfficer = trim($this->request->getPost('pickup_officer') ?? ($session->get('fullname') ?? 'เจ้าหน้าที่ผู้จ่ายของ'));
        $pickupRemark = trim($this->request->getPost('pickup_remark') ?? '');
        $pickupDate = $this->request->getPost('pickup_date') ?: date('Y-m-d H:i:s');

        $borrow = $this->borrowModel->getBorrowWithItems($borrowId);
        if (!$borrow) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลคำขอยืม']);
        }

        // จัดการอัปโหลดรูปถ่ายผู้ยืมคู่กับพัสดุตอนส่งมอบ (Pickup Photo สูงสุด 5 รูป) ไปยัง Remote Server
        $pickupPhotos = $this->request->getFileMultiple('pickup_photo');
        $uploadedPickup = [];
        if ($pickupPhotos) {
            $count = 0;
            foreach ($pickupPhotos as $file) {
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    if ($count >= 5) break;
                    $name = \App\Libraries\RemoteUploadService::upload($file, 'general/Equipment/docs', 'pickup');
                    if ($name) {
                        $uploadedPickup[] = $name;
                        $count++;
                    }
                }
            }
        }

        // Fallback หากส่งไฟล์เดี่ยว
        if (empty($uploadedPickup)) {
            $singlePickup = $this->request->getFile('pickup_photo');
            if ($singlePickup && $singlePickup->isValid() && !$singlePickup->hasMoved()) {
                $name = \App\Libraries\RemoteUploadService::upload($singlePickup, 'general/Equipment/docs', 'pickup');
                if ($name) {
                    $uploadedPickup[] = $name;
                }
            }
        }

        $pickupPhotoName = !empty($uploadedPickup) ? implode(',', $uploadedPickup) : null;

        $db = \Config\Database::connect();
        $db->transStart();

        // อัปเดตสถานะเป็น borrowed และตัดสต็อกคงเหลือ
        $updateData = [
            'status'         => 'borrowed',
            'pickup_date'    => $pickupDate,
            'pickup_officer' => $pickupOfficer,
            'pickup_remark'  => $pickupRemark,
            'updated_at'     => date('Y-m-d H:i:s')
        ];
        if ($pickupPhotoName) {
            $updateData['pickup_photo'] = $pickupPhotoName;
        }

        $this->borrowModel->update($borrowId, $updateData);

        // ตัดสต็อกคงเหลือของอุปกรณ์แต่ละชิ้น
        foreach ($borrow['items'] as $item) {
            $eq = $this->equipmentModel->find($item['eq_id']);
            if ($eq) {
                $newAvailable = max(0, $eq['available_qty'] - $item['qty']);
                $this->equipmentModel->update($item['eq_id'], ['available_qty' => $newAvailable]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการตัดสต็อกพัสดุ']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกการส่งมอบพัสดุและตัดสต็อกเรียบร้อยแล้ว']);
    }

    // Action: บันทึกการตรวจรับคืนพัสดุ พร้อมแนบรูปถ่ายหลักฐานตอนคืน & คืนสต็อก
    public function saveReturn()
    {
        if (!$this->isStaff()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์ดำเนินการนี้ กรุณาเข้าสู่ระบบด้วยบัญชีเจ้าหน้าที่']);
        }

        $session = session();
        $borrowId = $this->request->getPost('borrow_id');
        $returnOfficer = trim($this->request->getPost('return_officer') ?? ($session->get('fullname') ?? 'เจ้าหน้าที่ผู้รับคืน'));
        $returnCondition = $this->request->getPost('return_condition') ?? 'normal';
        $returnRemark = trim($this->request->getPost('return_remark') ?? '');
        $returnDate = $this->request->getPost('return_date') ?: date('Y-m-d H:i:s');

        $borrow = $this->borrowModel->getBorrowWithItems($borrowId);
        if (!$borrow) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลคำขอยืม']);
        }

        // จัดการอัปโหลดรูปถ่ายผู้คืนคู่กับสภาพพัสดุ (Return Photo สูงสุด 5 รูป) ไปยัง Remote Server
        $returnPhotos = $this->request->getFileMultiple('return_photo');
        $uploadedReturn = [];
        if ($returnPhotos) {
            $count = 0;
            foreach ($returnPhotos as $file) {
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    if ($count >= 5) break;
                    $name = \App\Libraries\RemoteUploadService::upload($file, 'general/Equipment/docs', 'return');
                    if ($name) {
                        $uploadedReturn[] = $name;
                        $count++;
                    }
                }
            }
        }

        // Fallback หากส่งไฟล์เดี่ยว
        if (empty($uploadedReturn)) {
            $singleReturn = $this->request->getFile('return_photo');
            if ($singleReturn && $singleReturn->isValid() && !$singleReturn->hasMoved()) {
                $name = \App\Libraries\RemoteUploadService::upload($singleReturn, 'general/Equipment/docs', 'return');
                if ($name) {
                    $uploadedReturn[] = $name;
                }
            }
        }

        $returnPhotoName = !empty($uploadedReturn) ? implode(',', $uploadedReturn) : null;

        $db = \Config\Database::connect();
        $db->transStart();

        $updateData = [
            'status'           => 'returned',
            'return_date'      => $returnDate,
            'return_officer'   => $returnOfficer,
            'return_condition' => $returnCondition,
            'return_remark'    => $returnRemark,
            'updated_at'       => date('Y-m-d H:i:s')
        ];
        if ($returnPhotoName) {
            $updateData['return_photo'] = $returnPhotoName;
        }

        $this->borrowModel->update($borrowId, $updateData);

        // คืนสต็อกคงเหลือ (หากสภาพไม่ใช่สูญหายทั้งหมด)
        if ($returnCondition !== 'lost') {
            foreach ($borrow['items'] as $item) {
                $eq = $this->equipmentModel->find($item['eq_id']);
                if ($eq) {
                    $newAvailable = min($eq['total_qty'], $eq['available_qty'] + $item['qty']);
                    $this->equipmentModel->update($item['eq_id'], ['available_qty' => $newAvailable]);
                }
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการคืนสต็อกพัสดุ']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกการส่งคืนพัสดุและอัปเดตสต็อกเรียบร้อยแล้ว']);
    }

    // Action: เพิ่มอุปกรณ์ใหม่
    public function insertEquipment()
    {
        $eqName = trim($this->request->getPost('eq_name') ?? '');
        $categoryId = $this->request->getPost('category_id');
        $eqCode = trim($this->request->getPost('eq_code') ?? '');
        $eqSerial = trim($this->request->getPost('eq_serial') ?? '');
        $eqBrand = trim($this->request->getPost('eq_brand_model') ?? '');
        $eqUnit = trim($this->request->getPost('eq_unit') ?? 'ชิ้น');
        $totalQty = (int)($this->request->getPost('total_qty') ?? 1);
        $eqLocation = trim($this->request->getPost('eq_location') ?? '');
        $eqDetail = trim($this->request->getPost('eq_detail') ?? '');

        if (empty($eqName) || empty($categoryId) || $totalQty <= 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณากรอกชื่อพัสดุ หมวดหมู่ และจำนวนให้ถูกต้อง']);
        }

        if (empty($eqCode)) {
            $eqCode = 'EQ-' . strtoupper(substr(uniqid(), -6));
        }

        // จัดการอัปโหลดรูปภาพพัสดุ ไปยัง Remote Server
        $eqImage = $this->request->getFile('eq_image');
        $imageName = null;
        if ($eqImage && $eqImage->isValid() && !$eqImage->hasMoved()) {
            $imageName = \App\Libraries\RemoteUploadService::upload($eqImage, 'general/Equipment/items', 'eq');
        }

        $insertData = [
            'eq_code'        => $eqCode,
            'eq_name'        => $eqName,
            'category_id'    => $categoryId,
            'eq_serial'      => $eqSerial,
            'eq_brand_model' => $eqBrand,
            'eq_unit'        => $eqUnit,
            'total_qty'      => $totalQty,
            'available_qty'  => $totalQty,
            'eq_location'    => $eqLocation,
            'eq_image'       => $imageName,
            'eq_detail'      => $eqDetail,
            'eq_status'      => 'active',
            'created_at'     => date('Y-m-d H:i:s'),
        ];

        $this->equipmentModel->insert($insertData);
        return $this->response->setJSON(['status' => 'success', 'message' => 'เพิ่มพัสดุอุปกรณ์สำเร็จ']);
    }

    // Action: แก้ไขอุปกรณ์
    public function updateEquipment()
    {
        $eqId = $this->request->getPost('eq_id');
        $eq = $this->equipmentModel->find($eqId);
        if (!$eq) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลพัสดุ']);
        }

        $eqName = trim($this->request->getPost('eq_name') ?? '');
        $categoryId = $this->request->getPost('category_id');
        $eqCode = trim($this->request->getPost('eq_code') ?? $eq['eq_code']);
        $eqSerial = trim($this->request->getPost('eq_serial') ?? '');
        $eqBrand = trim($this->request->getPost('eq_brand_model') ?? '');
        $eqUnit = trim($this->request->getPost('eq_unit') ?? 'ชิ้น');
        $totalQty = (int)($this->request->getPost('total_qty') ?? $eq['total_qty']);
        $availableQty = (int)($this->request->getPost('available_qty') ?? $eq['available_qty']);
        $eqLocation = trim($this->request->getPost('eq_location') ?? '');
        $eqDetail = trim($this->request->getPost('eq_detail') ?? '');
        $eqStatus = $this->request->getPost('eq_status') ?? 'active';

        $updateData = [
            'eq_code'        => $eqCode,
            'eq_name'        => $eqName,
            'category_id'    => $categoryId,
            'eq_serial'      => $eqSerial,
            'eq_brand_model' => $eqBrand,
            'eq_unit'        => $eqUnit,
            'total_qty'      => $totalQty,
            'available_qty'  => $availableQty,
            'eq_location'    => $eqLocation,
            'eq_detail'      => $eqDetail,
            'eq_status'      => $eqStatus,
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        // รูปภาพใหม่ (ถ้ามี) อัปโหลดไปยัง Remote Server
        $eqImage = $this->request->getFile('eq_image');
        if ($eqImage && $eqImage->isValid() && !$eqImage->hasMoved()) {
            $updateData['eq_image'] = \App\Libraries\RemoteUploadService::upload($eqImage, 'general/Equipment/items', 'eq');
        }

        $this->equipmentModel->update($eqId, $updateData);
        return $this->response->setJSON(['status' => 'success', 'message' => 'แก้ไขข้อมูลพัสดุสำเร็จ']);
    }

    // Action: ลบอุปกรณ์
    public function deleteEquipment()
    {
        $eqId = $this->request->getPost('eq_id');
        $this->equipmentModel->delete($eqId);
        return $this->response->setJSON(['status' => 'success', 'message' => 'ลบรายการพัสดุเรียบร้อยแล้ว']);
    }

    // Action: เพิ่ม/แก้ไขหมวดหมู่
    public function saveCategory()
    {
        $catId = $this->request->getPost('category_id');
        $catName = trim($this->request->getPost('category_name') ?? '');
        $catIcon = trim($this->request->getPost('category_icon') ?? 'bx-box');
        $catStatus = $this->request->getPost('category_status') ?? 'active';

        if (empty($catName)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณากรอกชื่อหมวดหมู่']);
        }

        $db = \Config\Database::connect();
        if ($catId) {
            $db->table('tb_equipment_categories')->where('category_id', $catId)->update([
                'category_name'   => $catName,
                'category_icon'   => $catIcon,
                'category_status' => $catStatus,
                'updated_at'      => date('Y-m-d H:i:s')
            ]);
        } else {
            $db->table('tb_equipment_categories')->insert([
                'category_name'   => $catName,
                'category_icon'   => $catIcon,
                'category_status' => $catStatus,
                'created_at'      => date('Y-m-d H:i:s')
            ]);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลหมวดหมู่เรียบร้อย']);
    }

    // Action: ลบข้อมูลคำขอยืมทั้งหมด รายการพัสดุ และไฟล์รูปภาพทั้งหมดที่เกี่ยวข้อง (Permanent Delete)
    public function deleteBorrow()
    {
        if (!$this->isStaff()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์ดำเนินการนี้ กรุณาเข้าสู่ระบบด้วยบัญชีเจ้าหน้าที่']);
        }

        $borrowId = $this->request->getPost('borrow_id');
        if (empty($borrowId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่ระบุรหัสคำขอที่ต้องการลบ']);
        }

        $borrow = $this->borrowModel->getBorrowWithItems($borrowId);
        if (!$borrow) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลคำขอยืม']);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. หากคำขอกำลังอยู่ในสถานะ borrowed (กำลังใช้งาน) ให้คืนสต็อกพัสดุกลับเข้าคงเหลือ
        if ($borrow['status'] === 'borrowed' && !empty($borrow['items'])) {
            foreach ($borrow['items'] as $item) {
                if (!empty($item['eq_id'])) {
                    $eq = $this->equipmentModel->find($item['eq_id']);
                    if ($eq) {
                        $newAvailable = min($eq['total_qty'], $eq['available_qty'] + $item['qty']);
                        $this->equipmentModel->update($item['eq_id'], ['available_qty' => $newAvailable]);
                    }
                }
            }
        }

        // 2. ลบไฟล์รูปภาพทั้งหมดที่เกี่ยวข้อง        // ลบไฟล์หลักฐานต่างๆ จาก Remote Server
        if (!empty($borrow['doc_ref_file'])) {
            \App\Libraries\RemoteUploadService::deleteFile($borrow['doc_ref_file'], 'general/Equipment/docs');
        }
        if (!empty($borrow['pickup_photo'])) {
            \App\Libraries\RemoteUploadService::deleteFile($borrow['pickup_photo'], 'general/Equipment/docs');
        }
        if (!empty($borrow['return_photo'])) {
            \App\Libraries\RemoteUploadService::deleteFile($borrow['return_photo'], 'general/Equipment/docs');
        }

        // 3. ลบรายการสิ่งของใน tb_equipment_borrow_items
        $db->table('tb_equipment_borrow_items')->where('borrow_id', $borrowId)->delete();

        // 4. ลบข้อมูลคำขอหลักใน tb_equipment_borrows
        $this->borrowModel->delete($borrowId);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'ลบข้อมูลคำขอยืมและรูปภาพทั้งหมดเรียบร้อยแล้ว']);
    }

    // Action: ลบไฟล์รูปภาพขยะทั้งหมดที่ไม่มีชื่ออยู่ในฐานข้อมูล (Cleanup Orphan Files)
    public function cleanupOrphanImages()
    {
        if (!$this->isStaff()) {
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
}

