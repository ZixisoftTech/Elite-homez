<?php
use App\Helpers\Csrf;
use App\Helpers\Format;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>
<form action="<?= $baseUrl ?>/admin/settings/update" method="POST">
    <?= Csrf::field() ?>

    <div class="admin-page-header">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy);">System & Brand Settings</h2>
            <p style="font-size: 0.85rem; color: var(--admin-text-muted);">Manage brand credentials, WhatsApp lines, advisory contacts, and SEO defaults.</p>
        </div>
        <div class="admin-header-actions">
            <button type="submit" class="btn btn-primary btn-sm">Save All Settings</button>
        </div>
    </div>

    <div class="grid-2" style="align-items: start;">
        <!-- Left Col: Brand & Contact -->
        <div>
            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Brand Identity</h3>

                <div class="form-group">
                    <label class="form-label" for="site_name">Firm / Brand Name</label>
                    <input type="text" name="site_name" id="site_name" class="form-control" value="<?= Format::e($settings['site_name'] ?? 'Elite Homez') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="site_tagline">Official Tagline</label>
                    <input type="text" name="site_tagline" id="site_tagline" class="form-control" value="<?= Format::e($settings['site_tagline'] ?? 'your trust, our responsibility.') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="experience_years">Years of Experience Claim</label>
                    <input type="text" name="experience_years" id="experience_years" class="form-control" value="<?= Format::e($settings['experience_years'] ?? '20+') ?>">
                </div>
            </div>

            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Direct Advisory Contact Numbers</h3>

                <div class="form-group">
                    <label class="form-label" for="phone_primary">Primary Telephone Line</label>
                    <input type="text" name="phone_primary" id="phone_primary" class="form-control" value="<?= Format::e($settings['phone_primary'] ?? '+91 9811044200') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone_secondary">Secondary Telephone Line</label>
                    <input type="text" name="phone_secondary" id="phone_secondary" class="form-control" value="<?= Format::e($settings['phone_secondary'] ?? '+91 98112 88400') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="whatsapp_number">WhatsApp Number (International format without symbols)</label>
                    <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control" value="<?= Format::e($settings['whatsapp_number'] ?? '9811044200') ?>" placeholder="9811044200">
                </div>

                <div class="form-group">
                    <label class="form-label" for="whatsapp_display">WhatsApp Display String</label>
                    <input type="text" name="whatsapp_display" id="whatsapp_display" class="form-control" value="<?= Format::e($settings['whatsapp_display'] ?? '+91 98110 44200') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email_primary">Primary Advisory Email</label>
                    <input type="email" name="email_primary" id="email_primary" class="form-control" value="<?= Format::e($settings['email_primary'] ?? 'info@elitehomez.com') ?>">
                </div>
            </div>
        </div>

        <!-- Right Col: Physical Office & SEO -->
        <div>
            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Physical Presence & Maps</h3>

                <div class="form-group">
                    <label class="form-label" for="office_address">Office Address</label>
                    <textarea name="office_address" id="office_address" class="form-control" rows="3"><?= Format::e($settings['office_address'] ?? '225, 2nd Floor, Square One Mall, Saket, New Delhi - 110017 (India)') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="google_maps_url">Google Map Embed / Coordinates URL</label>
                    <input type="url" name="google_maps_url" id="google_maps_url" class="form-control" value="<?= Format::e($settings['google_maps_url'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="footer_brand_text">Footer Narrative Description</label>
                    <textarea name="footer_brand_text" id="footer_brand_text" class="form-control" rows="4"><?= Format::e($settings['footer_brand_text'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Default SEO Snippets</h3>

                <div class="form-group">
                    <label class="form-label" for="default_seo_title">Default Meta Title</label>
                    <input type="text" name="default_seo_title" id="default_seo_title" class="form-control" value="<?= Format::e($settings['default_seo_title'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="default_meta_description">Default Meta Description</label>
                    <textarea name="default_meta_description" id="default_meta_description" class="form-control" rows="4"><?= Format::e($settings['default_meta_description'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>
