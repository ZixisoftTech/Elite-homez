<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];

// Decode JSON structures with safe fallbacks
$approachStats = !empty($service['approach_stats']) ? (is_array($service['approach_stats']) ? $service['approach_stats'] : json_decode((string)$service['approach_stats'], true)) : [];
$deliverablesItems = !empty($service['deliverables_items']) ? (is_array($service['deliverables_items']) ? $service['deliverables_items'] : json_decode((string)$service['deliverables_items'], true)) : [];
$roadmapSteps = !empty($service['roadmap_steps']) ? (is_array($service['roadmap_steps']) ? $service['roadmap_steps'] : json_decode((string)$service['roadmap_steps'], true)) : [];
$whyPillars = !empty($service['why_pillars']) ? (is_array($service['why_pillars']) ? $service['why_pillars'] : json_decode((string)$service['why_pillars'], true)) : [];
$valuePropCheckmarks = !empty($service['value_prop_checkmarks']) ? (is_array($service['value_prop_checkmarks']) ? $service['value_prop_checkmarks'] : json_decode((string)$service['value_prop_checkmarks'], true)) : [];
$audienceProfiles = !empty($service['audience_profiles']) ? (is_array($service['audience_profiles']) ? $service['audience_profiles'] : json_decode((string)$service['audience_profiles'], true)) : [];
$faqsItems = !empty($service['faqs_items']) ? (is_array($service['faqs_items']) ? $service['faqs_items'] : json_decode((string)$service['faqs_items'], true)) : [];
$heroFeatures = !empty($service['hero_features']) ? (is_array($service['hero_features']) ? $service['hero_features'] : json_decode((string)$service['hero_features'], true)) : [];
if (empty($heroFeatures)) {
    $heroFeatures = ['South Delhi Enclaves', 'Zero Conflict of Interest', 'RERA Certified'];
}
$enquiryFeatures = !empty($service['enquiry_features']) ? (is_array($service['enquiry_features']) ? $service['enquiry_features'] : json_decode((string)$service['enquiry_features'], true)) : [];
if (empty($enquiryFeatures)) {
    $enquiryFeatures = ['Protected by bilateral non-disclosure covenants', 'Verified RERA Advisory Mandate (DLRERA2023A00892)', 'Direct Senior Partner Access Only'];
}
?>

<form action="<?= $baseUrl ?>/admin/services/update/<?= (int) $service['id'] ?>" method="POST" enctype="multipart/form-data">
    <?= Csrf::field() ?>

    <div class="admin-page-header">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy); margin: 0;">Edit: <?= Format::e($service['name']) ?></h2>
                <span class="badge" style="background: <?= !empty($service['is_published']) ? '#DCFCE7' : '#FEE2E2' ?>; color: <?= !empty($service['is_published']) ? '#166534' : '#991B1B' ?>;">
                    <?= !empty($service['is_published']) ? 'Active (Published)' : 'Draft (Inactive)' ?>
                </span>
            </div>
            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 0;">Complete control over headings, text, buttons, images, FAQs, and sections from head to bottom.</p>
        </div>
        <div class="admin-header-actions">
            <a href="<?= $baseUrl ?>/services/<?= Format::e($service['slug']) ?>" target="_blank" class="btn btn-outline btn-sm">
                <?= SvgIcons::render('eye', 'w-3 h-3', 14) ?> View Live Page
            </a>
            <a href="<?= $baseUrl ?>/admin/services" class="btn btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm">Save All Changes</button>
        </div>
    </div>

    <div class="admin-form-layout">
        <!-- Left Main Column: Section Tabs -->
        <div class="admin-form-main">
            <!-- Navigation Tabs -->
            <div class="admin-tabs" style="display: flex; flex-wrap: wrap; gap: 0.25rem; border-bottom: 1px solid var(--admin-border); margin-bottom: 1.25rem;">
                <button type="button" class="admin-tab-btn active" data-tab="tab-overview">1. Hero & Core</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-approach">2. The Approach</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-deliverables">3. What We Do</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-roadmap">4. Journey Roadmap</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-banner">5. Quotes & Why Us</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-valueprop">6. Value & Audiences</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-faqs">7. FAQs (Accordion)</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-cta">8. Enquiry & CTA</button>
            </div>

            <!-- TAB 1: HERO & CORE OVERVIEW -->
            <div class="admin-tab-pane active" id="tab-overview">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 1: Hero Identity, Headlines & Actions</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="name">Service Name / Title *</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= Format::e($service['name']) ?>" placeholder="e.g. Luxury Property Buying Advisory" required>
                            <small class="form-text">Split automatically across editorial serif lines on the live page.</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="slug">URL Slug (Custom Permalinks)</label>
                            <input type="text" name="slug" id="slug" class="form-control" value="<?= Format::e($service['slug']) ?>" placeholder="e.g. luxury-property-buying-advisory">
                            <small class="form-text">Live URL: <code>/services/<?= Format::e($service['slug']) ?></code></small>
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="hero_badge">Practice Mandate Badge / Overline</label>
                            <input type="text" name="hero_badge" id="hero_badge" class="form-control" value="<?= Format::e($service['hero_badge'] ?? '') ?>" placeholder="e.g. Practice Mandate 01 · Private Client Mandate">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="hero_tagline">Hero Header Micro-Tagline</label>
                            <input type="text" name="hero_tagline" id="hero_tagline" class="form-control" value="<?= Format::e($service['hero_tagline'] ?? 'ELITE HOMEZ · PRIVATE REAL ESTATE ADVISORY') ?>" placeholder="e.g. ELITE HOMEZ · PRIVATE REAL ESTATE ADVISORY">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="short_description">Executive Summary / Hero Lead Paragraph *</label>
                        <textarea name="short_description" id="short_description" class="form-control" rows="3" placeholder="Lead editorial paragraph displayed on hero and homepage cards..." required><?= Format::e($service['short_description']) ?></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="hero_cta_text">Primary Button Text</label>
                            <input type="text" name="hero_cta_text" id="hero_cta_text" class="form-control" value="<?= Format::e($service['hero_cta_text'] ?? 'Speak with an Advisor') ?>" placeholder="e.g. Speak with an Advisor">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="hero_cta_url">Primary Button URL / Target</label>
                            <input type="text" name="hero_cta_url" id="hero_cta_url" class="form-control" value="<?= Format::e($service['hero_cta_url'] ?? '#confidential-desk') ?>" placeholder="e.g. #confidential-desk or /contact-us">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="hero_fiduciary_title">Fiduciary Floating Card Title</label>
                            <input type="text" name="hero_fiduciary_title" id="hero_fiduciary_title" class="form-control" value="<?= Format::e($service['hero_fiduciary_title'] ?? 'Exclusive Buy-Side Mandate') ?>" placeholder="e.g. Exclusive Buy-Side Mandate">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="hero_fiduciary_badge">Floating Card Badge</label>
                            <input type="text" name="hero_fiduciary_badge" id="hero_fiduciary_badge" class="form-control" value="<?= Format::e($service['hero_fiduciary_badge'] ?? 'Zero Conflict') ?>" placeholder="e.g. Zero Conflict">
                        </div>
                    </div>

                    <!-- Hero Feature Bullets -->
                    <div class="form-group">
                        <label class="form-label">Hero Highlight Badges (Under Action Buttons)</label>
                        <div id="hero-features-container" class="space-y-2">
                            <?php foreach ($heroFeatures as $hIdx => $hFeat): ?>
                                <div class="dynamic-row" style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <input type="text" name="hero_features[]" class="form-control" value="<?= Format::e($hFeat) ?>" placeholder="e.g. South Delhi Enclaves">
                                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-hero-feature-btn" class="btn btn-outline btn-sm" style="margin-top: 0.5rem;">+ Add Highlight Badge</button>
                    </div>

                    <!-- Primary Hero Image -->
                    <div class="form-group" style="padding-top: 1rem; border-top: 1px solid var(--admin-border);">
                        <label class="form-label">Hero Architectural Portrait Image</label>
                        <?php if (!empty($service['image'])): ?>
                            <div style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 1rem;">
                                <img src="<?= $baseUrl . $service['image'] ?>" alt="Hero Preview" width="140" height="90" style="object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border);">
                                <div>
                                    <span style="font-size: 0.8rem; color: var(--admin-text-muted);">Current Image: <code><?= Format::e($service['image']) ?></code></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="grid-2">
                            <div>
                                <label class="form-label" for="image">Upload New File</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                            </div>
                            <div>
                                <label class="form-label" for="image_path">Or Direct Image Path / URL</label>
                                <input type="text" name="image_path" id="image_path" class="form-control" value="<?= Format::e($service['image']) ?>" placeholder="/assets/images/...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: THE APPROACH & STATS -->
            <div class="admin-tab-pane" id="tab-approach">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 2: The Elite Homez Approach</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="approach_eyebrow">Section Eyebrow</label>
                            <input type="text" name="approach_eyebrow" id="approach_eyebrow" class="form-control" value="<?= Format::e($service['approach_eyebrow'] ?? 'The Elite Homez Approach') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="approach_title">Main Headline</label>
                            <input type="text" name="approach_title" id="approach_title" class="form-control" value="<?= Format::e($service['approach_title'] ?? 'Property decisions deserve a more personal, discreet approach.') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="approach_description">Philosophy &amp; Strategic Value Proposition</label>
                        <textarea name="approach_description" id="approach_description" class="form-control" rows="6" placeholder="Paragraphs explaining the philosophy and fiduciary positioning for this service..."><?= Format::e($service['approach_description'] ?? '') ?></textarea>
                    </div>

                    <!-- Approach Stats Repeater -->
                    <div class="form-group">
                        <label class="form-label">Key Authority Metrics / Stat Badges</label>
                        <div id="approach-stats-container">
                            <?php foreach ($approachStats as $sIdx => $st): ?>
                                <div class="dynamic-row" style="display: grid; grid-template-columns: 140px 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <input type="text" name="approach_stats[<?= $sIdx ?>][value]" class="form-control" value="<?= Format::e($st['value'] ?? '') ?>" placeholder="e.g. 100%">
                                    <input type="text" name="approach_stats[<?= $sIdx ?>][label]" class="form-control" value="<?= Format::e($st['label'] ?? '') ?>" placeholder="e.g. Buyer Aligned">
                                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-stat-btn" class="btn btn-outline btn-sm" style="margin-top: 0.5rem;">+ Add Stat Badge</button>
                    </div>
                </div>
            </div>

            <!-- TAB 3: WHAT WE DO (DELIVERABLES) -->
            <div class="admin-tab-pane" id="tab-deliverables">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 3: What We Do (Systematic Due Diligence)</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="deliverables_eyebrow">Section Eyebrow</label>
                            <input type="text" name="deliverables_eyebrow" id="deliverables_eyebrow" class="form-control" value="<?= Format::e($service['deliverables_eyebrow'] ?? 'Systematic Due Diligence') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="deliverables_title">Headline</label>
                            <input type="text" name="deliverables_title" id="deliverables_title" class="form-control" value="<?= Format::e($service['deliverables_title'] ?? 'What We Do') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="deliverables_subtitle">Subtitle / Overview Description</label>
                        <input type="text" name="deliverables_subtitle" id="deliverables_subtitle" class="form-control" value="<?= Format::e($service['deliverables_subtitle'] ?? 'A rigorous, institutional methodology tailored specifically to high-value residential acquisitions.') ?>">
                    </div>

                    <!-- Deliverables Repeater -->
                    <div class="form-group">
                        <label class="form-label">Deliverables / Methodology Steps</label>
                        <div id="deliverables-container">
                            <?php foreach ($deliverablesItems as $dIdx => $dItem): ?>
                                <div class="dynamic-row" style="background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;">
                                    <div style="display: grid; grid-template-columns: 80px 1fr 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                                        <input type="text" name="deliverables_items[<?= $dIdx ?>][num]" class="form-control" value="<?= Format::e($dItem['num'] ?? sprintf('%02d', $dIdx + 1)) ?>" placeholder="01">
                                        <input type="text" name="deliverables_items[<?= $dIdx ?>][title]" class="form-control" value="<?= Format::e($dItem['title'] ?? '') ?>" placeholder="Step Title">
                                        <input type="text" name="deliverables_items[<?= $dIdx ?>][tag]" class="form-control" value="<?= Format::e($dItem['tag'] ?? '') ?>" placeholder="Tag / Category">
                                        <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                                    </div>
                                    <textarea name="deliverables_items[<?= $dIdx ?>][desc]" class="form-control" rows="2" placeholder="Detailed step description..."><?= Format::e($dItem['desc'] ?? '') ?></textarea>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-deliverable-btn" class="btn btn-outline btn-sm" style="margin-top: 0.5rem;">+ Add Methodology Step</button>
                    </div>

                    <div class="form-group" style="padding-top: 1rem; border-top: 1px solid var(--admin-border);">
                        <label class="form-label" for="content">Executive Practice Briefing Box (Optional Rich Content)</label>
                        <textarea name="content" id="content" class="form-control" rows="6" placeholder="Additional background description displayed in executive briefing box..."><?= Format::e($service['content'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- TAB 4: JOURNEY ROADMAP -->
            <div class="admin-tab-pane" id="tab-roadmap">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 4: Acquisition & Mandate Journey Roadmap</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="roadmap_eyebrow">Roadmap Eyebrow</label>
                            <input type="text" name="roadmap_eyebrow" id="roadmap_eyebrow" class="form-control" value="<?= Format::e($service['roadmap_eyebrow'] ?? 'Acquisition Roadmap') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="roadmap_title">Roadmap Title</label>
                            <input type="text" name="roadmap_title" id="roadmap_title" class="form-control" value="<?= Format::e($service['roadmap_title'] ?? 'From Requirement to Handover') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="roadmap_subtitle">Roadmap Subtitle</label>
                        <input type="text" name="roadmap_subtitle" id="roadmap_subtitle" class="form-control" value="<?= Format::e($service['roadmap_subtitle'] ?? 'A structured journey engineered for absolute peace of mind and decisive execution.') ?>">
                    </div>

                    <!-- Roadmap Repeater -->
                    <div class="form-group">
                        <label class="form-label">Roadmap Milestone Stages</label>
                        <div id="roadmap-container">
                            <?php foreach ($roadmapSteps as $rIdx => $rStep): ?>
                                <div class="dynamic-row" style="background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;">
                                    <div style="display: grid; grid-template-columns: 80px 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                                        <input type="text" name="roadmap_steps[<?= $rIdx ?>][step]" class="form-control" value="<?= Format::e($rStep['step'] ?? sprintf('%02d', $rIdx + 1)) ?>" placeholder="01">
                                        <input type="text" name="roadmap_steps[<?= $rIdx ?>][title]" class="form-control" value="<?= Format::e($rStep['title'] ?? '') ?>" placeholder="Stage Name">
                                        <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                                    </div>
                                    <textarea name="roadmap_steps[<?= $rIdx ?>][desc]" class="form-control" rows="2" placeholder="Stage description..."><?= Format::e($rStep['desc'] ?? '') ?></textarea>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-roadmap-btn" class="btn btn-outline btn-sm" style="margin-top: 0.5rem;">+ Add Roadmap Stage</button>
                    </div>
                </div>
            </div>

            <!-- TAB 5: QUOTES & WHY US -->
            <div class="admin-tab-pane" id="tab-banner">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 5: Architectural Quote & Why Elite Homez</h3>

                    <h4 style="font-size: 0.95rem; color: var(--admin-gold); margin-bottom: 0.75rem;">A. Parallax Architectural Quote Banner</h4>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="banner_tag">Quote Eyebrow Tag</label>
                            <input type="text" name="banner_tag" id="banner_tag" class="form-control" value="<?= Format::e($service['banner_tag'] ?? 'Perspective · Discernment · Heritage') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="banner_btn_text">Banner Button Text</label>
                            <input type="text" name="banner_btn_text" id="banner_btn_text" class="form-control" value="<?= Format::e($service['banner_btn_text'] ?? 'Request A Private Briefing') ?>">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="banner_btn_url">Banner Button Target URL</label>
                            <input type="text" name="banner_btn_url" id="banner_btn_url" class="form-control" value="<?= Format::e($service['banner_btn_url'] ?? '#confidential-desk') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="banner_image_url">Banner Background Image URL</label>
                            <input type="text" name="banner_image_url" id="banner_image_url" class="form-control" value="<?= Format::e($service['banner_image'] ?? '') ?>" placeholder="/assets/images/...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="banner_image">Or Upload Banner Image</label>
                        <input type="file" name="banner_image" id="banner_image" class="form-control" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="banner_quote">Large Editorial Quote *</label>
                        <input type="text" name="banner_quote" id="banner_quote" class="form-control" value="<?= Format::e($service['banner_quote'] ?? '“Access matters. Judgement matters more.”') ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="banner_subquote">Subquote / Guiding Principle</label>
                        <textarea name="banner_subquote" id="banner_subquote" class="form-control" rows="2"><?= Format::e($service['banner_subquote'] ?? 'Our role is not simply to show you property. It is to help you make an enduring, generational decision anchored in long-term value.') ?></textarea>
                    </div>

                    <h4 style="font-size: 0.95rem; color: var(--admin-gold); margin: 1.5rem 0 0.75rem;">B. Why Elite Homez Institutional Authority</h4>
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label" for="why_eyebrow">Section Eyebrow</label>
                            <input type="text" name="why_eyebrow" id="why_eyebrow" class="form-control" value="<?= Format::e($service['why_eyebrow'] ?? 'Fiduciary Excellence') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="why_title">Title</label>
                            <input type="text" name="why_title" id="why_title" class="form-control" value="<?= Format::e($service['why_title'] ?? 'Why Elite Homez') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="why_subtitle">Subtitle</label>
                            <input type="text" name="why_subtitle" id="why_subtitle" class="form-control" value="<?= Format::e($service['why_subtitle'] ?? 'Experience, absolute discretion, and a deeper understanding of exceptional Delhi real estate.') ?>">
                        </div>
                    </div>

                    <!-- Why Pillars Repeater -->
                    <div class="form-group">
                        <label class="form-label">Authority Pillars Grid</label>
                        <div id="why-pillars-container">
                            <?php foreach ($whyPillars as $wIdx => $wPillar): ?>
                                <div class="dynamic-row" style="background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;">
                                    <div style="display: grid; grid-template-columns: 80px 140px 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                                        <input type="text" name="why_pillars[<?= $wIdx ?>][num]" class="form-control" value="<?= Format::e($wPillar['num'] ?? sprintf('%02d', $wIdx + 1)) ?>" placeholder="01">
                                        <input type="text" name="why_pillars[<?= $wIdx ?>][icon]" class="form-control" value="<?= Format::e($wPillar['icon'] ?? 'verified_user') ?>" placeholder="Material Icon">
                                        <input type="text" name="why_pillars[<?= $wIdx ?>][title]" class="form-control" value="<?= Format::e($wPillar['title'] ?? '') ?>" placeholder="Pillar Title">
                                        <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                                    </div>
                                    <textarea name="why_pillars[<?= $wIdx ?>][desc]" class="form-control" rows="2" placeholder="Pillar description..."><?= Format::e($wPillar['desc'] ?? '') ?></textarea>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-why-pillar-btn" class="btn btn-outline btn-sm" style="margin-top: 0.5rem;">+ Add Authority Pillar</button>
                    </div>
                </div>
            </div>

            <!-- TAB 6: VALUE & AUDIENCES -->
            <div class="admin-tab-pane" id="tab-valueprop">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 6: Value Proposition & Tailored Audiences</h3>

                    <h4 style="font-size: 0.95rem; color: var(--admin-gold); margin-bottom: 0.75rem;">A. Value Proposition & Showcase Case Study</h4>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="value_prop_eyebrow">Eyebrow</label>
                            <input type="text" name="value_prop_eyebrow" id="value_prop_eyebrow" class="form-control" value="<?= Format::e($service['value_prop_eyebrow'] ?? 'Beyond Brokering') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="value_prop_title">Title</label>
                            <input type="text" name="value_prop_title" id="value_prop_title" class="form-control" value="<?= Format::e($service['value_prop_title'] ?? 'More than a property transaction. An enduring generational asset.') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="value_prop_body">Value Proposition Detailed Body</label>
                        <textarea name="value_prop_body" id="value_prop_body" class="form-control" rows="4"><?= Format::e($service['value_prop_body'] ?? '') ?></textarea>
                    </div>

                    <!-- Value Prop Checkmarks -->
                    <div class="form-group">
                        <label class="form-label">Key Commitments (Checkmark Bullets)</label>
                        <div id="checkmarks-container">
                            <?php foreach ($valuePropCheckmarks as $cVal): ?>
                                <div class="dynamic-row" style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <input type="text" name="value_prop_checkmarks[]" class="form-control" value="<?= Format::e($cVal) ?>" placeholder="e.g. Independent Valuations">
                                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-checkmark-btn" class="btn btn-outline btn-sm" style="margin-top: 0.5rem;">+ Add Commitment Bullet</button>
                    </div>

                    <!-- Showcase Image -->
                    <div class="grid-2" style="padding-top: 1rem; border-top: 1px solid var(--admin-border);">
                        <div class="form-group">
                            <label class="form-label" for="showcase_caption">Showcase Image Caption</label>
                            <input type="text" name="showcase_caption" id="showcase_caption" class="form-control" value="<?= Format::e($service['showcase_caption'] ?? 'Private Residence · Vasant Vihar') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="showcase_tag">Showcase Tag / Badge</label>
                            <input type="text" name="showcase_tag" id="showcase_tag" class="form-control" value="<?= Format::e($service['showcase_tag'] ?? 'Curated Acquisition') ?>">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="showcase_image">Upload Showcase Image</label>
                            <input type="file" name="showcase_image" id="showcase_image" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="showcase_image_url">Or Direct Showcase Image URL</label>
                            <input type="text" name="showcase_image_url" id="showcase_image_url" class="form-control" value="<?= Format::e($service['showcase_image'] ?? '') ?>" placeholder="/assets/images/...">
                        </div>
                    </div>

                    <h4 style="font-size: 0.95rem; color: var(--admin-gold); margin: 1.5rem 0 0.75rem;">B. Tailored Client Desks (Who We Help)</h4>
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label" for="audience_eyebrow">Eyebrow</label>
                            <input type="text" name="audience_eyebrow" id="audience_eyebrow" class="form-control" value="<?= Format::e($service['audience_eyebrow'] ?? 'Tailored Client Desks') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="audience_title">Title</label>
                            <input type="text" name="audience_title" id="audience_title" class="form-control" value="<?= Format::e($service['audience_title'] ?? 'Who We Help') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="audience_subtitle">Subtitle</label>
                            <input type="text" name="audience_subtitle" id="audience_subtitle" class="form-control" value="<?= Format::e($service['audience_subtitle'] ?? 'Our advisory practice is crafted specifically for discerning purchasers with distinct governance criteria.') ?>">
                        </div>
                    </div>

                    <!-- Audiences Repeater -->
                    <div class="form-group">
                        <label class="form-label">Audience Profiles Grid</label>
                        <div id="audiences-container">
                            <?php foreach ($audienceProfiles as $aIdx => $aProf): ?>
                                <div class="dynamic-row" style="background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;">
                                    <div style="display: grid; grid-template-columns: 140px 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                                        <input type="text" name="audience_profiles[<?= $aIdx ?>][icon]" class="form-control" value="<?= Format::e($aProf['icon'] ?? 'home') ?>" placeholder="e.g. home, account_balance">
                                        <input type="text" name="audience_profiles[<?= $aIdx ?>][title]" class="form-control" value="<?= Format::e($aProf['title'] ?? '') ?>" placeholder="e.g. Private Home Buyers">
                                        <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                                    </div>
                                    <textarea name="audience_profiles[<?= $aIdx ?>][desc]" class="form-control" rows="2" placeholder="Audience profile description..."><?= Format::e($aProf['desc'] ?? '') ?></textarea>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-audience-btn" class="btn btn-outline btn-sm" style="margin-top: 0.5rem;">+ Add Audience Profile</button>
                    </div>
                </div>
            </div>

            <!-- TAB 7: FREQUENTLY ASKED QUESTIONS (FAQS) -->
            <div class="admin-tab-pane" id="tab-faqs">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 7: Frequently Asked Questions (Interactive Accordion)</h3>
                    <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.25rem;">Add, edit, and reorder service-specific FAQs that render as an interactive luxury accordion on the public page.</p>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="faqs_eyebrow">FAQ Eyebrow</label>
                            <input type="text" name="faqs_eyebrow" id="faqs_eyebrow" class="form-control" value="<?= Format::e($service['faqs_eyebrow'] ?? 'Bespoke Guidance & Clarity') ?>" placeholder="e.g. Bespoke Guidance & Clarity">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="faqs_title">FAQ Section Title</label>
                            <input type="text" name="faqs_title" id="faqs_title" class="form-control" value="<?= Format::e($service['faqs_title'] ?? 'Frequently Asked Questions') ?>" placeholder="e.g. Frequently Asked Questions">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="faqs_subtitle">FAQ Subtitle / Introduction</label>
                        <input type="text" name="faqs_subtitle" id="faqs_subtitle" class="form-control" value="<?= Format::e($service['faqs_subtitle'] ?? 'Clear answers to the most common questions regarding our private advisory services and confidential engagement process.') ?>">
                    </div>

                    <!-- FAQs Repeater -->
                    <div class="form-group">
                        <label class="form-label">Questions &amp; Comprehensive Answers</label>
                        <div id="faqs-container">
                            <?php foreach ($faqsItems as $fIdx => $faq): ?>
                                <div class="dynamic-row" style="background: #FAF8F4; padding: 1.25rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 1rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                        <strong style="color: var(--admin-navy); font-size: 0.9rem;">FAQ Item #<span class="faq-row-num"><?= $fIdx + 1 ?></span></strong>
                                        <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">Remove FAQ &times;</button>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0.75rem;">
                                        <label class="form-label" style="font-size: 0.8rem;">Question *</label>
                                        <input type="text" name="faqs_items[<?= $fIdx ?>][question]" class="form-control" value="<?= Format::e($faq['question'] ?? '') ?>" placeholder="e.g. How does the private acquisition advisory mandate work?" required>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label class="form-label" style="font-size: 0.8rem;">Answer *</label>
                                        <textarea name="faqs_items[<?= $fIdx ?>][answer]" class="form-control" rows="3" placeholder="Detailed response for clients..." required><?= Format::e($faq['answer'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-faq-btn" class="btn btn-outline btn-sm" style="margin-top: 0.5rem;">+ Add New FAQ Item</button>
                    </div>
                </div>
            </div>

            <!-- TAB 8: ENQUIRY DESK & BOTTOM CTA -->
            <div class="admin-tab-pane" id="tab-cta">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 8: Confidential Enquiry Desk &amp; Bottom Cinematic CTA</h3>

                    <h4 style="font-size: 0.95rem; color: var(--admin-gold); margin-bottom: 0.75rem;">A. Confidential Enquiry Desk (Lead Conversion)</h4>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="enquiry_eyebrow">Enquiry Eyebrow</label>
                            <input type="text" name="enquiry_eyebrow" id="enquiry_eyebrow" class="form-control" value="<?= Format::e($service['enquiry_eyebrow'] ?? 'Confidential Dialogue') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="enquiry_title">Enquiry Title</label>
                            <input type="text" name="enquiry_title" id="enquiry_title" class="form-control" value="<?= Format::e($service['enquiry_title'] ?? 'Initiate a Private Advisory Briefing') ?>">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="enquiry_description">Enquiry Lead Description</label>
                            <textarea name="enquiry_description" id="enquiry_description" class="form-control" rows="3"><?= Format::e($service['enquiry_description'] ?? 'Share your parameters. A designated Elite Homez Senior Partner will contact you under strict bilateral confidentiality.') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="enquiry_btn_text">Submit Button Text</label>
                            <input type="text" name="enquiry_btn_text" id="enquiry_btn_text" class="form-control" value="<?= Format::e($service['enquiry_btn_text'] ?? 'Submit Confidential Mandate') ?>">
                        </div>
                    </div>

                    <!-- Enquiry Features Bullets -->
                    <div class="form-group">
                        <label class="form-label">Trust &amp; Compliance Badges (Beside Form)</label>
                        <div id="enquiry-features-container">
                            <?php foreach ($enquiryFeatures as $eIdx => $eFeat): ?>
                                <div class="dynamic-row" style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <input type="text" name="enquiry_features[]" class="form-control" value="<?= Format::e($eFeat) ?>" placeholder="e.g. Protected by bilateral non-disclosure covenants">
                                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-enquiry-feature-btn" class="btn btn-outline btn-sm" style="margin-top: 0.5rem;">+ Add Trust Badge</button>
                    </div>

                    <h4 style="font-size: 0.95rem; color: var(--admin-gold); margin: 1.5rem 0 0.75rem;">B. Bottom Cinematic Call To Action</h4>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="cta_eyebrow">CTA Eyebrow</label>
                            <input type="text" name="cta_eyebrow" id="cta_eyebrow" class="form-control" value="<?= Format::e($service['cta_eyebrow'] ?? 'Elite Homez Advisory') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cta_title">CTA Headline</label>
                            <input type="text" name="cta_title" id="cta_title" class="form-control" value="<?= Format::e($service['cta_title'] ?? 'The right property starts with the right advice.') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cta_subtitle">CTA Subtitle</label>
                        <textarea name="cta_subtitle" id="cta_subtitle" class="form-control" rows="2"><?= Format::e($service['cta_subtitle'] ?? 'Discover a more considered, confidential way to navigate premier Delhi NCR real estate.') ?></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="cta_btn1_text">Button 1 Text</label>
                            <input type="text" name="cta_btn1_text" id="cta_btn1_text" class="form-control" value="<?= Format::e($service['cta_btn1_text'] ?? 'Explore Properties Catalogue') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cta_btn1_url">Button 1 Target URL</label>
                            <input type="text" name="cta_btn1_url" id="cta_btn1_url" class="form-control" value="<?= Format::e($service['cta_btn1_url'] ?? '/properties') ?>">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="cta_btn2_text">Button 2 Text</label>
                            <input type="text" name="cta_btn2_text" id="cta_btn2_text" class="form-control" value="<?= Format::e($service['cta_btn2_text'] ?? 'Contact Advisory Desk') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cta_btn2_url">Button 2 Target URL</label>
                            <input type="text" name="cta_btn2_url" id="cta_btn2_url" class="form-control" value="<?= Format::e($service['cta_btn2_url'] ?? '/contact-us') ?>">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="cta_image">Upload Background Image</label>
                            <input type="file" name="cta_image" id="cta_image" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cta_image_url">Or Direct Image URL</label>
                            <input type="text" name="cta_image_url" id="cta_image_url" class="form-control" value="<?= Format::e($service['cta_image'] ?? '') ?>" placeholder="/assets/images/stitch/service-cta-dusk.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar: Publishing Settings -->
        <div class="admin-form-side">
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.05rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Visibility &amp; State</h3>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.6rem; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1" <?= !empty($service['is_published']) ? 'checked' : '' ?> style="width: 18px; height: 18px;">
                        <div>
                            <strong style="color: var(--admin-navy); font-size: 0.95rem;">Active (Published)</strong>
                            <div style="font-size: 0.75rem; color: var(--admin-text-muted);">When unchecked, service returns 404 and is hidden from navigation.</div>
                        </div>
                    </label>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.6rem; cursor: pointer;">
                        <input type="checkbox" name="show_on_home" value="1" <?= !empty($service['show_on_home']) ? 'checked' : '' ?> style="width: 18px; height: 18px;">
                        <div>
                            <strong style="color: var(--admin-navy); font-size: 0.95rem;">Show on Homepage</strong>
                            <div style="font-size: 0.75rem; color: var(--admin-text-muted);">Displays this practice on the primary website homepage.</div>
                        </div>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label" for="sort_order">Display Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?= (int) $service['sort_order'] ?>">
                    <small class="form-text">Lower numbers appear first (e.g. 1, 2, 3).</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="icon">Material / SVG Icon</label>
                    <input type="text" name="icon" id="icon" class="form-control" value="<?= Format::e($service['icon'] ?? 'compass') ?>" placeholder="compass, home, award, shield...">
                </div>

                <div style="padding-top: 1rem; border-top: 1px solid var(--admin-border);">
                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 0.5rem;">Save All Changes</button>
                    <a href="<?= $baseUrl ?>/services/<?= Format::e($service['slug']) ?>" target="_blank" class="btn btn-outline" style="width: 100%; text-align: center;">View Public Page</a>
                </div>
            </div>

            <div class="admin-card">
                <h3 style="font-size: 1.05rem; margin-bottom: 1.25rem; color: var(--admin-navy);">SEO &amp; Meta Tags</h3>

                <div class="form-group">
                    <label class="form-label" for="seo_title">SEO Meta Title</label>
                    <input type="text" name="seo_title" id="seo_title" class="form-control" value="<?= Format::e($service['seo_title']) ?>" placeholder="Defaults to service name if blank">
                </div>

                <div class="form-group">
                    <label class="form-label" for="meta_description">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="4"><?= Format::e($service['meta_description']) ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    document.querySelectorAll('.admin-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.admin-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.admin-tab-pane').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            const targetPane = document.getElementById(btn.dataset.tab);
            if (targetPane) targetPane.classList.add('active');
        });
    });

    // Remove row event delegation
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-row-btn')) {
            const row = e.target.closest('.dynamic-row');
            if (row) row.remove();
        }
    });

    // 1. Add Hero Feature
    const addHeroFeatureBtn = document.getElementById('add-hero-feature-btn');
    if (addHeroFeatureBtn) {
        addHeroFeatureBtn.addEventListener('click', function() {
            const container = document.getElementById('hero-features-container');
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'display: flex; gap: 0.5rem; margin-bottom: 0.5rem;';
            div.innerHTML = `
                <input type="text" name="hero_features[]" class="form-control" placeholder="e.g. South Delhi Enclaves">
                <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
            `;
            container.appendChild(div);
        });
    }

    // 2. Add Stat
    const addStatBtn = document.getElementById('add-stat-btn');
    if (addStatBtn) {
        addStatBtn.addEventListener('click', function() {
            const container = document.getElementById('approach-stats-container');
            const idx = container.querySelectorAll('.dynamic-row').length + Date.now();
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'display: grid; grid-template-columns: 140px 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;';
            div.innerHTML = `
                <input type="text" name="approach_stats[${idx}][value]" class="form-control" placeholder="e.g. 100%">
                <input type="text" name="approach_stats[${idx}][label]" class="form-control" placeholder="e.g. Buyer Aligned">
                <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
            `;
            container.appendChild(div);
        });
    }

    // 3. Add Deliverable
    const addDelivBtn = document.getElementById('add-deliverable-btn');
    if (addDelivBtn) {
        addDelivBtn.addEventListener('click', function() {
            const container = document.getElementById('deliverables-container');
            const count = container.querySelectorAll('.dynamic-row').length + 1;
            const idx = Date.now();
            const numStr = String(count).padStart(2, '0');
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;';
            div.innerHTML = `
                <div style="display: grid; grid-template-columns: 80px 1fr 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <input type="text" name="deliverables_items[${idx}][num]" class="form-control" value="${numStr}">
                    <input type="text" name="deliverables_items[${idx}][title]" class="form-control" placeholder="Step Title">
                    <input type="text" name="deliverables_items[${idx}][tag]" class="form-control" placeholder="Category / Tag">
                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                </div>
                <textarea name="deliverables_items[${idx}][desc]" class="form-control" rows="2" placeholder="Detailed step description..."></textarea>
            `;
            container.appendChild(div);
        });
    }

    // 4. Add Roadmap Step
    const addRoadmapBtn = document.getElementById('add-roadmap-btn');
    if (addRoadmapBtn) {
        addRoadmapBtn.addEventListener('click', function() {
            const container = document.getElementById('roadmap-container');
            const count = container.querySelectorAll('.dynamic-row').length + 1;
            const idx = Date.now();
            const numStr = String(count).padStart(2, '0');
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;';
            div.innerHTML = `
                <div style="display: grid; grid-template-columns: 80px 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <input type="text" name="roadmap_steps[${idx}][step]" class="form-control" value="${numStr}">
                    <input type="text" name="roadmap_steps[${idx}][title]" class="form-control" placeholder="Stage Name">
                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                </div>
                <textarea name="roadmap_steps[${idx}][desc]" class="form-control" rows="2" placeholder="Stage description..."></textarea>
            `;
            container.appendChild(div);
        });
    }

    // 5. Add Why Pillar
    const addWhyBtn = document.getElementById('add-why-pillar-btn');
    if (addWhyBtn) {
        addWhyBtn.addEventListener('click', function() {
            const container = document.getElementById('why-pillars-container');
            const count = container.querySelectorAll('.dynamic-row').length + 1;
            const idx = Date.now();
            const numStr = String(count).padStart(2, '0');
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;';
            div.innerHTML = `
                <div style="display: grid; grid-template-columns: 80px 140px 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <input type="text" name="why_pillars[${idx}][num]" class="form-control" value="${numStr}">
                    <input type="text" name="why_pillars[${idx}][icon]" class="form-control" value="verified_user" placeholder="Icon">
                    <input type="text" name="why_pillars[${idx}][title]" class="form-control" placeholder="Pillar Title">
                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                </div>
                <textarea name="why_pillars[${idx}][desc]" class="form-control" rows="2" placeholder="Pillar description..."></textarea>
            `;
            container.appendChild(div);
        });
    }

    // 6. Add Checkmark
    const addCheckmarkBtn = document.getElementById('add-checkmark-btn');
    if (addCheckmarkBtn) {
        addCheckmarkBtn.addEventListener('click', function() {
            const container = document.getElementById('checkmarks-container');
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'display: flex; gap: 0.5rem; margin-bottom: 0.5rem;';
            div.innerHTML = `
                <input type="text" name="value_prop_checkmarks[]" class="form-control" placeholder="Commitment bullet point">
                <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
            `;
            container.appendChild(div);
        });
    }

    // 7. Add Audience
    const addAudienceBtn = document.getElementById('add-audience-btn');
    if (addAudienceBtn) {
        addAudienceBtn.addEventListener('click', function() {
            const container = document.getElementById('audiences-container');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'background: #FAF8F4; padding: 1rem; border: 1px solid var(--admin-border); border-radius: 4px; margin-bottom: 0.75rem;';
            div.innerHTML = `
                <div style="display: grid; grid-template-columns: 140px 1fr 40px; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <input type="text" name="audience_profiles[${idx}][icon]" class="form-control" value="home" placeholder="Icon">
                    <input type="text" name="audience_profiles[${idx}][title]" class="form-control" placeholder="Audience Title">
                    <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
                </div>
                <textarea name="audience_profiles[${idx}][desc]" class="form-control" rows="2" placeholder="Audience description..."></textarea>
            `;
            container.appendChild(div);
        });
    }

    // 8. Add FAQ
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
                    <input type="text" name="faqs_items[${idx}][question]" class="form-control" placeholder="e.g. What are your advisory fees and commercial terms?" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-size: 0.8rem;">Answer *</label>
                    <textarea name="faqs_items[${idx}][answer]" class="form-control" rows="3" placeholder="Detailed response for clients..." required></textarea>
                </div>
            `;
            container.appendChild(div);
        });
    }

    // 9. Add Enquiry Feature
    const addEnquiryFeatureBtn = document.getElementById('add-enquiry-feature-btn');
    if (addEnquiryFeatureBtn) {
        addEnquiryFeatureBtn.addEventListener('click', function() {
            const container = document.getElementById('enquiry-features-container');
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'display: flex; gap: 0.5rem; margin-bottom: 0.5rem;';
            div.innerHTML = `
                <input type="text" name="enquiry_features[]" class="form-control" placeholder="e.g. Strict Bilateral Non-Disclosure">
                <button type="button" class="btn btn-outline btn-sm remove-row-btn" style="color: #EF4444;">&times;</button>
            `;
            container.appendChild(div);
        });
    }
});
</script>
