<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];

$currentFilter = $currentFilter ?? 'all';
$counts = $counts ?? ['all' => count($properties ?? []), 'sale' => 0, 'rent' => 0, 'featured' => 0];
?>

<div class="admin-card">
    <div class="admin-page-header" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--admin-border);">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy); margin: 0 0 0.25rem 0;">Property Portfolio Management</h2>
            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 0;">Manage residences, select For Sale or For Rent, fill complete details, and tag properties to show in Featured Residences.</p>
        </div>
        <div>
            <a href="<?= $baseUrl ?>/admin/properties/create" class="btn btn-primary btn-sm">
                <?= SvgIcons::render('plus', 'w-4 h-4', 16) ?> Add New Property
            </a>
        </div>
    </div>

    <!-- Quick Filter Tabs (All / For Sale / For Rent / Featured) -->
    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.25rem; align-items: center; justify-content: space-between;">
        <div style="display: flex; flex-wrap: wrap; gap: 0.35rem;">
            <a href="<?= $baseUrl ?>/admin/properties?filter=all" 
               class="btn btn-sm <?= $currentFilter === 'all' ? 'btn-primary' : 'btn-outline' ?>" 
               style="border-radius: 9999px; font-size: 0.8rem; padding: 0.35rem 0.85rem;">
                All Listings (<?= sprintf('%02d', $counts['all']) ?>)
            </a>
            <a href="<?= $baseUrl ?>/admin/properties?filter=sale" 
               class="btn btn-sm <?= $currentFilter === 'sale' ? 'btn-primary' : 'btn-outline' ?>" 
               style="border-radius: 9999px; font-size: 0.8rem; padding: 0.35rem 0.85rem;">
                For Sale (<?= sprintf('%02d', $counts['sale']) ?>)
            </a>
            <a href="<?= $baseUrl ?>/admin/properties?filter=rent" 
               class="btn btn-sm <?= $currentFilter === 'rent' ? 'btn-primary' : 'btn-outline' ?>" 
               style="border-radius: 9999px; font-size: 0.8rem; padding: 0.35rem 0.85rem;">
                For Rent (<?= sprintf('%02d', $counts['rent']) ?>)
            </a>
            <a href="<?= $baseUrl ?>/admin/properties?filter=featured" 
               class="btn btn-sm <?= $currentFilter === 'featured' ? 'btn-primary' : 'btn-outline' ?>" 
               style="border-radius: 9999px; font-size: 0.8rem; padding: 0.35rem 0.85rem; <?= $currentFilter === 'featured' ? 'background: #B99A62; border-color: #B99A62;' : 'color: #92400E; border-color: #FCD34D;' ?>">
                ★ Featured Properties (<?= sprintf('%02d', $counts['featured']) ?>)
            </a>
        </div>

        <div style="font-size: 0.8rem; color: var(--admin-text-muted);">
            Showing <?= count($properties) ?> properties
        </div>
    </div>

    <?php if (!empty($properties)): ?>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Media</th>
                        <th>Property Title</th>
                        <th>Enclave & Address</th>
                        <th>Price Display</th>
                        <th>Transaction</th>
                        <th>Featured Tag</th>
                        <th>Status</th>
                        <th style="text-align: right; width: 110px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($properties as $p): ?>
                        <?php 
                        $img = !empty($p['featured_image']) ? $p['featured_image'] : '/assets/images/hero/hero-main.jpg';
                        $imgSrc = str_starts_with($img, 'http') ? $img : $baseUrl . $img;
                        $isRent = ($p['listing_type'] ?? '') === 'rent';
                        ?>
                        <tr>
                            <td>
                                <img src="<?= $imgSrc ?>" alt="<?= Format::e($p['title']) ?>" width="68" height="46" style="object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border); background: #171A18;">
                            </td>
                            <td>
                                <a href="<?= $baseUrl ?>/admin/properties/edit/<?= (int) $p['id'] ?>" style="color: var(--admin-navy); font-weight: 600; text-decoration: none; font-size: 0.95rem;" class="hover-underline">
                                    <?= Format::e($p['title']) ?>
                                </a>
                                <div style="font-size: 0.75rem; color: var(--admin-text-muted); display: flex; align-items: center; gap: 0.5rem; margin-top: 3px;">
                                    <span><?= ucfirst(Format::e($p['property_type'])) ?></span>
                                    <?php if (!empty($p['mandate_ref'])): ?>
                                        <span>·</span>
                                        <span style="font-family: monospace; font-weight: 600; color: var(--admin-navy);"><?= Format::e($p['mandate_ref']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 500; color: var(--admin-navy);"><?= Format::e($p['area_name']) ?></div>
                                <div style="font-size: 0.75rem; color: var(--admin-text-muted);"><?= Format::e($p['property_location']) ?></div>
                            </td>
                            <td style="font-weight: 600; color: var(--admin-navy); white-space: nowrap;">
                                <?= Format::e($p['price_display']) ?>
                            </td>
                            <td>
                                <span class="badge" style="background: <?= $isRent ? '#ECFDF5' : '#FEF3C7' ?>; color: <?= $isRent ? '#065F46' : '#92400E' ?>; border: 1px solid <?= $isRent ? '#A7F3D0' : '#FDE68A' ?>; font-weight: 600; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.05em;">
                                    <?= $isRent ? 'For Rent' : 'For Sale' ?>
                                </span>
                            </td>
                            <td>
                                <form action="<?= $baseUrl ?>/admin/properties/toggle-featured/<?= (int) $p['id'] ?>" method="POST" style="margin: 0;">
                                    <?= Csrf::field() ?>
                                    <button type="submit" class="badge" title="Click to toggle Featured Property status" style="border: 1px solid <?= !empty($p['is_featured']) ? '#F59E0B' : '#CBD5E1' ?>; cursor: pointer; font-weight: 600; background: <?= !empty($p['is_featured']) ? '#FEF3C7' : '#F8FAFC' ?>; color: <?= !empty($p['is_featured']) ? '#92400E' : '#64748B' ?>; display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 9999px;">
                                        <?= !empty($p['is_featured']) ? '★ Featured Property' : '☆ Standard Listing' ?>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="<?= $baseUrl ?>/admin/properties/toggle-status/<?= (int) $p['id'] ?>" method="POST" style="margin: 0;">
                                    <?= Csrf::field() ?>
                                    <button type="submit" style="border: none; cursor: pointer; background: transparent; padding: 0;" title="Click to toggle Active (Live) / Inactive (Draft)">
                                        <?php if ($p['status'] === 'published'): ?>
                                            <span class="badge" style="background: #DCFCE7; color: #166534; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; font-weight: 600;">
                                                <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #16a34a;"></span>
                                                Active (Live)
                                            </span>
                                        <?php else: ?>
                                            <span class="badge" style="background: #F1F5F9; color: #64748B; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; font-weight: 500;">
                                                <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #94A3B8;"></span>
                                                Inactive (Draft)
                                            </span>
                                        <?php endif; ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <div style="display: inline-flex; align-items: center; gap: 0.4rem;">
                                    <a href="<?= $baseUrl ?>/properties/<?= Format::e($p['slug']) ?>" target="_blank" title="View Public Page" class="btn btn-outline btn-sm" style="padding: 4px 6px;">
                                        <?= SvgIcons::render('eye', 'w-3 h-3', 14) ?>
                                    </a>
                                    <a href="<?= $baseUrl ?>/admin/properties/edit/<?= (int) $p['id'] ?>" title="Edit Property" class="btn btn-outline btn-sm" style="padding: 4px 6px;">
                                        <?= SvgIcons::render('edit', 'w-3 h-3', 14) ?>
                                    </a>
                                    <form action="<?= $baseUrl ?>/admin/properties/delete/<?= (int) $p['id'] ?>" method="POST" class="delete-confirm-form" style="margin: 0; display: inline;">
                                        <?= Csrf::field() ?>
                                        <button type="submit" title="Delete Property" class="btn btn-outline btn-sm" style="color: #EF4444; padding: 4px 6px;" onclick="return confirm('Are you sure you want to delete this property listing permanently?');">
                                            <?= SvgIcons::render('trash', 'w-3 h-3', 14) ?>
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
        <div style="padding: 3rem 0; text-align: center; color: var(--admin-text-muted);">
            <p style="font-size: 1.1rem; margin-bottom: 0.5rem; color: var(--admin-navy);">No properties found for this filter.</p>
            <p style="font-size: 0.85rem;">Try choosing "All Listings" or create a new property listing.</p>
            <a href="<?= $baseUrl ?>/admin/properties/create" class="btn btn-primary btn-sm" style="margin-top: 1rem;">
                + Add New Property
            </a>
        </div>
    <?php endif; ?>
</div>
