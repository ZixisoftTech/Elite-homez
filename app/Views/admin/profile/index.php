<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>

<div class="admin-page-header">
    <div>
        <div style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--admin-gold); font-weight: 600; margin-bottom: 0.25rem;">
            Account Credentials &amp; Access Security
        </div>
        <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy);">Administrator Profile &amp; Security</h2>
        <p style="font-size: 0.85rem; color: var(--admin-text-muted);">Manage your administrative identity, email address, and account password.</p>
    </div>
</div>

<div class="grid-2" style="align-items: start; gap: 1.5rem;">
    <!-- LEFT CARD: PROFILE INFORMATION -->
    <div class="admin-card">
        <div style="display: flex; align-items: center; gap: 1rem; padding-bottom: 1.25rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--admin-border);">
            <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--admin-navy); color: var(--admin-gold); display: flex; align-items: center; justify-content: center; font-size: 1.35rem; font-weight: 700; border: 2px solid var(--admin-gold);">
                <?= strtoupper(substr($admin['name'] ?? 'A', 0, 1)) ?>
            </div>
            <div>
                <h3 style="font-size: 1.1rem; color: var(--admin-navy); margin: 0;"><?= Format::e($admin['name']) ?></h3>
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                    <span style="display: inline-block; background: rgba(183, 154, 60, 0.15); color: #8C7343; font-size: 0.72rem; font-weight: 700; padding: 0.15rem 0.55rem; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?= Format::e($admin['role'] ?? 'admin') ?>
                    </span>
                    <span style="font-size: 0.8rem; color: var(--admin-text-muted);">
                        • ID #<?= (int)$admin['id'] ?>
                    </span>
                </div>
            </div>
        </div>

        <form action="<?= $baseUrl ?>/admin/profile/update" method="POST">
            <?= Csrf::field() ?>

            <div class="form-group">
                <label class="form-label" for="admin_name">
                    Full Name <span class="req">*</span>
                </label>
                <input type="text" name="name" id="admin_name" class="form-control" value="<?= Format::e($admin['name']) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="admin_email">
                    Login Email Address <span class="req">*</span>
                </label>
                <input type="email" name="email" id="admin_email" class="form-control" value="<?= Format::e($admin['email']) ?>" required>
                <small style="color: var(--admin-text-muted); font-size: 0.78rem; display: block; margin-top: 0.35rem;">
                    This email is used to log in to the Elite Homez Command Center.
                </small>
            </div>

            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 4px; padding: 0.85rem 1rem; margin-bottom: 1.25rem; font-size: 0.8rem; color: #475569;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                    <strong style="color: #1E293B;">Last Login:</strong>
                    <span><?= !empty($admin['last_login_at']) ? Format::date($admin['last_login_at']) : 'Current Session' ?></span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <strong style="color: #1E293B;">Account Created:</strong>
                    <span><?= Format::date($admin['created_at']) ?></span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.45rem;">
                <?= SvgIcons::render('check', 'w-4 h-4', 16) ?>
                <span>Save Profile Changes</span>
            </button>
        </form>
    </div>

    <!-- RIGHT CARD: CHANGE PASSWORD -->
    <div class="admin-card" style="border-top: 3px solid var(--admin-gold);">
        <div style="display: flex; align-items: center; gap: 0.75rem; padding-bottom: 1rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--admin-border);">
            <div style="width: 36px; height: 36px; border-radius: 4px; background: rgba(10, 35, 65, 0.08); color: var(--admin-navy); display: flex; align-items: center; justify-content: center;">
                <?= SvgIcons::render('lock', 'w-5 h-5', 20) ?>
            </div>
            <div>
                <h3 style="font-size: 1.1rem; color: var(--admin-navy); margin: 0;">Change Account Password</h3>
                <div style="font-size: 0.8rem; color: var(--admin-text-muted);">Update your security credentials to protect the platform.</div>
            </div>
        </div>

        <form action="<?= $baseUrl ?>/admin/profile/password" method="POST">
            <?= Csrf::field() ?>

            <div class="form-group">
                <label class="form-label" for="current_password">
                    Current Password <span class="req">*</span>
                </label>
                <div style="position: relative;">
                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter your current password" required autocomplete="current-password">
                    <button type="button" class="btn-toggle-pw" onclick="togglePasswordVisibility('current_password', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94A3B8; padding: 4px;" title="Show/Hide Password">
                        <?= SvgIcons::render('eye', 'w-4 h-4', 16) ?>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="new_password">
                    New Password <span class="req">*</span>
                </label>
                <div style="position: relative;">
                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Minimum 8 characters" required minlength="8" autocomplete="new-password">
                    <button type="button" class="btn-toggle-pw" onclick="togglePasswordVisibility('new_password', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94A3B8; padding: 4px;" title="Show/Hide Password">
                        <?= SvgIcons::render('eye', 'w-4 h-4', 16) ?>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="confirm_password">
                    Confirm New Password <span class="req">*</span>
                </label>
                <div style="position: relative;">
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Re-type your new password" required minlength="8" autocomplete="new-password">
                    <button type="button" class="btn-toggle-pw" onclick="togglePasswordVisibility('confirm_password', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94A3B8; padding: 4px;" title="Show/Hide Password">
                        <?= SvgIcons::render('eye', 'w-4 h-4', 16) ?>
                    </button>
                </div>
            </div>

            <div style="background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 4px; padding: 0.75rem 0.95rem; margin-bottom: 1.25rem; font-size: 0.78rem; color: #92400E;">
                <div style="font-weight: 600; margin-bottom: 0.2rem;">Password Guidelines:</div>
                <ul style="margin: 0; padding-left: 1.15rem; line-height: 1.5;">
                    <li>Minimum length: 8 characters</li>
                    <li>Recommend using a combination of uppercase, lowercase, numbers, and special symbols (e.g. <code>Admin@112233</code>)</li>
                    <li>Never share administrative credentials over unsecured channels</li>
                </ul>
            </div>

            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.45rem; background-color: var(--admin-gold);">
                <?= SvgIcons::render('key', 'w-4 h-4', 16) ?>
                <span>Update Password</span>
            </button>
        </form>
    </div>
</div>

<script>
function togglePasswordVisibility(fieldId, btn) {
    const input = document.getElementById(fieldId);
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        btn.style.color = '#B79A3C';
    } else {
        input.type = 'password';
        btn.style.color = '#94A3B8';
    }
}
</script>
