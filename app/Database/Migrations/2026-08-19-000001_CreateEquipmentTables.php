<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEquipmentTables extends Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();
        $db = \Config\Database::connect();

        // 1. หมวดหมู่พัสดุอุปกรณ์
        if (!$db->tableExists('tb_equipment_categories')) {
            $forge->addField([
                'category_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'category_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '150',
                ],
                'category_icon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'default'    => 'bx-box',
                ],
                'category_status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['active', 'inactive'],
                    'default'    => 'active',
                ],
                'created_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                ],
                'updated_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                ],
            ]);
            $forge->addKey('category_id', true);
            $forge->createTable('tb_equipment_categories');
        }

        // 2. รายการพัสดุอุปกรณ์
        if (!$db->tableExists('tb_equipments')) {
            $forge->addField([
                'eq_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'eq_code' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                ],
                'eq_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                ],
                'category_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'eq_serial' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'eq_brand_model' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '150',
                    'null'       => true,
                ],
                'eq_unit' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                    'default'    => 'ชิ้น',
                ],
                'total_qty' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 1,
                ],
                'available_qty' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 1,
                ],
                'eq_location' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '150',
                    'null'       => true,
                ],
                'eq_image' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'eq_detail' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                'eq_status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['active', 'maintenance', 'retired'],
                    'default'    => 'active',
                ],
                'created_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                ],
                'updated_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                ],
            ]);
            $forge->addKey('eq_id', true);
            $forge->addKey('eq_code');
            $forge->addKey('category_id');
            $forge->createTable('tb_equipments');
        }

        // 3. ตารางคำขอยืม-คืน
        if (!$db->tableExists('tb_equipment_borrows')) {
            $forge->addField([
                'borrow_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'borrow_code' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                ],
                'borrower_type' => [
                    'type'       => 'ENUM',
                    'constraint' => ['internal', 'external'],
                    'default'    => 'internal',
                ],
                'user_id' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                    'null'       => true,
                ],
                'borrower_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '150',
                ],
                'borrower_org' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '200',
                    'null'       => true,
                ],
                'borrower_tel' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '30',
                ],
                'borrower_idcard' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '20',
                    'null'       => true,
                ],
                'doc_ref_file' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'borrow_date' => [
                    'type' => 'DATE',
                ],
                'due_date' => [
                    'type' => 'DATE',
                ],
                'purpose' => [
                    'type' => 'TEXT',
                ],
                'location' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['pending', 'approved', 'rejected', 'borrowed', 'returned', 'cancelled', 'overdue'],
                    'default'    => 'pending',
                ],
                'approved_by' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'approved_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'reject_reason' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                // Pickup Info & Photo
                'pickup_date' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'pickup_officer' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'pickup_photo' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'pickup_remark' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                // Return Info & Photo
                'return_date' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'return_officer' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'return_condition' => [
                    'type'       => 'ENUM',
                    'constraint' => ['normal', 'damaged', 'lost'],
                    'default'    => 'normal',
                ],
                'return_photo' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'return_remark' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                'created_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                ],
                'updated_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                ],
            ]);
            $forge->addKey('borrow_id', true);
            $forge->addKey('borrow_code');
            $forge->addKey('status');
            $forge->createTable('tb_equipment_borrows');
        }

        // 4. ตารางรายการพัสดุในแต่ละคำขอยืม
        if (!$db->tableExists('tb_equipment_borrow_items')) {
            $forge->addField([
                'item_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'borrow_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'eq_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'qty' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 1,
                ],
                'item_condition_before' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'default'    => 'สภาพปกติพร้อมใช้งาน',
                ],
                'item_condition_after' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
            ]);
            $forge->addKey('item_id', true);
            $forge->addKey('borrow_id');
            $forge->addKey('eq_id');
            $forge->createTable('tb_equipment_borrow_items');
        }
    }

    public function down()
    {
        $forge = \Config\Database::forge();
        $forge->dropTable('tb_equipment_borrow_items', true);
        $forge->dropTable('tb_equipment_borrows', true);
        $forge->dropTable('tb_equipments', true);
        $forge->dropTable('tb_equipment_categories', true);
    }
}
