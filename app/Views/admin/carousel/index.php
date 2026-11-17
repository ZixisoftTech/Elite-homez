<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--admin-navy);">Hero Carousel Slides</h2>
            <p style="font-size: 0.82rem; color: var(--admin-text-muted);">Manage the homepage luxury hero slider slides, typography, background visuals, and action buttons.</p>
        </div>
        <div>
            <a href="<?= $baseUrl ?>/admin/carousel/create" class="btn btn-primary btn-sm">
                <?= SvgIcons::render('plus', 'w-4 h-4', 16) ?> Add New Slide
            </a>
        </div>
    </div>

    <?php if (!empty($slides)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Visual</th>
                    <th>Badge & Headline</th>
                    <th>Subheading</th>
                    <th>Buttons</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($slides as $slide): ?>
                    <?php
                    $img = !empty($slide['image']) ? $slide['image'] : (!empty($slide['image_url']) ? $slide['image_url'] : '/assets/images/stitch/hero-residence.jpg');
                    $imgSrc = str_starts_with($img, 'http') ? $img : $baseUrl . '/' . ltrim($img, '/');
                    $badgeVal = !empty($slide['eyebrow']) ? $slide['eyebrow'] : (!empty($slide['badge']) ? $slide['badge'] : '');
                    $pBtnText = !empty($slide['primary_btn_text']) ? $slide['primary_btn_text'] : (!empty($slide['btn_primary_text']) ? $slide['btn_primary_text'] : '');
                    $pBtnUrl = !empty($slide['primary_btn_url']) ? $slide['primary_btn_url'] : (!empty($slide['btn_primary_link']) ? $slide['btn_primary_link'] : '');
                    $sBtnText = !empty($slide['secondary_btn_text']) ? $slide['secondary_btn_text'] : (!empty($slide['btn_secondary_text']) ? $slide['btn_secondary_text'] : '');
                    $sBtnUrl = !empty($slide['secondary_btn_url']) ? $slide['secondary_btn_url'] : (!empty($slide['btn_secondary_link']) ? $slide['btn_secondary_link'] : '');
                    ?>
                    <tr>
                        <td>
                            <div style="width: 80px; height: 50px; border-radius: 3px; overflow: hidden; background: #000; border: 1px solid var(--admin-border);">
                                <img src="<?= $imgSrc ?>" alt="<?= Format::e($slide['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </td>
                        <td>
                            <?php if (!empty($badgeVal)): ?>
                                <span style="display: inline-block; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--admin-gold); margin-bottom: 2px;">
                                    <?= Format::e($badgeVal) ?>
                                </span>
                            <?php endif; ?>
                            <div style="color: var(--admin-navy); font-weight: 600; font-size: 0.95rem; max-width: 280px; line-height: 1.3;">
                                <?= Format::e($slide['title']) ?>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 0.8rem; color: var(--admin-text-muted); max-width: 260px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= Format::e($slide['subtitle']) ?>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 0.75rem;">
                                <?php if (!empty($pBtnText)): ?>
                                    <div style="font-weight: 600; color: var(--admin-navy);">
                                        1: <?= Format::e($pBtnText) ?> &rarr; <span style="font-family: monospace; color: var(--admin-text-muted);"><?= Format::e($pBtnUrl) ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($sBtnText)): ?>
                                    <div style="color: var(--admin-text-muted); margin-top: 2px;">
                                        2: <?= Format::e($sBtnText) ?> &rarr; <span style="font-family: monospace;"><?= Format::e($sBtnUrl) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: var(--admin-navy);"><?= (int) $slide['sort_order'] ?></span>
                        </td>
                        <td>
                            <form action="<?= $baseUrl ?>/admin/carousel/toggle-status/<?= (int) $slide['id'] ?>" method="POST" style="margin: 0; display: inline;">
                                <?= Csrf::field() ?>
                                <button type="submit" class="badge" title="Click to toggle Active / Inactive" style="border: none; cursor: pointer; background: <?= !empty($slide['is_active']) ? '#DCFCE7' : '#FEE2E2' ?>; color: <?= !empty($slide['is_active']) ? '#166534' : '#991B1B' ?>;">
                                    <?= !empty($slide['is_active']) ? 'Active (Live)' : 'Inactive' ?>
                                </button>
                            </form>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                <a href="<?= $baseUrl ?>/admin/carousel/edit/<?= (int) $slide['id'] ?>" title="Edit Slide" style="color: var(--admin-navy); padding: 0.25rem;">
                                    <?= SvgIcons::render('edit', 'w-4 h-4', 16) ?>
                                </a>
                                <form action="<?= $baseUrl ?>/admin/carousel/delete/<?= (int) $slide['id'] ?>" method="POST" class="delete-confirm-form" style="margin: 0; display: inline;">
                                    <?= Csrf::field() ?>
                                    <button type="submit" title="Delete Slide" style="background: none; border: none; color: #EF4444; cursor: pointer; padding: 0.25rem;">
                                        <?= SvgIcons::render('trash', 'w-4 h-4', 16) ?>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="padding: 2.5rem 0; text-align: center; color: var(--admin-text-muted);">
            No carousel slides found. Click "Add New Slide" above to create your first hero slide.
        </p>
    <?php endif; ?>
</div>
