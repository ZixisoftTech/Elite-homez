<?php
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$settings = $siteSettings ?? [];
$phone = $settings['phone_primary'] ?? '+91 (011) 4100 8800';
$phoneClean = preg_replace('/[^0-9\+]/', '', $phone);
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$waClean = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($waClean) === 10) {
    $waClean = '91' . $waClean;
}
$rera = $settings['rera_number'] ?? 'DLRERA2023A00892';

$currentTab = $currentTab ?? 'all';
$currentArea = $currentArea ?? '';
$currentCategory = $currentCategory ?? '';
$currentSearch = $currentSearch ?? '';
$currentPrice = $currentPrice ?? '';
$currentSort = $currentSort ?? 'featured';
$counts = $counts ?? ['all' => 0, 'sale' => 0, 'rent' => 0];
$showcase = $showcaseProperty ?? null;
$items = $gridProperties ?? [];
$allAreas = $areas ?? [];
$hasActiveFilter = $hasActiveFilter ?? false;
?>

<div class="flex flex-col w-full bg-[#FAF8F4] text-[#171A18] overflow-hidden">

    <!-- ============================================================
         SECTION 1: EDITORIAL PROPERTY HERO (CINEMATIC INTRODUCTION)
         ============================================================ -->
    <section class="relative w-full bg-[#171A18] text-white pt-28 pb-16 lg:pt-36 lg:pb-24 px-6 lg:px-16 overflow-hidden">
        <!-- Background Architectural Scrim -->
        <div class="absolute inset-0">
            <img 
                src="<?= $baseUrl ?>/assets/images/stitch/golf-links-pool-villa.jpg" 
                alt="Elite Homez Luxury Property Collection South Delhi" 
                class="w-full h-full object-cover scale-105 transition-transform duration-1000"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-[#171A18]/95 via-[#243F34]/85 to-[#171A18]/65"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#171A18] via-transparent to-black/30"></div>
        </div>

        <div class="relative max-w-[1440px] mx-auto z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-end">
                <!-- 55% Editorial Narrative Column -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-[#B99A62]/40 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-[#B99A62] animate-pulse"></span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#DFCF9F] font-semibold">Elite Homez · Curated Property Collection</span>
                    </div>

                    <h1 class="font-['Playfair_Display'] text-4xl sm:text-5xl lg:text-[4.25rem] text-white font-normal leading-[1.08] tracking-tight">
                        Exceptional Properties. <br />
                        <span class="italic text-[#DFCF9F]">Extraordinary Possibilities.</span>
                    </h1>

                    <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg lg:text-xl text-gray-200 font-light leading-relaxed max-w-xl">
                        Explore carefully presented residential properties across some of South Delhi's most prestigious neighbourhoods. Every estate undergoes strict architectural, legal, and privacy due diligence.
                    </p>

                    <!-- Metric Micro-Strip -->
                    <div class="pt-2 grid grid-cols-3 gap-4 max-w-lg bg-white/5 border border-white/10 p-4 rounded-xl backdrop-blur-sm">
                        <div>
                            <div class="text-xl sm:text-2xl font-normal text-white font-['Playfair_Display']">₹1,200 Cr+</div>
                            <div class="text-[0.625rem] text-[#DFCF9F] tracking-widest uppercase mt-0.5 font-['Manrope'] font-semibold">Asset Volume</div>
                        </div>
                        <div class="border-l border-white/15 pl-4">
                            <div class="text-xl sm:text-2xl font-normal text-white font-['Playfair_Display']">100%</div>
                            <div class="text-[0.625rem] text-[#DFCF9F] tracking-widest uppercase mt-0.5 font-['Manrope'] font-semibold">Clean Title</div>
                        </div>
                        <div class="border-l border-white/15 pl-4">
                            <div class="text-xl sm:text-2xl font-normal text-white font-['Playfair_Display']"><?= (int) ($counts['all'] ?? 16) ?></div>
                            <div class="text-[0.625rem] text-[#DFCF9F] tracking-widest uppercase mt-0.5 font-['Manrope'] font-semibold">Curated Residences</div>
                        </div>
                    </div>
                </div>

                <!-- 45% Hero Floating Feature Dossier Card -->
                <div class="lg:col-span-5">
                    <div class="bg-[#243F34]/90 backdrop-blur-xl p-8 rounded-2xl border border-[#B99A62]/35 shadow-2xl space-y-6">
                        <div class="flex items-center justify-between pb-4 border-b border-white/10">
                            <div>
                                <span class="font-['Manrope'] text-[0.65rem] uppercase tracking-[0.25em] text-[#DFCF9F] block font-semibold">Private Advisory Protocol</span>
                                <h3 class="font-['Playfair_Display'] text-xl text-white font-medium">Bespoke Client Representation</h3>
                            </div>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#B99A62]/20 border border-[#B99A62]/40 text-[#DFCF9F]">
                                ✦
                            </span>
                        </div>
                        <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                            Looking for off-market Lutyens or South Delhi residences not broadcast publicly? Our senior advisory principals coordinate confidential viewings under bilateral NDA covenants.
                        </p>
                        <div class="pt-1 flex items-center justify-between">
                            <a href="#portfolio-grid" class="inline-flex items-center gap-2 font-['Manrope'] text-xs uppercase tracking-[0.18em] text-[#DFCF9F] hover:text-white font-bold transition-colors">
                                <span>Explore Portfolio</span>
                                <span>&darr;</span>
                            </a>
                            <span class="text-xs text-gray-400 font-mono font-medium">RERA <?= Format::e($rera) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-[1px] bg-gradient-to-r from-transparent via-[#B99A62]/50 to-transparent"></div>
    </section>


    <!-- ============================================================
         SECTION 2: PROPERTY LISTING GRID (STREAMLINED PORTFOLIO)
         ============================================================ -->
    <section id="portfolio-grid" class="w-full max-w-[1440px] mx-auto px-6 lg:px-16 py-16 lg:py-24">
        <!-- Results Bar with Minimalist Transaction Filter Tabs -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-[#E0D7C9]/60 mb-10">
            <div>
                <span class="text-xs uppercase tracking-[0.2em] text-[#B99A62] font-['Manrope'] font-semibold block mb-1">The Capital Portfolio</span>
                <h2 class="text-2xl sm:text-3xl text-[#243F34] font-normal font-['Playfair_Display']">
                    Showing <?= count($items) ?> Curated Residences
                </h2>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 sm:gap-6">
                <!-- Dropdown Selector for Rent & Sale -->
                <div class="relative">
                    <select onchange="window.location.href=this.value" class="appearance-none bg-white border border-[#E0D7C9] text-[#243F34] font-['Manrope'] text-xs uppercase tracking-wider font-semibold py-2 pl-3.5 pr-8 rounded-lg shadow-sm focus:outline-none focus:border-[#B99A62] cursor-pointer hover:border-[#B99A62] transition-colors">
                        <option value="<?= $baseUrl ?>/properties?type=all" <?= $currentTab === 'all' ? 'selected' : '' ?>>All Properties (<?= sprintf('%02d', $counts['all']) ?>)</option>
                        <option value="<?= $baseUrl ?>/properties?type=sale" <?= $currentTab === 'sale' ? 'selected' : '' ?>>Properties For Sale (<?= sprintf('%02d', $counts['sale']) ?>)</option>
                        <option value="<?= $baseUrl ?>/properties?type=rent" <?= $currentTab === 'rent' ? 'selected' : '' ?>>Properties For Rent (<?= sprintf('%02d', $counts['rent']) ?>)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[#8C7343]">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Sleek Minimalist Tabs: All / For Sale / For Rent -->
                <div class="hidden sm:flex items-center gap-4 sm:gap-6 font-['Manrope'] text-xs uppercase tracking-wider font-semibold">
                    <a href="<?= $baseUrl ?>/properties?type=all" 
                       class="relative pb-1 transition-colors <?= $currentTab === 'all' ? 'text-[#243F34] font-bold' : 'text-[#5C605D] hover:text-[#243F34]' ?>">
                        All (<?= sprintf('%02d', $counts['all']) ?>)
                        <?php if ($currentTab === 'all'): ?>
                            <span class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#B99A62]"></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?= $baseUrl ?>/properties?type=sale" 
                       class="relative pb-1 transition-colors <?= $currentTab === 'sale' ? 'text-[#243F34] font-bold' : 'text-[#5C605D] hover:text-[#243F34]' ?>">
                        For Sale (<?= sprintf('%02d', $counts['sale']) ?>)
                        <?php if ($currentTab === 'sale'): ?>
                            <span class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#B99A62]"></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?= $baseUrl ?>/properties?type=rent" 
                       class="relative pb-1 transition-colors <?= $currentTab === 'rent' ? 'text-[#243F34] font-bold' : 'text-[#5C605D] hover:text-[#243F34]' ?>">
                        For Rent (<?= sprintf('%02d', $counts['rent']) ?>)
                        <?php if ($currentTab === 'rent'): ?>
                            <span class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#B99A62]"></span>
                        <?php endif; ?>
                    </a>
                </div>

                <?php if ($hasActiveFilter): ?>
                    <a href="<?= $baseUrl ?>/properties" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[#243F34] hover:bg-[#243F34] hover:text-white border border-[#E0D7C9] text-xs font-['Manrope'] font-semibold transition-colors shadow-sm">
                        <span>Clear Filters</span>
                        <span>&times;</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($items)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10 items-stretch">
                <?php foreach ($items as $idx => $prop): 
                    $pImg = !empty($prop['featured_image']) ? $prop['featured_image'] : '/assets/images/stitch/hero-residence.jpg';
                    $pImgSrc = str_starts_with($pImg, 'http') ? $pImg : $baseUrl . $pImg;
                    $pUrl = $baseUrl . '/properties/' . Format::e($prop['slug']);
                    $statusLabel = $prop['listing_type'] === 'rent' ? 'For Rent · Diplomatic Lease' : 'For Sale · Prime Mandate';
                    $pWaText = urlencode("Hello Elite Homez, I am interested in {$prop['title']} ({$prop['price_display']}) in {$prop['area_name']}. Mandate Ref: {$prop['mandate_ref']}");
                ?>
                    <article class="bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col group border border-[#E0D7C9] overflow-hidden">
                        <!-- Image Container with 16:10 Aspect Ratio -->
                        <div class="relative overflow-hidden aspect-[16/10] bg-[#EAE3D7]">
                            <img 
                                src="<?= $pImgSrc ?>" 
                                alt="<?= Format::e($prop['title']) ?>" 
                                class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/70 via-transparent to-transparent pointer-events-none"></div>

                            <!-- Top Badges -->
                            <div class="absolute top-4 left-4 right-4 flex items-center justify-between">
                                <span class="bg-[#243F34]/95 text-white text-[0.625rem] tracking-[0.2em] uppercase px-3 py-1 rounded-full font-['Manrope'] font-semibold shadow-sm border border-[#B99A62]/30">
                                    <?= $statusLabel ?>
                                </span>
                                <?php if ((int)$prop['is_featured']): ?>
                                    <span class="bg-[#B99A62] text-[#171A18] text-[0.625rem] tracking-wider uppercase px-2.5 py-1 rounded-full font-['Manrope'] font-bold shadow-sm">
                                        Featured
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Floating Price Tag -->
                            <div class="absolute bottom-4 right-4 bg-[#171A18]/90 backdrop-blur-sm text-white text-base font-normal px-4 py-1.5 rounded-lg shadow border border-[#B99A62]/30 font-['Playfair_Display']">
                                <?= Format::e($prop['price_display']) ?>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 sm:p-7 flex flex-col justify-between space-y-6 flex-1 bg-[#FAF8F4]">
                            <div class="space-y-2">
                                <span class="text-[0.6875rem] tracking-widest text-[#8C7343] uppercase font-['Manrope'] font-semibold block">
                                    <?= Format::e($prop['area_name'] ?? 'South Delhi') ?> · <?= Format::e($prop['property_type']) ?>
                                </span>
                                <h4 class="text-xl sm:text-2xl text-[#243F34] font-normal leading-snug font-['Playfair_Display'] group-hover:text-[#B99A62] transition-colors">
                                    <a href="<?= $pUrl ?>"><?= Format::e($prop['title']) ?></a>
                                </h4>
                                <p class="text-xs text-[#5C605D] font-['Plus_Jakarta_Sans'] line-clamp-2 leading-relaxed">
                                    <?= Format::e(substr(strip_tags($prop['description']), 0, 130)) ?>...
                                </p>
                            </div>

                            <!-- Key Specs Strip -->
                            <div class="bg-white p-3.5 rounded-xl flex items-center justify-between text-[#171A18] border border-[#E0D7C9] text-center">
                                <div class="flex-1">
                                    <span class="block text-[0.5625rem] uppercase tracking-wider text-[#5C605D] font-['Manrope'] font-semibold">Suites</span>
                                    <span class="text-sm font-semibold text-[#243F34] font-['Plus_Jakarta_Sans']"><?= (int) $prop['bedrooms'] ?> Bed</span>
                                </div>
                                <div class="h-6 w-[1px] bg-[#E0D7C9]"></div>
                                <div class="flex-1">
                                    <span class="block text-[0.5625rem] uppercase tracking-wider text-[#5C605D] font-['Manrope'] font-semibold">Area</span>
                                    <span class="text-sm font-semibold text-[#243F34] font-['Plus_Jakarta_Sans']"><?= Format::e($prop['property_size']) ?></span>
                                </div>
                                <div class="h-6 w-[1px] bg-[#E0D7C9]"></div>
                                <div class="flex-1">
                                    <span class="block text-[0.5625rem] uppercase tracking-wider text-[#5C605D] font-['Manrope'] font-semibold">Title</span>
                                    <span class="text-sm font-semibold text-[#243F34] font-['Plus_Jakarta_Sans']">Verified</span>
                                </div>
                            </div>

                            <!-- Card Bottom Action Strip -->
                            <div class="pt-2 flex items-center justify-between border-t border-[#E0D7C9]">
                                <a href="<?= $pUrl ?>" class="inline-flex items-center gap-1.5 text-[#243F34] hover:text-[#B99A62] text-xs uppercase tracking-[0.18em] font-['Manrope'] font-bold transition-colors">
                                    <span>View Residence</span>
                                    <span>&rarr;</span>
                                </a>

                                <a href="https://wa.me/<?= $waClean ?>?text=<?= $pWaText ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs text-[#243F34] hover:text-[#25D366] font-['Manrope'] font-semibold transition-colors" title="WhatsApp Enquiry">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" class="text-[#25D366]">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                    </svg>
                                    <span>Enquire</span>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Polished Empty State -->
            <div class="text-center py-20 px-8 rounded-3xl bg-[#F5F1E8] border border-[#E0D7C9] max-w-2xl mx-auto space-y-6">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white border border-[#B99A62]/30 text-[#B99A62] text-2xl font-serif">
                    ✦
                </div>
                <div class="space-y-2">
                    <h4 class="text-2xl text-[#243F34] font-normal font-['Playfair_Display']">
                        No Public Listings Match Your Criteria
                    </h4>
                    <p class="text-sm text-[#4A504B] font-['Plus_Jakarta_Sans'] leading-relaxed">
                        Much of our most prestigious South Delhi residential portfolio is held under confidential family-office mandates and is never published online.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                    <a href="<?= $baseUrl ?>/properties" class="px-6 py-3 rounded-full bg-[#243F34] text-white text-xs font-['Manrope'] uppercase tracking-widest font-semibold hover:bg-[#1B3128] transition-colors shadow">
                        Reset All Filters
                    </a>
                    <a href="<?= $baseUrl ?>/contact-us" class="px-6 py-3 rounded-full bg-white text-[#243F34] border border-[#E0D7C9] text-xs font-['Manrope'] uppercase tracking-widest font-semibold hover:bg-[#FAF8F4] transition-colors shadow-sm">
                        Request Off-Market Dossier
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </section>


    <!-- ============================================================
         SECTION 5: CONFIDENTIAL FAMILY OFFICE & OFF-MARKET DESK
         ============================================================ -->
    <section class="w-full relative overflow-hidden bg-[#243F34] text-white py-20 lg:py-28 px-6 lg:px-16">
        <div class="absolute inset-0 opacity-15 pointer-events-none mix-blend-luminosity">
            <img src="<?= $baseUrl ?>/assets/images/stitch/jor-bagh-bungalow.jpg" alt="" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#243F34] via-[#1B3128] to-[#243F34]"></div>

        <div class="relative max-w-[1440px] mx-auto z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-8 space-y-6">
                    <div class="inline-flex items-center gap-2 text-[#DFCF9F] text-xs uppercase tracking-[0.25em] font-['Manrope'] font-semibold">
                        <span>✦</span> Confidential Family Office Desk
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl text-white font-normal leading-tight font-['Playfair_Display']">
                        Looking for something <br />
                        <span class="italic text-[#DFCF9F]">truly extraordinary?</span>
                    </h2>
                    <p class="text-base text-gray-300 font-['Plus_Jakarta_Sans'] font-light leading-relaxed max-w-xl">
                        Over 70% of our ultra-luxury transactions execute completely off-market under bilateral non-disclosure agreements. Tell our Senior Advisory Partners what matters to you, and we will unlock private family trust inventories.
                    </p>
                    <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                        <a href="<?= $baseUrl ?>/contact-us" class="inline-flex items-center justify-center bg-gradient-to-r from-[#B99A62] to-[#8C7343] hover:from-[#C9A86A] hover:to-[#B99A62] text-[#171A18] px-8 py-4 rounded-full font-['Manrope'] text-xs uppercase tracking-[0.18em] font-bold shadow-lg transition-all duration-300">
                            <span>Initiate Private Mandate</span>
                            <span class="ml-2">&rarr;</span>
                        </a>
                        <a href="https://wa.me/<?= $waClean ?>?text=<?= urlencode('Hello Elite Homez Senior Partner, I would like to inquire regarding off-market luxury residences.') ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white px-7 py-4 rounded-full font-['Manrope'] text-xs uppercase tracking-[0.16em] font-semibold backdrop-blur-md border border-white/20 transition-all duration-300">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-[#DFCF9F]">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>WhatsApp Advisor</span>
                        </a>
                    </div>
                </div>

                <!-- Discretion Protocol Card -->
                <div class="lg:col-span-4 bg-[#1B3128]/90 p-8 rounded-2xl border border-[#B99A62]/35 shadow-2xl space-y-5">
                    <div class="space-y-1">
                        <span class="text-[0.625rem] text-[#DFCF9F] tracking-widest uppercase block font-['Manrope'] font-semibold">Direct Advisory Line</span>
                        <div class="text-2xl text-white font-medium font-['Playfair_Display']"><?= Format::e($phone) ?></div>
                        <p class="text-xs text-gray-400 font-['Plus_Jakarta_Sans']">Mon – Sat · 9:30 AM to 7:00 PM IST</p>
                    </div>
                    <div class="h-[1px] bg-white/10"></div>
                    <div class="space-y-3 font-['Plus_Jakarta_Sans'] text-xs text-gray-300">
                        <div class="flex items-start gap-2.5">
                            <span class="text-[#DFCF9F]">✓</span>
                            <span>Bilateral Non-Disclosure Agreement executed prior to viewing off-market coordinates.</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="text-[#DFCF9F]">✓</span>
                            <span>Partner-escorted private viewings arranged around diplomatic and executive schedules.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
