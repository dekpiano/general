<?php
/**
 * Email Notification Template (Unified)
 * ใช้สำหรับทุกประเภทการแจ้งเตือน
 * 
 * Variables:
 * @var array  $theme        ['color', 'colorEnd', 'cardBg', 'cardBorder', 'icon']
 * @var string $header_icon  Emoji icon สำหรับ header
 * @var string $header_title หัวข้อหลัก
 * @var string $header_sub   ชื่อระบบย่อย
 * @var array  $fields       [['label'=>'...', 'value'=>'...']]  ข้อมูลหลัก
 * @var array  $columns      [['label'=>'...', 'value'=>'...']]  ข้อมูลแบบ 2 คอลัมน์ (optional)
 * @var string $detail_label Label รายละเอียดเพิ่มเติม (optional)
 * @var string $detail_text  เนื้อหารายละเอียด (optional)
 * @var array  $status       ['text'=>'...', 'bg'=>'...', 'color'=>'...'] (optional)
 * @var array  $reason       ['label'=>'...', 'text'=>'...'] เหตุผล (สำหรับไม่อนุมัติ) (optional)
 * @var string $cta_text     ข้อความปุ่ม CTA
 * @var string $cta_url      URL ปุ่ม CTA
 * @var string $footer_text  ข้อความ footer เพิ่มเติม (optional)
 */

$color      = $theme['color'] ?? '#15a362';
$colorEnd   = $theme['colorEnd'] ?? '#20c997';
$cardBg     = $theme['cardBg'] ?? '#f0faf4';
$cardBorder = $theme['cardBorder'] ?? '#c8e6c9';
$icon       = $header_icon ?? $theme['icon'] ?? '🔔';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($header_title ?? 'แจ้งเตือน') ?></title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7fa; margin: 0; padding: 0;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f4f7fa; padding: 20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    
                    <!-- Top Accent Bar -->
                    <tr>
                        <td style="height: 5px; background: linear-gradient(90deg, <?= $color ?>, <?= $colorEnd ?>);"></td>
                    </tr>
                    
                    <!-- Header -->
                    <tr>
                        <td style="padding: 28px 30px 20px; text-align: center;">
                            <div style="font-size: 40px; margin-bottom: 12px;"><?= $icon ?></div>
                            <h1 style="margin: 0; font-size: 22px; color: #1a1a2e; font-weight: 700;"><?= esc($header_title ?? 'แจ้งเตือน') ?></h1>
                            <?php if (!empty($header_sub)): ?>
                                <p style="margin: 6px 0 0; font-size: 13px; color: #999;"><?= esc($header_sub) ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- Summary Card -->
                    <?php if (!empty($fields) || !empty($columns)): ?>
                    <tr>
                        <td style="padding: 0 30px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: <?= $cardBg ?>; border: 1px solid <?= $cardBorder ?>; border-radius: 10px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 18px 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            
                                            <!-- Fields (full width rows) -->
                                            <?php if (!empty($fields)): ?>
                                                <?php foreach ($fields as $i => $field): ?>
                                                    <?php if ($i > 0): ?>
                                                        <tr><td style="height: 1px; background: <?= $cardBorder ?>;"></td></tr>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <td style="padding: 8px 0;">
                                                            <span style="font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 0.5px;"><?= esc($field['label']) ?></span><br>
                                                            <span style="font-size: 16px; color: #1a1a2e; font-weight: 600;"><?= esc($field['value']) ?></span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                            <!-- Columns (2 columns side by side) -->
                                            <?php if (!empty($columns)): ?>
                                                <tr><td style="height: 1px; background: <?= $cardBorder ?>;"></td></tr>
                                                <tr>
                                                    <td style="padding: 8px 0;">
                                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                            <tr>
                                                                <?php foreach ($columns as $col): ?>
                                                                    <td width="<?= floor(100 / count($columns)) ?>%" style="vertical-align: top;">
                                                                        <span style="font-size: 12px; color: #999;"><?= esc($col['label']) ?></span><br>
                                                                        <span style="font-size: 14px; color: #1a1a2e;"><?= esc($col['value']) ?></span>
                                                                    </td>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <!-- Detail Text -->
                    <?php if (!empty($detail_text)): ?>
                    <tr>
                        <td style="padding: 16px 30px 0;">
                            <p style="margin: 0; font-size: 14px; color: #666; line-height: 1.6;">
                                <strong style="color: #333;"><?= esc($detail_label ?? 'รายละเอียด') ?>:</strong> <?= esc($detail_text) ?>
                            </p>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <!-- Reason Box (สำหรับไม่อนุมัติ) -->
                    <?php if (!empty($reason)): ?>
                    <tr>
                        <td style="padding: 16px 30px 0;">
                            <div style="background: #fff5f5; border-left: 4px solid #ff3e1d; padding: 14px 16px; border-radius: 0 8px 8px 0;">
                                <p style="margin: 0 0 4px; font-size: 13px; color: #c62828; font-weight: 600;"><?= esc($reason['label'] ?? 'เหตุผลที่ไม่อนุมัติ') ?>:</p>
                                <p style="margin: 0; font-size: 14px; color: #555;"><?= esc($reason['text'] ?? 'ไม่ได้ระบุเหตุผล') ?></p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <!-- Status Badge -->
                    <?php if (!empty($status)): ?>
                    <tr>
                        <td style="padding: 16px 30px 0;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="background: <?= $status['bg'] ?? '#fff3e0' ?>; color: <?= $status['color'] ?? '#e65100' ?>; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                                        <?= esc($status['text'] ?? '') ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <!-- CTA Button -->
                    <?php if (!empty($cta_url)): ?>
                    <tr>
                        <td style="padding: 24px 30px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="<?= esc($cta_url) ?>" target="_blank" style="display: inline-block; background: linear-gradient(135deg, <?= $color ?>, <?= $colorEnd ?>); color: #ffffff; padding: 14px 36px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 15px; box-shadow: 0 4px 12px <?= $color ?>4D;">
                                            <?= esc($cta_text ?? '👉 ดูรายละเอียด') ?>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 16px 30px 20px; border-top: 1px solid #f0f0f0; text-align: center;">
                            <?php if (!empty($footer_text)): ?>
                                <p style="margin: 0 0 6px; font-size: 12px; color: #999;"><?= esc($footer_text) ?></p>
                            <?php endif; ?>
                            <p style="margin: 0; font-size: 12px; color: #bbb;">อีเมลนี้ถูกส่งโดยระบบอัตโนมัติ กรุณาอย่าตอบกลับ</p>
                            <p style="margin: 4px 0 0; font-size: 12px; color: #bbb;">© <?= date('Y') + 543 ?> โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
