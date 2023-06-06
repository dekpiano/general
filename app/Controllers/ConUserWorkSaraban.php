<?php

namespace App\Controllers;

class ConUserWorkSaraban extends BaseController
{
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
       $data['uri'] = service('uri'); 
       $data['GoogleButton'] = $this->GoogleButton;
        return $data;
    }

    public function InstructionMain()
    {
        $data = $this->DataMain();
        $data['title']="หนังสือคำสั่ง";
        $data['UrlMenuMain'] = 'WorkSaraban';
        $data['UrlMenuSub'] = 'InstructionMain';
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserSaraban/UserInstructionBookMain')
                .view('User/UserLeyout/UserFooter');
    }

    public function DictationInsert()
    {  
        helper(['form', 'url']);
         
        $database = \Config\Database::connect();
        $builder = $database->table('tb_dictation');
        $validateImage = $this->validate([
            'file' => [
                'uploaded[dicta_file]',
                'max_size[dicta_file, 10000]',
            ],
        ]);
    
        $response = [
            'success' => false,
            'data' => '',
            'msg' => "อัพโหลดไฟล์ไม่ถูกต้อง"
        ];
        if ($validateImage) {
            $imageFile = $this->request->getFile('dicta_file');
            $type = $imageFile->getMimeType();
            $newName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'uploads/User/dictation/',$newName);
            $data = [
                'dicta_year' => $this->request->getPost('dicta_year'),
                'dicta_number' => $this->request->getPost('dicta_number'),
                'dicta_createdate' => $this->request->getPost('dicta_createdate'),
                'dicta_title' => $this->request->getPost('dicta_title'),
                'dicta_file'  => $newName
            ];
            $save = $builder->insert($data);
            $response = [
                'success' => true,
                'data' => $save,
                'msg' => "บันทึกข้อมูลเรียบร้อย"
            ];
        }
        return $this->response->setJSON($response);
    }

    public function DictationShowData(){
      
        $database = \Config\Database::connect();
        $builder = $database->table('tb_dictation');

        $DictationRecords = $builder->get()->getResult();
        $data = array();
        foreach ($DictationRecords as $row) {
            $data[] = array(
               "dicta_year"=>$row->dicta_year,
               "dicta_number"=>$row->dicta_number,
               "dicta_createdate"=>$row->dicta_createdate,
               "dicta_title"=>$row->dicta_title,
               "dicta_file"=>$row->dicta_file
            );
         }

         $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
       // echo '<pre>'; print_r($data);


    }
}
