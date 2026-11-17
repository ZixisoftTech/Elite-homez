<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$settings = $siteSettings ?? [];
$phone = $settings['phone_primary'] ?? '+91 9811044200';
$cleanPhone = preg_replace('/[^0-9\+]/', '', $phone);
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$cleanWa = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($cleanWa) === 10) {
    $cleanWa = '91' . $cleanWa;
}

// Images with robust fallbacks
$serviceImg = !empty($service['image']) ? $service['image'] : '/assets/images/stitch/service-hero-villa.jpg';
$serviceImgSrc = str_starts_with($serviceImg, 'http') ? $serviceImg : $baseUrl . $serviceImg;

$bannerImg = !empty($service['banner_image']) ? $service['banner_image'] : '/assets/images/stitch/service-living-pause.jpg';
$bannerImgSrc = str_starts_with($bannerImg, 'http') ? $bannerImg : $baseUrl . $bannerImg;

$showcaseImg = !empty($service['showcase_image']) ? $service['showcase_image'] : '/assets/images/stitch/service-master-suite.jpg';
$showcaseImgSrc = str_starts_with($showcaseImg, 'http') ? $showcaseImg : $baseUrl . $showcaseImg;

$ctaImg = !empty($service['cta_image']) ? $service['cta_image'] : '/assets/images/stitch/service-cta-dusk.jpg';
$ctaImgSrc = str_starts_with($ctaImg, 'http') ? $ctaImg : $baseUrl . $ctaImg;

// Repeaters with robust fallbacks
$approachStats = !empty($service['approach_stats']) ? (is_array($service['approach_stats']) ? $service['approach_stats'] : json_decode((string)$service['approach_stats'], true)) : [];
if (empty($approachStats)) {
    $approachStats = [
        ['value' => '100%', 'label' => 'Buyer Aligned'],
        ['value' => '30+ Yrs', 'label' => 'Title Audits'],
        ['value' => '0%', 'label' => 'Broker Markups'],
    ];
}

$deliverablesItems = !empty($service['deliverables_items']) ? (is_array($service['deliverables_items']) ? $service['deliverables_items'] : json_decode((string)$service['deliverables_items'], true)) : [];
if (empty($deliverablesItems)) {
    $deliverablesItems = [
        ['num' => '01', 'title' => 'Understand & Profile', 'tag' => 'Strategic Discovery', 'desc' => 'We begin with confidential discovery sessions to unpack spatial requirements, family lifestyle rhythms, architectural preferences, and statutory capital allocation timelines. Every parameter is codified to ensure precise market alignment.'],
        ['num' => '02', 'title' => 'Curate & Filter', 'tag' => 'Off-Market Access', 'desc' => 'We screen off-market enclaves and private family office portfolios, filtering out public portal clutter to present only residences with immaculate architectural pedigree, clear title, and uncompromised light, view, and spatial proportion.'],
        ['num' => '03', 'title' => 'Evaluate & Audit', 'tag' => 'Technical Diligence', 'desc' => 'Comprehensive technical due diligence: structural integrity audits, MEP and HVAC assessments, acoustic attenuation testing, solar orientation, Vastu harmony, and masterplan municipal infrastructure reviews.'],
        ['num' => '04', 'title' => 'Negotiate & Structure', 'tag' => 'Fiduciary Advocacy', 'desc' => 'Strategic buy-side representation protecting your financial confidentiality, benchmarked against real enclave transactional indices rather than inflated asking prices. We eliminate broker conflict and enforce realistic market values.'],
        ['num' => '05', 'title' => 'Close & Steward', 'tag' => 'Conveyance Protocol', 'desc' => 'End-to-end fiduciary stewardship: regulatory compliance under RERA, conveyance documentation, statutory stamp duty execution, physical key transfers, and seamless post-acquisition concierge transition.']
    ];
}

$whyPillars = !empty($service['why_pillars']) ? (is_array($service['why_pillars']) ? $service['why_pillars'] : json_decode((string)$service['why_pillars'], true)) : [];
if (empty($whyPillars)) {
    $whyPillars = [
        ['num' => '01', 'icon' => 'history_edu', 'title' => '20+ Years in Prime Enclaves', 'desc' => 'Decades spent cultivating intimate relationships with South Delhi landholders, architects, and private trusts across Vasant Vihar, Jor Bagh, and Golf Links.'],
        ['num' => '02', 'icon' => 'visibility_off', 'title' => '100% Off-Market Access', 'desc' => 'The majority of our transactions never appear in print or online portals. We operate purely through private networks and legacy mandates.'],
        ['num' => '03', 'icon' => 'location_on', 'title' => 'Micro-Market Mastery', 'desc' => 'Granular familiarity with plot dimensions, road widths, FAR regulations, municipal water pressures, and zoning covenants on every premier street.'],
        ['num' => '04', 'icon' => 'person', 'title' => 'Partner-Level Fiduciary', 'desc' => 'Your mandate is never delegated to junior sales reps. A Senior Partner directly stewards every negotiation, review, and property tour.'],
        ['num' => '05', 'icon' => 'lock', 'title' => 'Strict Non-Disclosure', 'desc' => 'Absolute privacy protocols. All client communications, wealth structures, and personal information remain legally protected under bilateral NDA covenants.'],
        ['num' => '06', 'icon' => 'verified_user', 'title' => 'RERA & Title Verification', 'desc' => 'Complete statutory compliance under DLRERA2023A00892. Forensic title vetting with leading property solicitors to ensure zero legacy encumbrances.']
    ];
}

$valuePropCheckmarks = !empty($service['value_prop_checkmarks']) ? (is_array($service['value_prop_checkmarks']) ? $service['value_prop_checkmarks'] : json_decode((string)$service['value_prop_checkmarks'], true)) : [];
if (empty($valuePropCheckmarks)) {
    $valuePropCheckmarks = [
        'Independent Valuations',
        'Discreet Viewings',
        'Legal Conveyance Oversight',
        'Post-Purchase Onboarding'
    ];
}

$faqsItems = !empty($service['faqs_items']) ? (is_array($service['faqs_items']) ? $service['faqs_items'] : json_decode((string)$service['faqs_items'], true)) : [];

$heroFeatures = !empty($service['hero_features']) ? (is_array($service['hero_features']) ? $service['hero_features'] : json_decode((string)$service['hero_features'], true)) : [];
if (empty($heroFeatures)) {
    $heroFeatures = ['South Delhi Enclaves', 'Zero Conflict of Interest', 'RERA Certified'];
}

$enquiryFeatures = !empty($service['enquiry_features']) ? (is_array($service['enquiry_features']) ? $service['enquiry_features'] : json_decode((string)$service['enquiry_features'], true)) : [];
if (empty($enquiryFeatures)) {
    $enquiryFeatures = [
        'Protected by bilateral non-disclosure covenants',
        'Verified RERA Advisory Mandate (DLRERA2023A00892)',
        'Direct Senior Partner Access Only'
    ];
}

// Format title with editorial serif split if applicable
$nameParts = explode(' ', trim($service['name']));
if (count($nameParts) >= 3) {
    $titleFirst = implode(' ', array_slice($nameParts, 0, count($nameParts) - 2));
    $titleLast = implode(' ', array_slice($nameParts, count($nameParts) - 2));
} elseif (count($nameParts) === 2) {
    $titleFirst = $nameParts[0];
    $titleLast = $nameParts[1];
} else {
    $titleFirst = $service['name'];
    $titleLast = '';
}

$mandateIndex = str_pad((string)($service['sort_order'] ?? 1), 2, '0', STR_PAD_LEFT);

// Clean formatting helper for editorial markdown content
function renderServiceContent(?string $raw): string {
    if (empty($raw)) return '';
    $lines = explode("\n", str_replace("\r", "", $raw));
    $html = '';
    $inList = false;
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '') {
            if ($inList) { $html .= "</ul>\n"; $inList = false; }
            continue;
        }
        if (str_starts_with($trimmed, '### ')) {
            if ($inList) { $html .= "</ul>\n"; $inList = false; }
            $text = htmlspecialchars(substr($trimmed, 4), ENT_QUOTES, 'UTF-8');
            $html .= "<h4 class=\"font-['Playfair_Display'] text-lg text-[#171A18] font-medium mt-4 mb-2\">{$text}</h4>\n";
        } elseif (str_starts_with($trimmed, '## ')) {
            if ($inList) { $html .= "</ul>\n"; $inList = false; }
            $text = htmlspecialchars(substr($trimmed, 3), ENT_QUOTES, 'UTF-8');
            $html .= "<h3 class=\"font-['Playfair_Display'] text-xl sm:text-2xl text-[#171A18] font-normal mt-4 mb-2\">{$text}</h3>\n";
        } elseif (str_starts_with($trimmed, '# ')) {
            if ($inList) { $html .= "</ul>\n"; $inList = false; }
            $text = htmlspecialchars(substr($trimmed, 2), ENT_QUOTES, 'UTF-8');
            $html .= "<h2 class=\"font-['Playfair_Display'] text-2xl sm:text-3xl text-[#171A18] font-normal mt-4 mb-2\">{$text}</h2>\n";
        } elseif (str_starts_with($trimmed, '- ') || str_starts_with($trimmed, '* ')) {
            if (!$inList) { $html .= "<ul class=\"space-y-2 my-2 list-disc list-inside text-[#4A504B]\">\n"; $inList = true; }
            $text = htmlspecialchars(substr($trimmed, 2), ENT_QUOTES, 'UTF-8');
            $text = preg_replace('/\*\*(.*?)\*\*/', '<strong class="font-semibold text-[#171A18]">$1</strong>', $text);
            $html .= "<li>{$text}</li>\n";
        } else {
            if ($inList) { $html .= "</ul>\n"; $inList = false; }
            $text = htmlspecialchars($trimmed, ENT_QUOTES, 'UTF-8');
            $text = preg_replace('/\*\*(.*?)\*\*/', '<strong class="font-semibold text-[#171A18]">$1</strong>', $text);
            $html .= "<p class=\"text-sm sm:text-base text-[#4A504B] leading-relaxed font-light\">{$text}</p>\n";
        }
    }
    if ($inList) { $html .= "</ul>\n"; }
    return $html;
}
?>

<div class="flex flex-col w-full bg-[#FAF8F4] text-[#171A18]">
    <!-- BREADCRUMB STRIP -->
    <section class="w-full bg-[#F5F1E8] border-b border-[#D8CDBA]/40 py-4 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <nav class="flex items-center gap-2 font-['Manrope'] uppercase text-[0.7rem] tracking-widest text-[#4A504B]">
                <a class="hover:text-[#171A18] transition-colors" href="<?= $baseUrl ?>/">Home</a>
                <span class="text-[#B99A62]">/</span>
                <a class="hover:text-[#171A18] transition-colors" href="<?= $baseUrl ?>/services">Services</a>
                <span class="text-[#B99A62]">/</span>
                <span class="text-[#171A18] font-semibold"><?= Format::e($service['name']) ?></span>
            </nav>
            <div class="hidden md:flex items-center gap-4 text-[0.7rem] font-['Manrope'] uppercase tracking-widest text-[#B99A62]">
                <span class="w-1.5 h-1.5 rounded-full bg-[#B99A62] animate-pulse"></span>
                <span><?= Format::e(!empty($service['hero_badge']) ? $service['hero_badge'] : 'Private Client Mandate') ?></span>
            </div>
        </div>
    </section>

    <!-- SECTION 1: SERVICE HERO (ASYMMETRIC & CINEMATIC) -->
    <section class="w-full bg-[#FAF8F4] py-14 lg:py-24 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <!-- Left Editorial Column -->
            <div class="lg:col-span-6 space-y-8">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <span class="font-['Manrope'] uppercase tracking-[0.2em] text-[#B99A62] text-xs font-semibold"><?= Format::e(!empty($service['hero_badge']) ? $service['hero_badge'] : 'Practice Mandate') ?></span>
                        <div class="h-[1px] w-12 bg-[#B99A62]/40"></div>
                        <span class="text-xl text-[#B99A62]/70 italic font-['Playfair_Display',serif]"><?= $mandateIndex ?></span>
                    </div>
                    <p class="font-['Manrope'] uppercase tracking-widest text-[#5C605D] text-xs"><?= Format::e(!empty($service['hero_tagline']) ? $service['hero_tagline'] : 'ELITE HOMEZ · PRIVATE REAL ESTATE ADVISORY') ?></p>
                    <h1 class="text-3xl sm:text-4xl lg:text-[3.25rem] text-[#171A18] leading-[1.25] lg:leading-[1.3] font-normal" style="font-family: 'Playfair Display', serif;">
                        <span class="block"><?= Format::e($titleFirst) ?></span>
                        <?php if (!empty($titleLast)): ?>
                            <span class="block mt-2 sm:mt-3.5 italic font-normal font-['Playfair_Display',serif] text-[#B99A62]"><?= Format::e($titleLast) ?></span>
                        <?php endif; ?>
                    </h1>
                </div>
                <p class="text-base sm:text-lg text-[#4A504B] leading-relaxed max-w-xl font-light">
                    <?= Format::e($service['short_description']) ?>
                </p>
                <div class="pt-2 flex flex-col sm:flex-row gap-5 items-start sm:items-center">
                    <a class="bg-[#243F34] text-white font-['Manrope'] uppercase tracking-widest px-8 py-4 shadow-md hover:bg-[#171A18] transition-colors inline-flex items-center gap-3 text-xs font-semibold" href="<?= Format::e(!empty($service['hero_cta_url']) ? $service['hero_cta_url'] : '#confidential-desk') ?>">
                        <span><?= Format::e(!empty($service['hero_cta_text']) ? $service['hero_cta_text'] : 'Speak with an Advisor') ?></span>
                        <span class="material-symbols-outlined text-sm text-[#DFCF9F]">arrow_forward</span>
                    </a>
                    <a class="group inline-flex items-center gap-3 font-['Manrope'] uppercase tracking-widest text-[#171A18] hover:text-[#B99A62] transition-colors py-3 text-xs font-semibold" href="https://wa.me/<?= $cleanWa ?>?text=<?= urlencode("Hello Elite Homez, I would like to consult regarding your {$service['name']} practice.") ?>" rel="noopener noreferrer" target="_blank">
                        <span class="material-symbols-outlined text-base text-[#B99A62]">chat</span>
                        <span>WhatsApp Concierge</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
                <div class="pt-6 border-t border-[#D8CDBA]/40 flex flex-wrap items-center gap-4 text-xs font-['Manrope'] uppercase tracking-wider text-[#5C605D]">
                    <?php if (!empty($heroFeatures)): ?>
                        <?php foreach ($heroFeatures as $hIdx => $hFeat): ?>
                            <?php if ($hIdx > 0): ?>
                                <span class="text-[#B99A62]">•</span>
                            <?php endif; ?>
                            <span><?= Format::e($hFeat) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span>South Delhi Enclaves</span>
                        <span class="text-[#B99A62]">•</span>
                        <span>Zero Conflict of Interest</span>
                        <span class="text-[#B99A62]">•</span>
                        <span>RERA Certified</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Architectural Portrait Column -->
            <div class="lg:col-span-6 relative">
                <div class="relative w-full aspect-[4/3] lg:aspect-[5/4] overflow-hidden bg-[#EAE3D7] shadow-xl border border-[#D8CDBA]/40">
                    <img class="w-full h-full object-cover" alt="<?= Format::e($service['name']) ?> — Elite Homez Architectural Facade" src="<?= $serviceImgSrc ?>" loading="eager"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#171A18]/60 via-transparent to-transparent pointer-events-none"></div>
                    <div class="absolute bottom-6 left-6 right-6 p-5 bg-[#FAF8F4]/95 backdrop-blur-md border border-[#B99A62]/30 shadow-lg flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="block font-['Manrope'] uppercase tracking-widest text-[#B99A62] text-[0.65rem] font-semibold">Fiduciary Protocol</span>
                            <p class="text-sm lg:text-base text-[#171A18] font-medium tracking-tight font-['Playfair_Display',serif]">
                                <?= Format::e(!empty($service['hero_fiduciary_title']) ? $service['hero_fiduciary_title'] : 'Exclusive Buy-Side Mandate') ?>
                            </p>
                        </div>
                        <span class="font-['Manrope'] text-[0.65rem] uppercase tracking-wider bg-[#243F34] text-[#FAF8F4] px-3 py-1.5 font-semibold"><?= Format::e(!empty($service['hero_fiduciary_badge']) ? $service['hero_fiduciary_badge'] : 'Zero Conflict') ?></span>
                    </div>
                </div>
                <!-- Architectural hairline offset accent -->
                <div class="hidden lg:block absolute -bottom-6 -left-6 w-32 h-32 border-l border-b border-[#B99A62]/40 -z-10 pointer-events-none"></div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: THE ELITE HOMEZ APPROACH -->
    <section class="w-full bg-[#F5F1E8] py-20 lg:py-28 px-6 lg:px-12 border-y border-[#D8CDBA]/40">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
            <div class="lg:col-span-5 space-y-6">
                <span class="font-['Manrope'] uppercase tracking-[0.2em] text-[#B99A62] text-xs font-semibold"><?= Format::e(!empty($service['approach_eyebrow']) ? $service['approach_eyebrow'] : 'The Elite Homez Approach') ?></span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl text-[#171A18] font-normal leading-snug" style="font-family: 'Playfair Display', serif;">
                    <?= Format::e(!empty($service['approach_title']) ? $service['approach_title'] : 'Property decisions deserve a more personal, discreet approach.') ?>
                </h2>
                <div class="w-16 h-[2px] bg-[#B99A62]"></div>
            </div>
            <div class="lg:col-span-7 space-y-6 text-[#4A504B] text-base sm:text-lg leading-relaxed font-light">
                <?php if (!empty($service['approach_description'])): ?>
                    <div class="space-y-4">
                        <?= nl2br(Format::e($service['approach_description'])) ?>
                    </div>
                <?php else: ?>
                    <p>
                        In the rarefied landscape of Delhi NCR’s trophy real estate—spanning Vasant Vihar, Jor Bagh, Golf Links, and Chanakyapuri—the finest residences are rarely advertised on open portals. They trade in quiet confidence between established generational families and vetted private offices.
                    </p>
                    <p>
                        Elite Homez operates exclusively on the client side of the acquisition equation. We act not as conventional transactional brokers, but as personal property fiduciaries who examine legal title, spatial viability, structural integrity, and long-term resale liquidity before you ever cross a threshold.
                    </p>
                <?php endif; ?>

                <?php if (!empty($approachStats)): ?>
                <div class="pt-4 grid grid-cols-1 sm:grid-cols-3 gap-6 font-['Manrope'] uppercase tracking-widest text-[#171A18] text-xs font-semibold">
                    <?php foreach ($approachStats as $st): ?>
                    <div class="p-5 bg-[#FAF8F4] border border-[#D8CDBA]/60 shadow-sm">
                        <span class="block text-[#B99A62] text-2xl mb-1 font-['Playfair_Display',serif] font-bold"><?= Format::e($st['value'] ?? '') ?></span>
                        <span class="text-[#5C605D] text-[0.7rem]"><?= Format::e($st['label'] ?? '') ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- SECTION 3: WHAT WE DO (EDITORIAL NUMBERED LIST / DUE DILIGENCE) -->
    <section class="w-full bg-[#FAF8F4] py-20 lg:py-28 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 pb-6 border-b border-[#D8CDBA]/40 gap-6">
                <div>
                    <span class="font-['Manrope'] uppercase tracking-[0.2em] text-[#B99A62] text-xs font-semibold"><?= Format::e(!empty($service['deliverables_eyebrow']) ? $service['deliverables_eyebrow'] : 'Systematic Due Diligence') ?></span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl text-[#171A18] mt-2 font-normal" style="font-family: 'Playfair Display', serif;"><?= Format::e(!empty($service['deliverables_title']) ? $service['deliverables_title'] : 'What We Do') ?></h2>
                </div>
                <p class="text-sm sm:text-base text-[#5C605D] max-w-md font-light">
                    <?= Format::e(!empty($service['deliverables_subtitle']) ? $service['deliverables_subtitle'] : 'A rigorous, institutional methodology tailored specifically to high-value residential acquisitions.') ?>
                </p>
            </div>

            <div class="divide-y divide-[#D8CDBA]/40">
                <?php foreach ($deliverablesItems as $dIdx => $dItem): ?>
                <div class="py-10 grid grid-cols-1 md:grid-cols-12 gap-6 items-baseline group hover:bg-[#F5F1E8]/50 transition-colors px-4">
                    <div class="md:col-span-1">
                        <span class="text-3xl font-serif text-[#B99A62] font-normal" style="font-family: 'Playfair Display', serif;"><?= Format::e($dItem['num'] ?? sprintf('%02d', $dIdx + 1)) ?></span>
                    </div>
                    <div class="md:col-span-3">
                        <h3 class="font-['Manrope'] uppercase tracking-widest text-[#171A18] text-sm font-semibold"><?= Format::e($dItem['title'] ?? '') ?></h3>
                        <?php if (!empty($dItem['tag'])): ?>
                            <span class="text-xs text-[#5C605D] font-['Manrope'] uppercase block mt-1"><?= Format::e($dItem['tag']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="md:col-span-8">
                        <p class="text-sm sm:text-base text-[#4A504B] leading-relaxed font-light">
                            <?= nl2br(Format::e($dItem['desc'] ?? '')) ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (!empty(trim((string)$service['content']))): ?>
                <!-- Dynamic Editorial Content Brief from CMS -->
                <div class="mt-16 p-8 lg:p-12 bg-[#F5F1E8] border border-[#D8CDBA]/50 shadow-sm space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="font-['Manrope'] uppercase tracking-[0.2em] text-[#B99A62] text-xs font-semibold">Executive Practice Briefing</span>
                        <div class="h-[1px] w-12 bg-[#B99A62]/40"></div>
                    </div>
                    <div class="space-y-4">
                        <?= renderServiceContent($service['content']) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- SECTION 4: LARGE IMAGE STORY (ARCHITECTURAL PAUSE) -->
    <section class="w-full relative py-28 lg:py-36 px-6 lg:px-12 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?= $bannerImgSrc ?>')"></div>
        <div class="absolute inset-0 bg-[#171A18]/65 backdrop-blur-[2px]"></div>
        <div class="relative max-w-5xl mx-auto h-full flex flex-col justify-center items-center text-center text-white space-y-6">
            <span class="font-['Manrope'] uppercase tracking-[0.25em] text-[#DFCF9F] text-xs font-semibold"><?= Format::e(!empty($service['banner_tag']) ? $service['banner_tag'] : 'Perspective · Discernment · Heritage') ?></span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl max-w-3xl leading-tight font-serif italic" style="font-family: 'Playfair Display', serif;">
                <?= Format::e(!empty($service['banner_quote']) ? $service['banner_quote'] : '“Access matters. Judgement matters more.”') ?>
            </h2>
            <p class="text-base sm:text-lg text-[#EAE3D7] max-w-xl font-light">
                <?= Format::e(!empty($service['banner_subquote']) ? $service['banner_subquote'] : 'Our role is not simply to show you property. It is to help you make an enduring, generational decision anchored in long-term value.') ?>
            </p>
            <div class="pt-2">
                <a class="inline-flex items-center gap-2 border border-[#DFCF9F]/60 text-white px-8 py-3.5 font-['Manrope'] uppercase tracking-widest hover:bg-[#DFCF9F] hover:text-[#171A18] transition-colors text-xs font-semibold" href="<?= Format::e(!empty($service['banner_btn_url']) ? $service['banner_btn_url'] : '#confidential-desk') ?>">
                    <?= Format::e(!empty($service['banner_btn_text']) ? $service['banner_btn_text'] : 'Request A Private Briefing') ?>
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 5: WHY ELITE HOMEZ (DEEP FOREST GREEN INSTITUTIONAL AUTHORITY) -->
    <section class="w-full bg-[#243F34] text-white py-24 px-6 lg:px-12 border-t border-[#B99A62]/30">
        <div class="max-w-7xl mx-auto space-y-16">
            <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-[#B99A62]/20 pb-8 gap-6">
                <div>
                    <span class="font-['Manrope'] uppercase tracking-[0.2em] text-[#DFCF9F] text-xs font-semibold"><?= Format::e(!empty($service['why_eyebrow']) ? $service['why_eyebrow'] : 'Fiduciary Excellence') ?></span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl text-white mt-2 font-normal" style="font-family: 'Playfair Display', serif;"><?= Format::e(!empty($service['why_title']) ? $service['why_title'] : 'Why Elite Homez') ?></h2>
                </div>
                <p class="text-sm sm:text-base text-[#EAE3D7]/80 max-w-md font-light">
                    <?= Format::e(!empty($service['why_subtitle']) ? $service['why_subtitle'] : 'Experience, absolute discretion, and a deeper understanding of exceptional Delhi real estate.') ?>
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($whyPillars as $wIdx => $wPillar): ?>
                <div class="p-8 bg-[#171A18]/50 border border-[#B99A62]/25 space-y-4 hover:border-[#B99A62]/60 hover:bg-[#171A18]/70 transition-all">
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-serif text-[#DFCF9F]" style="font-family: 'Playfair Display', serif;"><?= Format::e($wPillar['num'] ?? sprintf('%02d', $wIdx + 1)) ?></span>
                        <span class="material-symbols-outlined text-[#DFCF9F] text-xl"><?= Format::e(!empty($wPillar['icon']) ? $wPillar['icon'] : 'verified_user') ?></span>
                    </div>
                    <h3 class="text-lg text-white font-medium" style="font-family: 'Playfair Display', serif;"><?= Format::e($wPillar['title'] ?? '') ?></h3>
                    <p class="text-sm text-[#EAE3D7]/75 leading-relaxed font-light">
                        <?= Format::e($wPillar['desc'] ?? '') ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- SECTION 6: SERVICE VALUE PROPOSITION (SPLIT EDITORIAL) -->
    <section class="w-full bg-[#FAF8F4] py-20 lg:py-28 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <!-- Left Image Showcase -->
            <div class="lg:col-span-6 space-y-4">
                <div class="relative aspect-[16/10] overflow-hidden bg-[#EAE3D7] shadow-md border border-[#D8CDBA]/30">
                    <img alt="<?= Format::e($service['showcase_caption'] ?? 'Architectural Showcase') ?>" class="w-full h-full object-cover" src="<?= $showcaseImgSrc ?>" loading="lazy"/>
                </div>
                <div class="flex justify-between items-center text-xs font-['Manrope'] uppercase tracking-wider text-[#5C605D] px-1 font-semibold">
                    <span><?= Format::e(!empty($service['showcase_caption']) ? $service['showcase_caption'] : 'Private Residence · Vasant Vihar') ?></span>
                    <span class="text-[#B99A62]"><?= Format::e(!empty($service['showcase_tag']) ? $service['showcase_tag'] : 'Curated Acquisition') ?></span>
                </div>
            </div>
            <!-- Right Content -->
            <div class="lg:col-span-6 space-y-6">
                <span class="font-['Manrope'] uppercase tracking-[0.2em] text-[#B99A62] text-xs font-semibold"><?= Format::e(!empty($service['value_prop_eyebrow']) ? $service['value_prop_eyebrow'] : 'Beyond Brokering') ?></span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl text-[#171A18] leading-tight font-normal" style="font-family: 'Playfair Display', serif;">
                    <?= Format::e(!empty($service['value_prop_title']) ? $service['value_prop_title'] : 'More than a property transaction. An enduring generational asset.') ?>
                </h2>
                <div class="w-12 h-[2px] bg-[#B99A62]"></div>
                <?php if (!empty($service['value_prop_body'])): ?>
                    <div class="text-sm sm:text-base text-[#4A504B] leading-relaxed font-light space-y-4">
                        <?= nl2br(Format::e($service['value_prop_body'])) ?>
                    </div>
                <?php else: ?>
                    <p class="text-sm sm:text-base text-[#4A504B] leading-relaxed font-light">
                        Traditional real estate firms are structured to favor transaction velocity and seller mandates. Elite Homez was conceived on the exact opposite principle: uncompromising buyer advocacy.
                    </p>
                    <p class="text-sm sm:text-base text-[#4A504B] leading-relaxed font-light">
                        We identify hidden boundary disputes, evaluate future infrastructure noise, scrutinize heritage zoning restrictions, and coordinate directly with your private tax and family office advisors before drafting purchase agreements.
                    </p>
                <?php endif; ?>
                
                <?php if (!empty($valuePropCheckmarks)): ?>
                <div class="pt-4 border-t border-[#D8CDBA]/30 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-['Manrope'] uppercase tracking-wider text-[#171A18] font-semibold">
                    <?php foreach ($valuePropCheckmarks as $cMark): ?>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#B99A62] text-sm">check_circle</span>
                        <span><?= Format::e($cMark) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- SECTION 7: FREQUENTLY ASKED QUESTIONS (FAQ SECTION - BALANCED EDITORIAL ACCORDION) -->
    <?php if (!empty($faqsItems)): ?>
    <section class="w-full bg-[#F5F1E8] py-20 lg:py-28 px-6 lg:px-12 border-t border-[#D8CDBA]/30" id="service-faqs">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                <!-- Left Editorial Intro (4 Cols) -->
                <div class="lg:col-span-4 space-y-4 lg:sticky lg:top-28">
                    <span class="font-['Manrope'] uppercase tracking-[0.2em] text-[#B99A62] text-xs font-semibold"><?= Format::e(!empty($service['faqs_eyebrow']) ? $service['faqs_eyebrow'] : 'Bespoke Guidance & Clarity') ?></span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl text-[#171A18] font-normal leading-snug" style="font-family: 'Playfair Display', serif;">
                        <?= Format::e(!empty($service['faqs_title']) ? $service['faqs_title'] : 'Frequently Asked Questions') ?>
                    </h2>
                    <div class="w-12 h-[2px] bg-[#B99A62]"></div>
                    <p class="text-sm sm:text-base text-[#5C605D] font-light leading-relaxed">
                        <?= Format::e(!empty($service['faqs_subtitle']) ? $service['faqs_subtitle'] : 'Clear answers to the most common questions regarding our private advisory services and confidential engagement process.') ?>
                    </p>
                    <div class="pt-2 hidden lg:block">
                        <a href="#confidential-desk" class="inline-flex items-center gap-2 text-xs font-['Manrope'] uppercase tracking-widest text-[#243F34] hover:text-[#B99A62] font-semibold transition-colors">
                            <span>Have another enquiry?</span>
                            <span class="text-[#B99A62]">→</span>
                        </a>
                    </div>
                </div>

                <!-- Right Accordion List (8 Cols) -->
                <div class="lg:col-span-8 space-y-4" id="service-faq-accordion">
                    <?php foreach ($faqsItems as $fIdx => $faq): ?>
                    <div class="border border-[#D8CDBA]/60 bg-[#FAF8F4] hover:border-[#B99A62] transition-colors shadow-sm">
                        <button type="button" class="w-full p-6 text-left flex items-center justify-between gap-4 font-['Playfair_Display'] text-lg sm:text-xl text-[#171A18] hover:text-[#B99A62] transition-colors service-faq-toggle" data-target="#sfaq-ans-<?= $fIdx ?>" aria-expanded="<?= $fIdx === 0 ? 'true' : 'false' ?>">
                            <span class="font-normal"><?= Format::e($faq['question'] ?? '') ?></span>
                            <span class="w-8 h-8 rounded-full border border-[#D8CDBA]/80 flex-shrink-0 flex items-center justify-center text-[#B99A62] text-base font-light transform transition-transform duration-300 sfaq-icon <?= $fIdx === 0 ? 'rotate-45' : '' ?>">
                                +
                            </span>
                        </button>
                        <div id="sfaq-ans-<?= $fIdx ?>" class="sfaq-content px-6 pb-6 pt-1 font-['Manrope'] text-sm sm:text-base text-[#4A504B] font-light leading-relaxed border-t border-[#D8CDBA]/20 <?= $fIdx === 0 ? 'block' : 'hidden' ?>">
                            <?= nl2br(Format::e($faq['answer'] ?? '')) ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- SECTION 8: SERVICE ENQUIRY FORM (CONFIDENTIAL CONVERSION DESK) -->
    <section class="w-full bg-[#243F34] text-white py-24 px-6 lg:px-12 border-t border-[#B99A62]/30" id="confidential-desk">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                <!-- Advisory Context (5 Cols) -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="space-y-2">
                        <span class="font-['Manrope'] uppercase tracking-[0.2em] text-[#DFCF9F] text-xs font-semibold"><?= Format::e(!empty($service['enquiry_eyebrow']) ? $service['enquiry_eyebrow'] : 'Confidential Dialogue') ?></span>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl text-white leading-tight font-normal" style="font-family: 'Playfair Display', serif;">
                            <?= Format::e(!empty($service['enquiry_title']) ? $service['enquiry_title'] : 'Initiate a Private Advisory Briefing') ?>
                        </h2>
                    </div>
                    <p class="text-sm sm:text-base text-[#EAE3D7]/80 leading-relaxed font-light">
                        <?= Format::e(!empty($service['enquiry_description']) ? $service['enquiry_description'] : 'Share your parameters. A designated Elite Homez Senior Partner will contact you under strict bilateral confidentiality.') ?>
                    </p>
                    
                    <?php if (!empty($enquiryFeatures)): ?>
                    <div class="pt-6 space-y-4 text-xs font-['Manrope'] uppercase tracking-wider text-[#DFCF9F] border-t border-[#B99A62]/20 font-semibold">
                        <?php foreach ($enquiryFeatures as $eFeat): ?>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#B99A62] text-base">shield</span>
                            <span class="text-[#EAE3D7]/90"><?= Format::e($eFeat) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Form Interface (7 Cols) -->
                <div class="lg:col-span-7 bg-[#171A18]/65 border border-[#B99A62]/30 p-8 lg:p-10 shadow-2xl">
                    <form id="service-advisory-form" action="<?= $baseUrl ?>/enquire" method="POST" class="space-y-6">
                        <?= Csrf::field() ?>
                        <!-- Anti-spam Honeypot -->
                        <div style="display: none;">
                            <input type="text" name="website_url_check" tabindex="-1" autocomplete="off">
                        </div>
                        <input type="hidden" name="source_page" value="Service: <?= Format::e($service['name']) ?>">
                        <input type="hidden" name="return_url" value="<?= $baseUrl ?>/services/<?= Format::e($service['slug']) ?>#confidential-desk">

                        <div>
                            <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold">Full Name *</label>
                            <input class="w-full bg-white/10 border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-2.5 outline-none text-sm transition-colors placeholder:text-white/30" placeholder="e.g. Raghav Malhotra" required="" type="text" name="name"/>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold">Direct Telephone *</label>
                                <input class="w-full bg-white/10 border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-2.5 outline-none text-sm transition-colors placeholder:text-white/30" placeholder="+91 98110 00000" required="" type="tel" name="mobile"/>
                            </div>
                            <div>
                                <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold">Confidential Email *</label>
                                <input class="w-full bg-white/10 border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-2.5 outline-none text-sm transition-colors placeholder:text-white/30" placeholder="principal@domain.com" required="" type="email" name="email"/>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold">Preferred Enclave</label>
                                <select name="enclave_choice" id="enclave-choice" class="w-full bg-[#243F34] border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-2.5 outline-none text-sm transition-colors cursor-pointer">
                                    <?php if (!empty($allAreas)): ?>
                                        <?php foreach ($allAreas as $ar): ?>
                                            <option value="<?= Format::e($ar['name']) ?>"><?= Format::e($ar['name']) ?></option>
                                        <?php endforeach; ?>
                                        <option value="Other South Delhi Enclave">Other South Delhi Enclave</option>
                                    <?php else: ?>
                                        <option value="Vasant Vihar">Vasant Vihar</option>
                                        <option value="Jor Bagh">Jor Bagh</option>
                                        <option value="Golf Links">Golf Links</option>
                                        <option value="Chanakyapuri / Malcha">Chanakyapuri / Malcha</option>
                                        <option value="Shanti Niketan">Shanti Niketan</option>
                                        <option value="Other South Delhi Enclave">Other South Delhi Enclave</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold">Target Timeline</label>
                                <select name="timeline_choice" id="timeline-choice" class="w-full bg-[#243F34] border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-2.5 outline-none text-sm transition-colors cursor-pointer">
                                    <option value="Immediate (0-3 Months)">Immediate (0-3 Months)</option>
                                    <option value="Short Term (3-6 Months)">3-6 Months</option>
                                    <option value="Strategic (6-12 Months)">6-12 Months (Generational)</option>
                                    <option value="Market Survey Only">Market Survey Only</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block font-['Manrope'] uppercase tracking-widest text-[#EAE3D7] text-xs mb-2 font-semibold">Acquisition Parameters &amp; Spatial Requirements *</label>
                            <textarea id="brief-message" name="message" class="w-full bg-white/10 border-b border-[#B99A62]/40 focus:border-[#DFCF9F] text-white px-3 py-2.5 outline-none text-sm transition-colors placeholder:text-white/30" placeholder="Plot area, configuration (Duplex / Standalone / Builder Floor), parking needs, orientation..." rows="3" required></textarea>
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row gap-4">
                            <button id="submit-advisory-btn" class="flex-1 bg-[#B99A62] text-[#171A18] font-['Manrope'] uppercase tracking-widest px-6 py-4 hover:bg-[#DFCF9F] transition-colors font-semibold shadow-md text-xs" type="submit">
                                <?= Format::e(!empty($service['enquiry_btn_text']) ? $service['enquiry_btn_text'] : 'Request Confidential Consultation') ?>
                            </button>
                            <a class="inline-flex items-center justify-center gap-2 border border-[#B99A62]/50 text-white px-6 py-4 font-['Manrope'] uppercase tracking-widest hover:border-[#DFCF9F] hover:text-[#DFCF9F] transition-colors text-xs font-semibold" href="https://wa.me/<?= $cleanWa ?>?text=<?= urlencode("Hello Elite Homez, I would like to consult regarding your {$service['name']} practice.") ?>" rel="noopener noreferrer" target="_blank">
                                <span class="material-symbols-outlined text-sm text-[#DFCF9F]">chat</span>
                                <span>WhatsApp Concierge</span>
                            </a>
                        </div>

                        <div id="form-feedback" class="hidden p-4 bg-[#B99A62]/20 border border-[#B99A62] text-xs text-[#FAF8F4] text-center font-['Manrope'] uppercase tracking-wider font-semibold">
                            Thank you. Your mandate parameters have been securely routed to a Senior Partner. We will connect within 4 business hours.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 9: FINAL CINEMATIC CALL TO ACTION -->
    <section class="w-full relative py-28 px-6 lg:px-12 overflow-hidden bg-[#171A18]">
        <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('<?= $ctaImgSrc ?>')"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#171A18] via-[#171A18]/80 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto space-y-8">
            <div class="space-y-4 max-w-2xl">
                <span class="font-['Manrope'] uppercase tracking-[0.25em] text-[#DFCF9F] text-xs font-semibold"><?= Format::e(!empty($service['cta_eyebrow']) ? $service['cta_eyebrow'] : 'Elite Homez Advisory') ?></span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl text-white leading-tight font-normal" style="font-family: 'Playfair Display', serif;">
                    <?= Format::e(!empty($service['cta_title']) ? $service['cta_title'] : 'The right property starts with the right advice.') ?>
                </h2>
                <p class="text-base sm:text-lg text-[#EAE3D7]/80 max-w-xl font-light">
                    <?= Format::e(!empty($service['cta_subtitle']) ? $service['cta_subtitle'] : 'Discover a more considered, confidential way to navigate premier Delhi NCR real estate.') ?>
                </p>
            </div>
            <div class="flex flex-wrap gap-5 pt-2">
                <a class="bg-[#FAF8F4] text-[#171A18] font-['Manrope'] uppercase tracking-widest px-8 py-4 hover:bg-[#DFCF9F] transition-colors text-xs font-semibold" href="<?= Format::e(!empty($service['cta_btn1_url']) ? $service['cta_btn1_url'] : $baseUrl . '/properties') ?>">
                    <?= Format::e(!empty($service['cta_btn1_text']) ? $service['cta_btn1_text'] : 'Explore Properties Catalogue') ?>
                </a>
                <a class="border border-white/40 text-white font-['Manrope'] uppercase tracking-widest px-8 py-4 hover:border-white transition-colors text-xs font-semibold" href="<?= Format::e(!empty($service['cta_btn2_url']) ? $service['cta_btn2_url'] : $baseUrl . '/contact-us') ?>">
                    <?= Format::e(!empty($service['cta_btn2_text']) ? $service['cta_btn2_text'] : 'Contact Advisory Desk') ?>
                </a>
            </div>
        </div>
    </section>
</div>

<!-- AJAX Submission & FAQ Accordion Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion Toggle
    const faqButtons = document.querySelectorAll('.service-faq-toggle');
    faqButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetContent = document.querySelector(targetId);
            const icon = this.querySelector('.sfaq-icon');
            const isCurrentlyOpen = !targetContent.classList.contains('hidden');

            // Close all
            document.querySelectorAll('.sfaq-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.sfaq-icon').forEach(i => i.classList.remove('rotate-45'));
            document.querySelectorAll('.service-faq-toggle').forEach(b => b.setAttribute('aria-expanded', 'false'));

            // If it was closed, open it
            if (!isCurrentlyOpen) {
                targetContent.classList.remove('hidden');
                this.setAttribute('aria-expanded', 'true');
                if (icon) icon.classList.add('rotate-45');
            }
        });
    });

    // Form submission
    const form = document.getElementById('service-advisory-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        const enclaveEl = document.getElementById('enclave-choice');
        const timelineEl = document.getElementById('timeline-choice');
        const msgEl = document.getElementById('brief-message');

        const enclaveVal = enclaveEl ? enclaveEl.value : '';
        const timelineVal = timelineEl ? timelineEl.value : '';
        const rawMsg = msgEl.value;

        if (enclaveVal || timelineVal) {
            if (!rawMsg.includes('[Preferred Enclave:')) {
                msgEl.value = `[Preferred Enclave: ${enclaveVal}] [Target Timeline: ${timelineVal}]\n${rawMsg}`;
            }
        }

        e.preventDefault();
        const feedback = document.getElementById('form-feedback');
        const submitBtn = document.getElementById('submit-advisory-btn');
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting Mandate...';

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                feedback.textContent = data.message || 'Thank you. Your mandate parameters have been securely routed to a Senior Partner. We will connect within 4 business hours.';
                feedback.classList.remove('hidden');
                form.reset();
            } else {
                feedback.textContent = data.message || 'An error occurred. Please telephone our Senior Advisory Desk directly.';
                feedback.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            form.submit();
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });
});
</script>
