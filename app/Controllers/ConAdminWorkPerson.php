<?php

namespace App\Controllers;

class ConAdminWorkPerson extends BaseController
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
        $session = session();
        $data = $this->DataMain();
        $data['title']="ทะเบียนครูและบุคลากรทางการศึกษา";
        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $data['LocationRoomAll'] = $builder->countAll();

        return view('Admin/AdminLeyout/AdminHeader',$data)
                .view('Admin/AdminLeyout/AdminMenuLeft')
                .view('Admin/AdminWorkPerson/AdminPersonMain')
                .view('Admin/AdminLeyout/AdminFooter');
    }

    public function FormAdd(){
        $session = session();
        $data = $this->DataMain();
        $data['title']="เพิ่มข้อมูลครูและบุคลากรทางการศึกษา";
        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $data['LocationRoomAll'] = $builder->countAll();

        return view('Admin/AdminLeyout/AdminHeader',$data)
                .view('Admin/AdminLeyout/AdminMenuLeft')
                .view('Admin/AdminWorkPerson/AdminPersonAdd')
                .view('Admin/AdminLeyout/AdminFooter');
    }
   

}
