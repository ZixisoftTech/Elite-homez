<?php
use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\Session;
use App\Helpers\SvgIcons;
use App\Models\Enquiry;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$user = Auth::user();
$enquiryModel = new Enquiry();
$newLeadsCount = $enquiryModel->countNew();

$currentUri = $_SERVER['REQUEST_URI'] ?? '/admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Format::e($seo['title'] ?? 'Elite Homez — Executive Command Center') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/admin.css?v=<?= @filemtime(dirname(__DIR__, 3) . '/public/assets/css/admin.css') ?: time() ?>">
    <link rel="icon" type="image/png" href="<?= $baseUrl ?>/assets/images/logo.png">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <a href="<?= $baseUrl ?>/admin/dashboard" style="display: flex; align-items: center; gap: 0.75rem;">
                    <img src="<?= $baseUrl ?>/assets/images/logo.png" alt="Elite Homez Logo">
                </a>
            </div>

            <nav class="sidebar-nav">
                <a href="<?= $baseUrl ?>/admin/dashboard" class="sidebar-link <?= str_contains($currentUri, '/dashboard') ? 'active' : '' ?>">
                    <?= SvgIcons::render('activity', 'w-4 h-4', 18) ?>
                    <span>Dashboard</span>
                </a>
                <a href="<?= $baseUrl ?>/admin/properties" class="sidebar-link <?= str_contains($currentUri, '/properties') ? 'active' : '' ?>">
                    <?= SvgIcons::render('home', 'w-4 h-4', 18) ?>
                    <span>Properties</span>
                </a>
                <a href="<?= $baseUrl ?>/admin/features" class="sidebar-link <?= str_contains($currentUri, '/features') ? 'active' : '' ?>">
                    <?= SvgIcons::render('check-square', 'w-4 h-4', 18) ?>
                    <span>Features & Amenities</span>
                </a>
                <a href="<?= $baseUrl ?>/admin/services" class="sidebar-link <?= str_contains($currentUri, '/services') ? 'active' : '' ?>">
                    <?= SvgIcons::render('compass', 'w-4 h-4', 18) ?>
                    <span>Services</span>
                </a>
                <a href="<?= $baseUrl ?>/admin/areas" class="sidebar-link <?= str_contains($currentUri, '/areas') ? 'active' : '' ?>">
                    <?= SvgIcons::render('map-pin', 'w-4 h-4', 18) ?>
                    <span>Areas of Expertise</span>
                </a>
                <a href="<?= $baseUrl ?>/admin/home" class="sidebar-link <?= str_contains($currentUri, '/admin/home') ? 'active' : '' ?>">
                    <?= SvgIcons::render('layout', 'w-4 h-4', 18) ?>
                    <span>Home Page</span>
                </a>
                <a href="<?= $baseUrl ?>/admin/about" class="sidebar-link <?= str_contains($currentUri, '/about') ? 'active' : '' ?>">
                    <?= SvgIcons::render('file-text', 'w-4 h-4', 18) ?>
                    <span>About Us Page</span>
                </a>
                <a href="<?= $baseUrl ?>/admin/carousel" class="sidebar-link <?= str_contains($currentUri, '/carousel') ? 'active' : '' ?>">
                    <?= SvgIcons::render('image', 'w-4 h-4', 18) ?>
                    <span>Hero Carousel</span>
                </a>
                <a href="<?= $baseUrl ?>/admin/enquiries" class="sidebar-link <?= str_contains($currentUri, '/enquiries') ? 'active' : '' ?>" style="justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 0.85rem;">
                        <?= SvgIcons::render('mail', 'w-4 h-4', 18) ?>
                        <span>Lead Inbox</span>
                    </div>
                    <?php if ($newLeadsCount > 0): ?>
                        <span style="background: var(--admin-gold); color: #FFFFFF; font-size: 0.7rem; font-weight: 700; padding: 0.15rem 0.45rem; border-radius: 10px;">
                            <?= $newLeadsCount ?>
                        </span>
                    <?php endif; ?>
                </a>
                <a href="<?= $baseUrl ?>/admin/testimonials" class="sidebar-link <?= str_contains($currentUri, '/testimonials') ? 'active' : '' ?>">
                    <?= SvgIcons::render('star', 'w-4 h-4', 18) ?>
                    <span>Testimonials</span>
                </a>
                <a href="<?= $baseUrl ?>/admin/settings" class="sidebar-link <?= str_contains($currentUri, '/settings') ? 'active' : '' ?>">
                    <?= SvgIcons::render('archive', 'w-4 h-4', 18) ?>
                    <span>System Settings</span>
                </a>
                <a href="<?= $baseUrl ?>/admin/profile" class="sidebar-link <?= str_contains($currentUri, '/profile') ? 'active' : '' ?>">
                    <?= SvgIcons::render('user', 'w-4 h-4', 18) ?>
                    <span>Profile &amp; Security</span>
                </a>
            </nav>

            <div class="sidebar-user-box">
                <a href="<?= $baseUrl ?>/admin/profile" class="user-details" title="Edit Profile & Password" style="text-decoration: none; flex: 1; min-width: 0;">
                    <div class="user-name"><?= Format::e($user['name'] ?? 'Administrator') ?></div>
                    <div class="user-role" style="display: flex; align-items: center; gap: 0.35rem;">
                        <span style="color: var(--admin-gold); font-size: 0.72rem;">●</span>
                        <span><?= Format::e($user['role'] ?? 'admin') ?></span>
                    </div>
                </a>
                <form action="<?= $baseUrl ?>/admin/logout" method="POST" style="margin: 0;">
                    <?= Csrf::field() ?>
                    <button type="submit" title="Sign Out" style="background: none; border: none; color: #EF4444; cursor: pointer; padding: 0.25rem;">
                        <?= SvgIcons::render('logout', 'w-5 h-5', 20) ?>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Sidebar Backdrop Overlay -->
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <!-- Main Workspace -->
        <div class="admin-main">
            <header class="admin-topbar">
                <div style="display: flex; align-items: center; gap: 0.75rem; min-width: 0;">
                    <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle navigation">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div style="font-weight: 600; font-size: 1.1rem; color: var(--admin-navy); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?= Format::e($pageHeading ?? 'Executive Dashboard') ?>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0;">
                    <a href="<?= $baseUrl ?>/admin/profile" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.85rem;" title="My Profile & Password">
                        <?= SvgIcons::render('user', 'w-3 h-3', 14) ?> <span class="hide-mobile">Profile &amp; Security</span><span class="show-mobile">Profile</span>
                    </a>
                    <a href="<?= $baseUrl ?>/" target="_blank" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.85rem;">
                        <?= SvgIcons::render('external-link', 'w-3 h-3', 14) ?> <span class="hide-mobile">View Public Website</span><span class="show-mobile">Website</span>
                    </a>
                </div>
            </header>

            <main class="admin-body">
                <?php if (Session::hasFlash('success')): ?>
                    <div class="alert alert-success">
                        <?= Format::e(Session::getFlash('success')) ?>
                    </div>
                <?php endif; ?>

                <?php if (Session::hasFlash('error')): ?>
                    <div class="alert alert-error">
                        <?= Format::e(Session::getFlash('error')) ?>
                    </div>
                <?php endif; ?>

                <?= $content ?>
            </main>
        </div>
    </div>

    <script src="<?= $baseUrl ?>/assets/js/admin.js" defer></script>
</body>
</html>
