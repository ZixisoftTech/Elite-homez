<?php
use App\Helpers\Csrf;
use App\Helpers\Format;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$propId = $propertyContextId ?? null;
$propTitle = $propertyContextTitle ?? null;
$areaId = $areaContextId ?? null;
$source = $sourceContext ?? ($_SERVER['REQUEST_URI'] ?? 'Website');
?>
<form action="<?= $baseUrl ?>/enquire" method="POST" class="enquiry-box-form">
    <?= Csrf::field() ?>
    
    <!-- Hidden Context Parameters -->
    <input type="hidden" name="property_id" value="<?= Format::e($propId) ?>">
    <input type="hidden" name="area_id" value="<?= Format::e($areaId) ?>">
    <input type="hidden" name="source_page" value="<?= Format::e($source) ?>">
    <input type="hidden" name="return_url" value="<?= Format::e($_SERVER['REQUEST_URI'] ?? '/') ?>">

    <!-- Anti-spam Honeypot (must remain empty for human submission) -->
    <div class="honeypot-field" aria-hidden="true">
        <label for="website_url_check">Leave empty</label>
        <input type="text" name="website_url_check" id="website_url_check" tabindex="-1" autocomplete="off">
    </div>

    <?php if (!empty($propTitle)): ?>
        <div style="margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-light);">
            <span class="overline" style="margin-bottom: 0.25rem;">Property Inquired</span>
            <div style="font-family: var(--font-serif); font-size: 1.15rem; font-weight: 600; color: var(--navy-primary);">
                <?= Format::e($propTitle) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label class="form-label" for="client_name">Full Name *</label>
        <input type="text" name="name" id="client_name" class="form-control" placeholder="e.g. Vikramaditya Singhal" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="client_mobile">Mobile / WhatsApp Number *</label>
        <input type="tel" name="mobile" id="client_mobile" class="form-control" placeholder="+91 98110 00000" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="client_email">Email Address *</label>
        <input type="email" name="email" id="client_email" class="form-control" placeholder="advisory@domain.com" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="client_message">Inquiry / Requirements *</label>
        <textarea name="message" id="client_message" class="form-control" placeholder="Please detail your timeline, spatial requirements, or request a private site viewing." required><?= !empty($propTitle) ? "I would like to schedule a private consultation and viewing for " . Format::e($propTitle) . "." : "I am interested in prime residential opportunities." ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary" style="width: 100%;">
        Request Confidential Advisory
    </button>
    <p style="font-size: 0.75rem; color: var(--text-muted); text-align: center; margin-top: 0.85rem;">
        Your inquiry is treated with absolute discretion under non-disclosure standards.
    </p>
</form>
