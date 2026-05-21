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
        .image-gallery a {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 200px;
            background-color: #fafafa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .image-gallery a:hover {
            border-color: #15a362;
            box-shadow: 0 4px 12px rgba(21, 163, 98, 0.1);
        }
        .img-thumbnail {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: none;
            border-radius: 0;
            padding: 0;
            transition: transform 0.3s ease;
        }
        .rotate-to-landscape {
            transform: rotate(90deg) !important;
            /* When rotated 90deg, natural height becomes visual width, and natural width becomes visual height.
               So we swap container height and width to cover it perfectly! */
            width: 200px !important; /* matches container height */
            height: 245px !important; /* matches container width */
            object-fit: cover !important;
        }
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm 15mm; /* Standard, elegant margins for A4 */
            }
            body {
                background-color: #fff !important;
                font-size: 10pt !important;
                line-height: 1.4 !important;
            }
            .receipt-container {
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
                width: 100% !important;
                max-width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                min-height: 258mm !important; /* Perfect height to fill A4 page gracefully leaving margin safety */
                box-sizing: border-box !important;
            }
            /* Header adjustments - elegant and spacious yet fits 1 page */
            .receipt-header {
                margin-bottom: 1rem !important;
                padding-bottom: 0.8rem !important;
                border-bottom: 2px solid #000 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .receipt-header img {
                width: 68px !important; /* Elegant size */
                margin-bottom: 0.4rem !important;
            }
            .receipt-header h2 {
                font-size: 15pt !important;
                margin-bottom: 0.2rem !important;
            }
            .receipt-header p {
                font-size: 9.5pt !important;
                margin-bottom: 0 !important;
            }
            /* Details Card adjustments */
            .receipt-details {
                margin-bottom: 1rem !important;
            }
            .receipt-details .card {
                background-color: #f8f9fa !important;
                border: 1px solid #dee2e6 !important;
            }
            .receipt-details .card-body {
                padding: 0.75rem 1rem !important; /* More breathing room */
            }
            .receipt-details .row {
                margin-bottom: 0 !important;
                --bs-gutter-x: 0.75rem !important;
                --bs-gutter-y: 0.25rem !important;
            }
            .receipt-details hr {
                margin: 0.25rem 0 !important;
            }
            .receipt-details .fs-5 {
                font-size: 10.5pt !important;
            }
            .receipt-details .badge {
                font-size: 9.5pt !important;
                padding: 0.2em 0.5em !important;
            }
            .receipt-details span.small {
                font-size: 8.5pt !important;
            }
            /* Report Body adjustments */
            .report-body {
                margin-bottom: 1rem !important;
            }
            .report-body h5 {
                font-size: 11pt !important;
                margin-top: 0.8rem !important;
                margin-bottom: 0.4rem !important;
                padding-bottom: 0.2rem !important;
                border-bottom: 1px solid #dee2e6 !important;
            }
            .report-body p {
                font-size: 10.5pt !important;
                margin-bottom: 0.8rem !important;
                line-height: 1.4 !important;
            }
            /* Image Gallery adjustments - Elegant size that fills the page */
            .image-gallery {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 0.75rem !important;
                margin-top: 0.4rem !important;
                margin-bottom: 1rem !important;
            }
            .image-gallery a {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                height: 150px !important; /* Uniform height frame for printing */
                background-color: #fafafa !important;
                border: 1px solid #dee2e6 !important;
                border-radius: 4px !important;
                overflow: hidden !important;
            }
            .img-thumbnail {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important; /* Stretch and crop to fill the frame completely! */
                border: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
                transition: transform 0.2s ease !important;
            }
            .rotate-to-landscape {
                transform: rotate(90deg) !important;
                /* When rotated 90deg, we swap container height and width to cover it perfectly! */
                width: 150px !important; /* matches print container height */
                height: 220px !important; /* matches print container width */
                object-fit: cover !important;
            }
            /* Signatures Section adjustments - PUSHED TO BOTTOM using flexbox */
            .signatures {
                margin-top: auto !important; /* PUSHES signatures beautifully to the absolute bottom of the page! */
                margin-bottom: 0.5rem !important;
                display: flex !important;
                justify-content: space-between !important;
                gap: 8% !important;
                page-break-inside: avoid !important;
            }
            .signature-box {
                width: 46% !important;
                padding: 5px !important;
                font-size: 10pt !important;
            }
            .signature-box p {
                margin-bottom: 0.25rem !important;
                line-height: 1.35 !important;
            }
            .signature-line {
                margin-top: 1.8rem !important; /* Elegant space for actual signature writing */
                margin-bottom: 0.3rem !important;
                border-bottom: 1px solid #000 !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <?php if (!empty($food_report)):
            ?>
            <div class="receipt-header d-flex align-items-center justify-content-center border-bottom pb-4 mb-4">
                <div class="text-center">
                    <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" alt="School Logo" width="80" class="mb-3">
                    <h2 class="fw-bold mb-1">บันทึกรายงานอาหาร</h2>
                    <p class="text-muted mb-0">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
                </div>
            </div>

            <div class="receipt-details mb-4">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-6">
                                <span class="fw-bold text-muted d-block small">เลขที่เอกสาร</span>
                                <span class="fs-5 fw-bold">FOOD-<?= esc(str_pad($food_report['food_id'], 5, '0', STR_PAD_LEFT)) ?></span>
                            </div>
                            <div class="col-md-6 col-6 text-end">
                                <span class="fw-bold text-muted d-block small">วันที่ตรวจสอบ</span>
                                <span class="fs-5 text-primary fw-bold"><?= esc(date('d/m/Y', strtotime($food_report['food_date']))) ?></span>
                            </div>
                            <div class="col-12"><hr class="my-2 border-secondary-subtle"></div>
                            <div class="col-md-6 col-6">
                                <span class="fw-bold text-muted d-block small">วันที่บันทึก</span>
                                <span class="text-muted"><?= esc(date('d/m/Y H:i', strtotime($food_report['created_at']))) ?> น.</span>
                            </div>
                            <div class="col-md-6 col-6 text-end">
                                <span class="fw-bold text-muted d-block small">มื้ออาหาร</span>
                                <span class="badge bg-primary fs-6"><?= esc($food_report['food_meal']) ?></span>
                            </div>
                        </div>
                    </div>
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
                    <p>(<?php
                            $creator_name = trim(($food_report['pers_prefix'] ?? '') . ($food_report['pers_firstname'] ?? '') . ' ' . ($food_report['pers_lastname'] ?? ''));
                            echo esc($creator_name) ?: 'N/A';
                        ?>)</p>
                    <p>
                        <strong>ผู้ส่งงาน/ผู้บันทึก</strong>
                    </p>
                </div>
                <div class="signature-box">
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

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('.image-gallery img');
            images.forEach(img => {
                const checkRotation = () => {
                    if (img.naturalHeight > img.naturalWidth) {
                        img.classList.add('rotate-to-landscape');
                    }
                };
                if (img.complete) {
                    checkRotation();
                } else {
                    img.addEventListener('load', checkRotation);
                }
            });
        });
    </script>
</body>
</html>
