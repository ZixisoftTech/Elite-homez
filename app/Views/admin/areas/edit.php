<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];

// Safe JSON decoder helper
$jsonDecode = function ($val, $default = []) {
    if (empty($val)) return $default;
    if (is_array($val)) return $val;
    $res = json_decode((string)$val, true);
    return is_array($res) ? $res : $default;
};

$heroMetrics = $jsonDecode($area['hero_metrics'] ?? null, [
    ['label' => 'Avg. Price/Sq.Yd', 'value' => '₹12L - ₹18L'],
    ['label' => 'Plot Footprints', 'value' => '400 - 2,000 Sq.Yd'],
    ['label' => 'Green Cover', 'value' => '42% (A-Grade)'],
    ['label' => 'Security', 'value' => 'Diplomatic A1']
]);

$characterHighlights = $jsonDecode($area['character_highlights'] ?? null, [
    'Strict Residential Zoning',
    'High Owner-Occupancy',
    'Off-Market Mandates'
]);

$propertyTypes = $jsonDecode($area['property_types'] ?? null, [
    [
        'title' => 'Independent Luxury Bungalows',
        'description' => 'Detached multi-level private residences featuring generous front setbacks, perimeter security, landscaped wrap-around lawns, and multi-car parking.',
        'buyer_profile' => 'Prominent business families, industrial leaders, and diplomatic foreign missions seeking compound security.',
        'cta_text' => 'Inquire for Off-Market Bungalows',
        'cta_link' => '/contact-us?subject=' . urlencode(($area['name'] ?? 'Location') . ' Bungalow Inquiry')
    ],
    [
        'title' => 'Full-Floor Luxury Builder Residences',
        'description' => 'Bespoke single-floor apartments measuring 3,500 to 8,000 sq ft, equipped with private high-speed elevators, imported Italian marble, and separate staff quarters.',
        'buyer_profile' => 'C-suite executives, senior corporate counsel, and luxury homeowners requiring effortless turnkey living.',
        'cta_text' => 'Explore Builder Floors',
        'cta_link' => '/properties?area=' . ($area['slug'] ?? '')
    ],
    [
        'title' => 'Park-Facing Penthouses with Terraces',
        'description' => 'Top-tier duplex and single-level penthouse homes with exclusive roof rights, cantilevered pergolas, curated sky decks, and unobstructed views.',
        'buyer_profile' => 'Affluent entrepreneurs and NRI investors looking for distinctive architectural trophy assets.',
        'cta_text' => 'Request Penthouse Dossier',
        'cta_link' => '/contact-us?subject=' . urlencode(($area['name'] ?? 'Location') . ' Penthouse Inquiry')
    ]
]);

$plotSizes = $jsonDecode($area['plot_sizes'] ?? null, [
    ['type' => 'Compact Enclave Plots', 'size' => '400 - 600 Sq. Yards', 'description' => 'Ideal for luxury duplex development or modern bespoke multi-level residences.'],
    ['type' => 'Standard Prime Plots', 'size' => '800 - 1,200 Sq. Yards', 'description' => 'The hallmark plot footprint supporting grand detached bungalows with expansive lawns.'],
    ['type' => 'Flagship Estate Plots', 'size' => '1,500 - 2,500+ Sq. Yards', 'description' => 'Rare landmark parcels offering total diplomatic security, perimeter shielding, and private pavilions.']
]);

$faqs = $jsonDecode($area['faqs'] ?? null, [
    [
        'question' => "What is the typical property structure available in " . ($area['name'] ?? 'this enclave') . "?",
        'answer' => ($area['name'] ?? 'This enclave') . " predominantly offers independent luxury builder floors (single-floor apartments on 400 to 1,200 sq. yard plots) and detached legacy bungalows."
    ],
    [
        'question' => "Are properties in " . ($area['name'] ?? 'this enclave') . " freehold?",
        'answer' => "Yes, the vast majority of residential plots and builder floors in " . ($area['name'] ?? 'this enclave') . " are freehold properties with registered conveyance deeds."
    ],
    [
        'question' => "How does Elite Homez verify property documentation in " . ($area['name'] ?? 'this enclave') . "?",
        'answer' => "Our legal advisory team conducts 30-year title searches, verifies chain of ownership, confirms sanctioned building plans, and reviews completion certificates."
    ]
]);

$currHeroImg = !empty($area['hero_image']) ? $area['hero_image'] : '/assets/images/areas/vasant-vihar.jpg';
$currHeroImgSrc = str_starts_with($currHeroImg, 'http') ? $currHeroImg : $baseUrl . '/' . ltrim($currHeroImg, '/');
?>

<form action="<?= $baseUrl ?>/admin/areas/update/<?= (int) $area['id'] ?>" method="POST" enctype="multipart/form-data">
    <?= Csrf::field() ?>

    <div class="admin-page-header">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy); margin: 0;">Edit Location: <?= Format::e($area['name']) ?></h2>
                <span class="badge" style="background: <?= !empty($area['is_published']) ? '#DCFCE7' : '#FEE2E2' ?>; color: <?= !empty($area['is_published']) ? '#166534' : '#991B1B' ?>;">
                    <?= !empty($area['is_published']) ? '● Published' : '○ Draft (Inactive)' ?>
                </span>
                <?php if (!empty($area['show_on_home'])): ?>
                    <span class="badge" style="background: #FEF3C7; color: #92400E;">★ On Home</span>
                <?php endif; ?>
            </div>
            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 0;">Complete control over headings, text, metrics, property formats, plots, connectivity, FAQs, and buttons from head to bottom.</p>
        </div>
        <div class="admin-header-actions">
            <a href="<?= $baseUrl ?>/locations/<?= Format::e($area['slug']) ?>" target="_blank" class="btn btn-outline btn-sm">
                <?= SvgIcons::render('eye', 'w-3 h-3', 14) ?> View Live Page
            </a>
            <a href="<?= $baseUrl ?>/admin/areas" class="btn btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm">Save All Changes</button>
        </div>
    </div>

    <div class="admin-form-layout">
        <!-- Left Main Column: Section Tabs -->
        <div class="admin-form-main">
            <!-- Navigation Tabs -->
            <div class="admin-tabs" style="display: flex; flex-wrap: wrap; gap: 0.25rem; border-bottom: 1px solid var(--admin-border); margin-bottom: 1.25rem;">
                <button type="button" class="admin-tab-btn active" data-tab="tab-overview">1. Hero & Metrics</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-character">2. Character & Market</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-formats">3. Formats & Plots</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-lifestyle">4. Lifestyle & Transit</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-banner">5. Advisory Banner</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-faqs">6. FAQs (Accordion)</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-cta">7. Final CTA</button>
            </div>

            <!-- TAB 1: HERO & METRICS -->
            <div class="admin-tab-pane active" id="tab-overview">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 1: Hero Identity, Headlines & Key Metrics</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="name">Enclave / Location Name *</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= Format::e($area['name']) ?>" placeholder="e.g. Vasant Vihar" required>
                            <small class="form-text">Primary geographical name of the micro-market.</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="slug">URL Slug (Custom Permalinks)</label>
                            <input type="text" name="slug" id="slug" class="form-control" value="<?= Format::e($area['slug']) ?>" placeholder="e.g. vasant-vihar">
                            <small class="form-text">Live URL: <code>/locations/<?= Format::e($area['slug']) ?></code></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_monograph_text">Territory Monograph Badge (Top Overline)</label>
                        <input type="text" name="hero_monograph_text" id="hero_monograph_text" class="form-control" value="<?= Format::e($area['hero_monograph_text'] ?? "Territory Monograph 01 · South Delhi") ?>" placeholder="e.g. Territory Monograph 01 · South Delhi">
                        <small class="form-text">Displays above the main H1 with a luxury gold badge border.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_title">Hero H1 Headline *</label>
                        <input type="text" name="hero_title" id="hero_title" class="form-control" value="<?= Format::e($area['hero_title'] ?? ($area['name'] . ': The Grand Boulevards of Diplomatic South Delhi')) ?>" placeholder="e.g. Vasant Vihar: The Grand Boulevards of Diplomatic South Delhi" required>
                        <small class="form-text">Main editorial headline on the cinematic hero banner.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_subtitle">Hero Subtitle Paragraph</label>
                        <textarea name="hero_subtitle" id="hero_subtitle" class="form-control" rows="2" placeholder="e.g. Benchmark South Delhi address defined by wide tree-canopied avenues..."><?= Format::e($area['hero_subtitle'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="short_description">Short Summary Description</label>
                        <textarea name="short_description" id="short_description" class="form-control" rows="2" placeholder="Short description used for homepage location cards and SEO excerpts..."><?= Format::e($area['short_description'] ?? '') ?></textarea>
                    </div>

                    <!-- Key Metrics Visual Repeater -->
                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--admin-border);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <div>
                                <h4 style="font-size: 0.95rem; font-weight: 600; color: var(--admin-navy); margin: 0;">Hero Key Metrics Strip</h4>
                                <small style="color: var(--admin-text-muted);">Displayed inside the translucent floating card on the hero banner (Label & Value).</small>
                            </div>
                            <button type="button" id="add-metric-btn" class="btn btn-outline btn-sm">+ Add Metric</button>
                        </div>

                        <div id="metrics-container">
                            <?php foreach ($heroMetrics as $i => $metric): ?>
                                <div class="dynamic-row" style="display: grid; grid-template-columns: 1fr 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <input type="text" name="hero_metrics[<?= $i ?>][label]" class="form-control" value="<?= Format::e($metric['label'] ?? '') ?>" placeholder="Metric Label (e.g. Avg. Price/Sq.Yd)">
                                    <input type="text" name="hero_metrics[<?= $i ?>][value]" class="form-control" value="<?= Format::e($metric['value'] ?? '') ?>" placeholder="Metric Value (e.g. ₹12L - ₹18L)">
                                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;" title="Remove Metric">&times;</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: CHARACTER & MARKET ANALYSIS -->
            <div class="admin-tab-pane" id="tab-character">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 2: Residential Character & Market Analysis</h3>

                    <div class="form-group">
                        <label class="form-label" for="overview">The Residential Character (Lead Overview)</label>
                        <textarea name="overview" id="overview" class="form-control" rows="6" placeholder="Detailed architectural and enclave overview..."><?= Format::e($area['overview'] ?? '') ?></textarea>
                        <small class="form-text">Displayed on the left editorial column of Section 2.</small>
                    </div>

                    <!-- Character Highlights Visual Repeater -->
                    <div style="margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid var(--admin-border);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <div>
                                <h4 style="font-size: 0.95rem; font-weight: 600; color: var(--admin-navy); margin: 0;">Character Highlight Bullets</h4>
                                <small style="color: var(--admin-text-muted);">Pill badges displayed beneath the residential character narrative.</small>
                            </div>
                            <button type="button" id="add-highlight-btn" class="btn btn-outline btn-sm">+ Add Bullet</button>
                        </div>

                        <div id="highlights-container">
                            <?php foreach ($characterHighlights as $hl): ?>
                                <div class="dynamic-row" style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <input type="text" name="character_highlights[]" class="form-control" value="<?= Format::e($hl) ?>" placeholder="e.g. Strict Residential Zoning">
                                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;" title="Remove">&times;</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid var(--admin-border);">
                        <label class="form-label" for="property_market">Property & Market Analysis</label>
                        <textarea name="property_market" id="property_market" class="form-control" rows="6" placeholder="Market dynamics, supply-demand, land tenure, pricing insights..."><?= Format::e($area['property_market'] ?? '') ?></textarea>
                        <small class="form-text">Displayed on the right column of Section 2.</small>
                    </div>

                    <div class="form-group" style="margin-top: 1.25rem;">
                        <label class="form-label" for="fiduciary_note">Fiduciary Advisory Note / Editorial Quote</label>
                        <textarea name="fiduciary_note" id="fiduciary_note" class="form-control" rows="3" placeholder="Elite Homez maintains direct relationships with multi-generational resident owners..."><?= Format::e($area['fiduciary_note'] ?? '') ?></textarea>
                        <small class="form-text">Highlighted inside the shaded gold-bordered box at the base of the market analysis.</small>
                    </div>
                </div>
            </div>

            <!-- TAB 3: PROPERTY FORMATS & PLOT SIZES -->
            <div class="admin-tab-pane" id="tab-formats">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 3: Typical Property Formats</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="property_types_eyebrow">Section Eyebrow</label>
                            <input type="text" name="property_types_eyebrow" id="property_types_eyebrow" class="form-control" value="<?= Format::e($area['property_types_eyebrow'] ?? 'Residential Asset Categories') ?>" placeholder="e.g. Residential Asset Categories">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="property_types_title">Section Title</label>
                            <input type="text" name="property_types_title" id="property_types_title" class="form-control" value="<?= Format::e($area['property_types_title'] ?? ('Typical Property Formats in ' . $area['name'])) ?>" placeholder="e.g. Typical Property Formats in Vasant Vihar">
                        </div>
                    </div>

                    <!-- Property Types Visual Repeater -->
                    <div style="margin-top: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <strong style="font-size: 0.95rem; color: var(--admin-navy);">Property Format Cards (3-Column Layout)</strong>
                            <button type="button" id="add-format-btn" class="btn btn-outline btn-sm">+ Add Property Format</button>
                        </div>

                        <div id="formats-container">
                            <?php foreach ($propertyTypes as $i => $pt): ?>
                                <div class="dynamic-row" style="background: #FAF8F4; padding: 1.25rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 1rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                                        <strong style="color: var(--admin-navy); font-size: 0.9rem;">Format #<span class="format-num"><?= $i + 1 ?></span>: <?= Format::e($pt['title'] ?? 'New Format') ?></strong>
                                        <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">Remove Format &times;</button>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Format Title *</label>
                                        <input type="text" name="property_types[<?= $i ?>][title]" class="form-control" value="<?= Format::e($pt['title'] ?? '') ?>" placeholder="e.g. Independent Luxury Bungalows" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <textarea name="property_types[<?= $i ?>][description]" class="form-control" rows="2" placeholder="Detached multi-level private residences featuring..."><?= Format::e($pt['description'] ?? '') ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Buyer Profile / Spatial Allocation Note</label>
                                        <textarea name="property_types[<?= $i ?>][buyer_profile]" class="form-control" rows="2" placeholder="e.g. Prominent business families, industrial leaders..."><?= Format::e($pt['buyer_profile'] ?? '') ?></textarea>
                                    </div>
                                    <div class="grid-2">
                                        <div class="form-group">
                                            <label class="form-label">CTA Button Text</label>
                                            <input type="text" name="property_types[<?= $i ?>][cta_text]" class="form-control" value="<?= Format::e($pt['cta_text'] ?? 'Inquire for Off-Market Bungalows') ?>" placeholder="e.g. Inquire for Off-Market Bungalows">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">CTA Button Target Link</label>
                                            <input type="text" name="property_types[<?= $i ?>][cta_link]" class="form-control" value="<?= Format::e($pt['cta_link'] ?? '') ?>" placeholder="e.g. /contact-us?subject=...">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Plot Sizes -->
                <div class="admin-card" style="margin-top: 1.5rem;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 4: Typical Residential Plot Sizes</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="plot_sizes_eyebrow">Section Eyebrow</label>
                            <input type="text" name="plot_sizes_eyebrow" id="plot_sizes_eyebrow" class="form-control" value="<?= Format::e($area['plot_sizes_eyebrow'] ?? 'Spatial Typologies') ?>" placeholder="e.g. Spatial Typologies">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="plot_sizes_title">Section Title</label>
                            <input type="text" name="plot_sizes_title" id="plot_sizes_title" class="form-control" value="<?= Format::e($area['plot_sizes_title'] ?? ('Typical Residential Plot Sizes in ' . $area['name'])) ?>" placeholder="e.g. Typical Residential Plot Sizes in Vasant Vihar">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="plot_sizes_description">Plot Typologies Description Paragraph</label>
                        <textarea name="plot_sizes_description" id="plot_sizes_description" class="form-control" rows="2" placeholder="Residential parcels in this enclave follow structured allocations..."><?= Format::e($area['plot_sizes_description'] ?? '') ?></textarea>
                    </div>

                    <!-- Plot Sizes Visual Repeater -->
                    <div style="margin-top: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <strong style="font-size: 0.95rem; color: var(--admin-navy);">Plot Size Cards</strong>
                            <button type="button" id="add-plot-btn" class="btn btn-outline btn-sm">+ Add Plot Size</button>
                        </div>

                        <div id="plots-container">
                            <?php foreach ($plotSizes as $i => $plot): ?>
                                <div class="dynamic-row" style="background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                        <strong style="color: var(--admin-navy); font-size: 0.85rem;">Plot Size #<span class="plot-num"><?= $i + 1 ?></span></strong>
                                        <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                                    </div>
                                    <div class="grid-2">
                                        <div class="form-group">
                                            <label class="form-label" style="font-size: 0.8rem;">Typology Name</label>
                                            <input type="text" name="plot_sizes[<?= $i ?>][type]" class="form-control" value="<?= Format::e($plot['type'] ?? '') ?>" placeholder="e.g. Compact Enclave Plots">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" style="font-size: 0.8rem;">Footprint / Range</label>
                                            <input type="text" name="plot_sizes[<?= $i ?>][size]" class="form-control" value="<?= Format::e($plot['size'] ?? '') ?>" placeholder="e.g. 400 - 600 Sq. Yards">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label class="form-label" style="font-size: 0.8rem;">Typology Description</label>
                                        <textarea name="plot_sizes[<?= $i ?>][description]" class="form-control" rows="2" placeholder="Ideal for luxury duplex development or modern bespoke multi-level residences."><?= Format::e($plot['description'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: LIFESTYLE & TRANSIT -->
            <div class="admin-tab-pane" id="tab-lifestyle">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 5: Lifestyle & Community</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="lifestyle_eyebrow">Lifestyle Eyebrow</label>
                            <input type="text" name="lifestyle_eyebrow" id="lifestyle_eyebrow" class="form-control" value="<?= Format::e($area['lifestyle_eyebrow'] ?? 'Neighborhood Ambiance') ?>" placeholder="e.g. Neighborhood Ambiance">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="lifestyle_title">Lifestyle Title</label>
                            <input type="text" name="lifestyle_title" id="lifestyle_title" class="form-control" value="<?= Format::e($area['lifestyle_title'] ?? ('Lifestyle & Community in ' . $area['name'])) ?>" placeholder="e.g. Lifestyle & Community in Vasant Vihar">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="lifestyle">Lifestyle & Social Fabric Description</label>
                        <textarea name="lifestyle" id="lifestyle" class="form-control" rows="5" placeholder="Social environment, clubs, embassy culture, private parks..."><?= Format::e($area['lifestyle'] ?? '') ?></textarea>
                    </div>

                    <h3 style="font-size: 1.1rem; margin-top: 2rem; margin-bottom: 1.25rem; color: var(--admin-navy); padding-top: 1.25rem; border-top: 1px solid var(--admin-border);">Section 6: Connectivity & Arterial Transit</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="connectivity_eyebrow">Transit Eyebrow</label>
                            <input type="text" name="connectivity_eyebrow" id="connectivity_eyebrow" class="form-control" value="<?= Format::e($area['connectivity_eyebrow'] ?? 'Arterial Infrastructure') ?>" placeholder="e.g. Arterial Infrastructure">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="connectivity_title">Transit Title</label>
                            <input type="text" name="connectivity_title" id="connectivity_title" class="form-control" value="<?= Format::e($area['connectivity_title'] ?? 'Connectivity & Transit Links') ?>" placeholder="e.g. Connectivity & Transit Links">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="connectivity">Connectivity Description</label>
                        <textarea name="connectivity" id="connectivity" class="form-control" rows="4" placeholder="Access to Ring Road, Airport, Diplomatic Enclave, Metro lines..."><?= Format::e($area['connectivity'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="nearby_landmarks">Key Nearby Landmarks & Distances Box</label>
                        <textarea name="nearby_landmarks" id="nearby_landmarks" class="form-control" rows="3" placeholder="Basant Lok Community Centre (3 min), IGI Airport T3 (12 min), The Lodhi Club (18 min)..."><?= Format::e($area['nearby_landmarks'] ?? '') ?></textarea>
                        <small class="form-text">Displayed inside the shaded reference box under connectivity.</small>
                    </div>
                </div>
            </div>

            <!-- TAB 5: ADVISORY BANNER -->
            <div class="admin-tab-pane" id="tab-banner">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 7: Local Advisory Mid-Page Banner</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="banner_eyebrow">Banner Eyebrow</label>
                            <input type="text" name="banner_eyebrow" id="banner_eyebrow" class="form-control" value="<?= Format::e($area['banner_eyebrow'] ?? 'Elite Homez Private Office') ?>" placeholder="e.g. Elite Homez Private Office">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="banner_title">Banner Headline</label>
                            <input type="text" name="banner_title" id="banner_title" class="form-control" value="<?= Format::e($area['banner_title'] ?? 'Local Knowledge. Better Property Decisions.') ?>" placeholder="e.g. Local Knowledge. Better Property Decisions.">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="banner_description">Banner Narrative / Advisory Protocol</label>
                        <textarea name="banner_description" id="banner_description" class="form-control" rows="3" placeholder="Elite Homez maintains direct relationships with multi-generational resident owners..."><?= Format::e($area['banner_description'] ?? ($area['advisory_content'] ?? '')) ?></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="banner_btn1_text">Primary Button Text</label>
                            <input type="text" name="banner_btn1_text" id="banner_btn1_text" class="form-control" value="<?= Format::e($area['banner_btn1_text'] ?? 'Initiate Private Mandate') ?>" placeholder="e.g. Initiate Private Mandate">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="banner_btn1_url">Primary Button URL</label>
                            <input type="text" name="banner_btn1_url" id="banner_btn1_url" class="form-control" value="<?= Format::e($area['banner_btn1_url'] ?? '') ?>" placeholder="e.g. /contact-us?subject=Vasant+Vihar+Confidential+Advisory">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="banner_btn2_text">Secondary Button Text</label>
                            <input type="text" name="banner_btn2_text" id="banner_btn2_text" class="form-control" value="<?= Format::e($area['banner_btn2_text'] ?? 'Call Advisory Desk') ?>" placeholder="e.g. Call Advisory Desk">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="banner_btn2_url">Secondary Button URL</label>
                            <input type="text" name="banner_btn2_url" id="banner_btn2_url" class="form-control" value="<?= Format::e($area['banner_btn2_url'] ?? 'tel:+911149008800') ?>" placeholder="e.g. tel:+911149008800">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 6: FAQS (ACCORDION) -->
            <div class="admin-tab-pane" id="tab-faqs">
                <div class="admin-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                        <div>
                            <h3 style="font-size: 1.1rem; color: var(--admin-navy); margin: 0;">Section 8: Frequently Asked Questions</h3>
                            <small style="color: var(--admin-text-muted);">Expandable FAQ accordion powered by native details/summary semantics.</small>
                        </div>
                        <button type="button" id="add-faq-btn" class="btn btn-outline btn-sm">+ Add FAQ Item</button>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="faqs_eyebrow">FAQ Eyebrow</label>
                            <input type="text" name="faqs_eyebrow" id="faqs_eyebrow" class="form-control" value="<?= Format::e($area['faqs_eyebrow'] ?? 'Local Advisory Insights') ?>" placeholder="e.g. Local Advisory Insights">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="faqs_title">FAQ Title</label>
                            <input type="text" name="faqs_title" id="faqs_title" class="form-control" value="<?= Format::e($area['faqs_title'] ?? ('Frequently Asked Questions: ' . $area['name'])) ?>" placeholder="e.g. Frequently Asked Questions: Vasant Vihar">
                        </div>
                    </div>

                    <!-- FAQs Visual Repeater -->
                    <div id="faqs-container" style="margin-top: 1rem;">
                        <?php foreach ($faqs as $i => $faq): ?>
                            <div class="dynamic-row" style="background: #FAF8F4; padding: 1.25rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <strong style="color: var(--admin-navy); font-size: 0.9rem;">FAQ Item #<span class="faq-row-num"><?= $i + 1 ?></span></strong>
                                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">Remove FAQ &times;</button>
                                </div>
                                <div class="form-group" style="margin-bottom: 0.75rem;">
                                    <label class="form-label" style="font-size: 0.8rem;">Question *</label>
                                    <input type="text" name="faqs[<?= $i ?>][question]" class="form-control" value="<?= Format::e($faq['question'] ?? '') ?>" placeholder="e.g. What is the typical property structure available in Vasant Vihar?" required>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.8rem;">Answer *</label>
                                    <textarea name="faqs[<?= $i ?>][answer]" class="form-control" rows="3" placeholder="Detailed response for clients..." required><?= Format::e($faq['answer'] ?? '') ?></textarea>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- TAB 7: FINAL CTA -->
            <div class="admin-tab-pane" id="tab-cta">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 9: Final Call-to-Action</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="cta_eyebrow">CTA Eyebrow</label>
                            <input type="text" name="cta_eyebrow" id="cta_eyebrow" class="form-control" value="<?= Format::e($area['cta_eyebrow'] ?? 'Fiduciary Client Representation') ?>" placeholder="e.g. Fiduciary Client Representation">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cta_title">CTA Title</label>
                            <input type="text" name="cta_title" id="cta_title" class="form-control" value="<?= Format::e($area['cta_title'] ?? ('Begin Your Residential Search in ' . $area['name'])) ?>" placeholder="e.g. Begin Your Residential Search in Vasant Vihar">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cta_description">CTA Narrative</label>
                        <textarea name="cta_description" id="cta_description" class="form-control" rows="3" placeholder="Whether seeking an off-market independent bungalow or a bespoke modern builder floor..."><?= Format::e($area['cta_description'] ?? '') ?></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="cta_btn1_text">Primary Button Text</label>
                            <input type="text" name="cta_btn1_text" id="cta_btn1_text" class="form-control" value="<?= Format::e($area['cta_btn1_text'] ?? 'Share Your Requirement') ?>" placeholder="e.g. Share Your Requirement">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cta_btn1_url">Primary Button URL</label>
                            <input type="text" name="cta_btn1_url" id="cta_btn1_url" class="form-control" value="<?= Format::e($area['cta_btn1_url'] ?? '') ?>" placeholder="e.g. /contact-us?subject=Direct+Inquiry:+Vasant+Vihar">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="cta_btn2_text">Secondary Button Text</label>
                            <input type="text" name="cta_btn2_text" id="cta_btn2_text" class="form-control" value="<?= Format::e($area['cta_btn2_text'] ?? 'WhatsApp Advisory') ?>" placeholder="e.g. WhatsApp Advisory">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cta_btn2_url">Secondary Button URL</label>
                            <input type="text" name="cta_btn2_url" id="cta_btn2_url" class="form-control" value="<?= Format::e($area['cta_btn2_url'] ?? '') ?>" placeholder="e.g. https://wa.me/919811000000?text=...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar: Status, Images & SEO -->
        <div class="admin-form-sidebar">
            <!-- Publishing & Status -->
            <div class="admin-card">
                <h4 style="font-size: 0.95rem; font-weight: 600; color: var(--admin-navy); margin-bottom: 1rem;">Publishing & Display</h4>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1" <?= !empty($area['is_published']) ? 'checked' : '' ?> style="width: 18px; height: 18px; accent-color: var(--admin-navy);">
                        <span style="font-weight: 500; font-size: 0.9rem;">Published & Active</span>
                    </label>
                    <small class="form-text" style="margin-left: 26px;">When unchecked, location returns 404 and is hidden from menus.</small>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="show_on_home" value="1" <?= !empty($area['show_on_home']) ? 'checked' : '' ?> style="width: 18px; height: 18px; accent-color: var(--admin-navy);">
                        <span style="font-weight: 500; font-size: 0.9rem;">Show on Homepage Grid</span>
                    </label>
                    <small class="form-text" style="margin-left: 26px;">Features this location in the curated prime enclave carousel.</small>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label" for="sort_order">Sort Order (Monograph #)</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?= (int) ($area['sort_order'] ?? 1) ?>" min="1" max="999">
                    <small class="form-text">Determines numerical rank (e.g. 1 &rarr; Territory Monograph 01).</small>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="map_url">Google Maps Embed URL</label>
                    <input type="text" name="map_url" id="map_url" class="form-control" value="<?= Format::e($area['map_url'] ?? '') ?>" placeholder="https://maps.google.com/...">
                </div>
            </div>

            <!-- Hero Architectural Image -->
            <div class="admin-card" style="margin-top: 1.25rem;">
                <h4 style="font-size: 0.95rem; font-weight: 600; color: var(--admin-navy); margin-bottom: 1rem;">Hero Architectural Image</h4>

                <div style="margin-bottom: 1rem; border-radius: 4px; overflow: hidden; border: 1px solid var(--admin-border); background: #171A18;">
                    <img id="hero-img-preview" src="<?= $currHeroImgSrc ?>" alt="Hero Preview" style="width: 100%; height: 140px; object-fit: cover; display: block;">
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label" for="hero_image">Upload New Image File</label>
                    <input type="file" name="hero_image" id="hero_image" class="form-control" accept="image/*">
                    <small class="form-text">Recommended: 1920x1080px or higher, JPG/WEBP.</small>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label" for="hero_image_url">Or Image File Path / URL</label>
                    <input type="text" name="hero_image_url" id="hero_image_url" class="form-control" value="<?= Format::e($area['hero_image'] ?? '') ?>" placeholder="/assets/images/areas/vasant-vihar.jpg">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="hero_image_alt">Image Alt Text (SEO)</label>
                    <input type="text" name="hero_image_alt" id="hero_image_alt" class="form-control" value="<?= Format::e($area['hero_image_alt'] ?? ($area['name'] . ' Luxury Real Estate South Delhi')) ?>" placeholder="e.g. Vasant Vihar Luxury Real Estate South Delhi">
                </div>
            </div>

            <!-- SEO & Meta Tags -->
            <div class="admin-card" style="margin-top: 1.25rem;">
                <h4 style="font-size: 0.95rem; font-weight: 600; color: var(--admin-navy); margin-bottom: 1rem;">SEO & Meta Tags</h4>

                <div class="form-group">
                    <label class="form-label" for="seo_title">Meta Title</label>
                    <input type="text" name="seo_title" id="seo_title" class="form-control" value="<?= Format::e($area['seo_title'] ?? '') ?>" placeholder="e.g. Luxury Properties in Vasant Vihar | Elite Homez">
                </div>

                <div class="form-group">
                    <label class="form-label" for="meta_description">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="Discreet advisory representation for prime residential estates..."><?= Format::e($area['meta_description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="primary_keyword">Primary Keyword</label>
                    <input type="text" name="primary_keyword" id="primary_keyword" class="form-control" value="<?= Format::e($area['primary_keyword'] ?? '') ?>" placeholder="e.g. luxury property in vasant vihar">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="secondary_keywords">Secondary Keywords</label>
                    <input type="text" name="secondary_keywords" id="secondary_keywords" class="form-control" value="<?= Format::e($area['secondary_keywords'] ?? '') ?>" placeholder="builder floors, bungalows, vasant vihar estates">
                </div>
            </div>

            <!-- Sticky Save Changes -->
            <div style="margin-top: 1.25rem; display: flex; flex-direction: column; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.75rem;">
                    Save All Changes
                </button>
                <a href="<?= $baseUrl ?>/locations/<?= Format::e($area['slug']) ?>" target="_blank" class="btn btn-outline" style="width: 100%; justify-content: center;">
                    <?= SvgIcons::render('eye', 'w-3 h-3', 14) ?> Preview Live Page
                </a>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Tab Switching Logic
    const tabBtns = document.querySelectorAll('.admin-tab-btn');
    const tabPanes = document.querySelectorAll('.admin-tab-pane');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanes.forEach(p => p.classList.remove('active'));

            this.classList.add('active');
            const target = this.getAttribute('data-tab');
            const targetPane = document.getElementById(target);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        });
    });

    // 2. Generic row removal with delegation
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-row-btn')) {
            const row = e.target.closest('.dynamic-row');
            if (row) {
                row.remove();
            }
        }
    });

    // 3. Add Metric Item
    const addMetricBtn = document.getElementById('add-metric-btn');
    if (addMetricBtn) {
        addMetricBtn.addEventListener('click', function() {
            const container = document.getElementById('metrics-container');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'display: grid; grid-template-columns: 1fr 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;';
            div.innerHTML = `
                <input type="text" name="hero_metrics[${idx}][label]" class="form-control" placeholder="Metric Label (e.g. Zoning)">
                <input type="text" name="hero_metrics[${idx}][value]" class="form-control" placeholder="Metric Value (e.g. Low Density)">
                <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;" title="Remove">&times;</button>
            `;
            container.appendChild(div);
        });
    }

    // 4. Add Character Highlight Bullet
    const addHlBtn = document.getElementById('add-highlight-btn');
    if (addHlBtn) {
        addHlBtn.addEventListener('click', function() {
            const container = document.getElementById('highlights-container');
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'display: flex; gap: 0.5rem; margin-bottom: 0.5rem;';
            div.innerHTML = `
                <input type="text" name="character_highlights[]" class="form-control" placeholder="e.g. High Owner-Occupancy">
                <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;" title="Remove">&times;</button>
            `;
            container.appendChild(div);
        });
    }

    // 5. Add Property Format Card
    const addFormatBtn = document.getElementById('add-format-btn');
    if (addFormatBtn) {
        addFormatBtn.addEventListener('click', function() {
            const container = document.getElementById('formats-container');
            const count = container.querySelectorAll('.dynamic-row').length + 1;
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'background: #FAF8F4; padding: 1.25rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 1rem;';
            div.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <strong style="color: var(--admin-navy); font-size: 0.9rem;">Format #<span class="format-num">${count}</span>: New Format</strong>
                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">Remove Format &times;</button>
                </div>
                <div class="form-group">
                    <label class="form-label">Format Title *</label>
                    <input type="text" name="property_types[${idx}][title]" class="form-control" placeholder="e.g. Detached Heritage Bungalows" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="property_types[${idx}][description]" class="form-control" rows="2" placeholder="Detached multi-level private residences..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Buyer Profile / Spatial Allocation Note</label>
                    <textarea name="property_types[${idx}][buyer_profile]" class="form-control" rows="2" placeholder="Prominent business families and diplomatic missions..."></textarea>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">CTA Button Text</label>
                        <input type="text" name="property_types[${idx}][cta_text]" class="form-control" value="Inquire for Off-Market Assets" placeholder="CTA Text">
                    </div>
                    <div class="form-group">
                        <label class="form-label">CTA Button Target Link</label>
                        <input type="text" name="property_types[${idx}][cta_link]" class="form-control" value="/contact-us" placeholder="/contact-us">
                    </div>
                </div>
            `;
            container.appendChild(div);
        });
    }

    // 6. Add Plot Size Card
    const addPlotBtn = document.getElementById('add-plot-btn');
    if (addPlotBtn) {
        addPlotBtn.addEventListener('click', function() {
            const container = document.getElementById('plots-container');
            const count = container.querySelectorAll('.dynamic-row').length + 1;
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;';
            div.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <strong style="color: var(--admin-navy); font-size: 0.85rem;">Plot Size #<span class="plot-num">${count}</span></strong>
                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" style="font-size: 0.8rem;">Typology Name</label>
                        <input type="text" name="plot_sizes[${idx}][type]" class="form-control" placeholder="e.g. Standard Prime Plots">
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 0.8rem;">Footprint / Range</label>
                        <input type="text" name="plot_sizes[${idx}][size]" class="form-control" placeholder="e.g. 800 - 1,200 Sq. Yards">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-size: 0.8rem;">Typology Description</label>
                    <textarea name="plot_sizes[${idx}][description]" class="form-control" rows="2" placeholder="Description of architectural feasibility..."></textarea>
                </div>
            `;
            container.appendChild(div);
        });
    }

    // 7. Add FAQ Item
    const addFaqBtn = document.getElementById('add-faq-btn');
    if (addFaqBtn) {
        addFaqBtn.addEventListener('click', function() {
            const container = document.getElementById('faqs-container');
            const count = container.querySelectorAll('.dynamic-row').length + 1;
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'background: #FAF8F4; padding: 1.25rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 1rem;';
            div.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <strong style="color: var(--admin-navy); font-size: 0.9rem;">FAQ Item #<span class="faq-row-num">${count}</span></strong>
                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">Remove FAQ &times;</button>
                </div>
                <div class="form-group" style="margin-bottom: 0.75rem;">
                    <label class="form-label" style="font-size: 0.8rem;">Question *</label>
                    <input type="text" name="faqs[${idx}][question]" class="form-control" placeholder="e.g. Are properties in this enclave freehold?" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-size: 0.8rem;">Answer *</label>
                    <textarea name="faqs[${idx}][answer]" class="form-control" rows="3" placeholder="Detailed response for clients..." required></textarea>
                </div>
            `;
            container.appendChild(div);
        });
    }

    // 8. Live Hero Image File Preview
    const heroImageInput = document.getElementById('hero_image');
    const heroPreview = document.getElementById('hero-img-preview');
    if (heroImageInput && heroPreview) {
        heroImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    heroPreview.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
</script>
