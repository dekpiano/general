<?php

namespace App\Controllers;

class ConAdminRoles extends BaseController
{
    public function __construct(){
        $session = session();
        if(!$session->get('username') && $session->get('status') != "admin" && $session->get('status') != "manager"){
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

        $data['Manager'] = $tb_admin_rloes->select('admin_rloes_userid,admin_rloes_id,admin_rloes_nanetype')->get()->getResult();

        $data['NameTeacher'] = $DBPers->select('pers_id,pers_prefix,pers_firstname,pers_lastname,pers_position,pers_learning')
        ->orderBy('pers_learning')
        ->get()->getResult();

        //echo '<pre>'; print_r($data['Manager']); exit();

        return view('Admin/AdminLeyout/AdminHeader',$data)
                .view('Admin/AdminLeyout/AdminMenuLeft')
                .view('Admin/AdminRoles/AdminRolesMain')
                .view('Admin/AdminLeyout/AdminFooter');
    }

    public function RloesSettingManager() {      
        $database = \Config\Database::connect();
        $DBrloes = $database->table('tb_admin_rloes');
        $data = array('admin_rloes_userid' => $this->request->getVar('TeachID'));

        $DBrloes->where('admin_rloes_id',$this->request->getVar('RloesID'));
        $result = $DBrloes->update($data);
        echo $result;
    }
 

}
