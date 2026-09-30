<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    /* --- Modern Variables --- */
    :root {
        --repair-primary: #696cff;
        --repair-secondary: #8592a3;
        --repair-success: #71dd37;
        --repair-info: #03c3ec;
        --repair-warning: #ffab00;
        --repair-danger: #ff3e1d;
        --glass-bg: rgba(255, 255, 255, 0.92);
        --glass-border: rgba(255, 255, 255, 0.7);
        --repair-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
    }

    .repair-container {
        padding-top: 1.5rem;
        padding-bottom: 3.5rem;
    }

    /* --- Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .premium-animate {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* --- Premium Header --- */
    .page-header {
        background: var(--repair-gradient);
        border-radius: 20px;
        padding: 2.5rem 2.25rem;
        margin-bottom: 2.25rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 15px 40px -10px rgba(105, 108, 255, 0.32);
    }

    .header-content { position: relative; z-index: 2; }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-header h2 {
        color: #fff;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 0.5rem;
    }

    .page-header p { 
        color: rgba(255,255,255,0.92); 
        margin-bottom: 0;
        font-size: 1rem;
    }

    .btn-white {
        background-color: #ffffff !important;
        color: var(--repair-primary) !important;
        border: none !important;
        box-shadow: 0 4px 14px rgba(0,0,0,0.15) !important;
        transition: all 0.3s ease;
    }
    .btn-white:hover {
        background-color: #f8f9ff !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2) !important;
    }

    /* --- Section Headline --- */
    .section-headline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .section-headline-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #435971;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 0;
    }

    .section-headline-title i {
        color: var(--repair-primary);
        font-size: 1.6rem;
    }

    /* --- Category Card Style --- */
    .repair-cat-card-wrapper {
        text-decoration: none !important;
        color: inherit !important;
        display: block;
        height: 100%;
    }

    .repair-cat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 1.35rem;
        padding: 1.75rem 1.5rem 1.5rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(67, 89, 113, 0.06);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
    }

    /* Top Accent Line on Card */
    .repair-cat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: var(--cat-gradient, var(--repair-gradient));
        opacity: 0.9;
        transition: all 0.3s ease;
    }

    .repair-cat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 38px -5px var(--cat-shadow, rgba(105, 108, 255, 0.25));
        border-color: var(--cat-border, rgba(105, 108, 255, 0.4));
        background: #ffffff;
    }

    .repair-cat-card:hover::before {
        height: 7px;
        opacity: 1;
    }

    /* Icon Box with Smooth Glow */
    .cat-icon-box {
        width: 86px;
        height: 86px;
        border-radius: 1.35rem;
        background: var(--cat-icon-bg, rgba(105, 108, 255, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 8px 20px var(--cat-shadow, rgba(105, 108, 255, 0.15));
        flex-shrink: 0;
        position: relative;
    }

    .cat-svg-icon {
        width: 58px;
        height: 58px;
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), filter 0.3s ease;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.08));
    }

    .repair-cat-card:hover .cat-icon-box {
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 14px 30px var(--cat-shadow, rgba(105, 108, 255, 0.28));
        background: #ffffff;
    }

    .repair-cat-card:hover .cat-svg-icon {
        transform: scale(1.15) rotate(4deg);
        filter: drop-shadow(0 8px 16px var(--cat-shadow, rgba(105, 108, 255, 0.25)));
    }

    .cat-badge {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.35rem 0.8rem;
        border-radius: 30px;
        background: var(--cat-icon-bg, rgba(105, 108, 255, 0.1));
        color: var(--cat-color, var(--repair-primary));
        border: 1px solid var(--cat-border, rgba(105, 108, 255, 0.2));
    }

    .cat-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: #32475c;
        margin-bottom: 0.25rem;
        line-height: 1.35;
        transition: color 0.2s ease;
    }

    .repair-cat-card:hover .cat-title {
        color: var(--cat-color, var(--repair-primary));
    }

    .cat-subtitle {
        font-size: 0.78rem;
        color: #8592a3;
        font-weight: 600;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cat-description {
        font-size: 0.85rem;
        color: #697a8d;
        line-height: 1.55;
        margin-bottom: 1rem;
        flex-grow: 1;
    }

    /* Tag Pills */
    .cat-tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        margin-bottom: 1.25rem;
    }

    .cat-tag-pill {
        font-size: 0.74rem;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        background: #f5f6f8;
        color: #697a8d;
        border: 1px solid #e7eaf0;
        transition: all 0.2s ease;
    }

    .repair-cat-card:hover .cat-tag-pill {
        background: var(--cat-icon-bg, #f0f2ff);
        color: var(--cat-color, var(--repair-primary));
        border-color: transparent;
    }

    /* Card Action Footer */
    .cat-footer {
        padding-top: 1rem;
        border-top: 1px dashed rgba(67, 89, 113, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cat-stats-badge {
        font-size: 0.75rem;
        color: #8592a3;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .cat-action-btn {
        padding: 0.5rem 1.15rem;
        border-radius: 0.75rem;
        font-size: 0.84rem;
        font-weight: 700;
        background: var(--cat-icon-bg, rgba(105, 108, 255, 0.1));
        color: var(--cat-color, var(--repair-primary));
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.3s ease;
    }

    .repair-cat-card:hover .cat-action-btn {
        background: var(--cat-color, var(--repair-primary));
        color: #ffffff;
        box-shadow: 0 4px 14px var(--cat-shadow, rgba(105, 108, 255, 0.3));
    }

    .repair-cat-card:hover .cat-action-btn i {
        transform: translateX(4px);
    }

    @media (max-width: 768px) {
        .repair-container {
            padding-top: 1rem;
            padding-bottom: 2rem;
        }
        .page-header {
            padding: 1.5rem 1.25rem;
            border-radius: 1.25rem;
            margin-bottom: 1.5rem;
        }
        .page-header h2 {
            font-size: 1.35rem;
        }
        .cat-icon-box {
            width: 72px;
            height: 72px;
            border-radius: 1.15rem;
        }
        .cat-svg-icon {
            width: 48px;
            height: 48px;
        }
        .cat-title {
            font-size: 1.1rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?php
/**
 * Helper to render custom high quality SVG illustrations for repair categories
 */
function renderRepairCategorySVG($catId) {
    switch ($catId) {
        case 'computer':
            return '
            <svg class="cat-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="svgGradComp" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#7c80ff" />
                        <stop offset="100%" stop-color="#4e51d8" />
                    </linearGradient>
                    <linearGradient id="svgGradCompLight" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#ffffff" />
                        <stop offset="100%" stop-color="#e8e9ff" />
                    </linearGradient>
                </defs>
                <!-- Monitor Outer Frame -->
                <rect x="5" y="8" width="40" height="28" rx="4" fill="url(#svgGradComp)" />
                <!-- Screen Glass -->
                <rect x="8" y="11" width="34" height="22" rx="2" fill="url(#svgGradCompLight)" />
                <!-- Screen Content -->
                <rect x="12" y="14" width="14" height="3" rx="1.5" fill="#696cff" />
                <rect x="12" y="19" width="26" height="2" rx="1" fill="#b0b3ff" />
                <rect x="12" y="23" width="18" height="2" rx="1" fill="#b0b3ff" />
                <circle cx="35" cy="15" r="3" fill="#696cff" />
                <!-- Monitor Stand -->
                <path d="M21 36H29L31 42H19L21 36Z" fill="#4e51d8" />
                <rect x="16" y="42" width="18" height="3" rx="1.5" fill="url(#svgGradComp)" />
                <!-- Optical Projector Device (Right Side) -->
                <rect x="34" y="28" width="24" height="15" rx="3.5" fill="url(#svgGradComp)" stroke="#ffffff" stroke-width="1.5" />
                <!-- Projector Lens & Glow Ring -->
                <circle cx="42" cy="35.5" r="4.5" fill="#ffffff" />
                <circle cx="42" cy="35.5" r="2.5" fill="#696cff" />
                <circle cx="42" cy="35.5" r="1" fill="#ffffff" />
                <!-- Projector Air Vents -->
                <path d="M51 32.5H54M51 35.5H55M51 38.5H54" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                <!-- Light Projector Beam -->
                <path d="M46.5 35.5L59 28V43L46.5 35.5Z" fill="url(#svgGradComp)" fill-opacity="0.3" />
                <!-- Keyboard Bar at bottom -->
                <rect x="9" y="48" width="32" height="4" rx="2" fill="#d9dbff" />
                <circle cx="47" cy="50" r="3" fill="#a5a8ff" />
            </svg>';

        case 'printer':
            return '
            <svg class="cat-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="svgGradPrint" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#03c3ec" />
                        <stop offset="100%" stop-color="#018fae" />
                    </linearGradient>
                    <linearGradient id="svgGradPaper" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#ffffff" />
                        <stop offset="100%" stop-color="#d8f8ff" />
                    </linearGradient>
                </defs>
                <!-- Top Paper Feed -->
                <rect x="18" y="6" width="28" height="18" rx="2" fill="url(#svgGradPaper)" stroke="#03c3ec" stroke-width="1.5" />
                <line x1="22" y1="11" x2="34" y2="11" stroke="#03c3ec" stroke-width="1.5" stroke-linecap="round" />
                <line x1="22" y1="15" x2="42" y2="15" stroke="#7ddff5" stroke-width="1.5" stroke-linecap="round" />
                <!-- Printer Main Machine Body -->
                <rect x="7" y="20" width="50" height="24" rx="5" fill="url(#svgGradPrint)" />
                <!-- Scanner Glass Top Border Line -->
                <line x1="11" y1="26" x2="53" y2="26" stroke="rgba(255,255,255,0.4)" stroke-width="1.5" />
                <!-- Paper Tray Output Slot -->
                <rect x="15" y="32" width="34" height="8" rx="2" fill="#01667d" />
                <!-- Printed Document Output -->
                <rect x="19" y="34" width="26" height="23" rx="2" fill="url(#svgGradPaper)" stroke="#03c3ec" stroke-width="1.5" />
                <line x1="23" y1="40" x2="37" y2="40" stroke="#03c3ec" stroke-width="1.5" stroke-linecap="round" />
                <line x1="23" y1="44" x2="41" y2="44" stroke="#03c3ec" stroke-width="1.5" stroke-linecap="round" />
                <line x1="23" y1="48" x2="35" y2="48" stroke="#03c3ec" stroke-width="1.5" stroke-linecap="round" />
                <line x1="23" y1="52" x2="39" y2="52" stroke="#7ddff5" stroke-width="1.5" stroke-linecap="round" />
                <!-- Status LEDs & Buttons -->
                <circle cx="49" cy="23" r="2" fill="#71dd37" />
                <circle cx="44" cy="23" r="1.5" fill="#ffffff" />
                <circle cx="40" cy="23" r="1.5" fill="#ffffff" />
            </svg>';

        case 'network':
            return '
            <svg class="cat-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="svgGradNet" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#8ceb5c" />
                        <stop offset="100%" stop-color="#4ea71c" />
                    </linearGradient>
                </defs>
                <!-- Wi-Fi Waves Emitting -->
                <path d="M17 15C26 7 38 7 47 15" stroke="#71dd37" stroke-width="3" stroke-linecap="round" />
                <path d="M22 20C28 15 36 15 42 20" stroke="#71dd37" stroke-width="3" stroke-linecap="round" stroke-opacity="0.8" />
                <circle cx="32" cy="25" r="2.5" fill="#71dd37" />
                <!-- Router Antennas -->
                <line x1="16" y1="36" x2="10" y2="17" stroke="#4ea71c" stroke-width="3" stroke-linecap="round" />
                <circle cx="10" cy="17" r="2.5" fill="#71dd37" />
                <line x1="48" y1="36" x2="54" y2="17" stroke="#4ea71c" stroke-width="3" stroke-linecap="round" />
                <circle cx="54" cy="17" r="2.5" fill="#71dd37" />
                <!-- Main Router Body -->
                <rect x="7" y="33" width="50" height="19" rx="6" fill="url(#svgGradNet)" />
                <!-- Front Display Panel -->
                <rect x="11" y="37" width="42" height="11" rx="3" fill="#2d6410" />
                <!-- Glowing LEDs -->
                <circle cx="17" cy="42.5" r="2" fill="#a7f57a" />
                <circle cx="23" cy="42.5" r="2" fill="#a7f57a" />
                <circle cx="29" cy="42.5" r="2" fill="#a7f57a" />
                <circle cx="35" cy="42.5" r="2" fill="#03c3ec" />
                <circle cx="41" cy="42.5" r="2" fill="#ffab00" />
                <circle cx="47" cy="42.5" r="2" fill="#a7f57a" />
                <!-- LAN Connector Port Below -->
                <path d="M25 52V57H39V52" stroke="#4ea71c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                <rect x="29" y="54" width="6" height="5" rx="1" fill="#71dd37" />
            </svg>';

        case 'av':
            return '
            <svg class="cat-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="svgGradAV" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#ffb82e" />
                        <stop offset="100%" stop-color="#cc8800" />
                    </linearGradient>
                </defs>
                <!-- Large Stage Audio Speaker Cabinet -->
                <rect x="7" y="9" width="31" height="47" rx="5" fill="url(#svgGradAV)" />
                <!-- Top Tweeter Cone -->
                <circle cx="22.5" cy="21" r="5" fill="#5c3c00" />
                <circle cx="22.5" cy="21" r="2.5" fill="#ffd166" />
                <!-- Bottom Subwoofer Cone -->
                <circle cx="22.5" cy="40" r="10" fill="#5c3c00" />
                <circle cx="22.5" cy="40" r="6" fill="#ffd166" />
                <circle cx="22.5" cy="40" r="2.5" fill="#ffffff" />
                <!-- Acoustic Wave Arcs -->
                <path d="M41 19C45 22 47 26 47 30C47 34 45 38 41 41" stroke="#ffab00" stroke-width="2.5" stroke-linecap="round" />
                <path d="M46 13C52 18 55 24 55 30C55 36 52 42 46 47" stroke="#ffab00" stroke-width="2.5" stroke-linecap="round" stroke-opacity="0.6" />
                <!-- Stage Microphone (Right) -->
                <rect x="42" y="15" width="10" height="15" rx="5" fill="#32475c" stroke="#ffab00" stroke-width="1.5" />
                <line x1="42" y1="20" x2="52" y2="20" stroke="#ffab00" stroke-width="1" />
                <line x1="42" y1="25" x2="52" y2="25" stroke="#ffab00" stroke-width="1" />
                <!-- Mic Stand U-bracket -->
                <path d="M39 23C39 28.5 42.5 33 47 33C51.5 33 55 28.5 55 23" stroke="#ffab00" stroke-width="2" stroke-linecap="round" />
                <line x1="47" y1="33" x2="47" y2="41" stroke="#ffab00" stroke-width="2.5" stroke-linecap="round" />
                <line x1="42" y1="41" x2="52" y2="41" stroke="#ffab00" stroke-width="2.5" stroke-linecap="round" />
            </svg>';

        case 'building':
            return '
            <svg class="cat-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="svgGradBld" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#ff5e3a" />
                        <stop offset="100%" stop-color="#c4290d" />
                    </linearGradient>
                    <linearGradient id="svgGradBulb" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#ffca28" />
                        <stop offset="100%" stop-color="#ff9800" />
                    </linearGradient>
                </defs>
                <!-- School Architectural Pediment Roof -->
                <path d="M6 21L28 7L50 21H6Z" fill="url(#svgGradBld)" />
                <!-- Building Body & Walls -->
                <rect x="9" y="21" width="38" height="34" rx="2" fill="#ffece8" stroke="#ff3e1d" stroke-width="1.5" />
                <!-- Classic Columns -->
                <rect x="13" y="23" width="4" height="27" rx="1" fill="url(#svgGradBld)" />
                <rect x="21" y="23" width="4" height="27" rx="1" fill="url(#svgGradBld)" />
                <rect x="29" y="23" width="4" height="27" rx="1" fill="url(#svgGradBld)" />
                <!-- Main Entrance Archway -->
                <path d="M37 50V35C37 32.5 39 30.5 41.5 30.5C44 30.5 46 32.5 46 35V50H37Z" fill="url(#svgGradBld)" />
                <!-- Foundation Steps -->
                <rect x="5" y="51" width="46" height="4" rx="1.5" fill="url(#svgGradBld)" />
                <!-- Electrical / Utility Maintenance Bulb (Top Right) -->
                <circle cx="48" cy="17" r="9.5" fill="url(#svgGradBulb)" stroke="#ffffff" stroke-width="1.5" />
                <path d="M45 18L47 14L49 18L51 14" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <!-- Light Glow Sparks -->
                <line x1="48" y1="4" x2="48" y2="6" stroke="#ffab00" stroke-width="2" stroke-linecap="round" />
                <line x1="58" y1="10" x2="60" y2="8" stroke="#ffab00" stroke-width="2" stroke-linecap="round" />
                <line x1="60" y1="20" x2="58" y2="20" stroke="#ffab00" stroke-width="2" stroke-linecap="round" />
            </svg>';

        case 'general':
        default:
            return '
            <svg class="cat-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="svgGradGen" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#9aa5b5" />
                        <stop offset="100%" stop-color="#5a6a7e" />
                    </linearGradient>
                </defs>
                <!-- Heavy Duty Toolbox Handle -->
                <path d="M21 17V11C21 9.5 22.5 8 24 8H40C41.5 8 43 9.5 43 11V17" stroke="#5a6a7e" stroke-width="3" stroke-linecap="round" />
                <!-- Toolbox Chest Body -->
                <rect x="7" y="17" width="50" height="35" rx="6" fill="url(#svgGradGen)" />
                <!-- Metal Latch Bar & Fasteners -->
                <rect x="5" y="26" width="54" height="6" rx="2" fill="#384554" />
                <rect x="17" y="24" width="6" height="10" rx="1.5" fill="#ffab00" />
                <rect x="41" y="24" width="6" height="10" rx="1.5" fill="#ffab00" />
                <!-- Mechanical Gear Cog in Front -->
                <g transform="translate(19, 34)">
                    <circle cx="13" cy="11" r="9" fill="#2d3844" />
                    <circle cx="13" cy="11" r="4" fill="#ffffff" />
                    <path d="M13 0V4M13 18V22M2 11H6M20 11H24" stroke="#ffab00" stroke-width="2.5" stroke-linecap="round" />
                </g>
                <!-- Sparkles -->
                <circle cx="51" cy="13" r="2.5" fill="#696cff" />
                <path d="M51 7V9M51 17V19M45 13H47M55 13H57" stroke="#696cff" stroke-width="1.5" stroke-linecap="round" />
            </svg>';
    }
}
?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 repair-container">

    <!-- Premium Page Header -->
    <div class="page-header premium-animate">
        <div class="header-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-2">
                        <i class='bx bx-wrench fs-2 me-2'></i>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="<?=base_url()?>" class="text-white-50">หน้าแรก</a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">แจ้งซ่อมออนไลน์</li>
                            </ol>
                        </nav>
                    </div>
                    <h2>ระบบแจ้งซ่อมออนไลน์ (Online Repair Service)</h2>
                    <p>กรุณาเลือกหมวดหมู่งานซ่อมที่ต้องการ เพื่อเข้าสู่แบบฟอร์มการแจ้งซ่อมที่มีประสิทธิภาพ</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0 d-flex gap-2 justify-content-lg-end flex-wrap">
                    <a href="<?=base_url('Repair/Dashboard')?>" class="btn btn-white text-primary fw-bold shadow-sm rounded-pill px-4">
                        <i class='bx bx-pie-chart-alt-2 me-1'></i> แดชบอร์ด & รายการซ่อม
                    </a>
                    <a target="_blank" href="<?=base_url('manual/repair') ?>" class="btn btn-outline-light rounded-pill px-3">
                        <i class='bx bx-book-content me-1'></i> คู่มือการใช้งาน
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Headline -->
    <div class="section-headline premium-animate" style="animation-delay: 0.1s">
        <h3 class="section-headline-title">
            <i class='bx bxs-grid-alt'></i>
            <span>เลือกหมวดหมู่ที่ต้องการแจ้งซ่อม</span>
        </h3>
        <span class="badge bg-label-primary rounded-pill px-3 py-2 d-none d-md-inline-flex align-items-center gap-1">
            <i class='bx bx-check-circle'></i> มี 5 หมวดงานบริการ
        </span>
    </div>

    <!-- Categories Grid (Full Width Cards with Matching SVG Vector Graphics) -->
    <div class="row g-3 g-md-4 mb-4">
        <?php foreach($RepairCategories as $index => $cat): ?>
            <?php 
            $catStat = $CategoryStats[$cat['caselist']] ?? ['total' => 0, 'pending' => 0, 'in_progress' => 0, 'completed' => 0];
            $pendingCount = $catStat['pending'];
            ?>
            <div class="col-12 col-md-6 col-lg-4 premium-animate" style="animation-delay: <?= 0.15 + ($index * 0.08) ?>s">
                <a href="<?= base_url('Repair/Add?category=' . urlencode($cat['caselist'])) ?>" 
                   class="repair-cat-card-wrapper"
                   style="--cat-color: <?= $cat['color'] ?>; 
                          --cat-gradient: <?= $cat['gradient'] ?>; 
                          --cat-icon-bg: <?= $cat['bg_light'] ?>; 
                          --cat-border: <?= $cat['border_color'] ?>; 
                          --cat-shadow: <?= $cat['color'] ?>40;">
                    <div class="repair-cat-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="cat-icon-box">
                                <?= renderRepairCategorySVG($cat['id']) ?>
                            </div>
                            <span class="cat-badge">
                                <?= $cat['badge'] ?>
                            </span>
                        </div>

                        <h4 class="cat-title"><?= $cat['title'] ?></h4>
                        <div class="cat-subtitle"><?= $cat['sub_title'] ?></div>
                        <p class="cat-description"><?= $cat['description'] ?></p>

                        <!-- Tag Pills -->
                        <div class="cat-tags-container">
                            <?php foreach($cat['tags'] as $tag): ?>
                                <span class="cat-tag-pill"><i class='bx bx-check me-1'></i><?= $tag ?></span>
                            <?php endforeach; ?>
                        </div>

                        <div class="cat-footer">
                            <div class="cat-stats-badge">
                                <?php if($pendingCount > 0): ?>
                                    <span class="badge bg-label-warning rounded-pill px-2 py-1">
                                        <i class='bx bx-time-five me-1'></i> รอซ่อม <?= $pendingCount ?> งาน
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-label-success rounded-pill px-2 py-1">
                                        <i class='bx bx-check-circle me-1'></i> พร้อมรับแจ้ง
                                    </span>
                                <?php endif; ?>
                            </div>
                            <span class="cat-action-btn">
                                แจ้งซ่อมหมวดนี้ <i class='bx bx-right-arrow-alt'></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

        <!-- 6th Card: General / Custom Repair Card to fill the grid evenly -->
        <div class="col-12 col-md-6 col-lg-4 premium-animate" style="animation-delay: 0.55s">
            <a href="<?= base_url('Repair/Add') ?>" 
               class="repair-cat-card-wrapper"
               style="--cat-color: #8592a3; 
                      --cat-gradient: linear-gradient(135deg, #8592a3 0%, #566a7f 100%); 
                      --cat-icon-bg: rgba(133, 146, 163, 0.1); 
                      --cat-border: rgba(133, 146, 163, 0.25); 
                      --cat-shadow: #8592a340;">
                <div class="repair-cat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="cat-icon-box">
                            <?= renderRepairCategorySVG('general') ?>
                        </div>
                        <span class="cat-badge">
                            งานทั่วไป
                        </span>
                    </div>

                    <h4 class="cat-title">แจ้งซ่อมทั่วไป / อื่นๆ</h4>
                    <div class="cat-subtitle">General & Other Repairs</div>
                    <p class="cat-description">สำหรับงานซ่อมที่ไม่ตรงกับ 5 หมวดหลักข้างต้น หรือไม่แน่ใจประเภท สามารถเปิดฟอร์มเพื่อกรอกข้อมูลได้โดยตรง</p>

                    <!-- Tag Pills -->
                    <div class="cat-tags-container">
                        <span class="cat-tag-pill"><i class='bx bx-check me-1'></i>เปิดฟอร์มทันที</span>
                        <span class="cat-tag-pill"><i class='bx bx-check me-1'></i>เลือกหมวดภายหลัง</span>
                        <span class="cat-tag-pill"><i class='bx bx-check me-1'></i>งานซ่อมทั่วไป</span>
                    </div>

                    <div class="cat-footer">
                        <div class="cat-stats-badge">
                            <span class="badge bg-label-secondary rounded-pill px-2 py-1">
                                <i class='bx bx-edit me-1'></i> ระบุปัญหาเอง
                            </span>
                        </div>
                        <span class="cat-action-btn">
                            เปิดฟอร์มแจ้งซ่อม <i class='bx bx-right-arrow-alt'></i>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
