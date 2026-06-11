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
    // LINE Messaging API Config (per system)
    // ========================================
    private $lineConfig = [
        'repair' => [
            'token'   => '7gfC9gYjR4S/xRSGeqlOuXo9ZVR5TSvyAUSdgDRMDn4los6yawPmupV+iq47du3cwHjMYzG9SeWz97kGTGsNm+tVww6pHgHQNk7xA3HNHUatjywK/0Pfq98hW5EmM0Xg9PpGHcRZ3zpnQ7evs8yYWwdB04t89/1O/w1cDnyilFU=',
            'groupId' => 'C17a681261a4c021435e323ffc81cedea'
        ],
        'car' => [
            'token'   => 'sNlR5f0V6R5ymIr7KPd5Xp8orbv7moKfar4WUYQF2uOwLvIVJrl0QYkd6vdNArphKzH9Uu0kIeOyjIXOjYkAnXcLmdCR0zJeAOakv8LrwTjlqXi9i0nJrYe/9aBFQsSuvybozfMDE6Ao/C1kmaqDgAdB04t89/1O/w1cDnyilFU=',
            'groupId' => 'C8d6e31d23796ce4a9d17c9ee7b419ec8'
        ],
        'booking' => [
            'token'   => '6uPLX8E6wzICMzMr16kab9Qrf1gorrrbHBJHJ4rK7HFCsP/258uqhgqbf8i9VoopJX4o/4T9Go4gfKzQmxQryJG+LvnYfD3tHtrKXJ24SfsFEKXcW6xFBepKWOGRsoito2pr5neKVHNmSfjfDdwNowdB04t89/1O/w1cDnyilFU=',
            'groupId' => 'C135052df1f6c6de703cc6a2a9758b872'
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
     * ตรวจสอบว่าควรส่งแจ้งเตือนหรือไม่ (เฉพาะ production + ไม่ใช่ localhost)
     */
    private function shouldSendNotification(): bool
    {
        $isLocal = (strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false || ($_SERVER['HTTP_HOST'] ?? '') === '127.0.0.1');
        return (ENVIRONMENT === 'production' && !$isLocal);
    }

    // ================================================================
    //  LINE Messaging API
    // ================================================================

    /**
     * ส่งข้อความ LINE ไปยังกลุ่ม/บุคคล
     * 
     * @param string $system ชื่อระบบ: 'repair', 'car', 'booking'
     * @param string $message ข้อความที่จะส่ง
     * @param string|null $targetId User ID หรือ Group ID (ถ้าไม่ระบุจะใช้ groupId จาก config)
     * @return mixed
     */
    public function sendLine(string $system, string $message, ?string $targetId = null)
    {
        if (!$this->shouldSendNotification()) {
            return null;
        }

        $config = $this->lineConfig[$system] ?? null;
        if (!$config) {
            log_message('error', "LINE Config not found for system: {$system}");
            return false;
        }

        $to = $targetId ?? $config['groupId'];

        $data = [
            'to' => $to,
            'messages' => [[
                'type' => 'text',
                'text' => $message
            ]]
        ];

        $ch = curl_init('https://api.line.me/v2/bot/message/push');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $config['token']
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            log_message('error', 'LINE API Error [' . $system . ']: ' . curl_error($ch));
        }

        curl_close($ch);
        return $result;
    }

    // ================================================================
    //  LINE Message Builders (สร้างข้อความ LINE สำเร็จรูป)
    // ================================================================

    /**
     * สร้างข้อความ LINE สำหรับงานแจ้งซ่อมใหม่
     */
    public function buildLineRepairNew(array $d): string
    {
        $msg  = "━━━━━━━━━━━━━━\n";
        $msg .= "🛠️ แจ้งซ่อมใหม่\n";
        $msg .= "━━━━━━━━━━━━━━\n";
        $msg .= "👤 {$d['requester_name']}\n";
        $msg .= "📋 {$d['case_type']}\n";
        if (!empty($d['detail'])) {
            $msg .= "📝 {$d['detail']}\n";
        }
        $msg .= "📍 {$d['location']}\n";
        $msg .= "📅 {$d['date']}\n";
        $msg .= "━━━━━━━━━━━━━━\n";
        $msg .= "👉 {$d['url']}";
        return $msg;
    }

    /**
     * สร้างข้อความ LINE สำหรับอัปเดตสถานะซ่อม
     */
    public function buildLineRepairUpdate(array $d): string
    {
        $icon = ($d['status'] === 'ดำเนินการเรียบร้อย') ? '✅' : '🔄';
        $msg  = "━━━━━━━━━━━━━━\n";
        $msg .= "{$icon} อัปเดตสถานะซ่อม\n";
        $msg .= "━━━━━━━━━━━━━━\n";
        $msg .= "👤 เรียน {$d['requester_name']}\n";
        $msg .= "📋 {$d['case_type']}\n";
        $msg .= "🔄 สถานะ: {$d['status']}\n";
        if (!empty($d['repairman'])) {
            $msg .= "👷 โดย: {$d['repairman']}\n";
        }
        if (!empty($d['cause'])) {
            $msg .= "📝 {$d['cause']}\n";
        }
        $msg .= "━━━━━━━━━━━━━━\n";
        $msg .= "👉 {$d['url']}";
        return $msg;
    }

    /**
     * สร้างข้อความ LINE สำหรับจองใหม่ (รถ/อาคาร)
     */
    public function buildLineBookingNew(array $d): string
    {
        $icon = $d['icon'] ?? '📣';
        $systemLabel = $d['system_label'] ?? 'คำขอจองใหม่';
        $msg  = "━━━━━━━━━━━━━━\n";
        $msg .= "{$icon} {$systemLabel}\n";
        $msg .= "━━━━━━━━━━━━━━\n";
        $msg .= "👤 {$d['requester_name']}\n";
        $msg .= "🎯 {$d['purpose']}\n";
        if (!empty($d['vehicle'])) {
            $msg .= "🚙 {$d['vehicle']}\n";
        }
        if (!empty($d['location'])) {
            $msg .= "📍 {$d['location']}\n";
        }
        $msg .= "📅 {$d['date_range']}\n";
        $msg .= "━━━━━━━━━━━━━━\n";
        $msg .= "👉 {$d['url']}";
        return $msg;
    }

    /**
     * สร้างข้อความ LINE สำหรับผลการอนุมัติ/ไม่อนุมัติ
     */
    public function buildLineApprovalResult(array $d): string
    {
        $isApproved = $d['is_approved'] ?? true;
        $icon = $isApproved ? '✅' : '❌';
        $title = $isApproved ? 'อนุมัติแล้ว' : 'ไม่ผ่านการอนุมัติ';

        $msg  = "━━━━━━━━━━━━━━\n";
        $msg .= "{$icon} {$title}\n";
        $msg .= "━━━━━━━━━━━━━━\n";
        $msg .= "👤 เรียน {$d['requester_name']}\n";
        if (!empty($d['order_number'])) {
            $msg .= "📄 เลขที่: {$d['order_number']}\n";
        }
        if (!empty($d['detail'])) {
            $msg .= "🎯 {$d['detail']}\n";
        }
        if (!empty($d['location'])) {
            $msg .= "📍 {$d['location']}\n";
        }
        if (!empty($d['date_range'])) {
            $msg .= "📅 {$d['date_range']}\n";
        }
        if ($isApproved && !empty($d['approver'])) {
            $msg .= "👤 อนุมัติโดย: {$d['approver']}\n";
        }
        if (!$isApproved && !empty($d['reason'])) {
            $msg .= "📝 เหตุผล: {$d['reason']}\n";
        }
        $msg .= "━━━━━━━━━━━━━━\n";
        $msg .= "👉 {$d['url']}";
        return $msg;
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
}
