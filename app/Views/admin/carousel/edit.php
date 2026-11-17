<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];

$img = !empty($slide['image']) ? $slide['image'] : (!empty($slide['image_url']) ? $slide['image_url'] : '/assets/images/stitch/hero-residence.jpg');
$imgSrc = str_starts_with($img, 'http') ? $img : $baseUrl . '/' . ltrim($img, '/');

$eyebrowVal = $slide['eyebrow'] ?? $slide['badge'] ?? '';
$primaryBtnTextVal = $slide['primary_btn_text'] ?? $slide['btn_primary_text'] ?? 'Explore Properties';
$primaryBtnUrlVal = $slide['primary_btn_url'] ?? $slide['btn_primary_link'] ?? '/properties';
$secondaryBtnTextVal = $slide['secondary_btn_text'] ?? $slide['btn_secondary_text'] ?? 'Speak With an Advisor';
$secondaryBtnUrlVal = $slide['secondary_btn_url'] ?? $slide['btn_secondary_link'] ?? '/contact-us';
$trust1Val = $slide['trust_badge_1'] ?? 'RERA Certified Advisory';
$trust2Val = $slide['trust_badge_2'] ?? '100% Non-Disclosure Mandates';
$dossierEyebrowVal = $slide['dossier_eyebrow'] ?? 'Trophy Estate Dossier';
$dossierTitleVal = $slide['dossier_title'] ?? 'South Delhi Prime Enclaves';
$badgeTextVal = $slide['badge_text'] ?? 'Off-Market Mandate';
?>
<form action="<?= $baseUrl ?>/admin/carousel/update/<?= (int) $slide['id'] ?>" method="POST" enctype="multipart/form-data">
    <?= Csrf::field() ?>

    <div class="admin-page-header">
        <div>
            <a href="<?= $baseUrl ?>/admin/carousel" style="font-size: 0.85rem; color: var(--admin-text-muted); display: inline-flex; align-items: center; gap: 0.3rem;">
                &larr; Back to Hero Carousel Slides
            </a>
            <h1 style="font-size: 1.5rem; font-weight: 600; color: var(--admin-navy); margin-top: 0.25rem;">
                Edit Carousel Slide #<?= (int) $slide['id'] ?>
            </h1>
        </div>
        <div class="admin-header-actions">
            <a href="<?= $baseUrl ?>/admin/carousel" class="btn btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
        </div>
    </div>

    <div class="admin-form-layout">
        <!-- Left: Slide Content & Buttons -->
        <div class="admin-form-main">
            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--admin-navy);">Slide Typography & Headline</h3>

                <div class="form-group">
                    <label class="form-label" for="eyebrow">Overline Badge / Category</label>
                    <input type="text" name="eyebrow" id="eyebrow" class="form-control" value="<?= Format::e($eyebrowVal) ?>" placeholder="e.g. CONFIDENTIAL ADVISORY · PRIVATE MANDATES">
                    <small style="color: var(--admin-text-muted); font-size: 0.75rem;">Small gold badge shown above the main title.</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Headline / Slide Title *</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?= Format::e($slide['title']) ?>" placeholder="e.g. Unrivalled Luxury Residences In Delhi's Most Exclusive Enclaves" required>
                    <small style="color: var(--admin-text-muted); font-size: 0.75rem;">Tip: Use a period (e.g. "Headline Part 1. Second Accent Part") to create an elegant gold italicized second sentence.</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="subtitle">Subheading / Description</label>
                    <textarea name="subtitle" id="subtitle" class="form-control" rows="3" placeholder="Discreet advisory, bespoke estates, and private mandates across South Delhi."><?= Format::e($slide['subtitle']) ?></textarea>
                </div>
            </div>

            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--admin-navy);">Call to Action Buttons</h3>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="primary_btn_text">Primary Button Text</label>
                        <input type="text" name="primary_btn_text" id="primary_btn_text" class="form-control" value="<?= Format::e($primaryBtnTextVal) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="primary_btn_url">Primary Button URL</label>
                        <input type="text" name="primary_btn_url" id="primary_btn_url" class="form-control" value="<?= Format::e($primaryBtnUrlVal) ?>">
                    </div>
                </div>

                <div class="grid-2" style="margin-top: 0.5rem;">
                    <div class="form-group">
                        <label class="form-label" for="secondary_btn_text">Secondary Button Text</label>
                        <input type="text" name="secondary_btn_text" id="secondary_btn_text" class="form-control" value="<?= Format::e($secondaryBtnTextVal) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="secondary_btn_url">Secondary Button URL</label>
                        <input type="text" name="secondary_btn_url" id="secondary_btn_url" class="form-control" value="<?= Format::e($secondaryBtnUrlVal) ?>">
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--admin-navy);">Authentic Trust Pillars (Below CTA)</h3>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="trust_badge_1">Trust Pillar 1</label>
                        <input type="text" name="trust_badge_1" id="trust_badge_1" class="form-control" value="<?= Format::e($trust1Val) ?>" placeholder="e.g. RERA Certified Advisory">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="trust_badge_2">Trust Pillar 2</label>
                        <input type="text" name="trust_badge_2" id="trust_badge_2" class="form-control" value="<?= Format::e($trust2Val) ?>" placeholder="e.g. 100% Non-Disclosure Mandates">
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--admin-navy);">Image Floating Card & Mandate Badge</h3>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="dossier_eyebrow">Image Card Eyebrow</label>
                        <input type="text" name="dossier_eyebrow" id="dossier_eyebrow" class="form-control" value="<?= Format::e($dossierEyebrowVal) ?>" placeholder="e.g. Trophy Estate Dossier">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="dossier_title">Image Card Headline</label>
                        <input type="text" name="dossier_title" id="dossier_title" class="form-control" value="<?= Format::e($dossierTitleVal) ?>" placeholder="e.g. South Delhi Prime Enclaves">
                    </div>
                </div>
                <div class="form-group" style="margin-top: 0.5rem;">
                    <label class="form-label" for="badge_text">Floating Status Pill</label>
                    <input type="text" name="badge_text" id="badge_text" class="form-control" value="<?= Format::e($badgeTextVal) ?>" placeholder="e.g. Off-Market Mandate">
                    <small style="color: var(--admin-text-muted); font-size: 0.75rem;">Displayed alongside the shield icon on the lower edge of the hero frame.</small>
                </div>
            </div>
        </div>

        <!-- Right: Media & Visibility -->
        <div class="admin-form-sidebar">
            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--admin-navy);">Publishing & Order</h3>

                <div class="form-group">
                    <label class="checkbox-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" <?= !empty($slide['is_active']) ? 'checked' : '' ?>>
                        <span style="font-weight: 600; color: var(--admin-navy);">Active (Live on Hero Slider)</span>
                    </label>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label class="form-label" for="sort_order">Sequence Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?= (int) $slide['sort_order'] ?>">
                    <small style="color: var(--admin-text-muted); font-size: 0.75rem;">Lower numbers appear first (0, 1, 2, ...).</small>
                </div>
            </div>

            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--admin-navy);">Hero Architectural Image</h3>

                <div style="margin-bottom: 1rem; aspect-ratio: 16 / 10; border-radius: 4px; overflow: hidden; background: #0b1526; border: 1px solid var(--admin-border); position: relative;">
                    <img id="carouselPreviewImg" src="<?= $imgSrc ?>" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                <div class="form-group">
                    <label class="form-label" for="carouselFileInput">Replace Image (Upload)</label>
                    <input type="file" name="image" id="carouselFileInput" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif,image/avif">
                    <small style="color: var(--admin-text-muted); font-size: 0.75rem;">Upload new file to replace current image (Max 25MB).</small>
                </div>

                <div class="form-group" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--admin-border);">
                    <label class="form-label" for="carouselUrlInput">Or Direct Image Path / URL</label>
                    <input type="text" name="image_url" id="carouselUrlInput" class="form-control" value="<?= Format::e($img) ?>" placeholder="/assets/images/stitch/hero-residence.jpg">
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('carouselFileInput');
    const urlInput = document.getElementById('carouselUrlInput');
    const previewImg = document.getElementById('carouselPreviewImg');

    if (fileInput && previewImg) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    if (urlInput && previewImg) {
        urlInput.addEventListener('input', function() {
            const val = this.value.trim();
            if (val) {
                previewImg.src = val.startsWith('http') ? val : ('<?= $baseUrl ?>/' + val.replace(/^\//, ''));
            }
        });
    }
});
</script>
