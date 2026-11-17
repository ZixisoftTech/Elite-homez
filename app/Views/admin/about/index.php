<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];

$about = $about ?? [];
$settings = $generalSettings ?? [];
$rera = $settings['rera_number'] ?? 'DLRERA2023A00892';
?>

<form action="<?= $baseUrl ?>/admin/about/update" method="POST" enctype="multipart/form-data">
    <?= Csrf::field() ?>

    <div class="admin-page-header">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                <h2 style="font-size: 1.35rem; font-weight: 600; color: var(--admin-navy); margin: 0;">About Us Page Management</h2>
                <span class="badge" style="background: #DCFCE7; color: #166534;">
                    ● Live on Website
                </span>
            </div>
            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 0;">Manage every section, headline, narrative quote, stat, image, and CTA on the About Us page.</p>
        </div>
        <div class="admin-header-actions">
            <a href="<?= $baseUrl ?>/about-us" target="_blank" class="btn btn-outline btn-sm">
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
                <button type="button" class="admin-tab-btn active" data-tab="tab-hero">1. Hero & Identity</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-story">2. Our Story & Heritage</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-stats">3. Experience & Metrics</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-philosophy">4. Our Philosophy</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-why">5. Why Choose (6 Pillars)</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-atlas-reviews">6. Enclaves & Reviews</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-director">7. Director's Message</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-cta">8. Final Call to Action</button>
                <button type="button" class="admin-tab-btn" data-tab="tab-seo">9. SEO & Metadata</button>
            </div>

            <!-- TAB 1: HERO & IDENTITY -->
            <div class="admin-tab-pane active" id="tab-hero">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 1: Hero Identity, Headlines & Actions</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_hero_badge">Eyebrow Badge Text</label>
                            <input type="text" name="about_hero_badge" id="about_hero_badge" class="form-control" value="<?= Format::e($about['about_hero_badge'] ?? 'Get to Know Elite Homez') ?>" placeholder="e.g. Get to Know Elite Homez">
                            <small class="form-text">Pulsing badge at the very top of the hero.</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_hero_title">Primary H1 Headline (First Line) *</label>
                            <input type="text" name="about_hero_title" id="about_hero_title" class="form-control" value="<?= Format::e($about['about_hero_title'] ?? 'Where Exceptional Homes') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_hero_title_italic">H1 Headline Accent (Second Line - Italic Gold) *</label>
                        <input type="text" name="about_hero_title_italic" id="about_hero_title_italic" class="form-control" value="<?= Format::e($about['about_hero_title_italic'] ?? 'Meet Exceptional Experiences.') ?>" required>
                        <small class="form-text">Rendered in Playfair Display italic in warm champagne gold.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_hero_desc">Hero Supporting Paragraph *</label>
                        <textarea name="about_hero_desc" id="about_hero_desc" class="form-control" rows="3" required><?= Format::e($about['about_hero_desc'] ?? '') ?></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_hero_btn1_text">Primary Button Text</label>
                            <input type="text" name="about_hero_btn1_text" id="about_hero_btn1_text" class="form-control" value="<?= Format::e($about['about_hero_btn1_text'] ?? 'Explore Our Approach') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_hero_btn1_link">Primary Button Link / Anchor</label>
                            <input type="text" name="about_hero_btn1_link" id="about_hero_btn1_link" class="form-control" value="<?= Format::e($about['about_hero_btn1_link'] ?? '#our-story') ?>">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_hero_btn2_text">WhatsApp Button Text</label>
                            <input type="text" name="about_hero_btn2_text" id="about_hero_btn2_text" class="form-control" value="<?= Format::e($about['about_hero_btn2_text'] ?? 'WhatsApp Senior Advisor') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_hero_btn2_link">WhatsApp Custom URL (Optional)</label>
                            <input type="text" name="about_hero_btn2_link" id="about_hero_btn2_link" class="form-control" value="<?= Format::e($about['about_hero_btn2_link'] ?? '') ?>" placeholder="Leave blank to auto-generate from site WhatsApp number">
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Floating Institutional Credibility Card</h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="about_hero_card_eyebrow">Card Eyebrow</label>
                                <input type="text" name="about_hero_card_eyebrow" id="about_hero_card_eyebrow" class="form-control" value="<?= Format::e($about['about_hero_card_eyebrow'] ?? 'Institutional Heritage') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_hero_card_title">Card Title</label>
                                <input type="text" name="about_hero_card_title" id="about_hero_card_title" class="form-control" value="<?= Format::e($about['about_hero_card_title'] ?? 'South Delhi Advisory') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_hero_card_desc">Card Description</label>
                            <textarea name="about_hero_card_desc" id="about_hero_card_desc" class="form-control" rows="2"><?= Format::e($about['about_hero_card_desc'] ?? '') ?></textarea>
                        </div>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="about_hero_card_tag1">Footer Tag 1 (RERA Note)</label>
                                <input type="text" name="about_hero_card_tag1" id="about_hero_card_tag1" class="form-control" value="<?= Format::e($about['about_hero_card_tag1'] ?? 'RERA {rera}') ?>" placeholder="e.g. RERA {rera}">
                                <small class="form-text">Tip: <code>{rera}</code> auto-substitutes the registered RERA number.</small>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_hero_card_tag2">Footer Tag 2</label>
                                <input type="text" name="about_hero_card_tag2" id="about_hero_card_tag2" class="form-control" value="<?= Format::e($about['about_hero_card_tag2'] ?? 'Est. 2004') ?>">
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 0.75rem; color: var(--admin-navy);">Hero Background Architectural Image</h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="about_hero_image">Image Path or URL</label>
                                <input type="text" name="about_hero_image" id="about_hero_image" class="form-control" value="<?= Format::e($about['about_hero_image'] ?? '/assets/images/stitch/about-flagship-architecture.jpg') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_hero_image_file">Or Upload New Image</label>
                                <input type="file" name="about_hero_image_file" id="about_hero_image_file" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <?php if (!empty($about['about_hero_image'])): ?>
                            <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <img src="<?= str_starts_with($about['about_hero_image'], 'http') ? $about['about_hero_image'] : $baseUrl . '/' . ltrim($about['about_hero_image'], '/') ?>" style="height: 60px; width: 100px; object-fit: cover; border-radius: 6px; border: 1px solid var(--admin-border);">
                                <span style="font-size: 0.75rem; color: var(--admin-text-muted);">Current Hero Background</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- TAB 2: OUR STORY & HERITAGE -->
            <div class="admin-tab-pane" id="tab-story">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 2: Our Story &amp; Heritage Narrative</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_story_eyebrow">Section Eyebrow</label>
                            <input type="text" name="about_story_eyebrow" id="about_story_eyebrow" class="form-control" value="<?= Format::e($about['about_story_eyebrow'] ?? 'Our Story') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_story_title">Main Heading Line 1 *</label>
                            <input type="text" name="about_story_title" id="about_story_title" class="form-control" value="<?= Format::e($about['about_story_title'] ?? 'A Journey Built Around') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_story_title_italic">Main Heading Line 2 (Accent) *</label>
                        <input type="text" name="about_story_title_italic" id="about_story_title_italic" class="form-control" value="<?= Format::e($about['about_story_title_italic'] ?? 'Exceptional Real Estate.') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_story_p1">Story Paragraph 1 *</label>
                        <textarea name="about_story_p1" id="about_story_p1" class="form-control" rows="3" required><?= Format::e($about['about_story_p1'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_story_p2">Story Paragraph 2 *</label>
                        <textarea name="about_story_p2" id="about_story_p2" class="form-control" rows="3" required><?= Format::e($about['about_story_p2'] ?? '') ?></textarea>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">The Elite Homez Covenant Blockquote</h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="about_story_covenant_eyebrow">Covenant Card Eyebrow</label>
                                <input type="text" name="about_story_covenant_eyebrow" id="about_story_covenant_eyebrow" class="form-control" value="<?= Format::e($about['about_story_covenant_eyebrow'] ?? 'The Elite Homez Covenant') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_story_covenant_quote">Covenant Quotation</label>
                                <input type="text" name="about_story_covenant_quote" id="about_story_covenant_quote" class="form-control" value="<?= Format::e($about['about_story_covenant_quote'] ?? 'Your trust, our responsibility. Not merely an operational motto, but an absolute fiduciary anchor protecting generational legacy.') ?>">
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Story Highlights (3 Bullet Badges)</h4>
                        <div class="grid-3">
                            <div class="form-group">
                                <label class="form-label" for="about_story_highlight_1">Highlight 1</label>
                                <input type="text" name="about_story_highlight_1" id="about_story_highlight_1" class="form-control" value="<?= Format::e($about['about_story_highlight_1'] ?? 'South Delhi Specialisation') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_story_highlight_2">Highlight 2</label>
                                <input type="text" name="about_story_highlight_2" id="about_story_highlight_2" class="form-control" value="<?= Format::e($about['about_story_highlight_2'] ?? 'Bespoke Client Portfolios') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_story_highlight_3">Highlight 3</label>
                                <input type="text" name="about_story_highlight_3" id="about_story_highlight_3" class="form-control" value="<?= Format::e($about['about_story_highlight_3'] ?? 'Discreet Representation') ?>">
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Floating Experience Badge &amp; Images</h4>
                        <div class="grid-3">
                            <div class="form-group">
                                <label class="form-label" for="about_story_badge_number">Badge Metric</label>
                                <input type="text" name="about_story_badge_number" id="about_story_badge_number" class="form-control" value="<?= Format::e($about['about_story_badge_number'] ?? '20+') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_story_badge_text1">Badge Text Line 1</label>
                                <input type="text" name="about_story_badge_text1" id="about_story_badge_text1" class="form-control" value="<?= Format::e($about['about_story_badge_text1'] ?? 'Years of') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_story_badge_text2">Badge Text Line 2</label>
                                <input type="text" name="about_story_badge_text2" id="about_story_badge_text2" class="form-control" value="<?= Format::e($about['about_story_badge_text2'] ?? 'Bespoke Advisory') ?>">
                            </div>
                        </div>

                        <div class="grid-2" style="margin-top: 1rem;">
                            <div class="form-group">
                                <label class="form-label" for="about_story_image_primary">Primary Large Living Room Image</label>
                                <input type="text" name="about_story_image_primary" id="about_story_image_primary" class="form-control" value="<?= Format::e($about['about_story_image_primary'] ?? '/assets/images/about/about-living-room.jpg') ?>">
                                <input type="file" name="about_story_image_primary_file" class="form-control" style="margin-top: 0.35rem;" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_story_image_secondary">Secondary Overlapping Image</label>
                                <input type="text" name="about_story_image_secondary" id="about_story_image_secondary" class="form-control" value="<?= Format::e($about['about_story_image_secondary'] ?? '/assets/images/stitch/about-interior.jpg') ?>">
                                <input type="file" name="about_story_image_secondary_file" class="form-control" style="margin-top: 0.35rem;" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: EXPERIENCE & METRICS -->
            <div class="admin-tab-pane" id="tab-stats">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 3: Experience &amp; Expertise (4 Forest Green Metrics)</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_stats_eyebrow">Section Eyebrow</label>
                            <input type="text" name="about_stats_eyebrow" id="about_stats_eyebrow" class="form-control" value="<?= Format::e($about['about_stats_eyebrow'] ?? 'Experience & Expertise') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_stats_title">Section Title *</label>
                            <input type="text" name="about_stats_title" id="about_stats_title" class="form-control" value="<?= Format::e($about['about_stats_title'] ?? 'Two Decades of Dedicated Advisory') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_stats_desc">Section Subtitle / Description</label>
                        <textarea name="about_stats_desc" id="about_stats_desc" class="form-control" rows="2"><?= Format::e($about['about_stats_desc'] ?? '') ?></textarea>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">4 Experience Metric Cards</h4>
                        <div class="grid-2" style="gap: 1.25rem;">
                            <!-- Stat 1 -->
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <h5 style="margin: 0 0 0.75rem 0; font-size: 0.85rem; color: var(--admin-gold); text-transform: uppercase;">Stat Card 01</h5>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Number / Metric</label>
                                    <input type="text" name="about_stat_1_num" class="form-control" value="<?= Format::e($about['about_stat_1_num'] ?? '20+') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Title</label>
                                    <input type="text" name="about_stat_1_title" class="form-control" value="<?= Format::e($about['about_stat_1_title'] ?? 'Years of Experience') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem;">Description</label>
                                    <textarea name="about_stat_1_desc" class="form-control" rows="2"><?= Format::e($about['about_stat_1_desc'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <!-- Stat 2 -->
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <h5 style="margin: 0 0 0.75rem 0; font-size: 0.85rem; color: var(--admin-gold); text-transform: uppercase;">Stat Card 02</h5>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Number / Metric</label>
                                    <input type="text" name="about_stat_2_num" class="form-control" value="<?= Format::e($about['about_stat_2_num'] ?? '10') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Title</label>
                                    <input type="text" name="about_stat_2_title" class="form-control" value="<?= Format::e($about['about_stat_2_title'] ?? 'Prime Enclaves Mastered') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem;">Description</label>
                                    <textarea name="about_stat_2_desc" class="form-control" rows="2"><?= Format::e($about['about_stat_2_desc'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <!-- Stat 3 -->
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <h5 style="margin: 0 0 0.75rem 0; font-size: 0.85rem; color: var(--admin-gold); text-transform: uppercase;">Stat Card 03</h5>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Number / Metric</label>
                                    <input type="text" name="about_stat_3_num" class="form-control" value="<?= Format::e($about['about_stat_3_num'] ?? '100%') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Title</label>
                                    <input type="text" name="about_stat_3_title" class="form-control" value="<?= Format::e($about['about_stat_3_title'] ?? 'Verified Clean Titles') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem;">Description</label>
                                    <textarea name="about_stat_3_desc" class="form-control" rows="2"><?= Format::e($about['about_stat_3_desc'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <!-- Stat 4 -->
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <h5 style="margin: 0 0 0.75rem 0; font-size: 0.85rem; color: var(--admin-gold); text-transform: uppercase;">Stat Card 04</h5>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Number / Metric</label>
                                    <input type="text" name="about_stat_4_num" class="form-control" value="<?= Format::e($about['about_stat_4_num'] ?? '1:1') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" style="font-size: 0.75rem;">Title</label>
                                    <input type="text" name="about_stat_4_title" class="form-control" value="<?= Format::e($about['about_stat_4_title'] ?? 'Partner-Led Advocacy') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 0.75rem;">Description</label>
                                    <textarea name="about_stat_4_desc" class="form-control" rows="2"><?= Format::e($about['about_stat_4_desc'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: OUR PHILOSOPHY -->
            <div class="admin-tab-pane" id="tab-philosophy">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 4: Our Philosophy &amp; Core Tenets</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_philosophy_eyebrow">Section Eyebrow</label>
                            <input type="text" name="about_philosophy_eyebrow" id="about_philosophy_eyebrow" class="form-control" value="<?= Format::e($about['about_philosophy_eyebrow'] ?? 'Our Philosophy') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_philosophy_title">Philosophy Headline Line 1 *</label>
                            <input type="text" name="about_philosophy_title" id="about_philosophy_title" class="form-control" value="<?= Format::e($about['about_philosophy_title'] ?? 'Real Estate Is Personal.') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_philosophy_title_italic">Headline Line 2 (Accent) *</label>
                        <input type="text" name="about_philosophy_title_italic" id="about_philosophy_title_italic" class="form-control" value="<?= Format::e($about['about_philosophy_title_italic'] ?? 'So Is Our Approach.') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_philosophy_lead_quote">Lead Philosophy Quotation *</label>
                        <input type="text" name="about_philosophy_lead_quote" id="about_philosophy_lead_quote" class="form-control" value="<?= Format::e($about['about_philosophy_lead_quote'] ?? 'We believe exceptional real estate experiences begin with understanding people.') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_philosophy_desc">Philosophy Paragraph *</label>
                        <textarea name="about_philosophy_desc" id="about_philosophy_desc" class="form-control" rows="3" required><?= Format::e($about['about_philosophy_desc'] ?? '') ?></textarea>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Core Tenets Checklist</h4>
                        <div class="grid-2">
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <label class="form-label" style="font-size: 0.75rem;">Tenet 01 Title</label>
                                <input type="text" name="about_philosophy_tenet1_num" class="form-control" value="<?= Format::e($about['about_philosophy_tenet1_num'] ?? '01 · Discretion') ?>" style="margin-bottom: 0.5rem;">
                                <label class="form-label" style="font-size: 0.75rem;">Tenet 01 Description</label>
                                <textarea name="about_philosophy_tenet1_desc" class="form-control" rows="2"><?= Format::e($about['about_philosophy_tenet1_desc'] ?? '') ?></textarea>
                            </div>
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <label class="form-label" style="font-size: 0.75rem;">Tenet 02 Title</label>
                                <input type="text" name="about_philosophy_tenet2_num" class="form-control" value="<?= Format::e($about['about_philosophy_tenet2_num'] ?? '02 · Selectivity') ?>" style="margin-bottom: 0.5rem;">
                                <label class="form-label" style="font-size: 0.75rem;">Tenet 02 Description</label>
                                <textarea name="about_philosophy_tenet2_desc" class="form-control" rows="2"><?= Format::e($about['about_philosophy_tenet2_desc'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Philosophy Image &amp; Brand Thesis Card</h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="about_philosophy_image">Image Path or URL</label>
                                <input type="text" name="about_philosophy_image" id="about_philosophy_image" class="form-control" value="<?= Format::e($about['about_philosophy_image'] ?? '/assets/images/stitch/about-cinematic-pause.jpg') ?>">
                                <input type="file" name="about_philosophy_image_file" class="form-control" style="margin-top: 0.35rem;" accept="image/*">
                            </div>
                            <div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" for="about_philosophy_card_eyebrow">Floating Card Eyebrow</label>
                                    <input type="text" name="about_philosophy_card_eyebrow" id="about_philosophy_card_eyebrow" class="form-control" value="<?= Format::e($about['about_philosophy_card_eyebrow'] ?? 'Brand Thesis') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" for="about_philosophy_card_quote">Floating Card Quote</label>
                                    <textarea name="about_philosophy_card_quote" id="about_philosophy_card_quote" class="form-control" rows="2"><?= Format::e($about['about_philosophy_card_quote'] ?? 'The most meaningful addresses are found through patience, discernment and trusted relationships.') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 5: WHY CHOOSE (6 PILLARS) -->
            <div class="admin-tab-pane" id="tab-why">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 5: Why Choose Elite Homez (6 Value Pillars)</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_why_eyebrow">Section Eyebrow</label>
                            <input type="text" name="about_why_eyebrow" id="about_why_eyebrow" class="form-control" value="<?= Format::e($about['about_why_eyebrow'] ?? 'Distinctive Value') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_why_title">Section Title *</label>
                            <input type="text" name="about_why_title" id="about_why_title" class="form-control" value="<?= Format::e($about['about_why_title'] ?? 'Why Choose Elite Homez') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_why_desc">Section Subtitle / Description</label>
                        <textarea name="about_why_desc" id="about_why_desc" class="form-control" rows="2"><?= Format::e($about['about_why_desc'] ?? '') ?></textarea>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">The 6 Distinctive Value Proposition Cards</h4>
                        <div class="grid-2" style="gap: 1.25rem;">
                            <!-- Pillar 1 -->
                            <div style="background: #FFFFFF; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--admin-gold);">PILLAR 01 (Wide Card)</span>
                                </div>
                                <div class="grid-2" style="margin-bottom: 0.5rem;">
                                    <input type="text" name="about_why_1_num" class="form-control" value="<?= Format::e($about['about_why_1_num'] ?? '01') ?>" placeholder="Number">
                                    <input type="text" name="about_why_1_tag" class="form-control" value="<?= Format::e($about['about_why_1_tag'] ?? 'Advisory Touch') ?>" placeholder="Tag">
                                </div>
                                <input type="text" name="about_why_1_title" class="form-control" value="<?= Format::e($about['about_why_1_title'] ?? 'Personalised Guidance') ?>" placeholder="Title" style="margin-bottom: 0.5rem;">
                                <textarea name="about_why_1_desc" class="form-control" rows="2" placeholder="Description"><?= Format::e($about['about_why_1_desc'] ?? '') ?></textarea>
                            </div>

                            <!-- Pillar 2 -->
                            <div style="background: #243F34; color: white; padding: 1rem; border-radius: 8px; border: 1px solid #B99A62;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #DFCF9F;">PILLAR 02 (Forest Green)</span>
                                </div>
                                <div class="grid-2" style="margin-bottom: 0.5rem;">
                                    <input type="text" name="about_why_2_num" class="form-control" value="<?= Format::e($about['about_why_2_num'] ?? '02') ?>" placeholder="Number">
                                    <input type="text" name="about_why_2_tag" class="form-control" value="<?= Format::e($about['about_why_2_tag'] ?? 'Specialisation') ?>" placeholder="Tag">
                                </div>
                                <input type="text" name="about_why_2_title" class="form-control" value="<?= Format::e($about['about_why_2_title'] ?? 'Luxury Property Focus') ?>" placeholder="Title" style="margin-bottom: 0.5rem;">
                                <textarea name="about_why_2_desc" class="form-control" rows="2" placeholder="Description"><?= Format::e($about['about_why_2_desc'] ?? '') ?></textarea>
                            </div>

                            <!-- Pillar 3 -->
                            <div style="background: #FFFFFF; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--admin-gold);">PILLAR 03</span>
                                </div>
                                <div class="grid-2" style="margin-bottom: 0.5rem;">
                                    <input type="text" name="about_why_3_num" class="form-control" value="<?= Format::e($about['about_why_3_num'] ?? '03') ?>" placeholder="Number">
                                    <input type="text" name="about_why_3_tag" class="form-control" value="<?= Format::e($about['about_why_3_tag'] ?? 'Micro-Market') ?>" placeholder="Tag">
                                </div>
                                <input type="text" name="about_why_3_title" class="form-control" value="<?= Format::e($about['about_why_3_title'] ?? 'Local Market Understanding') ?>" placeholder="Title" style="margin-bottom: 0.5rem;">
                                <textarea name="about_why_3_desc" class="form-control" rows="2" placeholder="Description"><?= Format::e($about['about_why_3_desc'] ?? '') ?></textarea>
                            </div>

                            <!-- Pillar 4 -->
                            <div style="background: #FFFFFF; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--admin-gold);">PILLAR 04 (Wide Card)</span>
                                </div>
                                <div class="grid-2" style="margin-bottom: 0.5rem;">
                                    <input type="text" name="about_why_4_num" class="form-control" value="<?= Format::e($about['about_why_4_num'] ?? '04') ?>" placeholder="Number">
                                    <input type="text" name="about_why_4_tag" class="form-control" value="<?= Format::e($about['about_why_4_tag'] ?? 'Competence') ?>" placeholder="Tag">
                                </div>
                                <input type="text" name="about_why_4_title" class="form-control" value="<?= Format::e($about['about_why_4_title'] ?? 'Professional Expertise') ?>" placeholder="Title" style="margin-bottom: 0.5rem;">
                                <textarea name="about_why_4_desc" class="form-control" rows="2" placeholder="Description"><?= Format::e($about['about_why_4_desc'] ?? '') ?></textarea>
                            </div>

                            <!-- Pillar 5 -->
                            <div style="background: #FFFFFF; padding: 1rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--admin-gold);">PILLAR 05</span>
                                </div>
                                <div class="grid-2" style="margin-bottom: 0.5rem;">
                                    <input type="text" name="about_why_5_num" class="form-control" value="<?= Format::e($about['about_why_5_num'] ?? '05') ?>" placeholder="Number">
                                    <input type="text" name="about_why_5_tag" class="form-control" value="<?= Format::e($about['about_why_5_tag'] ?? 'Integrity') ?>" placeholder="Tag">
                                </div>
                                <input type="text" name="about_why_5_title" class="form-control" value="<?= Format::e($about['about_why_5_title'] ?? 'Transparent Communication') ?>" placeholder="Title" style="margin-bottom: 0.5rem;">
                                <textarea name="about_why_5_desc" class="form-control" rows="2" placeholder="Description"><?= Format::e($about['about_why_5_desc'] ?? '') ?></textarea>
                            </div>

                            <!-- Pillar 6 -->
                            <div style="background: #171A18; color: white; padding: 1rem; border-radius: 8px; border: 1px solid #B99A62;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #DFCF9F;">PILLAR 06 (Charcoal Black)</span>
                                </div>
                                <div class="grid-2" style="margin-bottom: 0.5rem;">
                                    <input type="text" name="about_why_6_num" class="form-control" value="<?= Format::e($about['about_why_6_num'] ?? '06') ?>" placeholder="Number">
                                    <input type="text" name="about_why_6_tag" class="form-control" value="<?= Format::e($about['about_why_6_tag'] ?? 'Fiduciary Anchor') ?>" placeholder="Tag">
                                </div>
                                <input type="text" name="about_why_6_title" class="form-control" value="<?= Format::e($about['about_why_6_title'] ?? 'Client-First Approach') ?>" placeholder="Title" style="margin-bottom: 0.5rem;">
                                <textarea name="about_why_6_desc" class="form-control" rows="2" placeholder="Description"><?= Format::e($about['about_why_6_desc'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 6: ENCLAVES & REVIEWS INTROS -->
            <div class="admin-tab-pane" id="tab-atlas-reviews">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 6 &amp; 8: Service Areas &amp; Reviews Headers</h3>

                    <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; gap: 0.5rem; align-items: center; color: #1E40AF; font-weight: 600; font-size: 0.85rem;">
                            <?= SvgIcons::render('check-circle', 'w-4 h-4', 16) ?>
                            <span>Live Database Streaming Notice</span>
                        </div>
                        <p style="margin: 0.35rem 0 0 0; font-size: 0.8rem; color: #1E3A8A; line-height: 1.5;">
                            As mandated, the enclave cards themselves are dynamically fetched from the <strong>Areas database</strong> (<a href="<?= $baseUrl ?>/admin/areas" target="_blank" style="color: #2563EB; text-decoration: underline;">Manage Areas</a>), and review cards are dynamically fetched from the <strong>Testimonials database</strong> (<a href="<?= $baseUrl ?>/admin/testimonials" target="_blank" style="color: #2563EB; text-decoration: underline;">Manage Testimonials</a>). You can customise their section titles, subtitles, and view-all buttons below.
                        </p>
                    </div>

                    <h4 style="font-size: 0.95rem; margin-bottom: 0.75rem; color: var(--admin-navy);">Section 6: Service Areas Header</h4>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_areas_eyebrow">Eyebrow</label>
                            <input type="text" name="about_areas_eyebrow" id="about_areas_eyebrow" class="form-control" value="<?= Format::e($about['about_areas_eyebrow'] ?? 'Service Areas') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_areas_title">Title Line 1 *</label>
                            <input type="text" name="about_areas_title" id="about_areas_title" class="form-control" value="<?= Format::e($about['about_areas_title'] ?? 'Exceptional Addresses.') ?>" required>
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_areas_title_italic">Title Line 2 (Accent) *</label>
                            <input type="text" name="about_areas_title_italic" id="about_areas_title_italic" class="form-control" value="<?= Format::e($about['about_areas_title_italic'] ?? 'Distinctive Lifestyles.') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_areas_btn_text">Button Text</label>
                            <input type="text" name="about_areas_btn_text" id="about_areas_btn_text" class="form-control" value="<?= Format::e($about['about_areas_btn_text'] ?? 'View All Enclave Dossiers') ?>">
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_areas_desc">Description</label>
                            <textarea name="about_areas_desc" id="about_areas_desc" class="form-control" rows="2"><?= Format::e($about['about_areas_desc'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_areas_btn_link">Button Link URL</label>
                            <input type="text" name="about_areas_btn_link" id="about_areas_btn_link" class="form-control" value="<?= Format::e($about['about_areas_btn_link'] ?? '/locations') ?>">
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 0.75rem; color: var(--admin-navy);">Section 8: Testimonials / Reviews Header</h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="about_reviews_eyebrow">Eyebrow</label>
                                <input type="text" name="about_reviews_eyebrow" id="about_reviews_eyebrow" class="form-control" value="<?= Format::e($about['about_reviews_eyebrow'] ?? 'Client Trust') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_reviews_title">Section Title *</label>
                                <input type="text" name="about_reviews_title" id="about_reviews_title" class="form-control" value="<?= Format::e($about['about_reviews_title'] ?? 'Relationships Built on Trust.') ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_reviews_desc">Section Description</label>
                            <textarea name="about_reviews_desc" id="about_reviews_desc" class="form-control" rows="2"><?= Format::e($about['about_reviews_desc'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 7: DIRECTOR'S MESSAGE -->
            <div class="admin-tab-pane" id="tab-director">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 7: Director's Message &amp; Leadership Directorate</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_director_eyebrow">Eyebrow</label>
                            <input type="text" name="about_director_eyebrow" id="about_director_eyebrow" class="form-control" value="<?= Format::e($about['about_director_eyebrow'] ?? 'Leadership & Vision') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_director_title">Headline Line 1 *</label>
                            <input type="text" name="about_director_title" id="about_director_title" class="form-control" value="<?= Format::e($about['about_director_title'] ?? 'A Commitment to Trust,') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_director_title_italic">Headline Line 2 (Accent) *</label>
                        <input type="text" name="about_director_title_italic" id="about_director_title_italic" class="form-control" value="<?= Format::e($about['about_director_title_italic'] ?? 'Excellence and Relationships.') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_director_quote">Director's Core Blockquote *</label>
                        <textarea name="about_director_quote" id="about_director_quote" class="form-control" rows="2" required><?= Format::e($about['about_director_quote'] ?? 'When a family entrusts us with their residential acquisition or disposition, they are not simply commissioning a transaction—they are placing their privacy, capital, and family legacy in our care.') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_director_p1">Letter Paragraph 1 *</label>
                        <textarea name="about_director_p1" id="about_director_p1" class="form-control" rows="3" required><?= Format::e($about['about_director_p1'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_director_p2">Letter Paragraph 2 *</label>
                        <textarea name="about_director_p2" id="about_director_p2" class="form-control" rows="2" required><?= Format::e($about['about_director_p2'] ?? '') ?></textarea>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Sign-off Directorate &amp; Credentials</h4>
                        <div class="grid-3">
                            <div class="form-group">
                                <label class="form-label" for="about_director_signoff_name">Directorate Name</label>
                                <input type="text" name="about_director_signoff_name" id="about_director_signoff_name" class="form-control" value="<?= Format::e($about['about_director_signoff_name'] ?? 'Senior Advisory Directorate') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_director_signoff_title">Title / Role</label>
                                <input type="text" name="about_director_signoff_title" id="about_director_signoff_title" class="form-control" value="<?= Format::e($about['about_director_signoff_title'] ?? 'Managing Principals · Elite Homez') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_director_signoff_sub">Regulatory RERA Line</label>
                                <input type="text" name="about_director_signoff_sub" id="about_director_signoff_sub" class="form-control" value="<?= Format::e($about['about_director_signoff_sub'] ?? 'RERA Registered Real Estate Advisory · {rera}') ?>">
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Director Portrait &amp; Floating Badge</h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="about_director_image">Director Portrait Image</label>
                                <input type="text" name="about_director_image" id="about_director_image" class="form-control" value="<?= Format::e($about['about_director_image'] ?? '/assets/images/about/director.jpg') ?>">
                                <input type="file" name="about_director_image_file" class="form-control" style="margin-top: 0.35rem;" accept="image/*">
                            </div>
                            <div>
                                <div class="form-group" style="margin-bottom: 0.5rem;">
                                    <label class="form-label" for="about_director_badge_title">Floating Badge Title</label>
                                    <input type="text" name="about_director_badge_title" id="about_director_badge_title" class="form-control" value="<?= Format::e($about['about_director_badge_title'] ?? 'Fiduciary Leadership') ?>">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" for="about_director_badge_quote">Floating Badge Quote</label>
                                    <input type="text" name="about_director_badge_quote" id="about_director_badge_quote" class="form-control" value="<?= Format::e($about['about_director_badge_quote'] ?? 'Protecting privacy, capital and family legacy across generations.') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 8: FINAL CALL TO ACTION -->
            <div class="admin-tab-pane" id="tab-cta">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Section 9: Final Call to Action (Bottom Banner)</h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="about_cta_eyebrow">Eyebrow Badge</label>
                            <input type="text" name="about_cta_eyebrow" id="about_cta_eyebrow" class="form-control" value="<?= Format::e($about['about_cta_eyebrow'] ?? 'Private Advisory Mandates') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_cta_title">Heading Line 1 *</label>
                            <input type="text" name="about_cta_title" id="about_cta_title" class="form-control" value="<?= Format::e($about['about_cta_title'] ?? 'Your Next Chapter Begins') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_cta_title_italic">Heading Line 2 (Accent) *</label>
                        <input type="text" name="about_cta_title_italic" id="about_cta_title_italic" class="form-control" value="<?= Format::e($about['about_cta_title_italic'] ?? 'with the Right Address.') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_cta_desc">Description *</label>
                        <textarea name="about_cta_desc" id="about_cta_desc" class="form-control" rows="2" required><?= Format::e($about['about_cta_desc'] ?? '') ?></textarea>
                    </div>

                    <div class="grid-3" style="margin-top: 1rem;">
                        <div class="form-group">
                            <label class="form-label" for="about_cta_btn1_text">Button 1 Text</label>
                            <input type="text" name="about_cta_btn1_text" id="about_cta_btn1_text" class="form-control" value="<?= Format::e($about['about_cta_btn1_text'] ?? 'Explore Properties') ?>">
                            <label class="form-label" for="about_cta_btn1_link" style="margin-top: 0.35rem; font-size: 0.75rem;">Button 1 Link</label>
                            <input type="text" name="about_cta_btn1_link" id="about_cta_btn1_link" class="form-control" value="<?= Format::e($about['about_cta_btn1_link'] ?? '/properties') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_cta_btn2_text">Button 2 Text</label>
                            <input type="text" name="about_cta_btn2_text" id="about_cta_btn2_text" class="form-control" value="<?= Format::e($about['about_cta_btn2_text'] ?? 'Contact Our Team') ?>">
                            <label class="form-label" for="about_cta_btn2_link" style="margin-top: 0.35rem; font-size: 0.75rem;">Button 2 Link</label>
                            <input type="text" name="about_cta_btn2_link" id="about_cta_btn2_link" class="form-control" value="<?= Format::e($about['about_cta_btn2_link'] ?? '/contact-us') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_cta_btn3_text">WhatsApp Button Text</label>
                            <input type="text" name="about_cta_btn3_text" id="about_cta_btn3_text" class="form-control" value="<?= Format::e($about['about_cta_btn3_text'] ?? 'WhatsApp Concierge') ?>">
                            <label class="form-label" for="about_cta_btn3_link" style="margin-top: 0.35rem; font-size: 0.75rem;">Custom WhatsApp URL</label>
                            <input type="text" name="about_cta_btn3_link" id="about_cta_btn3_link" class="form-control" value="<?= Format::e($about['about_cta_btn3_link'] ?? '') ?>" placeholder="Leave empty for auto wa.me">
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Footer Trust Badges (3 Items)</h4>
                        <div class="grid-3">
                            <div class="form-group">
                                <label class="form-label" for="about_cta_note1">Trust Badge 1</label>
                                <input type="text" name="about_cta_note1" id="about_cta_note1" class="form-control" value="<?= Format::e($about['about_cta_note1'] ?? 'Direct Senior Partner Access') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_cta_note2">Trust Badge 2</label>
                                <input type="text" name="about_cta_note2" id="about_cta_note2" class="form-control" value="<?= Format::e($about['about_cta_note2'] ?? 'Bilateral NDA Protocols') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_cta_note3">Trust Badge 3</label>
                                <input type="text" name="about_cta_note3" id="about_cta_note3" class="form-control" value="<?= Format::e($about['about_cta_note3'] ?? 'RERA Certified') ?>">
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border);">
                        <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">CTA Background Architectural Dusk Image</h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label" for="about_cta_image">Image Path or URL</label>
                                <input type="text" name="about_cta_image" id="about_cta_image" class="form-control" value="<?= Format::e($about['about_cta_image'] ?? '/assets/images/stitch/service-cta-dusk.jpg') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="about_cta_image_file">Upload New Image</label>
                                <input type="file" name="about_cta_image_file" id="about_cta_image_file" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 9: SEO & METADATA -->
            <div class="admin-tab-pane" id="tab-seo">
                <div class="admin-card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--admin-navy);">Search Engine Optimization (SEO) &amp; OpenGraph</h3>

                    <div class="form-group">
                        <label class="form-label" for="about_seo_title">Meta Browser Title</label>
                        <input type="text" name="about_seo_title" id="about_seo_title" class="form-control" value="<?= Format::e($about['about_seo_title'] ?? 'About Elite Homez | Where Exceptional Homes Meet Exceptional Experiences') ?>">
                        <small class="form-text">Recommended 50-60 characters for maximum search visibility.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_seo_description">Meta Description</label>
                        <textarea name="about_seo_description" id="about_seo_description" class="form-control" rows="3"><?= Format::e($about['about_seo_description'] ?? 'Discover Elite Homez — two decades of trusted advisory, unparalleled discretion, and personalised luxury real estate expertise across South Delhi.') ?></textarea>
                        <small class="form-text">Concise summary shown under page title in Google and social shares.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar Action & Preview Panels -->
        <div class="admin-form-sidebar">
            <div class="admin-card sticky-sidebar" style="position: sticky; top: 1.5rem;">
                <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--admin-navy);">Save &amp; Publish</h4>
                <p style="font-size: 0.8rem; color: var(--admin-text-muted); line-height: 1.5; margin-bottom: 1rem;">
                    All modifications to copy, metrics, and images are immediately published to the live About Us page upon saving.
                </p>

                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        Save All Changes
                    </button>
                    <a href="<?= $baseUrl ?>/about-us" target="_blank" class="btn btn-outline" style="width: 100%; justify-content: center; font-size: 0.8rem;">
                        <?= SvgIcons::render('eye', 'w-3 h-3', 14) ?> View Live Page
                    </a>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--admin-border); font-size: 0.75rem; color: var(--admin-text-muted);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span>Page URL:</span>
                        <a href="<?= $baseUrl ?>/about-us" target="_blank" style="color: var(--admin-gold); font-weight: 600;">/about-us</a>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span>Enclaves Source:</span>
                        <span style="font-weight: 600; color: #166534;">areas table</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Reviews Source:</span>
                        <span style="font-weight: 600; color: #166534;">testimonials table</span>
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
