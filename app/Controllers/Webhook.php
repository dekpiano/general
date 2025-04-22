<?php
namespace App\Controllers;

class Webhook extends BaseController
{
    public function index()
    {
        $accessToken = '7gfC9gYjR4S/xRSGeqlOuXo9ZVR5TSvyAUSdgDRMDn4los6yawPmupV+iq47du3cwHjMYzG9SeWz97kGTGsNm+tVww6pHgHQNk7xA3HNHUatjywK/0Pfq98hW5EmM0Xg9PpGHcRZ3zpnQ7evs8yYWwdB04t89/1O/w1cDnyilFU=';

        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (isset($data['events'][0]['type']) && $data['events'][0]['type'] === 'message') {
            $event = $data['events'][0];
            $replyToken = $event['replyToken'];
            $source = $event['source'];

            $messageText = '';

            if ($source['type'] === 'group') {
                $messageText = "📌 Group ID: {$source['groupId']}";
            } elseif ($source['type'] === 'user') {
                $messageText = "👤 User ID: {$source['userId']}";
            } else {
                $messageText = "📎 ไม่พบ groupId หรือ userId";
            }

            // ตอบกลับไปที่ LINE
            $replyMessage = [
                'replyToken' => $replyToken,
                'messages' => [[
                    'type' => 'text',
                    'text' => $messageText
                ]]
            ];

            $ch = curl_init('https://api.line.me/v2/bot/message/reply');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($replyMessage));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }

        return $this->response->setStatusCode(200)->setBody('OK');
    }
}
