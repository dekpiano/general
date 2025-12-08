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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
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

        <div class="my-4">
            <?= $GoogleButton; ?>
        </div>

        <div class="mt-4">
            <small class="text-muted">กรุณาเข้าสู่ระบบด้วยบัญชี Google ของโรงเรียน<br>(@skj.ac.th)</small>
        </div>
    </div>
</div>
<?= $this->endSection() ?>