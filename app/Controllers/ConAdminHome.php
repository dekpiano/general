<?php

namespace App\Controllers;

class ConAdminHome extends BaseController
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
        $data['title']="หน้าแรก";
        $database = \Config\Database::connect();
                $builder = $database->table('tb_location');
        $data['LocationRoomAll'] = $builder->countAll();

                        $builder = $database->table('tb_school_car');
        $data['CarAll'] = $builder->countAll();

        $builder = $database->table('tb_car_driver');
        $data['DriverAll'] = $builder->countAll();
        return view('Admin/AdminHome/AdminPageHome', $data);
    }

    public function User()
    {
        $session = session();
        $data = $this->DataMain();
        $data['title']="หน้าแรก";

        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserHome/UserPageHome')
                .view('User/UserLeyout/UserFooter');
    }    

}
