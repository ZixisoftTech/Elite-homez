<?php
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$settings = $siteSettings ?? [];
$phone = $settings['phone_primary'] ?? '+91 (011) 4100 8800';
$phone = $settings['phone_primary'] ?? '+91 9811044200';
$cleanPhone = preg_replace('/[^0-9\+]/', '', $phone);
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$cleanWa = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($cleanWa) === 10) {
    $cleanWa = '91' . $cleanWa;
}
$rera = $settings['rera_number'] ?? 'DLRERA2023A00892';

$items = $services ?? [];

// Helper for image paths
$getImgSrc = function(?string $path, string $default) use ($baseUrl) {
    if (empty($path)) return $baseUrl . $default;
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
    return $baseUrl . '/' . ltrim($path, '/');
};

// Featured service is the first one (Buying Advisory)
$featuredService = $items[0] ?? null;
// Remaining services for the alternating showcase
$showcaseServices = array_slice($items, 1);
?>

<div class="flex flex-col w-full bg-[#FAF8F4] text-[#171A18] selection:bg-[#B99A62] selection:text-[#171A18] overflow-hidden">

    <!-- ============================================================
         SECTION 1: SERVICES HERO (CINEMATIC ARCHITECTURAL)
         ============================================================ -->
    <section class="relative w-full bg-[#171A18] text-white pt-28 pb-16 lg:pt-36 lg:pb-24 px-6 lg:px-16 overflow-hidden">
        <!-- Background Architectural Scrim -->
        <div class="absolute inset-0">
            <img 
                src="<?= $baseUrl ?>/assets/images/stitch/service-hero-villa.jpg" 
                alt="Elite Homez Real Estate Advisory Services" 
                class="w-full h-full object-cover scale-105 transition-transform duration-1000"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-[#171A18]/95 via-[#243F34]/85 to-[#171A18]/70"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#171A18] via-transparent to-black/30"></div>
        </div>

        <div class="relative max-w-[1440px] mx-auto z-10">
            <!-- Breadcrumb Strip -->
            <nav class="flex items-center gap-2 font-['Manrope'] uppercase text-[0.7rem] tracking-[0.25em] text-[#DFCF9F]/80 mb-8" aria-label="Breadcrumb">
                <a class="hover:text-white transition-colors" href="<?= $baseUrl ?>/">Home</a>
                <span class="text-[#B99A62]">/</span>
                <span class="text-white font-semibold">Services &amp; Advisory</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-end">
                <!-- 60% Editorial Narrative Column -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-[#B99A62]/40 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-[#B99A62] animate-pulse"></span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#DFCF9F] font-semibold">
                            Our Expertise
                        </span>
                    </div>

                    <h1 class="font-['Playfair_Display'] text-4xl sm:text-5xl lg:text-[4.25rem] text-white font-normal leading-[1.08] tracking-tight">
                        Thoughtful Real Estate Services. <br />
                        <span class="italic text-[#DFCF9F]">Exceptional Experiences.</span>
                    </h1>

                    <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg lg:text-xl text-gray-200 font-light leading-relaxed max-w-xl">
                        From discovering exceptional properties to navigating important real-estate decisions, Elite Homez brings a personalised and professional approach to every interaction.
                    </p>

                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <a href="#services-showcase" 
                           class="inline-flex items-center gap-3 px-8 py-4 bg-[#B99A62] hover:bg-[#A88B53] text-[#171A18] font-['Manrope'] text-xs uppercase tracking-[0.2em] font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-[#B99A62]/20">
                            <span>Explore Our Services</span>
                            <span class="text-base">&darr;</span>
                        </a>
                        <a href="https://wa.me/<?= $cleanWa ?>?text=<?= urlencode('Hello Elite Homez Advisory Desk, I would like to consult on luxury real estate advisory services.') ?>" 
                           target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2.5 px-7 py-4 bg-white/10 hover:bg-white/20 text-white font-['Manrope'] text-xs uppercase tracking-[0.18em] font-semibold rounded-lg border border-white/20 backdrop-blur-md transition-all">
                            <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>WhatsApp Senior Desk</span>
                        </a>
                    </div>
                </div>

                <!-- 40% Hero Floating Advisory Metric Card -->
                <div class="lg:col-span-5">
                    <div class="bg-[#243F34]/90 backdrop-blur-xl p-8 rounded-2xl border border-[#B99A62]/35 shadow-2xl space-y-6">
                        <div class="flex items-center justify-between pb-4 border-b border-white/10">
                            <div>
                                <span class="font-['Manrope'] text-[0.65rem] uppercase tracking-[0.25em] text-[#DFCF9F] block font-semibold">Institutional Fiduciary</span>
                                <h3 class="font-['Playfair_Display'] text-xl text-white font-medium">Bespoke Practice Scope</h3>
                            </div>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#B99A62]/20 border border-[#B99A62]/40 text-[#DFCF9F]">
                                ✦
                            </span>
                        </div>

                        <!-- 4 Core Service Metrics -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                                <span class="block text-2xl font-normal text-white font-['Playfair_Display']"><?= count($items) ?></span>
                                <span class="text-[0.65rem] uppercase tracking-wider text-[#DFCF9F] font-['Manrope'] font-semibold">Advisory Practices</span>
                            </div>
                            <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                                <span class="block text-2xl font-normal text-white font-['Playfair_Display']">₹1,200 Cr+</span>
                                <span class="text-[0.65rem] uppercase tracking-wider text-[#DFCF9F] font-['Manrope'] font-semibold">Asset Advisory</span>
                            </div>
                            <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                                <span class="block text-2xl font-normal text-white font-['Playfair_Display']">100%</span>
                                <span class="text-[0.65rem] uppercase tracking-wider text-[#DFCF9F] font-['Manrope'] font-semibold">Client-Aligned</span>
                            </div>
                            <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                                <span class="block text-2xl font-normal text-white font-['Playfair_Display']">Zero</span>
                                <span class="text-[0.65rem] uppercase tracking-wider text-[#DFCF9F] font-['Manrope'] font-semibold">Broker Conflict</span>
                            </div>
                        </div>

                        <p class="font-['Plus_Jakarta_Sans'] text-xs text-gray-300 font-light leading-relaxed">
                            Every engagement is led directly by senior advisory principals under strict bilateral non-disclosure agreements, delivering forensic clarity and discrete transaction execution.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION 2: SERVICES INTRODUCTION (ASYMMETRIC COMPOSITION)
         "Real Estate Expertise, Guided by Your Aspirations."
         ============================================================ -->
    <section class="w-full py-20 lg:py-28 px-6 lg:px-16 bg-[#FAF8F4] border-b border-[#D8CDBA]/40">
        <div class="max-w-[1440px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <!-- Left: Editorial Text Block -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="inline-flex items-center gap-2">
                        <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.25em] text-[#B99A62] font-semibold">
                            Our Guiding Philosophy
                        </span>
                    </div>

                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-normal text-[#171A18] leading-[1.15]">
                        Real Estate Expertise, <br />
                        <span class="italic text-[#243F34]">Guided by Your Aspirations.</span>
                    </h2>

                    <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg text-[#4A504B] font-light leading-relaxed">
                        Our approach is centred on understanding your requirements, presenting suitable opportunities and providing professional guidance throughout your property journey.
                    </p>

                    <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-[#5C605D] font-light leading-relaxed">
                        Whether representing a generational family office acquiring a marquee bungalow, an ambassadorial delegation seeking sovereign security leasing, or an estate executor divesting prime assets, we bridge granular South Delhi micro-market intelligence with institutional execution.
                    </p>

                    <div class="pt-4 grid grid-cols-2 gap-6 border-t border-[#D8CDBA]/40">
                        <div class="space-y-1">
                            <span class="font-['Manrope'] text-xs uppercase tracking-wider text-[#B99A62] font-bold block">Discreet Sourcing</span>
                            <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#5C605D] font-light">Accessing off-market estates not listed on commercial portals.</p>
                        </div>
                        <div class="space-y-1">
                            <span class="font-['Manrope'] text-xs uppercase tracking-wider text-[#B99A62] font-bold block">Forensic Diligence</span>
                            <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#5C605D] font-light">Title vetting, sanctioned FAR limits, and municipal zoning.</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Asymmetric Floating Photographic Composition -->
                <div class="lg:col-span-6 relative">
                    <div class="relative w-full aspect-[4/3] rounded-3xl overflow-hidden bg-[#EAE3D7] shadow-2xl border border-[#D8CDBA]/60 group">
                        <img 
                            src="<?= $baseUrl ?>/assets/images/stitch/service-living-pause.jpg" 
                            alt="Elite Homez Luxury Architectural Interior" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/70 via-transparent to-transparent"></div>

                        <!-- Floating Quote Card -->
                        <div class="absolute bottom-6 left-6 right-6 p-6 bg-[#FAF8F4]/95 backdrop-blur-md rounded-2xl border border-[#B99A62]/30 shadow-xl space-y-2">
                            <span class="font-['Manrope'] uppercase tracking-widest text-[#B99A62] text-[0.65rem] font-bold block">
                                Fiduciary Commitment
                            </span>
                            <p class="font-['Playfair_Display'] text-base sm:text-lg text-[#171A18] font-normal leading-snug">
                                "Discretion, diligence, and forensic attention to every detail across every mandate."
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION 3: FEATURED SERVICE COMPOSITION (FLAGSHIP PRACTICE)
         Large Image-Led Layout for Luxury Buying Advisory
         ============================================================ -->
    <?php if ($featuredService): 
        $fNum = str_pad((string)($featuredService['sort_order'] ?? 1), 2, '0', STR_PAD_LEFT);
        $fImg = $getImgSrc($featuredService['image'] ?? null, '/assets/images/services/uhnw-advisory.jpg');
        $fUrl = $baseUrl . '/services/' . Format::e($featuredService['slug']);
    ?>
        <section id="services-showcase" class="w-full py-20 lg:py-28 px-6 lg:px-16 bg-[#F5F1E8] border-b border-[#D8CDBA]/40">
            <div class="max-w-[1440px] mx-auto space-y-12">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-[#D8CDBA]/40">
                    <div class="space-y-2">
                        <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-[0.25em] text-[#B99A62]">
                            Flagship Practice Area
                        </span>
                        <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-normal text-[#171A18]">
                            Featured Advisory Discipline
                        </h2>
                    </div>
                    <span class="font-['Manrope'] text-xs uppercase tracking-[0.2em] text-[#4A504B] font-semibold">
                        Practice Monograph <?= $fNum ?>
                    </span>
                </div>

                <div class="group relative bg-white rounded-3xl overflow-hidden border border-[#D8CDBA]/50 shadow-xl hover:shadow-2xl transition-all duration-500">
                    <div class="grid grid-cols-1 lg:grid-cols-12">
                        <!-- 60% Image Column with Overlay Badges -->
                        <div class="lg:col-span-7 relative min-h-[380px] lg:min-h-[520px] overflow-hidden bg-[#171A18]">
                            <img 
                                src="<?= $fImg ?>" 
                                alt="<?= Format::e($featuredService['name']) ?>" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/85 via-black/20 to-transparent"></div>

                            <div class="absolute top-6 left-6 right-6 flex items-center justify-between">
                                <span class="bg-[#171A18]/90 backdrop-blur-md text-[#DFCF9F] font-['Manrope'] text-xs uppercase tracking-[0.2em] font-semibold px-4 py-1.5 rounded-full border border-[#B99A62]/40">
                                    Advisory Practice <?= $fNum ?>
                                </span>
                                <span class="bg-white/95 backdrop-blur-md text-[#243F34] font-['Manrope'] text-xs uppercase tracking-wider font-bold px-3.5 py-1.5 rounded-full shadow-sm">
                                    Exclusive Buy-Side
                                </span>
                            </div>

                            <div class="absolute bottom-6 left-6 right-6 text-white space-y-1">
                                <span class="text-[0.65rem] uppercase tracking-widest text-[#DFCF9F] font-['Manrope'] font-semibold block">Primary Representation</span>
                                <div class="font-['Playfair_Display'] text-xl sm:text-2xl font-normal text-white">Bespoke Acquisition &amp; Retained Mandates</div>
                            </div>
                        </div>

                        <!-- 40% Editorial Panel in Forest Green -->
                        <div class="lg:col-span-5 bg-[#243F34] text-white p-8 sm:p-10 lg:p-12 flex flex-col justify-between space-y-8">
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-[0.25em] text-[#DFCF9F]">
                                        Property Buying Assistance
                                    </span>
                                    <h3 class="font-['Playfair_Display'] text-3xl sm:text-4xl text-white font-normal leading-tight">
                                        <?= Format::e($featuredService['name']) ?>
                                    </h3>
                                </div>

                                <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-gray-200 font-light leading-relaxed">
                                    <?= !empty($featuredService['short_description']) ? Format::e($featuredService['short_description']) : 'Independent, discreet buy-side representation for ultra-high-net-worth individuals, institutional family offices, and discerning buyers seeking trophy assets in South Delhi.' ?>
                                </p>

                                <div class="space-y-3 pt-2 border-t border-white/15">
                                    <div class="flex items-start gap-3 text-xs font-['Plus_Jakarta_Sans'] text-gray-200">
                                        <span class="text-[#DFCF9F] text-base leading-none">✦</span>
                                        <span>Confidential access to unlisted Lutyens &amp; South Delhi generational estates.</span>
                                    </div>
                                    <div class="flex items-start gap-3 text-xs font-['Plus_Jakarta_Sans'] text-gray-200">
                                        <span class="text-[#DFCF9F] text-base leading-none">✦</span>
                                        <span>30-year forensic title audits by leading real estate solicitors.</span>
                                    </div>
                                    <div class="flex items-start gap-3 text-xs font-['Plus_Jakarta_Sans'] text-gray-200">
                                        <span class="text-[#DFCF9F] text-base leading-none">✦</span>
                                        <span>Strategic price benchmarking against certified enclave transactional indices.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6 border-t border-white/15 flex flex-wrap items-center justify-between gap-4">
                                <a href="<?= $fUrl ?>" 
                                   class="inline-flex items-center gap-2 px-6 py-3.5 bg-[#B99A62] hover:bg-[#A88B53] text-[#171A18] font-['Manrope'] text-xs uppercase tracking-[0.18em] font-bold rounded-lg transition-colors">
                                    <span>Explore Service Mandate</span>
                                    <span>&rarr;</span>
                                </a>
                                <a href="https://wa.me/<?= $cleanWa ?>?text=<?= urlencode('Hello Elite Homez, I would like to consult on Luxury Property Buying Advisory.') ?>" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="font-['Manrope'] text-xs uppercase tracking-[0.16em] text-[#DFCF9F] hover:text-white font-semibold transition-colors">
                                    Inquire via WhatsApp &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ============================================================
         SECTION 4: SERVICES SHOWCASE (ALTERNATING EDITORIAL BLOCKS)
         Large Blocks, Numerical Labels, Alternating Light & Dark
         ============================================================ -->
    <section class="w-full py-20 lg:py-28 px-6 lg:px-16 space-y-16 lg:space-y-24">
        <div class="max-w-[1440px] mx-auto space-y-16 lg:space-y-24">
            
            <div class="max-w-2xl space-y-3">
                <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-[0.25em] text-[#B99A62]">
                    Comprehensive Capabilities
                </span>
                <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-normal text-[#171A18]">
                    Specialized Advisory Disciplines
                </h2>
                <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-[#4A504B] font-light leading-relaxed">
                    Every service is tailored to the statutory, privacy, and capital allocation requirements of our clients.
                </p>
            </div>

            <?php foreach ($showcaseServices as $sIdx => $s): 
                $sNum = str_pad((string)($s['sort_order'] ?? ($sIdx + 2)), 2, '0', STR_PAD_LEFT);
                $sImg = $getImgSrc($s['image'] ?? null, '/assets/images/services/asset-divestment.jpg');
                $sUrl = $baseUrl . '/services/' . Format::e($s['slug']);
                $isDark = ($sIdx % 2 === 1); // Alternate light and dark styling
            ?>
                <div class="group rounded-3xl overflow-hidden border border-[#D8CDBA]/50 shadow-lg hover:shadow-2xl transition-all duration-500 <?= $isDark ? 'bg-[#171A18] text-white' : 'bg-white text-[#171A18]' ?>">
                    <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">
                        
                        <?php if ($sIdx % 2 === 0): ?>
                            <!-- Left: Image, Right: Content -->
                            <div class="lg:col-span-6 relative min-h-[340px] lg:min-h-[440px] overflow-hidden bg-[#243F34]">
                                <img 
                                    src="<?= $sImg ?>" 
                                    alt="<?= Format::e($s['name']) ?>" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out"
                                    loading="lazy"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                <div class="absolute top-6 left-6">
                                    <span class="bg-[#171A18]/90 text-[#DFCF9F] font-['Manrope'] text-xs uppercase tracking-[0.2em] font-semibold px-4 py-1.5 rounded-full border border-[#B99A62]/40">
                                        Practice <?= $sNum ?>
                                    </span>
                                </div>
                            </div>

                            <div class="lg:col-span-6 p-8 sm:p-12 lg:p-16 flex flex-col justify-between space-y-6">
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3">
                                        <span class="text-3xl font-normal text-[#B99A62] font-['Playfair_Display']"><?= $sNum ?></span>
                                        <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.2em] text-[#B99A62] font-semibold">Specialized Practice</span>
                                    </div>

                                    <h3 class="font-['Playfair_Display'] text-2xl sm:text-3xl lg:text-4xl font-normal leading-tight">
                                        <?= Format::e($s['name']) ?>
                                    </h3>

                                    <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-[#4A504B] font-light leading-relaxed">
                                        <?= Format::e($s['short_description']) ?>
                                    </p>
                                </div>

                                <div class="pt-6 border-t border-[#D8CDBA]/30 flex flex-wrap items-center justify-between gap-4">
                                    <a href="<?= $sUrl ?>" 
                                       class="inline-flex items-center gap-2 px-6 py-3 bg-[#243F34] hover:bg-[#1B3128] text-white font-['Manrope'] text-xs uppercase tracking-[0.18em] font-bold rounded-lg transition-colors shadow-md">
                                        <span>Explore Service</span>
                                        <span>&rarr;</span>
                                    </a>
                                    <a href="https://wa.me/<?= $cleanWa ?>?text=<?= urlencode('Hello Elite Homez, I would like to consult regarding ' . $s['name'] . '.') ?>" 
                                       target="_blank" rel="noopener noreferrer"
                                       class="text-xs font-['Manrope'] uppercase tracking-wider text-[#B99A62] hover:text-[#243F34] font-semibold transition-colors">
                                        Direct Enquiry &rarr;
                                    </a>
                                </div>
                            </div>

                        <?php else: ?>
                            <!-- Left: Content, Right: Image (Alternating) -->
                            <div class="lg:col-span-6 p-8 sm:p-12 lg:p-16 flex flex-col justify-between space-y-6 order-2 lg:order-1">
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3">
                                        <span class="text-3xl font-normal text-[#DFCF9F] font-['Playfair_Display']"><?= $sNum ?></span>
                                        <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.2em] text-[#DFCF9F] font-semibold">Senior Mandate</span>
                                    </div>

                                    <h3 class="font-['Playfair_Display'] text-2xl sm:text-3xl lg:text-4xl font-normal text-white leading-tight">
                                        <?= Format::e($s['name']) ?>
                                    </h3>

                                    <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-gray-300 font-light leading-relaxed">
                                        <?= Format::e($s['short_description']) ?>
                                    </p>
                                </div>

                                <div class="pt-6 border-t border-white/15 flex flex-wrap items-center justify-between gap-4">
                                    <a href="<?= $sUrl ?>" 
                                       class="inline-flex items-center gap-2 px-6 py-3 bg-[#B99A62] hover:bg-[#A88B53] text-[#171A18] font-['Manrope'] text-xs uppercase tracking-[0.18em] font-bold rounded-lg transition-colors shadow-md">
                                        <span>Explore Service</span>
                                        <span>&rarr;</span>
                                    </a>
                                    <a href="https://wa.me/<?= $cleanWa ?>?text=<?= urlencode('Hello Elite Homez, I would like to consult regarding ' . $s['name'] . '.') ?>" 
                                       target="_blank" rel="noopener noreferrer"
                                       class="text-xs font-['Manrope'] uppercase tracking-wider text-[#DFCF9F] hover:text-white font-semibold transition-colors">
                                        Direct Enquiry &rarr;
                                    </a>
                                </div>
                            </div>

                            <div class="lg:col-span-6 relative min-h-[340px] lg:min-h-[440px] overflow-hidden bg-[#243F34] order-1 lg:order-2">
                                <img 
                                    src="<?= $sImg ?>" 
                                    alt="<?= Format::e($s['name']) ?>" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out"
                                    loading="lazy"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/80 via-transparent to-transparent"></div>
                                <div class="absolute top-6 right-6">
                                    <span class="bg-[#171A18]/90 text-[#DFCF9F] font-['Manrope'] text-xs uppercase tracking-[0.2em] font-semibold px-4 py-1.5 rounded-full border border-[#B99A62]/40">
                                        Practice <?= $sNum ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </section>

    <!-- ============================================================
         SECTION 5: OUR APPROACH
         "A More Personal Approach to Real Estate."
         01. Understand | 02. Discover | 03. Connect | 04. Guide
         ============================================================ -->
    <section class="w-full bg-[#243F34] text-white py-20 lg:py-28 px-6 lg:px-16 relative overflow-hidden">
        <!-- Subtle Pattern Backdrop -->
        <div class="absolute inset-0 opacity-5 pointer-events-none bg-[radial-gradient(#DFCF9F_1px,transparent_1px)] [background-size:24px_24px]"></div>

        <div class="relative max-w-[1440px] mx-auto space-y-16 lg:space-y-20">
            <!-- Header -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                <div class="lg:col-span-7 space-y-4">
                    <span class="font-['Manrope'] text-xs uppercase tracking-[0.25em] text-[#DFCF9F] font-semibold block">
                        The Client Experience
                    </span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-normal text-white leading-tight">
                        A More Personal Approach <br />
                        <span class="italic text-[#DFCF9F]">to Real Estate.</span>
                    </h2>
                </div>
                <div class="lg:col-span-5">
                    <p class="font-['Plus_Jakarta_Sans'] text-base text-gray-300 font-light leading-relaxed">
                        We avoid transactional haste in favor of measured advisory. Every property mandate progresses through four deliberate stages designed to protect your privacy, time, and capital.
                    </p>
                </div>
            </div>

            <!-- 4 Visual Progression Stages -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- Stage 01 -->
                <div class="relative bg-white/5 border border-white/10 rounded-2xl p-8 space-y-6 hover:border-[#B99A62]/50 transition-colors group">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <span class="font-['Playfair_Display'] text-4xl text-[#DFCF9F] font-normal group-hover:scale-110 transition-transform">01</span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-widest text-gray-400 font-semibold">Stage I</span>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-['Playfair_Display'] text-2xl text-white font-normal">Understand</h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                            Understand the client's requirements, preferences, and objectives through confidential discovery sessions, establishing exact spatial, architectural, and financial criteria.
                        </p>
                    </div>
                </div>

                <!-- Stage 02 -->
                <div class="relative bg-white/5 border border-white/10 rounded-2xl p-8 space-y-6 hover:border-[#B99A62]/50 transition-colors group">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <span class="font-['Playfair_Display'] text-4xl text-[#DFCF9F] font-normal group-hover:scale-110 transition-transform">02</span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-widest text-gray-400 font-semibold">Stage II</span>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-['Playfair_Display'] text-2xl text-white font-normal">Discover</h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                            Explore relevant properties and suitable opportunities, unlocking private off-market estates and sovereign diplomatic enclaves filtered against strict due diligence.
                        </p>
                    </div>
                </div>

                <!-- Stage 03 -->
                <div class="relative bg-white/5 border border-white/10 rounded-2xl p-8 space-y-6 hover:border-[#B99A62]/50 transition-colors group">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <span class="font-['Playfair_Display'] text-4xl text-[#DFCF9F] font-normal group-hover:scale-110 transition-transform">03</span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-widest text-gray-400 font-semibold">Stage III</span>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-['Playfair_Display'] text-2xl text-white font-normal">Connect</h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                            Facilitate communication and property enquiries under strict bilateral non-disclosure covenants, arranging discreet escorted viewings tailored to your schedule.
                        </p>
                    </div>
                </div>

                <!-- Stage 04 -->
                <div class="relative bg-white/5 border border-white/10 rounded-2xl p-8 space-y-6 hover:border-[#B99A62]/50 transition-colors group">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <span class="font-['Playfair_Display'] text-4xl text-[#DFCF9F] font-normal group-hover:scale-110 transition-transform">04</span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-widest text-gray-400 font-semibold">Stage IV</span>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-['Playfair_Display'] text-2xl text-white font-normal">Guide</h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                            Provide professional guidance throughout the property journey, from statutory title audits and price benchmarking to final conveyance registration and keys handover.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION 6: WHY CHOOSE ELITE HOMEZ (VALUE PROPOSITION)
         Personalised Attention | Premium Focus | South Delhi Expertise
         ============================================================ -->
    <section class="w-full py-20 lg:py-28 px-6 lg:px-16 bg-[#FAF8F4] border-b border-[#D8CDBA]/40">
        <div class="max-w-[1440px] mx-auto space-y-16">
            
            <div class="max-w-2xl space-y-3">
                <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-[0.25em] text-[#B99A62]">
                    Fiduciary Alignment
                </span>
                <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-normal text-[#171A18]">
                    Why Choose Elite Homez
                </h2>
                <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-[#4A504B] font-light leading-relaxed">
                    We eliminate the conflict of traditional commission-driven brokerage by operating as trusted advisors focused on long-term client relationships.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Pillar 1 -->
                <div class="bg-white p-8 rounded-2xl border border-[#D8CDBA]/50 shadow-sm hover:shadow-md transition-shadow space-y-4">
                    <span class="font-['Playfair_Display'] text-3xl text-[#B99A62] font-normal">01</span>
                    <h3 class="font-['Playfair_Display'] text-2xl text-[#171A18] font-normal">Personalised Attention</h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-[#4A504B] font-light leading-relaxed">
                        Every mandate is directly handled by senior partners with single-point accountability. You never deal with junior sales intermediaries.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="bg-white p-8 rounded-2xl border border-[#D8CDBA]/50 shadow-sm hover:shadow-md transition-shadow space-y-4">
                    <span class="font-['Playfair_Display'] text-3xl text-[#B99A62] font-normal">02</span>
                    <h3 class="font-['Playfair_Display'] text-2xl text-[#171A18] font-normal">Premium Property Focus</h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-[#4A504B] font-light leading-relaxed">
                        We represent exclusively high-end residential assets — independent bungalows, bespoke architect builder floors, and luxury penthouses.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="bg-white p-8 rounded-2xl border border-[#D8CDBA]/50 shadow-sm hover:shadow-md transition-shadow space-y-4">
                    <span class="font-['Playfair_Display'] text-3xl text-[#B99A62] font-normal">03</span>
                    <h3 class="font-['Playfair_Display'] text-2xl text-[#171A18] font-normal">South Delhi Mastery</h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-[#4A504B] font-light leading-relaxed">
                        Over two decades of established presence across Vasant Vihar, Jor Bagh, Golf Links, Chanakyapuri, and surrounding diplomatic enclaves.
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="bg-white p-8 rounded-2xl border border-[#D8CDBA]/50 shadow-sm hover:shadow-md transition-shadow space-y-4">
                    <span class="font-['Playfair_Display'] text-3xl text-[#B99A62] font-normal">04</span>
                    <h3 class="font-['Playfair_Display'] text-2xl text-[#171A18] font-normal">Professional Communication</h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-[#4A504B] font-light leading-relaxed">
                        Transparent reporting, prompt feedback, clear valuation benchmarking, and complete documentation integrity from enquiry to closing.
                    </p>
                </div>

                <!-- Pillar 5 -->
                <div class="bg-white p-8 rounded-2xl border border-[#D8CDBA]/50 shadow-sm hover:shadow-md transition-shadow space-y-4">
                    <span class="font-['Playfair_Display'] text-3xl text-[#B99A62] font-normal">05</span>
                    <h3 class="font-['Playfair_Display'] text-2xl text-[#171A18] font-normal">Client-First Discretion</h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-[#4A504B] font-light leading-relaxed">
                        Bilateral non-disclosure protection for all client records, family wealth structures, and off-market property negotiations.
                    </p>
                </div>

                <!-- Pillar 6 (Statutory Compliance) -->
                <div class="bg-[#F5F1E8] p-8 rounded-2xl border border-[#B99A62]/30 shadow-sm space-y-4">
                    <span class="font-['Playfair_Display'] text-3xl text-[#243F34] font-normal">06</span>
                    <h3 class="font-['Playfair_Display'] text-2xl text-[#243F34] font-normal">RERA Certified Practice</h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-[#4A504B] font-light leading-relaxed">
                        Full compliance under DLRERA2023A00892. Forensic title vetting with property solicitors ensuring zero legacy encumbrances.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION 7: FINAL ARCHITECTURAL CTA
         "Let's Find the Right Opportunity Together."
         ============================================================ -->
    <section class="relative w-full bg-[#171A18] text-white py-24 lg:py-32 px-6 lg:px-16 overflow-hidden">
        <!-- Background Architectural Scrim -->
        <div class="absolute inset-0">
            <img 
                src="<?= $baseUrl ?>/assets/images/stitch/service-cta-dusk.jpg" 
                alt="Elite Homez Real Estate Advisory Team" 
                class="w-full h-full object-cover scale-105"
                loading="lazy"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-[#171A18]/95 via-[#243F34]/90 to-[#171A18]/85"></div>
        </div>

        <div class="relative max-w-4xl mx-auto text-center space-y-8 z-10">
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full border border-[#B99A62]/40 text-[#DFCF9F] font-['Manrope'] text-xs uppercase tracking-[0.22em] font-semibold">
                <span class="w-2 h-2 rounded-full bg-[#B99A62] animate-pulse"></span>
                <span>Private Consultation</span>
            </div>

            <h2 class="font-['Playfair_Display'] text-4xl sm:text-5xl lg:text-6xl font-normal text-white leading-[1.12]">
                Let's Find the Right <br />
                <span class="italic text-[#DFCF9F]">Opportunity Together.</span>
            </h2>

            <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg text-gray-200 font-light leading-relaxed max-w-2xl mx-auto">
                Connect with Elite Homez to explore personalised real-estate assistance. Our senior partners are available for a confidential discussion regarding your property requirements.
            </p>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <a href="<?= $baseUrl ?>/contact-us" 
                   class="px-8 py-4 bg-[#B99A62] hover:bg-[#A88B53] text-[#171A18] font-['Manrope'] text-xs font-bold uppercase tracking-[0.2em] rounded-lg transition-all duration-300 shadow-xl hover:shadow-[#B99A62]/20">
                    Contact Our Team
                </a>
                <a href="https://wa.me/<?= $cleanWa ?>?text=<?= urlencode('Hello Elite Homez Senior Partner, I would like to schedule a private advisory consultation.') ?>" 
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2.5 px-7 py-4 bg-white/10 hover:bg-white/20 text-white font-['Manrope'] text-xs font-semibold uppercase tracking-[0.18em] rounded-lg border border-white/20 backdrop-blur-md transition-all">
                    <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>WhatsApp Senior Partner</span>
                </a>
            </div>

            <!-- Discretion Subtext -->
            <div class="pt-4 text-xs font-['Manrope'] uppercase tracking-[0.2em] text-[#DFCF9F]/70">
                <span>✦ All advisory mandates conducted under strict bilateral non-disclosure agreements</span>
            </div>
        </div>
    </section>

</div>
