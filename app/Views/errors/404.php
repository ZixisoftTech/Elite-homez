<?php
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>
<section class="section-padding" style="background-color: var(--bg-surface); min-height: 65vh; display: flex; align-items: center;">
    <div class="site-container" style="text-align: center; max-width: 640px; margin: 0 auto;">
        <span class="overline">404 Exception</span>
        <h1 class="heading-section" style="font-size: clamp(2.2rem, 3.5vw, 3.2rem); margin-bottom: 1rem;">
            Property or Page Not Located
        </h1>
        <p style="font-size: 1.05rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 2.5rem;">
            The luxury residence or advisory page you requested may have been acquired, relocated, or temporarily withdrawn from private presentation.
        </p>

        <div style="display: flex; align-items: center; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
            <a href="<?= $baseUrl ?>/" class="btn btn-outline">
                <?= SvgIcons::render('arrow-right', 'w-4 h-4', 16) ?> Return to Home
            </a>
            <a href="<?= $baseUrl ?>/properties" class="btn btn-primary">
                Explore Prime Properties
            </a>
        </div>
    </div>
</section>
