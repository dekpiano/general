<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    .login-page-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 2rem;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 3rem;
        max-width: 450px;
        width: 100%;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.5);
        animation: fadeIn 0.8s ease-out;
    }

    .login-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, #696cff, #8592a3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2.5rem;
        box-shadow: 0 5px 15px rgba(105, 108, 255, 0.4);
    }

    .login-title {
        font-family: 'Prompt', sans-serif;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .login-subtitle {
        color: #666;
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }

    /* Target the Google Button passed from controller */
    .login-card a.btn {
        width: 100% !important;
        margin-right: 0 !important;
        padding: 12px 20px;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 50px;
        background: white;
        color: #444;
        border: 1px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .login-card a.btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        background: #f8f9fa;
        border-color: #cdd1e0;
    }

    .login-card a.btn i {
        font-size: 1.4rem;
        color: #db4437; /* Google Red */
    }

    /* Error Alert Styling */
    .error-alert {
        background: linear-gradient(135deg, rgba(255, 62, 29, 0.1) 0%, rgba(255, 62, 29, 0.05) 100%);
        border: 1px solid rgba(255, 62, 29, 0.3);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        text-align: left;
    }

    .error-alert i {
        color: #ff3e1d;
        font-size: 1.25rem;
    }

    .error-alert .error-title {
        color: #ff3e1d;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .error-alert .error-email {
        color: #566a7f;
        font-size: 0.8rem;
        background: rgba(0,0,0,0.05);
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        margin-top: 4px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-5px); }
        40%, 80% { transform: translateX(5px); }
    }

    .shake-animation {
        animation: shake 0.5s ease-in-out;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="login-page-wrapper">
    <div class="login-card">
        <div class="login-logo">
            <i class='bx bxs-school'></i>
        </div>
        
        <h3 class="login-title">SKJ General System</h3>
        <p class="login-subtitle">ระบบบริหารจัดการงานทั่วไป<br>โรงเรียนสวนกุหลาบวิทยาลัย จิรประวัติ นครสวรรค์</p>

        <?php if(session()->getFlashdata('login_error')): ?>
        <div class="error-alert shake-animation">
            <div class="d-flex align-items-start gap-2">
                <i class='bx bxs-error-circle mt-1'></i>
                <div>
                    <div class="error-title"><?= session()->getFlashdata('login_error') ?></div>
                    <?php if(session()->getFlashdata('error_email')): ?>
                    <div class="error-email">
                        <i class='bx bx-envelope me-1'></i>
                        <?= session()->getFlashdata('error_email') ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="my-4">
            <?= $GoogleButton; ?>
        </div>

        <div class="mt-4">
            <small class="text-muted">กรุณาเข้าสู่ระบบด้วยบัญชี Google ของโรงเรียน<br><strong class="text-primary">@skj.ac.th</strong> เท่านั้น</small>
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