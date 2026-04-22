<?php

namespace App\Controllers;

use App\Models\Model_login;

class Auth extends BaseController
{
    protected $model;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->model = new Model_login();
        session(); // Start session
    }

    public function login()
    {
        log_message('critical', 'Auth::login called');
        if (session()->get('logged_in')) {
            return redirect()->to(base_url());
        }

        // เก็บ URL ที่ต้องการกลับไปหลังจาก Login (ถ้ามี)
        if ($this->request->getVar('return_to')) {
            session()->set('Return', $this->request->getVar('return_to'));
        }

        $config = config('Google');
        $params = [
            'client_id'     => $config->clientId,
            'redirect_uri'  => base_url('Auth/googleLogin'),
            'response_type' => 'code',
            'scope'         => 'email profile openid',
            'access_type'   => 'online',
            'prompt'        => 'select_account'
        ];
        
        $data['GoogleButton'] = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
        $data['title'] = "เข้าสู่ระบบ";
        $data['description'] = "เข้าสู่ระบบบุคลากร";
        $data['UrlMenuMain'] = '';
        $data['UrlMenuSub'] = '';
        $data['full_url'] = current_url();
        $data['uri'] = service('uri');
        
        return view('Login/LoginGoogle', $data);
    }

    public function googleLogin()
    {
        log_message('critical', 'Auth::googleLogin called');
        $code = $this->request->getVar('code');
        if (!$code) {
            return redirect()->to(base_url('/'))->with('login_error', 'การยืนยันตัวตนล้มเหลว (Missing Code)');
        }

        $config = config('Google');
        $curl = \Config\Services::curlrequest();

        try {
            // 1. Exchange code for access_token and id_token (Raw cURL)
            $chToken = curl_init('https://oauth2.googleapis.com/token');
            curl_setopt($chToken, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chToken, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($chToken, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($chToken, CURLOPT_POST, true);
            curl_setopt($chToken, CURLOPT_POSTFIELDS, http_build_query([
                'code'          => $code,
                'client_id'     => $config->clientId,
                'client_secret' => $config->clientSecret,
                'redirect_uri'  => base_url('Auth/googleLogin'),
                'grant_type'    => 'authorization_code',
            ]));
            $tokenResponse = curl_exec($chToken);
            $tokenError = curl_error($chToken);
            curl_close($chToken);

            if ($tokenError) {
                return redirect()->to(base_url('/'))->with('login_error', 'Token cURL Error: ' . $tokenError);
            }

            $tokens = json_decode($tokenResponse, true);

            if (!isset($tokens['access_token'])) {
                return redirect()->to(base_url('/'))->with('login_error', 'ไม่สามารถรับ Access Token ได้: ' . $tokenResponse);
            }

            // 2. Get user profile using access_token (Raw cURL)
            $chUser = curl_init('https://www.googleapis.com/oauth2/v3/userinfo');
            curl_setopt($chUser, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chUser, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($chUser, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($chUser, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $tokens['access_token']
            ]);
            $userResponse = curl_exec($chUser);
            $userError = curl_error($chUser);
            curl_close($chUser);

            if ($userError) {
                return redirect()->to(base_url('/'))->with('login_error', 'UserInfo cURL Error: ' . $userError);
            }

            $payload = json_decode($userResponse, true);

            if (isset($payload['error'])) {
                 return redirect()->to(base_url('/'))->with('login_error', 'Google API Error: ' . json_encode($payload));
            }

        } catch (\Exception $e) {
            return redirect()->to(base_url('/'))->with('login_error', 'เกิดข้อผิดพลาดของระบบ: ' . $e->getMessage());
        }

        if (!$payload || !isset($payload['email'])) {
            return redirect()->to(base_url('/'))->with('login_error', 'ไม่สามารถดึงข้อมูลอีเมลได้');
        }

        $email = $payload['email'];
        $google_sub = $payload['sub'];
        log_message('critical', 'Email from Google: ' . $email);

        
        // ตรวจสอบโดเมนอีเมล
        if (!str_ends_with($email, '@skj.ac.th')) {
            log_message('critical', 'Invalid domain: ' . $email);
            return redirect()->to(base_url('/'))->with('login_error', 'กรุณาใช้อีเมลโรงเรียน @skj.ac.th ในการเข้าสู่ระบบเท่านั้น');
        }

        $check = $this->model->check_login_teacher($email);
        log_message('critical', 'Database check for ' . $email . ' result: ' . $check);

        if ($check >= 1) {
            $result = $this->model->fetch_teacher_login($email);
            log_message('critical', 'Fetch result for ' . $email . ': ' . ($result ? 'Found' : 'Not Found'));
            
            if ($result) {
                // อัปเดตข้อมูลการ Login
                $user_data = [
                    'updated_at' => date('Y-m-d H:i:s'),
                    'login_oauth_uid' => $google_sub
                ];
                $this->model->Update_user_data($user_data, $email);

                // ตั้งค่า Session ตามรูปแบบเดิมของระบบ
                $sessionData = [
                    'id'        => $result->pers_id,
                    'username'  => $result->pers_prefix . $result->pers_firstname . ' ' . $result->pers_lastname,
                    'fullname'  => $result->pers_prefix . $result->pers_firstname . ' ' . $result->pers_lastname,
                    'email'     => $result->pers_username,
                    'pers_img'  => $result->pers_img,
                    'rloes'     => $result->rloesAll ?: '',
                    'status'    => $result->admin_rloes_status ?: 'Member',
                    'logged_in' => true,
                ];
                session()->set($sessionData);
                log_message('critical', 'Session set for: ' . $email . ' - ID: ' . $result->pers_id . ' - SessionID: ' . session_id());

                // สร้างข้อความต้อนรับโดยดึงชื่อจาก Session
                session()->setFlashdata('login_success', 'ยินดีต้อนรับคุณ ' . $sessionData['username'] . ' เข้าสู่ระบบครับ!');

                // จัดการ Redirect กลับไปยังหน้าเดิมตามตรรกะเดิมของระบบ
                $redirectUrl = session()->get('Return');
                session()->remove('Return');

                if (empty($redirectUrl)) {
                    $redirectUrl = base_url();
                }

                // ป้องกันปัญหา URL ซ้อนกัน (ตรรกะเดียวกับ ConLogin เดิม)
                if (strpos($redirectUrl, 'http') === 0) {
                    // เป็น URL สมบูรณ์แล้ว
                } elseif (strpos($redirectUrl, $_SERVER['HTTP_HOST']) !== false) {
                    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
                    $redirectUrl = $protocol . "://" . $redirectUrl;
                } else {
                    $redirectUrl = base_url($redirectUrl);
                }

                return redirect()->to($redirectUrl);
            }
        }
        
        return redirect()->to(base_url('/'))->with('login_error', "ไม่พบอีเมล $email ในระบบพนักงาน");
    }

    public function ajaxGoogleLogin()
    {
        $credential = $this->request->getPost('credential');
        if (!$credential) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูล Credential']);
        }

        $curl = \Config\Services::curlrequest();
        try {
            // ยืนยัน Token กับเซิร์ฟเวอร์ Google
            $response = $curl->get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $credential, [
                'verify' => false,
                'version' => 1.1
            ]);
            $payload = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'การยืนยัน Token ล้มเหลว']);
        }

        if (!isset($payload['email'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูล Token ไม่ถูกต้อง']);
        }

        $email = $payload['email'];
        $google_sub = $payload['sub'];

        if (!str_ends_with($email, '@skj.ac.th')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาใช้อีเมลโรงเรียน @skj.ac.th เท่านั้นครับ']);
        }

        $check = $this->model->check_login_teacher($email);
        if ($check >= 1) {
            $result = $this->model->fetch_teacher_login($email);
            if ($result) {
                $user_data = [
                    'updated_at' => date('Y-m-d H:i:s'),
                    'login_oauth_uid' => $google_sub
                ];
                $this->model->Update_user_data($user_data, $email);

                $sessionData = [
                    'id'        => $result->pers_id,
                    'username'  => $result->pers_prefix . $result->pers_firstname . ' ' . $result->pers_lastname,
                    'fullname'  => $result->pers_prefix . $result->pers_firstname . ' ' . $result->pers_lastname,
                    'email'     => $result->pers_username,
                    'pers_img'  => $result->pers_img,
                    'rloes'     => $result->rloesAll ?: '',
                    'status'    => $result->admin_rloes_status ?: 'Member',
                    'logged_in' => true,
                ];
                session()->set($sessionData);
                session()->close(); // Force save

                session()->setFlashdata('login_success', 'ยินดีต้อนรับคุณ ' . $sessionData['username'] . ' เข้าสู่ระบบครับ!');

                return $this->response->setJSON(['status' => 'success', 'message' => 'เข้าสู่ระบบสำเร็จ']);
            }
        }

        return $this->response->setJSON(['status' => 'error', 'message' => "ไม่พบอีเมล $email ในระบบพนักงาน"]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
