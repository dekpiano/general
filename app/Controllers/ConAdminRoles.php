<?php

namespace App\Controllers;

class ConAdminRoles extends BaseController
{
    public function __construct(){
        $session = session();
        if(!$session->get('username') || $session->get('status') !== 'superadmin'){
            header("Location:".base_url('Admin/Home')); exit();
        } 
    }


    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $data['uri'] = service('uri'); 
        return $data;
    }

    public function index()
    {
        $data = $this->DataMain();
        $data['title']="จัดการข้อมูลกำหนดสิทธิ์การใช้งาน";
        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $tb_admin_rloes = $database->table('tb_admin_rloes');
        $DB_Personnel = \Config\Database::connect('personnel');
        $DBPers = $DB_Personnel->table('tb_personnel');

        $data['Manager'] = $tb_admin_rloes->select('admin_rloes_userid,admin_rloes_id,admin_rloes_nanetype,admin_rloes_level,admin_rloes_status')
        ->orderBy('admin_rloes_level','ASC')
        ->get()->getResult();

        $data['NameTeacher'] = $DBPers->select('pers_id, pers_prefix, pers_firstname, pers_lastname, pers_position, pers_img, pers_learning, skjacth_skj.tb_position.posi_name')
        ->join('skjacth_skj.tb_position', 'skjacth_personnel.tb_personnel.pers_position = skjacth_skj.tb_position.posi_id', 'left')
        ->where('pers_status', 'กำลังใช้งาน')
        ->orderBy('pers_position', 'ASC')
        ->get()->getResult();

        //echo '<pre>'; print_r($data['Manager']); exit();

        return view('Admin/AdminRoles/AdminRolesMain', $data);
    }

    public function SaveUserRoles()
    {
        $response = [
            'success' => false,
            'msg' => "เกิดข้อผิดพลาด"
        ];

        if ($this->request->is('post')) {
            $user_id = $this->request->getPost('user_id');
            $systems = $this->request->getPost('systems') ?: [];
            $level = $this->request->getPost('level');
            $status = $this->request->getPost('status');

            if (empty($user_id)) {
                $response['msg'] = "ไม่พบรหัสบุคลากร";
                return $this->response->setJSON($response);
            }

            $database = \Config\Database::connect();
            $builder = $database->table('tb_admin_rloes');

            // Check if user already exists
            $existing = $builder->where('admin_rloes_userid', $user_id)->get()->getRow();

            // If empty systems array and status is not superadmin, maybe delete? 
            // Or just save empty array.
            $data = [
                'admin_rloes_userid' => $user_id,
                'admin_rloes_nanetype' => json_encode($systems, JSON_UNESCAPED_UNICODE),
                'admin_rloes_level' => $level ?: '2/เจ้าหน้าที่',
                'admin_rloes_status' => $status ?: 'AdminGeneral'
            ];

            if ($existing) {
                // Update
                $builder->where('admin_rloes_userid', $user_id)->update($data);
            } else {
                // Insert
                $builder->insert($data);
            }

            $response = [
                'success' => true,
                'msg' => "บันทึกข้อมูลเรียบร้อย"
            ];
        }

        return $this->response->setJSON($response);
    }
    public function DeleteRole()
    {
        $response = [
            'success' => false,
            'msg' => "เกิดข้อผิดพลาด"
        ];

        if ($this->request->is('post')) {
            $user_id = $this->request->getPost('user_id');

            if (empty($user_id)) {
                $response['msg'] = "ไม่พบรหัสบุคลากร";
                return $this->response->setJSON($response);
            }

            $database = \Config\Database::connect();
            $builder = $database->table('tb_admin_rloes');
            $builder->where('admin_rloes_userid', $user_id)->delete();

            $response = [
                'success' => true,
                'msg' => "ลบสิทธิ์เรียบร้อยแล้ว"
            ];
        }

        return $this->response->setJSON($response);
    }
}
