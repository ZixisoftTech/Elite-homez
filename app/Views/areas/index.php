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

$areasList = $areas ?? [];
$featuredProps = $featuredProperties ?? [];

// Helper for resolving image paths
$getImgSrc = function(?string $path, string $default) use ($baseUrl) {
    if (empty($path)) return $baseUrl . $default;
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
    return $baseUrl . '/' . ltrim($path, '/');
};

// Calculate total property count across all enclaves
$totalProps = array_sum(array_map(fn($a) => (int)($a['property_count'] ?? 0), $areasList));
?>

<div class="flex flex-col w-full bg-[#FAF8F4] text-[#171A18] selection:bg-[#B99A62] selection:text-[#171A18] overflow-hidden">

    <!-- ============================================================
         SECTION 1: EDITORIAL LOCATION HERO (CINEMATIC ARCHITECTURAL)
         ============================================================ -->
    <section class="relative w-full bg-[#171A18] text-white pt-28 pb-16 lg:pt-36 lg:pb-24 px-6 lg:px-16 overflow-hidden">
        <!-- Background Architectural Scrim -->
        <div class="absolute inset-0">
            <img 
                src="<?= $baseUrl ?>/assets/images/stitch/area-vasant-vihar-hero.jpg" 
                alt="Elite Homez Prime South Delhi Enclaves" 
                class="w-full h-full object-cover scale-105 transition-transform duration-1000"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-[#171A18]/95 via-[#243F34]/85 to-[#171A18]/70"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#171A18] via-transparent to-black/30"></div>
        </div>

        <div class="relative max-w-[1440px] mx-auto z-10">
            <!-- Breadcrumbs Strip -->
            <nav class="flex items-center gap-2 font-['Manrope'] uppercase text-[0.7rem] tracking-[0.25em] text-[#DFCF9F]/80 mb-8" aria-label="Breadcrumb">
                <a class="hover:text-white transition-colors" href="<?= $baseUrl ?>/">Home</a>
                <span class="text-[#B99A62]">/</span>
                <span class="text-white font-semibold">Locations &amp; Service Areas</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-end">
                <!-- 60% Editorial Narrative Column -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-[#B99A62]/40 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-[#B99A62] animate-pulse"></span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#DFCF9F] font-semibold">
                            Explore Our Locations
                        </span>
                    </div>

                    <h1 class="font-['Playfair_Display'] text-4xl sm:text-5xl lg:text-[4.25rem] text-white font-normal leading-[1.08] tracking-tight">
                        Discover the Address <br />
                        <span class="italic text-[#DFCF9F]">That Defines Your Lifestyle.</span>
                    </h1>

                    <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg lg:text-xl text-gray-200 font-light leading-relaxed max-w-xl">
                        Explore some of South Delhi's most prestigious residential neighbourhoods, where exceptional homes meet distinctive lifestyles, sovereign diplomatic security, and generational heritage.
                    </p>

                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <a href="#enclaves-showcase" 
                           class="inline-flex items-center gap-3 px-8 py-4 bg-[#B99A62] hover:bg-[#A88B53] text-[#171A18] font-['Manrope'] text-xs uppercase tracking-[0.2em] font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-[#B99A62]/20">
                            <span>Explore Neighbourhoods</span>
                            <span class="text-base">&darr;</span>
                        </a>
                        <a href="<?= $baseUrl ?>/properties" 
                           class="inline-flex items-center gap-2 px-7 py-4 bg-white/10 hover:bg-white/20 text-white font-['Manrope'] text-xs uppercase tracking-[0.18em] font-semibold rounded-lg border border-white/20 backdrop-blur-md transition-all">
                            <span>View All Residences (<?= $totalProps > 0 ? $totalProps : 16 ?>)</span>
                        </a>
                    </div>
                </div>

                <!-- 40% Hero Floating Territory Dossier Card -->
                <div class="lg:col-span-5">
                    <div class="bg-[#243F34]/90 backdrop-blur-xl p-8 rounded-2xl border border-[#B99A62]/35 shadow-2xl space-y-6">
                        <div class="flex items-center justify-between pb-4 border-b border-white/10">
                            <div>
                                <span class="font-['Manrope'] text-[0.65rem] uppercase tracking-[0.25em] text-[#DFCF9F] block font-semibold">Territory Monograph Index</span>
                                <h3 class="font-['Playfair_Display'] text-xl text-white font-medium">South Delhi Micro-Markets</h3>
                            </div>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#B99A62]/20 border border-[#B99A62]/40 text-[#DFCF9F]">
                                ✦
                            </span>
                        </div>

                        <!-- 4 Key Territory Metrics -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                                <span class="block text-2xl font-normal text-white font-['Playfair_Display']"><?= count($areasList) ?></span>
                                <span class="text-[0.65rem] uppercase tracking-wider text-[#DFCF9F] font-['Manrope'] font-semibold">Prime Enclaves</span>
                            </div>
                            <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                                <span class="block text-2xl font-normal text-white font-['Playfair_Display']">₹1,200 Cr+</span>
                                <span class="text-[0.65rem] uppercase tracking-wider text-[#DFCF9F] font-['Manrope'] font-semibold">Asset Advisory</span>
                            </div>
                            <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                                <span class="block text-2xl font-normal text-white font-['Playfair_Display']">100%</span>
                                <span class="text-[0.65rem] uppercase tracking-wider text-[#DFCF9F] font-['Manrope'] font-semibold">Clear Freehold Title</span>
                            </div>
                            <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                                <span class="block text-2xl font-normal text-white font-['Playfair_Display']">20+ Yrs</span>
                                <span class="text-[0.65rem] uppercase tracking-wider text-[#DFCF9F] font-['Manrope'] font-semibold">Enclave Advisory</span>
                            </div>
                        </div>

                        <p class="font-['Plus_Jakarta_Sans'] text-xs text-gray-300 font-light leading-relaxed">
                            Each enclave maintains its own distinct municipal FAR, ownership covenants, and private transaction protocols. Our partners advise HNI and family office clients with confidential discretion.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION 2: ENCLAVE QUICK-JUMP FILTER STRIP
         ============================================================ -->
    <div class="sticky top-20 z-30 w-full bg-[#F5F1E8]/95 backdrop-blur-md border-y border-[#B99A62]/20 py-4 px-6 lg:px-16 shadow-sm">
        <div class="max-w-[1440px] mx-auto flex items-center justify-between gap-4 overflow-x-auto no-scrollbar">
            <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#243F34] font-bold shrink-0 hidden sm:inline-flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#B99A62]"></span>
                Enclaves:
            </span>
            <div class="flex items-center gap-2 shrink-0">
                <?php foreach ($areasList as $idx => $quickArea): ?>
                    <a href="#enclave-<?= Format::e($quickArea['slug']) ?>" 
                       class="px-3 py-1.5 bg-white hover:bg-[#243F34] hover:text-white text-[#171A18] font-['Manrope'] text-xs font-semibold rounded-full border border-[#D8CDBA]/60 transition-all duration-200 shrink-0">
                        <?= Format::e($quickArea['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <a href="<?= $baseUrl ?>/properties" class="shrink-0 font-['Manrope'] text-xs uppercase tracking-[0.16em] text-[#B99A62] hover:text-[#243F34] font-bold hidden md:inline-flex items-center gap-1 transition-colors">
                <span>View All Properties</span>
                <span>&rarr;</span>
            </a>
        </div>
    </div>

    <!-- ============================================================
         SECTION 3: FEATURED LOCATIONS (ASYMMETRIC EDITORIAL SHOWCASE)
         ============================================================ -->
    <section id="enclaves-showcase" class="w-full py-16 lg:py-24 px-6 lg:px-16">
        <div class="max-w-[1440px] mx-auto space-y-16 lg:space-y-24">

            <!-- Section Eyebrow & Intro -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-8 border-b border-[#D8CDBA]/40">
                <div class="space-y-3 max-w-2xl">
                    <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-[0.25em] text-[#B99A62]">
                        Curated Neighbourhood Portfolios
                    </span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-normal text-[#171A18] leading-tight">
                        Prestigious South Delhi Enclaves
                    </h2>
                </div>
                <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-[#4A504B] font-light max-w-md leading-relaxed">
                    Explore sovereign diplomatic perimeters, historic Lutyens borders, and quiet leafy sanctuaries vetted by our private advisory desk.
                </p>
            </div>

            <?php 
            // Separate into layout tiers:
            // 1. Flagship Enclave (First item - e.g. Vasant Vihar)
            // 2. Duet Asymmetric Pair (Next 2 items - e.g. Jor Bagh & Golf Links)
            // 3. Mosaic Trio (Next 3 items - e.g. Chanakyapuri, Panchsheel Park, Shanti Niketan)
            // 4. Promenade Grid (Remaining items - e.g. Anand Niketan, Westend, Hauz Khas, Greater Kailash)
            $flagship = $areasList[0] ?? null;
            $duet = array_slice($areasList, 1, 2);
            $mosaic = array_slice($areasList, 3, 3);
            $promenade = array_slice($areasList, 6);
            ?>

            <!-- TIER 1: DOMINANT FLAGSHIP SHOWCASE (e.g. Vasant Vihar) -->
            <?php if ($flagship): 
                $flagshipNum = str_pad((string)($flagship['sort_order'] ?? 1), 2, '0', STR_PAD_LEFT);
                $flagshipImg = $getImgSrc($flagship['hero_image'] ?? null, '/assets/images/areas/vasant-vihar.jpg');
                $flagshipCount = (int)($flagship['property_count'] ?? 0);
                
                // Decode types
                $flagshipTypes = [];
                if (!empty($flagship['property_types'])) {
                    $decoded = is_array($flagship['property_types']) ? $flagship['property_types'] : json_decode((string)$flagship['property_types'], true);
                    if (is_array($decoded)) {
                        foreach ($decoded as $t) {
                            if (!empty($t['title'])) $flagshipTypes[] = $t['title'];
                        }
                    }
                }
                if (empty($flagshipTypes)) {
                    $flagshipTypes = ['Independent Bungalows', 'Luxury Builder Floors', 'Penthouses'];
                }
            ?>
                <div id="enclave-<?= Format::e($flagship['slug']) ?>" class="group relative bg-white rounded-3xl overflow-hidden border border-[#D8CDBA]/50 shadow-xl hover:shadow-2xl transition-all duration-500">
                    <div class="grid grid-cols-1 lg:grid-cols-12">
                        <!-- 60% Cinematic Imagery Column with Overlay Insets -->
                        <div class="lg:col-span-7 relative min-h-[380px] lg:min-h-[520px] overflow-hidden bg-[#171A18]">
                            <img 
                                src="<?= $flagshipImg ?>" 
                                alt="<?= Format::e($flagship['name']) ?> Luxury Real Estate" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/80 via-transparent to-black/20"></div>

                            <!-- Top Badges -->
                            <div class="absolute top-6 left-6 right-6 flex items-center justify-between">
                                <span class="bg-[#171A18]/90 backdrop-blur-md text-[#DFCF9F] font-['Manrope'] text-xs uppercase tracking-[0.2em] font-semibold px-4 py-1.5 rounded-full border border-[#B99A62]/40">
                                    Territory Monograph <?= $flagshipNum ?>
                                </span>
                                <?php if ($flagshipCount > 0): ?>
                                    <span class="bg-white/95 backdrop-blur-md text-[#243F34] font-['Manrope'] text-xs uppercase tracking-wider font-bold px-3.5 py-1.5 rounded-full shadow-sm">
                                        <?= $flagshipCount ?> Active <?= $flagshipCount === 1 ? 'Mandate' : 'Mandates' ?>
                                    </span>
                                <?php else: ?>
                                    <span class="bg-[#243F34]/90 backdrop-blur-md text-[#DFCF9F] font-['Manrope'] text-xs uppercase tracking-wider font-semibold px-3.5 py-1.5 rounded-full">
                                        Private Off-Market Briefs
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Bottom Floating Micro Inset -->
                            <div class="absolute bottom-6 left-6 right-6 bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/20 text-white flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <span class="text-[0.65rem] uppercase tracking-widest text-[#DFCF9F] font-['Manrope'] font-semibold">Micro-Market Profile</span>
                                    <div class="font-['Playfair_Display'] text-sm font-medium">Diplomatic Mission Perimeter &amp; Green Corridors</div>
                                </div>
                                <span class="text-xs text-[#DFCF9F] font-['Manrope'] uppercase tracking-wider font-bold">Zone A1</span>
                            </div>
                        </div>

                        <!-- 40% Editorial Content Panel in Deep Forest Tint -->
                        <div class="lg:col-span-5 bg-[#243F34] text-white p-8 sm:p-10 lg:p-12 flex flex-col justify-between space-y-8">
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-[0.25em] text-[#DFCF9F]">
                                        Flagship Residential Territory
                                    </span>
                                    <h3 class="font-['Playfair_Display'] text-3xl sm:text-4xl text-white font-normal">
                                        <?= Format::e($flagship['name']) ?>
                                    </h3>
                                </div>

                                <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-gray-200 font-light leading-relaxed">
                                    <?= !empty($flagship['short_description']) ? Format::e($flagship['short_description']) : 'Home to over 50 foreign diplomatic embassies and high commissions, characterised by sprawling 400 to 1,200 sq. yd. residential parcels, tree-lined boulevards, and exclusive security perimeters.' ?>
                                </p>

                                <!-- Available Property Formats -->
                                <div class="space-y-2 pt-2 border-t border-white/15">
                                    <span class="block font-['Manrope'] text-[0.68rem] uppercase tracking-[0.2em] text-[#DFCF9F] font-semibold">
                                        Available Asset Formats:
                                    </span>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (array_slice($flagshipTypes, 0, 3) as $t): ?>
                                            <span class="px-3 py-1 bg-white/10 border border-white/15 rounded-md font-['Manrope'] text-xs text-white">
                                                <?= Format::e($t) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- CTAs -->
                            <div class="pt-6 border-t border-white/15 flex flex-wrap items-center justify-between gap-4">
                                <a href="<?= $baseUrl ?>/locations/<?= Format::e($flagship['slug']) ?>" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-[#B99A62] hover:bg-[#A88B53] text-[#171A18] font-['Manrope'] text-xs uppercase tracking-[0.18em] font-bold rounded-lg transition-colors">
                                    <span>Explore Location Dossier</span>
                                    <span>&rarr;</span>
                                </a>
                                <a href="<?= $baseUrl ?>/properties?area=<?= Format::e($flagship['slug']) ?>" 
                                   class="font-['Manrope'] text-xs uppercase tracking-[0.16em] text-[#DFCF9F] hover:text-white font-semibold transition-colors">
                                    View Properties (<?= $flagshipCount ?>) &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- TIER 2: ASYMMETRIC DUET SHOWCASE (e.g. Jor Bagh & Golf Links) -->
            <?php if (!empty($duet)): ?>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                    <?php 
                    // Item 1: 7-column widescreen (Jor Bagh)
                    $d1 = $duet[0] ?? null;
                    if ($d1):
                        $d1Num = str_pad((string)($d1['sort_order'] ?? 2), 2, '0', STR_PAD_LEFT);
                        $d1Img = $getImgSrc($d1['hero_image'] ?? null, '/assets/images/areas/jor-bagh.jpg');
                        $d1Count = (int)($d1['property_count'] ?? 0);
                    ?>
                        <div id="enclave-<?= Format::e($d1['slug']) ?>" class="lg:col-span-7 group bg-white rounded-3xl overflow-hidden border border-[#D8CDBA]/50 shadow-md hover:shadow-xl transition-all duration-500 flex flex-col justify-between">
                            <div class="relative w-full aspect-[16/10] overflow-hidden bg-[#171A18]">
                                <img 
                                    src="<?= $d1Img ?>" 
                                    alt="<?= Format::e($d1['name']) ?> Luxury Residences" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out"
                                    loading="lazy"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/85 via-black/20 to-transparent"></div>
                                
                                <div class="absolute top-5 left-5 right-5 flex items-center justify-between">
                                    <span class="bg-[#171A18]/90 backdrop-blur-md text-[#DFCF9F] font-['Manrope'] text-xs uppercase tracking-[0.2em] font-semibold px-3.5 py-1 rounded-full border border-[#B99A62]/40">
                                        Monograph <?= $d1Num ?>
                                    </span>
                                    <span class="bg-white/90 backdrop-blur-md text-[#171A18] font-['Manrope'] text-xs uppercase tracking-wider font-semibold px-3 py-1 rounded-full">
                                        <?= $d1Count ?> <?= $d1Count === 1 ? 'Residence' : 'Residences' ?>
                                    </span>
                                </div>

                                <div class="absolute bottom-5 left-5 right-5 text-white">
                                    <span class="font-['Manrope'] text-[0.68rem] uppercase tracking-[0.25em] text-[#DFCF9F] block mb-1">Heritage Lutyens Boundary</span>
                                    <h3 class="font-['Playfair_Display'] text-2xl sm:text-3xl font-normal group-hover:text-[#DFCF9F] transition-colors">
                                        <?= Format::e($d1['name']) ?>
                                    </h3>
                                </div>
                            </div>

                            <div class="p-8 space-y-6 flex-1 flex flex-col justify-between">
                                <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-[#4A504B] font-light leading-relaxed">
                                    <?= !empty($d1['short_description']) ? Format::e($d1['short_description']) : 'Overlooking Lodhi Gardens and Safdarjung Tomb, Jor Bagh remains one of New Delhi\'s most tightly held colonial-scale enclaves.' ?>
                                </p>

                                <div class="pt-4 border-t border-[#D8CDBA]/30 flex items-center justify-between">
                                    <a href="<?= $baseUrl ?>/locations/<?= Format::e($d1['slug']) ?>" 
                                       class="inline-flex items-center gap-2 text-xs font-['Manrope'] uppercase tracking-[0.2em] font-bold text-[#171A18] group-hover:text-[#B99A62] transition-colors">
                                        <span>Explore Monograph</span>
                                        <span>&rarr;</span>
                                    </a>
                                    <a href="<?= $baseUrl ?>/properties?area=<?= Format::e($d1['slug']) ?>" 
                                       class="text-xs font-['Manrope'] uppercase tracking-[0.16em] text-[#B99A62] hover:text-[#171A18] font-semibold">
                                        View Properties &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php 
                    // Item 2: 5-column tall editorial card (Golf Links)
                    $d2 = $duet[1] ?? null;
                    if ($d2):
                        $d2Num = str_pad((string)($d2['sort_order'] ?? 3), 2, '0', STR_PAD_LEFT);
                        $d2Img = $getImgSrc($d2['hero_image'] ?? null, '/assets/images/areas/golf-links.jpg');
                        $d2Count = (int)($d2['property_count'] ?? 0);
                    ?>
                        <div id="enclave-<?= Format::e($d2['slug']) ?>" class="lg:col-span-5 group bg-white rounded-3xl overflow-hidden border border-[#D8CDBA]/50 shadow-md hover:shadow-xl transition-all duration-500 flex flex-col justify-between">
                            <div class="relative w-full aspect-[4/3] overflow-hidden bg-[#171A18]">
                                <img 
                                    src="<?= $d2Img ?>" 
                                    alt="<?= Format::e($d2['name']) ?> Luxury Estates" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out"
                                    loading="lazy"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/85 via-black/20 to-transparent"></div>

                                <div class="absolute top-5 left-5 right-5 flex items-center justify-between">
                                    <span class="bg-[#171A18]/90 backdrop-blur-md text-[#DFCF9F] font-['Manrope'] text-xs uppercase tracking-[0.2em] font-semibold px-3.5 py-1 rounded-full border border-[#B99A62]/40">
                                        Monograph <?= $d2Num ?>
                                    </span>
                                    <span class="bg-white/90 backdrop-blur-md text-[#171A18] font-['Manrope'] text-xs uppercase tracking-wider font-semibold px-3 py-1 rounded-full">
                                        <?= $d2Count ?> <?= $d2Count === 1 ? 'Residence' : 'Residences' ?>
                                    </span>
                                </div>

                                <div class="absolute bottom-5 left-5 right-5 text-white">
                                    <span class="font-['Manrope'] text-[0.68rem] uppercase tracking-[0.25em] text-[#DFCF9F] block mb-1">Historic Championship Greens</span>
                                    <h3 class="font-['Playfair_Display'] text-2xl sm:text-3xl font-normal group-hover:text-[#DFCF9F] transition-colors">
                                        <?= Format::e($d2['name']) ?>
                                    </h3>
                                </div>
                            </div>

                            <div class="p-8 space-y-6 flex-1 flex flex-col justify-between">
                                <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-[#4A504B] font-light leading-relaxed">
                                    <?= !empty($d2['short_description']) ? Format::e($d2['short_description']) : 'Adjoining the Delhi Golf Club and Delhi Zoo, Golf Links offers sovereign exclusivity with sprawling residential plots of 575 to 1,250 sq. yds.' ?>
                                </p>

                                <div class="pt-4 border-t border-[#D8CDBA]/30 flex items-center justify-between">
                                    <a href="<?= $baseUrl ?>/locations/<?= Format::e($d2['slug']) ?>" 
                                       class="inline-flex items-center gap-2 text-xs font-['Manrope'] uppercase tracking-[0.2em] font-bold text-[#171A18] group-hover:text-[#B99A62] transition-colors">
                                        <span>Explore Monograph</span>
                                        <span>&rarr;</span>
                                    </a>
                                    <a href="<?= $baseUrl ?>/properties?area=<?= Format::e($d2['slug']) ?>" 
                                       class="text-xs font-['Manrope'] uppercase tracking-[0.16em] text-[#B99A62] hover:text-[#171A18] font-semibold">
                                        View Properties &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- TIER 3: ASYMMETRIC TRIO MOSAIC (e.g. Chanakyapuri, Panchsheel Park, Shanti Niketan) -->
            <?php if (!empty($mosaic)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 items-stretch">
                    <?php 
                    // Card 1: 6-column widescreen card (Chanakyapuri)
                    $m1 = $mosaic[0] ?? null;
                    if ($m1):
                        $m1Num = str_pad((string)($m1['sort_order'] ?? 4), 2, '0', STR_PAD_LEFT);
                        $m1Img = $getImgSrc($m1['hero_image'] ?? null, '/assets/images/areas/chanakyapuri.jpg');
                        $m1Count = (int)($m1['property_count'] ?? 0);
                    ?>
                        <div id="enclave-<?= Format::e($m1['slug']) ?>" class="lg:col-span-6 group bg-white rounded-3xl overflow-hidden border border-[#D8CDBA]/50 shadow-md hover:shadow-xl transition-all duration-500 flex flex-col justify-between">
                            <div class="relative w-full aspect-[16/10] overflow-hidden bg-[#171A18]">
                                <img 
                                    src="<?= $m1Img ?>" 
                                    alt="<?= Format::e($m1['name']) ?> Luxury Estates" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out"
                                    loading="lazy"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/85 via-black/20 to-transparent"></div>

                                <div class="absolute top-4 left-4 right-4 flex items-center justify-between">
                                    <span class="bg-[#171A18]/90 backdrop-blur-md text-[#DFCF9F] font-['Manrope'] text-xs uppercase tracking-[0.2em] font-semibold px-3 py-1 rounded-full border border-[#B99A62]/40">
                                        Monograph <?= $m1Num ?>
                                    </span>
                                    <span class="bg-white/90 backdrop-blur-md text-[#171A18] font-['Manrope'] text-xs uppercase tracking-wider font-semibold px-3 py-1 rounded-full">
                                        <?= $m1Count ?> <?= $m1Count === 1 ? 'Residence' : 'Residences' ?>
                                    </span>
                                </div>

                                <div class="absolute bottom-4 left-4 right-4 text-white">
                                    <span class="font-['Manrope'] text-[0.68rem] uppercase tracking-[0.22em] text-[#DFCF9F] block mb-1">Diplomatic Capital</span>
                                    <h3 class="font-['Playfair_Display'] text-2xl font-normal group-hover:text-[#DFCF9F] transition-colors">
                                        <?= Format::e($m1['name']) ?>
                                    </h3>
                                </div>
                            </div>

                            <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                                <p class="font-['Plus_Jakarta_Sans'] text-sm text-[#4A504B] font-light leading-relaxed">
                                    <?= !empty($m1['short_description']) ? Format::e($m1['short_description']) : 'The official diplomatic enclave of India, housing premier embassies, high commissions, and the prestigious Malcha Marg residential strip.' ?>
                                </p>

                                <div class="pt-4 border-t border-[#D8CDBA]/30 flex items-center justify-between">
                                    <a href="<?= $baseUrl ?>/locations/<?= Format::e($m1['slug']) ?>" 
                                       class="inline-flex items-center gap-1.5 text-xs font-['Manrope'] uppercase tracking-[0.2em] font-bold text-[#171A18] group-hover:text-[#B99A62] transition-colors">
                                        <span>Explore</span>
                                        <span>&rarr;</span>
                                    </a>
                                    <a href="<?= $baseUrl ?>/properties?area=<?= Format::e($m1['slug']) ?>" class="text-xs font-['Manrope'] text-[#B99A62] hover:underline font-semibold uppercase">
                                        Properties &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php 
                    // Card 2: 3-column card (Panchsheel Park)
                    $m2 = $mosaic[1] ?? null;
                    if ($m2):
                        $m2Num = str_pad((string)($m2['sort_order'] ?? 5), 2, '0', STR_PAD_LEFT);
                        $m2Img = $getImgSrc($m2['hero_image'] ?? null, '/assets/images/areas/panchsheel-park.jpg');
                        $m2Count = (int)($m2['property_count'] ?? 0);
                    ?>
                        <div id="enclave-<?= Format::e($m2['slug']) ?>" class="lg:col-span-3 group bg-white rounded-3xl overflow-hidden border border-[#D8CDBA]/50 shadow-md hover:shadow-xl transition-all duration-500 flex flex-col justify-between">
                            <div class="relative w-full aspect-[4/3] overflow-hidden bg-[#171A18]">
                                <img 
                                    src="<?= $m2Img ?>" 
                                    alt="<?= Format::e($m2['name']) ?> Luxury Estates" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out"
                                    loading="lazy"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/85 via-black/20 to-transparent"></div>

                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                    <span class="bg-[#171A18]/90 text-[#DFCF9F] font-['Manrope'] text-[0.65rem] uppercase tracking-wider font-semibold px-2.5 py-0.5 rounded-full border border-[#B99A62]/40">
                                        <?= $m2Num ?>
                                    </span>
                                    <span class="bg-white/90 text-[#171A18] font-['Manrope'] text-[0.65rem] uppercase font-semibold px-2 py-0.5 rounded-full">
                                        <?= $m2Count ?>
                                    </span>
                                </div>

                                <div class="absolute bottom-3 left-3 right-3 text-white">
                                    <h3 class="font-['Playfair_Display'] text-xl font-normal group-hover:text-[#DFCF9F] transition-colors">
                                        <?= Format::e($m2['name']) ?>
                                    </h3>
                                </div>
                            </div>

                            <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                                <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#4A504B] font-light leading-relaxed line-clamp-3">
                                    <?= !empty($m2['short_description']) ? Format::e($m2['short_description']) : 'Bifurcated by Outer Ring Road into North and South wings with expansive 500 to 1,000 sq. yd. luxury plots.' ?>
                                </p>

                                <div class="pt-3 border-t border-[#D8CDBA]/30 flex items-center justify-between">
                                    <a href="<?= $baseUrl ?>/locations/<?= Format::e($m2['slug']) ?>" 
                                       class="text-xs font-['Manrope'] uppercase tracking-wider font-bold text-[#171A18] group-hover:text-[#B99A62]">
                                        Explore &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php 
                    // Card 3: 3-column card (Shanti Niketan)
                    $m3 = $mosaic[2] ?? null;
                    if ($m3):
                        $m3Num = str_pad((string)($m3['sort_order'] ?? 6), 2, '0', STR_PAD_LEFT);
                        $m3Img = $getImgSrc($m3['hero_image'] ?? null, '/assets/images/areas/shanti-niketan.jpg');
                        $m3Count = (int)($m3['property_count'] ?? 0);
                    ?>
                        <div id="enclave-<?= Format::e($m3['slug']) ?>" class="lg:col-span-3 group bg-white rounded-3xl overflow-hidden border border-[#D8CDBA]/50 shadow-md hover:shadow-xl transition-all duration-500 flex flex-col justify-between">
                            <div class="relative w-full aspect-[4/3] overflow-hidden bg-[#171A18]">
                                <img 
                                    src="<?= $m3Img ?>" 
                                    alt="<?= Format::e($m3['name']) ?> Luxury Estates" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out"
                                    loading="lazy"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/85 via-black/20 to-transparent"></div>

                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                    <span class="bg-[#171A18]/90 text-[#DFCF9F] font-['Manrope'] text-[0.65rem] uppercase tracking-wider font-semibold px-2.5 py-0.5 rounded-full border border-[#B99A62]/40">
                                        <?= $m3Num ?>
                                    </span>
                                    <span class="bg-white/90 text-[#171A18] font-['Manrope'] text-[0.65rem] uppercase font-semibold px-2 py-0.5 rounded-full">
                                        <?= $m3Count ?>
                                    </span>
                                </div>

                                <div class="absolute bottom-3 left-3 right-3 text-white">
                                    <h3 class="font-['Playfair_Display'] text-xl font-normal group-hover:text-[#DFCF9F] transition-colors">
                                        <?= Format::e($m3['name']) ?>
                                    </h3>
                                </div>
                            </div>

                            <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                                <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#4A504B] font-light leading-relaxed line-clamp-3">
                                    <?= !empty($m3['short_description']) ? Format::e($m3['short_description']) : 'A tranquil low-density diplomatic enclave established for senior officials, renowned for its stately tree cover.' ?>
                                </p>

                                <div class="pt-3 border-t border-[#D8CDBA]/30 flex items-center justify-between">
                                    <a href="<?= $baseUrl ?>/locations/<?= Format::e($m3['slug']) ?>" 
                                       class="text-xs font-['Manrope'] uppercase tracking-wider font-bold text-[#171A18] group-hover:text-[#B99A62]">
                                        Explore &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- TIER 4: PROMENADE ENCLAVE SUITE (Anand Niketan, Westend, Hauz Khas, Greater Kailash) -->
            <?php if (!empty($promenade)): ?>
                <div class="space-y-6 pt-4">
                    <div class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#B99A62]"></span>
                        <h3 class="font-['Playfair_Display'] text-2xl text-[#171A18] font-normal">
                            Further Prestigious South Delhi Addresses
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach ($promenade as $p): 
                            $pNum = str_pad((string)($p['sort_order'] ?? 7), 2, '0', STR_PAD_LEFT);
                            $pImg = $getImgSrc($p['hero_image'] ?? null, '/assets/images/areas/anand-niketan.jpg');
                            $pCount = (int)($p['property_count'] ?? 0);
                        ?>
                            <div id="enclave-<?= Format::e($p['slug']) ?>" class="group bg-white rounded-2xl overflow-hidden border border-[#D8CDBA]/40 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                                <div class="relative w-full aspect-[16/10] overflow-hidden bg-[#171A18]">
                                    <img 
                                        src="<?= $pImg ?>" 
                                        alt="<?= Format::e($p['name']) ?> Luxury Estates" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                                        loading="lazy"
                                    />
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/80 via-transparent to-transparent"></div>

                                    <div class="absolute top-3 left-3">
                                        <span class="bg-[#171A18]/90 text-[#DFCF9F] font-['Manrope'] text-[0.625rem] uppercase tracking-wider font-semibold px-2 py-0.5 rounded-full border border-[#B99A62]/30">
                                            <?= $pNum ?>
                                        </span>
                                    </div>
                                    <div class="absolute bottom-3 left-3 right-3 text-white">
                                        <h4 class="font-['Playfair_Display'] text-lg font-normal group-hover:text-[#DFCF9F] transition-colors">
                                            <?= Format::e($p['name']) ?>
                                        </h4>
                                    </div>
                                </div>

                                <div class="p-4 space-y-3 flex-1 flex flex-col justify-between">
                                    <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#5C605D] font-light leading-relaxed line-clamp-2">
                                        <?= Format::e($p['short_description'] ?? '') ?>
                                    </p>

                                    <div class="pt-3 border-t border-[#D8CDBA]/20 flex items-center justify-between text-xs font-['Manrope']">
                                        <a href="<?= $baseUrl ?>/locations/<?= Format::e($p['slug']) ?>" 
                                           class="uppercase tracking-wider font-bold text-[#171A18] group-hover:text-[#B99A62] transition-colors">
                                            Explore &rarr;
                                        </a>
                                        <a href="<?= $baseUrl ?>/properties?area=<?= Format::e($p['slug']) ?>" 
                                           class="text-[#B99A62] hover:underline font-semibold">
                                            <?= $pCount ?> <?= $pCount === 1 ? 'Prop' : 'Props' ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- ============================================================
         SECTION 4: LOCATION STORYTELLING
         "More Than a Location. A Way of Living."
         ============================================================ -->
    <section class="w-full bg-[#171A18] text-white py-20 lg:py-28 px-6 lg:px-16 relative overflow-hidden">
        <!-- Subtle Pattern Backdrop -->
        <div class="absolute inset-0 opacity-5 pointer-events-none bg-[radial-gradient(#DFCF9F_1px,transparent_1px)] [background-size:24px_24px]"></div>

        <div class="relative max-w-[1440px] mx-auto space-y-16 lg:space-y-20">
            <!-- Section Header -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                <div class="lg:col-span-7 space-y-4">
                    <span class="font-['Manrope'] text-xs uppercase tracking-[0.25em] text-[#DFCF9F] font-semibold block">
                        The South Delhi Advantage
                    </span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-normal text-white leading-tight">
                        More Than a Location. <br />
                        <span class="italic text-[#DFCF9F]">A Way of Living.</span>
                    </h2>
                </div>
                <div class="lg:col-span-5">
                    <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg text-gray-300 font-light leading-relaxed">
                        South Delhi's prime residential enclaves represent a sanctuary of low-density living, guarded by century-old tree canopies, diplomatic security cordons, and generational provenance found nowhere else in the National Capital Region.
                    </p>
                </div>
            </div>

            <!-- 4 Distinct Lifestyle Pillars -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Pillar 1 -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-8 space-y-4 hover:border-[#B99A62]/40 transition-colors">
                    <div class="w-12 h-12 rounded-full bg-[#B99A62]/15 border border-[#B99A62]/30 flex items-center justify-center text-[#DFCF9F]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-['Playfair_Display'] text-xl text-white font-medium">Diplomatic Security</h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                        Surrounded by over 70 foreign embassies and diplomatic missions, benefiting from permanent Delhi Police cordons, perimeter monitoring, and round-the-clock VIP patrol networks.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-8 space-y-4 hover:border-[#B99A62]/40 transition-colors">
                    <div class="w-12 h-12 rounded-full bg-[#B99A62]/15 border border-[#B99A62]/30 flex items-center justify-center text-[#DFCF9F]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="font-['Playfair_Display'] text-xl text-white font-medium">Generational Pedigree</h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                        Neighbours of historic distinction — cabinet ministers, senior jurists, Fortune 500 chairmen, and royal legacy families who have held freehold parcels across generations.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-8 space-y-4 hover:border-[#B99A62]/40 transition-colors">
                    <div class="w-12 h-12 rounded-full bg-[#B99A62]/15 border border-[#B99A62]/30 flex items-center justify-center text-[#DFCF9F]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-['Playfair_Display'] text-xl text-white font-medium">Unrivalled Connectivity</h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                        15 minutes to Indira Gandhi International Airport (Terminal 3), 10 minutes to Delhi Golf Club and Lodhi Gardens, with immediate access to Central Lutyens and the Ring Roads.
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-8 space-y-4 hover:border-[#B99A62]/40 transition-colors">
                    <div class="w-12 h-12 rounded-full bg-[#B99A62]/15 border border-[#B99A62]/30 flex items-center justify-center text-[#DFCF9F]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="font-['Playfair_Display'] text-xl text-white font-medium">Strict Zoning Sanctions</h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                        Rigid municipal building height sanctions, designated setback lines, and mandatory stilt parking allocations prevent commercial dilution and safeguard residential tranquility.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION 5: DISCOVER PROPERTIES CTA
         "Find Your Next Home in South Delhi."
         ============================================================ -->
    <section class="w-full py-20 lg:py-28 px-6 lg:px-16 bg-[#F5F1E8] border-b border-[#D8CDBA]/40">
        <div class="max-w-[1440px] mx-auto space-y-12">
            <!-- Header Strip -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3">
                    <span class="font-['Manrope'] text-xs font-semibold uppercase tracking-[0.25em] text-[#B99A62]">
                        Available In These Enclaves
                    </span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-normal text-[#171A18]">
                        Find Your Next Home in South Delhi
                    </h2>
                </div>
                <a href="<?= $baseUrl ?>/properties" 
                   class="inline-flex items-center gap-2 px-6 py-3.5 bg-[#243F34] hover:bg-[#1B3128] text-white font-['Manrope'] text-xs uppercase tracking-[0.2em] font-bold rounded-lg transition-colors shadow-md">
                    <span>Explore All Properties</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <!-- Curated Live Properties Preview -->
            <?php if (!empty($featuredProps)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($featuredProps as $fp): 
                        $fpImg = $getImgSrc($fp['featured_image'] ?? null, '/assets/images/areas/vasant-vihar.jpg');
                        $fpPrice = !empty($fp['price_display']) ? $fp['price_display'] : ('₹ ' . number_format((float)$fp['price'] / 10000000, 2) . ' Cr');
                        $fpAreaName = $fp['area_name'] ?? 'South Delhi';
                        $fpUrl = $baseUrl . '/properties/' . Format::e($fp['slug']);
                        $fpWaText = urlencode("Hello Elite Homez, I am interested in exploring " . $fp['title'] . " in " . $fpAreaName . " (" . $fpPrice . "). Reference: " . ($fp['reference_number'] ?? 'Direct'));
                    ?>
                        <article class="group bg-white rounded-2xl overflow-hidden border border-[#D8CDBA]/50 shadow-md hover:shadow-xl transition-all duration-500 flex flex-col justify-between">
                            <div class="relative w-full aspect-[16/10] overflow-hidden bg-[#171A18]">
                                <img 
                                    src="<?= $fpImg ?>" 
                                    alt="<?= Format::e($fp['title']) ?>" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                                    loading="lazy"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/70 via-transparent to-transparent"></div>
                                
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                    <span class="bg-[#171A18]/90 text-[#DFCF9F] font-['Manrope'] text-[0.65rem] uppercase tracking-wider font-semibold px-2.5 py-1 rounded-full border border-[#B99A62]/40">
                                        <?= Format::e($fpAreaName) ?>
                                    </span>
                                    <span class="bg-white/95 text-[#243F34] font-['Manrope'] text-[0.65rem] uppercase tracking-wider font-bold px-2.5 py-1 rounded-full">
                                        <?= strtoupper(Format::e($fp['listing_type'] ?? 'Sale')) ?>
                                    </span>
                                </div>

                                <div class="absolute bottom-3 left-3 right-3 text-white">
                                    <span class="font-['Manrope'] text-xs uppercase tracking-wider text-[#DFCF9F] font-bold block mb-0.5">
                                        Guide Valuation
                                    </span>
                                    <div class="font-['Playfair_Display'] text-xl font-normal text-white">
                                        <?= Format::e($fpPrice) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                                <div class="space-y-2">
                                    <span class="block font-['Manrope'] text-[0.68rem] uppercase tracking-wider text-[#B99A62] font-semibold">
                                        <?= Format::e($fp['property_type'] ?? 'Luxury Residence') ?>
                                    </span>
                                    <h3 class="font-['Playfair_Display'] text-xl font-normal text-[#171A18] group-hover:text-[#B99A62] transition-colors line-clamp-1">
                                        <a href="<?= $fpUrl ?>">
                                            <?= Format::e($fp['title']) ?>
                                        </a>
                                    </h3>
                                    <?php if (!empty($fp['sub_title'])): ?>
                                        <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#5C605D] font-light line-clamp-2">
                                            <?= Format::e($fp['sub_title']) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <!-- Key Metrics -->
                                <div class="pt-3 border-t border-[#D8CDBA]/30 flex items-center justify-between text-xs font-['Manrope'] text-[#4A504B]">
                                    <?php if (!empty($fp['bedrooms'])): ?>
                                        <span><strong><?= (int)$fp['bedrooms'] ?></strong> Suites</span>
                                    <?php endif; ?>
                                    <?php if (!empty($fp['built_up_area'])): ?>
                                        <span><?= Format::e($fp['built_up_area']) ?></span>
                                    <?php endif; ?>
                                    <span class="text-[#243F34] font-semibold">Clean Title</span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="pt-3 border-t border-[#D8CDBA]/30 flex items-center justify-between">
                                    <a href="<?= $fpUrl ?>" 
                                       class="text-xs font-['Manrope'] uppercase tracking-wider font-bold text-[#171A18] hover:text-[#B99A62] transition-colors">
                                        View Details &rarr;
                                    </a>
                                    <a href="https://wa.me/<?= $cleanWa ?>?text=<?= $fpWaText ?>" 
                                       target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#25D366]/10 text-[#128C7E] hover:bg-[#25D366] hover:text-white rounded-md text-xs font-['Manrope'] font-semibold transition-all">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                        <span>WhatsApp</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ============================================================
         SECTION 6: FINAL ARCHITECTURAL CTA
         "Your Ideal Home Starts with the Right Neighbourhood."
         ============================================================ -->
    <section class="relative w-full bg-[#171A18] text-white py-24 lg:py-32 px-6 lg:px-16 overflow-hidden">
        <!-- Background Architectural Scrim -->
        <div class="absolute inset-0">
            <img 
                src="<?= $baseUrl ?>/assets/images/stitch/jor-bagh-bungalow.jpg" 
                alt="Elite Homez South Delhi Enclave Consultation" 
                class="w-full h-full object-cover scale-105"
                loading="lazy"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-[#171A18]/95 via-[#243F34]/90 to-[#171A18]/85"></div>
        </div>

        <div class="relative max-w-4xl mx-auto text-center space-y-8 z-10">
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full border border-[#B99A62]/40 text-[#DFCF9F] font-['Manrope'] text-xs uppercase tracking-[0.22em] font-semibold">
                <span class="w-2 h-2 rounded-full bg-[#B99A62] animate-pulse"></span>
                <span>Bespoke Territory Advisory</span>
            </div>

            <h2 class="font-['Playfair_Display'] text-4xl sm:text-5xl lg:text-6xl font-normal text-white leading-[1.12]">
                Your Ideal Home Starts with the <br />
                <span class="italic text-[#DFCF9F]">Right Neighbourhood.</span>
            </h2>

            <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg text-gray-200 font-light leading-relaxed max-w-2xl mx-auto">
                Whether you are seeking a generational family estate in Golf Links, a diplomatic residence in Chanakyapuri, or an off-market penthouse in Vasant Vihar, our senior partners coordinate confidential viewings under bilateral NDA covenants.
            </p>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <a href="<?= $baseUrl ?>/contact-us" 
                   class="px-8 py-4 bg-[#B99A62] hover:bg-[#A88B53] text-[#171A18] font-['Manrope'] text-xs font-bold uppercase tracking-[0.2em] rounded-lg transition-all duration-300 shadow-xl hover:shadow-[#B99A62]/20">
                    Speak to Our Team
                </a>
                <a href="https://wa.me/<?= $cleanWa ?>?text=<?= urlencode('Hello Elite Homez, I would like to consult with an advisor regarding South Delhi neighbourhood opportunities.') ?>" 
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2.5 px-7 py-4 bg-white/10 hover:bg-white/20 text-white font-['Manrope'] text-xs font-semibold uppercase tracking-[0.18em] rounded-lg border border-white/20 backdrop-blur-md transition-all">
                    <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>Direct WhatsApp Concierge</span>
                </a>
            </div>

            <!-- Discretion Subtext -->
            <div class="pt-4 text-xs font-['Manrope'] uppercase tracking-[0.2em] text-[#DFCF9F]/70">
                <span>✦ All advisory mandates conducted under strict bilateral non-disclosure agreements</span>
            </div>
        </div>
    </section>

</div>
