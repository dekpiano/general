<?php

namespace App\Controllers;

use App\Models\AdminModels;
use App\Models\FoodReportModel;
use phpseclib3\Net\SFTP;

class ConUserFoodReport extends BaseController
{
    public function __construct()
    {
        $this->AdminModels = new AdminModels();
        $this->FoodReportModel = new FoodReportModel();
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
        $data['UrlMenuMain'] = 'FoodReport';
        $data['UrlMenuSub'] = 'FoodReportMain';
        
        $data['title'] = 'รายงานอาหาร';
        $data['description'] = 'รายงานอาหารมื้ออาหาร';
        // Pass sftp paths to the view for use in JS
        $data['sftp_partweb'] = env('sftp.partweb');
        $data['sftp_partfullweb'] = env('sftp.partfullweb');
        
        echo view('User/UserFoodReport/PageFoodReportMain', $data);
    }

    public function foodReportInsert()
    {
        // SFTP Configuration
        $sftp_host = getenv('sftp.host');
        $sftp_port = getenv('sftp.port');
        $sftp_user = getenv('sftp.user');
        $sftp_pass = getenv('sftp.pass');
        $base_remote_dir = getenv('sftp.remoteDir');

        $food_date = $this->request->getVar('food_date');
        $food_meal = $this->request->getVar('food_meal');
        $food_menu = $this->request->getVar('food_menu');

        $image_names = [];
        $files = $this->request->getFiles();

        if ($files && isset($files['food_images'])) {
            // Connect to SFTP server once before the loop
            $sftp = new SFTP($sftp_host, $sftp_port);
            if (!$sftp->login($sftp_user, $sftp_pass)) {
                // Handle login failure
                return $this->response->setJSON(['status' => 'error', 'message' => 'SFTP login failed.']);
            }

            // Create a new directory based on the current date
            $date_folder = date('Y-m-d');
            $remote_dir = $base_remote_dir . '/' . $date_folder;

            // Check if the directory exists, and create it if it doesn't
            if (!$sftp->is_dir($remote_dir)) {
                if (!$sftp->mkdir($remote_dir, -1, true)) { // true for recursive creation
                     return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to create remote directory.']);
                }
            }

            foreach ($files['food_images'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $local_temp_path = $img->getTempName();

                    // Upload to the date-specific directory on the SFTP server from temp file
                    $sftp->put($remote_dir . '/' . $newName, $local_temp_path, SFTP::SOURCE_LOCAL_FILE);
                    
                    $image_names[] = $newName;
                }
            }
        }

        $food_images_json = json_encode($image_names);

        $data = [
            'food_date' => $food_date,
            'food_meal' => $food_meal,
            'food_menu' => $food_menu,
            'food_images' => $food_images_json,
        ];

        if ($this->FoodReportModel->foodReportInsert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
    }

    public function foodReportUpdate()
    {
        $fr_id = $this->request->getVar('fr_id');
        $data = [
            'fr_name' => $this->request->getVar('fr_name'),
            'fr_price' => $this->request->getVar('fr_price'),
            'fr_quantity' => $this->request->getVar('fr_quantity'),
            'fr_details' => $this->request->getVar('fr_details'),
        ];
        $this->FoodReportModel->foodReportUpdate($fr_id, $data);
        return $this->response->setJSON(['success' => 'แก้ไขข้อมูลสำเร็จ']);
    }

    public function foodReportDelete()
    {
        $fr_id = $this->request->getVar('fr_id');
        $this->FoodReportModel->foodReportDelete($fr_id);
        return $this->response->setJSON(['success' => 'ลบข้อมูลสำเร็จ']);
    }

    public function print($food_id = null)
    {
        $data = $this->DataMain();

        $report = $this->FoodReportModel
            ->select('tb_food_reports.*, p.pers_prefix, p.pers_firstname, p.pers_lastname')
            ->join('skjacth_personnel.tb_personnel as p', 'p.pers_id = tb_food_reports.food_admin', 'left')
            ->find($food_id);

        $data['food_report'] = $report;

        if (empty($data['food_report'])) {
            // Handle report not found
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Food report not found: ' . $food_id);
        }
        
        $data['title'] = 'พิมพ์รายงานอาหาร';
        $data['description'] = 'พิมพ์รายงานอาหาร';

        return view('User/UserFoodReport/PrintFoodReport', $data);
    }

    public function getFoodReportsJson()
    {
        $reports = $this->FoodReportModel->orderBy('created_at', 'DESC')->findAll();
        return $this->response->setJSON(['data' => $reports]);
    }
}
