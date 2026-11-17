<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];

$statusList = ['all', 'new', 'contacted', 'qualified', 'closed', 'spam'];
$currentStatus = $currentStatus ?? '';
if (empty($currentStatus)) $currentStatus = 'all';
?>
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--admin-navy);">Client Lead Inbox</h2>
            <p style="font-size: 0.82rem; color: var(--admin-text-muted);">Inbound inquiries submitted through property pages and contact channels.</p>
        </div>
        
        <!-- Status Filter Tabs -->
        <div style="display: flex; gap: 0.4rem; background-color: #F1F5F9; padding: 0.25rem; border-radius: 4px;">
            <?php foreach ($statusList as $st): ?>
                <a href="<?= $baseUrl ?>/admin/enquiries<?= $st === 'all' ? '' : '?status=' . $st ?>" class="btn btn-sm <?= $currentStatus === $st ? 'btn-primary' : 'btn-outline' ?>" style="border: none; padding: 0.35rem 0.75rem; font-size: 0.75rem;">
                    <?= ucfirst($st) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!empty($enquiries)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 105px;">Ref ID</th>
                    <th>Client Legal Name</th>
                    <th>Contact Phone & Email</th>
                    <th>Interest Context</th>
                    <th>Message Excerpt</th>
                    <th>Status</th>
                    <th>Submission Timestamp</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enquiries as $e): 
                    $refId = '#EH-' . str_pad((string) $e['id'], 5, '0', STR_PAD_LEFT);
                ?>
                    <tr>
                        <td>
                            <a href="<?= $baseUrl ?>/admin/enquiries/show/<?= (int) $e['id'] ?>" title="View Mandate Dossier" style="display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; font-family: monospace; background: #243F34; color: #DFCF9F; letter-spacing: 0.04em; text-decoration: none;">
                                <?= $refId ?>
                            </a>
                        </td>
                        <td>
                            <strong style="color: var(--admin-navy); font-size: 0.95rem;"><?= Format::e($e['name']) ?></strong>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                <a href="tel:<?= preg_replace('/[^0-9\+]/', '', $e['mobile']) ?>" style="font-weight: 600; color: var(--admin-navy);">
                                    <?= Format::e($e['mobile']) ?>
                                </a>
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $e['mobile']) ?>" target="_blank" rel="noopener noreferrer" style="color: #16A34A;" title="WhatsApp Client">
                                    <?= SvgIcons::render('whatsapp', 'w-4 h-4', 16) ?>
                                </a>
                            </div>
                            <div style="font-size: 0.78rem; color: var(--admin-text-muted);">
                                <a href="mailto:<?= Format::e($e['email']) ?>"><?= Format::e($e['email']) ?></a>
                            </div>
                        </td>
                        <td>
                            <?php if (!empty($e['property_title'])): ?>
                                <a href="<?= $baseUrl ?>/properties/<?= Format::e($e['property_slug']) ?>" target="_blank" style="color: var(--admin-gold); font-weight: 500;">
                                    <?= Format::e($e['property_title']) ?>
                                </a>
                            <?php elseif (!empty($e['area_name'])): ?>
                                <span style="font-weight: 500;"><?= Format::e($e['area_name']) ?></span>
                            <?php else: ?>
                                <span style="color: var(--admin-text-muted);"><?= Format::e($e['source_page']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="max-width: 240px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; font-size: 0.82rem; color: var(--admin-text-muted);">
                            <?= Format::e($e['message']) ?>
                        </td>
                        <td>
                            <!-- Status Selector -->
                            <form action="<?= $baseUrl ?>/admin/enquiries/update-status/<?= (int) $e['id'] ?>" method="POST" style="margin: 0;">
                                <?= Csrf::field() ?>
                                <input type="hidden" name="return_url" value="<?= Format::e($_SERVER['REQUEST_URI'] ?? '/admin/enquiries') ?>">
                                <select name="status" onchange="this.form.submit()" style="padding: 0.3rem 0.5rem; font-size: 0.78rem; border-radius: 3px; border: 1px solid var(--admin-border); background: <?= $e['status'] === 'new' ? '#FEF08A' : ($e['status'] === 'qualified' ? '#DCFCE7' : '#FFFFFF') ?>;">
                                    <option value="new" <?= $e['status'] === 'new' ? 'selected' : '' ?>>New</option>
                                    <option value="contacted" <?= $e['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                                    <option value="qualified" <?= $e['status'] === 'qualified' ? 'selected' : '' ?>>Qualified</option>
                                    <option value="closed" <?= $e['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                                    <option value="spam" <?= $e['status'] === 'spam' ? 'selected' : '' ?>>Spam</option>
                                </select>
                            </form>
                        </td>
                        <td style="white-space: nowrap;">
                            <div style="font-size: 0.82rem; font-weight: 600; color: var(--admin-navy);">
                                <?= Format::date($e['created_at'], 'd M Y') ?>
                            </div>
                            <div style="font-size: 0.72rem; color: var(--admin-text-muted); font-family: monospace;">
                                <?= Format::date($e['created_at'], 'h:i A') ?> IST
                            </div>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                <a href="<?= $baseUrl ?>/admin/enquiries/show/<?= (int) $e['id'] ?>" title="View Inquiry Dossier" style="color: var(--admin-navy); padding: 0.25rem;">
                                    <?= SvgIcons::render('eye', 'w-4 h-4', 16) ?>
                                </a>
                                <form action="<?= $baseUrl ?>/admin/enquiries/delete/<?= (int) $e['id'] ?>" method="POST" class="delete-confirm-form" style="margin: 0; display: inline;">
                                    <?= Csrf::field() ?>
                                    <button type="submit" title="Delete Inquiry" style="background: none; border: none; color: #EF4444; cursor: pointer; padding: 0.25rem;">
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
        <p style="padding: 2.5rem 0; color: var(--admin-text-muted); text-align: center;">No client inquiries matching this filter.</p>
    <?php endif; ?>
</div>
