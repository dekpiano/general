<?php

namespace App\Libraries;

class LineNotify
{
    private $accessToken;

    public function __construct()
    {
        $this->accessToken = getenv('LINE_ACCESS_TOKEN');
    }

    /**
     * Send a message to a specific user or group via LINE Messaging API (Push Message)
     * 
     * @param string $to User ID or Group ID
     * @param string $messageText The message content
     * @return mixed Response from LINE API
     */
    public function sendPushMessage($to, $messageText)
    {
        if (empty($this->accessToken)) {
            log_message('error', 'LINE_ACCESS_TOKEN is missing in .env');
            return false;
        }

        $data = [
            'to' => $to,
            'messages' => [[
                'type' => 'text',
                'text' => $messageText
            ]]
        ];

        $ch = curl_init('https://api.line.me/v2/bot/message/push');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->accessToken
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        
        if (curl_errno($ch)) {
            log_message('error', 'LINE API Error: ' . curl_error($ch));
        }
        
        curl_close($ch);

        return $result;
    }
}
