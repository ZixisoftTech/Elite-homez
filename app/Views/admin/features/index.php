<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];

$iconsList = [
    'check-circle', 'waves', 'trees', 'sun', 'arrow-up-circle', 'car', 'zap', 'shield', 
    'video', 'activity', 'film', 'utensils', 'users', 'user-check', 'book-open', 
    'feather', 'maximize', 'wind', 'flame', 'droplet', 'cloud', 'cpu', 'lock', 
    'heart', 'move', 'grid', 'coffee', 'layout', 'repeat', 'battery-charging', 
    'archive', 'box', 'square', 'volume-x', 'chevrons-up', 'home', 'award', 'compass', 'wifi'
];
?>
<div class="admin-form-layout" style="grid-template-columns: minmax(0, 360px) minmax(0, 1fr);">
    <!-- Add New Feature Form -->
    <div class="admin-card">
        <h3 style="font-size: 1.15rem; font-weight: 600; color: var(--admin-navy); margin-bottom: 1.25rem;">
            Add Feature to Master Library
        </h3>
        <p style="font-size: 0.82rem; color: var(--admin-text-muted); margin-bottom: 1.5rem;">
            This library populates the checkboxes available when creating or editing property listings.
        </p>

        <form action="<?= $baseUrl ?>/admin/features/store" method="POST">
            <?= Csrf::field() ?>

            <div class="form-group">
                <label class="form-label" for="feat_name">Feature Name *</label>
                <input type="text" name="name" id="feat_name" class="form-control" placeholder="e.g. Temperature Controlled Wine Cellar" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="feat_icon">Assigned Vector Icon</label>
                <select name="icon" id="feat_icon" class="form-control">
                    <?php foreach ($iconsList as $ic): ?>
                        <option value="<?= $ic ?>"><?= ucfirst(str_replace('-', ' ', $ic)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="feat_sort">Display Sort Priority</label>
                <input type="number" name="sort_order" id="feat_sort" class="form-control" value="0">
            </div>

            <div class="form-group">
                <label class="form-label" for="feat_status">Status</label>
                <select name="status" id="feat_status" class="form-control">
                    <option value="active">Active (Available on listings)</option>
                    <option value="inactive">Inactive (Hidden)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">
                <?= SvgIcons::render('plus', 'w-4 h-4', 16) ?> Add to Master Library
            </button>
        </form>
    </div>

    <!-- Master Library Table -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3 style="font-size: 1.15rem; font-weight: 600; color: var(--admin-navy);">Master Library Items (<?= count($features) ?>)</h3>
                <p style="font-size: 0.82rem; color: var(--admin-text-muted);">Curated luxury residential features with consistent SVG icons.</p>
            </div>
        </div>

        <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Icon</th>
                        <th>Feature Name</th>
                        <th>Slug</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($features as $f): ?>
                        <tr>
                            <td style="color: var(--admin-gold);">
                                <?= SvgIcons::render($f['icon'] ?: 'check-circle', 'w-5 h-5', 20) ?>
                            </td>
                            <td>
                                <strong><?= Format::e($f['name']) ?></strong>
                            </td>
                            <td style="font-family: monospace; font-size: 0.8rem; color: var(--admin-text-muted);">
                                <?= Format::e($f['slug']) ?>
                            </td>
                            <td>
                                <?= (int) $f['sort_order'] ?>
                            </td>
                            <td>
                                <form action="<?= $baseUrl ?>/admin/features/toggle-status/<?= (int) $f['id'] ?>" method="POST" style="margin: 0;">
                                    <?= Csrf::field() ?>
                                    <button type="submit" class="badge" style="background: <?= $f['status'] === 'active' ? '#DCFCE7' : '#FEE2E2' ?>; color: <?= $f['status'] === 'active' ? '#166534' : '#991B1B' ?>; border: none; cursor: pointer;">
                                        <?= ucfirst(Format::e($f['status'])) ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                    <button type="button" 
                                            class="edit-feature-btn" 
                                            data-id="<?= (int) $f['id'] ?>"
                                            data-name="<?= Format::e($f['name']) ?>"
                                            data-icon="<?= Format::e($f['icon']) ?>"
                                            data-sort="<?= (int) $f['sort_order'] ?>"
                                            data-status="<?= Format::e($f['status']) ?>"
                                            title="Edit Feature" 
                                            style="background: none; border: none; color: var(--admin-navy); cursor: pointer; padding: 0.25rem;">
                                        <?= SvgIcons::render('edit', 'w-4 h-4', 16) ?>
                                    </button>
                                    <form action="<?= $baseUrl ?>/admin/features/delete/<?= (int) $f['id'] ?>" method="POST" class="delete-confirm-form" style="display: inline; margin: 0;">
                                        <?= Csrf::field() ?>
                                        <button type="submit" title="Delete Feature" style="background: none; border: none; color: #EF4444; cursor: pointer; padding: 0.25rem;">
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
    </div>
</div>

<!-- Edit Feature Modal -->
<div class="admin-modal-overlay" id="editFeatureModal">
    <div class="admin-modal-content">
        <form id="editFeatureForm" action="" method="POST">
            <?= Csrf::field() ?>
            <div class="admin-modal-header">
                <h3>Edit Feature Item</h3>
                <button type="button" class="admin-modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <div class="admin-modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_feat_name">Feature Name *</label>
                    <input type="text" name="name" id="edit_feat_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_feat_icon">Assigned Vector Icon</label>
                    <select name="icon" id="edit_feat_icon" class="form-control">
                        <?php foreach ($iconsList as $ic): ?>
                            <option value="<?= $ic ?>"><?= ucfirst(str_replace('-', ' ', $ic)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_feat_sort">Display Sort Priority</label>
                    <input type="number" name="sort_order" id="edit_feat_sort" class="form-control" value="0">
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_feat_status">Status</label>
                    <select name="status" id="edit_feat_status" class="form-control">
                        <option value="active">Active (Available on listings)</option>
                        <option value="inactive">Inactive (Hidden)</option>
                    </select>
                </div>
            </div>
            <div class="admin-modal-footer">
                <button type="button" class="btn btn-outline btn-sm" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('editFeatureModal');
    const form = document.getElementById('editFeatureForm');
    const nameInput = document.getElementById('edit_feat_name');
    const iconSelect = document.getElementById('edit_feat_icon');
    const sortInput = document.getElementById('edit_feat_sort');
    const statusSelect = document.getElementById('edit_feat_status');

    document.querySelectorAll('.edit-feature-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const icon = this.getAttribute('data-icon');
            const sort = this.getAttribute('data-sort');
            const status = this.getAttribute('data-status');

            form.action = '<?= $baseUrl ?>/admin/features/update/' + id;
            nameInput.value = name;
            iconSelect.value = icon;
            sortInput.value = sort;
            statusSelect.value = status;

            modal.classList.add('active');
        });
    });

    window.closeEditModal = function() {
        modal.classList.remove('active');
    };

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeEditModal();
        }
    });
});
</script>
