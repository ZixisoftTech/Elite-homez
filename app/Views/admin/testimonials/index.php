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
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--admin-navy);">Client Testimonials</h2>
            <p style="font-size: 0.82rem; color: var(--admin-text-muted);">Manage genuine client feedback and advisory reviews.</p>
        </div>
        <div>
            <a href="<?= $baseUrl ?>/admin/testimonials/create" class="btn btn-primary btn-sm">
                <?= SvgIcons::render('plus', 'w-4 h-4', 16) ?> Add Testimonial
            </a>
        </div>
    </div>

    <?php if (!empty($testimonials)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Designation</th>
                    <th>Rating</th>
                    <th>Excerpt</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testimonials as $t): ?>
                    <tr>
                        <td>
                            <strong style="color: var(--admin-navy);"><?= Format::e($t['client_name']) ?></strong>
                        </td>
                        <td style="color: var(--admin-text-muted);">
                            <?= Format::e($t['designation'] ?? 'Private Client') ?>
                        </td>
                        <td style="color: var(--admin-gold);">
                            <?php for ($i = 0; $i < (int) $t['rating']; $i++): ?>
                                <?= SvgIcons::render('star', 'w-3 h-3', 14) ?>
                            <?php endfor; ?>
                        </td>
                        <td style="max-width: 320px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; font-size: 0.82rem;">
                            <?= Format::e($t['testimonial']) ?>
                        </td>
                        <td>
                            <span class="badge" style="background: <?= !empty($t['status']) ? '#DCFCE7' : '#FEE2E2' ?>; color: <?= !empty($t['status']) ? '#166534' : '#991B1B' ?>;">
                                <?= !empty($t['status']) ? 'Published' : 'Draft' ?>
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                <a href="<?= $baseUrl ?>/admin/testimonials/edit/<?= (int) $t['id'] ?>" title="Edit" style="color: var(--admin-navy); padding: 0.25rem;">
                                    <?= SvgIcons::render('edit', 'w-4 h-4', 16) ?>
                                </a>
                                <form action="<?= $baseUrl ?>/admin/testimonials/delete/<?= (int) $t['id'] ?>" method="POST" class="delete-confirm-form" style="margin: 0; display: inline;">
                                    <?= Csrf::field() ?>
                                    <button type="submit" title="Delete" style="background: none; border: none; color: #EF4444; cursor: pointer; padding: 0.25rem;">
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
        <p style="padding: 2rem 0; color: var(--admin-text-muted);">No testimonials added yet.</p>
    <?php endif; ?>
</div>
