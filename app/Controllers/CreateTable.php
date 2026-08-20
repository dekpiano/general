<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class CreateTable extends Controller
{
    public function index()
    {
        $db = Database::connect();
        $forge = \Config\Database::forge();

        if (!$db->tableExists('tb_repair_evaluations')) {
            $forge->addField([
                'eval_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'repair_order' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                ],
                'eval_score_speed' => [
                    'type'       => 'INT',
                    'constraint' => 1,
                ],
                'eval_score_quality' => [
                    'type'       => 'INT',
                    'constraint' => 1,
                ],
                'eval_score_service' => [
                    'type'       => 'INT',
                    'constraint' => 1,
                ],
                'eval_comment' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                'eval_datetime' => [
                    'type' => 'DATETIME',
                ],
            ]);
            $forge->addKey('eval_id', true);
            $forge->addKey('repair_order'); // Add index for faster lookup
            $forge->createTable('tb_repair_evaluations');
            echo "Table 'tb_repair_evaluations' created successfully.<br>";
        }

        // Equipment System Tables
        if (!$db->tableExists('tb_equipment_categories')) {
            $forge->addField([
                'category_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'category_name' => ['type' => 'VARCHAR', 'constraint' => '150'],
                'category_icon' => ['type' => 'VARCHAR', 'constraint' => '100', 'default' => 'bx-box'],
                'category_status' => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('category_id', true);
            $forge->createTable('tb_equipment_categories');
            
            // Insert initial default categories
            $db->table('tb_equipment_categories')->insertBatch([
                ['category_name' => 'อุปกรณ์โสตทัศนูปกรณ์ / ICT', 'category_icon' => 'bx-camera', 'category_status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
                ['category_name' => 'อุปกรณ์และเครื่องมือช่าง', 'category_icon' => 'bx-wrench', 'category_status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
                ['category_name' => 'อุปกรณ์จัดสถานที่ / โต๊ะ-เก้าอี้-เต็นท์', 'category_icon' => 'bx-buildings', 'category_status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
                ['category_name' => 'อุปกรณ์กีฬา / สันทนาการ', 'category_icon' => 'bx-football', 'category_status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
                ['category_name' => 'เครื่องใช้และอุปกรณ์สำนักงาน', 'category_icon' => 'bx-printer', 'category_status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ]);
            echo "Table 'tb_equipment_categories' created successfully.<br>";
        }

        if (!$db->tableExists('tb_equipments')) {
            $forge->addField([
                'eq_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'eq_code' => ['type' => 'VARCHAR', 'constraint' => '50'],
                'eq_name' => ['type' => 'VARCHAR', 'constraint' => '255'],
                'category_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'eq_serial' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'eq_brand_model' => ['type' => 'VARCHAR', 'constraint' => '150', 'null' => true],
                'eq_unit' => ['type' => 'VARCHAR', 'constraint' => '50', 'default' => 'ชิ้น'],
                'total_qty' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
                'available_qty' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
                'eq_location' => ['type' => 'VARCHAR', 'constraint' => '150', 'null' => true],
                'eq_image' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'eq_detail' => ['type' => 'TEXT', 'null' => true],
                'eq_status' => ['type' => 'ENUM', 'constraint' => ['active', 'maintenance', 'retired'], 'default' => 'active'],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('eq_id', true);
            $forge->addKey('eq_code');
            $forge->addKey('category_id');
            $forge->createTable('tb_equipments');
            echo "Table 'tb_equipments' created successfully.<br>";
        }

        if (!$db->tableExists('tb_equipment_borrows')) {
            $forge->addField([
                'borrow_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'borrow_code' => ['type' => 'VARCHAR', 'constraint' => '50'],
                'borrower_type' => ['type' => 'ENUM', 'constraint' => ['internal', 'external'], 'default' => 'internal'],
                'user_id' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true],
                'borrower_name' => ['type' => 'VARCHAR', 'constraint' => '150'],
                'borrower_org' => ['type' => 'VARCHAR', 'constraint' => '200', 'null' => true],
                'borrower_tel' => ['type' => 'VARCHAR', 'constraint' => '30'],
                'borrower_idcard' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
                'doc_ref_file' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'borrow_date' => ['type' => 'DATE'],
                'due_date' => ['type' => 'DATE'],
                'purpose' => ['type' => 'TEXT'],
                'location' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected', 'borrowed', 'returned', 'cancelled', 'overdue'], 'default' => 'pending'],
                'approved_by' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'approved_at' => ['type' => 'DATETIME', 'null' => true],
                'reject_reason' => ['type' => 'TEXT', 'null' => true],
                'pickup_date' => ['type' => 'DATETIME', 'null' => true],
                'pickup_officer' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'pickup_photo' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'pickup_remark' => ['type' => 'TEXT', 'null' => true],
                'return_date' => ['type' => 'DATETIME', 'null' => true],
                'return_officer' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'return_condition' => ['type' => 'ENUM', 'constraint' => ['normal', 'damaged', 'lost'], 'default' => 'normal'],
                'return_photo' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'return_remark' => ['type' => 'TEXT', 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('borrow_id', true);
            $forge->addKey('borrow_code');
            $forge->addKey('status');
            $forge->createTable('tb_equipment_borrows');
            echo "Table 'tb_equipment_borrows' created successfully.<br>";
        }

        if (!$db->tableExists('tb_equipment_borrow_items')) {
            $forge->addField([
                'item_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'borrow_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'eq_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'qty' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
                'item_condition_before' => ['type' => 'VARCHAR', 'constraint' => '255', 'default' => 'สภาพปกติพร้อมใช้งาน'],
                'item_condition_after' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            ]);
            $forge->addKey('item_id', true);
            $forge->addKey('borrow_id');
            $forge->addKey('eq_id');
            $forge->createTable('tb_equipment_borrow_items');
            echo "Table 'tb_equipment_borrow_items' created successfully.<br>";
        }

        echo "All tables initialized.";
    }
}
