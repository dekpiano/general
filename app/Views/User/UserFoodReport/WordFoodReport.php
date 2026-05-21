<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap');
        @page {
            size: A4 portrait;
            margin: 1.5cm;
        }
        body {
            font-family: 'TH Sarabun PSK', 'TH Sarabun New', 'Sarabun', 'Cordia New', 'Angsana New', sans-serif;
            font-size: 16pt;
            line-height: 1.25;
            color: #000000;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .header-section {
            text-align: center;
            border-bottom: 2px solid #000000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header-logo {
            margin-bottom: 6px;
        }
        .header-title {
            font-size: 20pt;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .header-subtitle {
            font-size: 16pt;
            margin: 0;
        }
        .metadata-section {
            margin-bottom: 15px;
            padding: 6px 0;
            border-bottom: 1.5px solid #000000;
        }
        .metadata-row {
            margin: 4px 0;
            font-size: 16pt;
        }
        .label-text {
            font-weight: bold;
            color: #000000;
        }
        .value-text {
            font-weight: normal;
            color: #000000;
        }
        .report-title {
            font-size: 17pt;
            font-weight: bold;
            border-bottom: 1px solid #000000;
            padding-bottom: 2px;
            margin-top: 15px;
            margin-bottom: 6px;
        }
        .menu-content {
            font-size: 16pt;
            line-height: 1.3;
            margin-bottom: 15px;
        }
        .image-gallery {
            margin: 12px 0;
        }
        .signature-section {
            margin-top: 25px;
        }
        .signature-block {
            margin-bottom: 15px;
        }
        .signature-text {
            font-size: 16pt;
        }
        .committee-block {
            margin-top: 15px;
        }
        .committee-line {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div style="width: 100%; max-width: 650px; margin: 0 auto;">
        <?php if (!empty($food_report)): ?>
            <!-- Header Section -->
            <div class="header-section">
                <?php if (!empty($logo_base64)): ?>
                    <img class="header-logo" src="<?= $logo_base64 ?>" width="75" height="75" alt="School Logo" />
                <?php endif; ?>
                <div class="header-title">บันทึกรายงานอาหาร</div>
                <div class="header-subtitle">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</div>
            </div>

            <!-- Metadata Section (Table-free, stacked list for absolute compatibility and simple editing) -->
            <div class="metadata-section">
                <div class="metadata-row">
                    <span class="label-text">เลขที่เอกสาร:</span>
                    <span class="value-text">FOOD-<?= esc(str_pad($food_report['food_id'], 5, '0', STR_PAD_LEFT)) ?></span>
                </div>
                <div class="metadata-row">
                    <span class="label-text">วันที่ตรวจสอบ:</span>
                    <span class="value-text"><?= esc(date('d/m/Y', strtotime($food_report['food_date']))) ?></span>
                </div>
                <div class="metadata-row">
                    <span class="label-text">วันที่บันทึก:</span>
                    <span class="value-text"><?= esc(date('d/m/Y H:i', strtotime($food_report['created_at']))) ?> น.</span>
                </div>
                <div class="metadata-row">
                    <span class="label-text">มื้ออาหาร:</span>
                    <span class="value-text"><?= esc($food_report['food_meal']) ?></span>
                </div>
            </div>

            <!-- Report Body -->
            <div class="report-title">รายการอาหาร</div>
            <div class="menu-content">
                <?= nl2br(esc($food_report['food_menu'])) ?>
            </div>

            <!-- Image Gallery (Clean Flow Layout) -->
            <?php if (!empty($food_images_base64)): ?>
                <div class="report-title">รูปภาพประกอบ</div>
                <div class="image-gallery">
                    <?php foreach ($food_images_base64 as $img): 
                        if ($img['is_portrait']) {
                            $width = "150";
                            $height = "225";
                        } else {
                            $width = "225";
                            $height = "150";
                        }
                    ?>
                        <img src="<?= $img['base64'] ?>" width="<?= $width ?>" height="<?= $height ?>" style="margin: 5px; border: 1px solid #cccccc; padding: 2px;" alt="Food Photo" />
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <p style="text-align: center; font-size: 16pt; color: #dc2626; margin-top: 50px;">ไม่พบข้อมูลรายงานอาหาร</p>
        <?php endif; ?>
    </div>
</body>
</html>

