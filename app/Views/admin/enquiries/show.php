<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];
$refId = '#EH-' . str_pad((string) $enquiry['id'], 5, '0', STR_PAD_LEFT);
?>
<div class="admin-card" style="max-width: 860px; margin: 0 auto;">
    <div class="admin-card-header" style="align-items: flex-start;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.25rem;">
                <span style="display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: 700; font-family: monospace; background: #243F34; color: #DFCF9F; letter-spacing: 0.05em;">
                    <?= $refId ?>
                </span>
                <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy); margin: 0;">Mandate Inquiry Dossier</h2>
            </div>
            <p style="font-size: 0.82rem; color: var(--admin-text-muted); margin: 0;">
                Submitted on <?= Format::date($enquiry['created_at'], 'l, d F Y \a\t h:i A') ?> IST
            </p>
        </div>
        <div>
            <a href="<?= $baseUrl ?>/admin/enquiries" class="btn btn-outline btn-sm">&larr; Back to Lead Inbox</a>
        </div>
    </div>

    <div class="grid-2" style="gap: 2rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--admin-border);">
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 600;">Client Name</div>
            <div style="font-size: 1.2rem; font-weight: 600; color: var(--admin-navy); margin-top: 0.25rem;"><?= Format::e($enquiry['name']) ?></div>
            
            <div style="margin-top: 1.25rem;">
                <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 600;">Direct Mobile</div>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 0.25rem;">
                    <a href="tel:<?= preg_replace('/[^0-9\+]/', '', $enquiry['mobile']) ?>" style="font-size: 1rem; font-weight: 600; color: var(--admin-navy);">
                        <?= Format::e($enquiry['mobile']) ?>
                    </a>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $enquiry['mobile']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp btn-sm" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;">
                        <?= SvgIcons::render('whatsapp', 'w-3 h-3', 14) ?> WhatsApp
                    </a>
                </div>
            </div>

            <div style="margin-top: 1.25rem;">
                <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 600;">Email Address</div>
                <div style="font-size: 0.95rem; margin-top: 0.25rem;">
                    <a href="mailto:<?= Format::e($enquiry['email']) ?>" style="color: var(--admin-gold); text-decoration: underline;"><?= Format::e($enquiry['email']) ?></a>
                </div>
            </div>
        </div>

        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 600;">Lead Workflow Status</div>
            <form action="<?= $baseUrl ?>/admin/enquiries/update-status/<?= (int) $enquiry['id'] ?>" method="POST" style="margin-top: 0.5rem;">
                <?= Csrf::field() ?>
                <select name="status" onchange="this.form.submit()" class="form-control" style="font-weight: 600;">
                    <option value="new" <?= $enquiry['status'] === 'new' ? 'selected' : '' ?>>New / Uncontacted</option>
                    <option value="contacted" <?= $enquiry['status'] === 'contacted' ? 'selected' : '' ?>>Contacted Advisor</option>
                    <option value="qualified" <?= $enquiry['status'] === 'qualified' ? 'selected' : '' ?>>Qualified Buyer</option>
                    <option value="closed" <?= $enquiry['status'] === 'closed' ? 'selected' : '' ?>>Closed / Transacted</option>
                    <option value="spam" <?= $enquiry['status'] === 'spam' ? 'selected' : '' ?>>Spam / Unsolicited</option>
                </select>
            </form>

            <div style="margin-top: 1.5rem;">
                <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 600;">Source Channel</div>
                <div style="font-size: 0.9rem; margin-top: 0.25rem; color: var(--admin-navy); font-weight: 500;">
                    <?= Format::e($enquiry['source_page']) ?>
                </div>
            </div>

            <div style="margin-top: 1.25rem;">
                <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 600;">Originating IP</div>
                <div style="font-size: 0.82rem; margin-top: 0.25rem; color: var(--admin-text-muted); font-family: monospace;">
                    <?= Format::e($enquiry['ip_address'] ?? 'N/A') ?>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div style="font-size: 0.8rem; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 600; margin-bottom: 0.75rem;">
            Inquiry Message
        </div>
        <div style="background-color: #F8FAFC; border: 1px solid var(--admin-border); padding: 1.5rem; border-radius: 4px; font-size: 1rem; line-height: 1.8; color: var(--admin-text);">
            <?= nl2br(Format::e($enquiry['message'])) ?>
        </div>
    </div>
</div>
