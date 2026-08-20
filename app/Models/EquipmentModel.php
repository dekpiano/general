<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipmentModel extends Model
{
    protected $table            = 'tb_equipments';
    protected $primaryKey       = 'eq_id';
    protected $allowedFields    = [
        'eq_code', 'eq_name', 'category_id', 'eq_serial', 'eq_brand_model',
        'eq_unit', 'total_qty', 'available_qty', 'eq_location', 'eq_image',
        'eq_detail', 'eq_status', 'created_at', 'updated_at'
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // ดึงข้อมูลอุปกรณ์พร้อมชื่อหมวดหมู่
    public function getEquipmentsWithCategory($categoryId = null, $status = null, $keyword = null)
    {
        $builder = $this->select('tb_equipments.*, c.category_name, c.category_icon')
                        ->join('tb_equipment_categories as c', 'c.category_id = tb_equipments.category_id', 'left');

        if ($categoryId && $categoryId !== 'all') {
            $builder->where('tb_equipments.category_id', $categoryId);
        }
        if ($status) {
            $builder->where('tb_equipments.eq_status', $status);
        }
        if ($keyword) {
            $builder->groupStart()
                    ->like('tb_equipments.eq_name', $keyword)
                    ->orLike('tb_equipments.eq_code', $keyword)
                    ->orLike('tb_equipments.eq_brand_model', $keyword)
                    ->orLike('tb_equipments.eq_serial', $keyword)
                    ->groupEnd();
        }

        return $builder->orderBy('tb_equipments.eq_id', 'DESC')->findAll();
    }

    // หมวดหมู่ทั้งหมด
    public function getCategories($onlyActive = true)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_equipment_categories');
        if ($onlyActive) {
            $builder->where('category_status', 'active');
        }
        return $builder->orderBy('category_id', 'ASC')->get()->getResultArray();
    }
}
