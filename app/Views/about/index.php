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

$areas = $areas ?? [];
$testimonials = $testimonials ?? [];
$about = $about ?? [];

// Helper for image URLs
$getImageUrl = function (?string $path, string $fallback) use ($baseUrl): string {
    if (empty($path)) {
        return str_starts_with($fallback, 'http') ? $fallback : $baseUrl . '/' . ltrim($fallback, '/');
    }
    return str_starts_with($path, 'http') ? $path : $baseUrl . '/' . ltrim($path, '/');
};

$heroImg = $getImageUrl($about['about_hero_image'] ?? null, '/assets/images/stitch/about-flagship-architecture.jpg');
$storyImgPrimary = $getImageUrl($about['about_story_image_primary'] ?? null, '/assets/images/about/about-living-room.jpg');
$storyImgSecondary = $getImageUrl($about['about_story_image_secondary'] ?? null, '/assets/images/stitch/about-interior.jpg');
$philosophyImg = $getImageUrl($about['about_philosophy_image'] ?? null, '/assets/images/stitch/about-cinematic-pause.jpg');
$directorImg = $getImageUrl($about['about_director_image'] ?? null, '/assets/images/about/director.jpg');
$ctaImg = $getImageUrl($about['about_cta_image'] ?? null, '/assets/images/stitch/service-cta-dusk.jpg');
?>

<div class="flex flex-col w-full bg-[#FAF8F4] text-[#171A18] overflow-hidden">

    <!-- ============================================================
         SECTION 1: PREMIUM ABOUT HERO (CINEMATIC EDITORIAL HERO)
         ============================================================ -->
    <section class="relative w-full min-h-[85vh] lg:min-h-[90vh] flex items-center bg-[#171A18] text-white overflow-hidden">
        <!-- Background Architectural Image with Luxury Overlays -->
        <div class="absolute inset-0">
            <img 
                src="<?= $heroImg ?>" 
                alt="Elite Homez Flagship Luxury Architectural Residence in South Delhi" 
                class="w-full h-full object-cover object-center scale-105 transition-transform duration-1000 ease-out"
                loading="eager"
            />
            <!-- Multi-layer Gradient: Forest Green Authority & Charcoal Depth -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#171A18]/95 via-[#243F34]/80 to-[#171A18]/60"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#171A18] via-transparent to-black/30"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(185,154,98,0.15),transparent_60%)]"></div>
        </div>

        <div class="relative w-full max-w-[1440px] mx-auto px-6 lg:px-16 pt-32 pb-20 lg:pt-36 lg:pb-28 z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-end">
                <div class="lg:col-span-8 space-y-6">
                    <!-- Refined Eyebrow Badge -->
                    <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-[#B99A62]/40 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-[#B99A62] animate-pulse"></span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#DFCF9F] font-semibold"><?= Format::e($about['about_hero_badge'] ?? 'Get to Know Elite Homez') ?></span>
                    </div>

                    <!-- Main Editorial Heading -->
                    <h1 class="font-['Playfair_Display'] text-4xl sm:text-6xl lg:text-[4.75rem] text-white font-normal leading-[1.08] tracking-tight">
                        <?= Format::e($about['about_hero_title'] ?? 'Where Exceptional Homes') ?> <br class="hidden sm:inline" />
                        <span class="italic text-[#DFCF9F] font-normal" style="font-family: 'Playfair Display', serif;"><?= Format::e($about['about_hero_title_italic'] ?? 'Meet Exceptional Experiences.') ?></span>
                    </h1>

                    <!-- Supporting Description -->
                    <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg lg:text-xl text-gray-200 font-light leading-relaxed max-w-2xl">
                        <?= nl2br(Format::e($about['about_hero_desc'] ?? 'At Elite Homez, we believe finding the right property is about more than just an address. It is about discovering a lifestyle, making confident decisions and experiencing real estate with trust, expertise and personal attention.')) ?>
                    </p>

                    <!-- Interactive CTAs -->
                    <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                        <a href="<?= Format::e(!empty($about['about_hero_btn1_link']) ? $about['about_hero_btn1_link'] : '#our-story') ?>" class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-[#B99A62] to-[#8C7343] hover:from-[#C9A86A] hover:to-[#B99A62] text-[#171A18] px-8 py-4 rounded-full font-['Manrope'] text-xs uppercase tracking-[0.18em] font-bold shadow-lg hover:shadow-2xl transition-all duration-300">
                            <span><?= Format::e($about['about_hero_btn1_text'] ?? 'Explore Our Approach') ?></span>
                            <span class="text-base">&darr;</span>
                        </a>

                        <?php 
                        $heroWaUrl = !empty($about['about_hero_btn2_link']) 
                            ? $about['about_hero_btn2_link'] 
                            : 'https://wa.me/' . $waClean . '?text=' . urlencode('Hello Elite Homez, I would like to schedule a private advisory conversation.');
                        ?>
                        <a href="<?= Format::e($heroWaUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2.5 bg-white/10 hover:bg-white/20 text-white px-7 py-4 rounded-full font-['Manrope'] text-xs uppercase tracking-[0.16em] font-semibold backdrop-blur-md border border-white/20 transition-all duration-300">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="text-[#DFCF9F]">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span><?= Format::e($about['about_hero_btn2_text'] ?? 'WhatsApp Senior Advisor') ?></span>
                        </a>
                    </div>
                </div>

                <!-- Floating Editorial Credibility Card -->
                <div class="lg:col-span-4">
                    <div class="bg-[#243F34]/90 backdrop-blur-xl p-8 rounded-2xl border border-[#B99A62]/35 shadow-2xl space-y-6">
                        <div class="flex items-center justify-between pb-4 border-b border-white/10">
                            <div>
                                <span class="font-['Manrope'] text-[0.65rem] uppercase tracking-[0.25em] text-[#DFCF9F] block font-semibold"><?= Format::e($about['about_hero_card_eyebrow'] ?? 'Institutional Heritage') ?></span>
                                <span class="font-['Playfair_Display'] text-2xl text-white font-medium"><?= Format::e($about['about_hero_card_title'] ?? 'South Delhi Advisory') ?></span>
                            </div>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#B99A62]/20 border border-[#B99A62]/40 text-[#DFCF9F]">
                                ✦
                            </span>
                        </div>
                        <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                            <?= Format::e($about['about_hero_card_desc'] ?? 'Two decades of continuous private representation safeguarding family estates and generational capital across premier diplomatic enclaves.') ?>
                        </p>
                        <div class="pt-2 flex items-center justify-between text-xs font-['Manrope'] uppercase tracking-wider text-gray-300">
                            <span class="flex items-center gap-1.5 text-[#DFCF9F]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#B99A62]"></span>
                                <?= Format::e(str_replace('{rera}', $rera, $about['about_hero_card_tag1'] ?? ('RERA ' . $rera))) ?>
                            </span>
                            <span class="text-gray-400"><?= Format::e($about['about_hero_card_tag2'] ?? 'Est. 2004') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Delicate Gold Accent Hairline -->
        <div class="absolute bottom-0 left-0 right-0 h-[1px] bg-gradient-to-r from-transparent via-[#B99A62]/50 to-transparent"></div>
    </section>


    <!-- ============================================================
         SECTION 2: OUR STORY (ASYMMETRIC EDITORIAL STORYTELLING)
         ============================================================ -->
    <section id="our-story" class="relative w-full bg-[#FAF8F4] py-20 lg:py-32 px-6 lg:px-16 border-b border-[#E0D7C9]/60">
        <div class="max-w-[1440px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Left Column: Asymmetric Overlapping Architectural Imagery -->
                <div class="lg:col-span-6 relative">
                    <!-- Primary Large Luxury Architectural Image -->
                    <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl bg-[#EAE3D7] border border-[#E0D7C9]">
                        <img 
                            src="<?= $storyImgPrimary ?>" 
                            alt="Elite Homez Luxury Living Room Interior" 
                            class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/40 via-transparent to-transparent pointer-events-none"></div>
                    </div>

                    <!-- Secondary Overlapping Architectural Detail Image -->
                    <div class="absolute -bottom-8 -right-4 sm:-bottom-10 sm:-right-8 w-1/2 sm:w-5/12 aspect-[4/3] rounded-xl overflow-hidden shadow-2xl border-4 border-[#FAF8F4] bg-[#243F34] hidden sm:block">
                        <img 
                            src="<?= $storyImgSecondary ?>" 
                            alt="Architectural Materiality and Lighting Detail" 
                            class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                            loading="lazy"
                        />
                    </div>

                    <!-- Floating Experience Badge -->
                    <div class="absolute -top-6 -left-4 sm:-top-8 sm:-left-6 bg-[#243F34] text-white p-5 rounded-xl shadow-xl border border-[#B99A62]/30 flex items-center gap-3">
                        <span class="font-['Playfair_Display'] text-3xl font-normal text-[#DFCF9F]"><?= Format::e($about['about_story_badge_number'] ?? '20+') ?></span>
                        <div class="flex flex-col">
                            <span class="font-['Manrope'] text-[0.625rem] uppercase tracking-[0.2em] text-[#DFCF9F] font-bold"><?= Format::e($about['about_story_badge_text1'] ?? 'Years of') ?></span>
                            <span class="font-['Plus_Jakarta_Sans'] text-xs uppercase tracking-wider text-white font-medium"><?= Format::e($about['about_story_badge_text2'] ?? 'Bespoke Advisory') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Editorial Narrative & Covenant -->
                <div class="lg:col-span-6 space-y-8 lg:pl-4">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                            <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#B99A62] font-semibold"><?= Format::e($about['about_story_eyebrow'] ?? 'Our Story') ?></span>
                        </div>
                        <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl text-[#243F34] font-normal leading-[1.12]">
                            <?= Format::e($about['about_story_title'] ?? 'A Journey Built Around') ?> <br />
                            <span class="italic text-[#B99A62]"><?= Format::e($about['about_story_title_italic'] ?? 'Exceptional Real Estate.') ?></span>
                        </h2>
                    </div>

                    <!-- Mandated Content Paragraphs -->
                    <div class="space-y-5 font-['Plus_Jakarta_Sans'] text-base sm:text-lg text-[#4A504B] font-light leading-relaxed">
                        <p>
                            <?= nl2br(Format::e($about['about_story_p1'] ?? 'Elite Homez is dedicated to bringing a more thoughtful and personalised approach to luxury real estate. We understand that every property represents an aspiration, an investment and an important life decision.')) ?>
                        </p>
                        <p>
                            <?= nl2br(Format::e($about['about_story_p2'] ?? 'Our approach combines market understanding, professional guidance and personal attention to help clients explore exceptional residential opportunities across South Delhi.')) ?>
                        </p>
                    </div>

                    <!-- The Covenant Quotation Card -->
                    <div class="p-6 sm:p-8 rounded-xl bg-[#F5F1E8] border-l-4 border-[#B99A62] shadow-sm space-y-3">
                        <span class="font-['Manrope'] text-[0.6875rem] uppercase tracking-[0.2em] text-[#8C7343] font-bold block"><?= Format::e($about['about_story_covenant_eyebrow'] ?? 'The Elite Homez Covenant') ?></span>
                        <blockquote class="font-['Playfair_Display'] text-lg sm:text-xl text-[#243F34] italic font-normal leading-relaxed">
                            "<?= Format::e(trim($about['about_story_covenant_quote'] ?? 'Your trust, our responsibility. Not merely an operational motto, but an absolute fiduciary anchor protecting generational legacy.', '"')) ?>"
                        </blockquote>
                    </div>

                    <div class="pt-2 flex flex-wrap items-center gap-6 text-xs font-['Manrope'] uppercase tracking-wider text-[#5C605D]">
                        <span class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#B99A62]"></span>
                            <?= Format::e($about['about_story_highlight_1'] ?? 'South Delhi Specialisation') ?>
                        </span>
                        <span class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#B99A62]"></span>
                            <?= Format::e($about['about_story_highlight_2'] ?? 'Bespoke Client Portfolios') ?>
                        </span>
                        <span class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#B99A62]"></span>
                            <?= Format::e($about['about_story_highlight_3'] ?? 'Discreet Representation') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================================
         SECTION 3: EXPERIENCE & EXPERTISE (DEEP FOREST GREEN STATISTICS)
         ============================================================ -->
    <section class="relative w-full bg-[#243F34] text-white py-20 lg:py-28 px-6 lg:px-16 overflow-hidden">
        <!-- Background Architectural Scrim -->
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <img src="<?= $baseUrl ?>/assets/images/stitch/jor-bagh-bungalow.jpg" alt="" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#243F34] via-[#1B3128] to-[#243F34]"></div>

        <div class="relative max-w-[1440px] mx-auto z-10">
            <!-- Section Header -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-16 pb-8 border-b border-white/10">
                <div class="space-y-3 max-w-2xl">
                    <span class="font-['Manrope'] text-xs uppercase tracking-[0.25em] text-[#DFCF9F] font-semibold block"><?= Format::e($about['about_stats_eyebrow'] ?? 'Experience & Expertise') ?></span>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl text-white font-normal leading-tight">
                        <?= Format::e($about['about_stats_title'] ?? 'Two Decades of Dedicated Advisory') ?>
                    </h2>
                </div>
                <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-gray-300 font-light max-w-md leading-relaxed">
                    <?= Format::e($about['about_stats_desc'] ?? "Built upon intimate knowledge of South Delhi's premier residential enclaves, sustained client relationships, and uncompromised title scrutiny.") ?>
                </p>
            </div>

            <!-- Authentic Verified Statistics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
                <!-- Stat 1 -->
                <div class="space-y-3 p-6 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="font-['Playfair_Display'] text-5xl sm:text-6xl lg:text-7xl text-[#DFCF9F] font-normal leading-none tracking-tight">
                        <?= Format::e($about['about_stat_1_num'] ?? '20+') ?>
                    </div>
                    <div class="h-[2px] w-12 bg-[#B99A62]"></div>
                    <h3 class="font-['Playfair_Display'] text-lg text-white font-medium"><?= Format::e($about['about_stat_1_title'] ?? 'Years of Experience') ?></h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-xs text-gray-300 font-light leading-relaxed">
                        <?= Format::e($about['about_stat_1_desc'] ?? "Continuous active advisory across South Delhi's most prestigious neighbourhoods.") ?>
                    </p>
                </div>

                <!-- Stat 2 -->
                <div class="space-y-3 p-6 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="font-['Playfair_Display'] text-5xl sm:text-6xl lg:text-7xl text-[#DFCF9F] font-normal leading-none tracking-tight">
                        <?= Format::e($about['about_stat_2_num'] ?? '10') ?>
                    </div>
                    <div class="h-[2px] w-12 bg-[#B99A62]"></div>
                    <h3 class="font-['Playfair_Display'] text-lg text-white font-medium"><?= Format::e($about['about_stat_2_title'] ?? 'Prime Enclaves Mastered') ?></h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-xs text-gray-300 font-light leading-relaxed">
                        <?= Format::e($about['about_stat_2_desc'] ?? 'Granular street-level understanding from Vasant Vihar to Golf Links and Chanakyapuri.') ?>
                    </p>
                </div>

                <!-- Stat 3 -->
                <div class="space-y-3 p-6 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="font-['Playfair_Display'] text-5xl sm:text-6xl lg:text-7xl text-[#DFCF9F] font-normal leading-none tracking-tight">
                        <?= Format::e($about['about_stat_3_num'] ?? '100%') ?>
                    </div>
                    <div class="h-[2px] w-12 bg-[#B99A62]"></div>
                    <h3 class="font-['Playfair_Display'] text-lg text-white font-medium"><?= Format::e($about['about_stat_3_title'] ?? 'Verified Clean Titles') ?></h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-xs text-gray-300 font-light leading-relaxed">
                        <?= Format::e($about['about_stat_3_desc'] ?? 'Rigorous statutory legal checks and complete chain-of-title verification before screening.') ?>
                    </p>
                </div>

                <!-- Stat 4 -->
                <div class="space-y-3 p-6 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="font-['Playfair_Display'] text-5xl sm:text-6xl lg:text-7xl text-[#DFCF9F] font-normal leading-none tracking-tight">
                        <?= Format::e($about['about_stat_4_num'] ?? '1:1') ?>
                    </div>
                    <div class="h-[2px] w-12 bg-[#B99A62]"></div>
                    <h3 class="font-['Playfair_Display'] text-lg text-white font-medium"><?= Format::e($about['about_stat_4_title'] ?? 'Partner-Led Advocacy') ?></h3>
                    <p class="font-['Plus_Jakarta_Sans'] text-xs text-gray-300 font-light leading-relaxed">
                        <?= Format::e($about['about_stat_4_desc'] ?? 'Personal principal attention with zero delegation to junior intermediaries.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================================
         SECTION 4: OUR PHILOSOPHY (LUXURY BRAND MANIFESTO)
         ============================================================ -->
    <section class="relative w-full bg-[#FAF8F4] py-20 lg:py-32 px-6 lg:px-16 border-b border-[#E0D7C9]/60">
        <div class="max-w-[1440px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-center">
                <!-- Left Column: Statement Typography & Manifesto Content -->
                <div class="lg:col-span-6 space-y-8">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                            <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#B99A62] font-semibold"><?= Format::e($about['about_philosophy_eyebrow'] ?? 'Our Philosophy') ?></span>
                        </div>
                        <h2 class="font-['Playfair_Display'] text-3xl sm:text-5xl lg:text-[3.5rem] text-[#243F34] font-normal leading-[1.12]">
                            <?= Format::e($about['about_philosophy_title'] ?? 'Real Estate Is Personal.') ?> <br />
                            <span class="italic text-[#B99A62]" style="font-family: 'Playfair Display', serif;"><?= Format::e($about['about_philosophy_title_italic'] ?? 'So Is Our Approach.') ?></span>
                        </h2>
                    </div>

                    <!-- Mandated Content -->
                    <div class="space-y-6 font-['Plus_Jakarta_Sans'] text-base sm:text-lg text-[#4A504B] font-light leading-relaxed">
                        <p class="text-xl sm:text-2xl text-[#171A18] font-normal leading-snug font-['Playfair_Display'] italic">
                            "<?= Format::e(trim($about['about_philosophy_lead_quote'] ?? 'We believe exceptional real estate experiences begin with understanding people.', '"')) ?>"
                        </p>
                        <p>
                            <?= nl2br(Format::e($about['about_philosophy_desc'] ?? 'Every client has different expectations, preferences and ambitions. Our focus is to understand those needs and provide thoughtful property guidance throughout the journey.')) ?>
                        </p>
                    </div>

                    <!-- Core Tenets Checklist -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-[#E0D7C9]">
                        <div class="p-4 rounded-xl bg-[#F5F1E8] space-y-1">
                            <span class="font-['Manrope'] text-xs uppercase tracking-widest text-[#B99A62] font-bold block"><?= Format::e($about['about_philosophy_tenet1_num'] ?? '01 · Discretion') ?></span>
                            <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#4A504B]"><?= Format::e($about['about_philosophy_tenet1_desc'] ?? 'Protecting client identity and financial privacy at every stage.') ?></p>
                        </div>
                        <div class="p-4 rounded-xl bg-[#F5F1E8] space-y-1">
                            <span class="font-['Manrope'] text-xs uppercase tracking-widest text-[#B99A62] font-bold block"><?= Format::e($about['about_philosophy_tenet2_num'] ?? '02 · Selectivity') ?></span>
                            <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#4A504B]"><?= Format::e($about['about_philosophy_tenet2_desc'] ?? 'Curating only residences of unquestionable architectural and legal integrity.') ?></p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Architectural Photography Pairing -->
                <div class="lg:col-span-6">
                    <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl bg-[#EAE3D7] border border-[#E0D7C9]">
                        <img 
                            src="<?= $philosophyImg ?>" 
                            alt="Elite Homez Luxury Property Atmosphere" 
                            class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/60 via-transparent to-transparent pointer-events-none"></div>
                        <div class="absolute bottom-6 left-6 right-6 p-6 rounded-xl bg-[#FAF8F4]/95 backdrop-blur-md border border-[#B99A62]/30 shadow-lg">
                            <span class="font-['Manrope'] text-[0.65rem] uppercase tracking-[0.2em] text-[#B99A62] font-bold block mb-1"><?= Format::e($about['about_philosophy_card_eyebrow'] ?? 'Brand Thesis') ?></span>
                            <p class="font-['Playfair_Display'] text-base sm:text-lg text-[#243F34] font-medium leading-snug">
                                "<?= Format::e(trim($about['about_philosophy_card_quote'] ?? 'The most meaningful addresses are found through patience, discernment and trusted relationships.', '"')) ?>"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================================
         SECTION 5: WHY CHOOSE ELITE HOMEZ (ASYMMETRIC GRID)
         ============================================================ -->
    <section class="w-full bg-[#F5F1E8] py-20 lg:py-32 px-6 lg:px-16 border-b border-[#E0D7C9]/60">
        <div class="max-w-[1440px] mx-auto">
            <!-- Header -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-16">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#B99A62] font-semibold"><?= Format::e($about['about_why_eyebrow'] ?? 'Distinctive Value') ?></span>
                    </div>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl text-[#243F34] font-normal leading-tight">
                        <?= Format::e($about['about_why_title'] ?? 'Why Choose Elite Homez') ?>
                    </h2>
                </div>
                <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-[#4A504B] font-light max-w-md leading-relaxed">
                    <?= Format::e($about['about_why_desc'] ?? 'Designed for discerning buyers and investors seeking a professional, personal, and relationship-driven property journey.') ?>
                </p>
            </div>

            <!-- Asymmetric Grid of 6 Mandated Value Propositions -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-8 items-stretch">
                <!-- 01. Personalised Guidance (Wide 7 cols) -->
                <div class="md:col-span-7 bg-[#FFFFFF] rounded-2xl p-8 sm:p-10 border border-[#E0D7C9] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-6 group">
                    <div class="flex items-start justify-between">
                        <span class="font-['Playfair_Display'] text-4xl text-[#B99A62] font-normal"><?= Format::e($about['about_why_1_num'] ?? '01') ?></span>
                        <span class="font-['Manrope'] text-[0.6875rem] uppercase tracking-[0.2em] text-[#8C7343] font-bold bg-[#FAF8F4] px-3 py-1 rounded-full border border-[#E0D7C9]"><?= Format::e($about['about_why_1_tag'] ?? 'Advisory Touch') ?></span>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-['Playfair_Display'] text-2xl text-[#243F34] font-normal group-hover:text-[#B99A62] transition-colors">
                            <?= Format::e($about['about_why_1_title'] ?? 'Personalised Guidance') ?>
                        </h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-base text-[#4A504B] font-light leading-relaxed">
                            <?= Format::e($about['about_why_1_desc'] ?? 'Understanding individual preferences and helping clients explore suitable property opportunities tailored to spatial, family, and investment goals.') ?>
                        </p>
                    </div>
                    <div class="h-[1px] w-full bg-[#E0D7C9]/60"></div>
                </div>

                <!-- 02. Luxury Property Focus (5 cols in Deep Forest Green) -->
                <div class="md:col-span-5 bg-[#243F34] text-white rounded-2xl p-8 sm:p-10 border border-[#B99A62]/30 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-6 group">
                    <div class="flex items-start justify-between">
                        <span class="font-['Playfair_Display'] text-4xl text-[#DFCF9F] font-normal"><?= Format::e($about['about_why_2_num'] ?? '02') ?></span>
                        <span class="font-['Manrope'] text-[0.6875rem] uppercase tracking-[0.2em] text-[#DFCF9F] font-bold bg-white/10 px-3 py-1 rounded-full border border-white/20"><?= Format::e($about['about_why_2_tag'] ?? 'Specialisation') ?></span>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-['Playfair_Display'] text-2xl text-white font-normal group-hover:text-[#DFCF9F] transition-colors">
                            <?= Format::e($about['about_why_2_title'] ?? 'Luxury Property Focus') ?>
                        </h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-base text-gray-200 font-light leading-relaxed">
                            <?= Format::e($about['about_why_2_desc'] ?? 'A focused approach to premium residential properties, generational bungalows, and prestigious addresses across the capital.') ?>
                        </p>
                    </div>
                    <div class="h-[1px] w-full bg-white/20"></div>
                </div>

                <!-- 03. Local Market Understanding (5 cols) -->
                <div class="md:col-span-5 bg-[#FFFFFF] rounded-2xl p-8 sm:p-10 border border-[#E0D7C9] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-6 group">
                    <div class="flex items-start justify-between">
                        <span class="font-['Playfair_Display'] text-4xl text-[#B99A62] font-normal"><?= Format::e($about['about_why_3_num'] ?? '03') ?></span>
                        <span class="font-['Manrope'] text-[0.6875rem] uppercase tracking-[0.2em] text-[#8C7343] font-bold bg-[#FAF8F4] px-3 py-1 rounded-full border border-[#E0D7C9]"><?= Format::e($about['about_why_3_tag'] ?? 'Micro-Market') ?></span>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-['Playfair_Display'] text-2xl text-[#243F34] font-normal group-hover:text-[#B99A62] transition-colors">
                            <?= Format::e($about['about_why_3_title'] ?? 'Local Market Understanding') ?>
                        </h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-base text-[#4A504B] font-light leading-relaxed">
                            <?= Format::e($about['about_why_3_desc'] ?? "Deep, nuanced knowledge of South Delhi's premium residential neighbourhoods, road widths, plot scales, and zoning conventions.") ?>
                        </p>
                    </div>
                    <div class="h-[1px] w-full bg-[#E0D7C9]/60"></div>
                </div>

                <!-- 04. Professional Expertise (7 cols) -->
                <div class="md:col-span-7 bg-[#FFFFFF] rounded-2xl p-8 sm:p-10 border border-[#E0D7C9] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-6 group">
                    <div class="flex items-start justify-between">
                        <span class="font-['Playfair_Display'] text-4xl text-[#B99A62] font-normal"><?= Format::e($about['about_why_4_num'] ?? '04') ?></span>
                        <span class="font-['Manrope'] text-[0.6875rem] uppercase tracking-[0.2em] text-[#8C7343] font-bold bg-[#FAF8F4] px-3 py-1 rounded-full border border-[#E0D7C9]"><?= Format::e($about['about_why_4_tag'] ?? 'Competence') ?></span>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-['Playfair_Display'] text-2xl text-[#243F34] font-normal group-hover:text-[#B99A62] transition-colors">
                            <?= Format::e($about['about_why_4_title'] ?? 'Professional Expertise') ?>
                        </h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-base text-[#4A504B] font-light leading-relaxed">
                            <?= Format::e($about['about_why_4_desc'] ?? 'Experience-driven guidance throughout the property discovery process, title diligence, valuation benchmarking, and formal closing.') ?>
                        </p>
                    </div>
                    <div class="h-[1px] w-full bg-[#E0D7C9]/60"></div>
                </div>

                <!-- 05. Transparent Communication (6 cols) -->
                <div class="md:col-span-6 bg-[#FFFFFF] rounded-2xl p-8 sm:p-10 border border-[#E0D7C9] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-6 group">
                    <div class="flex items-start justify-between">
                        <span class="font-['Playfair_Display'] text-4xl text-[#B99A62] font-normal"><?= Format::e($about['about_why_5_num'] ?? '05') ?></span>
                        <span class="font-['Manrope'] text-[0.6875rem] uppercase tracking-[0.2em] text-[#8C7343] font-bold bg-[#FAF8F4] px-3 py-1 rounded-full border border-[#E0D7C9]"><?= Format::e($about['about_why_5_tag'] ?? 'Integrity') ?></span>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-['Playfair_Display'] text-2xl text-[#243F34] font-normal group-hover:text-[#B99A62] transition-colors">
                            <?= Format::e($about['about_why_5_title'] ?? 'Transparent Communication') ?>
                        </h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-base text-[#4A504B] font-light leading-relaxed">
                            <?= Format::e($about['about_why_5_desc'] ?? 'Clear information, unvarnished property assessments, and professional interaction at every stage without speculative exaggeration.') ?>
                        </p>
                    </div>
                    <div class="h-[1px] w-full bg-[#E0D7C9]/60"></div>
                </div>

                <!-- 06. Client-First Approach (6 cols in Dark Charcoal) -->
                <div class="md:col-span-6 bg-[#171A18] text-white rounded-2xl p-8 sm:p-10 border border-[#B99A62]/30 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-6 group">
                    <div class="flex items-start justify-between">
                        <span class="font-['Playfair_Display'] text-4xl text-[#DFCF9F] font-normal"><?= Format::e($about['about_why_6_num'] ?? '06') ?></span>
                        <span class="font-['Manrope'] text-[0.6875rem] uppercase tracking-[0.2em] text-[#DFCF9F] font-bold bg-white/10 px-3 py-1 rounded-full border border-white/20"><?= Format::e($about['about_why_6_tag'] ?? 'Fiduciary Anchor') ?></span>
                    </div>
                    <div class="space-y-3">
                        <h3 class="font-['Playfair_Display'] text-2xl text-white font-normal group-hover:text-[#DFCF9F] transition-colors">
                            <?= Format::e($about['about_why_6_title'] ?? 'Client-First Approach') ?>
                        </h3>
                        <p class="font-['Plus_Jakarta_Sans'] text-base text-gray-300 font-light leading-relaxed">
                            <?= Format::e($about['about_why_6_desc'] ?? 'Building enduring multi-generational relationships through active listening, absolute discretion, and personalised service.') ?>
                        </p>
                    </div>
                    <div class="h-[1px] w-full bg-white/20"></div>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================================
         SECTION 6: OUR AREAS OF EXPERTISE (SOUTH DELHI TERRITORIAL ATLAS)
         ============================================================ -->
    <section class="w-full bg-[#FAF8F4] py-20 lg:py-32 px-6 lg:px-16 border-b border-[#E0D7C9]/60">
        <div class="max-w-[1440px] mx-auto">
            <!-- Header -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-16">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#B99A62] font-semibold"><?= Format::e($about['about_areas_eyebrow'] ?? 'Service Areas') ?></span>
                    </div>
                    <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl text-[#243F34] font-normal leading-tight">
                        <?= Format::e($about['about_areas_title'] ?? 'Exceptional Addresses.') ?> <br />
                        <span class="italic text-[#B99A62]"><?= Format::e($about['about_areas_title_italic'] ?? 'Distinctive Lifestyles.') ?></span>
                    </h2>
                </div>
                <div class="flex flex-col items-start lg:items-end gap-3">
                    <p class="font-['Plus_Jakarta_Sans'] text-sm sm:text-base text-[#4A504B] font-light max-w-md leading-relaxed lg:text-right">
                        <?= Format::e($about['about_areas_desc'] ?? 'Explore the prestigious neighbourhoods where Elite Homez advises clients on premier residences, bungalows, and exclusive builder floors.') ?>
                    </p>
                    <?php 
                    $areasLink = !empty($about['about_areas_btn_link']) 
                        ? (str_starts_with($about['about_areas_btn_link'], 'http') || str_starts_with($about['about_areas_btn_link'], '/') ? $about['about_areas_btn_link'] : $baseUrl . '/' . ltrim($about['about_areas_btn_link'], '/')) 
                        : $baseUrl . '/locations';
                    ?>
                    <a href="<?= Format::e($areasLink) ?>" class="inline-flex items-center gap-2 font-['Manrope'] text-xs uppercase tracking-[0.16em] text-[#243F34] hover:text-[#B99A62] font-bold transition-colors">
                        <span><?= Format::e($about['about_areas_btn_text'] ?? 'View All Enclave Dossiers') ?></span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Dynamic Enclave Grid (STREAMED DYNAMICALLY FROM DATABASE) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <?php 
                $displayAreas = array_slice($areas, 0, 8);
                if (empty($displayAreas)):
                    $displayAreas = [
                        ['name' => 'Vasant Vihar', 'slug' => 'vasant-vihar', 'hero_image' => '/assets/images/areas/vasant-vihar.jpg'],
                        ['name' => 'Jor Bagh', 'slug' => 'jor-bagh', 'hero_image' => '/assets/images/areas/jor-bagh.jpg'],
                        ['name' => 'Golf Links', 'slug' => 'golf-links', 'hero_image' => '/assets/images/areas/golf-links.jpg'],
                        ['name' => 'Chanakyapuri', 'slug' => 'chanakyapuri', 'hero_image' => '/assets/images/areas/chanakyapuri.jpg'],
                        ['name' => 'Panchsheel Park', 'slug' => 'panchsheel-park', 'hero_image' => '/assets/images/areas/panchsheel-park.jpg'],
                        ['name' => 'Shanti Niketan', 'slug' => 'shanti-niketan', 'hero_image' => '/assets/images/areas/shanti-niketan.jpg'],
                        ['name' => 'Anand Niketan', 'slug' => 'anand-niketan', 'hero_image' => '/assets/images/areas/anand-niketan.jpg'],
                        ['name' => 'Westend', 'slug' => 'westend', 'hero_image' => '/assets/images/areas/westend.jpg']
                    ];
                endif;

                foreach ($displayAreas as $idx => $area):
                    $aNum = str_pad((string)($idx + 1), 2, '0', STR_PAD_LEFT);
                    $aImg = !empty($area['hero_image']) ? (str_starts_with($area['hero_image'], 'http') ? $area['hero_image'] : $baseUrl . '/' . ltrim($area['hero_image'], '/')) : $baseUrl . '/assets/images/areas/vasant-vihar.jpg';
                    $aUrl = $baseUrl . '/locations/' . Format::e($area['slug']);
                ?>
                    <article class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 bg-[#171A18] flex flex-col justify-end aspect-[3/4]">
                        <!-- Image Container with Zoom -->
                        <div class="absolute inset-0">
                            <img 
                                src="<?= $aImg ?>" 
                                alt="<?= Format::e($area['name']) ?> Luxury Real Estate" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#171A18] via-[#171A18]/40 to-transparent"></div>
                        </div>

                        <!-- Card Content -->
                        <div class="relative p-6 sm:p-7 space-y-3 z-10">
                            <span class="inline-block font-['Manrope'] text-[0.625rem] uppercase tracking-[0.25em] text-[#DFCF9F] font-bold">
                                Enclave <?= $aNum ?>
                            </span>
                            <h3 class="font-['Playfair_Display'] text-2xl text-white font-normal group-hover:text-[#DFCF9F] transition-colors">
                                <?= Format::e($area['name']) ?>
                            </h3>
                            <a href="<?= $aUrl ?>" class="inline-flex items-center gap-2 font-['Manrope'] text-xs uppercase tracking-[0.16em] text-white/90 group-hover:text-[#DFCF9F] font-semibold transition-colors pt-2">
                                <span>Explore Location</span>
                                <span class="transform group-hover:translate-x-1 transition-transform">&rarr;</span>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- ============================================================
         SECTION 7: DIRECTOR'S MESSAGE (FIDUCIARY LEADERSHIP STATEMENT)
         ============================================================ -->
    <section class="w-full bg-[#F5F1E8] py-20 lg:py-32 px-6 lg:px-16 border-b border-[#E0D7C9]/60">
        <div class="max-w-[1440px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Left: Director Authentic Portrait -->
                <div class="lg:col-span-5 relative">
                    <div class="relative w-full aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl bg-[#EAE3D7] border-2 border-[#E0D7C9]">
                        <img 
                            src="<?= $directorImg ?>" 
                            alt="Elite Homez Director & Senior Advisory Leadership" 
                            class="w-full h-full object-cover object-top transition-transform duration-700 hover:scale-105"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/50 via-transparent to-transparent pointer-events-none"></div>
                    </div>

                    <!-- Floating Fiduciary Badge -->
                    <div class="absolute -bottom-6 -right-4 sm:-bottom-8 sm:-right-6 bg-[#243F34] text-white p-5 rounded-xl shadow-2xl border border-[#B99A62]/35 max-w-[260px] hidden sm:block">
                        <span class="font-['Manrope'] text-[0.625rem] uppercase tracking-[0.2em] text-[#DFCF9F] font-bold block mb-1"><?= Format::e($about['about_director_badge_title'] ?? 'Fiduciary Leadership') ?></span>
                        <p class="font-['Playfair_Display'] text-sm text-white italic leading-snug">
                            "<?= Format::e(trim($about['about_director_badge_quote'] ?? 'Protecting privacy, capital and family legacy across generations.', '"')) ?>"
                        </p>
                    </div>
                </div>

                <!-- Right: Editorial Message Body -->
                <div class="lg:col-span-7 space-y-8 lg:pl-6">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                            <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#B99A62] font-semibold"><?= Format::e($about['about_director_eyebrow'] ?? 'Leadership & Vision') ?></span>
                        </div>
                        <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl text-[#243F34] font-normal leading-[1.12]">
                            <?= Format::e($about['about_director_title'] ?? 'A Commitment to Trust,') ?> <br />
                            <span class="italic text-[#B99A62]"><?= Format::e($about['about_director_title_italic'] ?? 'Excellence and Relationships.') ?></span>
                        </h2>
                    </div>

                    <!-- Authentic Quote -->
                    <blockquote class="p-6 rounded-xl bg-[#FFFFFF] border-l-4 border-[#B99A62] shadow-sm font-['Playfair_Display'] text-lg sm:text-xl text-[#243F34] italic font-normal leading-relaxed">
                        "<?= Format::e(trim($about['about_director_quote'] ?? 'When a family entrusts us with their residential acquisition or disposition, they are not simply commissioning a transaction—they are placing their privacy, capital, and family legacy in our care.', '"')) ?>"
                    </blockquote>

                    <!-- Narrative -->
                    <div class="space-y-4 font-['Plus_Jakarta_Sans'] text-base sm:text-lg text-[#4A504B] font-light leading-relaxed">
                        <p>
                            <?= nl2br(Format::e($about['about_director_p1'] ?? 'Our responsibility is to protect that trust without compromise, providing honest, unvarnished counsel that stands the test of decades. In an industry frequently oriented toward transactional velocity, we intentionally choose discernment, discretion, and partner-level stewardship.')) ?>
                        </p>
                        <p>
                            <?= nl2br(Format::e($about['about_director_p2'] ?? 'Every mandate we accept is handled personally, with complete transparency and adherence to regulatory governance under RERA.')) ?>
                        </p>
                    </div>

                    <!-- Sign-off & Credentials -->
                    <div class="pt-6 border-t border-[#E0D7C9] flex flex-wrap items-center justify-between gap-6">
                        <div>
                            <p class="font-['Playfair_Display'] text-2xl text-[#243F34] font-medium"><?= Format::e($about['about_director_signoff_name'] ?? 'Senior Advisory Directorate') ?></p>
                            <p class="font-['Manrope'] text-xs uppercase tracking-widest text-[#8C7343] font-semibold mt-1"><?= Format::e($about['about_director_signoff_title'] ?? 'Managing Principals · Elite Homez') ?></p>
                            <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#5C605D] mt-0.5"><?= Format::e(str_replace('{rera}', $rera, $about['about_director_signoff_sub'] ?? ('RERA Registered Real Estate Advisory · ' . $rera))) ?></p>
                        </div>
                        <div class="opacity-70">
                            <!-- Refined Brand Signature Flourish -->
                            <svg class="text-[#243F34]" fill="none" height="42" viewBox="0 0 160 42" width="160">
                                <path d="M12 28 C 35 12, 52 38, 70 19 C 88 5, 105 32, 128 16 C 140 10, 150 28, 155 20" stroke="currentColor" stroke-linecap="round" stroke-width="1.6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================================
         SECTION 8: TRUST & TESTIMONIALS (AUTHENTIC CLIENT FEEDBACK)
         ============================================================ -->
    <section class="w-full bg-[#FAF8F4] py-20 lg:py-32 px-6 lg:px-16 border-b border-[#E0D7C9]/60">
        <div class="max-w-[1440px] mx-auto">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <div class="inline-flex items-center gap-3">
                    <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                    <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#B99A62] font-semibold"><?= Format::e($about['about_reviews_eyebrow'] ?? 'Client Trust') ?></span>
                    <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                </div>
                <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl text-[#243F34] font-normal leading-tight">
                    <?= Format::e($about['about_reviews_title'] ?? 'Relationships Built on Trust.') ?>
                </h2>
                <p class="font-['Plus_Jakarta_Sans'] text-base text-[#4A504B] font-light leading-relaxed">
                    <?= Format::e($about['about_reviews_desc'] ?? 'Hear from the discerning individuals and families who have experienced our personalised approach to luxury real estate.') ?>
                </p>
            </div>

            <!-- Testimonials Grid (STREAMED DYNAMICALLY FROM DATABASE) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php 
                $validTestimonials = array_filter($testimonials, fn($t) => !empty($t['client_name']) && (int)($t['status'] ?? 1) === 1);
                if (empty($validTestimonials)):
                    $validTestimonials = [
                        [
                            'client_name' => 'R.K. Mehta',
                            'designation' => 'Home Buyer, Vasant Vihar',
                            'testimonial' => 'Elite Homez made the entire process seamless and professional. Their market knowledge and attention to detail are truly impressive.'
                        ],
                        [
                            'client_name' => 'Priya S.',
                            'designation' => 'Resident & Client, Jor Bagh',
                            'testimonial' => 'A trustworthy and knowledgeable team who genuinely understand client needs. Highly recommended for anyone looking to buy or rent premium properties.'
                        ],
                        [
                            'client_name' => 'Sovereign Capital Partner',
                            'designation' => 'Managing Director, Private Wealth',
                            'testimonial' => 'Elite Homez provided exemplary discreet advisory during our luxury bungalow acquisition in Jor Bagh. Fiduciary integrity is second to none.'
                        ]
                    ];
                endif;

                foreach ($validTestimonials as $t): 
                    if (str_contains(strtolower($t['client_name']), 'test') && !str_contains(strtolower($t['client_name']), 'capital')) {
                        continue;
                    }
                ?>
                    <article class="bg-[#FFFFFF] p-8 sm:p-10 rounded-2xl border border-[#E0D7C9] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <!-- 5-Star Subtle Accent -->
                            <div class="flex items-center gap-1 text-[#B99A62]">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <span class="text-sm">★</span>
                                <?php endfor; ?>
                            </div>
                            <blockquote class="font-['Playfair_Display'] text-base sm:text-lg text-[#243F34] italic font-normal leading-relaxed">
                                "<?= Format::e($t['testimonial']) ?>"
                            </blockquote>
                        </div>

                        <div class="pt-6 border-t border-[#E0D7C9] flex items-center justify-between">
                            <div>
                                <h4 class="font-['Playfair_Display'] text-lg text-[#171A18] font-medium"><?= Format::e($t['client_name']) ?></h4>
                                <p class="font-['Manrope'] text-xs text-[#8C7343] font-semibold tracking-wider uppercase mt-0.5"><?= Format::e($t['designation'] ?? 'Client') ?></p>
                            </div>
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#F5F1E8] text-[#B99A62] text-xs font-serif font-bold">
                                ✦
                            </span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- ============================================================
         SECTION 9: PREMIUM CALL TO ACTION (CAMPAIGN STATEMENT)
         ============================================================ -->
    <section class="relative w-full py-24 lg:py-36 px-6 lg:px-16 overflow-hidden bg-[#171A18] text-white">
        <!-- High-Resolution Architectural Background Image -->
        <div class="absolute inset-0">
            <img 
                src="<?= $ctaImg ?>" 
                alt="Contemporary Luxury Villa at Dusk in South Delhi" 
                class="w-full h-full object-cover scale-105 transition-transform duration-1000 ease-out"
                loading="lazy"
            />
            <!-- Dark Forest Green / Charcoal Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#171A18]/95 via-[#243F34]/90 to-[#171A18]/95"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(185,154,98,0.12),transparent_70%)]"></div>
        </div>

        <div class="relative max-w-[1440px] mx-auto text-center z-10">
            <div class="max-w-3xl mx-auto space-y-6">
                <!-- Eyebrow -->
                <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-[#B99A62]/35 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-[#B99A62] animate-pulse"></span>
                    <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#DFCF9F] font-semibold"><?= Format::e($about['about_cta_eyebrow'] ?? 'Private Advisory Mandates') ?></span>
                </div>

                <!-- Mandated Heading -->
                <h2 class="font-['Playfair_Display'] text-3xl sm:text-5xl lg:text-6xl text-white font-normal leading-[1.1] tracking-tight">
                    <?= Format::e($about['about_cta_title'] ?? 'Your Next Chapter Begins') ?> <br />
                    <span class="italic text-[#DFCF9F]"><?= Format::e($about['about_cta_title_italic'] ?? 'with the Right Address.') ?></span>
                </h2>

                <!-- Mandated Description -->
                <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg lg:text-xl text-gray-200 font-light leading-relaxed max-w-2xl mx-auto">
                    <?= nl2br(Format::e($about['about_cta_desc'] ?? 'Discover exceptional properties and experience a more personalised approach to luxury real estate.')) ?>
                </p>

                <!-- Action CTAs -->
                <div class="pt-6 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <?php 
                    $ctaBtn1Link = !empty($about['about_cta_btn1_link'])
                        ? (str_starts_with($about['about_cta_btn1_link'], 'http') || str_starts_with($about['about_cta_btn1_link'], '/') ? $about['about_cta_btn1_link'] : $baseUrl . '/' . ltrim($about['about_cta_btn1_link'], '/'))
                        : $baseUrl . '/properties';
                    $ctaBtn2Link = !empty($about['about_cta_btn2_link'])
                        ? (str_starts_with($about['about_cta_btn2_link'], 'http') || str_starts_with($about['about_cta_btn2_link'], '/') ? $about['about_cta_btn2_link'] : $baseUrl . '/' . ltrim($about['about_cta_btn2_link'], '/'))
                        : $baseUrl . '/contact-us';
                    $ctaBtn3Link = !empty($about['about_cta_btn3_link'])
                        ? $about['about_cta_btn3_link']
                        : 'https://wa.me/' . $waClean . '?text=' . urlencode('Hello Elite Homez, I would like to explore luxury property opportunities across South Delhi.');
                    ?>
                    <a href="<?= Format::e($ctaBtn1Link) ?>" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-gradient-to-r from-[#B99A62] to-[#8C7343] hover:from-[#C9A86A] hover:to-[#B99A62] text-[#171A18] px-9 py-4 rounded-full font-['Manrope'] text-xs uppercase tracking-[0.18em] font-bold shadow-xl hover:shadow-2xl transition-all duration-300">
                        <span><?= Format::e($about['about_cta_btn1_text'] ?? 'Explore Properties') ?></span>
                        <span>&rarr;</span>
                    </a>

                    <a href="<?= Format::e($ctaBtn2Link) ?>" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-full font-['Manrope'] text-xs uppercase tracking-[0.16em] font-semibold backdrop-blur-md border border-white/20 transition-all duration-300">
                        <span><?= Format::e($about['about_cta_btn2_text'] ?? 'Contact Our Team') ?></span>
                    </a>

                    <a href="<?= Format::e($ctaBtn3Link) ?>" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-transparent hover:bg-white/10 text-[#DFCF9F] px-7 py-4 rounded-full font-['Manrope'] text-xs uppercase tracking-[0.16em] font-semibold border border-[#B99A62]/40 transition-all duration-300">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span><?= Format::e($about['about_cta_btn3_text'] ?? 'WhatsApp Concierge') ?></span>
                    </a>
                </div>

                <div class="pt-6 flex items-center justify-center gap-6 text-xs font-['Manrope'] uppercase tracking-widest text-gray-400">
                    <span><?= Format::e($about['about_cta_note1'] ?? 'Direct Senior Partner Access') ?></span>
                    <span>•</span>
                    <span><?= Format::e($about['about_cta_note2'] ?? 'Bilateral NDA Protocols') ?></span>
                    <span>•</span>
                    <span><?= Format::e($about['about_cta_note3'] ?? 'RERA Certified') ?></span>
                </div>
            </div>
        </div>
    </section>

</div>
