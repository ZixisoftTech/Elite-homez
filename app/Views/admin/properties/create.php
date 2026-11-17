<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>

<form action="<?= $baseUrl ?>/admin/properties/store" method="POST" enctype="multipart/form-data">
    <?= Csrf::field() ?>

    <div class="admin-page-header">
        <div>
            <a href="<?= $baseUrl ?>/admin/properties" style="font-size: 0.85rem; color: var(--admin-text-muted); display: inline-flex; align-items: center; gap: 0.3rem;">
                &larr; Back to Properties
            </a>
            <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy); margin-top: 0.25rem;">Create New Luxury Property</h2>
            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 0;">Fill all property details, select whether it is For Sale or For Rent, and tag as Featured Property.</p>
        </div>
        <div class="admin-header-actions">
            <a href="<?= $baseUrl ?>/admin/properties" class="btn btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm">Save & Publish Listing</button>
        </div>
    </div>

    <div class="admin-form-layout">
        <!-- Main Form Column -->
        <div class="admin-form-main">
            <!-- 1. Transaction & Basic Particulars -->
            <div class="admin-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy); display: flex; align-items: center; justify-content: space-between;">
                    <span>1. Transaction Category & Core Particulars</span>
                    <span style="font-size: 0.75rem; font-weight: 500; color: var(--admin-text-muted);">* Mandatory fields</span>
                </h3>

                <!-- Prominent Dropdown for Sale vs Rent -->
                <div style="background: #FAF8F4; padding: 1.25rem; border: 1px solid var(--admin-border); border-radius: 6px; margin-bottom: 1.5rem;">
                    <div class="grid-2">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="listing_type" style="font-weight: 700; color: var(--admin-navy);">
                                Transaction Category (For Sale / For Rent) *
                            </label>
                            <select name="listing_type" id="listing_type" class="form-control" style="font-weight: 600; font-size: 0.95rem;" required>
                                <option value="sale" selected>● For Sale (Outright Acquisition / Buy)</option>
                                <option value="rent">● For Rent (Diplomatic & Luxury Lease)</option>
                            </select>
                            <small class="form-text" id="listing_type_hint">
                                Properties For Sale appear in the Buy collection and use total capital valuation.
                            </small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="area_id" style="font-weight: 700; color: var(--admin-navy);">
                                Prime Enclave / Area *
                            </label>
                            <select name="area_id" id="area_id" class="form-control" required>
                                <option value="">Select Enclave Location...</option>
                                <?php foreach ($areas as $a): ?>
                                    <option value="<?= (int) $a['id'] ?>"><?= Format::e($a['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text">Associates the listing with South Delhi territory monographs.</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Property Title *</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="e.g. The Diplomatic Boulevard Residence" required>
                    <small class="form-text">Primary editorial headline used across catalog cards and detail pages.</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="sub_title">Subtitle / Diplomatic Micro-Location</label>
                    <input type="text" name="sub_title" id="sub_title" class="form-control" placeholder="e.g. Block C, Diplomatic Enclave, Vasant Vihar, New Delhi">
                    <small class="form-text">Secondary editorial serif line displayed under the title.</small>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="property_type">Property Typology *</label>
                        <input type="text" name="property_type" id="property_type" class="form-control" placeholder="e.g. Independent Luxury Villa or Builder Floor" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="mandate_ref">Mandate Reference #</label>
                        <input type="text" name="mandate_ref" id="mandate_ref" class="form-control" placeholder="e.g. EH-VV-408">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="price">Price Numeric Value (INR) *</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="e.g. 185000000 for ₹18.5 Cr or 650000 for ₹6.5 Lakh/mo" required>
                        <small class="form-text">Numeric value in rupees (used for sorting and price indexing).</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="price_display">Formatted Display Price</label>
                        <input type="text" name="price_display" id="price_display" class="form-control" placeholder="e.g. ₹ 18.50 Cr or ₹ 6.50 Lakhs / mo">
                        <small class="form-text">Leave blank to auto-format from numeric price.</small>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="rera_number">RERA Registration No.</label>
                    <input type="text" name="rera_number" id="rera_number" class="form-control" value="DLRERA2023A00892" placeholder="DLRERA2023A00892">
                </div>
            </div>

            <!-- 2. Architectural Specifications -->
            <div class="admin-card" style="margin-top: 1.5rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">2. Architectural Specifications & Spatial Allocations</h3>

                <div class="grid-3">
                    <div class="form-group">
                        <label class="form-label" for="bedrooms">Bedrooms (BHK)</label>
                        <input type="number" name="bedrooms" id="bedrooms" class="form-control" placeholder="e.g. 4" min="0" value="4">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="bathrooms">Bathrooms</label>
                        <input type="number" name="bathrooms" id="bathrooms" class="form-control" placeholder="e.g. 5" min="0" value="5">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="parking_spaces">Car Parking Bays</label>
                        <input type="number" name="parking_spaces" id="parking_spaces" class="form-control" placeholder="e.g. 4" min="0" value="4">
                    </div>
                </div>

                <div class="grid-3">
                    <div class="form-group">
                        <label class="form-label" for="property_size">Built-up Size</label>
                        <input type="text" name="property_size" id="property_size" class="form-control" placeholder="e.g. 5,200 sq. ft.">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="plot_size">Plot Footprint / Parcel</label>
                        <input type="text" name="plot_size" id="plot_size" class="form-control" placeholder="e.g. 800 sq. yards">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="floor_info">Floor Placement</label>
                        <input type="text" name="floor_info" id="floor_info" class="form-control" placeholder="e.g. Ground Floor + Private Basement">
                    </div>
                </div>

                <div class="grid-3">
                    <div class="form-group">
                        <label class="form-label" for="orientation">Orientation & Vastu</label>
                        <input type="text" name="orientation" id="orientation" class="form-control" placeholder="e.g. North-East Facing · Vastu Certified">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="ceiling_height">Ceiling Clearance</label>
                        <input type="text" name="ceiling_height" id="ceiling_height" class="form-control" placeholder="e.g. 3.40m Clearance">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="architect_info">Architect & Completion</label>
                        <input type="text" name="architect_info" id="architect_info" class="form-control" placeholder="e.g. Studio Khosla Architects · 2023">
                    </div>
                </div>
            </div>

            <!-- 3. Location & Street Address -->
            <div class="admin-card" style="margin-top: 1.5rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">3. Location & Geolocation</h3>

                <div class="form-group">
                    <label class="form-label" for="property_location">Property Location / Street Address *</label>
                    <input type="text" name="property_location" id="property_location" class="form-control" placeholder="e.g. Poorvi Marg, Block A, Vasant Vihar, New Delhi" required>
                    <small class="form-text">Displayed on the property card badge and detail specifications.</small>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="coordinates">Geographic Coordinates</label>
                        <input type="text" name="coordinates" id="coordinates" class="form-control" placeholder="e.g. 28.5672° N, 77.1595° E">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="google_map_url">Google Maps Embed URL</label>
                        <input type="text" name="google_map_url" id="google_map_url" class="form-control" placeholder="https://maps.google.com/...">
                    </div>
                </div>
            </div>

            <!-- 4. Narrative Description & Quotes -->
            <div class="admin-card" style="margin-top: 1.5rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">4. Editorial Description & Quotes</h3>

                <div class="form-group">
                    <label class="form-label" for="description">Property Overview & Narrative *</label>
                    <textarea name="description" id="description" class="form-control" rows="8" placeholder="Detail the architectural craftsmanship, spatial layout, interior specifications, and prestigious appointments..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="provenance_quote">Architectural Provenance Quote (Featured in Gallery)</label>
                    <input type="text" name="provenance_quote" id="provenance_quote" class="form-control" placeholder='e.g. "Curated geometry paired with raw, tactile travertine creates an acoustic stillness unique to South Delhi\x27s diplomatic corridor."'>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="lifestyle_quote">Lifestyle Banner Quote (Full-bleed Break)</label>
                    <input type="text" name="lifestyle_quote" id="lifestyle_quote" class="form-control" placeholder='e.g. "An unyielding standard of residential distinction in South Delhi\x27s most coveted enclave."'>
                </div>
            </div>

            <!-- 5. Master Features & Amenities Checkboxes -->
            <div class="admin-card" style="margin-top: 1.5rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                    <div>
                        <h3 style="font-size: 1.1rem; color: var(--admin-navy); margin: 0;">5. Master Features & Amenities</h3>
                        <small style="color: var(--admin-text-muted);">Select the verified appointments present in this residence.</small>
                    </div>
                    <a href="<?= $baseUrl ?>/admin/features" target="_blank" style="font-size: 0.8rem; color: var(--admin-gold); font-weight: 500;">
                        Manage Master Library &rarr;
                    </a>
                </div>

                <div class="amenities-checkbox-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.75rem;">
                    <?php foreach ($features as $f): ?>
                        <label class="checkbox-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; background: #FAF8F4; padding: 0.5rem 0.75rem; border: 1px solid var(--admin-border); border-radius: 4px;">
                            <input type="checkbox" name="features[]" value="<?= (int) $f['id'] ?>" style="width: 16px; height: 16px; accent-color: var(--admin-navy);">
                            <span style="font-size: 0.85rem; font-weight: 500;"><?= Format::e($f['name']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Column: Featured Tag, Status, Photos & SEO -->
        <div class="admin-form-sidebar">
            <!-- Featured Property Tag Card (Requirement 4) -->
            <div class="admin-card" style="border: 2px solid #F59E0B; background: #FFFDF9;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 50%; background: #FEF3C7; color: #D97706; font-size: 14px; font-weight: 700;">★</span>
                    <h3 style="font-size: 1.05rem; font-weight: 700; color: #92400E; margin: 0;">Featured Property Tag</h3>
                </div>

                <div class="form-group" style="margin-bottom: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.65rem; cursor: pointer;">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" checked style="width: 20px; height: 20px; accent-color: #D97706;">
                        <span style="font-weight: 700; font-size: 0.95rem; color: #92400E;">Show in Featured Properties</span>
                    </label>
                </div>
                <small class="form-text" style="color: #78350F; line-height: 1.4; display: block; margin-top: 0.25rem;">
                    When checked, this property is highlighted with the gold <strong>FEATURED</strong> badge and displayed in the Featured Residences carousel on the homepage and portfolio.
                </small>
            </div>

            <!-- Publishing Controls -->
            <div class="admin-card" style="margin-top: 1.25rem;">
                <h3 style="font-size: 1.05rem; margin-bottom: 1rem; color: var(--admin-navy);">Publishing Visibility</h3>
                
                <div class="form-group">
                    <label class="form-label" for="status">Listing Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="published" selected>● Published (Live to Visitors)</option>
                        <option value="draft">○ Draft (Internal Only)</option>
                        <option value="archived">✕ Archived</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="sort_order">Catalogue Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="0" min="0">
                    <small class="form-text">Lower numbers appear first.</small>
                </div>
            </div>

            <!-- Primary Featured Image -->
            <div class="admin-card" style="margin-top: 1.25rem;">
                <h3 style="font-size: 1.05rem; margin-bottom: 1rem; color: var(--admin-navy);">Primary Featured Photo</h3>

                <div style="margin-bottom: 1rem; aspect-ratio: 16 / 10; border-radius: 4px; overflow: hidden; border: 1px solid var(--admin-border); background: #171A18;">
                    <img id="primary-photo-preview" src="<?= $baseUrl ?>/assets/images/hero/hero-main.jpg" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label" for="featured_image">Upload Primary Photo</label>
                    <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/jpeg,image/png,image/webp">
                    <small class="form-text">Recommended: 1920x1200px or 16:10 ratio.</small>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="featured_image_url">Or Image File Path / URL</label>
                    <input type="text" name="featured_image_url" id="featured_image_url" class="form-control" placeholder="/assets/images/stitch/hero-residence.jpg">
                </div>
            </div>

            <!-- Additional Gallery Photos -->
            <div class="admin-card" style="margin-top: 1.25rem;">
                <h3 style="font-size: 1.05rem; margin-bottom: 1rem; color: var(--admin-navy);">Additional Gallery Images</h3>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="gallery_images">Select Multi-File Photos</label>
                    <input type="file" name="gallery_images[]" id="gallery_images" class="form-control" multiple accept="image/jpeg,image/png,image/webp">
                    <small class="form-text">Upload multiple high-resolution photos for the curated gallery lightbox.</small>
                </div>
            </div>

            <!-- SEO & Meta Tags -->
            <div class="admin-card" style="margin-top: 1.25rem;">
                <h3 style="font-size: 1.05rem; margin-bottom: 1rem; color: var(--admin-navy);">SEO Metadata</h3>

                <div class="form-group">
                    <label class="form-label" for="seo_title">Meta Title</label>
                    <input type="text" name="seo_title" id="seo_title" class="form-control" placeholder="e.g. Ultra-Luxury Villa in Vasant Vihar | Elite Homez">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="meta_description">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="Discreet advisory briefing for this exceptional residential mandate..."></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div style="margin-top: 1.25rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.75rem; font-size: 0.95rem;">
                    Save & Publish Listing
                </button>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Live Featured Image Preview
    const featuredInput = document.getElementById('featured_image');
    const previewImg = document.getElementById('primary-photo-preview');
    if (featuredInput && previewImg) {
        featuredInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // 2. Dynamic Transaction Type hint & pricing formatting
    const listingType = document.getElementById('listing_type');
    const typeHint = document.getElementById('listing_type_hint');
    const priceDisplay = document.getElementById('price_display');
    const priceInput = document.getElementById('price');

    if (listingType && typeHint) {
        listingType.addEventListener('change', function() {
            if (this.value === 'rent') {
                typeHint.innerHTML = 'Properties <strong>For Rent</strong> appear under diplomatic luxury leases with monthly rental rates.';
                if (priceDisplay && !priceDisplay.value) {
                    priceDisplay.placeholder = 'e.g. ₹ 6.50 Lakhs / mo';
                }
            } else {
                typeHint.innerHTML = 'Properties <strong>For Sale</strong> appear in the Buy collection and use total capital valuation.';
                if (priceDisplay && !priceDisplay.value) {
                    priceDisplay.placeholder = 'e.g. ₹ 18.50 Cr';
                }
            }
        });
    }
});
</script>
