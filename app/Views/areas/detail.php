<?php
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$settings = $siteSettings ?? [];
$phone = $settings['phone_primary'] ?? '+91 (0) 11 4900 8800';
$phone = $settings['phone_primary'] ?? '+91 9811044200';
$cleanPhone = preg_replace('/[^0-9\+]/', '', $phone);
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$cleanWa = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($cleanWa) === 10) {
    $cleanWa = '91' . $cleanWa;
}

// Helper for resolving image paths
$getImgSrc = function(?string $path, string $default) use ($baseUrl) {
    if (empty($path)) return $baseUrl . $default;
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
    return $baseUrl . '/' . ltrim($path, '/');
};

$areaName = $area['name'] ?? 'South Delhi Enclave';
$heroImgSrc = $getImgSrc($area['hero_image'] ?? null, '/assets/images/areas/vasant-vihar.jpg');
$heroImgAlt = !empty($area['hero_image_alt']) ? $area['hero_image_alt'] : ($areaName . ' Luxury Real Estate South Delhi');

$sortNum = (int)($area['sort_order'] ?? 1);
$monographIndex = str_pad((string)$sortNum, 2, '0', STR_PAD_LEFT);

$propertyTypes = $area['property_types_items'] ?? [];
$plotSizes = $area['plot_sizes_items'] ?? [];
$schools = $area['schools_items'] ?? [];
$healthcare = $area['healthcare_items'] ?? [];
$shopping = $area['shopping_items'] ?? [];
$recreation = $area['recreation_items'] ?? [];
$faqs = $area['faqs_items'] ?? [];
$gallery = $area['gallery_items'] ?? [];
$propList = $properties ?? [];

$heroMetrics = !empty($area['hero_metrics_items']) ? $area['hero_metrics_items'] : [
    ['label' => 'Active Mandates', 'value' => count($propList) > 0 ? (string)count($propList) : 'Off-Market'],
    ['label' => 'Title Status', 'value' => 'Freehold'],
    ['label' => 'Zoning', 'value' => 'Low Density'],
    ['label' => 'Security', 'value' => 'Diplomatic A1']
];

$characterHighlights = !empty($area['character_highlights_items']) ? $area['character_highlights_items'] : [
    'Strict Residential Zoning',
    'High Owner-Occupancy',
    'Off-Market Mandates'
];
?>

<?php if (!empty($seo['schema_json'])): ?>
    <script type="application/ld+json">
        <?= $seo['schema_json'] ?>
    </script>
<?php endif; ?>

<div class="flex flex-col w-full bg-[#FAF8F4] text-[#171A18] selection:bg-[#B99A62] selection:text-[#171A18]">

    <!-- ============================================================
         SECTION 1: EDITORIAL CINEMATIC HERO
         ============================================================ -->
    <section class="relative w-full bg-[#171A18] text-white pt-28 pb-16 lg:pt-36 lg:pb-20 px-6 lg:px-16 overflow-hidden">
        <!-- Background Architectural Scrim -->
        <div class="absolute inset-0">
            <img 
                src="<?= $heroImgSrc ?>" 
                alt="<?= Format::e($heroImgAlt) ?>" 
                class="w-full h-full object-cover scale-105 transition-transform duration-1000"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-[#171A18]/95 via-[#243F34]/85 to-[#171A18]/70"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#171A18] via-transparent to-black/30"></div>
        </div>

        <div class="relative max-w-[1440px] mx-auto z-10 space-y-8">
            <!-- Breadcrumb Strip -->
            <nav class="flex items-center gap-2 font-['Manrope'] uppercase text-[0.7rem] tracking-[0.25em] text-[#DFCF9F]/80" aria-label="Breadcrumb">
                <a class="hover:text-white transition-colors" href="<?= $baseUrl ?>/">Home</a>
                <span class="text-[#B99A62]">/</span>
                <a class="hover:text-white transition-colors" href="<?= $baseUrl ?>/locations">Locations</a>
                <span class="text-[#B99A62]">/</span>
                <span class="text-white font-semibold"><?= Format::e($areaName) ?></span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-end">
                <div class="lg:col-span-8 space-y-4">
                    <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-[#B99A62]/40">
                        <span class="w-2 h-2 rounded-full bg-[#B99A62] animate-pulse"></span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#DFCF9F] font-semibold">
                            <?= !empty($area['hero_monograph_text']) ? Format::e($area['hero_monograph_text']) : "Territory Monograph {$monographIndex} · South Delhi" ?>
                        </span>
                    </div>

                    <h1 class="font-['Playfair_Display'] text-4xl sm:text-5xl lg:text-6xl font-normal text-white tracking-tight leading-[1.12]">
                        <?= !empty($area['hero_title']) ? Format::e($area['hero_title']) : Format::e($areaName) ?>
                    </h1>

                    <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg text-gray-200 font-light leading-relaxed max-w-2xl">
                        <?= !empty($area['hero_subtitle']) ? Format::e($area['hero_subtitle']) : Format::e($area['short_description'] ?? '') ?>
                    </p>

                    <div class="pt-4 flex flex-wrap items-center gap-4">
                        <a href="#properties-section" 
                           class="px-6 py-3.5 bg-[#B99A62] hover:bg-[#A88B53] text-[#171A18] font-['Manrope'] text-xs font-bold uppercase tracking-[0.18em] rounded-lg transition-all shadow-lg">
                            <span>Explore Residences (<?= count($propList) ?>)</span>
                        </a>
                        <a href="https://wa.me/<?= $cleanWa ?>?text=<?= urlencode('Hello Elite Homez Advisory Desk, I would like to enquire about luxury residential opportunities in ' . $areaName . '.') ?>" 
                           target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 px-6 py-3.5 bg-white/10 hover:bg-white/20 text-white font-['Manrope'] text-xs font-semibold uppercase tracking-[0.18em] rounded-lg border border-white/20 backdrop-blur-md transition-all">
                            <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>WhatsApp Concierge</span>
                        </a>
                        <a href="<?= $baseUrl ?>/contact-us?subject=<?= urlencode($areaName . ' Property Consultation') ?>" 
                           class="px-5 py-3.5 text-[#DFCF9F] hover:text-white font-['Manrope'] text-xs uppercase tracking-[0.16em] font-semibold transition-colors">
                            Schedule Private Briefing &rarr;
                        </a>
                    </div>
                </div>

                <!-- Right Key Metric Strip Card -->
                <div class="lg:col-span-4 bg-[#243F34]/90 backdrop-blur-xl p-6 rounded-2xl border border-[#B99A62]/35 shadow-xl space-y-4">
                    <span class="font-['Manrope'] text-[0.65rem] uppercase tracking-[0.25em] text-[#DFCF9F] block font-semibold">
                        Micro-Market Intelligence
                    </span>
                    <div class="grid grid-cols-2 gap-3 pt-1">
                        <?php foreach ($heroMetrics as $mIdx => $m): ?>
                            <div class="bg-black/20 p-3 rounded-lg border border-white/5">
                                <span class="text-[0.65rem] uppercase tracking-wider text-gray-300 font-['Manrope'] block"><?= Format::e($m['label'] ?? '') ?></span>
                                <span class="text-xl font-normal <?= $mIdx % 2 === 1 ? 'text-[#DFCF9F]' : 'text-white' ?> font-['Playfair_Display']"><?= Format::e($m['value'] ?? '') ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2 & 3: LOCATION INTRODUCTION & PROPERTY MARKET -->
    <section class="w-full py-16 lg:py-20 px-6 lg:px-12 border-b border-[#D8CDBA]/30">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
            
            <!-- Left Column: Location Introduction (Section 2) -->
            <div class="lg:col-span-6 space-y-6">
                <div>
                    <span class="font-['Manrope'] text-xs font-semibold text-[#B99A62] uppercase tracking-[0.25em] block mb-2">
                        Location Overview
                    </span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl font-normal text-[#171A18]">
                        The Residential Character of <?= Format::e($areaName) ?>
                    </h2>
                </div>
                <div class="font-['Manrope'] text-base text-[#4A504B] font-light leading-relaxed space-y-4">
                    <?= !empty($area['overview']) ? nl2br(Format::e($area['overview'])) : nl2br(Format::e($area['detailed_description'] ?? '')) ?>
                </div>
                <?php if (!empty($characterHighlights)): ?>
                    <div class="pt-4 border-t border-[#D8CDBA]/30 flex flex-wrap items-center gap-4 text-xs font-['Manrope'] text-[#5C605D]">
                        <?php foreach ($characterHighlights as $ch): ?>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#B99A62]"></span>
                                <?= Format::e($ch) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Property Market (Section 3) -->
            <div class="lg:col-span-6 bg-white p-8 lg:p-10 border border-[#D8CDBA]/30 shadow-sm space-y-6">
                <div>
                    <span class="font-['Manrope'] text-xs font-semibold text-[#B99A62] uppercase tracking-[0.25em] block mb-2">
                        Micro-Market Analysis
                    </span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl font-normal text-[#171A18]">
                        Property in <?= Format::e($areaName) ?>
                    </h2>
                </div>
                <div class="font-['Manrope'] text-sm sm:text-base text-[#4A504B] font-light leading-relaxed space-y-4">
                    <?= !empty($area['property_market']) ? nl2br(Format::e($area['property_market'])) : nl2br(Format::e($area['property_info'] ?? '')) ?>
                </div>
                <div class="p-4 bg-[#f8f7f5] border-l-2 border-[#B99A62] font-['Manrope'] text-xs text-[#5C605D] leading-relaxed">
                    <strong>Fiduciary Guidance Note:</strong> <?= Format::e(!empty($area['fiduciary_note']) ? $area['fiduciary_note'] : "Property values in {$areaName} vary significantly based on plot size, road width, frontage, construction quality, location within the neighbourhood, and property condition. Contact Elite Homez for current property-specific guidance.") ?>
                </div>
            </div>

        </div>
    </section>

    <!-- SECTION 4 — PROPERTY TYPES CARDS -->
    <?php if (!empty($propertyTypes)): ?>
        <section class="w-full py-16 lg:py-20 px-6 lg:px-12 bg-[#F5F1E8] border-b border-[#D8CDBA]/30">
            <div class="max-w-7xl mx-auto">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="font-['Manrope'] text-xs font-semibold text-[#B99A62] uppercase tracking-[0.25em] block mb-2">
                        <?= Format::e(!empty($area['property_types_eyebrow']) ? $area['property_types_eyebrow'] : 'Residential Asset Categories') ?>
                    </span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl font-normal text-[#171A18]">
                        <?= Format::e(!empty($area['property_types_title']) ? $area['property_types_title'] : "Typical Property Formats in {$areaName}") ?>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($propertyTypes as $pt): ?>
                        <div class="bg-white p-8 border border-[#D8CDBA]/30 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow">
                            <div>
                                <div class="w-10 h-10 mb-6 bg-[#171A18] text-[#C9A86A] flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <h3 class="font-['Playfair_Display'] text-2xl text-[#171A18] mb-3">
                                    <?= Format::e($pt['title'] ?? 'Residential Asset') ?>
                                </h3>
                                <p class="font-['Manrope'] text-sm text-[#5C605D] font-light leading-relaxed mb-4">
                                    <?= Format::e($pt['description'] ?? '') ?>
                                </p>
                                <?php if (!empty($pt['buyer_profile'])): ?>
                                    <div class="p-3 bg-[#f8f7f5] border border-[#D8CDBA]/20 mb-6">
                                        <span class="block font-['Manrope'] text-[0.68rem] uppercase tracking-wider text-[#B99A62] font-semibold mb-1">Target Profile:</span>
                                        <p class="font-['Manrope'] text-xs text-[#4A504B] font-light">
                                            <?= Format::e($pt['buyer_profile']) ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <a href="<?= !empty($pt['cta_link']) ? $pt['cta_link'] : ($baseUrl . '/contact-us?subject=' . urlencode($areaName . ' ' . ($pt['title'] ?? 'Property'))) ?>" 
                               class="inline-flex items-center gap-2 text-xs font-['Manrope'] uppercase tracking-[0.18em] font-semibold text-[#171A18] hover:text-[#B99A62] transition-colors pt-4 border-t border-[#D8CDBA]/20">
                                <span><?= Format::e($pt['cta_text'] ?? 'Inquire Now') ?></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- SECTION 5 — PLOT / PROPERTY SIZE -->
    <?php if (!empty($plotSizes)): ?>
        <section class="w-full py-16 lg:py-20 px-6 lg:px-12 bg-white border-b border-[#D8CDBA]/30">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                    <div class="lg:col-span-4">
                        <span class="font-['Manrope'] text-xs font-semibold text-[#B99A62] uppercase tracking-[0.25em] block mb-2">
                            <?= Format::e(!empty($area['plot_sizes_eyebrow']) ? $area['plot_sizes_eyebrow'] : 'Spatial Typologies') ?>
                        </span>
                        <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl font-normal text-[#171A18] mb-4">
                            <?= Format::e(!empty($area['plot_sizes_title']) ? $area['plot_sizes_title'] : "Typical Residential Plot Sizes in {$areaName}") ?>
                        </h2>
                        <p class="font-['Manrope'] text-sm text-[#5C605D] font-light leading-relaxed">
                            <?= Format::e(!empty($area['plot_sizes_description']) ? $area['plot_sizes_description'] : "Plot footprints in {$areaName} dictate permissible floor area ratio (FAR), setback requirements, and basement depth. Available property sizes vary considerably across individual listings.") ?>
                        </p>
                    </div>

                    <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php foreach ($plotSizes as $ps): ?>
                            <div class="p-6 bg-[#FAF8F4] border border-[#D8CDBA]/30">
                                <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-wider text-[#B99A62] block mb-1">
                                    <?= Format::e($ps['type'] ?? 'Plot Parcel') ?>
                                </span>
                                <h4 class="font-['Playfair_Display'] text-xl text-[#171A18] font-normal mb-3">
                                    <?= Format::e($ps['size'] ?? '') ?>
                                </h4>
                                <p class="font-['Manrope'] text-xs text-[#5C605D] font-light leading-relaxed">
                                    <?= Format::e($ps['description'] ?? '') ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- SECTION 6 & 7: LIFESTYLE & CONNECTIVITY -->
    <section class="w-full py-16 lg:py-20 px-6 lg:px-12 bg-[#FAF8F4] border-b border-[#D8CDBA]/30">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Lifestyle (Section 6) -->
            <div class="lg:col-span-6 space-y-6">
                <div>
                    <span class="font-['Manrope'] text-xs font-semibold text-[#B99A62] uppercase tracking-[0.25em] block mb-2">
                        <?= Format::e(!empty($area['lifestyle_eyebrow']) ? $area['lifestyle_eyebrow'] : 'Neighborhood Ambiance') ?>
                    </span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl font-normal text-[#171A18]">
                        <?= Format::e(!empty($area['lifestyle_title']) ? $area['lifestyle_title'] : "Lifestyle & Community in {$areaName}") ?>
                    </h2>
                </div>
                <div class="font-['Manrope'] text-base text-[#4A504B] font-light leading-relaxed space-y-4">
                    <?= !empty($area['lifestyle']) ? nl2br(Format::e($area['lifestyle'])) : 'The neighborhood offers quiet tree-canopied residential living with premier social infrastructure, private parks, and dedicated community facilities.' ?>
                </div>
            </div>

            <!-- Connectivity (Section 7) -->
            <div class="lg:col-span-6 space-y-6">
                <div>
                    <span class="font-['Manrope'] text-xs font-semibold text-[#B99A62] uppercase tracking-[0.25em] block mb-2">
                        <?= Format::e(!empty($area['connectivity_eyebrow']) ? $area['connectivity_eyebrow'] : 'Arterial Infrastructure') ?>
                    </span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl font-normal text-[#171A18]">
                        <?= Format::e(!empty($area['connectivity_title']) ? $area['connectivity_title'] : 'Connectivity & Transit Links') ?>
                    </h2>
                </div>
                <div class="font-['Manrope'] text-base text-[#4A504B] font-light leading-relaxed space-y-4">
                    <?= !empty($area['connectivity']) ? nl2br(Format::e($area['connectivity'])) : 'Well-positioned with convenient access to major arterial routes, metro stations, and key South Delhi commercial corridors.' ?>
                </div>

                <?php if (!empty($area['nearby_landmarks'])): ?>
                    <div class="p-5 bg-white border border-[#D8CDBA]/30 space-y-2">
                        <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-wider text-[#B99A62] block">
                            Key Landmarks & Perimeter Points:
                        </span>
                        <p class="font-['Manrope'] text-xs text-[#5C605D] leading-relaxed">
                            <?= Format::e($area['nearby_landmarks']) ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>

    <!-- SECTION 8 — LOCAL PROPERTY ADVISORY BANNER -->
    <section class="w-full bg-[#171A18] text-white py-16 lg:py-20 px-6 lg:px-12 border-b border-[#B99A62]/30">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-8 space-y-4">
                <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-[0.25em] text-[#C9A86A] block">
                    <?= Format::e(!empty($area['banner_eyebrow']) ? $area['banner_eyebrow'] : 'Elite Homez Private Office') ?>
                </span>
                <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl font-normal text-white">
                    <?= Format::e(!empty($area['banner_title']) ? $area['banner_title'] : 'Local Knowledge. Better Property Decisions.') ?>
                </h2>
                <p class="font-['Manrope'] text-base text-[#D8CDBA] font-light leading-relaxed max-w-2xl">
                    <?= Format::e(!empty($area['banner_description']) ? $area['banner_description'] : (!empty($area['advisory_content']) ? $area['advisory_content'] : 'Elite Homez maintains direct relationships with multi-generational resident owners and premier developers in ' . Format::e($areaName) . '. We operate off-market to present verified residential assets with complete discretion.')) ?>
                </p>
            </div>
            <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-4 justify-center">
                <a href="<?= Format::e(!empty($area['banner_btn1_url']) ? $area['banner_btn1_url'] : ($baseUrl . '/contact-us?subject=' . urlencode($areaName . ' Confidential Advisory'))) ?>" 
                   class="px-7 py-4 bg-[#B99A62] hover:bg-[#b09339] text-[#171A18] font-['Manrope'] text-xs font-semibold uppercase tracking-[0.2em] text-center transition-all">
                    <?= Format::e(!empty($area['banner_btn1_text']) ? $area['banner_btn1_text'] : 'Initiate Private Mandate') ?>
                </a>
                <a href="<?= Format::e(!empty($area['banner_btn2_url']) ? $area['banner_btn2_url'] : ('tel:' . $cleanPhone)) ?>" 
                   class="px-7 py-4 border border-[#D8CDBA]/30 hover:border-white text-white font-['Manrope'] text-xs font-medium uppercase tracking-[0.2em] text-center transition-all">
                    <?= Format::e(!empty($area['banner_btn2_text']) ? $area['banner_btn2_text'] : 'Call Advisory Desk') ?>
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 9 — FAQS -->
    <?php if (!empty($faqs)): ?>
        <section class="w-full py-16 lg:py-24 px-6 lg:px-12 bg-[#FAF8F4] border-b border-[#D8CDBA]/30">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <span class="font-['Manrope'] text-xs font-semibold text-[#B99A62] uppercase tracking-[0.25em] block mb-2">
                        <?= Format::e(!empty($area['faqs_eyebrow']) ? $area['faqs_eyebrow'] : 'Local Advisory Insights') ?>
                    </span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl font-normal text-[#171A18]">
                        <?= Format::e(!empty($area['faqs_title']) ? $area['faqs_title'] : "Frequently Asked Questions: {$areaName}") ?>
                    </h2>
                </div>

                <div class="space-y-4" id="faq-accordion">
                    <?php foreach ($faqs as $fIdx => $faq): ?>
                        <div class="border border-[#D8CDBA]/30 bg-white shadow-sm overflow-hidden">
                            <button type="button" 
                                    class="w-full p-6 text-left flex items-center justify-between gap-4 font-['Playfair_Display'] text-lg sm:text-xl text-[#171A18] hover:text-[#B99A62] transition-colors faq-toggle"
                                    aria-expanded="<?= $fIdx === 0 ? 'true' : 'false' ?>"
                                    data-target="#faq-ans-<?= $fIdx ?>">
                                <span><?= Format::e($faq['question'] ?? '') ?></span>
                                <span class="w-6 h-6 flex-shrink-0 flex items-center justify-center text-[#B99A62] text-xl font-light transform transition-transform duration-300 faq-icon <?= $fIdx === 0 ? 'rotate-45' : '' ?>">
                                    +
                                </span>
                            </button>
                            <div id="faq-ans-<?= $fIdx ?>" 
                                 class="faq-content px-6 pb-6 pt-1 font-['Manrope'] text-sm sm:text-base text-[#4A504B] font-light leading-relaxed <?= $fIdx === 0 ? 'block' : 'hidden' ?>">
                                <?= nl2br(Format::e($faq['answer'] ?? '')) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- FINAL CTA STRIP -->
    <section class="w-full bg-[#171A18] text-white py-16 lg:py-20 px-6 lg:px-12">
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-[0.25em] text-[#C9A86A]">
                <?= Format::e(!empty($area['cta_eyebrow']) ? $area['cta_eyebrow'] : 'Fiduciary Client Representation') ?>
            </span>
            <h2 class="font-['Playfair_Display'] text-3xl sm:text-5xl font-normal text-white">
                <?= Format::e(!empty($area['cta_title']) ? $area['cta_title'] : "Begin Your Residential Search in {$areaName}") ?>
            </h2>
            <p class="font-['Manrope'] text-base text-[#D8CDBA] font-light leading-relaxed max-w-2xl mx-auto">
                <?= Format::e(!empty($area['cta_description']) ? $area['cta_description'] : "Whether seeking an off-market independent bungalow or a bespoke modern builder floor, Elite Homez provides verified confidential guidance.") ?>
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                <a href="<?= Format::e(!empty($area['cta_btn1_url']) ? $area['cta_btn1_url'] : ($baseUrl . '/contact-us?subject=' . urlencode('Direct Inquiry: ' . $areaName))) ?>" 
                   class="px-8 py-4 bg-[#B99A62] hover:bg-[#b09339] text-[#171A18] font-['Manrope'] text-xs font-semibold uppercase tracking-[0.2em] transition-all">
                    <?= Format::e(!empty($area['cta_btn1_text']) ? $area['cta_btn1_text'] : 'Share Your Requirement') ?>
                </a>
                <a href="<?= Format::e(!empty($area['cta_btn2_url']) ? $area['cta_btn2_url'] : ('https://wa.me/' . $cleanWa . '?text=' . urlencode('Hello, I would like to inquire about luxury properties in ' . $areaName . '.'))) ?>" 
                   target="_blank" rel="noopener noreferrer"
                   class="px-8 py-4 border border-white/40 hover:border-white text-white font-['Manrope'] text-xs font-medium uppercase tracking-[0.2em] transition-all">
                    <?= Format::e(!empty($area['cta_btn2_text']) ? $area['cta_btn2_text'] : 'WhatsApp Advisory') ?>
                </a>
            </div>
        </div>
    </section>

</div>

<!-- FAQ Accordion Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.faq-toggle');
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const content = document.querySelector(targetId);
            const icon = this.querySelector('.faq-icon');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            // Close all
            buttons.forEach(b => {
                b.setAttribute('aria-expanded', 'false');
                const t = document.querySelector(b.getAttribute('data-target'));
                if (t) t.classList.add('hidden');
                const ic = b.querySelector('.faq-icon');
                if (ic) ic.classList.remove('rotate-45');
            });

            // Toggle current if it was closed
            if (!isExpanded && content) {
                this.setAttribute('aria-expanded', 'true');
                content.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-45');
            }
        });
    });
});
</script>
