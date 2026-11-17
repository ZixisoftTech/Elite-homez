<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$settings = $siteSettings ?? [];
$phone = $settings['phone_primary'] ?? '+91 9811044200';
$phoneClean = preg_replace('/[^0-9\+]/', '', $phone);
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$waClean = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($waClean) === 10) {
    $waClean = '91' . $waClean;
}
$siteRera = $settings['rera_number'] ?? 'DLRERA2023A00892';

$mainImg = !empty($property['featured_image']) ? $property['featured_image'] : '/assets/images/stitch/detail-hero-greatroom.jpg';
$mainImgSrc = str_starts_with($mainImg, 'http') ? $mainImg : $baseUrl . $mainImg;

// Prepare curated gallery
$allGallery = [$mainImgSrc];
if (!empty($galleryImages)) {
    foreach ($galleryImages as $gi) {
        $p = str_starts_with($gi['image_path'], 'http') ? $gi['image_path'] : $baseUrl . $gi['image_path'];
        if (!in_array($p, $allGallery, true)) {
            $allGallery[] = $p;
        }
    }
}
$fallbackGallery = [
    $baseUrl . '/assets/images/stitch/detail-twilight-facade.jpg',
    $baseUrl . '/assets/images/stitch/detail-quartzite-kitchen.jpg',
    $baseUrl . '/assets/images/stitch/detail-master-suite.jpg',
    $baseUrl . '/assets/images/stitch/living-pavilion.jpg'
];
foreach ($fallbackGallery as $fb) {
    if (count($allGallery) < 5 && !in_array($fb, $allGallery, true)) {
        $allGallery[] = $fb;
    }
}

$ref = !empty($property['mandate_ref']) ? $property['mandate_ref'] : ('EH-' . str_pad((string)$property['id'], 3, '0', STR_PAD_LEFT));
$propRera = !empty($property['rera_number']) ? $property['rera_number'] : $siteRera;
$subTitle = !empty($property['sub_title']) ? $property['sub_title'] : ($property['property_location'] ?? 'Diplomatic Enclave, South Delhi');
$orientation = !empty($property['orientation']) ? $property['orientation'] : 'East Facing · Vastu Certified';
$ceilingHeight = !empty($property['ceiling_height']) ? $property['ceiling_height'] : '3.4m Ceiling Clearance';
$architect = !empty($property['architect_info']) ? $property['architect_info'] : 'Studio Khosla Architects · 2023';
$provenanceQuote = !empty($property['provenance_quote']) ? $property['provenance_quote'] : '"Curated geometry paired with raw, tactile travertine creates an acoustic stillness unique to South Delhi\'s diplomatic corridor."';
$statusLabel = $property['listing_type'] === 'rent' ? 'For Rent · Diplomatic Lease' : 'For Sale · Prime Mandate';

// Construct pre-filled WhatsApp inquiry message
$currentUrl = $baseUrl . '/properties/' . Format::e($property['slug']);
$waMessage = "Hello Elite Homez, I am inquiring about {$property['title']} (Ref: {$ref}) listed at {$property['price_display']} in {$property['area_name']}. Link: {$currentUrl}";
$waUrl = "https://wa.me/{$waClean}?text=" . urlencode($waMessage);
?>

<div class="flex flex-col w-full text-[#171A18] bg-[#FAF8F4] overflow-hidden">

    <!-- ============================================================
         01. BREADCRUMB & MANDATE METADATA STRIP
         ============================================================ -->
    <section class="w-full bg-[#F5F1E8] py-4 px-6 lg:px-16 border-b border-[#E0D7C9]/60">
        <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
            <nav aria-label="Breadcrumb" class="flex items-center gap-2 font-['Manrope'] text-xs uppercase tracking-wider text-[#5C605D] font-semibold overflow-x-auto pb-1 md:pb-0">
                <a class="hover:text-[#243F34] transition-colors" href="<?= $baseUrl ?>/">Home</a>
                <span class="text-[#B99A62]">/</span>
                <a class="hover:text-[#243F34] transition-colors" href="<?= $baseUrl ?>/properties">Properties</a>
                <span class="text-[#B99A62]">/</span>
                <a class="hover:text-[#243F34] transition-colors" href="<?= $baseUrl ?>/locations/<?= Format::e($property['area_slug']) ?>"><?= Format::e($property['area_name']) ?></a>
                <span class="text-[#B99A62]">/</span>
                <span class="text-[#243F34] font-bold truncate max-w-[240px] sm:max-w-md"><?= Format::e($property['title']) ?></span>
            </nav>

            <div class="flex flex-wrap items-center gap-4 text-xs font-['Manrope'] uppercase tracking-wider text-[#5C605D] font-semibold">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#B99A62]"></span>
                    <span>Ref: <strong class="text-[#243F34] font-mono"><?= Format::e($ref) ?></strong></span>
                </div>
                <span>•</span>
                <div class="flex items-center gap-2">
                    <span>RERA: <strong class="text-[#243F34] font-mono"><?= Format::e($propRera) ?></strong></span>
                </div>
                <span class="px-3 py-1 bg-white text-[#243F34] border border-[#E0D7C9] rounded-full text-[0.65rem] tracking-widest uppercase font-bold shadow-sm">
                    Accredited Mandate
                </span>
            </div>
        </div>
    </section>


    <!-- ============================================================
         02. PROPERTY INTRODUCTION & TITLE HEADER
         ============================================================ -->
    <section class="w-full max-w-[1440px] mx-auto px-6 lg:px-16 pt-8 pb-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
            <div class="lg:col-span-8 space-y-3">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="bg-[#243F34] text-white text-[0.6875rem] uppercase tracking-[0.2em] font-['Manrope'] font-bold px-3.5 py-1 rounded-full shadow-sm">
                        <?= $statusLabel ?>
                    </span>
                    <span class="text-xs uppercase tracking-widest text-[#8C7343] font-['Manrope'] font-semibold">
                        <?= Format::e($property['area_name']) ?> · <?= Format::e($property['property_type']) ?>
                    </span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-[3.5rem] lg:leading-[1.1] text-[#243F34] tracking-tight font-normal font-['Playfair_Display']">
                    <?= Format::e($property['title']) ?>
                </h1>
                <p class="text-base sm:text-lg text-[#5C605D] italic font-['Playfair_Display'] font-light">
                    <?= Format::e($subTitle) ?>
                </p>
            </div>

            <div class="lg:col-span-4 flex flex-col lg:items-end justify-end space-y-1">
                <span class="text-xs uppercase text-[#5C605D] tracking-widest font-['Manrope'] font-semibold">Guide Valuation</span>
                <div class="text-3xl sm:text-4xl lg:text-5xl text-[#243F34] font-normal tracking-tight font-['Playfair_Display']">
                    <?= Format::e($property['price_display']) ?><span class="text-base text-[#B99A62] align-top">*</span>
                </div>
                <p class="text-[0.6875rem] uppercase tracking-wider text-[#8C7343] font-['Manrope'] font-bold">
                    Clean Freehold Title · Private Treaty
                </p>
            </div>
        </div>
    </section>


    <!-- ============================================================
         03. INTERACTIVE PROPERTY GALLERY & LIGHTBOX
         ============================================================ -->
    <section class="w-full max-w-[1440px] mx-auto px-6 lg:px-16 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-stretch">
            <!-- Large Primary Image (8 cols) -->
            <div class="lg:col-span-8 relative rounded-2xl overflow-hidden shadow-xl bg-[#171A18] aspect-[16/10] sm:aspect-[16/9] group cursor-pointer" id="primary-gallery-wrap">
                <img 
                    id="primary-gallery-img"
                    src="<?= $allGallery[0] ?>" 
                    alt="<?= Format::e($property['title']) ?> - Primary Architecture View" 
                    class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/60 via-transparent to-transparent pointer-events-none"></div>

                <!-- Fullscreen Inspection Pill -->
                <button type="button" class="absolute bottom-5 right-5 bg-[#171A18]/80 hover:bg-[#243F34] text-white px-4 py-2.5 rounded-full text-xs font-['Manrope'] uppercase tracking-widest backdrop-blur-md border border-[#B99A62]/40 transition-colors flex items-center gap-2 shadow-lg" id="open-lightbox-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <polyline points="9 21 3 21 3 15"></polyline>
                        <line x1="21" y1="3" x2="14" y2="10"></line>
                        <line x1="3" y1="21" x2="10" y2="14"></line>
                    </svg>
                    <span>View All Photos (<?= count($allGallery) ?>)</span>
                </button>
            </div>

            <!-- Supporting Thumbnail Grid (4 cols) -->
            <div class="lg:col-span-4 grid grid-cols-2 gap-4">
                <?php foreach (array_slice($allGallery, 1, 4) as $idx => $tImg): ?>
                    <div class="relative rounded-xl overflow-hidden shadow-sm bg-[#EAE3D7] aspect-[4/3] group cursor-pointer border-2 border-transparent hover:border-[#B99A62] transition-all thumb-item" data-src="<?= $tImg ?>" data-idx="<?= $idx + 1 ?>">
                        <img 
                            src="<?= $tImg ?>" 
                            alt="<?= Format::e($property['title']) ?> - View <?= $idx + 2 ?>" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        >
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Key Architectural Metrics Bar -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-px bg-[#E0D7C9] mt-6 rounded-2xl overflow-hidden shadow-sm border border-[#E0D7C9]">
            <div class="bg-white p-5 text-center sm:text-left">
                <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold block">Covered Area</span>
                <span class="text-xl sm:text-2xl text-[#243F34] font-medium font-['Playfair_Display'] mt-1 block">
                    <?= Format::e($property['property_size']) ?>
                </span>
                <span class="text-[0.65rem] text-[#8C7343] font-['Manrope'] uppercase mt-0.5 block">Interior Space</span>
            </div>
            <div class="bg-white p-5 text-center sm:text-left">
                <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold block">Plot Size</span>
                <span class="text-xl sm:text-2xl text-[#243F34] font-medium font-['Playfair_Display'] mt-1 block">
                    <?= Format::e($property['plot_size'] ?: 'Parcel Share') ?>
                </span>
                <span class="text-[0.65rem] text-[#8C7343] font-['Manrope'] uppercase mt-0.5 block">Plot Apportionment</span>
            </div>
            <div class="bg-white p-5 text-center sm:text-left">
                <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold block">Bedrooms</span>
                <span class="text-xl sm:text-2xl text-[#243F34] font-medium font-['Playfair_Display'] mt-1 block">
                    <?= (int) $property['bedrooms'] ?> Suites
                </span>
                <span class="text-[0.65rem] text-[#8C7343] font-['Manrope'] uppercase mt-0.5 block">Dressing Salons</span>
            </div>
            <div class="bg-white p-5 text-center sm:text-left">
                <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold block">Bathrooms</span>
                <span class="text-xl sm:text-2xl text-[#243F34] font-medium font-['Playfair_Display'] mt-1 block">
                    <?= (int) $property['bathrooms'] ?> Full Baths
                </span>
                <span class="text-[0.65rem] text-[#8C7343] font-['Manrope'] uppercase mt-0.5 block">Italian Marble</span>
            </div>
            <div class="bg-white p-5 text-center sm:text-left">
                <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold block">Orientation</span>
                <span class="text-xl sm:text-2xl text-[#243F34] font-medium font-['Playfair_Display'] mt-1 block">
                    <?= Format::e(explode('·', $orientation)[0] ?? 'East Facing') ?>
                </span>
                <span class="text-[0.65rem] text-[#8C7343] font-['Manrope'] uppercase mt-0.5 block">Vastu Compliant</span>
            </div>
            <div class="bg-white p-5 text-center sm:text-left">
                <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold block">Parking</span>
                <span class="text-xl sm:text-2xl text-[#243F34] font-medium font-['Playfair_Display'] mt-1 block">
                    <?= (int) $property['parking_spaces'] ?> Stalls
                </span>
                <span class="text-[0.65rem] text-[#8C7343] font-['Manrope'] uppercase mt-0.5 block">Secure Garage</span>
            </div>
        </div>
    </section>


    <!-- ============================================================
         04. ASYMMETRIC MAIN CONTENT & STICKY ENQUIRY PANEL (7 COLS / 5 COLS)
         ============================================================ -->
    <section class="w-full max-w-[1440px] mx-auto px-6 lg:px-16 py-8 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- LEFT COLUMN: EDITORIAL NARRATIVE & SPECIFICATIONS (7 COLS) -->
            <div class="lg:col-span-7 space-y-12">
                
                <!-- Architectural Narrative -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#B99A62] font-semibold">Architectural Narrative</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl text-[#243F34] font-normal font-['Playfair_Display'] leading-tight">
                        A sanctuary crafted for space, natural light, and quiet discretion.
                    </h2>

                    <!-- Provenance Pull Quote -->
                    <div class="p-6 rounded-2xl bg-[#F5F1E8] border-l-4 border-[#B99A62] shadow-sm">
                        <blockquote class="font-['Playfair_Display'] text-lg text-[#243F34] italic font-normal leading-relaxed">
                            <?= Format::e($provenanceQuote) ?>
                        </blockquote>
                    </div>

                    <!-- Description Body Paragraphs -->
                    <div class="space-y-4 font-['Plus_Jakarta_Sans'] text-base text-[#4A504B] font-light leading-relaxed">
                        <?php 
                        $paragraphs = explode("\n\n", trim($property['description']));
                        foreach ($paragraphs as $para): 
                            if (empty(trim($para))) continue;
                        ?>
                            <p><?= nl2br(Format::e(trim($para))) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Technical & Statutory Dossier Table -->
                <div class="space-y-6 pt-6 border-t border-[#E0D7C9]">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl sm:text-2xl text-[#243F34] font-normal font-['Playfair_Display']">
                            Statutory &amp; Technical Dossier
                        </h3>
                        <span class="font-mono text-xs uppercase text-[#8C7343] font-semibold">Ref: <?= Format::e($ref) ?></span>
                    </div>

                    <div class="bg-white rounded-2xl border border-[#E0D7C9] overflow-hidden shadow-sm divide-y divide-[#E0D7C9]">
                        <div class="flex items-center justify-between p-4 sm:p-5 hover:bg-[#FAF8F4] transition-colors">
                            <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold">Property Classification</span>
                            <span class="text-sm text-[#171A18] font-medium"><?= Format::e($property['property_type']) ?></span>
                        </div>
                        <div class="flex items-center justify-between p-4 sm:p-5 hover:bg-[#FAF8F4] transition-colors">
                            <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold">Transaction Framework</span>
                            <span class="text-sm text-[#171A18] font-medium">
                                <?= $property['listing_type'] === 'rent' ? 'Diplomatic Lease Agreement' : 'Direct Private Treaty Sale' ?>
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-4 sm:p-5 hover:bg-[#FAF8F4] transition-colors">
                            <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold">Floor Clearance</span>
                            <span class="text-sm text-[#171A18] font-medium"><?= Format::e($ceilingHeight) ?></span>
                        </div>
                        <div class="flex items-center justify-between p-4 sm:p-5 hover:bg-[#FAF8F4] transition-colors">
                            <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold">Floor Levels</span>
                            <span class="text-sm text-[#171A18] font-medium"><?= Format::e($property['floor_info'] ?: 'Ground + 3 Levels') ?></span>
                        </div>
                        <div class="flex items-center justify-between p-4 sm:p-5 hover:bg-[#FAF8F4] transition-colors">
                            <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold">Architect &amp; Pedigree</span>
                            <span class="text-sm text-[#171A18] font-medium"><?= Format::e($architect) ?></span>
                        </div>
                        <div class="flex items-center justify-between p-4 sm:p-5 hover:bg-[#FAF8F4] transition-colors">
                            <span class="text-xs uppercase text-[#5C605D] font-['Manrope'] font-semibold">Title Diligence</span>
                            <span class="text-sm font-semibold text-[#243F34]">100% Freehold · 30-Year Chain Audited</span>
                        </div>
                    </div>
                </div>

                <!-- Verified Features & Amenities Grid -->
                <div class="space-y-6 pt-6 border-t border-[#E0D7C9]">
                    <div class="space-y-2">
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#B99A62] font-semibold">Estate Infrastructure</span>
                        <h3 class="text-xl sm:text-2xl text-[#243F34] font-normal font-['Playfair_Display']">
                            Features &amp; Private Amenities
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php if (!empty($features)): ?>
                            <?php foreach ($features as $f): ?>
                                <div class="bg-white p-5 rounded-xl border border-[#E0D7C9] flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="w-10 h-10 rounded-full bg-[#F5F1E8] flex items-center justify-center text-[#B99A62] shrink-0">
                                        <?= SvgIcons::render($f['icon'] ?: 'check-circle', 'w-5 h-5', 20) ?>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-[#243F34] font-['Plus_Jakarta_Sans']"><?= Format::e($f['name']) ?></h4>
                                        <span class="text-[0.6875rem] text-[#5C605D]">Verified Architectural Specification</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Standard Premium Inclusions -->
                            <div class="bg-white p-5 rounded-xl border border-[#E0D7C9] flex items-center gap-4 shadow-sm">
                                <span class="w-10 h-10 rounded-full bg-[#F5F1E8] flex items-center justify-center text-[#B99A62] shrink-0 font-serif">✦</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-[#243F34]">Private Lap Pool &amp; Deck</h4>
                                    <span class="text-[0.6875rem] text-[#5C605D]">Ozone sanitized temperature-controlled</span>
                                </div>
                            </div>
                            <div class="bg-white p-5 rounded-xl border border-[#E0D7C9] flex items-center gap-4 shadow-sm">
                                <span class="w-10 h-10 rounded-full bg-[#F5F1E8] flex items-center justify-center text-[#B99A62] shrink-0 font-serif">✦</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-[#243F34]">Biometric Lift Access</h4>
                                    <span class="text-[0.6875rem] text-[#5C605D]">Direct foyer access with encrypted override</span>
                                </div>
                            </div>
                            <div class="bg-white p-5 rounded-xl border border-[#E0D7C9] flex items-center gap-4 shadow-sm">
                                <span class="w-10 h-10 rounded-full bg-[#F5F1E8] flex items-center justify-center text-[#B99A62] shrink-0 font-serif">✦</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-[#243F34]">Acoustic Double Glazing</h4>
                                    <span class="text-[0.6875rem] text-[#5C605D]">Sub-28 dB interior acoustic rating</span>
                                </div>
                            </div>
                            <div class="bg-white p-5 rounded-xl border border-[#E0D7C9] flex items-center gap-4 shadow-sm">
                                <span class="w-10 h-10 rounded-full bg-[#F5F1E8] flex items-center justify-center text-[#B99A62] shrink-0 font-serif">✦</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-[#243F34]">Staff Quarters &amp; Multi-Car Bay</h4>
                                    <span class="text-[0.6875rem] text-[#5C605D]">Dedicated domestic suites and EV chargers</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Location & Enclave Intelligence -->
                <div class="space-y-4 pt-6 border-t border-[#E0D7C9]">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#B99A62] font-semibold block mb-1">Micro-Market Context</span>
                            <h3 class="text-xl sm:text-2xl text-[#243F34] font-normal font-['Playfair_Display']">
                                Enclave: <?= Format::e($property['area_name']) ?>
                            </h3>
                        </div>
                        <a href="<?= $baseUrl ?>/locations/<?= Format::e($property['area_slug']) ?>" class="inline-flex items-center gap-1.5 text-xs uppercase font-['Manrope'] font-bold text-[#243F34] hover:text-[#B99A62] transition-colors">
                            <span>Explore Enclave Dossier</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-[#4A504B] font-light leading-relaxed">
                        Situated within South Delhi's premier diplomatic zone, enjoying 24/7 dedicated security patrols, wide tree-lined boulevards, seamless connectivity to the international airport (15 mins), and proximity to prestigious diplomatic clubs and embassies.
                    </p>
                </div>
            </div>

            <!-- RIGHT COLUMN: STICKY HIGH-CONVERSION ADVISORY PANEL (5 COLS) -->
            <div class="lg:col-span-5 sticky top-28 z-10" id="private-viewing">
                <div class="bg-[#243F34] text-white p-8 sm:p-10 rounded-3xl shadow-2xl border border-[#B99A62]/35 space-y-6">
                    
                    <!-- Panel Header -->
                    <div class="space-y-2 pb-5 border-b border-white/15">
                        <div class="flex items-center justify-between">
                            <span class="font-['Manrope'] text-[0.65rem] uppercase tracking-[0.25em] text-[#DFCF9F] font-semibold">
                                Confidential Mandate Desk
                            </span>
                            <span class="text-xs text-white/70 font-mono">Ref: <?= Format::e($ref) ?></span>
                        </div>
                        <h3 class="font-['Playfair_Display'] text-2xl sm:text-3xl text-white font-normal">
                            Enquire About This Property
                        </h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-xs text-gray-300 font-light leading-relaxed">
                            Connect directly with a Senior Advisory Partner for private viewings and verified cadastral drawings.
                        </p>
                    </div>

                    <!-- Direct WhatsApp Button (Prefilled) -->
                    <a href="<?= $waUrl ?>" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center gap-3 bg-[#25D366] hover:bg-[#20ba59] text-white py-4 px-6 rounded-full font-['Manrope'] text-xs uppercase tracking-[0.16em] font-bold shadow-lg transition-all duration-300">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>WhatsApp Senior Advisor</span>
                    </a>

                    <!-- Divider -->
                    <div class="flex items-center gap-3 text-xs text-white/40 uppercase tracking-widest font-['Manrope']">
                        <span class="h-[1px] flex-1 bg-white/15"></span>
                        <span>Or Submit Confidential Form</span>
                        <span class="h-[1px] flex-1 bg-white/15"></span>
                    </div>

                    <!-- Direct Enquiry Form Associated With Property -->
                    <div id="prop-enquiry-feedback" class="hidden p-4 rounded-xl text-xs font-['Manrope'] font-medium transition-all text-center mb-3"></div>

                    <form action="<?= $baseUrl ?>/enquire" method="POST" class="space-y-4" id="property-enquiry-form">
                        <?= Csrf::field() ?>
                        <input type="hidden" name="property_id" value="<?= (int) $property['id'] ?>">
                        <input type="hidden" name="source_page" value="Property Detail: <?= Format::e($property['title']) ?> (<?= Format::e($ref) ?>)">
                        <input type="hidden" name="return_url" value="<?= $currentUrl ?>">
                        <!-- Honeypot -->
                        <input type="text" name="website_url_check" style="display:none;" tabindex="-1" autocomplete="off">

                        <div>
                            <label class="block text-[0.6875rem] uppercase tracking-widest text-gray-300 font-['Manrope'] font-semibold mb-1" for="enq_name">Your Name *</label>
                            <input 
                                type="text" 
                                id="enq_name" 
                                name="name" 
                                required 
                                placeholder="Full Legal Name" 
                                class="w-full bg-[#1B3128] border border-white/20 text-white px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-[#DFCF9F] font-['Plus_Jakarta_Sans']"
                            >
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[0.6875rem] uppercase tracking-widest text-gray-300 font-['Manrope'] font-semibold mb-1" for="enq_phone">Mobile Number *</label>
                                <input 
                                    type="tel" 
                                    id="enq_phone" 
                                    name="mobile" 
                                    required 
                                    placeholder="+91 98110 00000" 
                                    class="w-full bg-[#1B3128] border border-white/20 text-white px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-[#DFCF9F] font-['Plus_Jakarta_Sans']"
                                >
                            </div>
                            <div>
                                <label class="block text-[0.6875rem] uppercase tracking-widest text-gray-300 font-['Manrope'] font-semibold mb-1" for="enq_email">Email Address *</label>
                                <input 
                                    type="email" 
                                    id="enq_email" 
                                    name="email" 
                                    required 
                                    placeholder="principal@family.com" 
                                    class="w-full bg-[#1B3128] border border-white/20 text-white px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-[#DFCF9F] font-['Plus_Jakarta_Sans']"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="block text-[0.6875rem] uppercase tracking-widest text-gray-300 font-['Manrope'] font-semibold mb-1" for="enq_msg">Confidential Message</label>
                            <textarea 
                                id="enq_msg" 
                                name="message" 
                                rows="3" 
                                placeholder="Please arrange a private escorted viewing at this address..." 
                                class="w-full bg-[#1B3128] border border-white/20 text-white px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-[#DFCF9F] font-['Plus_Jakarta_Sans'] resize-none"
                            >I am interested in scheduling a private viewing for <?= Format::e($property['title']) ?> (Ref: <?= Format::e($ref) ?>).</textarea>
                        </div>

                        <button type="submit" id="prop-enquiry-btn" class="w-full bg-gradient-to-r from-[#B99A62] to-[#8C7343] hover:from-[#C9A86A] hover:to-[#B99A62] text-[#171A18] py-4 px-6 rounded-full font-['Manrope'] text-xs uppercase tracking-[0.18em] font-bold shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                            <span id="prop-btn-text">Enquire About This Property &rarr;</span>
                            <span id="prop-btn-spinner" class="hidden w-4 h-4 border-2 border-[#171A18] border-t-transparent rounded-full animate-spin"></span>
                        </button>
                    </form>

                    <!-- Trust Footnote -->
                    <div class="pt-2 flex items-center justify-between text-[0.6875rem] text-gray-300 font-['Manrope'] uppercase tracking-wider border-t border-white/10">
                        <span>Strict Bilateral NDA</span>
                        <span>•</span>
                        <a href="tel:<?= $phoneClean ?>" class="text-[#DFCF9F] hover:underline font-semibold">Call Desk: <?= Format::e($phone) ?></a>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- ============================================================
         05. RELATED PROPERTIES SECTION (YOU MAY ALSO CONSIDER)
         ============================================================ -->
    <?php if (!empty($similarProperties)): ?>
        <section class="w-full py-20 lg:py-28 bg-[#F5F1E8] border-t border-[#E0D7C9]/60">
            <div class="max-w-[1440px] mx-auto px-6 lg:px-16 space-y-12">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="space-y-2">
                        <span class="text-xs uppercase tracking-[0.2em] text-[#B99A62] font-['Manrope'] font-semibold">Curated Portfolio</span>
                        <h2 class="text-2xl sm:text-3xl text-[#243F34] font-normal font-['Playfair_Display']">You May Also Consider</h2>
                    </div>
                    <a href="<?= $baseUrl ?>/properties" class="text-xs uppercase text-[#243F34] hover:text-[#B99A62] tracking-widest inline-flex items-center gap-2 font-['Manrope'] font-bold transition-colors">
                        <span>View All Curated Residences</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($similarProperties as $sim): 
                        $simImg = !empty($sim['featured_image']) ? $sim['featured_image'] : '/assets/images/stitch/hero-residence.jpg';
                        $simImgSrc = str_starts_with($simImg, 'http') ? $simImg : $baseUrl . $simImg;
                        $simUrl = $baseUrl . '/properties/' . Format::e($sim['slug']);
                        $simRef = !empty($sim['mandate_ref']) ? $sim['mandate_ref'] : 'EH-' . $sim['id'];
                    ?>
                        <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-[#E0D7C9] flex flex-col group">
                            <a href="<?= $simUrl ?>" class="block relative aspect-[16/10] overflow-hidden bg-[#EAE3D7]">
                                <img 
                                    src="<?= $simImgSrc ?>" 
                                    alt="<?= Format::e($sim['title']) ?>" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                >
                                <div class="absolute top-4 left-4 bg-[#243F34] text-white px-3 py-1 rounded-full text-[0.625rem] uppercase tracking-widest font-['Manrope'] font-semibold">
                                    <?= Format::e($sim['area_name']) ?> · Ref: <?= Format::e($simRef) ?>
                                </div>
                            </a>
                            <div class="p-6 flex flex-col justify-between flex-1 space-y-4 bg-[#FAF8F4]">
                                <div class="space-y-1.5">
                                    <h4 class="text-lg text-[#243F34] font-normal leading-snug font-['Playfair_Display'] group-hover:text-[#B99A62] transition-colors">
                                        <a href="<?= $simUrl ?>"><?= Format::e($sim['title']) ?></a>
                                    </h4>
                                    <p class="text-xs text-[#5C605D] font-['Plus_Jakarta_Sans'] line-clamp-2">
                                        <?= Format::e(substr(strip_tags($sim['description']), 0, 110)) ?>...
                                    </p>
                                </div>
                                <div class="pt-3 flex items-center justify-between border-t border-[#E0D7C9]">
                                    <span class="text-base text-[#243F34] font-medium font-['Playfair_Display']">
                                        <?= Format::e($sim['price_display']) ?>
                                    </span>
                                    <a href="<?= $simUrl ?>" class="text-xs uppercase tracking-wider font-['Manrope'] font-bold text-[#243F34] hover:text-[#B99A62]">
                                        View &rarr;
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

</div>

<!-- ============================================================
     LIGHTBOX GALLERY MODAL COMPONENT
     ============================================================ -->
<div class="fixed inset-0 z-[100] bg-[#171A18]/95 backdrop-blur-md hidden flex-col justify-between p-6 sm:p-12 transition-opacity duration-300" id="gallery-lightbox">
    <div class="flex items-center justify-between text-white max-w-6xl mx-auto w-full">
        <div class="text-xs uppercase tracking-widest font-mono text-[#DFCF9F]">
            <?= Format::e($ref) ?> · <?= Format::e($property['title']) ?> (<span id="lightbox-index">1</span>/<?= count($allGallery) ?>)
        </div>
        <button type="button" class="text-white hover:text-[#DFCF9F] text-xs uppercase tracking-widest flex items-center gap-2 font-semibold" id="lightbox-close">
            <span>Close</span>
            <span class="text-xl">&times;</span>
        </button>
    </div>

    <div class="max-w-5xl mx-auto max-h-[75vh] flex items-center justify-center overflow-hidden my-auto">
        <img alt="Archival property showcase view" class="max-h-[72vh] max-w-full object-contain shadow-2xl rounded-xl" id="lightbox-image" src="<?= $allGallery[0] ?>">
    </div>

    <div class="flex items-center justify-between max-w-5xl mx-auto w-full text-white pt-4 border-t border-white/10">
        <button type="button" class="text-xs uppercase tracking-widest hover:text-[#DFCF9F] flex items-center gap-2 font-['Manrope'] font-semibold" id="lightbox-prev">
            <span>&larr;</span> Previous
        </button>
        <span class="text-xs text-gray-300 italic text-center font-['Playfair_Display'] hidden sm:inline" id="lightbox-caption">
            <?= Format::e($property['title']) ?> Architectural Portfolio
        </span>
        <button type="button" class="text-xs uppercase tracking-widest hover:text-[#DFCF9F] flex items-center gap-2 font-['Manrope'] font-semibold" id="lightbox-next">
            Next <span>&rarr;</span>
        </button>
    </div>
</div>

<!-- Lightbox & Interactive Gallery Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const galleryItems = <?= json_encode($allGallery) ?>;
    let currentIndex = 0;

    const primaryImg = document.getElementById('primary-gallery-img');
    const thumbItems = document.querySelectorAll('.thumb-item');
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxImg = document.getElementById('lightbox-image');
    const lightboxIdx = document.getElementById('lightbox-index');
    const openLightboxBtn = document.getElementById('open-lightbox-btn');
    const closeLightboxBtn = document.getElementById('lightbox-close');
    const prevBtn = document.getElementById('lightbox-prev');
    const nextBtn = document.getElementById('lightbox-next');

    // Thumbnail click switches primary image
    thumbItems.forEach(thumb => {
        thumb.addEventListener('click', () => {
            const src = thumb.getAttribute('data-src');
            const idx = parseInt(thumb.getAttribute('data-idx') || '0', 10);
            if (primaryImg && src) {
                primaryImg.src = src;
                currentIndex = idx;
            }
        });
    });

    function openLightbox(idx = 0) {
        currentIndex = idx;
        if (lightbox && lightboxImg) {
            lightboxImg.src = galleryItems[currentIndex];
            if (lightboxIdx) lightboxIdx.textContent = currentIndex + 1;
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeLightbox() {
        if (lightbox) {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }

    if (openLightboxBtn) openLightboxBtn.addEventListener('click', () => openLightbox(currentIndex));
    if (primaryImg) primaryImg.parentElement.addEventListener('click', (e) => {
        if (e.target !== openLightboxBtn && !openLightboxBtn.contains(e.target)) {
            openLightbox(currentIndex);
        }
    });

    if (closeLightboxBtn) closeLightboxBtn.addEventListener('click', closeLightbox);

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
            if (lightboxImg) lightboxImg.src = galleryItems[currentIndex];
            if (lightboxIdx) lightboxIdx.textContent = currentIndex + 1;
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % galleryItems.length;
            if (lightboxImg) lightboxImg.src = galleryItems[currentIndex];
            if (lightboxIdx) lightboxIdx.textContent = currentIndex + 1;
        });
    }

    document.addEventListener('keydown', (e) => {
        if (!lightbox || lightbox.classList.contains('hidden')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft' && prevBtn) prevBtn.click();
        if (e.key === 'ArrowRight' && nextBtn) nextBtn.click();
    });

    // Dynamic AJAX Submission for Property Enquiry Form
    const propForm = document.getElementById('property-enquiry-form');
    if (propForm) {
        propForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const feedback = document.getElementById('prop-enquiry-feedback');
            const submitBtn = document.getElementById('prop-enquiry-btn');
            const btnText = document.getElementById('prop-btn-text');
            const btnSpinner = document.getElementById('prop-btn-spinner');

            submitBtn.disabled = true;
            if (btnText) btnText.textContent = 'Transmitting Viewing Request...';
            if (btnSpinner) btnSpinner.classList.remove('hidden');

            const formData = new FormData(propForm);

            fetch(propForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json().catch(() => ({ success: false, message: 'Server communication error. Please phone our desk directly.' })))
            .then(data => {
                feedback.classList.remove('hidden', 'bg-red-900/50', 'text-red-200', 'border-red-500/50', 'bg-[#1B3128]', 'text-[#DFCF9F]', 'border-[#B99A62]/40');
                if (data.success) {
                    feedback.textContent = data.message || 'Thank you. Your viewing request has been scheduled with priority.';
                    feedback.classList.add('bg-[#1B3128]', 'text-[#DFCF9F]', 'border', 'border-[#B99A62]/40');
                    propForm.reset();
                } else {
                    feedback.textContent = data.message || data.error || 'Unable to submit enquiry. Please call our desk.';
                    feedback.classList.add('bg-red-900/50', 'text-red-200', 'border', 'border-red-500/50');
                }
                feedback.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            })
            .catch(err => {
                feedback.classList.remove('hidden');
                feedback.textContent = 'A network error occurred. Please contact our advisory desk directly.';
                feedback.classList.add('bg-red-900/50', 'text-red-200', 'border', 'border-red-500/50');
            })
            .finally(() => {
                submitBtn.disabled = false;
                if (btnText) btnText.innerHTML = 'Enquire About This Property &rarr;';
                if (btnSpinner) btnSpinner.classList.add('hidden');
            });
        });
    }
});
</script>
