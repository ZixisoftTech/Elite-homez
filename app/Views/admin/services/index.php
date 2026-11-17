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
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--admin-navy);">Advisory Services</h2>
            <p style="font-size: 0.82rem; color: var(--admin-text-muted);">Manage real estate advisory practices. Add, edit, delete, activate/deactivate, and customize full editorial sections.</p>
        </div>
        <div>
            <a href="<?= $baseUrl ?>/admin/services/create" class="btn btn-primary btn-sm">
                <?= SvgIcons::render('plus', 'w-4 h-4', 16) ?> Add Advisory Service
            </a>
        </div>
    </div>

    <?php if (!empty($services)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 70px;">Media</th>
                    <th>Practice Name</th>
                    <th>Slug URL</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Show on Home</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $s): ?>
                    <tr>
                        <td>
                            <?php 
                                $previewImg = !empty($s['image']) ? $s['image'] : '/assets/images/services/residential-advisory.jpg';
                                $imgSrc = str_starts_with($previewImg, 'http') ? $previewImg : $baseUrl . $previewImg;
                            ?>
                            <img src="<?= $imgSrc ?>" alt="<?= Format::e($s['name']) ?>" width="64" height="42" style="object-fit: cover; border-radius: 2px; border: 1px solid var(--admin-border);">
                        </td>
                        <td>
                            <strong style="color: var(--admin-navy); font-size: 0.95rem;"><?= Format::e($s['name']) ?></strong>
                            <div style="font-size: 0.75rem; color: var(--admin-text-muted); max-width: 320px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                <?= Format::e($s['short_description']) ?>
                            </div>
                        </td>
                        <td style="font-family: monospace; font-size: 0.8rem; color: var(--admin-text-muted);">
                            <a href="<?= $baseUrl ?>/services/<?= Format::e($s['slug']) ?>" target="_blank" style="color: inherit; text-decoration: underline;">
                                /services/<?= Format::e($s['slug']) ?>
                            </a>
                        </td>
                        <td>
                            <?= (int) $s['sort_order'] ?>
                        </td>
                        <td>
                            <form action="<?= $baseUrl ?>/admin/services/toggle-status/<?= (int) $s['id'] ?>" method="POST" style="margin: 0; display: inline;">
                                <?= Csrf::field() ?>
                                <button type="submit" class="badge" title="Click to toggle Active / Inactive" style="border: none; cursor: pointer; padding: 0.35rem 0.65rem; font-weight: 600; border-radius: 9999px; background: <?= !empty($s['is_published']) ? '#DCFCE7' : '#FEE2E2' ?>; color: <?= !empty($s['is_published']) ? '#166534' : '#991B1B' ?>;">
                                    <?= !empty($s['is_published']) ? '● Active' : '○ Inactive' ?>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="<?= $baseUrl ?>/admin/services/toggle-home/<?= (int) $s['id'] ?>" method="POST" style="margin: 0; display: inline;">
                                <?= Csrf::field() ?>
                                <button type="submit" class="badge" title="Click to toggle homepage display" style="border: none; cursor: pointer; padding: 0.35rem 0.65rem; font-weight: 600; border-radius: 9999px; background: <?= !empty($s['show_on_home']) ? '#FEF3C7' : '#F1F5F9' ?>; color: <?= !empty($s['show_on_home']) ? '#92400E' : '#64748B' ?>;">
                                    <?= !empty($s['show_on_home']) ? '★ On Home' : 'Hidden' ?>
                                </button>
                            </form>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                <a href="<?= $baseUrl ?>/services/<?= Format::e($s['slug']) ?>" target="_blank" title="View Public Page" style="color: var(--admin-text-muted); padding: 0.35rem; border-radius: 4px; border: 1px solid var(--admin-border);">
                                    <?= SvgIcons::render('eye', 'w-4 h-4', 16) ?>
                                </a>
                                <a href="<?= $baseUrl ?>/admin/services/edit/<?= (int) $s['id'] ?>" title="Edit Service" class="btn btn-outline btn-sm" style="padding: 0.25rem 0.5rem; font-size: 0.78rem;">
                                    <?= SvgIcons::render('edit', 'w-3 h-3', 14) ?> Edit
                                </a>
                                <form action="<?= $baseUrl ?>/admin/services/delete/<?= (int) $s['id'] ?>" method="POST" class="delete-confirm-form" onsubmit="return confirm('Are you sure you want to delete \'<?= addslashes(Format::e($s['name'])) ?>\'? This action cannot be undone.');" style="margin: 0; display: inline;">
                                    <?= Csrf::field() ?>
                                    <button type="submit" title="Delete Service" style="background: none; border: 1px solid #FECACA; color: #EF4444; cursor: pointer; padding: 0.35rem; border-radius: 4px; display: inline-flex; align-items: center;">
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
        <p style="padding: 2rem 0; color: var(--admin-text-muted);">No services created yet.</p>
    <?php endif; ?>
</div>
