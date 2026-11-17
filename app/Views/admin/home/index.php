<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];

$home = $home ?? [];
$settings = $generalSettings ?? [];
?>

<form action="<?= $baseUrl ?>/admin/home/update" method="POST" enctype="multipart/form-data">
    <?= Csrf::field() ?>

    <div class="admin-page-header">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy); margin: 0;">Home Page Management</h2>
                <span class="badge" style="background: #DCFCE7; color: #166534;">
                    ● Live on Website
                </span>
            </div>
            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 0;">Manage homepage section titles, narrative copy, 4 metrics, 4 pillars, director's letter, CTAs, and images.</p>
        </div>
        <div class="admin-header-actions">
            <a href="<?= $baseUrl ?>/" target="_blank" class="btn btn-outline btn-sm">
                <?= SvgIcons::render('eye', 'w-3 h-3', 14) ?> View Live Page
            </a>
            <button type="submit" class="btn btn-primary btn-sm">Save All Changes</button>
        </div>
    </div>

    <div class="admin-form-layout">
        <!-- Left Main Column: Section Tabs -->
        <div class="admin-form-main">
            <!-- Navigation Tabs -->
            <div class="admin-tabs" style="display: flex; flex-wrap: wrap; gap: 0.25rem; border-bottom: 1px solid var(--admin-border); margin-bottom: 1.25rem;">
                <button type="button" class="admin-tab-btn active" data-tab="tab-hero">1. Hero & Rail</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-manifesto">2. Institutional Heritage</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-properties">3. Selected Properties</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-services">4. Advisory Scope</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-why">5. Why Elite Homez</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-areas">6. Addresses We Know</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-director">7. Director's Letter</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-enquiry">8. Advisory Enquiry Desk</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-cta">9. Final Principal CTA</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-seo">10. SEO & Metadata</button>
            </div>

            <!-- TAB 1: HERO & BRAND RAIL -->
            <div class="admin-tab-pane active" id="tab-hero">
                <div class="admin-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem;">
                        <div>
                            <h3 style="font-size: 1.1rem; color: var(--admin-navy); margin: 0 0 0.25rem 0;">Section 1: Hero Carousel Defaults &amp; Brand Rail</h3>
                            <p style="font-size: 0.8rem; color: var(--admin-text-muted); margin: 0;">
                                Multi-slides are managed in <a href="<?= $baseUrl ?>/admin/carousel" style="color: var(--admin-gold); font-weight: 600; text-decoration: underline;">Hero Carousel Manager</a>. Below are the default fallback captions and the vertical rail branding.
                            </p>
                        </div>
                        <a href="<?= $baseUrl ?>/admin/carousel" class="btn btn-outline btn-sm">
                            <?= SvgIcons::render('image', 'w-3 h-3', 14) ?> Manage Multi-Slides
                        </a>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_hero_rail_text">Vertical Architectural Rail Text</label>
                        <input type="text" name="home_hero_rail_text" id="home_hero_rail_text" class="form-control" value="<?= Format::e($home['home_hero_rail_text'] ?? 'ELITE HOMEZ · SOUTH DELHI BESPOKE ADVISORY') ?>">
                        <small class="form-text">Vertical micro-branding running down the right border of the hero frame.</small>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_hero_default_eyebrow">Hero Eyebrow (Fallback Slide)</label>
                            <input type="text" name="home_hero_default_eyebrow" id="home_hero_default_eyebrow" class="form-control" value="<?= Format::e($home['home_hero_default_eyebrow'] ?? 'PRIVATE LUXURY ADVISORY · SOUTH DELHI') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_hero_default_title">Hero H1 Headline (HTML supported)</label>
                            <input type="text" name="home_hero_default_title" id="home_hero_default_title" class="form-control" value="<?= htmlspecialchars($home['home_hero_default_title'] ?? 'Discover a More Exclusive<br><span class="hero-gold-italic">Way to Live.</span>', ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_hero_default_subtitle">Hero Supporting Subtitle</label>
                        <textarea name="home_hero_default_subtitle" id="home_hero_default_subtitle" class="form-control" rows="2"><?= Format::e($home['home_hero_default_subtitle'] ?? 'Exceptional homes. Prestigious addresses. Personalised real estate expertise across South Delhi.') ?></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_hero_default_btn1_text">Primary Button Text</label>
                            <input type="text" name="home_hero_default_btn1_text" id="home_hero_default_btn1_text" class="form-control" value="<?= Format::e($home['home_hero_default_btn1_text'] ?? 'Explore Properties') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_hero_default_btn1_url">Primary Button URL</label>
                            <input type="text" name="home_hero_default_btn1_url" id="home_hero_default_btn1_url" class="form-control" value="<?= Format::e($home['home_hero_default_btn1_url'] ?? '/properties') ?>">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_hero_default_btn2_text">Secondary Button Text</label>
                            <input type="text" name="home_hero_default_btn2_text" id="home_hero_default_btn2_text" class="form-control" value="<?= Format::e($home['home_hero_default_btn2_text'] ?? 'Speak With an Advisor') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_hero_default_btn2_url">Secondary Button URL</label>
                            <input type="text" name="home_hero_default_btn2_url" id="home_hero_default_btn2_url" class="form-control" value="<?= Format::e($home['home_hero_default_btn2_url'] ?? '/contact-us') ?>">
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Hero Trust Markers &amp; Dossier Card (Fallback)</h4>
                        <div class="grid-3">
                            <div class="form-group">
                                <label class="form-label" for="home_hero_default_trust1">Trust Marker 1</label>
                                <input type="text" name="home_hero_default_trust1" id="home_hero_default_trust1" class="form-control" value="<?= Format::e($home['home_hero_default_trust1'] ?? '20+ Years Leadership') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="home_hero_default_trust2">Trust Marker 2</label>
                                <input type="text" name="home_hero_default_trust2" id="home_hero_default_trust2" class="form-control" value="<?= Format::e($home['home_hero_default_trust2'] ?? '100% Non-Disclosure Mandates') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="home_hero_default_trust3">Trust Marker 3</label>
                                <input type="text" name="home_hero_default_trust3" id="home_hero_default_trust3" class="form-control" value="<?= Format::e($home['home_hero_default_trust3'] ?? 'RERA Registered') ?>">
                            </div>
                        </div>
                        <div class="grid-3" style="margin-top: 0.75rem;">
                            <div class="form-group">
                                <label class="form-label" for="home_hero_default_dossier_eyebrow">Dossier Eyebrow</label>
                                <input type="text" name="home_hero_default_dossier_eyebrow" id="home_hero_default_dossier_eyebrow" class="form-control" value="<?= Format::e($home['home_hero_default_dossier_eyebrow'] ?? 'Featured Residence Dossier') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="home_hero_default_dossier_title">Dossier Title</label>
                                <input type="text" name="home_hero_default_dossier_title" id="home_hero_default_dossier_title" class="form-control" value="<?= Format::e($home['home_hero_default_dossier_title'] ?? 'Golf Links Promenade · ₹35.00 Cr') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="home_hero_default_badge">Badge Tag</label>
                                <input type="text" name="home_hero_default_badge" id="home_hero_default_badge" class="form-control" value="<?= Format::e($home['home_hero_default_badge'] ?? 'Off-Market Mandate') ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: INSTITUTIONAL HERITAGE (4 METRICS) -->
            <div class="admin-tab-pane" id="tab-manifesto">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 2: Institutional Heritage (Deep Forest Green Bar)</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_manifesto_eyebrow">Section Eyebrow</label>
                            <input type="text" name="home_manifesto_eyebrow" id="home_manifesto_eyebrow" class="form-control" value="<?= Format::e($home['home_manifesto_eyebrow'] ?? 'Institutional Heritage') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_manifesto_title">Section Headline *</label>
                            <input type="text" name="home_manifesto_title" id="home_manifesto_title" class="form-control" value="<?= Format::e($home['home_manifesto_title'] ?? 'More than a property. A relationship built around trust.') ?>" required>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">The 4 Key Metric Columns</h4>
                        <div class="grid-2" style="gap: 1.25rem;">
                            <!-- Metric 1 -->
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <h5 style="margin: 0 0 0.5rem 0; font-size: 0.8rem; color: var(--admin-gold); text-transform: uppercase;">Metric Column 01</h5>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Number / Stat</label>
                                    <input type="text" name="home_stat_1_num" class="form-control" value="<?= Format::e($home['home_stat_1_num'] ?? '20+') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Title</label>
                                    <input type="text" name="home_stat_1_title" class="form-control" value="<?= Format::e($home['home_stat_1_title'] ?? 'Years of Leadership') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem;">Description</label>
                                    <textarea name="home_stat_1_desc" class="form-control" rows="2"><?= Format::e($home['home_stat_1_desc'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <!-- Metric 2 -->
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <h5 style="margin: 0 0 0.5rem 0; font-size: 0.8rem; color: var(--admin-gold); text-transform: uppercase;">Metric Column 02</h5>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Number / Stat</label>
                                    <input type="text" name="home_stat_2_num" class="form-control" value="<?= Format::e($home['home_stat_2_num'] ?? '₹1,200 Cr+') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Title</label>
                                    <input type="text" name="home_stat_2_title" class="form-control" value="<?= Format::e($home['home_stat_2_title'] ?? 'Transacted Asset Volume') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem;">Description</label>
                                    <textarea name="home_stat_2_desc" class="form-control" rows="2"><?= Format::e($home['home_stat_2_desc'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <!-- Metric 3 -->
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <h5 style="margin: 0 0 0.5rem 0; font-size: 0.8rem; color: var(--admin-gold); text-transform: uppercase;">Metric Column 03</h5>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Number / Stat</label>
                                    <input type="text" name="home_stat_3_num" class="form-control" value="<?= Format::e($home['home_stat_3_num'] ?? '100%') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Title</label>
                                    <input type="text" name="home_stat_3_title" class="form-control" value="<?= Format::e($home['home_stat_3_title'] ?? 'Forensic Title Diligence') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem;">Description</label>
                                    <textarea name="home_stat_3_desc" class="form-control" rows="2"><?= Format::e($home['home_stat_3_desc'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <!-- Metric 4 -->
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <h5 style="margin: 0 0 0.5rem 0; font-size: 0.8rem; color: var(--admin-gold); text-transform: uppercase;">Metric Column 04</h5>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Number / Stat</label>
                                    <input type="text" name="home_stat_4_num" class="form-control" value="<?= Format::e($home['home_stat_4_num'] ?? 'Strict NDA') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Title</label>
                                    <input type="text" name="home_stat_4_title" class="form-control" value="<?= Format::e($home['home_stat_4_title'] ?? 'Family Office Discretion') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem;">Description</label>
                                    <textarea name="home_stat_4_desc" class="form-control" rows="2"><?= Format::e($home['home_stat_4_desc'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: SELECTED PROPERTIES HEADER -->
            <div class="admin-tab-pane" id="tab-properties">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 3: Selected Properties Showcase Header</h3>

                    <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; gap: 0.5rem; align-items: center; color: #1E40AF; font-weight: 600; font-size: 0.85rem;">
                            <?= SvgIcons::render('check-circle', 'w-4 h-4', 16) ?>
                            <span>Dynamic Properties Portfolio Integration</span>
                        </div>
                        <p style="margin: 0.35rem 0 0 0; font-size: 0.8rem; color: #1E3A8A; line-height: 1.5;">
                            All residences displayed here stream directly from your <strong>Properties database</strong> tagged as <strong>★ Featured</strong> (<a href="<?= $baseUrl ?>/admin/properties" target="_blank" style="color: #2563EB; text-decoration: underline;">Manage Properties</a>). Below you can customise the section title, subtitle, and view-all button.
                        </p>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_properties_eyebrow">Eyebrow</label>
                            <input type="text" name="home_properties_eyebrow" id="home_properties_eyebrow" class="form-control" value="<?= Format::e($home['home_properties_eyebrow'] ?? 'Curated Portfolio') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_properties_title">Section Title *</label>
                            <input type="text" name="home_properties_title" id="home_properties_title" class="form-control" value="<?= Format::e($home['home_properties_title'] ?? 'Selected Properties') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_properties_desc">Section Subtitle</label>
                        <textarea name="home_properties_desc" id="home_properties_desc" class="form-control" rows="2"><?= Format::e($home['home_properties_desc'] ?? '') ?></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_properties_btn_text">View All Button Text</label>
                            <input type="text" name="home_properties_btn_text" id="home_properties_btn_text" class="form-control" value="<?= Format::e($home['home_properties_btn_text'] ?? 'View All Properties') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_properties_btn_url">View All Button URL</label>
                            <input type="text" name="home_properties_btn_url" id="home_properties_btn_url" class="form-control" value="<?= Format::e($home['home_properties_btn_url'] ?? '/properties') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: ADVISORY SCOPE HEADER -->
            <div class="admin-tab-pane" id="tab-services">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 4: Practice Mandates Header (Dark Charcoal Block)</h3>

                    <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; gap: 0.5rem; align-items: center; color: #1E40AF; font-weight: 600; font-size: 0.85rem;">
                            <?= SvgIcons::render('check-circle', 'w-4 h-4', 16) ?>
                            <span>Dynamic Services Integration</span>
                        </div>
                        <p style="margin: 0.35rem 0 0 0; font-size: 0.8rem; color: #1E3A8A; line-height: 1.5;">
                            The service rows stream dynamically from your <strong>Advisory Services database</strong> (<a href="<?= $baseUrl ?>/admin/services" target="_blank" style="color: #2563EB; text-decoration: underline;">Manage Services</a>). Below you can customise the section eyebrow and main heading.
                        </p>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_services_eyebrow">Section Eyebrow</label>
                            <input type="text" name="home_services_eyebrow" id="home_services_eyebrow" class="form-control" value="<?= Format::e($home['home_services_eyebrow'] ?? 'Structured Advisory Scope') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_services_title">Section Headline *</label>
                            <input type="text" name="home_services_title" id="home_services_title" class="form-control" value="<?= Format::e($home['home_services_title'] ?? 'Find Your Next Address.') ?>" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 5: WHY ELITE HOMEZ (4 PILLARS) -->
            <div class="admin-tab-pane" id="tab-why">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 5: Why Elite Homez (The Difference is Experience)</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_why_eyebrow">Section Eyebrow</label>
                            <input type="text" name="home_why_eyebrow" id="home_why_eyebrow" class="form-control" value="<?= Format::e($home['home_why_eyebrow'] ?? 'Institutional Excellence') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_why_title">Section Headline *</label>
                            <input type="text" name="home_why_title" id="home_why_title" class="form-control" value="<?= Format::e($home['home_why_title'] ?? 'The Difference is Experience.') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_why_quote">Header Quote Subtitle</label>
                        <input type="text" name="home_why_quote" id="home_why_quote" class="form-control" value="<?= Format::e($home['home_why_quote'] ?? '"Because acquiring or transferring generational real estate requires more than brokerage."') ?>">
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">The 4 Architectural Pillars</h4>
                        <div class="grid-2" style="gap: 1.25rem;">
                            <!-- Pillar 1 -->
                            <div style="background: #243F34; color: white; padding: 1rem; border-radius: 8px; border: 1px solid #B99A62;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #DFCF9F;">PILLAR 01</span>
                                    <input type="text" name="home_pillar_1_num" class="form-control" value="<?= Format::e($home['home_pillar_1_num'] ?? '01') ?>" style="width: 60px; text-align: center; background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Title</label>
                                    <input type="text" name="home_pillar_1_title" class="form-control" value="<?= Format::e($home['home_pillar_1_title'] ?? 'LOCAL KNOWLEDGE') ?>" style="background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Description</label>
                                    <textarea name="home_pillar_1_desc" class="form-control" rows="2" style="background: #1B3128; color: white; border-color: #B99A62;"><?= Format::e($home['home_pillar_1_desc'] ?? '') ?></textarea>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Footer Tag</label>
                                    <input type="text" name="home_pillar_1_tag" class="form-control" value="<?= Format::e($home['home_pillar_1_tag'] ?? 'Forensic Due Diligence') ?>" style="background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                            </div>

                            <!-- Pillar 2 -->
                            <div style="background: #243F34; color: white; padding: 1rem; border-radius: 8px; border: 1px solid #B99A62;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #DFCF9F;">PILLAR 02</span>
                                    <input type="text" name="home_pillar_2_num" class="form-control" value="<?= Format::e($home['home_pillar_2_num'] ?? '02') ?>" style="width: 60px; text-align: center; background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Title</label>
                                    <input type="text" name="home_pillar_2_title" class="form-control" value="<?= Format::e($home['home_pillar_2_title'] ?? 'DISCREET ADVISORY') ?>" style="background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Description</label>
                                    <textarea name="home_pillar_2_desc" class="form-control" rows="2" style="background: #1B3128; color: white; border-color: #B99A62;"><?= Format::e($home['home_pillar_2_desc'] ?? '') ?></textarea>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Footer Tag</label>
                                    <input type="text" name="home_pillar_2_tag" class="form-control" value="<?= Format::e($home['home_pillar_2_tag'] ?? 'Strict Bilateral NDAs') ?>" style="background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                            </div>

                            <!-- Pillar 3 -->
                            <div style="background: #243F34; color: white; padding: 1rem; border-radius: 8px; border: 1px solid #B99A62;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #DFCF9F;">PILLAR 03</span>
                                    <input type="text" name="home_pillar_3_num" class="form-control" value="<?= Format::e($home['home_pillar_3_num'] ?? '03') ?>" style="width: 60px; text-align: center; background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Title</label>
                                    <input type="text" name="home_pillar_3_title" class="form-control" value="<?= Format::e($home['home_pillar_3_title'] ?? 'OFF-MARKET ACCESS') ?>" style="background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Description</label>
                                    <textarea name="home_pillar_3_desc" class="form-control" rows="2" style="background: #1B3128; color: white; border-color: #B99A62;"><?= Format::e($home['home_pillar_3_desc'] ?? '') ?></textarea>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Footer Tag</label>
                                    <input type="text" name="home_pillar_3_tag" class="form-control" value="<?= Format::e($home['home_pillar_3_tag'] ?? 'Private Enclave Network') ?>" style="background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                            </div>

                            <!-- Pillar 4 -->
                            <div style="background: #243F34; color: white; padding: 1rem; border-radius: 8px; border: 1px solid #B99A62;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #DFCF9F;">PILLAR 04</span>
                                    <input type="text" name="home_pillar_4_num" class="form-control" value="<?= Format::e($home['home_pillar_4_num'] ?? '04') ?>" style="width: 60px; text-align: center; background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Title</label>
                                    <input type="text" name="home_pillar_4_title" class="form-control" value="<?= Format::e($home['home_pillar_4_title'] ?? 'SENIOR STEWARDSHIP') ?>" style="background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Description</label>
                                    <textarea name="home_pillar_4_desc" class="form-control" rows="2" style="background: #1B3128; color: white; border-color: #B99A62;"><?= Format::e($home['home_pillar_4_desc'] ?? '') ?></textarea>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem; color: #DFCF9F;">Footer Tag</label>
                                    <input type="text" name="home_pillar_4_tag" class="form-control" value="<?= Format::e($home['home_pillar_4_tag'] ?? 'Principal Level Trust') ?>" style="background: #1B3128; color: white; border-color: #B99A62;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 6: ADDRESSES WE KNOW (ATLAS HEADER) -->
            <div class="admin-tab-pane" id="tab-areas">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 6: Addresses We Know (Territorial Atlas Header)</h3>

                    <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; gap: 0.5rem; align-items: center; color: #1E40AF; font-weight: 600; font-size: 0.85rem;">
                            <?= SvgIcons::render('check-circle', 'w-4 h-4', 16) ?>
                            <span>Dynamic Enclaves Mosaic Integration</span>
                        </div>
                        <p style="margin: 0.35rem 0 0 0; font-size: 0.8rem; color: #1E3A8A; line-height: 1.5;">
                            The mosaic and bottom enclave ticker cards stream live from your <strong>Areas of Expertise database</strong> (<a href="<?= $baseUrl ?>/admin/areas" target="_blank" style="color: #2563EB; text-decoration: underline;">Manage Areas</a>). Below you can customise the section title, subtitle, and ticker label.
                        </p>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_areas_eyebrow">Section Eyebrow</label>
                            <input type="text" name="home_areas_eyebrow" id="home_areas_eyebrow" class="form-control" value="<?= Format::e($home['home_areas_eyebrow'] ?? 'Territorial Mastery') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_areas_title">Section Title *</label>
                            <input type="text" name="home_areas_title" id="home_areas_title" class="form-control" value="<?= Format::e($home['home_areas_title'] ?? 'Addresses We Know.') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_areas_desc">Section Subtitle</label>
                        <textarea name="home_areas_desc" id="home_areas_desc" class="form-control" rows="2"><?= Format::e($home['home_areas_desc'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_areas_ticker_label">Bottom Enclaves Ticker Label</label>
                        <input type="text" name="home_areas_ticker_label" id="home_areas_ticker_label" class="form-control" value="<?= Format::e($home['home_areas_ticker_label'] ?? 'Additional Prime South Delhi Enclaves:') ?>">
                    </div>
                </div>
            </div>

            <!-- TAB 7: DIRECTOR'S LETTER -->
            <div class="admin-tab-pane" id="tab-director">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 7: Director's Message &amp; Leadership Covenant</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_director_eyebrow">Eyebrow</label>
                            <input type="text" name="home_director_eyebrow" id="home_director_eyebrow" class="form-control" value="<?= Format::e($home['home_director_eyebrow'] ?? "DIRECTOR'S LETTER") ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_director_title">Core Quote Headline *</label>
                            <input type="text" name="home_director_title" id="home_director_title" class="form-control" value="<?= Format::e($home['home_director_title'] ?? '"Discretion is not merely a courtesy. In high-value real estate, it is the cornerstone of trust."') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_director_pullquote">Pull-Quote Callout *</label>
                        <textarea name="home_director_pullquote" id="home_director_pullquote" class="form-control" rows="2" required><?= Format::e($home['home_director_pullquote'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_director_p1">Letter Paragraph 1 *</label>
                        <textarea name="home_director_p1" id="home_director_p1" class="form-control" rows="3" required><?= Format::e($home['home_director_p1'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_director_p2">Letter Paragraph 2 *</label>
                        <textarea name="home_director_p2" id="home_director_p2" class="form-control" rows="2" required><?= Format::e($home['home_director_p2'] ?? '') ?></textarea>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Director Credentials &amp; Signature</h4>
                        <div class="grid-3">
                            <div class="form-group">
                                <label class="form-label" for="home_director_credentials_eyebrow">Credentials Eyebrow</label>
                                <input type="text" name="home_director_credentials_eyebrow" id="home_director_credentials_eyebrow" class="form-control" value="<?= Format::e($home['home_director_credentials_eyebrow'] ?? 'FOUNDING PRINCIPAL') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="home_director_credentials_name">Credentials Name</label>
                                <input type="text" name="home_director_credentials_name" id="home_director_credentials_name" class="form-control" value="<?= Format::e($home['home_director_credentials_name'] ?? 'Managing Director') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="home_director_credentials_title">Credentials Title</label>
                                <input type="text" name="home_director_credentials_title" id="home_director_credentials_title" class="form-control" value="<?= Format::e($home['home_director_credentials_title'] ?? 'Elite Homez Property Advisory') ?>">
                            </div>
                        </div>
                        <div class="grid-2" style="margin-top: 0.75rem;">
                            <div class="form-group">
                                <label class="form-label" for="home_director_signoff">Signature Sign-off</label>
                                <input type="text" name="home_director_signoff" id="home_director_signoff" class="form-control" value="<?= Format::e($home['home_director_signoff'] ?? 'Elite Homez Advisory') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="home_director_badge">Signature Badge</label>
                                <input type="text" name="home_director_badge" id="home_director_badge" class="form-control" value="<?= Format::e($home['home_director_badge'] ?? '✦ Senior Partner Desk') ?>">
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Director Office Interior Image</h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="home_director_image">Image Path or URL</label>
                                <input type="text" name="home_director_image" id="home_director_image" class="form-control" value="<?= Format::e($home['home_director_image'] ?? '/assets/images/stitch/about-director-office.jpg') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="home_director_image_file">Upload New Image</label>
                                <input type="file" name="home_director_image_file" id="home_director_image_file" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <?php if (!empty($home['home_director_image'])): ?>
                            <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <img src="<?= str_starts_with($home['home_director_image'], 'http') ? $home['home_director_image'] : $baseUrl . '/' . ltrim($home['home_director_image'], '/') ?>" style="height: 60px; width: 80px; object-fit: cover; border-radius: 6px; border: 1px solid var(--admin-border);">
                                <span style="font-size: 0.75rem; color: var(--admin-text-muted);">Current Director Office Image</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- TAB 8: ADVISORY ENQUIRY DESK -->
            <div class="admin-tab-pane" id="tab-enquiry">
                <div class="admin-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem;">
                        <div>
                            <h3 style="font-size: 1.1rem; color: var(--admin-navy); margin: 0 0 0.25rem 0;">Section 8: Confidential Dialogue Enquiry Desk (Conversion Form)</h3>
                            <p style="font-size: 0.8rem; color: var(--admin-text-muted); margin: 0;">
                                Direct high-conversion enquiry section on the homepage where prospective buyers and investors register their requirements.
                            </p>
                        </div>
                        <a href="<?= $baseUrl ?>/admin/enquiries" class="btn btn-outline btn-sm">
                            <?= SvgIcons::render('mail', 'w-3 h-3', 14) ?> View Leads Inbox
                        </a>
                    </div>

                    <div class="form-group" style="background: var(--admin-bg); padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border); margin-bottom: 1.5rem;">
                        <label class="form-label" style="margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-weight: 600;">Display Enquiry Desk on Homepage</span>
                            <select name="home_enquiry_enabled" class="form-control" style="width: auto; padding: 0.25rem 0.75rem;">
                                <option value="1" <?= (($home['home_enquiry_enabled'] ?? '1') === '1') ? 'selected' : '' ?>>Enabled (Visible)</option>
                                <option value="0" <?= (($home['home_enquiry_enabled'] ?? '1') === '0') ? 'selected' : '' ?>>Disabled (Hidden)</option>
                            </select>
                        </label>
                        <small class="form-text" style="margin: 0;">When enabled, the 2-column luxury enquiry desk with dynamic enclave and service selectors renders right above the final CTA banner.</small>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_enquiry_eyebrow">Section Eyebrow</label>
                            <input type="text" name="home_enquiry_eyebrow" id="home_enquiry_eyebrow" class="form-control" value="<?= Format::e($home['home_enquiry_eyebrow'] ?? 'Confidential Dialogue') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_enquiry_title">Headline</label>
                            <input type="text" name="home_enquiry_title" id="home_enquiry_title" class="form-control" value="<?= Format::e($home['home_enquiry_title'] ?? 'Initiate a Private Advisory Briefing') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_enquiry_desc">Narrative Description</label>
                        <textarea name="home_enquiry_desc" id="home_enquiry_desc" class="form-control" rows="2"><?= Format::e($home['home_enquiry_desc'] ?? 'Share your parameters. A designated Elite Homez Senior Partner will contact you under strict bilateral confidentiality.') ?></textarea>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 0.5rem; color: var(--admin-navy);">Trust Badges (Left Column Protocols)</h4>
                        <p style="font-size: 0.8rem; color: var(--admin-text-muted); margin-bottom: 1rem;">These three key security covenants reinforce client confidence.</p>
                        
                        <div class="form-group">
                            <label class="form-label" for="home_enquiry_feature_1">Trust Protocol 1</label>
                            <input type="text" name="home_enquiry_feature_1" id="home_enquiry_feature_1" class="form-control" value="<?= Format::e($home['home_enquiry_feature_1'] ?? 'Protected by bilateral non-disclosure covenants') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_enquiry_feature_2">Trust Protocol 2</label>
                            <input type="text" name="home_enquiry_feature_2" id="home_enquiry_feature_2" class="form-control" value="<?= Format::e($home['home_enquiry_feature_2'] ?? 'Senior partner consultation within 4 business hours') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_enquiry_feature_3">Trust Protocol 3</label>
                            <input type="text" name="home_enquiry_feature_3" id="home_enquiry_feature_3" class="form-control" value="<?= Format::e($home['home_enquiry_feature_3'] ?? 'Verified freehold credentials & micro-market intelligence') ?>">
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Button Labels</h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="home_enquiry_btn_text">Gold Submit Button Text</label>
                                <input type="text" name="home_enquiry_btn_text" id="home_enquiry_btn_text" class="form-control" value="<?= Format::e($home['home_enquiry_btn_text'] ?? 'Request Confidential Consultation') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="home_enquiry_wa_text">WhatsApp Concierge Button Text</label>
                                <input type="text" name="home_enquiry_wa_text" id="home_enquiry_wa_text" class="form-control" value="<?= Format::e($home['home_enquiry_wa_text'] ?? 'Direct WhatsApp Concierge') ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 9: FINAL PRINCIPAL CTA -->
            <div class="admin-tab-pane" id="tab-cta">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 8: Final Principal Advisory CTA (Bottom Dusk Banner)</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_cta_eyebrow">Eyebrow</label>
                            <input type="text" name="home_cta_eyebrow" id="home_cta_eyebrow" class="form-control" value="<?= Format::e($home['home_cta_eyebrow'] ?? 'DIRECT PRINCIPAL ADVISORY') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_cta_title">Main Headline *</label>
                            <input type="text" name="home_cta_title" id="home_cta_title" class="form-control" value="<?= Format::e($home['home_cta_title'] ?? 'Your next address deserves the right advice.') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_cta_desc">Lead Paragraph *</label>
                        <textarea name="home_cta_desc" id="home_cta_desc" class="form-control" rows="2" required><?= Format::e($home['home_cta_desc'] ?? '') ?></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_cta_btn1_text">Primary Button Text</label>
                            <input type="text" name="home_cta_btn1_text" id="home_cta_btn1_text" class="form-control" value="<?= Format::e($home['home_cta_btn1_text'] ?? 'Speak With an Advisor') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_cta_btn1_url">Primary Button URL</label>
                            <input type="text" name="home_cta_btn1_url" id="home_cta_btn1_url" class="form-control" value="<?= Format::e($home['home_cta_btn1_url'] ?? '/contact-us') ?>">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="home_cta_btn2_text">WhatsApp Button Text</label>
                            <input type="text" name="home_cta_btn2_text" id="home_cta_btn2_text" class="form-control" value="<?= Format::e($home['home_cta_btn2_text'] ?? 'Direct WhatsApp Concierge') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_cta_btn2_url">Custom WhatsApp URL (Optional)</label>
                            <input type="text" name="home_cta_btn2_url" id="home_cta_btn2_url" class="form-control" value="<?= Format::e($home['home_cta_btn2_url'] ?? '') ?>" placeholder="Leave blank to use site WhatsApp number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_cta_note">Confidentiality Footnote</label>
                        <input type="text" name="home_cta_note" id="home_cta_note" class="form-control" value="<?= Format::e($home['home_cta_note'] ?? 'All discussions are treated with strict professional confidentiality under bilateral NDAs.') ?>">
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Background Architectural Residence Dusk Image</h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="home_cta_image">Image Path or URL</label>
                                <input type="text" name="home_cta_image" id="home_cta_image" class="form-control" value="<?= Format::e($home['home_cta_image'] ?? '/assets/images/stitch/hero-residence.jpg') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="home_cta_image_file">Upload New Image</label>
                                <input type="file" name="home_cta_image_file" id="home_cta_image_file" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 9: SEO & METADATA -->
            <div class="admin-tab-pane" id="tab-seo">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Homepage Search Engine Optimization (SEO)</h3>

                    <div class="form-group">
                        <label class="form-label" for="home_seo_title">Homepage Browser Meta Title</label>
                        <input type="text" name="home_seo_title" id="home_seo_title" class="form-control" value="<?= Format::e($home['home_seo_title'] ?? 'Elite Homez | Premium Luxury Real Estate Property Advisory') ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_seo_description">Homepage Meta Description</label>
                        <textarea name="home_seo_description" id="home_seo_description" class="form-control" rows="3"><?= Format::e($home['home_seo_description'] ?? 'Elite Homez — your trust, our responsibility. Over 20 years of trusted advisory in prime luxury residences, villas, and builder floors in Vasant Vihar, Jor Bagh, Golf Links, and Chanakyapuri.') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar Action & Preview Panels -->
        <div class="admin-form-sidebar">
            <div class="admin-card sticky-sidebar" style="position: sticky; top: 1.5rem;">
                <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Save &amp; Publish</h4>
                <p style="font-size: 0.8rem; color: var(--admin-text-muted); line-height: 1.5; margin-bottom: 1rem;">
                    All modifications to headlines, metrics, pillars, and director credentials publish immediately to the live homepage.
                </p>

                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        Save All Changes
                    </button>
                    <a href="<?= $baseUrl ?>/" target="_blank" class="btn btn-outline" style="width: 100%; justify-content: center; font-size: 0.8rem;">
                        <?= SvgIcons::render('eye', 'w-3 h-3', 14) ?> View Live Page
                    </a>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--admin-border); font-size: 0.75rem; color: var(--admin-text-muted);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span>Page URL:</span>
                        <a href="<?= $baseUrl ?>/" target="_blank" style="color: var(--admin-gold); font-weight: 600;">/ (Home)</a>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span>Featured Properties:</span>
                        <span style="font-weight: 600; color: #166534;">properties table</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span>Services:</span>
                        <span style="font-weight: 600; color: #166534;">services table</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Enclaves:</span>
                        <span style="font-weight: 600; color: #166534;">areas table</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.admin-tab-btn');
    const tabPanes = document.querySelectorAll('.admin-tab-pane');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const target = this.dataset.tab;
            tabButtons.forEach(b => b.classList.remove('active'));
            tabPanes.forEach(p => p.classList.remove('active'));

            this.classList.add('active');
            const targetPane = document.getElementById(target);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        });
    });
});
</script>
