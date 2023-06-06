<?php

namespace App\Controllers;

class ConUserHome extends BaseController
{  

    function __construct(){
       
    }


    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   
        $data['uri'] = service('uri'); 
        return $data;
    }

    public function index()
    {
    //    echo $this->googleClient->createAuthUrl();
    //     exit();
        $database = \Config\Database::connect();
        $builder = $database->table('tb_dictation');

        $data = $this->DataMain();
        $data['title']="หน้าแรก";
        $data['UrlMenuMain'] = '';
        $data['UrlMenuSub'] = '';

        $data['DictationAll'] = $builder->countAll();
       
       

        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserHome/UserPageHome')
                .view('User/UserLeyout/UserFooter');
    }


  

    
}
