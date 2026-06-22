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
    // Notification Toggle (เปิด/ปิด ช่องทางส่ง)
    // ========================================
    private $enableLine = false; // ตั้งค่าเป็น false เพื่อปิดการแจ้งเตือนทาง LINE (โค้ดยังคงอยู่)

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
     * ตรวจสอบว่าควรส่งแจ้งเตือนหรือไม่ (ปรับให้ส่งเสมอเพื่อประโยนช์ในการทดสอบ)
     */
    private function shouldSendNotification(): bool
    {
        return true;
    }
    // ================================================================
    //  LINE Messaging API
    // ================================================================

    /**
     * ส่งข้อความ LINE ไปยังกลุ่ม/บุคคล
     * รองรับทั้ง text เดี่ยว หรือ text + image พร้อมกัน
     *
     * @param string $system ชื่อระบบ: 'repair', 'car', 'booking'
     * @param string $message ข้อความที่จะส่ง
     * @param string|null $targetId User ID หรือ Group ID
     * @param string|null $imageUrl URL รูปภาพ (ถ้ามีจะส่งเป็น image message ด้วย)
     * @return mixed
     */
    /**
     * ส่งข้อความ LINE ไปยังกลุ่ม/บุคคล
     * รองรับทั้ง text เดี่ยว, Flex Message หรือ text/Flex + image พร้อมกัน
     *
     * @param string $system ชื่อระบบ: 'repair', 'car', 'booking'
     * @param string|array $message ข้อความที่จะส่ง (ถ้าเป็น array จะถือว่าเป็น Flex Message)
     * @param string|null $targetId User ID หรือ Group ID
     * @param string|null $imageUrl URL รูปภาพ (ถ้ามีจะส่งเป็น image message ด้วย)
     * @return mixed
     */
    public function sendLine(string $system, $message, ?string $targetId = null, ?string $imageUrl = null)
    {
        if (!$this->shouldSendNotification()) {
            return null;
        }

        $result = false;

        if ($this->enableLine) {
            $config = $this->lineConfig[$system] ?? null;
            if (!$config) {
                log_message('error', "LINE Config not found for system: {$system}");
                return false;
            }

            $to = $targetId ?? $config['groupId'];
            $messages = [];

            // ถ้ามีรูป ส่งรูปก่อน (จะเป็น preview ให้เห็นทันที)
            if (!empty($imageUrl)) {
                $messages[] = [
                    'type' => 'image',
                    'originalContentUrl' => $imageUrl,
                    'previewImageUrl' => $imageUrl
                ];
            }

            // ส่งข้อความตามประเภท (Text หรือ Flex)
            if (is_array($message)) {
                $messages[] = $message;
            } else {
                $messages[] = [
                    'type' => 'text',
                    'text' => $message
                ];
            }

            $data = [
                'to' => $to,
                'messages' => $messages
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
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // If it failed and we had an image, try retrying WITHOUT the image
            if ($httpCode !== 200 && !empty($imageUrl)) {
                log_message('warning', 'LINE API failed with image. Retrying without image... Response: ' . $result);
                
                // Re-prepare data without the image message
                $fallbackMessages = [];
                if (is_array($message)) {
                    $fallbackMessages[] = $message;
                } else {
                    $fallbackMessages[] = [
                        'type' => 'text',
                        'text' => $message
                    ];
                }
                $fallbackData = [
                    'to' => $to,
                    'messages' => $fallbackMessages
                ];

                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fallbackData));
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            }

            if (curl_errno($ch)) {
                log_message('error', 'LINE API Connection Error [' . $system . ']: ' . curl_error($ch));
            } else if ($httpCode !== 200) {
                log_message('error', 'LINE API Error Response [' . $system . '] (' . $httpCode . '): ' . $result);
            }

            curl_close($ch);
        }

        // Auto-forward notification to Telegram in parallel
        try {
            $this->sendTelegram($system, $message, $imageUrl);
        } catch (\Exception $te) {
            log_message('error', 'Failed to auto-forward Telegram notification: ' . $te->getMessage());
        }

        return $result;
    }
    // ================================================================
    //  LINE Message Builders (สร้างข้อความ LINE สำเร็จรูป)
    // ================================================================

    /**
     * สร้างข้อความ LINE สำหรับงานแจ้งซ่อมใหม่
     */
    public function buildLineRepairNew(array $d): array
    {
        $primaryColor = '#ff6b35';
        $altText = 'แจ้งซ่อมใหม่';

        $contents = [
            'type' => 'box',
            'layout' => 'vertical',
            'contents' => [
                [
                    'type' => 'text',
                    'text' => 'MAINTENANCE SERVICE',
                    'weight' => 'bold',
                    'color' => $primaryColor,
                    'size' => 'xs',
                    'letterSpacing' => '0.05em'
                ],
                [
                    'type' => 'text',
                    'text' => '🛠️ มีงานแจ้งซ่อมใหม่เข้ามา',
                    'weight' => 'bold',
                    'size' => 'lg',
                    'margin' => 'sm'
                ],
                [
                    'type' => 'separator',
                    'margin' => 'md'
                ],
                [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'margin' => 'md',
                    'spacing' => 'sm',
                    'contents' => [
                        [
                            'type' => 'box',
                            'layout' => 'horizontal',
                            'contents' => [
                                ['type' => 'text', 'text' => '📋 ประเภท', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                                ['type' => 'text', 'text' => $d['case_type'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true, 'weight' => 'bold']
                            ]
                        ]
                    ]
                ]
            ]
        ];

        if (!empty($d['detail'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '📝 รายละเอียด', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['detail'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                ]
            ];
        }

        $contents['contents'][3]['contents'][] = [
            'type' => 'box',
            'layout' => 'horizontal',
            'contents' => [
                ['type' => 'text', 'text' => '👤 ผู้แจ้งซ่อม', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                ['type' => 'text', 'text' => $d['requester_name'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
            ]
        ];

        $contents['contents'][3]['contents'][] = [
            'type' => 'box',
            'layout' => 'horizontal',
            'contents' => [
                ['type' => 'text', 'text' => '📍 สถานที่', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                ['type' => 'text', 'text' => $d['location'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
            ]
        ];

        $contents['contents'][3]['contents'][] = [
            'type' => 'box',
            'layout' => 'horizontal',
            'contents' => [
                ['type' => 'text', 'text' => '📅 วันเวลาแจ้ง', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                ['type' => 'text', 'text' => $d['date'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
            ]
        ];

        return [
            'type' => 'flex',
            'altText' => '🛠️ แจ้งซ่อมใหม่: ' . $d['case_type'],
            'contents' => [
                'type' => 'bubble',
                'body' => $contents,
                'footer' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'spacing' => 'sm',
                    'contents' => [
                        [
                            'type' => 'button',
                            'style' => 'primary',
                            'height' => 'sm',
                            'color' => $primaryColor,
                            'action' => [
                                'type' => 'uri',
                                'label' => 'ดูรายละเอียดการแจ้งซ่อม',
                                'uri' => $d['url']
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * สร้างข้อความ LINE สำหรับอัปเดตสถานะซ่อม
     */
    public function buildLineRepairUpdate(array $d): array
    {
        $isDone = ($d['status'] === 'ดำเนินการเรียบร้อย');
        $primaryColor = $isDone ? '#28a745' : '#ff6b35';
        $statusIcon = $isDone ? '✅' : '🔄';
        $altText = 'อัปเดตสถานะซ่อม';

        $contents = [
            'type' => 'box',
            'layout' => 'vertical',
            'contents' => [
                [
                    'type' => 'text',
                    'text' => 'MAINTENANCE STATUS UPDATE',
                    'weight' => 'bold',
                    'color' => $primaryColor,
                    'size' => 'xs',
                    'letterSpacing' => '0.05em'
                ],
                [
                    'type' => 'text',
                    'text' => $statusIcon . ' ' . $d['status'],
                    'weight' => 'bold',
                    'size' => 'lg',
                    'margin' => 'sm',
                    'color' => $primaryColor
                ],
                [
                    'type' => 'separator',
                    'margin' => 'md'
                ],
                [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'margin' => 'md',
                    'spacing' => 'sm',
                    'contents' => [
                        [
                            'type' => 'box',
                            'layout' => 'horizontal',
                            'contents' => [
                                ['type' => 'text', 'text' => '📋 งานซ่อม', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                                ['type' => 'text', 'text' => $d['case_type'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        if (!empty($d['cause'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '📝 รายละเอียด', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['cause'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                ]
            ];
        }

        if (!empty($d['repairman'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '👷 ช่างผู้ดูแล', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['repairman'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                ]
            ];
        }

        $contents['contents'][3]['contents'][] = [
            'type' => 'box',
            'layout' => 'horizontal',
            'contents' => [
                ['type' => 'text', 'text' => '👤 ผู้รับบริการ', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                ['type' => 'text', 'text' => 'เรียนคุณ ' . $d['requester_name'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
            ]
        ];

        return [
            'type' => 'flex',
            'altText' => $statusIcon . ' อัปเดตสถานะซ่อม: ' . $d['status'],
            'contents' => [
                'type' => 'bubble',
                'body' => $contents,
                'footer' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'spacing' => 'sm',
                    'contents' => [
                        [
                            'type' => 'button',
                            'style' => 'primary',
                            'height' => 'sm',
                            'color' => $primaryColor,
                            'action' => [
                                'type' => 'uri',
                                'label' => 'ดูรายละเอียดงานซ่อม',
                                'uri' => $d['url']
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * สร้างข้อความ LINE สำหรับจองใหม่ (รถ/อาคาร)
     */
    public function buildLineBookingNew(array $d): array
    {
        $isCar = (!empty($d['vehicle']) || strpos($d['system_label'] ?? '', 'รถ') !== false);
        $primaryColor = $isCar ? '#2196f3' : '#15a362';
        $altText = $d['system_label'] ?? 'แจ้งเตือนการจองใหม่';

        $contents = [
            'type' => 'box',
            'layout' => 'vertical',
            'contents' => [
                [
                    'type' => 'text',
                    'text' => mb_strtoupper($d['system_label'] ?? 'BOOKING SYSTEM', 'UTF-8'),
                    'weight' => 'bold',
                    'color' => $primaryColor,
                    'size' => 'xs',
                    'letterSpacing' => '0.05em'
                ],
                [
                    'type' => 'text',
                    'text' => '⏳ มีการขอจองใหม่เข้ามา',
                    'weight' => 'bold',
                    'size' => 'lg',
                    'margin' => 'sm'
                ],
                [
                    'type' => 'separator',
                    'margin' => 'md'
                ],
                [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'margin' => 'md',
                    'spacing' => 'sm',
                    'contents' => [
                        [
                            'type' => 'box',
                            'layout' => 'horizontal',
                            'contents' => [
                                ['type' => 'text', 'text' => '👤 ผู้ขอใช้', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                                ['type' => 'text', 'text' => $d['requester_name'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                            ]
                        ],
                        [
                            'type' => 'box',
                            'layout' => 'horizontal',
                            'contents' => [
                                ['type' => 'text', 'text' => '🎯 วัตถุประสงค์', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                                ['type' => 'text', 'text' => $d['purpose'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        if (!empty($d['vehicle'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '🚙 ยานพาหนะ', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['vehicle'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                ]
            ];
        }

        if (!empty($d['location'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '📍 สถานที่', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['location'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                ]
            ];
        }

        // Add date_range row
        $contents['contents'][3]['contents'][] = [
            'type' => 'box',
            'layout' => 'horizontal',
            'contents' => [
                ['type' => 'text', 'text' => '📅 วัน/เวลา', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                ['type' => 'text', 'text' => $d['date_range'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
            ]
        ];

        return [
            'type' => 'flex',
            'altText' => '🔔 ' . $altText . ': ' . $d['purpose'],
            'contents' => [
                'type' => 'bubble',
                'body' => $contents,
                'footer' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'spacing' => 'sm',
                    'contents' => [
                        [
                            'type' => 'button',
                            'style' => 'primary',
                            'height' => 'sm',
                            'color' => $primaryColor,
                            'action' => [
                                'type' => 'uri',
                                'label' => 'ตรวจสอบและดำเนินการ',
                                'uri' => $d['url']
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * สร้างข้อความ LINE สำหรับผลการอนุมัติ/ไม่อนุมัติ
     */
    public function buildLineApprovalResult(array $d): array
    {
        $isApproved = $d['is_approved'] ?? true;
        $primaryColor = $isApproved ? '#15a362' : '#ff3e1d';
        $statusText = $isApproved ? '✅ อนุมัติแล้ว' : '❌ ไม่ผ่านการอนุมัติ';
        $altText = 'ผลการอนุมัติคำขอจอง';

        $contents = [
            'type' => 'box',
            'layout' => 'vertical',
            'contents' => [
                [
                    'type' => 'text',
                    'text' => 'BOOKING STATUS UPDATE',
                    'weight' => 'bold',
                    'color' => $primaryColor,
                    'size' => 'xs',
                    'letterSpacing' => '0.05em'
                ],
                [
                    'type' => 'text',
                    'text' => $statusText,
                    'weight' => 'bold',
                    'size' => 'lg',
                    'margin' => 'sm'
                ],
                [
                    'type' => 'separator',
                    'margin' => 'md'
                ],
                [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'margin' => 'md',
                    'spacing' => 'sm',
                    'contents' => [
                        [
                            'type' => 'box',
                            'layout' => 'horizontal',
                            'contents' => [
                                ['type' => 'text', 'text' => '👤 เรียน', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                                ['type' => 'text', 'text' => $d['requester_name'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        if (!empty($d['order_number'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '📄 เลขที่คำขอ', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['order_number'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                ]
            ];
        }

        if (!empty($d['detail'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '🎯 รายละเอียด', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['detail'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                ]
            ];
        }

        if (!empty($d['location'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '📍 สถานที่/รถ', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['location'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                ]
            ];
        }

        if (!empty($d['date_range'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '📅 วัน/เวลา', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['date_range'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                ]
            ];
        }

        if ($isApproved && !empty($d['approver'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '👤 อนุมัติโดย', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['approver'], 'size' => 'sm', 'color' => '#333333', 'flex' => 7, 'wrap' => true]
                ]
            ];
        }

        if (!$isApproved && !empty($d['reason'])) {
            $contents['contents'][3]['contents'][] = [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    ['type' => 'text', 'text' => '📝 เหตุผล', 'size' => 'sm', 'color' => '#8c8c8c', 'flex' => 3],
                    ['type' => 'text', 'text' => $d['reason'], 'size' => 'sm', 'color' => '#ff3e1d', 'flex' => 7, 'wrap' => true, 'weight' => 'bold']
                ]
            ];
        }

        return [
            'type' => 'flex',
            'altText' => '🔔 ' . $statusText . ': ' . ($d['detail'] ?? 'แจ้งสถานะการจอง'),
            'contents' => [
                'type' => 'bubble',
                'body' => $contents,
                'footer' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'spacing' => 'sm',
                    'contents' => [
                        [
                            'type' => 'button',
                            'style' => 'primary',
                            'height' => 'sm',
                            'color' => $primaryColor,
                            'action' => [
                                'type' => 'uri',
                                'label' => 'ดูรายละเอียด',
                                'uri' => $d['url']
                            ]
                        ]
                    ]
                ]
            ]
        ];
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
