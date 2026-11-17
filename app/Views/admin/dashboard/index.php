<?php
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>
<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon">
            <?= SvgIcons::render('home', 'w-6 h-6', 26) ?>
        </div>
        <div>
            <div class="metric-value"><?= (int) $stats['total_properties'] ?></div>
            <div class="metric-label">Total Properties</div>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-icon" style="background-color: #EBFBEE; color: #16A34A;">
            <?= SvgIcons::render('mail', 'w-6 h-6', 26) ?>
        </div>
        <div>
            <div class="metric-value"><?= (int) $stats['new_enquiries'] ?></div>
            <div class="metric-label">New Leads Pending</div>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-icon">
            <?= SvgIcons::render('map-pin', 'w-6 h-6', 26) ?>
        </div>
        <div>
            <div class="metric-value"><?= (int) $stats['total_areas'] ?></div>
            <div class="metric-label">Areas of Expertise</div>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-icon">
            <?= SvgIcons::render('check-square', 'w-6 h-6', 26) ?>
        </div>
        <div>
            <div class="metric-value"><?= (int) $stats['total_features'] ?></div>
            <div class="metric-label">Master Amenities</div>
        </div>
    </div>
</div>

<div class="admin-form-layout">
    <!-- Recent Enquiries -->
    <div class="admin-form-main">
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 style="font-size: 1.15rem; font-weight: 600; color: var(--admin-navy);">Recent Client Inquiries</h2>
                <a href="<?= $baseUrl ?>/admin/enquiries" style="font-size: 0.8rem; color: var(--admin-gold); font-weight: 600;">
                    View Lead Inbox &rarr;
                </a>
            </div>

            <?php if (!empty($recentEnquiries)): ?>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 100px;">Ref ID</th>
                                <th>Client Legal Name</th>
                                <th>Contact Details</th>
                                <th>Interest Context</th>
                                <th>Status</th>
                                <th>Submission Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentEnquiries as $enq): 
                                $refId = '#EH-' . str_pad((string) $enq['id'], 5, '0', STR_PAD_LEFT);
                            ?>
                                <tr>
                                    <td>
                                        <a href="<?= $baseUrl ?>/admin/enquiries/show/<?= (int) $enq['id'] ?>" style="display: inline-block; padding: 2px 7px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; font-family: monospace; background: #243F34; color: #DFCF9F; text-decoration: none;">
                                            <?= $refId ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= $baseUrl ?>/admin/enquiries/show/<?= (int) $enq['id'] ?>" style="font-weight: 600; color: var(--admin-navy); text-decoration: none;">
                                            <?= Format::e($enq['name']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <div><?= Format::e($enq['mobile']) ?></div>
                                        <div style="font-size: 0.78rem; color: var(--admin-text-muted);"><?= Format::e($enq['email']) ?></div>
                                    </td>
                                    <td>
                                        <?php if (!empty($enq['property_title'])): ?>
                                            <span style="color: var(--admin-navy); font-weight: 500;"><?= Format::e($enq['property_title']) ?></span>
                                        <?php elseif (!empty($enq['area_name'])): ?>
                                            <span><?= Format::e($enq['area_name']) ?></span>
                                        <?php else: ?>
                                            <span style="color: var(--admin-text-muted);"><?= Format::e($enq['source_page']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: <?= $enq['status'] === 'new' ? '#FEF08A' : '#E2E8F0' ?>; color: #1E293B;">
                                            <?= ucfirst(Format::e($enq['status'])) ?>
                                        </span>
                                    </td>
                                    <td style="white-space: nowrap;">
                                        <div style="font-size: 0.8rem; font-weight: 600; color: var(--admin-navy);">
                                            <?= Format::date($enq['created_at'], 'd M Y') ?>
                                        </div>
                                        <div style="font-size: 0.72rem; color: var(--admin-text-muted); font-family: monospace;">
                                            <?= Format::date($enq['created_at'], 'h:i A') ?> IST
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="color: var(--admin-text-muted); padding: 1.5rem 0;">No inquiries received yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Shortcuts -->
    <div class="admin-form-sidebar">
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 style="font-size: 1.15rem; font-weight: 600; color: var(--admin-navy);">Quick Management Actions</h2>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="<?= $baseUrl ?>/admin/properties/create" class="btn btn-primary" style="justify-content: flex-start;">
                    <?= SvgIcons::render('plus', 'w-4 h-4', 16) ?> Add Luxury Property
                </a>
            <a href="<?= $baseUrl ?>/admin/features" class="btn btn-outline" style="justify-content: flex-start;">
                <?= SvgIcons::render('check-square', 'w-4 h-4', 16) ?> Master Amenities Library
            </a>
            <a href="<?= $baseUrl ?>/admin/areas" class="btn btn-outline" style="justify-content: flex-start;">
                <?= SvgIcons::render('map-pin', 'w-4 h-4', 16) ?> Areas of Expertise
            </a>
            <a href="<?= $baseUrl ?>/admin/services" class="btn btn-outline" style="justify-content: flex-start;">
                <?= SvgIcons::render('compass', 'w-4 h-4', 16) ?> Advisory Services
            </a>
            <a href="<?= $baseUrl ?>/admin/settings" class="btn btn-outline" style="justify-content: flex-start;">
                <?= SvgIcons::render('archive', 'w-4 h-4', 16) ?> System & Brand Settings
            </a>
        </div>
    </div>
</div>
