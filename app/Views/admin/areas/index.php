<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>
<div class="admin-card">
    <div class="admin-card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy); margin: 0;">Prime Locations &amp; Enclaves</h2>
            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 0.25rem 0 0 0;">
                Manage South Delhi territories. Create, edit, toggle published status, and customize every section dynamically.
            </p>
        </div>
        <div>
            <a href="<?= $baseUrl ?>/admin/areas/create" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.6rem 1.1rem; font-weight: 600;">
                <?= SvgIcons::render('plus', 'w-4 h-4', 16) ?> Add New Location
            </a>
        </div>
    </div>

    <?php if (!empty($areas)): ?>
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Media</th>
                        <th>Location / Enclave</th>
                        <th>Public Endpoint</th>
                        <th>Properties</th>
                        <th style="text-align: center;">Order</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Home Feature</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($areas as $a): ?>
                        <?php 
                        $img = !empty($a['hero_image']) ? $a['hero_image'] : '/assets/images/areas/vasant-vihar.jpg';
                        $imgSrc = str_starts_with($img, 'http') ? $img : $baseUrl . '/' . ltrim($img, '/');
                        ?>
                        <tr>
                            <td>
                                <img src="<?= $imgSrc ?>" alt="<?= Format::e($a['name']) ?>" width="64" height="42" style="object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border); box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <strong style="color: var(--admin-navy); font-size: 0.95rem; font-weight: 600;"><?= Format::e($a['name']) ?></strong>
                                    <span style="font-size: 0.75rem; color: #B99A62; font-family: monospace; font-weight: 600;">
                                        <?= Format::e(!empty($a['hero_monograph_text']) ? $a['hero_monograph_text'] : ('Monograph ' . str_pad((string)$a['sort_order'], 2, '0', STR_PAD_LEFT))) ?>
                                    </span>
                                    <div style="font-size: 0.78rem; color: var(--admin-text-muted); max-width: 280px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; margin-top: 2px;">
                                        <?= Format::e($a['short_description'] ?? '') ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="<?= $baseUrl ?>/locations/<?= Format::e($a['slug']) ?>" target="_blank" style="font-family: monospace; font-size: 0.8rem; color: #2563EB; text-decoration: none;" title="Open live public URL">
                                    /locations/<?= Format::e($a['slug']) ?> &nearr;
                                </a>
                            </td>
                            <td>
                                <span class="badge" style="background: #EEF2F6; color: var(--admin-navy); font-weight: 600; padding: 0.3rem 0.6rem; border-radius: 4px;">
                                    <?= (int) ($a['property_count'] ?? 0) ?> Active
                                </span>
                            </td>
                            <td style="text-align: center; font-weight: 600; color: var(--admin-navy);">
                                <?= (int) $a['sort_order'] ?>
                            </td>
                            <td style="text-align: center;">
                                <form action="<?= $baseUrl ?>/admin/areas/toggle-status/<?= (int) $a['id'] ?>" method="POST" style="margin: 0; display: inline;">
                                    <?= Csrf::field() ?>
                                    <button type="submit" class="badge" title="Click to toggle active status" style="border: none; cursor: pointer; font-weight: 600; padding: 0.35rem 0.7rem; border-radius: 4px; transition: opacity 0.15s; background: <?= !empty($a['is_published']) ? '#DCFCE7' : '#FEE2E2' ?>; color: <?= !empty($a['is_published']) ? '#166534' : '#991B1B' ?>;">
                                        <?= !empty($a['is_published']) ? '● Published' : '○ Inactive (Draft)' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: center;">
                                <form action="<?= $baseUrl ?>/admin/areas/toggle-home/<?= (int) $a['id'] ?>" method="POST" style="margin: 0; display: inline;">
                                    <?= Csrf::field() ?>
                                    <button type="submit" class="badge" title="Click to toggle homepage display" style="border: none; cursor: pointer; font-weight: 600; padding: 0.35rem 0.7rem; border-radius: 4px; transition: opacity 0.15s; background: <?= !empty($a['show_on_home']) ? '#FEF3C7' : '#F1F5F9' ?>; color: <?= !empty($a['show_on_home']) ? '#92400E' : '#64748B' ?>;">
                                        <?= !empty($a['show_on_home']) ? '★ On Home' : 'Hidden' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 0.6rem;">
                                    <a href="<?= $baseUrl ?>/locations/<?= Format::e($a['slug']) ?>" target="_blank" title="View Public Location Page" style="color: var(--admin-text-muted); padding: 0.35rem; border-radius: 4px; border: 1px solid var(--admin-border); background: #fff;" class="hover:border-navy">
                                        <?= SvgIcons::render('eye', 'w-4 h-4', 16) ?>
                                    </a>
                                    <a href="<?= $baseUrl ?>/admin/areas/edit/<?= (int) $a['id'] ?>" title="Edit Location Content" style="color: var(--admin-navy); padding: 0.35rem; border-radius: 4px; border: 1px solid var(--admin-border); background: #fff;">
                                        <?= SvgIcons::render('edit', 'w-4 h-4', 16) ?>
                                    </a>
                                    <form action="<?= $baseUrl ?>/admin/areas/delete/<?= (int) $a['id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete <?= Format::e(addslashes($a['name'])) ?>?');" style="margin: 0; display: inline;">
                                        <?= Csrf::field() ?>
                                        <button type="submit" title="Delete Location" style="background: #fff; border: 1px solid #FECACA; border-radius: 4px; color: #EF4444; cursor: pointer; padding: 0.35rem; display: inline-flex; align-items: center;">
                                            <?= SvgIcons::render('trash', 'w-4 h-4', 16) ?>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 3rem 1rem; color: var(--admin-text-muted);">
            <p style="font-size: 1.1rem; margin-bottom: 1rem;">No locations created yet.</p>
            <a href="<?= $baseUrl ?>/admin/areas/create" class="btn btn-primary btn-sm">Add First Location</a>
        </div>
    <?php endif; ?>
</div>
