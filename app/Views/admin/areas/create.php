<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];

// Starter defaults for smooth enclave creation
$defaultMetrics = [
    ['label' => 'Avg. Price/Sq.Yd', 'value' => '₹12L - ₹18L'],
    ['label' => 'Plot Footprints', 'value' => '400 - 2,000 Sq.Yd'],
    ['label' => 'Green Cover', 'value' => '42% (A-Grade)'],
    ['label' => 'Security', 'value' => 'Diplomatic A1']
];

$defaultHighlights = [
    'Strict Residential Zoning',
    'High Owner-Occupancy',
    'Off-Market Mandates'
];

$defaultPropertyTypes = [
    [
        'title' => 'Independent Luxury Bungalows',
        'description' => 'Detached multi-level private residences featuring generous front setbacks, perimeter security, landscaped wrap-around lawns, and multi-car parking.',
        'buyer_profile' => 'Prominent business families, industrial leaders, and diplomatic foreign missions seeking compound security.',
        'cta_text' => 'Inquire for Off-Market Bungalows',
        'cta_link' => '/contact-us?subject=Bungalow+Inquiry'
    ],
    [
        'title' => 'Full-Floor Luxury Builder Residences',
        'description' => 'Bespoke single-floor apartments measuring 3,500 to 8,000 sq ft, equipped with private high-speed elevators, imported Italian marble, and separate staff quarters.',
        'buyer_profile' => 'C-suite executives, senior corporate counsel, and luxury homeowners requiring effortless turnkey living.',
        'cta_text' => 'Explore Builder Floors',
        'cta_link' => '/properties'
    ],
    [
        'title' => 'Park-Facing Penthouses with Terraces',
        'description' => 'Top-tier duplex and single-level penthouse homes with exclusive roof rights, cantilevered pergolas, curated sky decks, and unobstructed views.',
        'buyer_profile' => 'Affluent entrepreneurs and NRI investors looking for distinctive architectural trophy assets.',
        'cta_text' => 'Request Penthouse Dossier',
        'cta_link' => '/contact-us?subject=Penthouse+Inquiry'
    ]
];

$defaultPlotSizes = [
    ['type' => 'Compact Enclave Plots', 'size' => '400 - 600 Sq. Yards', 'description' => 'Ideal for luxury duplex development or modern bespoke multi-level residences.'],
    ['type' => 'Standard Prime Plots', 'size' => '800 - 1,200 Sq. Yards', 'description' => 'The hallmark plot footprint supporting grand detached bungalows with expansive lawns.'],
    ['type' => 'Flagship Estate Plots', 'size' => '1,500 - 2,500+ Sq. Yards', 'description' => 'Rare landmark parcels offering total diplomatic security, perimeter shielding, and private pavilions.']
];

$defaultFaqs = [
    [
        'question' => "What is the typical property structure available in this enclave?",
        'answer' => "This enclave predominantly offers independent luxury builder floors (single-floor apartments on 400 to 1,200 sq. yard plots) and detached legacy bungalows."
    ],
    [
        'question' => "Are properties in this enclave freehold?",
        'answer' => "Yes, the vast majority of residential plots and builder floors in this enclave are freehold properties with registered conveyance deeds."
    ],
    [
        'question' => "How does Elite Homez verify property documentation?",
        'answer' => "Our legal advisory team conducts 30-year title searches, verifies chain of ownership, confirms sanctioned building plans, and reviews completion certificates."
    ]
];
?>

<form action="<?= $baseUrl ?>/admin/areas/store" method="POST" enctype="multipart/form-data">
    <?= Csrf::field() ?>

    <div class="admin-page-header">
        <div>
            <a href="<?= $baseUrl ?>/admin/areas" style="font-size: 0.85rem; color: var(--admin-text-muted); display: inline-flex; align-items: center; gap: 0.3rem;">
                &larr; Back to Locations
            </a>
            <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy); margin-top: 0.25rem;">Create New Prime Location / Enclave</h2>
            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 0;">Complete control over headings, text, metrics, property formats, plots, connectivity, FAQs, and buttons from head to bottom.</p>
        </div>
        <div class="admin-header-actions">
            <a href="<?= $baseUrl ?>/admin/areas" class="btn btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm">Create Location</button>
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
                            <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Sundar Nagar" required>
                            <small class="form-text">Primary geographical name of the micro-market.</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="slug">URL Slug (Leave blank to auto-generate)</label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="e.g. sundar-nagar">
                            <small class="form-text">Permalinks will be: <code>/locations/{slug}</code></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_monograph_text">Territory Monograph Badge (Top Overline)</label>
                        <input type="text" name="hero_monograph_text" id="hero_monograph_text" class="form-control" value="Territory Monograph 11 · South Delhi" placeholder="e.g. Territory Monograph 11 · South Delhi">
                        <small class="form-text">Displays above the main H1 with a luxury gold badge border.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_title">Hero H1 Headline *</label>
                        <input type="text" name="hero_title" id="hero_title" class="form-control" placeholder="e.g. Sundar Nagar: The Exclusive Enclave of Curated Elegance" required>
                        <small class="form-text">Main editorial headline on the cinematic hero banner.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_subtitle">Hero Subtitle Paragraph</label>
                        <textarea name="hero_subtitle" id="hero_subtitle" class="form-control" rows="2" placeholder="Benchmark South Delhi address defined by wide tree-canopied avenues and prime residential estates..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="short_description">Short Summary Description</label>
                        <textarea name="short_description" id="short_description" class="form-control" rows="2" placeholder="Short description used for homepage location cards and SEO excerpts..."></textarea>
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
                            <?php foreach ($defaultMetrics as $i => $metric): ?>
                                <div class="dynamic-row" style="display: grid; grid-template-columns: 1fr 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <input type="text" name="hero_metrics[<?= $i ?>][label]" class="form-control" value="<?= Format::e($metric['label']) ?>" placeholder="Metric Label (e.g. Avg. Price/Sq.Yd)">
                                    <input type="text" name="hero_metrics[<?= $i ?>][value]" class="form-control" value="<?= Format::e($metric['value']) ?>" placeholder="Metric Value (e.g. ₹12L - ₹18L)">
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
                        <textarea name="overview" id="overview" class="form-control" rows="6" placeholder="Detailed architectural and enclave overview celebrating tree canopies, prestigious residences, and historical prestige..."></textarea>
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
                            <?php foreach ($defaultHighlights as $hl): ?>
                                <div class="dynamic-row" style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <input type="text" name="character_highlights[]" class="form-control" value="<?= Format::e($hl) ?>" placeholder="e.g. Strict Residential Zoning">
                                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;" title="Remove">&times;</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid var(--admin-border);">
                        <label class="form-label" for="property_market">Property & Market Analysis</label>
                        <textarea name="property_market" id="property_market" class="form-control" rows="6" placeholder="Market dynamics, supply-demand, land tenure, pricing insights, and appreciation trends..."></textarea>
                        <small class="form-text">Displayed on the right column of Section 2.</small>
                    </div>

                    <div class="form-group" style="margin-top: 1.25rem;">
                        <label class="form-label" for="fiduciary_note">Fiduciary Advisory Note / Editorial Quote</label>
                        <textarea name="fiduciary_note" id="fiduciary_note" class="form-control" rows="3" placeholder="Elite Homez maintains direct relationships with multi-generational resident owners and premier developers in this enclave. We operate off-market to present verified residential assets with complete discretion."></textarea>
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
                            <input type="text" name="property_types_eyebrow" id="property_types_eyebrow" class="form-control" value="Residential Asset Categories" placeholder="e.g. Residential Asset Categories">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="property_types_title">Section Title</label>
                            <input type="text" name="property_types_title" id="property_types_title" class="form-control" placeholder="e.g. Typical Property Formats in Sundar Nagar">
                        </div>
                    </div>

                    <!-- Property Types Visual Repeater -->
                    <div style="margin-top: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <strong style="font-size: 0.95rem; color: var(--admin-navy);">Property Format Cards (3-Column Layout)</strong>
                            <button type="button" id="add-format-btn" class="btn btn-outline btn-sm">+ Add Property Format</button>
                        </div>

                        <div id="formats-container">
                            <?php foreach ($defaultPropertyTypes as $i => $pt): ?>
                                <div class="dynamic-row" style="background: #FAF8F4; padding: 1.25rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 1rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                                        <strong style="color: var(--admin-navy); font-size: 0.9rem;">Format #<span class="format-num"><?= $i + 1 ?></span>: <?= Format::e($pt['title']) ?></strong>
                                        <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">Remove Format &times;</button>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Format Title *</label>
                                        <input type="text" name="property_types[<?= $i ?>][title]" class="form-control" value="<?= Format::e($pt['title']) ?>" placeholder="e.g. Independent Luxury Bungalows" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <textarea name="property_types[<?= $i ?>][description]" class="form-control" rows="2"><?= Format::e($pt['description']) ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Buyer Profile / Spatial Allocation Note</label>
                                        <textarea name="property_types[<?= $i ?>][buyer_profile]" class="form-control" rows="2"><?= Format::e($pt['buyer_profile']) ?></textarea>
                                    </div>
                                    <div class="grid-2">
                                        <div class="form-group">
                                            <label class="form-label">CTA Button Text</label>
                                            <input type="text" name="property_types[<?= $i ?>][cta_text]" class="form-control" value="<?= Format::e($pt['cta_text']) ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">CTA Button Target Link</label>
                                            <input type="text" name="property_types[<?= $i ?>][cta_link]" class="form-control" value="<?= Format::e($pt['cta_link']) ?>">
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
                            <input type="text" name="plot_sizes_eyebrow" id="plot_sizes_eyebrow" class="form-control" value="Spatial Typologies" placeholder="e.g. Spatial Typologies">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="plot_sizes_title">Section Title</label>
                            <input type="text" name="plot_sizes_title" id="plot_sizes_title" class="form-control" placeholder="e.g. Typical Residential Plot Sizes in Sundar Nagar">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="plot_sizes_description">Plot Typologies Description Paragraph</label>
                        <textarea name="plot_sizes_description" id="plot_sizes_description" class="form-control" rows="2" placeholder="Residential parcels in this enclave follow structured town-planning allocations designed for privacy and luxury..."></textarea>
                    </div>

                    <!-- Plot Sizes Visual Repeater -->
                    <div style="margin-top: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <strong style="font-size: 0.95rem; color: var(--admin-navy);">Plot Size Cards</strong>
                            <button type="button" id="add-plot-btn" class="btn btn-outline btn-sm">+ Add Plot Size</button>
                        </div>

                        <div id="plots-container">
                            <?php foreach ($defaultPlotSizes as $i => $plot): ?>
                                <div class="dynamic-row" style="background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                        <strong style="color: var(--admin-navy); font-size: 0.85rem;">Plot Size #<span class="plot-num"><?= $i + 1 ?></span></strong>
                                        <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                                    </div>
                                    <div class="grid-2">
                                        <div class="form-group">
                                            <label class="form-label" style="font-size: 0.8rem;">Typology Name</label>
                                            <input type="text" name="plot_sizes[<?= $i ?>][type]" class="form-control" value="<?= Format::e($plot['type']) ?>" placeholder="e.g. Compact Enclave Plots">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" style="font-size: 0.8rem;">Footprint / Range</label>
                                            <input type="text" name="plot_sizes[<?= $i ?>][size]" class="form-control" value="<?= Format::e($plot['size']) ?>" placeholder="e.g. 400 - 600 Sq. Yards">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label class="form-label" style="font-size: 0.8rem;">Typology Description</label>
                                        <textarea name="plot_sizes[<?= $i ?>][description]" class="form-control" rows="2"><?= Format::e($plot['description']) ?></textarea>
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
                            <input type="text" name="lifestyle_eyebrow" id="lifestyle_eyebrow" class="form-control" value="Neighborhood Ambiance" placeholder="e.g. Neighborhood Ambiance">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="lifestyle_title">Lifestyle Title</label>
                            <input type="text" name="lifestyle_title" id="lifestyle_title" class="form-control" placeholder="e.g. Lifestyle & Community in Sundar Nagar">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="lifestyle">Lifestyle & Social Fabric Description</label>
                        <textarea name="lifestyle" id="lifestyle" class="form-control" rows="5" placeholder="Social environment, clubs, embassy culture, private parks, elite institutions..."></textarea>
                    </div>

                    <h3 style="font-size: 1.1rem; margin-top: 2rem; margin-bottom: 1.25rem; color: var(--admin-navy); padding-top: 1.25rem; border-top: 1px solid var(--admin-border);">Section 6: Connectivity & Arterial Transit</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="connectivity_eyebrow">Transit Eyebrow</label>
                            <input type="text" name="connectivity_eyebrow" id="connectivity_eyebrow" class="form-control" value="Arterial Infrastructure" placeholder="e.g. Arterial Infrastructure">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="connectivity_title">Transit Title</label>
                            <input type="text" name="connectivity_title" id="connectivity_title" class="form-control" value="Connectivity & Transit Links" placeholder="e.g. Connectivity & Transit Links">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="connectivity">Connectivity Description</label>
                        <textarea name="connectivity" id="connectivity" class="form-control" rows="4" placeholder="Access to Ring Road, Airport, Diplomatic Enclave, Central Secretariat, Metro corridors..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="nearby_landmarks">Key Nearby Landmarks & Distances Box</label>
                        <textarea name="nearby_landmarks" id="nearby_landmarks" class="form-control" rows="3" placeholder="Delhi Golf Club (5 min), Khan Market (8 min), India Gate (7 min), IGI Airport T3 (22 min)..."></textarea>
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
                            <input type="text" name="banner_eyebrow" id="banner_eyebrow" class="form-control" value="Elite Homez Private Office" placeholder="e.g. Elite Homez Private Office">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="banner_title">Banner Headline</label>
                            <input type="text" name="banner_title" id="banner_title" class="form-control" value="Local Knowledge. Better Property Decisions." placeholder="e.g. Local Knowledge. Better Property Decisions.">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="banner_description">Banner Narrative / Advisory Protocol</label>
                        <textarea name="banner_description" id="banner_description" class="form-control" rows="3" placeholder="Elite Homez maintains direct relationships with multi-generational resident owners and premier developers in this enclave. We operate off-market to present verified residential assets with complete discretion."></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="banner_btn1_text">Primary Button Text</label>
                            <input type="text" name="banner_btn1_text" id="banner_btn1_text" class="form-control" value="Initiate Private Mandate" placeholder="e.g. Initiate Private Mandate">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="banner_btn1_url">Primary Button URL</label>
                            <input type="text" name="banner_btn1_url" id="banner_btn1_url" class="form-control" placeholder="e.g. /contact-us?subject=Confidential+Advisory">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="banner_btn2_text">Secondary Button Text</label>
                            <input type="text" name="banner_btn2_text" id="banner_btn2_text" class="form-control" value="Call Advisory Desk" placeholder="e.g. Call Advisory Desk">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="banner_btn2_url">Secondary Button URL</label>
                            <input type="text" name="banner_btn2_url" id="banner_btn2_url" class="form-control" value="tel:+911149008800" placeholder="e.g. tel:+911149008800">
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
                            <input type="text" name="faqs_eyebrow" id="faqs_eyebrow" class="form-control" value="Local Advisory Insights" placeholder="e.g. Local Advisory Insights">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="faqs_title">FAQ Title</label>
                            <input type="text" name="faqs_title" id="faqs_title" class="form-control" placeholder="e.g. Frequently Asked Questions: Sundar Nagar">
                        </div>
                    </div>

                    <!-- FAQs Visual Repeater -->
                    <div id="faqs-container" style="margin-top: 1rem;">
                        <?php foreach ($defaultFaqs as $i => $faq): ?>
                            <div class="dynamic-row" style="background: #FAF8F4; padding: 1.25rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <strong style="color: var(--admin-navy); font-size: 0.9rem;">FAQ Item #<span class="faq-row-num"><?= $i + 1 ?></span></strong>
                                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">Remove FAQ &times;</button>
                                </div>
                                <div class="form-group" style="margin-bottom: 0.75rem;">
                                    <label class="form-label" style="font-size: 0.8rem;">Question *</label>
                                    <input type="text" name="faqs[<?= $i ?>][question]" class="form-control" value="<?= Format::e($faq['question']) ?>" placeholder="e.g. What is the typical property structure available?" required>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.8rem;">Answer *</label>
                                    <textarea name="faqs[<?= $i ?>][answer]" class="form-control" rows="3" placeholder="Detailed response for clients..." required><?= Format::e($faq['answer']) ?></textarea>
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
                            <input type="text" name="cta_eyebrow" id="cta_eyebrow" class="form-control" value="Fiduciary Client Representation" placeholder="e.g. Fiduciary Client Representation">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cta_title">CTA Title</label>
                            <input type="text" name="cta_title" id="cta_title" class="form-control" placeholder="e.g. Begin Your Residential Search in Sundar Nagar">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cta_description">CTA Narrative</label>
                        <textarea name="cta_description" id="cta_description" class="form-control" rows="3" placeholder="Whether seeking an off-market independent bungalow or a bespoke modern builder floor, Elite Homez provides verified confidential guidance."></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="cta_btn1_text">Primary Button Text</label>
                            <input type="text" name="cta_btn1_text" id="cta_btn1_text" class="form-control" value="Share Your Requirement" placeholder="e.g. Share Your Requirement">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cta_btn1_url">Primary Button URL</label>
                            <input type="text" name="cta_btn1_url" id="cta_btn1_url" class="form-control" placeholder="e.g. /contact-us?subject=Direct+Inquiry">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="cta_btn2_text">Secondary Button Text</label>
                            <input type="text" name="cta_btn2_text" id="cta_btn2_text" class="form-control" value="WhatsApp Advisory" placeholder="e.g. WhatsApp Advisory">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cta_btn2_url">Secondary Button URL</label>
                            <input type="text" name="cta_btn2_url" id="cta_btn2_url" class="form-control" placeholder="e.g. https://wa.me/919811000000">
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
                        <input type="checkbox" name="is_published" value="1" checked style="width: 18px; height: 18px; accent-color: var(--admin-navy);">
                        <span style="font-weight: 500; font-size: 0.9rem;">Published & Active</span>
                    </label>
                    <small class="form-text" style="margin-left: 26px;">When unchecked, location returns 404 and is hidden from menus.</small>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="show_on_home" value="1" checked style="width: 18px; height: 18px; accent-color: var(--admin-navy);">
                        <span style="font-weight: 500; font-size: 0.9rem;">Show on Homepage Grid</span>
                    </label>
                    <small class="form-text" style="margin-left: 26px;">Features this location in the curated prime enclave carousel.</small>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label" for="sort_order">Sort Order (Monograph #)</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="11" min="1" max="999">
                    <small class="form-text">Determines numerical rank (e.g. 11 &rarr; Territory Monograph 11).</small>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="map_url">Google Maps Embed URL</label>
                    <input type="text" name="map_url" id="map_url" class="form-control" placeholder="https://maps.google.com/...">
                </div>
            </div>

            <!-- Hero Architectural Image -->
            <div class="admin-card" style="margin-top: 1.25rem;">
                <h4 style="font-size: 0.95rem; font-weight: 600; color: var(--admin-navy); margin-bottom: 1rem;">Hero Architectural Image</h4>

                <div style="margin-bottom: 1rem; border-radius: 4px; overflow: hidden; border: 1px solid var(--admin-border); background: #171A18;">
                    <img id="hero-img-preview" src="<?= $baseUrl ?>/assets/images/areas/vasant-vihar.jpg" alt="Hero Preview" style="width: 100%; height: 140px; object-fit: cover; display: block;">
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label" for="hero_image">Upload Image File</label>
                    <input type="file" name="hero_image" id="hero_image" class="form-control" accept="image/*">
                    <small class="form-text">Recommended: 1920x1080px or higher, JPG/WEBP.</small>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label" for="hero_image_url">Or Image File Path / URL</label>
                    <input type="text" name="hero_image_url" id="hero_image_url" class="form-control" placeholder="/assets/images/areas/vasant-vihar.jpg">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="hero_image_alt">Image Alt Text (SEO)</label>
                    <input type="text" name="hero_image_alt" id="hero_image_alt" class="form-control" placeholder="e.g. Sundar Nagar Luxury Real Estate South Delhi">
                </div>
            </div>

            <!-- SEO & Meta Tags -->
            <div class="admin-card" style="margin-top: 1.25rem;">
                <h4 style="font-size: 0.95rem; font-weight: 600; color: var(--admin-navy); margin-bottom: 1rem;">SEO & Meta Tags</h4>

                <div class="form-group">
                    <label class="form-label" for="seo_title">Meta Title</label>
                    <input type="text" name="seo_title" id="seo_title" class="form-control" placeholder="e.g. Luxury Properties in Sundar Nagar | Elite Homez">
                </div>

                <div class="form-group">
                    <label class="form-label" for="meta_description">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="Discreet advisory representation for prime residential estates in Sundar Nagar, South Delhi."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="primary_keyword">Primary Keyword</label>
                    <input type="text" name="primary_keyword" id="primary_keyword" class="form-control" placeholder="e.g. luxury property in sundar nagar">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="secondary_keywords">Secondary Keywords</label>
                    <input type="text" name="secondary_keywords" id="secondary_keywords" class="form-control" placeholder="builder floors, bungalows, sundar nagar estates">
                </div>
            </div>

            <!-- Submit Button -->
            <div style="margin-top: 1.25rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.75rem;">
                    Create Location
                </button>
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
