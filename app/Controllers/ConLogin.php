<?php

namespace App\Controllers;

class ConLogin extends BaseController
{
    //$path = dirname(dirname(dirname(dirname((dirname(__FILE__))))));
	//require $path . '/skj.ac.th/public_html/librarie_skj/google_sheet/vendor/autoload.php';

    private $googleClient = null;
    private $GoogleButton = "";
    function __construct(){
        $path = dirname(dirname(dirname((dirname(__FILE__)))));
		require $path . '/librarie_skj/google_sheet/vendor/autoload.php';

        $redirect_uri = base_url('LoginEoffice');
        
        $this->googleClient = new \Google_Client();
        $this->googleClient->setClientId('975527477710-i15oq29ntmboi7e1mopolps0u29c98mm.apps.googleusercontent.com');
		$this->googleClient->setClientSecret('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');
        $this->googleClient->setRedirectUri($redirect_uri);
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');

        $this->GoogleButton = '<a href="'.$this->googleClient->createAuthUrl().'" class="btn btn-primary me-3 w-auto"><i class="tf-icons bx bxl-google-plus"></i> Login by Google </a>';
    }

    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['GoogleButton'] = $this->GoogleButton;
        $data['uri'] = service('uri'); 
        return $data;
    }

       
    public function LoginEoffice(){
      
        $data = $this->DataMain();
        $data['title']="หน้าแรก";
        $data['UrlMenuMain'] = '';
        $data['UrlMenuSub'] = '';

        $session = session();
        $DB_Personnel = \Config\Database::connect('personnel');
        $DBPers = $DB_Personnel->table('tb_personnel');

        if($this->request->getVar("code")){
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar("code"));
        
        if(!isset($token['error'])){
           
            $this->googleClient->setAccessToken($token['access_token']);           
            session()->set('AccessToken', $token['access_token']);
          

            $googleService = new \Google_Service_Oauth2($this->googleClient);  
            //echo '<pre>';print_r($googleService); exit();          
            $data = $googleService->userinfo->get();            
           
           
           $CheckEmail = $DBPers->where('pers_username', $data['email'])->get()->getRowArray()>0?true:false;
           if($CheckEmail && $data['email'] == 'thanis.k@skj.ac.th' || $data['email'] == 'dekpiano@skj.ac.th'){
                $UserData = array('login_oauth_uid' => $data['id'],
                                    'updated_at' => date('Y-m-d H:i:s'));
                $DBPers->where('pers_username', $data['email'])->update($UserData);
                
                $User = $DBPers->where('pers_username', $data['email'])->get()->getRowArray();
                echo "<pre>";print_r($User['pers_id']); 
                $newdata = [
                    'username'  => $User['pers_prefix'].$User['pers_firstname'].' '.$User['pers_lastname'],
                    'id'     => $User['pers_id'],
                    'logged_in' => true,
                ];                
                $session->set($newdata);                
                return redirect()->to(base_url('Admin/Home'));
           }
         

        }else{
            session()->set('Error', "Something went Wrong!");
           

        }
      
    }
        return view('User/UserLeyout/UserHeader',$data)
        .view('User/UserLeyout/UserMenuLeft')
        .view('Login/LoginGoogle')
        .view('User/UserLeyout/UserFooter');
          
    }

    public function LogOutEoffice(){
        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }
}
