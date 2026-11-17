<?php
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

/** @var array $property */
$img = !empty($property['featured_image']) ? $property['featured_image'] : '/assets/images/hero/hero-main.jpg';
$isExternal = str_starts_with($img, 'http');
$imgSrc = $isExternal ? $img : $baseUrl . $img;
$detailUrl = $baseUrl . '/properties/' . Format::e($property['slug']);
$settings = $siteSettings ?? [];
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$waClean = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($waClean) === 10) {
    $waClean = '91' . $waClean;
}
$waText = urlencode('Hello Elite Homez, I would like to inquire about: ' . ($property['title'] ?? 'this property') . ' (Ref: ' . ($property['mandate_ref'] ?? 'EH') . ')');
?>
<article class="property-card">
    <div class="property-card-media">
        <a href="<?= $detailUrl ?>" tabindex="-1" aria-hidden="true" class="media-link">
            <img src="<?= $imgSrc ?>" alt="<?= Format::e($property['title']) ?>" loading="lazy" width="600" height="375" class="card-img">
        </a>
        <div class="property-badge-group">
            <span class="badge <?= $property['listing_type'] === 'rent' ? 'badge-rent' : 'badge-sale' ?>">
                <?= $property['listing_type'] === 'rent' ? 'FOR RENT' : 'FOR SALE' ?>
            </span>
            <?php if (!empty($property['is_featured'])): ?>
                <span class="badge badge-featured">FEATURED</span>
            <?php endif; ?>
        </div>
        <div class="property-media-gradient"></div>
        <div class="property-card-floating-price">
            <?= Format::e($property['price_display']) ?>
        </div>
    </div>

    <div class="property-card-body">
        <div class="property-location-line">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="loc-pin">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span><?= Format::e($property['area_name'] ?? ($property['property_location'] ?? 'South Delhi')) ?></span>
            <?php if (!empty($property['property_type'])): ?>
                <span class="type-pill">• <?= Format::e($property['property_type']) ?></span>
            <?php endif; ?>
        </div>

        <h3 class="property-card-title">
            <a href="<?= $detailUrl ?>">
                <?= Format::e($property['title']) ?>
            </a>
        </h3>

        <div class="property-specs-inline">
            <?php if (!empty($property['bedrooms'])): ?>
                <div class="spec-pill">
                    <strong><?= (int) $property['bedrooms'] ?></strong> Beds
                </div>
            <?php endif; ?>
            <?php if (!empty($property['bathrooms'])): ?>
                <div class="spec-pill">
                    <strong><?= (int) $property['bathrooms'] ?></strong> Baths
                </div>
            <?php endif; ?>
            <?php if (!empty($property['property_size'])): ?>
                <div class="spec-pill">
                    <?= Format::e($property['property_size']) ?>
                </div>
            <?php elseif (!empty($property['plot_size'])): ?>
                <div class="spec-pill">
                    <?= Format::e($property['plot_size']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="property-card-footer">
            <a href="<?= $detailUrl ?>" class="btn-card-details">
                <span>View Details</span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="https://wa.me/<?= $waClean ?>?text=<?= $waText ?>" target="_blank" rel="noopener noreferrer" class="btn-card-wa" title="Quick WhatsApp Enquiry">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            </a>
        </div>
    </div>
</article>
