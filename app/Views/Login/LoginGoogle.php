<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    .login-page-wrapper {
        min-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: radial-gradient(circle at top right, #f8f9ff 0%, #eef2f7 100%);
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    /* Floating blobs for premium background */
    .login-page-wrapper::before,
    .login-page-wrapper::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
    }
    .login-page-wrapper::before {
        width: 300px; height: 300px;
        background: rgba(105, 108, 255, 0.1);
        top: -100px; left: -100px;
    }
    .login-page-wrapper::after {
        width: 250px; height: 250px;
        background: rgba(3, 195, 236, 0.1);
        bottom: -50px; right: -50px;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 28px;
        box-shadow: 0 25px 50px -12px rgba(105, 108, 255, 0.15);
        padding: 3.5rem 2.5rem;
        max-width: 480px;
        width: 100%;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.8);
        position: relative;
        z-index: 1;
        animation: cardAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes cardAppear {
        from { opacity: 0; transform: translateY(30px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .login-logo-container {
        position: relative;
        margin-bottom: 2rem;
        display: inline-block;
    }

    .login-logo {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: white;
        font-size: 2.8rem;
        box-shadow: 0 10px 25px -5px rgba(105, 108, 255, 0.4);
        transform: rotate(-5deg);
        transition: transform 0.3s ease;
    }

    .login-card:hover .login-logo {
        transform: rotate(0deg) scale(1.05);
    }

    .login-title {
        font-family: 'K2D', sans-serif;
        font-weight: 700;
        color: #2b3a4a;
        margin-bottom: 0.75rem;
        font-size: 1.75rem;
    }

    .login-subtitle {
        color: #697a8d;
        margin-bottom: 2.5rem;
        font-size: 1rem;
        line-height: 1.6;
    }

    /* Login Action Area */
    .login-action-box {
        background: #f8faff;
        border-radius: 20px;
        padding: 2rem;
        border: 1px dashed #d4d8e1;
        margin-bottom: 2rem;
    }

    .login-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #696cff;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1.25rem;
    }

    /* Enhanced Google Button */
    .login-card a.btn {
        width: 100% !important;
        margin-right: 0 !important;
        padding: 16px 24px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 16px;
        background: #fff;
        color: #3c4043;
        border: 1px solid #dadce0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .login-card a.btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        background: #fff;
        border-color: #696cff;
        color: #696cff;
    }

    .login-card a.btn i {
        font-size: 1.5rem;
        color: #ea4335; /* Google Identity Red */
    }

    /* Error Alert Styling */
    .error-alert {
        background: #fff5f5;
        border: 1px solid #ffe2e2;
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 2rem;
        text-align: left;
        border-left: 5px solid #ff3e1d;
    }

    .error-alert i {
        color: #ff3e1d;
        font-size: 1.5rem;
    }

    .error-alert .error-title {
        color: #b91c1c;
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 4px;
    }

    .error-alert .error-email {
        color: #7f8c8d;
        font-size: 0.85rem;
        font-family: monospace;
        word-break: break-all;
    }

    /* Footer Info */
    .login-footer {
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }

    .help-link {
        color: #696cff;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .help-link:hover { text-decoration: underline; }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-8px); }
        75% { transform: translateX(8px); }
    }

    .shake-animation {
        animation: shake 0.4s ease-in-out 0s 2;
    }

    /* Mobile Responsiveness Improvements */
    @media (max-width: 576px) {
        .login-page-wrapper {
            padding: 1rem;
            align-items: flex-start; /* Start from top on small phones */
            padding-top: 10vh;
        }

        .login-card {
            padding: 2.5rem 1.5rem;
            border-radius: 24px;
        }

        .login-logo {
            width: 70px;
            height: 70px;
            font-size: 2.2rem;
            border-radius: 20px;
        }

        .login-title {
            font-size: 1.5rem;
        }

        .login-subtitle {
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .login-action-box {
            padding: 1.5rem 1rem;
            border-radius: 16px;
        }

        .login-card a.btn {
            padding: 14px 20px;
            font-size: 1rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="login-page-wrapper">
    <div class="login-card">
        <div class="login-logo-container">
            <div class="login-logo">
                <i class='bx bxs-user-badge'></i>
            </div>
        </div>
        
        <h3 class="login-title">Officer Login</h3>
        <p class="login-subtitle">ระบบบริหารจัดการงานทั่วไป<br>โรงเรียนสวนกุหลาบวิทยาลัย จิรประวัติ นครสวรรค์</p>

        <?php if(session()->getFlashdata('login_error')): ?>
        <div class="error-alert shake-animation">
            <div class="d-flex align-items-start gap-3">
                <i class='bx bxs-error-alt mt-1'></i>
                <div>
                    <div class="error-title"><?= session()->getFlashdata('login_error') ?></div>
                    <?php if(session()->getFlashdata('error_email')): ?>
                    <div class="error-email">
                        <?= session()->getFlashdata('error_email') ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="login-action-box">
            <span class="login-label">กรุณาเลือกวิธีการเข้าสู่ระบบ</span>
            <a href="<?= $GoogleButton; ?>" class="btn btn-primary">
                <i class="tf-icons bx bxl-google"></i> Login by Google 
            </a>
        </div>

        <div class="login-footer">
            <p class="mb-2 small text-muted">
                <i class='bx bx-info-circle me-1'></i> 
                สงวนสิทธิ์การเข้าใช้งานเฉพาะบุคลากรที่ใช้อีเมล 
                <strong class="text-dark">@skj.ac.th</strong> เท่านั้น
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
    <?php if(session()->getFlashdata('login_error')): ?>
    // Show SweetAlert2 notification
    Swal.fire({
        icon: 'error',
        title: 'ไม่สามารถเข้าสู่ระบบได้',
        html: `
            <div style="text-align: left; padding: 1rem;">
                <p style="margin-bottom: 0.5rem; color: #566a7f;">
                    <strong>สาเหตุ:</strong> <?= session()->getFlashdata('login_error') ?>
                </p>
                <?php if(session()->getFlashdata('error_email')): ?>
                <p style="margin-bottom: 0; color: #697a8d;">
                    <strong>อีเมลที่ใช้:</strong> <?= session()->getFlashdata('error_email') ?>
                </p>
                <?php endif; ?>
            </div>
        `,
        confirmButtonText: 'ลองใหม่อีกครั้ง',
        confirmButtonColor: '#696cff',
        footer: '<small class="text-muted">กรุณาใช้อีเมล <strong>@skj.ac.th</strong> ในการเข้าสู่ระบบ</small>'
    });
    <?php endif; ?>
</script>
<?= $this->endSection() ?>