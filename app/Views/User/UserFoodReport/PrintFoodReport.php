<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap');
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f5f5f5;
        }
        .receipt-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 2rem;
            border-bottom: 2px solid #000;
            padding-bottom: 1rem;
        }
        .receipt-header h2 {
            margin: 0;
            font-weight: bold;
        }
        .receipt-details, .report-body, .signatures {
            margin-bottom: 2rem;
        }
        .receipt-details .row {
            margin-bottom: 0.5rem;
        }
        .report-body h5 {
            font-weight: bold;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
        }
        .signatures {
            display: flex;
            justify-content: center; /* Changed from space-between */
            gap: 10%; /* Added gap between the two boxes */
            margin-top: 4rem;
        }
        .signature-box {
            text-align: center;
            width: 45%;
            padding: 10px; /* Added padding */
        }
        .signature-line {
            border-bottom: 1px solid #000;
            margin-top: 3rem;
            margin-bottom: 0.5rem;
        }
        .no-print {
            text-align: center;
            margin: 2rem;
        }
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }
        .img-thumbnail {
            max-width: 100%;
            max-height: 250px;
        }
        @media print {
            @page {
                size: A4; /* A4 is portrait by default */
                margin: 15mm; /* Standard margin */
            }
            body {
                background-color: #fff;
                font-size: 10pt; /* Smaller font for print */
            }
            .receipt-container {
                margin: 0;
                padding: 0;
                border: none;
                box-shadow: none;
                width: 100%;
            }
            .receipt-header {
                margin-bottom: 0.5rem;
                padding-bottom: 0.5rem;
            }
            .receipt-header h2 {
                font-size: 16pt;
            }
            .receipt-details, .report-body, .signatures {
                margin-bottom: 0.5rem;
            }
            .receipt-details .row {
                margin-bottom: 0.2rem;
            }
            .report-body h5 {
                font-size: 11pt;
                margin-top: 0.8rem;
                margin-bottom: 0.4rem;
            }
            .image-gallery {
                gap: 0.5rem;
            }
            .img-thumbnail {
                width: 100%;
                aspect-ratio: 1 / 1; /* Create a square box */
                object-fit: cover; /* Scale and crop image to fill the box */
            }
            .signatures {
                margin-top: 1.5rem;
                page-break-inside: avoid; /* Try to keep signatures together */
            }
            .signature-line {
                margin-top: 1.5rem;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <?php if (!empty($food_report)):
            ?>
            <div class="receipt-header">
                <h2>บันทึกรายงานอาหาร</h2>
                <p class="text-muted">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
            </div>

            <div class="receipt-details">
                <div class="row">
                    <div class="col"><strong>เลขที่เอกสาร:</strong> FOOD-<?= esc(str_pad($food_report['food_id'], 5, '0', STR_PAD_LEFT)) ?></div>
                    <div class="col text-end"><strong>วันที่บันทึก:</strong> <?= esc(date('d/m/Y H:i', strtotime($food_report['created_at']))) ?></div>
                </div>
                 <div class="row">
                    <div class="col"><strong>วันที่ทานอาหาร:</strong> <?= esc(date('d/m/Y', strtotime($food_report['food_date']))) ?></div>
                    <div class="col text-end"><strong>มื้ออาหาร:</strong> <?= esc($food_report['food_meal']) ?></div>
                </div>
            </div>

            <div class="report-body">
                <h5>รายการอาหาร</h5>
                <p><?= nl2br(esc($food_report['food_menu'])) ?></p>

                <?php
                $images = json_decode($food_report['food_images'], true);
                if (is_array($images) && !empty($images)):
                ?>
                    <h5>รูปภาพประกอบ</h5>
                    <div class="image-gallery">
                        <?php foreach($images as $image): 
                            $imageUrl = env("upload.server.baseurl") . date('Y-m-d', strtotime($food_report['food_date'])) . "/" . $image;
                            $proxiedUrl = base_url('image_proxy.php?url=' . urlencode($imageUrl));
                        ?>
                            <a href="<?= esc($imageUrl, 'attr') ?>" target="_blank">
                                <img src="<?= esc($proxiedUrl, 'attr') ?>" alt="Food Image" class="img-thumbnail">
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="signatures">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <p><?php
                            $creator_name = trim(($food_report['pers_prefix'] ?? '') . ($food_report['pers_firstname'] ?? '') . ' ' . ($food_report['pers_lastname'] ?? ''));
                            echo esc($creator_name) ?: 'N/A';
                        ?></p>
                    <p>
                        <strong>ผู้ส่งงาน/ผู้บันทึก:</strong><br>
                        
                    </p>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <p><strong>ลงชื่อ:</strong> ..................................ประธานกรรมการ</p>
                    <p><strong>ลงชื่อ:</strong> .............................................กรรมการ</p>
                    <p><strong>ลงชื่อ:</strong> .............................................กรรมการ</p>
                    <p><strong>ลงชื่อ:</strong> .............................................กรรมการ</p>
                </div>
            </div>

        <?php else: ?>
            <p class="text-center">ไม่พบข้อมูลรายงานอาหาร</p>
        <?php endif; ?>
    </div>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary">พิมพ์รายงาน</button>
        <button onclick="window.close()" class="btn btn-secondary">ปิดหน้าต่าง</button>
    </div>
</body>
</html>
