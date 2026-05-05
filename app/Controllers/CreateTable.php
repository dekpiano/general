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
            echo "Table 'tb_repair_evaluations' created successfully.";
        } else {
            echo "Table 'tb_repair_evaluations' already exists.";
        }
    }
}
