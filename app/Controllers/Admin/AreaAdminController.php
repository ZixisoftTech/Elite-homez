<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\Session;
use App\Helpers\Uploader;
use App\Models\Area;

class AreaAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $areaModel = new Area();
        $areas = $areaModel->allWithCount();

        $this->renderAdmin('admin/areas/index', [
            'areas' => $areas,
            'seo' => ['title' => 'Locations & Enclaves | Elite Homez Admin']
        ]);
    }

    public function create(): void {
        $this->requireAuth();
        $this->renderAdmin('admin/areas/create', [
            'seo' => ['title' => 'Add Location | Elite Homez Admin']
        ]);
    }

    public function store(): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/areas/create');
            return;
        }

        $name = trim((string) $this->request->post('name', ''));
        if (empty($name)) {
            Session::setFlash('error', 'Location / Enclave name is required.');
            $this->redirect('/admin/areas/create');
            return;
        }

        $slugInput = trim((string) $this->request->post('slug', ''));
        $slug = !empty($slugInput) ? Format::slug($slugInput) : Format::slug($name);
        $areaModel = new Area();
        if ($areaModel->findBySlug($slug)) {
            $slug .= '-' . rand(10, 99);
        }

        $sortOrder = (int) $this->request->post('sort_order', 1);
        $monographIndex = str_pad((string)$sortOrder, 2, '0', STR_PAD_LEFT);

        $shortDesc = trim((string) $this->request->post('short_description', ''));
        $heroTitle = trim((string) $this->request->post('hero_title', ''));
        $heroSubtitle = trim((string) $this->request->post('hero_subtitle', ''));
        $heroMonograph = trim((string) $this->request->post('hero_monograph_text', ''));
        $heroImageAlt = trim((string) $this->request->post('hero_image_alt', ''));
        $overview = trim((string) $this->request->post('overview', ''));
        $propertyMarket = trim((string) $this->request->post('property_market', ''));
        $fiduciaryNote = trim((string) $this->request->post('fiduciary_note', ''));
        $lifestyle = trim((string) $this->request->post('lifestyle', ''));
        $connectivity = trim((string) $this->request->post('connectivity', ''));
        $landmarks = trim((string) $this->request->post('nearby_landmarks', ''));
        $advisoryContent = trim((string) $this->request->post('advisory_content', ''));
        $mapUrl = trim((string) $this->request->post('map_url', ''));
        $isPublished = $this->request->post('is_published') ? 1 : 0;
        $showOnHome = $this->request->post('show_on_home') ? 1 : 0;
        $seoTitle = trim((string) $this->request->post('seo_title', ''));
        $metaDesc = trim((string) $this->request->post('meta_description', ''));
        $primaryKeyword = trim((string) $this->request->post('primary_keyword', ''));
        $secondaryKeywords = trim((string) $this->request->post('secondary_keywords', ''));

        // Handle image upload
        $directHeroImage = trim((string) ($this->request->post('hero_image_url') ?: $this->request->post('hero_image_path') ?: ''));
        $heroImage = !empty($directHeroImage) ? $directHeroImage : '/assets/images/areas/vasant-vihar.jpg';
        $file = $this->request->file('hero_image');
        if ($file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($file, 'areas');
            if ($upload['success']) {
                $heroImage = $upload['url'];
            }
        }

        // Process repeater & array fields
        $processRepeater = function($field, $default = []) {
            $val = $this->request->post($field);
            if (is_array($val)) {
                $cleaned = [];
                foreach ($val as $item) {
                    if (is_array($item)) {
                        $hasContent = false;
                        foreach ($item as $k => $v) {
                            if (trim((string)$v) !== '') { $hasContent = true; break; }
                        }
                        if ($hasContent) $cleaned[] = $item;
                    } elseif (is_string($item) && trim($item) !== '') {
                        $cleaned[] = trim($item);
                    }
                }
                return json_encode(array_values($cleaned), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
            if (is_string($val) && trim($val) !== '') {
                $decoded = json_decode(trim($val), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                }
            }
            return !empty($default) ? json_encode($default, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;
        };

        $heroMetrics = $processRepeater('hero_metrics', [
            ['label' => 'Active Mandates', 'value' => 'Off-Market'],
            ['label' => 'Title Status', 'value' => 'Freehold'],
            ['label' => 'Zoning', 'value' => 'Low Density'],
            ['label' => 'Security', 'value' => 'Diplomatic A1']
        ]);

        $characterHighlights = $processRepeater('character_highlights', [
            'Strict Residential Zoning',
            'High Owner-Occupancy',
            'Off-Market Mandates'
        ]);

        $propertyTypes = $processRepeater('property_types', [
            [
                'title' => 'Independent Luxury Bungalows',
                'description' => 'Detached multi-level private residences featuring generous front setbacks, perimeter security, landscaped wrap-around lawns, and multi-car parking.',
                'buyer_profile' => 'Prominent business families, industrial leaders, and diplomatic foreign missions seeking compound security.',
                'cta_text' => 'Inquire for Off-Market Bungalows',
                'cta_link' => '/contact-us?subject=' . urlencode("{$name} Bungalow Inquiry")
            ],
            [
                'title' => 'Full-Floor Luxury Builder Residences',
                'description' => 'Bespoke single-floor apartments measuring 3,500 to 8,000 sq ft, equipped with private high-speed elevators, imported Italian marble, and separate staff quarters.',
                'buyer_profile' => 'C-suite executives, senior corporate counsel, and luxury homeowners requiring effortless turnkey living.',
                'cta_text' => 'Explore Builder Floors',
                'cta_link' => '/properties?area=' . $slug
            ],
            [
                'title' => 'Park-Facing Penthouses with Terraces',
                'description' => 'Top-tier duplex and single-level penthouse homes with exclusive roof rights, cantilevered pergolas, curated sky decks, and unobstructed views.',
                'buyer_profile' => 'Affluent entrepreneurs and NRI investors looking for distinctive architectural trophy assets.',
                'cta_text' => 'Request Penthouse Dossier',
                'cta_link' => '/contact-us?subject=' . urlencode("{$name} Penthouse Inquiry")
            ]
        ]);

        $plotSizes = $processRepeater('plot_sizes', [
            ['type' => 'Compact Enclave Plots', 'size' => '400 - 600 Sq. Yards', 'description' => 'Ideal for luxury duplex development or modern bespoke multi-level residences.'],
            ['type' => 'Standard Prime Plots', 'size' => '800 - 1,200 Sq. Yards', 'description' => 'The hallmark plot footprint supporting grand detached bungalows with expansive lawns.'],
            ['type' => 'Flagship Estate Plots', 'size' => '1,500 - 2,500+ Sq. Yards', 'description' => 'Rare landmark parcels offering total diplomatic security, perimeter shielding, and private pavilions.']
        ]);

        $faqs = $processRepeater('faqs', [
            [
                'question' => "What is the typical property structure available in {$name}?",
                'answer' => "{$name} predominantly offers independent luxury builder floors (single-floor apartments on 400 to 1,200 sq. yard plots) and detached legacy bungalows."
            ],
            [
                'question' => "Are properties in {$name} freehold?",
                'answer' => "Yes, the vast majority of residential plots and builder floors in {$name} are freehold properties with registered conveyance deeds."
            ],
            [
                'question' => "How does Elite Homez verify property documentation in {$name}?",
                'answer' => 'Our legal advisory team conducts 30-year title searches, verifies chain of ownership, confirms sanctioned building plans, and reviews completion certificates.'
            ]
        ]);

        $newId = $areaModel->create([
            'name' => $name,
            'slug' => $slug,
            'hero_title' => $heroTitle ?: "{$name}: Luxury Residential Enclave South Delhi",
            'hero_subtitle' => $heroSubtitle ?: $shortDesc,
            'hero_monograph_text' => $heroMonograph ?: "Territory Monograph {$monographIndex} · South Delhi",
            'hero_metrics' => $heroMetrics,
            'hero_image' => $heroImage,
            'hero_image_alt' => $heroImageAlt ?: "{$name} Luxury Real Estate South Delhi",
            'short_description' => $shortDesc ?: "Benchmark South Delhi address defined by wide tree-canopied avenues and prime residential estates.",
            'overview' => $overview ?: "{$name} is one of South Delhi's most prestigious and sought-after residential enclaves, celebrated for wide avenues and premier privacy.",
            'detailed_description' => $overview ?: "{$name} is one of South Delhi's most prestigious and sought-after residential enclaves.",
            'character_highlights' => $characterHighlights,
            'property_market' => $propertyMarket ?: "The {$name} residential micro-market is characterized by high owner-occupancy, limited turnover, and enduring capital preservation.",
            'property_info' => $propertyMarket ?: "The {$name} residential micro-market.",
            'fiduciary_note' => $fiduciaryNote ?: "Property values in {$name} vary significantly based on plot size, road width, frontage, construction quality, location within the neighbourhood, and property condition. Contact Elite Homez for current property-specific guidance.",
            'property_types' => $propertyTypes,
            'property_types_eyebrow' => trim((string)$this->request->post('property_types_eyebrow', 'Residential Asset Categories')) ?: 'Residential Asset Categories',
            'property_types_title' => trim((string)$this->request->post('property_types_title', "Typical Property Formats in {$name}")) ?: "Typical Property Formats in {$name}",
            'plot_sizes' => $plotSizes,
            'plot_sizes_eyebrow' => trim((string)$this->request->post('plot_sizes_eyebrow', 'Spatial Typologies')) ?: 'Spatial Typologies',
            'plot_sizes_title' => trim((string)$this->request->post('plot_sizes_title', "Typical Residential Plot Sizes in {$name}")) ?: "Typical Residential Plot Sizes in {$name}",
            'plot_sizes_description' => trim((string)$this->request->post('plot_sizes_description', "Plot footprints in {$name} dictate permissible floor area ratio (FAR), setback requirements, and basement depth. Available property sizes vary considerably across individual listings.")),
            'lifestyle' => $lifestyle ?: "The neighborhood offers quiet tree-canopied residential living with premier social infrastructure, private parks, and dedicated community facilities.",
            'lifestyle_eyebrow' => trim((string)$this->request->post('lifestyle_eyebrow', 'Neighborhood Ambiance')) ?: 'Neighborhood Ambiance',
            'lifestyle_title' => trim((string)$this->request->post('lifestyle_title', "Lifestyle & Community in {$name}")) ?: "Lifestyle & Community in {$name}",
            'connectivity' => $connectivity ?: "Well-positioned with convenient access to major arterial routes, metro stations, and key South Delhi commercial corridors.",
            'connectivity_eyebrow' => trim((string)$this->request->post('connectivity_eyebrow', 'Arterial Infrastructure')) ?: 'Arterial Infrastructure',
            'connectivity_title' => trim((string)$this->request->post('connectivity_title', 'Connectivity & Transit Links')) ?: 'Connectivity & Transit Links',
            'nearby_landmarks' => $landmarks ?: "Embassy compounds, prestigious clubs, landmark parks, cultural institutions.",
            'advisory_content' => $advisoryContent ?: "Elite Homez maintains direct relationships with multi-generational resident owners and premier developers in {$name}. We operate off-market to present verified residential assets with complete discretion.",
            'banner_eyebrow' => trim((string)$this->request->post('banner_eyebrow', 'Elite Homez Private Office')) ?: 'Elite Homez Private Office',
            'banner_title' => trim((string)$this->request->post('banner_title', 'Local Knowledge. Better Property Decisions.')) ?: 'Local Knowledge. Better Property Decisions.',
            'banner_description' => trim((string)$this->request->post('banner_description', '')) ?: "Elite Homez maintains direct relationships with multi-generational resident owners and premier developers in {$name}. We operate off-market to present verified residential assets with complete discretion.",
            'banner_btn1_text' => trim((string)$this->request->post('banner_btn1_text', 'Initiate Private Mandate')) ?: 'Initiate Private Mandate',
            'banner_btn1_url' => trim((string)$this->request->post('banner_btn1_url', '')) ?: "/contact-us?subject=" . urlencode("{$name} Confidential Advisory"),
            'banner_btn2_text' => trim((string)$this->request->post('banner_btn2_text', 'Call Advisory Desk')) ?: 'Call Advisory Desk',
            'banner_btn2_url' => trim((string)$this->request->post('banner_btn2_url', '')) ?: 'tel:+911149008800',
            'faqs' => $faqs,
            'faqs_eyebrow' => trim((string)$this->request->post('faqs_eyebrow', 'Local Advisory Insights')) ?: 'Local Advisory Insights',
            'faqs_title' => trim((string)$this->request->post('faqs_title', "Frequently Asked Questions: {$name}")) ?: "Frequently Asked Questions: {$name}",
            'cta_eyebrow' => trim((string)$this->request->post('cta_eyebrow', 'Fiduciary Client Representation')) ?: 'Fiduciary Client Representation',
            'cta_title' => trim((string)$this->request->post('cta_title', "Begin Your Residential Search in {$name}")) ?: "Begin Your Residential Search in {$name}",
            'cta_description' => trim((string)$this->request->post('cta_description', '')) ?: "Whether seeking an off-market independent bungalow or a bespoke modern builder floor, Elite Homez provides verified confidential guidance.",
            'cta_btn1_text' => trim((string)$this->request->post('cta_btn1_text', 'Share Your Requirement')) ?: 'Share Your Requirement',
            'cta_btn1_url' => trim((string)$this->request->post('cta_btn1_url', '')) ?: "/contact-us?subject=" . urlencode("Direct Inquiry: {$name}"),
            'cta_btn2_text' => trim((string)$this->request->post('cta_btn2_text', 'WhatsApp Advisory')) ?: 'WhatsApp Advisory',
            'cta_btn2_url' => trim((string)$this->request->post('cta_btn2_url', '')) ?: "https://wa.me/919811000000?text=" . urlencode("Hello, I would like to inquire about luxury properties in {$name}."),
            'map_url' => $mapUrl,
            'is_published' => $isPublished,
            'show_on_home' => $showOnHome,
            'sort_order' => $sortOrder,
            'seo_title' => $seoTitle ?: "Luxury Properties in {$name} | Elite Homez",
            'meta_description' => $metaDesc ?: substr(strip_tags($shortDesc ?: $overview), 0, 160),
            'primary_keyword' => $primaryKeyword ?: "luxury property in {$name}",
            'secondary_keywords' => $secondaryKeywords
        ]);

        Session::setFlash('success', "Location '{$name}' created successfully.");
        $this->redirect('/admin/areas');
    }

    public function edit(string $id): void {
        $this->requireAuth();
        $areaModel = new Area();
        $area = $areaModel->find((int) $id);
        if (!$area) {
            Session::setFlash('error', 'Location not found.');
            $this->redirect('/admin/areas');
            return;
        }

        $this->renderAdmin('admin/areas/edit', [
            'area' => $area,
            'seo' => ['title' => "Edit {$area['name']} | Elite Homez Admin"]
        ]);
    }

    public function update(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect("/admin/areas/edit/{$id}");
            return;
        }

        $areaModel = new Area();
        $area = $areaModel->find((int) $id);
        if (!$area) {
            Session::setFlash('error', 'Location not found.');
            $this->redirect('/admin/areas');
            return;
        }

        $name = trim((string) $this->request->post('name', ''));
        if (empty($name)) {
            Session::setFlash('error', 'Location name is required.');
            $this->redirect("/admin/areas/edit/{$id}");
            return;
        }

        $slugInput = trim((string) $this->request->post('slug', ''));
        $slug = !empty($slugInput) ? Format::slug($slugInput) : $area['slug'];
        $sortOrder = (int) $this->request->post('sort_order', $area['sort_order'] ?? 1);
        $monographIndex = str_pad((string)$sortOrder, 2, '0', STR_PAD_LEFT);

        $shortDesc = trim((string) $this->request->post('short_description', ''));
        $heroTitle = trim((string) $this->request->post('hero_title', ''));
        $heroSubtitle = trim((string) $this->request->post('hero_subtitle', ''));
        $heroMonograph = trim((string) $this->request->post('hero_monograph_text', ''));
        $heroImageAlt = trim((string) $this->request->post('hero_image_alt', ''));
        $overview = trim((string) $this->request->post('overview', ''));
        $propertyMarket = trim((string) $this->request->post('property_market', ''));
        $fiduciaryNote = trim((string) $this->request->post('fiduciary_note', ''));
        $lifestyle = trim((string) $this->request->post('lifestyle', ''));
        $connectivity = trim((string) $this->request->post('connectivity', ''));
        $landmarks = trim((string) $this->request->post('nearby_landmarks', ''));
        $advisoryContent = trim((string) $this->request->post('advisory_content', ''));
        $mapUrl = trim((string) $this->request->post('map_url', ''));
        $isPublished = $this->request->post('is_published') ? 1 : 0;
        $showOnHome = $this->request->post('show_on_home') ? 1 : 0;
        $seoTitle = trim((string) $this->request->post('seo_title', ''));
        $metaDesc = trim((string) $this->request->post('meta_description', ''));
        $primaryKeyword = trim((string) $this->request->post('primary_keyword', ''));
        $secondaryKeywords = trim((string) $this->request->post('secondary_keywords', ''));

        // Handle image upload
        $directHeroImage = trim((string) ($this->request->post('hero_image_url') ?: $this->request->post('hero_image_path') ?: ''));
        $heroImage = !empty($directHeroImage) ? $directHeroImage : (!empty($area['hero_image']) ? $area['hero_image'] : '/assets/images/areas/vasant-vihar.jpg');
        $file = $this->request->file('hero_image');
        if ($file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($file, 'areas');
            if ($upload['success']) {
                $heroImage = $upload['url'];
            }
        }

        // Process repeater & array fields
        $processRepeater = function($field, $existingVal = null) {
            $val = $this->request->post($field);
            if (is_array($val)) {
                $cleaned = [];
                foreach ($val as $item) {
                    if (is_array($item)) {
                        $hasContent = false;
                        foreach ($item as $k => $v) {
                            if (trim((string)$v) !== '') { $hasContent = true; break; }
                        }
                        if ($hasContent) $cleaned[] = $item;
                    } elseif (is_string($item) && trim($item) !== '') {
                        $cleaned[] = trim($item);
                    }
                }
                return json_encode(array_values($cleaned), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
            if (is_string($val) && trim($val) !== '') {
                $decoded = json_decode(trim($val), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                }
            }
            return $existingVal;
        };

        $heroMetrics = $processRepeater('hero_metrics', $area['hero_metrics'] ?? null);
        $characterHighlights = $processRepeater('character_highlights', $area['character_highlights'] ?? null);
        $propertyTypes = $processRepeater('property_types', $area['property_types'] ?? null);
        $plotSizes = $processRepeater('plot_sizes', $area['plot_sizes'] ?? null);
        $faqs = $processRepeater('faqs', $area['faqs'] ?? null);

        $areaModel->update((int) $id, [
            'name' => $name,
            'slug' => $slug,
            'hero_title' => $heroTitle ?: "{$name}: Luxury Residential Enclave South Delhi",
            'hero_subtitle' => $heroSubtitle ?: $shortDesc,
            'hero_monograph_text' => $heroMonograph ?: "Territory Monograph {$monographIndex} · South Delhi",
            'hero_metrics' => $heroMetrics,
            'hero_image' => $heroImage,
            'hero_image_alt' => $heroImageAlt ?: "{$name} Luxury Real Estate South Delhi",
            'short_description' => $shortDesc,
            'overview' => $overview,
            'detailed_description' => $overview,
            'character_highlights' => $characterHighlights,
            'property_market' => $propertyMarket,
            'property_info' => $propertyMarket,
            'fiduciary_note' => $fiduciaryNote,
            'property_types' => $propertyTypes,
            'property_types_eyebrow' => trim((string)$this->request->post('property_types_eyebrow', 'Residential Asset Categories')),
            'property_types_title' => trim((string)$this->request->post('property_types_title', "Typical Property Formats in {$name}")),
            'plot_sizes' => $plotSizes,
            'plot_sizes_eyebrow' => trim((string)$this->request->post('plot_sizes_eyebrow', 'Spatial Typologies')),
            'plot_sizes_title' => trim((string)$this->request->post('plot_sizes_title', "Typical Residential Plot Sizes in {$name}")),
            'plot_sizes_description' => trim((string)$this->request->post('plot_sizes_description', '')),
            'lifestyle' => $lifestyle,
            'lifestyle_eyebrow' => trim((string)$this->request->post('lifestyle_eyebrow', 'Neighborhood Ambiance')),
            'lifestyle_title' => trim((string)$this->request->post('lifestyle_title', "Lifestyle & Community in {$name}")),
            'connectivity' => $connectivity,
            'connectivity_eyebrow' => trim((string)$this->request->post('connectivity_eyebrow', 'Arterial Infrastructure')),
            'connectivity_title' => trim((string)$this->request->post('connectivity_title', 'Connectivity & Transit Links')),
            'nearby_landmarks' => $landmarks,
            'advisory_content' => $advisoryContent,
            'banner_eyebrow' => trim((string)$this->request->post('banner_eyebrow', 'Elite Homez Private Office')),
            'banner_title' => trim((string)$this->request->post('banner_title', 'Local Knowledge. Better Property Decisions.')),
            'banner_description' => trim((string)$this->request->post('banner_description', '')),
            'banner_btn1_text' => trim((string)$this->request->post('banner_btn1_text', 'Initiate Private Mandate')),
            'banner_btn1_url' => trim((string)$this->request->post('banner_btn1_url', '')),
            'banner_btn2_text' => trim((string)$this->request->post('banner_btn2_text', 'Call Advisory Desk')),
            'banner_btn2_url' => trim((string)$this->request->post('banner_btn2_url', '')),
            'faqs' => $faqs,
            'faqs_eyebrow' => trim((string)$this->request->post('faqs_eyebrow', 'Local Advisory Insights')),
            'faqs_title' => trim((string)$this->request->post('faqs_title', "Frequently Asked Questions: {$name}")),
            'cta_eyebrow' => trim((string)$this->request->post('cta_eyebrow', 'Fiduciary Client Representation')),
            'cta_title' => trim((string)$this->request->post('cta_title', "Begin Your Residential Search in {$name}")),
            'cta_description' => trim((string)$this->request->post('cta_description', '')),
            'cta_btn1_text' => trim((string)$this->request->post('cta_btn1_text', 'Share Your Requirement')),
            'cta_btn1_url' => trim((string)$this->request->post('cta_btn1_url', '')),
            'cta_btn2_text' => trim((string)$this->request->post('cta_btn2_text', 'WhatsApp Advisory')),
            'cta_btn2_url' => trim((string)$this->request->post('cta_btn2_url', '')),
            'map_url' => $mapUrl,
            'is_published' => $isPublished,
            'show_on_home' => $showOnHome,
            'sort_order' => $sortOrder,
            'seo_title' => $seoTitle ?: "Luxury Properties in {$name} | Elite Homez",
            'meta_description' => $metaDesc ?: substr(strip_tags($shortDesc ?: $overview), 0, 160),
            'primary_keyword' => $primaryKeyword ?: "luxury property in {$name}",
            'secondary_keywords' => $secondaryKeywords
        ]);

        Session::setFlash('success', "Location '{$name}' updated successfully.");
        $this->redirect("/admin/areas/edit/{$id}");
    }

    public function toggleStatus(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/areas');
            return;
        }

        $areaModel = new Area();
        $area = $areaModel->find((int) $id);
        if ($area) {
            $newPublished = !empty($area['is_published']) ? 0 : 1;
            $areaModel->update((int) $id, ['is_published' => $newPublished]);
            $statusLabel = $newPublished ? 'Published' : 'Inactive (Draft)';
            Session::setFlash('success', "Location '{$area['name']}' status changed to {$statusLabel}.");
        }
        $this->redirect('/admin/areas');
    }

    public function toggleShowOnHome(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/areas');
            return;
        }

        $areaModel = new Area();
        $area = $areaModel->find((int) $id);
        if ($area) {
            $newShow = !empty($area['show_on_home']) ? 0 : 1;
            $areaModel->update((int) $id, ['show_on_home' => $newShow]);
            $label = $newShow ? 'Tagged to display on Homepage' : 'Removed from Homepage display';
            Session::setFlash('success', "Location '{$area['name']}': {$label}.");
        }
        $this->redirect('/admin/areas');
    }

    public function delete(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/areas');
            return;
        }

        $areaModel = new Area();
        $props = $areaModel->getProperties((int) $id);
        if (!empty($props)) {
            Session::setFlash('error', 'Cannot delete this location as it has ' . count($props) . ' active property listing(s) assigned to it. Reassign or remove those properties first.');
            $this->redirect('/admin/areas');
            return;
        }

        $area = $areaModel->find((int)$id);
        $name = $area['name'] ?? 'Location';
        $areaModel->delete((int) $id);
        Session::setFlash('success', "Location '{$name}' deleted successfully.");
        $this->redirect('/admin/areas');
    }
}
