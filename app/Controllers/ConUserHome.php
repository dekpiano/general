<?php

namespace App\Controllers;

class ConUserHome extends BaseController
{
    private $googleClient = null;
    function __construct(){
        $path = dirname(dirname(dirname((dirname(__FILE__)))));
		require $path . '/librarie_skj/google_sheet/vendor/autoload.php';

        $redirect_uri = base_url('LoginEoffice');
        
        $this->googleClient = new \Google_Client();
        $this->googleClient->setClientId('29638025169-aeobhq04v0lvimcjd27osmhlpua380gl.apps.googleusercontent.com');
		$this->googleClient->setClientSecret('RSANANTRl84lnYm54Hi0icGa');
        $this->googleClient->setRedirectUri($redirect_uri);
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
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
       
        $data['GoogleButton'] = '<a href="'.$this->googleClient->createAuthUrl().'" class="btn btn-primary me-3 w-auto"><i class="tf-icons bx bxl-google-plus"></i> Login by Google </a>';

        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserHome/UserPageHome')
                .view('User/UserLeyout/UserFooter');
    }

    public function LoginEoffice(){

        //echo $this->request->getVar("code");exit();
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar("code"));
        
        if(!isset($token['error'])){
           
            $this->googleClient->setAccessToken($token['access_token']);           
            session()->set('AccessToken', $token['access_token']);
          

            $googleService = new \Google_Service_Oauth2($this->googleClient);  
            //echo '<pre>';print_r($googleService); exit();          
            $data = $googleService->userinfo->get();
            
            echo "<pre>";print_r($data);

        }else{
            session()->set('Error', "Something went Wrong!");
            return redirect()->to(base_url());
        }
    }
}
