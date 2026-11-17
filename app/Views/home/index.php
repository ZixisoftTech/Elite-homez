<?php
use App\Core\View;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$stitchImg = $baseUrl . '/assets/images/stitch';
$settings = $siteSettings ?? [];
$home = $home ?? [];
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$waClean = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($waClean) === 10) {
    $waClean = '91' . $waClean;
}
?>

<?php
$slides = !empty($carouselSlides) ? $carouselSlides : [
    [
        'id' => 1,
        'eyebrow' => $home['home_hero_default_eyebrow'] ?? 'PRIVATE LUXURY ADVISORY · SOUTH DELHI',
        'title' => $home['home_hero_default_title'] ?? 'Discover a More Exclusive<br><span class="hero-gold-italic">Way to Live.</span>',
        'subtitle' => $home['home_hero_default_subtitle'] ?? 'Exceptional homes. Prestigious addresses. Personalised real estate expertise across South Delhi.',
        'image_url' => $stitchImg . '/hero-residence.jpg',
        'primary_btn_text' => $home['home_hero_default_btn1_text'] ?? 'Explore Properties',
        'primary_btn_url' => $home['home_hero_default_btn1_url'] ?? '/properties',
        'secondary_btn_text' => $home['home_hero_default_btn2_text'] ?? 'Speak With an Advisor',
        'secondary_btn_url' => $home['home_hero_default_btn2_url'] ?? '/contact-us',
        'trust_badge_1' => $home['home_hero_default_trust1'] ?? '20+ Years Leadership',
        'trust_badge_2' => $home['home_hero_default_trust2'] ?? '100% Non-Disclosure Mandates',
        'dossier_eyebrow' => $home['home_hero_default_dossier_eyebrow'] ?? 'Featured Residence Dossier',
        'dossier_title' => $home['home_hero_default_dossier_title'] ?? 'Golf Links Promenade · ₹35.00 Cr',
        'badge_text' => $home['home_hero_default_badge'] ?? 'Off-Market Mandate'
    ]
];
$totalSlides = count($slides);
?>

<!-- SECTION 1: ARCHITECTURAL CINEMATIC HERO (DYNAMIC CAROUSEL & DISCOVERY DESK) -->
<section class="stitch-hero" id="heroCarouselSection">
    <div class="site-container-stitch">
        <div class="stitch-hero-carousel-wrap">
            <div class="stitch-hero-slider" id="stitchHeroSlider">
                <?php foreach ($slides as $idx => $s): ?>
                    <?php
                    // Resolve dynamic image path
                    $sImg = !empty($s['image']) ? $s['image'] : (!empty($s['image_url']) ? $s['image_url'] : $stitchImg . '/hero-residence.jpg');
                    $sImgSrc = str_starts_with($sImg, 'http') ? $sImg : $baseUrl . '/' . ltrim($sImg, '/');

                    // Resolve slide title (support pre-formatted HTML or format plain text with dot)
                    $rawTitle = $s['title'] ?? '';
                    if (str_contains($rawTitle, '<span') || str_contains($rawTitle, '<br')) {
                        $titleFormatted = $rawTitle;
                    } elseif (str_contains($rawTitle, '.')) {
                        $parts = explode('.', $rawTitle, 2);
                        $titleFormatted = htmlspecialchars(trim($parts[0]), ENT_QUOTES, 'UTF-8') . '.<br><span class="hero-gold-italic">' . htmlspecialchars(trim($parts[1]), ENT_QUOTES, 'UTF-8') . '</span>';
                    } else {
                        $titleFormatted = htmlspecialchars($rawTitle, ENT_QUOTES, 'UTF-8');
                    }

                    $eyebrow = !empty($s['eyebrow']) ? $s['eyebrow'] : (!empty($s['badge']) ? $s['badge'] : ($home['home_hero_default_eyebrow'] ?? 'PRIVATE LUXURY ADVISORY · SOUTH DELHI'));
                    $btnPrimaryText = !empty($s['primary_btn_text']) ? $s['primary_btn_text'] : (!empty($s['btn_primary_text']) ? $s['btn_primary_text'] : ($home['home_hero_default_btn1_text'] ?? 'Explore Properties'));
                    $btnPrimaryUrl = !empty($s['primary_btn_url']) ? $s['primary_btn_url'] : (!empty($s['btn_primary_link']) ? $s['btn_primary_link'] : ($home['home_hero_default_btn1_url'] ?? '/properties'));
                    $btnSecondaryText = !empty($s['secondary_btn_text']) ? $s['secondary_btn_text'] : (!empty($s['btn_secondary_text']) ? $s['btn_secondary_text'] : ($home['home_hero_default_btn2_text'] ?? 'Speak With an Advisor'));
                    $btnSecondaryUrl = !empty($s['secondary_btn_url']) ? $s['secondary_btn_url'] : (!empty($s['btn_secondary_link']) ? $s['btn_secondary_link'] : ($home['home_hero_default_btn2_url'] ?? '/contact-us'));

                    $trust1 = !empty($s['trust_badge_1']) ? $s['trust_badge_1'] : ($home['home_hero_default_trust1'] ?? '20+ Years Leadership');
                    $trust2 = !empty($s['trust_badge_2']) ? $s['trust_badge_2'] : ($home['home_hero_default_trust2'] ?? '100% Non-Disclosure Mandates');

                    $dossierEyebrow = !empty($s['dossier_eyebrow']) ? $s['dossier_eyebrow'] : ($home['home_hero_default_dossier_eyebrow'] ?? 'Featured Residence Dossier');
                    $dossierTitle = !empty($s['dossier_title']) ? $s['dossier_title'] : ($home['home_hero_default_dossier_title'] ?? 'Golf Links Promenade · ₹35.00 Cr');
                    $badgeText = !empty($s['badge_text']) ? $s['badge_text'] : ($home['home_hero_default_badge'] ?? 'Off-Market Mandate');
                    ?>
                    <div class="stitch-hero-slide <?= $idx === 0 ? 'active' : '' ?>" data-slide-index="<?= $idx ?>">
                        <div class="stitch-hero-grid">
                            <!-- Editorial Narrative Column -->
                            <div class="stitch-hero-narrative">
                                <?php if (!empty($eyebrow)): ?>
                                    <div class="stitch-eyebrow-row">
                                        <span class="stitch-eyebrow-line"></span>
                                        <span class="stitch-eyebrow-text"><?= strtoupper(Format::e($eyebrow)) ?></span>
                                    </div>
                                <?php endif; ?>
                                <h1 class="stitch-hero-h1">
                                    <?= $titleFormatted ?>
                                </h1>
                                <?php if (!empty($s['subtitle'])): ?>
                                    <p class="stitch-hero-lead">
                                        <?= Format::e($s['subtitle']) ?>
                                    </p>
                                <?php endif; ?>
                                <div class="stitch-hero-actions">
                                    <?php if (!empty($btnPrimaryText)): ?>
                                        <?php $pUrlSrc = str_starts_with($btnPrimaryUrl, '#') ? $btnPrimaryUrl : (str_starts_with($btnPrimaryUrl, 'http') ? $btnPrimaryUrl : $baseUrl . '/' . ltrim($btnPrimaryUrl, '/')); ?>
                                        <a href="<?= Format::e($pUrlSrc) ?>" class="btn-stitch-primary">
                                            <span><?= Format::e($btnPrimaryText) ?></span>
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M5 12h14M12 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($btnSecondaryText)): ?>
                                        <?php $sUrlSrc = str_starts_with($btnSecondaryUrl, '#') ? $btnSecondaryUrl : (str_starts_with($btnSecondaryUrl, 'http') ? $btnSecondaryUrl : $baseUrl . '/' . ltrim($btnSecondaryUrl, '/')); ?>
                                        <a href="<?= Format::e($sUrlSrc) ?>" class="btn-stitch-outline">
                                            <span><?= Format::e($btnSecondaryText) ?></span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <!-- Authentic Trust Pillars -->
                                <div class="stitch-hero-trust-row">
                                    <div class="trust-dot-item">
                                        <span class="trust-gold-dot"></span>
                                        <span class="trust-tag-text"><?= Format::e($trust1) ?></span>
                                    </div>
                                    <span class="trust-sep">•</span>
                                    <div class="trust-dot-item">
                                        <span class="trust-gold-dot"></span>
                                        <span class="trust-tag-text"><?= Format::e($trust2) ?></span>
                                    </div>
                                    <span class="trust-sep">•</span>
                                    <div class="trust-dot-item">
                                        <span class="trust-gold-dot"></span>
                                        <span class="trust-tag-text"><?= Format::e($home['home_hero_default_trust3'] ?? 'RERA Registered') ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Hero Architectural Image Frame -->
                            <div class="stitch-hero-media-col">
                                <div class="stitch-hero-frame">
                                    <img src="<?= $sImgSrc ?>" alt="<?= Format::e($s['title']) ?>" width="800" height="640" fetchpriority="<?= $idx === 0 ? 'high' : 'auto' ?>">
                                    <div class="stitch-hero-scrim"></div>
                                    <!-- Floating Metadata Pill -->
                                    <div class="stitch-hero-pill-bar">
                                        <?php if (!empty($dossierTitle)): ?>
                                            <div class="stitch-dossier-card">
                                                <?php if (!empty($dossierEyebrow)): ?>
                                                    <p class="dossier-eyebrow"><?= Format::e($dossierEyebrow) ?></p>
                                                <?php endif; ?>
                                                <p class="dossier-title"><?= Format::e($dossierTitle) ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($badgeText)): ?>
                                            <div class="stitch-offmarket-badge">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                                </svg>
                                                <span><?= Format::e($badgeText) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="stitch-vertical-rail">
                                    <span><?= Format::e($home['home_hero_rail_text'] ?? 'ELITE HOMEZ · SOUTH DELHI BESPOKE ADVISORY') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Carousel Controls Bar (if > 1 slide) -->
            <?php if ($totalSlides > 1): ?>
                <div class="stitch-carousel-footer-bar">
                    <div class="stitch-carousel-counter" id="stitchHeroCounter">
                        <span class="counter-gold" id="stitchCurrentSlideNum">01</span> / <?= str_pad((string) $totalSlides, 2, '0', STR_PAD_LEFT) ?>
                    </div>
                    <div class="stitch-carousel-indicators" id="stitchHeroDots">
                        <?php for ($i = 0; $i < $totalSlides; $i++): ?>
                            <button type="button" class="stitch-carousel-dot <?= $i === 0 ? 'active' : '' ?>" data-goto="<?= $i ?>" aria-label="Go to slide <?= $i + 1 ?>"></button>
                        <?php endfor; ?>
                    </div>
                    <div class="stitch-carousel-ctrls">
                        <button type="button" class="stitch-carousel-btn" id="stitchPrevBtn" aria-label="Previous Slide">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                        </button>
                        <button type="button" class="stitch-carousel-btn" id="stitchNextBtn" aria-label="Next Slide">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- SECTION 2: BRAND AUTHORITY & 20+ YEARS MANIFESTO (DEEP FOREST GREEN #243F34 LUXURY BLOCK) -->
<section class="stitch-manifesto-section">
    <div class="site-container-stitch">
        <div class="stitch-manifesto-header">
            <span class="stitch-eyebrow-gold"><?= Format::e($home['home_manifesto_eyebrow'] ?? 'Institutional Heritage') ?></span>
            <h2 class="stitch-manifesto-h2">
                <?= Format::e($home['home_manifesto_title'] ?? 'More than a property. A relationship built around trust.') ?>
            </h2>
        </div>
        <!-- 4-Column Metric Line with Champagne Gold Dividers -->
        <div class="stitch-manifesto-grid">
            <div class="stitch-manifesto-col">
                <span class="manifesto-stat-num gold-text"><?= Format::e($home['home_stat_1_num'] ?? '20+') ?></span>
                <span class="manifesto-stat-title"><?= Format::e($home['home_stat_1_title'] ?? 'Years of Leadership') ?></span>
                <p class="manifesto-stat-desc"><?= Format::e($home['home_stat_1_desc'] ?? "Direct senior partner stewardship across Delhi's premier capital enclaves since 2004.") ?></p>
            </div>
            <div class="stitch-manifesto-col">
                <span class="manifesto-stat-num"><?= Format::e($home['home_stat_2_num'] ?? '₹1,200 Cr+') ?></span>
                <span class="manifesto-stat-title"><?= Format::e($home['home_stat_2_title'] ?? 'Transacted Asset Volume') ?></span>
                <p class="manifesto-stat-desc"><?= Format::e($home['home_stat_2_desc'] ?? 'Unrivaled access to off-market generational residences and private family estates.') ?></p>
            </div>
            <div class="stitch-manifesto-col">
                <span class="manifesto-stat-num gold-text"><?= Format::e($home['home_stat_3_num'] ?? '100%') ?></span>
                <span class="manifesto-stat-title"><?= Format::e($home['home_stat_3_title'] ?? 'Forensic Title Diligence') ?></span>
                <p class="manifesto-stat-desc"><?= Format::e($home['home_stat_3_desc'] ?? 'Zero legacy encumbrance assurance, zoning audits, and complete RERA statutory compliance.') ?></p>
            </div>
            <div class="stitch-manifesto-col">
                <span class="manifesto-stat-num"><?= Format::e($home['home_stat_4_num'] ?? 'Strict NDA') ?></span>
                <span class="manifesto-stat-title"><?= Format::e($home['home_stat_4_title'] ?? 'Family Office Discretion') ?></span>
                <p class="manifesto-stat-desc"><?= Format::e($home['home_stat_4_desc'] ?? 'Bilateral non-disclosure protocols protecting client confidentiality and wealth structures.') ?></p>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 3: SELECTED PROPERTIES (LUXURY MAGAZINE SHOWCASE) -->
<section class="stitch-properties-section">
    <div class="site-container-stitch">
        <!-- Header -->
        <div class="stitch-section-header">
            <div>
                <div class="stitch-dot-eyebrow">
                    <span class="gold-dot"></span>
                    <span class="eyebrow-caps"><?= Format::e($home['home_properties_eyebrow'] ?? 'Curated Portfolio') ?></span>
                </div>
                <h2 class="stitch-section-title"><?= Format::e($home['home_properties_title'] ?? 'Selected Properties') ?></h2>
                <p class="stitch-section-sub"><?= Format::e($home['home_properties_desc'] ?? 'A considered collection of exceptional South Delhi residences.') ?></p>
            </div>
            <?php 
            $propBtnUrl = !empty($home['home_properties_btn_url']) ? $home['home_properties_btn_url'] : '/properties';
            $propBtnUrlSrc = str_starts_with($propBtnUrl, 'http') ? $propBtnUrl : $baseUrl . '/' . ltrim($propBtnUrl, '/');
            ?>
            <a href="<?= Format::e($propBtnUrlSrc) ?>" class="stitch-view-all-link">
                <span><?= Format::e($home['home_properties_btn_text'] ?? 'View All Properties') ?></span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    <?php if (!empty($featuredProperties)): ?>
        <div class="stitch-extra-featured-grid">
            <?php foreach ($featuredProperties as $rIdx => $rp): ?>
                <?php
                $rpImg = !empty($rp['featured_image']) ? $rp['featured_image'] : $stitchImg . '/hero-residence.jpg';
                $rpImgSrc = str_starts_with($rpImg, 'http') ? $rpImg : $baseUrl . $rpImg;
                $rCardNum = str_pad((string) ($rIdx + 1), 2, '0', STR_PAD_LEFT);
                ?>
                <article class="stitch-secondary-card">
                    <div class="secondary-media-wrap">
                        <img src="<?= $rpImgSrc ?>" alt="<?= Format::e($rp['title']) ?>" loading="lazy">
                        <div class="secondary-scrim"></div>
                        <div class="secondary-tag-top"><?= $rCardNum ?> · <?= strtoupper(Format::e($rp['area_name'])) ?></div>
                        <?php if (!empty($rp['is_featured'])): ?>
                            <div style="position: absolute; top: 1rem; right: 1rem; background: linear-gradient(135deg, #B99A62, #9C7D46); color: #171A18; font-family: var(--font-caps); font-weight: 700; font-size: 0.625rem; letter-spacing: 0.1em; text-transform: uppercase; padding: 4px 8px; border-radius: 9999px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 2;">
                                ★ Featured
                            </div>
                        <?php endif; ?>
                        <div class="secondary-price-box"><?= Format::e($rp['price_display']) ?></div>
                    </div>
                    <div class="secondary-content-wrap">
                        <div class="secondary-enclave-tag"><?= Format::e($rp['property_type']) ?><?= !empty($rp['listing_type']) ? ' · ' . ucfirst(Format::e($rp['listing_type'])) : '' ?></div>
                        <h4 class="secondary-title"><?= Format::e($rp['title']) ?></h4>
                        <p class="secondary-desc">
                            <?= Format::e($rp['excerpt'] ?: substr(strip_tags($rp['description']), 0, 140) . '...') ?>
                        </p>
                        <div class="secondary-specs-row" style="margin-top: 0.75rem; font-size: 0.75rem; color: #5C605D; display: flex; align-items: center; gap: 0.5rem;">
                            <?php if (!empty($rp['bedrooms'])): ?>
                                <span><?= (int) $rp['bedrooms'] ?> Beds</span>
                                <span class="dot-sep">•</span>
                            <?php endif; ?>
                            <?php if (!empty($rp['property_size'])): ?>
                                <span><?= Format::e($rp['property_size']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="secondary-footer">
                        <a href="<?= $baseUrl ?>/properties/<?= Format::e($rp['slug']) ?>" class="stitch-details-link">
                            <span>View Property Details</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/<?= $waClean ?>?text=<?= urlencode('Hello Elite Homez, I would like to inquire about: ' . $rp['title']) ?>" target="_blank" rel="noopener noreferrer" class="btn-card-wa" title="WhatsApp Enquiry">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </div>
</section>

<!-- SECTION 4: ADVISORY SCOPE & CATEGORIES (DARK CHARCOAL #171A18 SECTION) -->
<section class="stitch-categories-section">
    <div class="site-container-stitch">
        <div class="stitch-categories-header">
            <span class="stitch-eyebrow-gold"><?= Format::e($home['home_services_eyebrow'] ?? 'Structured Advisory Scope') ?></span>
            <h2 class="stitch-categories-h2"><?= Format::e($home['home_services_title'] ?? 'Find Your Next Address.') ?></h2>
        </div>
        <?php if (!empty($services)): ?>
            <div class="stitch-categories-list">
                <?php foreach (array_values($services) as $idx => $srv): ?>
                    <?php $catNum = str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT); ?>
                    <a href="<?= $baseUrl ?>/services/<?= Format::e($srv['slug']) ?>" class="stitch-category-row">
                        <div class="cat-left-wrap">
                            <span class="cat-num"><?= $catNum ?></span>
                            <h3 class="cat-title"><?= strtoupper(Format::e($srv['name'])) ?></h3>
                        </div>
                        <div class="cat-right-wrap">
                            <p class="cat-desc">
                                <?= Format::e($srv['short_description']) ?>
                            </p>
                            <svg class="cat-arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- SECTION 5: WHY ELITE HOMEZ (INSTITUTIONAL DEEP FOREST GREEN BLOCK) -->
<section class="stitch-why-section">
    <div class="site-container-stitch">
        <div class="stitch-why-header">
            <div class="stitch-dot-eyebrow" style="justify-content: center;">
                <span class="gold-dot"></span>
                <span class="eyebrow-caps"><?= Format::e($home['home_why_eyebrow'] ?? 'Institutional Excellence') ?></span>
            </div>
            <h2 class="stitch-why-h2"><?= Format::e($home['home_why_title'] ?? 'The Difference is Experience.') ?></h2>
            <p class="stitch-why-quote">
                <?= Format::e($home['home_why_quote'] ?? '"Because acquiring or transferring generational real estate requires more than brokerage."') ?>
            </p>
        </div>
        <!-- 4 Vertical Architectural Principles -->
        <div class="stitch-why-grid">
            <div class="stitch-why-col">
                <span class="pillar-huge-num"><?= Format::e($home['home_pillar_1_num'] ?? '01') ?></span>
                <div>
                    <h3 class="pillar-title"><?= strtoupper(Format::e($home['home_pillar_1_title'] ?? 'LOCAL KNOWLEDGE')) ?></h3>
                    <p class="pillar-desc">
                        <?= Format::e($home['home_pillar_1_desc'] ?? "Unrivalled transaction intelligence across South Delhi's premier micro-markets, municipal FAR statutes, and clear title genealogy.") ?>
                    </p>
                </div>
                <div class="pillar-footer">
                    <span><?= Format::e($home['home_pillar_1_tag'] ?? 'Forensic Due Diligence') ?></span>
                </div>
            </div>
            <div class="stitch-why-col">
                <span class="pillar-huge-num"><?= Format::e($home['home_pillar_2_num'] ?? '02') ?></span>
                <div>
                    <h3 class="pillar-title"><?= strtoupper(Format::e($home['home_pillar_2_title'] ?? 'DISCREET ADVISORY')) ?></h3>
                    <p class="pillar-desc">
                        <?= Format::e($home['home_pillar_2_desc'] ?? 'Complete transaction privacy, family-office protocol, and non-disclosure governance protecting generational reputation.') ?>
                    </p>
                </div>
                <div class="pillar-footer">
                    <span><?= Format::e($home['home_pillar_2_tag'] ?? 'Strict Bilateral NDAs') ?></span>
                </div>
            </div>
            <div class="stitch-why-col">
                <span class="pillar-huge-num"><?= Format::e($home['home_pillar_3_num'] ?? '03') ?></span>
                <div>
                    <h3 class="pillar-title"><?= strtoupper(Format::e($home['home_pillar_3_title'] ?? 'OFF-MARKET ACCESS')) ?></h3>
                    <p class="pillar-desc">
                        <?= Format::e($home['home_pillar_3_desc'] ?? 'Direct access to trophy estates, heritage bungalows, and private residences that never enter public digital portals.') ?>
                    </p>
                </div>
                <div class="pillar-footer">
                    <span><?= Format::e($home['home_pillar_3_tag'] ?? 'Private Enclave Network') ?></span>
                </div>
            </div>
            <div class="stitch-why-col">
                <span class="pillar-huge-num"><?= Format::e($home['home_pillar_4_num'] ?? '04') ?></span>
                <div>
                    <h3 class="pillar-title"><?= strtoupper(Format::e($home['home_pillar_4_title'] ?? 'SENIOR STEWARDSHIP')) ?></h3>
                    <p class="pillar-desc">
                        <?= Format::e($home['home_pillar_4_desc'] ?? 'Senior partners directly stewarding every valuation, private viewing, and statutory contract closure.') ?>
                    </p>
                </div>
                <div class="pillar-footer">
                    <span><?= Format::e($home['home_pillar_4_tag'] ?? 'Principal Level Trust') ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 6: AREAS OF EXPERTISE (SOUTH DELHI VISUAL ATLAS) -->
<section class="stitch-areas-section">
    <div class="site-container-stitch">
        <div class="stitch-areas-header">
            <span class="stitch-eyebrow-gold"><?= Format::e($home['home_areas_eyebrow'] ?? 'Territorial Mastery') ?></span>
            <h2 class="stitch-areas-h2"><?= Format::e($home['home_areas_title'] ?? 'Addresses We Know.') ?></h2>
            <p class="stitch-areas-sub"><?= Format::e($home['home_areas_desc'] ?? 'Intimate familiarity with distinctive micro-markets and the rare residences within them.') ?></p>
        </div>
        <?php if (!empty($areas)): ?>
            <?php 
            $firstArea = $areas[0];
            $firstImg = !empty($firstArea['hero_image']) ? $firstArea['hero_image'] : $stitchImg . '/about-interior.jpg';
            $firstImgSrc = str_starts_with($firstImg, 'http') ? $firstImg : $baseUrl . $firstImg;
            $subAreas = array_slice($areas, 1, 3);
            $extraAreas = array_slice($areas, 4);
            $tags = ['Diplomatic Boulevard', 'Lutyens Perimeter', 'Diplomatic Enclave'];
            ?>
            <div class="stitch-mosaic-grid">
                <!-- Large Feature Location -->
                <a href="<?= $baseUrl ?>/locations/<?= Format::e($firstArea['slug']) ?>" class="mosaic-item-large">
                    <img src="<?= $firstImgSrc ?>" alt="<?= Format::e($firstArea['name']) ?>" loading="lazy">
                    <div class="mosaic-scrim-heavy"></div>
                    <div class="mosaic-large-content">
                        <div>
                            <span class="mosaic-tag-gold">Flagship Enclave</span>
                            <h3 class="mosaic-title-lg"><?= Format::e($firstArea['name']) ?></h3>
                            <p class="mosaic-sub-text"><?= Format::e($firstArea['short_description']) ?></p>
                        </div>
                        <svg class="mosaic-arrow" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                <!-- Subgrid -->
                <div class="mosaic-right-subgrid">
                    <?php foreach ($subAreas as $sIdx => $sa): ?>
                        <?php
                        $saImg = !empty($sa['hero_image']) ? $sa['hero_image'] : ($sIdx === 0 ? $stitchImg . '/jor-bagh-bungalow.jpg' : ($sIdx === 1 ? $stitchImg . '/golf-links-villa.jpg' : $stitchImg . '/vasant-vihar-penthouse.jpg'));
                        $saImgSrc = str_starts_with($saImg, 'http') ? $saImg : $baseUrl . $saImg;
                        $isSpan2 = ($sIdx === 2 || ($sIdx === 0 && count($subAreas) === 1));
                        ?>
                        <a href="<?= $baseUrl ?>/locations/<?= Format::e($sa['slug']) ?>" class="<?= $isSpan2 ? 'mosaic-subitem-span2' : 'mosaic-subitem' ?>">
                            <img src="<?= $saImgSrc ?>" alt="<?= Format::e($sa['name']) ?>" loading="lazy">
                            <div class="mosaic-scrim-med"></div>
                            <div class="<?= $isSpan2 ? 'mosaic-span2-content' : 'mosaic-subitem-content' ?>">
                                <div>
                                    <span class="mosaic-tag-gold"><?= $tags[$sIdx] ?? 'Prime Enclave' ?></span>
                                    <h4 class="mosaic-title-sm"><?= Format::e($sa['name']) ?></h4>
                                    <p class="mosaic-sub-text"><?= Format::e($sa['short_description']) ?></p>
                                </div>
                                <?php if ($isSpan2): ?>
                                    <svg class="mosaic-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if (!empty($extraAreas)): ?>
                <!-- Typographic Supporting Enclaves Ticker -->
                <div class="stitch-enclaves-ticker">
                    <p class="ticker-label"><?= Format::e($home['home_areas_ticker_label'] ?? 'Additional Prime South Delhi Enclaves:') ?></p>
                    <div class="ticker-grid">
                        <?php foreach ($extraAreas as $ea): ?>
                            <a href="<?= $baseUrl ?>/locations/<?= Format::e($ea['slug']) ?>" class="ticker-card">
                                <span class="ticker-name"><?= Format::e($ea['name']) ?></span>
                                <span class="ticker-sub">Explore Enclave &rarr;</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- SECTION 7: DIRECTOR'S MESSAGE / FIDUCIARY LEADERSHIP (DEEP FOREST GREEN #243F34 SECTION) -->
<?php
$dirImg = !empty($home['home_director_image']) 
    ? (str_starts_with($home['home_director_image'], 'http') ? $home['home_director_image'] : $baseUrl . '/' . ltrim($home['home_director_image'], '/'))
    : $stitchImg . '/about-director-office.jpg';
?>
<section class="stitch-director-section">
    <div class="site-container-stitch">
        <div class="stitch-director-grid">
            <div class="stitch-director-media">
                <div class="director-frame">
                    <img src="<?= $dirImg ?>" alt="Elite Homez Managing Director Office in New Delhi" loading="lazy">
                </div>
                <div class="director-credentials-card">
                    <span class="credentials-eyebrow"><?= Format::e($home['home_director_credentials_eyebrow'] ?? 'FOUNDING PRINCIPAL') ?></span>
                    <p class="credentials-name"><?= Format::e($home['home_director_credentials_name'] ?? 'Managing Director') ?></p>
                    <p class="credentials-title"><?= Format::e($home['home_director_credentials_title'] ?? 'Elite Homez Property Advisory') ?></p>
                </div>
            </div>

            <div class="stitch-director-copy">
                <div class="stitch-eyebrow-row">
                    <span class="stitch-eyebrow-line"></span>
                    <span class="stitch-eyebrow-text"><?= strtoupper(Format::e($home['home_director_eyebrow'] ?? "DIRECTOR'S LETTER")) ?></span>
                </div>
                <h2 class="stitch-director-h2">
                    <?= Format::e($home['home_director_title'] ?? '"Discretion is not merely a courtesy. In high-value real estate, it is the cornerstone of trust."') ?>
                </h2>
                <div class="director-pull-quote">
                    <?= nl2br(Format::e($home['home_director_pullquote'] ?? 'Over the last twenty years, we have seen prime Delhi real estate transition through cycles, zoning shifts, and generational changes. What has never changed is the value of personal integrity.')) ?>
                </div>
                <p class="director-letter-body">
                    <?= nl2br(Format::e($home['home_director_p1'] ?? 'When high-net-worth families, single family offices, and diplomatic missions entrust us with their residential mandates, they are looking for more than square footage. They require forensic legal clarity, absolute privacy, and an unhurried advisor who tells them the honest truth about an asset before a single rupee is committed.')) ?>
                </p>
                <p class="director-letter-body">
                    <?= nl2br(Format::e($home['home_director_p2'] ?? 'At Elite Homez, our motto "your trust, our responsibility" is our binding covenant. Every transaction is directly steered by our senior partners with generational commitment.')) ?>
                </p>
                <div class="director-signature-wrap">
                    <span class="signature-signoff"><?= Format::e($home['home_director_signoff'] ?? 'Elite Homez Advisory') ?></span>
                    <span class="signature-badge"><?= Format::e($home['home_director_badge'] ?? '✦ Senior Partner Desk') ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 8: PRIVATE ADVISORY ENQUIRY DESK (CONFIDENTIAL CONVERSION DESK) -->
<?php if (($home['home_enquiry_enabled'] ?? '1') !== '0'): ?>
<section class="w-full bg-[#243F34] text-white py-24 px-6 lg:px-12 border-t border-[#B99A62]/30 relative z-20" id="confidential-desk">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            <!-- Advisory Context (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#B99A62]"></span>
                        <span class="font-['Manrope'] uppercase tracking-[0.2em] text-[#DFCF9F] text-xs font-semibold">
                            <?= Format::e($home['home_enquiry_eyebrow'] ?? 'Confidential Dialogue') ?>
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl text-white leading-tight font-normal" style="font-family: 'Playfair Display', serif;">
                        <?= Format::e($home['home_enquiry_title'] ?? 'Initiate a Private Advisory Briefing') ?>
                    </h2>
                </div>
                <p class="text-sm sm:text-base text-[#EAE3D7]/85 leading-relaxed font-light font-['Plus_Jakarta_Sans']">
                    <?= nl2br(Format::e($home['home_enquiry_desc'] ?? 'Share your parameters. A designated Elite Homez Senior Partner will contact you under strict bilateral confidentiality.')) ?>
                </p>
                
                <div class="pt-6 space-y-4 text-xs font-['Manrope'] uppercase tracking-wider text-[#DFCF9F] border-t border-[#B99A62]/20 font-semibold">
                    <?php if (!empty($home['home_enquiry_feature_1'])): ?>
                    <div class="flex items-center gap-3">
                        <span class="text-[#B99A62] text-base font-bold">✓</span>
                        <span class="text-[#EAE3D7]/90"><?= Format::e($home['home_enquiry_feature_1']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($home['home_enquiry_feature_2'])): ?>
                    <div class="flex items-center gap-3">
                        <span class="text-[#B99A62] text-base font-bold">✓</span>
                        <span class="text-[#EAE3D7]/90"><?= Format::e($home['home_enquiry_feature_2']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($home['home_enquiry_feature_3'])): ?>
                    <div class="flex items-center gap-3">
                        <span class="text-[#B99A62] text-base font-bold">✓</span>
                        <span class="text-[#EAE3D7]/90"><?= Format::e($home['home_enquiry_feature_3']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="pt-4 text-xs text-[#EAE3D7]/60 font-['Manrope']">
                    Direct Partner Desk: <a href="tel:<?= $phoneClean ?>" class="text-[#DFCF9F] font-semibold hover:underline"><?= Format::e($phone) ?></a>
                </div>
            </div>

            <!-- Form Interface (7 Cols) -->
            <div class="lg:col-span-7 bg-[#171A18]/85 border border-[#B99A62]/30 p-8 lg:p-10 shadow-2xl backdrop-blur-sm">
                <!-- Feedback banner -->
                <div id="home-form-feedback" class="hidden p-4 mb-6 text-xs text-center font-['Manrope'] uppercase tracking-wider font-semibold transition-all"></div>

                <form id="home-advisory-form" action="<?= $baseUrl ?>/enquire" method="POST" class="space-y-6">
                    <?= \App\Helpers\Csrf::field() ?>
                    <!-- Anti-spam Honeypot -->
                    <div style="display: none;" aria-hidden="true">
                        <input type="text" name="website_url_check" tabindex="-1" autocomplete="off">
                    </div>
                    <input type="hidden" name="source_page" value="Homepage: Private Advisory Briefing">
                    <input type="hidden" name="return_url" value="<?= $baseUrl ?>/#confidential-desk">

                    <div>
                        <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold" for="home_name">Full Legal Name *</label>
                        <input class="w-full bg-white/10 border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-3 outline-none text-sm transition-colors placeholder:text-white/30 font-['Plus_Jakarta_Sans']" placeholder="e.g. Vikramaditya Singhania" required type="text" name="name" id="home_name"/>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold" for="home_mobile">Direct Telephone *</label>
                            <input class="w-full bg-white/10 border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-3 outline-none text-sm transition-colors placeholder:text-white/30 font-['Plus_Jakarta_Sans']" placeholder="+91 98110 00000" required type="tel" name="mobile" id="home_mobile"/>
                        </div>
                        <div>
                            <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold" for="home_email">Confidential Email *</label>
                            <input class="w-full bg-white/10 border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-3 outline-none text-sm transition-colors placeholder:text-white/30 font-['Plus_Jakarta_Sans']" placeholder="principal@familyoffice.com" required type="email" name="email" id="home_email"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold" for="home-enclave-choice">Preferred Enclave</label>
                            <select name="enclave_choice" id="home-enclave-choice" class="w-full bg-[#243F34] border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-3 outline-none text-sm transition-colors cursor-pointer font-['Plus_Jakarta_Sans']">
                                <option value="All Prime South Delhi">All Prime South Delhi</option>
                                <?php if (!empty($allAreas)): ?>
                                    <?php foreach ($allAreas as $ar): ?>
                                        <option value="<?= Format::e($ar['name']) ?>"><?= Format::e($ar['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <option value="Other South Delhi Enclave">Other South Delhi Enclave</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold" for="home-service-choice">Advisory Mandate / Service</label>
                            <select name="service_choice" id="home-service-choice" class="w-full bg-[#243F34] border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-3 outline-none text-sm transition-colors cursor-pointer font-['Plus_Jakarta_Sans']">
                                <option value="Luxury Property Buying Advisory">Luxury Property Buying Advisory</option>
                                <option value="Luxury Property Selling Mandate">Luxury Property Selling Mandate</option>
                                <option value="Diplomatic & Executive Leasing">Diplomatic & Executive Leasing</option>
                                <option value="Real Estate Portfolio Advisory">Real Estate Portfolio Advisory</option>
                                <?php if (!empty($allServices)): ?>
                                    <?php foreach ($allServices as $srv): ?>
                                        <option value="<?= Format::e($srv['name']) ?>"><?= Format::e($srv['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold" for="home-timeline-choice">Target Timeline</label>
                            <select name="timeline_choice" id="home-timeline-choice" class="w-full bg-[#243F34] border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-3 outline-none text-sm transition-colors cursor-pointer font-['Plus_Jakarta_Sans']">
                                <option value="Immediate (0-3 Months)">Immediate (0-3 Months)</option>
                                <option value="Short Term (3-6 Months)">3-6 Months</option>
                                <option value="Strategic (6-12 Months)">6-12 Months (Generational)</option>
                                <option value="Confidential Survey">Confidential Market Survey</option>
                            </select>
                        </div>
                        <div class="flex items-center pt-6">
                            <label class="flex items-center gap-2 cursor-pointer text-xs text-[#EAE3D7]/80 font-['Manrope']">
                                <input type="checkbox" name="nda_requested" value="1" checked class="accent-[#B99A62] w-4 h-4">
                                <span>Execute Bilateral Non-Disclosure Agreement (NDA)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold" for="home-brief-message">Acquisition Parameters &amp; Spatial Requirements *</label>
                        <textarea id="home-brief-message" name="message" class="w-full bg-white/10 border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-3 outline-none text-sm transition-colors placeholder:text-white/30 font-['Plus_Jakarta_Sans']" placeholder="Plot area (sq. yards), configuration (Duplex / Independent Bungalow / Builder Floor), preferred orientation, parking needs..." rows="3" required></textarea>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row gap-4">
                        <button id="home-submit-advisory-btn" class="flex-1 bg-[#B99A62] hover:bg-[#DFCF9F] text-[#171A18] font-['Manrope'] uppercase tracking-widest px-8 py-4 transition-colors font-semibold shadow-md text-xs flex items-center justify-center gap-2" type="submit">
                            <span id="home-btn-label"><?= Format::e($home['home_enquiry_btn_text'] ?? 'Request Confidential Consultation') ?></span>
                            <span id="home-btn-spinner" class="hidden w-4 h-4 border-2 border-[#171A18] border-t-transparent rounded-full animate-spin"></span>
                        </button>
                        <a class="inline-flex items-center justify-center gap-2 border border-[#B99A62]/50 text-white px-6 py-4 font-['Manrope'] uppercase tracking-widest hover:border-[#DFCF9F] hover:text-[#DFCF9F] transition-colors text-xs font-semibold" href="https://wa.me/<?= $waClean ?>?text=<?= urlencode('Hello Elite Homez, I would like to consult with an advisor regarding prime South Delhi properties.') ?>" rel="noopener noreferrer" target="_blank">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" class="text-[#DFCF9F]"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span><?= Format::e($home['home_enquiry_wa_text'] ?? 'Direct WhatsApp Concierge') ?></span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- SECTION 9: FINAL ENQUIRY (CINEMATIC FULL-WIDTH FINALE) -->
<?php
$ctaBgImg = !empty($home['home_cta_image'])
    ? (str_starts_with($home['home_cta_image'], 'http') ? $home['home_cta_image'] : $baseUrl . '/' . ltrim($home['home_cta_image'], '/'))
    : $stitchImg . '/hero-residence.jpg';

$ctaBtn1Url = !empty($home['home_cta_btn1_url']) ? $home['home_cta_btn1_url'] : '#confidential-desk';
$ctaBtn1UrlSrc = str_starts_with($ctaBtn1Url, '#') ? $ctaBtn1Url : (str_starts_with($ctaBtn1Url, 'http') ? $ctaBtn1Url : $baseUrl . '/' . ltrim($ctaBtn1Url, '/'));

$ctaWaUrl = !empty($home['home_cta_btn2_url'])
    ? $home['home_cta_btn2_url']
    : 'https://wa.me/' . $waClean . '?text=' . urlencode('Hello Elite Homez, I would like to consult with an advisor regarding prime properties.');
?>
<section class="stitch-finale-section">
    <div class="finale-bg-scrim">
        <img src="<?= $ctaBgImg ?>" alt="Luxury Residence Evening" loading="lazy">
    </div>
    <div class="finale-gradient-overlay"></div>
    <div class="site-container-stitch relative-z10">
        <div class="finale-content-wrap">
            <div class="stitch-dot-eyebrow" style="justify-content: center;">
                <span class="gold-dot"></span>
                <span class="eyebrow-caps"><?= Format::e($home['home_cta_eyebrow'] ?? 'DIRECT PRINCIPAL ADVISORY') ?></span>
            </div>
            <h2 class="finale-h2"><?= Format::e($home['home_cta_title'] ?? 'Your next address deserves the right advice.') ?></h2>
            <p class="finale-lead">
                <?= nl2br(Format::e($home['home_cta_desc'] ?? 'Speak with Elite Homez about your next property decision. Our advisory desk offers uncompromised discretion, deep enclave records, and partner-level stewardship.')) ?>
            </p>
            <!-- Action Buttons -->
            <div class="finale-actions-row">
                <a href="<?= Format::e($ctaBtn1UrlSrc) ?>" class="btn-finale-gold">
                    <span><?= Format::e($home['home_cta_btn1_text'] ?? 'Speak With an Advisor') ?></span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="<?= Format::e($ctaWaUrl) ?>" target="_blank" rel="noopener noreferrer" class="btn-finale-wa">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span><?= Format::e($home['home_cta_btn2_text'] ?? 'Direct WhatsApp Concierge') ?></span>
                </a>
            </div>
            <p class="finale-confidentiality-note">
                <?= Format::e($home['home_cta_note'] ?? 'All discussions are treated with strict professional confidentiality under bilateral NDAs.') ?>
            </p>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. HERO CAROUSEL CONTROLS & AUTOPLAY
    const heroSlides = document.querySelectorAll('#stitchHeroSlider .stitch-hero-slide');
    const heroDots = document.querySelectorAll('#stitchHeroDots .stitch-carousel-dot');
    const heroPrev = document.getElementById('stitchPrevBtn');
    const heroNext = document.getElementById('stitchNextBtn');
    const heroNum = document.getElementById('stitchCurrentSlideNum');
    let currentHeroIdx = 0;
    let heroTimer = null;

    function showHeroSlide(idx) {
        if (!heroSlides.length) return;
        if (idx < 0) idx = heroSlides.length - 1;
        if (idx >= heroSlides.length) idx = 0;
        currentHeroIdx = idx;

        heroSlides.forEach(function(s, i) {
            if (i === idx) {
                s.classList.add('active');
            } else {
                s.classList.remove('active');
            }
        });

        heroDots.forEach(function(d, i) {
            if (i === idx) {
                d.classList.add('active');
            } else {
                d.classList.remove('active');
            }
        });

        if (heroNum) {
            heroNum.textContent = String(idx + 1).padStart(2, '0');
        }
    }

    function nextHeroSlide() {
        showHeroSlide(currentHeroIdx + 1);
    }

    function prevHeroSlide() {
        showHeroSlide(currentHeroIdx - 1);
    }

    function startHeroTimer() {
        stopHeroTimer();
        if (heroSlides.length > 1) {
            heroTimer = setInterval(nextHeroSlide, 7000);
        }
    }

    function stopHeroTimer() {
        if (heroTimer) {
            clearInterval(heroTimer);
            heroTimer = null;
        }
    }

    if (heroNext) {
        heroNext.addEventListener('click', function() {
            nextHeroSlide();
            startHeroTimer();
        });
    }

    if (heroPrev) {
        heroPrev.addEventListener('click', function() {
            prevHeroSlide();
            startHeroTimer();
        });
    }

    heroDots.forEach(function(dot) {
        dot.addEventListener('click', function() {
            const target = parseInt(this.getAttribute('data-goto') || '0', 10);
            showHeroSlide(target);
            startHeroTimer();
        });
    });

    const heroSection = document.getElementById('heroCarouselSection');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', stopHeroTimer);
        heroSection.addEventListener('mouseleave', startHeroTimer);
    }

    startHeroTimer();

    // Home Page Advisory Briefing Dynamic Form AJAX Handler
    const homeForm = document.getElementById('home-advisory-form');
    if (homeForm) {
        homeForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const feedback = document.getElementById('home-form-feedback');
            const submitBtn = document.getElementById('home-submit-advisory-btn');
            const btnLabel = document.getElementById('home-btn-label');
            const btnSpinner = document.getElementById('home-btn-spinner');
            const originalLabel = btnLabel ? btnLabel.innerHTML : 'Request Confidential Consultation';

            const nameEl = document.getElementById('home_name');
            const mobileEl = document.getElementById('home_mobile');
            const emailEl = document.getElementById('home_email');
            const msgEl = document.getElementById('home-brief-message');

            if (!nameEl.value.trim()) {
                showHomeFeedback('Please enter your full legal name.', false);
                nameEl.focus();
                return;
            }
            if (!mobileEl.value.trim()) {
                showHomeFeedback('Please enter a valid telephone contact number.', false);
                mobileEl.focus();
                return;
            }
            if (!emailEl.value.trim()) {
                showHomeFeedback('Please provide a valid confidential email address.', false);
                emailEl.focus();
                return;
            }
            if (!msgEl.value.trim() || msgEl.value.trim().length < 3) {
                showHomeFeedback('Please detail your residential parameters or spatial requirements.', false);
                msgEl.focus();
                return;
            }

            submitBtn.disabled = true;
            if (btnLabel) btnLabel.textContent = 'Transmitting Mandate...';
            if (btnSpinner) btnSpinner.classList.remove('hidden');

            const formData = new FormData(homeForm);

            fetch(homeForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json().catch(() => ({ success: false, message: 'Server communication error. Please telephone our Senior Advisory Desk directly.' })))
            .then(data => {
                if (data.success) {
                    showHomeFeedback(data.message || 'Thank you. Your advisory mandate has been registered under strict bilateral NDA protocols. A senior partner will contact you shortly.', true);
                    homeForm.reset();
                } else {
                    showHomeFeedback(data.message || data.error || 'Unable to submit advisory mandate. Please verify your details or phone our desk.', false);
                }
            })
            .catch(err => {
                showHomeFeedback('A network transmission error occurred. Please contact our Senior Advisory Desk directly.', false);
            })
            .finally(() => {
                submitBtn.disabled = false;
                if (btnLabel) btnLabel.innerHTML = originalLabel;
                if (btnSpinner) btnSpinner.classList.add('hidden');
            });
        });

        function showHomeFeedback(msg, isSuccess) {
            const feedback = document.getElementById('home-form-feedback');
            if (!feedback) return;
            feedback.textContent = msg;
            feedback.classList.remove('hidden', 'bg-[#B99A62]/20', 'border-[#B99A62]', 'text-[#FAF8F4]', 'bg-red-950/70', 'border-red-500/60', 'text-red-200');
            if (isSuccess) {
                feedback.classList.add('bg-[#B99A62]/20', 'border', 'border-[#B99A62]', 'text-[#FAF8F4]');
            } else {
                feedback.classList.add('bg-red-950/70', 'border', 'border-red-500/60', 'text-red-200');
            }
            feedback.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
});
</script>
