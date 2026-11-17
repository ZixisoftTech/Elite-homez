<?php
use App\Helpers\Csrf;
use App\Helpers\Format;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>
<div class="admin-card" style="max-width: 680px; margin: 0 auto;">
    <div class="admin-card-header">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--admin-navy);">Edit Testimonial</h2>
        </div>
        <div>
            <a href="<?= $baseUrl ?>/admin/testimonials" class="btn btn-outline btn-sm">Cancel</a>
        </div>
    </div>

    <form action="<?= $baseUrl ?>/admin/testimonials/update/<?= (int) $testimonial['id'] ?>" method="POST" enctype="multipart/form-data">
        <?= Csrf::field() ?>

        <div class="form-group">
            <label class="form-label" for="client_name">Client Full Name *</label>
            <input type="text" name="client_name" id="client_name" class="form-control" value="<?= Format::e($testimonial['client_name']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="designation">Designation / Affiliation</label>
            <input type="text" name="designation" id="designation" class="form-control" value="<?= Format::e($testimonial['designation']) ?>">
        </div>

        <div class="form-group">
            <label class="form-label" for="rating">Rating (Stars)</label>
            <select name="rating" id="rating" class="form-control">
                <option value="5" <?= (int) $testimonial['rating'] === 5 ? 'selected' : '' ?>>5 Stars</option>
                <option value="4" <?= (int) $testimonial['rating'] === 4 ? 'selected' : '' ?>>4 Stars</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="testimonial">Testimonial Text *</label>
            <textarea name="testimonial" id="testimonial" class="form-control" rows="5" required><?= Format::e($testimonial['testimonial']) ?></textarea>
        </div>

        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Client / Residence Photo</label>
            <?php 
            $currImg = !empty($testimonial['image_path']) ? $testimonial['image_path'] : '';
            $currImgSrc = !empty($currImg) ? (str_starts_with($currImg, 'http') ? $currImg : $baseUrl . '/' . ltrim($currImg, '/')) : '';
            ?>
            <div id="testimPreviewWrap" style="width: 140px; height: 140px; border-radius: 4px; overflow: hidden; border: 1px solid var(--admin-border); background: #0b1526; margin-bottom: 0.75rem; <?= empty($currImgSrc) ? 'display: none;' : '' ?>">
                <img id="testimPreviewImg" src="<?= Format::e($currImgSrc) ?>" alt="Client Photo" style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <div class="form-group" style="margin-bottom: 0.5rem;">
                <label class="form-label" for="image">Upload New Photo</label>
                <input type="file" name="image" id="testimFileInput" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif,image/avif">
                <small class="form-text">Accepted formats: JPG, PNG, WebP, GIF, AVIF (Max 25MB).</small>
            </div>

            <div class="form-group" style="margin-top: 0.5rem;">
                <label class="form-label" for="image_url">Or Direct Image URL / Path</label>
                <input type="text" name="image_url" id="testimUrlInput" class="form-control" value="<?= Format::e($currImg) ?>" placeholder="/assets/images/stitch/minimalist-salon.jpg">
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('testimFileInput');
            const urlInput = document.getElementById('testimUrlInput');
            const previewWrap = document.getElementById('testimPreviewWrap');
            const previewImg = document.getElementById('testimPreviewImg');

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            previewWrap.style.display = 'block';
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            if (urlInput) {
                urlInput.addEventListener('input', function() {
                    const val = this.value.trim();
                    if (val) {
                        previewImg.src = val.startsWith('http') ? val : ('<?= $baseUrl ?>/' + val.replace(/^\//, ''));
                        previewWrap.style.display = 'block';
                    }
                });
            }
        });
        </script>

        <div class="form-group">
            <label class="checkbox-label">
                <input type="checkbox" name="status" value="1" <?= !empty($testimonial['status']) ? 'checked' : '' ?>>
                <span style="font-weight: 600; color: var(--admin-navy);">Publish on Website</span>
            </label>
        </div>

        <div class="form-group">
            <label class="form-label" for="sort_order">Sort Priority</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?= (int) $testimonial['sort_order'] ?>">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">
            Save Changes
        </button>
    </form>
</div>
