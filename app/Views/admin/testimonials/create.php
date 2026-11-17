<?php
use App\Helpers\Csrf;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>
<div class="admin-card" style="max-width: 680px; margin: 0 auto;">
    <div class="admin-card-header">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--admin-navy);">Add Authentic Client Review</h2>
        </div>
        <div>
            <a href="<?= $baseUrl ?>/admin/testimonials" class="btn btn-outline btn-sm">Cancel</a>
        </div>
    </div>

    <form action="<?= $baseUrl ?>/admin/testimonials/store" method="POST" enctype="multipart/form-data">
        <?= Csrf::field() ?>

        <div class="form-group">
            <label class="form-label" for="client_name">Client Full Name *</label>
            <input type="text" name="client_name" id="client_name" class="form-control" placeholder="e.g. Vikramaditya Singhal" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="designation">Designation / Affiliation (optional)</label>
            <input type="text" name="designation" id="designation" class="form-control" placeholder="e.g. Managing Partner, Singhal Capital">
        </div>

        <div class="form-group">
            <label class="form-label" for="rating">Rating (Stars)</label>
            <select name="rating" id="rating" class="form-control">
                <option value="5" selected>5 Stars (Exceptional)</option>
                <option value="4">4 Stars</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="testimonial">Testimonial Text *</label>
            <textarea name="testimonial" id="testimonial" class="form-control" rows="5" placeholder="Authentic client feedback regarding property advisory..." required></textarea>
        </div>

        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Client / Residence Interior Photo</label>
            <div id="testimCreatePreviewWrap" style="display: none; width: 140px; height: 140px; border-radius: 4px; overflow: hidden; border: 1px solid var(--admin-border); background: #0b1526; margin-bottom: 0.75rem;">
                <img id="testimCreatePreviewImg" src="" alt="Client Photo Preview" style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <div class="form-group" style="margin-bottom: 0.5rem;">
                <label class="form-label" for="image">Upload Photo</label>
                <input type="file" name="image" id="testimCreateFileInput" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif,image/avif">
                <small class="form-text">Accepted formats: JPG, PNG, WebP, GIF, AVIF (Max 25MB).</small>
            </div>

            <div class="form-group" style="margin-top: 0.5rem;">
                <label class="form-label" for="image_url">Or Direct Image URL / Path</label>
                <input type="text" name="image_url" id="testimCreateUrlInput" class="form-control" placeholder="/assets/images/stitch/minimalist-salon.jpg">
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('testimCreateFileInput');
            const urlInput = document.getElementById('testimCreateUrlInput');
            const previewWrap = document.getElementById('testimCreatePreviewWrap');
            const previewImg = document.getElementById('testimCreatePreviewImg');

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
                <input type="checkbox" name="status" value="1" checked>
                <span style="font-weight: 600; color: var(--admin-navy);">Publish on Website</span>
            </label>
        </div>

        <div class="form-group">
            <label class="form-label" for="sort_order">Sort Priority</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">
            Save Testimonial
        </button>
    </form>
</div>
