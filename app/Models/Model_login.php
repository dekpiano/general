<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_login extends Model
{
    protected $db_personnel;
    protected $db_general;

    public function __construct()
    {
        parent::__construct();
        $this->db_general = \Config\Database::connect();
        $this->db_personnel = \Config\Database::connect('personnel');
    }

    public function check_login_teacher($email)
    {
        return $this->db_personnel->table('tb_personnel')
            ->where('pers_username', $email)
            ->countAllResults();
    }

    public function fetch_teacher_login($email)
    {
        $builder = $this->db_personnel->table('tb_personnel');
        $builder->select('tb_personnel.*, MAX(tb_admin_rloes.admin_rloes_status) AS admin_rloes_status, GROUP_CONCAT(tb_admin_rloes.admin_rloes_nanetype) AS rloesAll');
        $builder->join('skjacth_general.tb_admin_rloes', 'skjacth_general.tb_admin_rloes.admin_rloes_userid = tb_personnel.pers_id', 'left');
        $builder->where('tb_personnel.pers_username', $email);
        $builder->groupBy('tb_personnel.pers_id');
        return $builder->get()->getRow();
    }

    public function Update_user_data($data, $email)
    {
        return $this->db_personnel->table('tb_personnel')
            ->where('pers_username', $email)
            ->update($data);
    }
}
