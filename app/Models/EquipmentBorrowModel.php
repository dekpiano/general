<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipmentBorrowModel extends Model
{
    protected $table            = 'tb_equipment_borrows';
    protected $primaryKey       = 'borrow_id';
    protected $allowedFields    = [
        'borrow_code', 'borrower_type', 'user_id', 'borrower_name', 'borrower_org',
        'borrower_tel', 'borrower_idcard', 'doc_ref_file', 'borrow_date', 'due_date',
        'purpose', 'location', 'status', 'approved_by', 'approved_at', 'reject_reason',
        'pickup_date', 'pickup_officer', 'pickup_photo', 'pickup_remark',
        'return_date', 'return_officer', 'return_condition', 'return_photo', 'return_remark',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // ตรวจสอบและสร้างคอลัมน์ให้อัตโนมัติหากยังไม่มี (รองรับการพิมพ์รายการเอง)
    public function ensureColumns()
    {
        $db = \Config\Database::connect();
        if ($db->tableExists('tb_equipment_borrow_items')) {
            $fields = $db->getFieldData('tb_equipment_borrow_items');
            $existing = array_column($fields, 'name');
            $forge = \Config\Database::forge();

            $toAdd = [];
            if (!in_array('item_name', $existing)) {
                $toAdd['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true];
            }
            if (!in_array('item_unit', $existing)) {
                $toAdd['item_unit'] = ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true, 'default' => 'ชิ้น'];
            }
            if (!empty($toAdd)) {
                $forge->addColumn('tb_equipment_borrow_items', $toAdd);
                $db->query('ALTER TABLE tb_equipment_borrow_items MODIFY eq_id INT(11) UNSIGNED NULL');
            }
        }
    }

    // ดึงรายการคำขอยืมพร้อมรายการของ
    public function getBorrowWithItems($borrowId)
    {
        $this->ensureColumns();
        $borrow = $this->find($borrowId);
        if (!$borrow) {
            return null;
        }

        $db = \Config\Database::connect();
        $items = $db->table('tb_equipment_borrow_items as bi')
                    ->select('bi.*, COALESCE(eq.eq_name, bi.item_name) as display_name, COALESCE(eq.eq_unit, bi.item_unit, "ชิ้น") as display_unit, eq.eq_code, eq.eq_brand_model, eq.eq_image')
                    ->join('tb_equipments as eq', 'eq.eq_id = bi.eq_id', 'left')
                    ->where('bi.borrow_id', $borrowId)
                    ->get()
                    ->getResultArray();

        $borrow['items'] = $items;
        return $borrow;
    }

    // ดึงรายการคำขอยืมตามเงื่อนไข (User / Admin)
    public function getBorrowList($userId = null, $status = null, $type = null, $search = null)
    {
        $builder = $this->select('tb_equipment_borrows.*, 
                                 (SELECT COUNT(*) FROM tb_equipment_borrow_items WHERE tb_equipment_borrow_items.borrow_id = tb_equipment_borrows.borrow_id) as total_items,
                                 (SELECT SUM(qty) FROM tb_equipment_borrow_items WHERE tb_equipment_borrow_items.borrow_id = tb_equipment_borrows.borrow_id) as total_qty,
                                 (SELECT GROUP_CONCAT(CONCAT(COALESCE(e.eq_name, bi.item_name), " (", bi.qty, " ", COALESCE(e.eq_unit, bi.item_unit, "ชิ้น"), ")") SEPARATOR ", ") 
                                  FROM tb_equipment_borrow_items bi 
                                  LEFT JOIN tb_equipments e ON e.eq_id = bi.eq_id 
                                  WHERE bi.borrow_id = tb_equipment_borrows.borrow_id) as items_summary');

        if ($userId) {
            $builder->where('tb_equipment_borrows.user_id', $userId);
        }
        if ($status && $status !== 'all') {
            $builder->where('tb_equipment_borrows.status', $status);
        }
        if ($type && $type !== 'all') {
            $builder->where('tb_equipment_borrows.borrower_type', $type);
        }
        if ($search) {
            $builder->groupStart()
                    ->like('tb_equipment_borrows.borrow_code', $search)
                    ->orLike('tb_equipment_borrows.borrower_name', $search)
                    ->orLike('tb_equipment_borrows.borrower_org', $search)
                    ->orLike('tb_equipment_borrows.purpose', $search)
                    ->groupEnd();
        }

        return $builder->orderBy('tb_equipment_borrows.borrow_id', 'DESC')->findAll();
    }

    // สร้างเลขที่ใบยืมอัตโนมัติ (เช่น EQ-2608-0001)
    public function generateBorrowCode()
    {
        $prefix = 'EQ-' . date('ym') . '-';
        $db = \Config\Database::connect();
        $last = $db->table('tb_equipment_borrows')
                   ->like('borrow_code', $prefix, 'after')
                   ->orderBy('borrow_id', 'DESC')
                   ->limit(1)
                   ->get()
                   ->getRowArray();

        if ($last) {
            $lastNum = (int)substr($last['borrow_code'], -4);
            $nextNum = str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNum = '0001';
        }

        return $prefix . $nextNum;
    }
}
