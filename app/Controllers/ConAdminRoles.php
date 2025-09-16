<?php

namespace App\Controllers;

class ConAdminRoles extends BaseController
{
    public function __construct(){
        $session = session();
        if(!$session->get('username') && $session->get('status') != "AdminGeneral" && $session->get('status') != "ManagerGeneral"){
            header("Location:".base_url()); exit();
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

        $data['NameTeacher'] = $DBPers->select('pers_id,pers_prefix,pers_firstname,pers_lastname,pers_position,pers_learning')
        ->where('pers_status','กำลังใช้งาน')
        ->orderBy('pers_position','ASC')
        ->get()->getResult();

        //echo '<pre>'; print_r($data['Manager']); exit();

        return view('Admin/AdminRoles/AdminRolesMain', $data);
    }

    public function RloesSettingManager() {      
        $database = \Config\Database::connect();
        $DBrloes = $database->table('tb_admin_rloes');
        $data = array('admin_rloes_userid' => $this->request->getVar('TeachID'));

        $DBrloes->where('admin_rloes_level',$this->request->getVar('RloesLevel'));
        $DBrloes->where('admin_rloes_nanetype',$this->request->getVar('Keytype'));
        $DBrloes->where('admin_rloes_id',$this->request->getVar('RloesID'));
        $result = $DBrloes->update($data);
        echo $result;
    }

    public function AddRole()
    {
        $response = [
            'success' => false,
            'msg' => "An error occurred."
        ];

        if ($this->request->getMethod() === 'post') {
            $database = \Config\Database::connect();
            $builder = $database->table('tb_admin_rloes');

            $data = [
                'admin_rloes_userid' => $this->request->getPost('user_id'),
                'admin_rloes_nanetype' => $this->request->getPost('role_group'),
                'admin_rloes_level' => $this->request->getPost('role_level'),
                'admin_rloes_status' => 'AdminGeneral'
            ];

            // Basic validation
            if (empty($data['admin_rloes_userid']) || empty($data['admin_rloes_nanetype']) || empty($data['admin_rloes_level'])) {
                $response['msg'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
                return $this->response->setJSON($response);
            }

            if ($builder->insert($data)) {
                $response = [
                    'success' => true,
                    'msg' => "บันทึกข้อมูลเรียบร้อย"
                ];
            } else {
                $response['msg'] = "ไม่สามารถบันทึกข้อมูลได้";
            }
        } else {
            $response['msg'] = "Invalid request method.";
        }

        return $this->response->setJSON($response);
    }

    public function DeleteRole()
    {
        $response = [
            'success' => false,
            'msg' => "An error occurred."
        ];

        if ($this->request->getMethod() === 'post') {
            $rloes_id = $this->request->getPost('rloes_id');

            if (empty($rloes_id)) {
                $response['msg'] = "Role ID is missing.";
                return $this->response->setJSON($response);
            }

            $database = \Config\Database::connect();
            $builder = $database->table('tb_admin_rloes');
            
            $builder->where('admin_rloes_id', $rloes_id);
            if ($builder->delete()) {
                $response = [
                    'success' => true,
                    'msg' => "ลบข้อมูลตำแหน่งเรียบร้อยแล้ว"
                ];
            } else {
                $response['msg'] = "ไม่สามารถลบข้อมูลได้";
            }
        } else {
            $response['msg'] = "Invalid request method.";
        }

        return $this->response->setJSON($response);
    }
     public function AddDepartment()
    {
        if ($this->request->getMethod() === 'post') {
            $departmentName = $this->request->getPost('department_name');

            if (empty($departmentName)) {
                return $this->response->setJSON(['success' => false, 'msg' => 'กรุณากรอกชื่องาน']);
            }

            $database = \Config\Database::connect();
            $builder = $database->table('tb_admin_rloes');

            // Check if a role with this department name already exists
            $existing = $builder->where('admin_rloes_nanetype', $departmentName)->get()->getRow();
            if ($existing) {
                return $this->response->setJSON(['success' => false, 'msg' => 'มีงานชื่อนี้อยู่ในระบบแล้ว']);
            }

            // Create a placeholder role for the new department.
            $data = [
                'admin_rloes_userid'   => '',
                'admin_rloes_nanetype' => $departmentName,
                'admin_rloes_level'    => '1/หัวหน้างาน',
                'admin_rloes_status'   => 'AdminGeneral'
            ];

            if ($builder->insert($data)) {
                return $this->response->setJSON(['success' => true, 'msg' => 'เพิ่มงานใหม่สำเร็จ']);
            } else {
                return $this->response->setJSON(['success' => false, 'msg' => 'ไม่สามารถบันทึกข้อมูลลงฐานข้อมูลได้']);
            }
        }
        return redirect()->back();
    }
 

}
