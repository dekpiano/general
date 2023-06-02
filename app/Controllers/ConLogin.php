<?php

namespace App\Controllers;

class ConLogin extends BaseController
{
    private $googleClient = null;
    function __construct(){
        $path = dirname(dirname(dirname((dirname(__FILE__)))));
		require $path . '/librarie_skj/google_sheet/vendor/autoload.php';

        $this->googleClient = new \Google_Client();
        $this->googleClient->setClientId('29638025169-aeobhq04v0lvimcjd27osmhlpua380gl.apps.googleusercontent.com');
		$this->googleClient->setClientSecret('RSANANTRl84lnYm54Hi0icGa');
        $this->googleClient->setRedirectUri("http://localhost/eoffice/LoginEoffice");
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }

    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $data['uri'] = service('uri'); 
        return $data;
    }

       
    public function LoginEoffice(){
      
        $googleButton = '<>';

    }
}
