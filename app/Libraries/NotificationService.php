<?php

namespace App\Libraries;

/**
 * NotificationService - ศูนย์กลางการแจ้งเตือนทุกช่องทาง
 * รวม LINE, Email, OneSignal Push Notification ไว้ในที่เดียว
 * 
 * @author System
 * @version 2.0
 */
class NotificationService
{

    // ========================================
    // Telegram Bot API Config (per system)
    // ========================================
    private $telegramConfig = [
        'repair' => [
            'token'   => '8901085783:AAHHcCKmTAr6sgsCpDd1XcsZw44oTIzqsP0',
            'chatId'  => '-5040182261'
        ],
        'car' => [
            'token'   => '8901085783:AAHHcCKmTAr6sgsCpDd1XcsZw44oTIzqsP0',
            'chatId'  => '-5309376982'
        ],
        'booking' => [
            'token'   => '8901085783:AAHHcCKmTAr6sgsCpDd1XcsZw44oTIzqsP0',
            'chatId'  => '-5587836326'
        ]
    ];


    // ========================================
    // OneSignal Config
    // ========================================
    private $oneSignalAppId  = 'be488231-0e72-4fe0-962d-fcb32cb761e7';
    private $oneSignalApiKey = 'os_v2_app_xzeiemioojh6bfrn7szszn3b46vk2igzrooeom4rtulcfh2t47lyy6rf6mccwtbxfwgzhvpjurm4trrduldx73e3wwz35nwjtsgyhwa';

    // ========================================
    // Theme Colors
    // ========================================
    private $themes = [
        'repair'   => ['color' => '#ff6b35', 'colorEnd' => '#f7931e', 'cardBg' => '#fef9f4', 'cardBorder' => '#fde8d4', 'icon' => '🛠️'],
        'car'      => ['color' => '#2196f3', 'colorEnd' => '#42a5f5', 'cardBg' => '#f0f7ff', 'cardBorder' => '#bbdefb', 'icon' => '🚗'],
        'booking'  => ['color' => '#15a362', 'colorEnd' => '#20c997', 'cardBg' => '#f0faf4', 'cardBorder' => '#c8e6c9', 'icon' => '⛪'],
        'approved' => ['color' => '#28a745', 'colorEnd' => '#15a362', 'cardBg' => '#f0faf4', 'cardBorder' => '#c8e6c9', 'icon' => '✅'],
        'rejected' => ['color' => '#ff3e1d', 'colorEnd' => '#ff6b4a', 'cardBg' => '#fff5f5', 'cardBorder' => '#ffcdd2', 'icon' => '❌'],
        'update'   => ['color' => '#28a745', 'colorEnd' => '#20c997', 'cardBg' => '#f0faf4', 'cardBorder' => '#c8e6c9', 'icon' => '🔄'],
    ];
    /**
     * ตรวจสอบว่าควรส่งแจ้งเตือนหรือไม่
     * บล็อกเฉพาะ localhost เท่านั้น เพื่อให้ส่งแจ้งเตือนได้บน server จริง
     */
    private function shouldSendNotification(): bool
    {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $isLocal = (strpos($host, 'localhost') !== false || $host === '127.0.0.1');
        if ($isLocal) {
            return false;
        }
        return true;
    }


    // ================================================================
    //  Email (ส่งผ่าน CodeIgniter Email Service + Template สวย)
    // ================================================================

    /**
     * ส่ง Email พร้อม Template สวย
     * 
     * @param string|array $to Email ปลายทาง
     * @param string $subject หัวข้อ
     * @param string $themeName ชื่อ theme: 'repair', 'car', 'booking', 'approved', 'rejected', 'update'
     * @param array $templateData ข้อมูลสำหรับ template
     * @param string|null $fromEmail Email ผู้ส่ง
     * @param string|null $fromName ชื่อผู้ส่ง
     * @return bool
     */
    public function sendEmail($to, string $subject, string $themeName, array $templateData, ?string $fromEmail = null, ?string $fromName = null): bool
    {
        if (!$this->shouldSendNotification()) {
            return false;
        }

        try {
            $theme = $this->themes[$themeName] ?? $this->themes['booking'];
            $templateData['theme'] = $theme;

            $email = \Config\Services::email();
            $email->setFrom($fromEmail ?? 'noreply@skj.ac.th', $fromName ?? 'ระบบแจ้งเตือน SKJ');
            $email->setTo($to);
            $email->setSubject($subject);

            $html = view('Email/notification_template', $templateData);
            $email->setMessage($html);
            $email->setMailType('html');

            return $email->send();
        } catch (\Exception $e) {
            log_message('error', 'NotificationService Email Error: ' . $e->getMessage());
            return false;
        }
    }

    // ================================================================
    //  OneSignal Push Notification
    // ================================================================

    /**
     * ส่ง OneSignal Push Notification
     * 
     * @param string $title หัวข้อ
     * @param string $message ข้อความ
     * @param string|null $url URL ที่จะเปิดเมื่อกด
     * @param array|null $tags Filter tags เช่น ['role' => 'admin_repair']
     * @param string|array|null $userIds External User IDs
     * @return mixed
     */
    public function sendPush(string $title, string $message, ?string $url = null, ?array $tags = null, $userIds = null)
    {
        if (!$this->shouldSendNotification()) {
            return null;
        }

        $content  = ["en" => $message, "th" => $message];
        $headings = ["en" => $title, "th" => $title];

        $fields = [
            'app_id'           => $this->oneSignalAppId,
            'headings'         => $headings,
            'contents'         => $content,
            'chrome_web_badge' => base_url('assets/img/icons/icon-192x192.png'),
            'chrome_web_icon'  => base_url('assets/img/icons/icon-512x512.png'),
            'firefox_icon'     => base_url('assets/img/icons/icon-512x512.png')
        ];

        if ($url) {
            $fields['url'] = $url;
        }

        if ($userIds) {
            $fields['include_external_user_ids'] = is_array($userIds) ? $userIds : [$userIds];
        } elseif ($tags) {
            $fields['filters'] = [];
            $first = true;
            foreach ($tags as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        if (!$first) $fields['filters'][] = ["operator" => "OR"];
                        $fields['filters'][] = ["field" => "tag", "key" => $key, "relation" => "=", "value" => $v];
                        $first = false;
                    }
                } else {
                    if (!$first) $fields['filters'][] = ["operator" => "OR"];
                    $fields['filters'][] = ["field" => "tag", "key" => $key, "relation" => "=", "value" => $value];
                    $first = false;
                }
            }
        } else {
            $fields['included_segments'] = ['All'];
        }

        $ch = curl_init('https://onesignal.com/api/v1/notifications');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $this->oneSignalApiKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            log_message('error', 'OneSignal Error: ' . curl_error($ch));
        }

        curl_close($ch);
        return $response;
    }

    // ================================================================
    //  Helper: ดึง Email เจ้าหน้าที่ตามชื่องาน
    // ================================================================

    /**
     * ดึง Email ของเจ้าหน้าที่ตามชื่องาน (หัวหน้า + เจ้าหน้าที่)
     * 
     * @param string $departmentName ชื่องาน เช่น "งานแจ้งซ่อม", "งานอาคารสถานที่"
     * @return array รายชื่อ Email
     */
    public function getStaffEmailsByDepartment(string $departmentName): array
    {
        $database = \Config\Database::connect();
        $DBpers = \Config\Database::connect('personnel');

        $staffIds = $database->table('tb_admin_rloes')
            ->select('admin_rloes_userid')
            ->where('admin_rloes_nanetype', $departmentName)
            ->where('admin_rloes_userid !=', '')
            ->get()
            ->getResult();

        if (empty($staffIds)) {
            return [];
        }

        $emails = [];
        foreach ($staffIds as $staff) {
            $person = $DBpers->table('tb_personnel')
                ->select('pers_username')
                ->where('pers_id', $staff->admin_rloes_userid)
                ->where('pers_status', 'กำลังใช้งาน')
                ->get()
                ->getRow();

            if ($person && !empty($person->pers_username)) {
                $emails[] = $person->pers_username;
            }
        }

        return array_unique($emails);
    }

    /**
     * ดึงข้อมูลบุคลากรจาก pers_id
     */
    public function getPersonnelInfo(string $persId): ?object
    {
        $DBpers = \Config\Database::connect('personnel');
        return $DBpers->table('tb_personnel')
            ->select('pers_prefix, pers_firstname, pers_lastname, pers_username')
            ->where('pers_id', $persId)
            ->get()
            ->getRow();
    }

    /**
     * สร้างชื่อเต็มจากข้อมูลบุคลากร
     */
    public function getFullName(?object $person): string
    {
        if (!$person) return 'ไม่ระบุ';
        return ($person->pers_prefix ?? '') . ($person->pers_firstname ?? '') . ' ' . ($person->pers_lastname ?? '');
    }

    // ================================================================
    //  Telegram Bot API Integration
    // ================================================================

    /**
     * ส่งข้อความแจ้งเตือนผ่าน Telegram Bot API
     *
     * @param string $system ชื่อระบบ: 'repair', 'car', 'booking'
     * @param string|array $message ข้อความ หรือ Flex Message structure
     * @param string|null $imageUrl URL รูปภาพ (ถ้ามี จะส่งเป็น Photo message)
     * @return mixed
     */
    public function sendTelegram(string $system, $message, ?string $imageUrl = null)
    {
        if (!$this->shouldSendNotification()) {
            return null;
        }

        $config = $this->telegramConfig[$system] ?? null;
        if (!$config || empty($config['token']) || empty($config['chatId'])) {
            // ไม่ส่งถ้าไม่ได้ระบุ Token หรือ Chat ID (ข้ามเงียบๆ)
            return false;
        }

        $token = $config['token'];
        $chatId = $config['chatId'];

        // ถ้า Token/Chat ID ยังเป็นค่าเริ่มต้น/Placeholder ก็ให้ข้าม
        if (strpos($token, 'YOUR_TELEGRAM') !== false || strpos($chatId, 'YOUR_TELEGRAM') !== false) {
            return false;
        }

        $textMessage = $this->getPlainTextFromFlex($message);

        // ใช้ curl ส่งข้อความไป Telegram
        if (!empty($imageUrl)) {
            $url = "https://api.telegram.org/bot{$token}/sendPhoto";
            $data = [
                'chat_id'    => $chatId,
                'photo'      => $imageUrl,
                'caption'    => $textMessage,
                'parse_mode' => 'HTML'
            ];
        } else {
            $url = "https://api.telegram.org/bot{$token}/sendMessage";
            $data = [
                'chat_id'    => $chatId,
                'text'       => $textMessage,
                'parse_mode' => 'HTML'
            ];
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // กรณีส่งรูปภาพล้มเหลว (เช่น ขนาดรูปใหญ่เกินไป) ให้ลองส่งเฉพาะข้อความตัวหนังสือแบบ fallback
        if ($httpCode !== 200 && !empty($imageUrl)) {
            log_message('warning', 'Telegram sendPhoto failed. Retrying as sendMessage... Response: ' . $result);
            $url = "https://api.telegram.org/bot{$token}/sendMessage";
            $fallbackData = [
                'chat_id'    => $chatId,
                'text'       => $textMessage . "\n\n<a href=\"" . htmlspecialchars($imageUrl) . "\">รูปภาพแนบ</a>",
                'parse_mode' => 'HTML'
            ];
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fallbackData));
            $result = curl_exec($ch);
        }

        if (curl_errno($ch)) {
            log_message('error', 'Telegram Connection Error [' . $system . ']: ' . curl_error($ch));
        } else if ($httpCode !== 200) {
            log_message('error', 'Telegram API Error Response [' . $system . '] (' . $httpCode . '): ' . $result);
        }

        curl_close($ch);
        return $result;
    }

    /**
     * แปลง LINE Flex Message ให้เป็นข้อความแบบ Plain Text + HTML format สำหรับ Telegram
     */
    private function getPlainTextFromFlex($message): string
    {
        if (!is_array($message)) {
            return (string)$message;
        }

        $title = $message['altText'] ?? 'แจ้งเตือนจากระบบ';
        $text = "<b>" . $title . "</b>\n\n";

        $texts = [];
        $this->collectTexts($message, $texts);

        foreach ($texts as $item) {
            if (is_array($item) && isset($item['type']) && $item['type'] === 'pair') {
                $text .= "• " . $item['label'] . ": " . $item['value'] . "\n";
            } else {
                $current = trim((string)$item);
                if ($current === '' || in_array(strtoupper($current), ['MAINTENANCE SERVICE', 'MAINTENANCE STATUS UPDATE', 'BOOKING SYSTEM', 'BOOKING STATUS UPDATE'])) {
                    continue;
                }
                
                // ตกแต่งหัวข้อหลัก (มีสัญลักษณ์พิเศษ)
                if (preg_match('/[🛠️✅❌⏳🔄📣🔔🚙📍👤📅👉]/u', $current)) {
                    $text .= "<b>" . $current . "</b>\n";
                } else {
                    $text .= $current . "\n";
                }
            }
        }

        return $text;
    }

    /**
     * ค้นหาข้อความในโครงสร้าง Flex Message แบบ recursive
     */
    private function collectTexts($array, &$texts)
    {
        if (!is_array($array)) {
            return;
        }
        
        // ถ้าเป็นกล่องแนวนอนและมีสมาชิก 2 ชิ้นที่เป็น Text (มักจะเป็น Label: Value)
        if (isset($array['layout']) && $array['layout'] === 'horizontal' && isset($array['contents'])) {
            $subTexts = [];
            foreach ($array['contents'] as $item) {
                if (isset($item['type']) && $item['type'] === 'text' && isset($item['text'])) {
                    $subTexts[] = $item['text'];
                }
            }
            if (count($subTexts) === 2) {
                $texts[] = [
                    'type'  => 'pair',
                    'label' => $subTexts[0],
                    'value' => $subTexts[1]
                ];
                return;
            }
        }

        if (isset($array['type']) && $array['type'] === 'text' && isset($array['text'])) {
            $texts[] = $array['text'];
        } else {
            foreach ($array as $key => $value) {
                // ข้าม altText เพื่อไม่ให้ดึงข้อมูลซ้ำซ้อน
                if ($key !== 'altText') {
                    $this->collectTexts($value, $texts);
                }
            }
        }
    }
}
