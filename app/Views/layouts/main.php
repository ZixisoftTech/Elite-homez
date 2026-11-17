<?php
use App\Core\View;
use App\Helpers\Format;
use App\Helpers\SeoHelper;
use App\Helpers\Session;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Dynamic SEO Tags & Schema.org JSON-LD -->
    <?= SeoHelper::renderTags($seo ?? []) ?>

    <!-- Preconnect & Google Fonts: Cinzel, Cormorant Garamond, Playfair Display, Manrope, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Manrope:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <!-- Tailwind CDN for Stitch Modern Utilities -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#243F34",
                        "primary-container": "#1B3128",
                        "primary-light": "#2E5244",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#EAE3D7",
                        "forest": "#243F34",
                        "forest-deep": "#1B3128",
                        "charcoal": "#171A18",
                        "charcoal-container": "#232724",
                        "ivory": "#F5F1E8",
                        "ivory-light": "#FAF8F4",
                        "beige": "#EAE3D7",
                        "gold": "#B99A62",
                        "gold-light": "#C9A86A",
                        "gold-dark": "#8C7343",
                        "secondary": "#4A504B",
                        "secondary-container": "#EAE3D7",
                        "on-secondary": "#ffffff",
                        "tertiary": "#B99A62",
                        "tertiary-container": "#B99A62",
                        "on-tertiary-container": "#171A18",
                        "tertiary-fixed": "#DFCF9F",
                        "tertiary-fixed-dim": "#B99A62",
                        "surface": "#F5F1E8",
                        "surface-bright": "#FAF8F4",
                        "surface-dim": "#EAE3D7",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#F2ECE0",
                        "surface-container": "#EAE3D7",
                        "surface-container-high": "#E2D9CC",
                        "surface-container-highest": "#D5CCBA",
                        "on-surface": "#171A18",
                        "on-surface-variant": "#4A504B",
                        "outline": "#B99A62",
                        "outline-variant": "#D8CDBA"
                    },
                    fontFamily: {
                        "headline-lg": ["Playfair Display", "serif"],
                        "headline-md": ["Playfair Display", "serif"],
                        "headline-sm": ["Playfair Display", "serif"],
                        "display-hero": ["Playfair Display", "serif"],
                        "serif": ["Playfair Display", "Cormorant Garamond", "serif"],
                        "body-lg": ["Plus Jakarta Sans", "Manrope", "sans-serif"],
                        "body-md": ["Plus Jakarta Sans", "Manrope", "sans-serif"],
                        "body-sm": ["Plus Jakarta Sans", "Manrope", "sans-serif"],
                        "sans": ["Plus Jakarta Sans", "Manrope", "sans-serif"],
                        "label-caps": ["Manrope", "sans-serif"],
                        "label-ui": ["Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        };
    </script>

    <!-- Design System CSS -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/main.css?v=<?= filemtime(dirname(__DIR__, 2) . '/public/assets/css/main.css') ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= $baseUrl ?>/assets/images/logo.png">
</head>
<body>
    <!-- Global Header -->
    <?php View::component('header'); ?>

    <!-- Flash Alerts -->
    <?php if (Session::hasFlash('success')): ?>
        <div class="site-container" style="margin-top: 1.5rem;">
            <div class="alert alert-success">
                <?= Format::e(Session::getFlash('success')) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (Session::hasFlash('error')): ?>
        <div class="site-container" style="margin-top: 1.5rem;">
            <div class="alert alert-error">
                <?= Format::e(Session::getFlash('error')) ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main View Content -->
    <main id="main-content">
        <?= $content ?>
    </main>

    <!-- Global Footer -->
    <?php View::component('footer'); ?>

    <!-- Sticky Direct WhatsApp Concierge Widget -->
    <?php View::component('whatsapp-sticky'); ?>

    <!-- Main Client Script -->
    <script src="<?= $baseUrl ?>/assets/js/main.js?v=<?= filemtime(dirname(__DIR__, 2) . '/public/assets/js/main.js') ?>" defer></script>
</body>
</html>
