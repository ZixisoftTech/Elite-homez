<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$settings = $siteSettings ?? [];
$phone = $settings['phone_primary'] ?? '+91 9811044200';
$phoneSecondary = $settings['phone_secondary'] ?? '+91 98112 88400';
$phoneClean = preg_replace('/[^0-9\+]/', '', $phone);
$phoneSecondaryClean = preg_replace('/[^0-9\+]/', '', $phoneSecondary);
$email = $settings['email_primary'] ?? 'info@elitehomez.com';
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$waClean = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($waClean) === 10) {
    $waClean = '91' . $waClean;
}
$waDisplay = $settings['whatsapp_display'] ?? '+91 98110 44200';
$address = $settings['office_address'] ?? '225, 2nd Floor, Square One Mall, Saket, New Delhi - 110017 (India)';
$rera = $settings['rera_number'] ?? 'DLRERA2023A00892';

$areasList = $areas ?? [];
$servicesList = $services ?? [];

// Query parameters for contextual pre-fill
$prefillSubject = trim((string)($_GET['subject'] ?? ''));
$prefillArea = trim((string)($_GET['area'] ?? ''));
$prefillPropertyId = trim((string)($_GET['property_id'] ?? ''));
$prefillType = trim((string)($_GET['type'] ?? ''));
?>

<div class="flex flex-col w-full bg-[#FAF8F4] text-[#171A18] selection:bg-[#B99A62] selection:text-[#171A18] overflow-hidden">

    <!-- ============================================================
         SECTION 1: CONTACT HERO SECTION
         ============================================================ -->
    <section class="relative w-full bg-[#171A18] text-white pt-28 pb-16 lg:pt-36 lg:pb-24 px-6 lg:px-16 overflow-hidden">
        <!-- Background Architectural Scrim -->
        <div class="absolute inset-0">
            <img 
                src="<?= $baseUrl ?>/assets/images/stitch/contact-chancery-salons.jpg" 
                alt="Elite Homez Diplomatic Client Reception Suite" 
                class="w-full h-full object-cover scale-105 transition-transform duration-1000"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-[#171A18]/95 via-[#243F34]/85 to-[#171A18]/70"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#171A18] via-transparent to-black/30"></div>
        </div>

        <div class="relative max-w-[1440px] mx-auto z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 font-['Manrope'] uppercase text-[0.7rem] tracking-[0.25em] text-[#DFCF9F]/80 mb-8" aria-label="Breadcrumb">
                <a class="hover:text-white transition-colors" href="<?= $baseUrl ?>/">Home</a>
                <span class="text-[#B99A62]">/</span>
                <span class="text-white font-semibold">Contact Us</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-end">
                <!-- 60% Editorial Narrative Column -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-[#B99A62]/40 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-[#B99A62] animate-pulse"></span>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.22em] text-[#DFCF9F] font-semibold">
                            Let's Connect
                        </span>
                    </div>

                    <h1 class="font-['Playfair_Display'] text-4xl sm:text-5xl lg:text-[4.25rem] text-white font-normal leading-[1.08] tracking-tight">
                        Exceptional Real Estate Experiences <br />
                        <span class="italic text-[#DFCF9F]">Begin with a Conversation.</span>
                    </h1>

                    <p class="font-['Plus_Jakarta_Sans'] text-base sm:text-lg lg:text-xl text-gray-200 font-light leading-relaxed max-w-xl">
                        Whether you are exploring a property, looking for the right address or seeking professional real-estate assistance, our team is here to help.
                    </p>

                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <a href="#enquiry-form" 
                           class="inline-flex items-center gap-3 px-8 py-4 bg-[#B99A62] hover:bg-[#A88B53] text-[#171A18] font-['Manrope'] text-xs uppercase tracking-[0.2em] font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-[#B99A62]/20">
                            <span>Send an Enquiry</span>
                            <span class="text-base">&darr;</span>
                        </a>
                        <a href="https://wa.me/<?= $waClean ?>?text=<?= urlencode('Hello Elite Homez Advisory Desk, I would like to schedule a confidential discussion regarding South Delhi property.') ?>" 
                           target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2.5 px-7 py-4 bg-white/10 hover:bg-white/20 text-white font-['Manrope'] text-xs uppercase tracking-[0.18em] font-semibold rounded-lg border border-white/20 backdrop-blur-md transition-all">
                            <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>WhatsApp Concierge</span>
                        </a>
                    </div>
                </div>

                <!-- 40% Hero Floating Contact Card -->
                <div class="lg:col-span-5">
                    <div class="bg-[#243F34]/90 backdrop-blur-xl p-8 rounded-2xl border border-[#B99A62]/35 shadow-2xl space-y-6">
                        <div class="flex items-center justify-between pb-4 border-b border-white/10">
                            <div>
                                <span class="font-['Manrope'] text-[0.65rem] uppercase tracking-[0.25em] text-[#DFCF9F] block font-semibold">Saket Executive Suites</span>
                                <h3 class="font-['Playfair_Display'] text-xl text-white font-medium">Senior Advisory Desk</h3>
                            </div>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#B99A62]/20 border border-[#B99A62]/40 text-[#DFCF9F]">
                                ✦
                            </span>
                        </div>

                        <!-- 4 Quick Desk Details -->
                        <div class="space-y-3 font-['Plus_Jakarta_Sans'] text-sm text-gray-200">
                            <div class="flex items-start gap-3">
                                <span class="text-[#DFCF9F] text-base">📍</span>
                                <div>
                                    <span class="block text-white font-medium"><?= Format::e($address) ?></span>
                                    <span class="text-xs text-gray-300">Square One Mall, Saket</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pt-1">
                                <span class="text-[#DFCF9F] text-base">📞</span>
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="tel:<?= $phoneClean ?>" class="text-white hover:text-[#DFCF9F] font-medium transition-colors">
                                            <?= Format::e($phone) ?>
                                        </a>
                                        <span class="text-[#DFCF9F]/50">|</span>
                                        <a href="tel:<?= $phoneSecondaryClean ?>" class="text-white hover:text-[#DFCF9F] font-medium transition-colors">
                                            <?= Format::e($phoneSecondary) ?>
                                        </a>
                                    </div>
                                    <span class="text-xs text-gray-400 block">Mon – Sat: 9:30 AM – 7:30 PM IST</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pt-1">
                                <span class="text-[#DFCF9F] text-base">✉️</span>
                                <div>
                                    <a href="mailto:<?= Format::e($email) ?>" class="text-white hover:text-[#DFCF9F] font-medium transition-colors">
                                        <?= Format::e($email) ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-white/10 flex items-center justify-between text-xs font-['Manrope'] text-[#DFCF9F]">
                            <span>RERA: <?= Format::e($rera) ?></span>
                            <span>•</span>
                            <span>Strict Bilateral NDA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         SECTION 2: PREMIUM ENQUIRY FORM & WHATSAPP SECTION
         "How Can We Assist You?"
         ============================================================ -->
    <section id="enquiry-form" class="w-full py-20 lg:py-28 px-6 lg:px-16 bg-[#FAF8F4] border-b border-[#D8CDBA]/40">
        <div class="max-w-[1440px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                
                <!-- Left 5-col: Authority & WhatsApp Contact Section -->
                <div class="lg:col-span-5 space-y-8">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2">
                            <span class="w-8 h-[1px] bg-[#B99A62]"></span>
                            <span class="font-['Manrope'] text-xs uppercase tracking-[0.25em] text-[#B99A62] font-bold">
                                Confidential Mandate
                            </span>
                        </div>
                        <h2 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-normal text-[#171A18] leading-tight">
                            How Can We Assist You?
                        </h2>
                        <p class="font-['Plus_Jakarta_Sans'] text-base text-[#4A504B] font-light leading-relaxed">
                            Share your requirement with complete assurance. Every enquiry is routed directly to a Senior Partner and handled under bilateral non-disclosure covenants.
                        </p>
                    </div>

                    <!-- Fiduciary Guarantees -->
                    <div class="space-y-4 pt-2 border-t border-[#D8CDBA]/40">
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#243F34] text-[#DFCF9F] flex items-center justify-center shrink-0 text-sm font-semibold">✓</div>
                            <div>
                                <h4 class="font-['Playfair_Display'] text-base text-[#171A18] font-medium">Dedicated Senior Partner Attention</h4>
                                <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#5C605D] font-light leading-relaxed">Your spatial criteria are managed directly by seasoned partners, never delegated to junior sales reps.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#243F34] text-[#DFCF9F] flex items-center justify-center shrink-0 text-sm font-semibold">✓</div>
                            <div>
                                <h4 class="font-['Playfair_Display'] text-base text-[#171A18] font-medium">100% Off-Market Discretion Protocol</h4>
                                <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#5C605D] font-light leading-relaxed">Generational estates, ambassadorial compounds, and silent family office transactions safeguarded.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#243F34] text-[#DFCF9F] flex items-center justify-center shrink-0 text-sm font-semibold">✓</div>
                            <div>
                                <h4 class="font-['Playfair_Display'] text-base text-[#171A18] font-medium">Forensic Title Diligence &amp; RERA Registered</h4>
                                <p class="font-['Plus_Jakarta_Sans'] text-xs text-[#5C605D] font-light leading-relaxed">Independent legal title vetting carried out under DLRERA2023A00892 compliance.</p>
                            </div>
                        </div>
                    </div>

                    <!-- WHATSAPP CONTACT SECTION (Requirement 5) -->
                    <div class="bg-[#243F34] text-white p-8 rounded-2xl shadow-xl space-y-4 border border-[#B99A62]/35">
                        <div class="flex items-center justify-between">
                            <span class="font-['Manrope'] text-xs uppercase tracking-[0.2em] text-[#DFCF9F] font-bold">Instant Concierge</span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#25D366]/20 text-[#25D366] text-[0.68rem] font-['Manrope'] font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#25D366] animate-pulse"></span>
                                Live On Active Duty
                            </span>
                        </div>

                        <h3 class="font-['Playfair_Display'] text-2xl text-white font-normal">
                            Prefer a Quick Conversation?
                        </h3>

                        <p class="font-['Plus_Jakarta_Sans'] text-sm text-gray-300 font-light leading-relaxed">
                            Connect with our team directly through WhatsApp for property-related enquiries, off-market briefs, or instant site consultation.
                        </p>

                        <div class="pt-2">
                            <a href="https://wa.me/<?= $waClean ?>?text=<?= urlencode('Hello Elite Homez Advisory Desk, I would like to enquire about South Delhi luxury properties.') ?>" 
                               target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center justify-center gap-2.5 w-full py-4 bg-[#25D366] hover:bg-[#20ba59] text-white font-['Manrope'] text-xs uppercase tracking-[0.18em] font-bold rounded-lg transition-all shadow-md">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                <span>Chat on WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right 7-col: Premium Enquiry Form (Requirement 4) -->
                <div class="lg:col-span-7 bg-white p-8 sm:p-12 rounded-3xl border border-[#D8CDBA]/60 shadow-xl space-y-8">
                    <div>
                        <span class="font-['Manrope'] text-xs uppercase tracking-[0.2em] text-[#B99A62] font-bold block mb-1">
                            Private Consultation Request
                        </span>
                        <h3 class="font-['Playfair_Display'] text-2xl sm:text-3xl text-[#171A18] font-normal">
                            Register Your Requirement
                        </h3>
                    </div>

                    <!-- Client Alert Banner (JS populated) -->
                    <div id="enquiryAlert" class="hidden p-4 rounded-xl text-xs font-['Manrope'] font-medium transition-all" role="alert"></div>

                    <form id="contactEnquiryForm" action="<?= $baseUrl ?>/enquire" method="POST" class="space-y-6">
                        <?= Csrf::field() ?>

                        <!-- Hidden Context Tracking -->
                        <input type="hidden" name="source_page" value="Contact Us Page">
                        <input type="hidden" name="return_url" value="<?= Format::e($_SERVER['REQUEST_URI'] ?? '/contact-us') ?>">
                        <?php if (!empty($prefillPropertyId)): ?>
                            <input type="hidden" name="property_id" value="<?= (int)$prefillPropertyId ?>">
                        <?php endif; ?>

                        <!-- Anti-Spam Honeypot -->
                        <div class="hidden" aria-hidden="true">
                            <label for="website_url_check">Leave empty</label>
                            <input type="text" name="website_url_check" id="website_url_check" tabindex="-1" autocomplete="off">
                        </div>

                        <!-- Row 1: Name & Mobile -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="formName" class="block font-['Manrope'] text-xs uppercase tracking-wider text-[#171A18] font-semibold">
                                    Full Name <span class="text-[#B99A62]">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="formName" 
                                    name="name" 
                                    required 
                                    placeholder="e.g. Yashvardhan Singhania"
                                    class="w-full px-4 py-3.5 bg-[#FAF8F4] border border-[#D8CDBA]/60 rounded-lg text-[#171A18] font-['Plus_Jakarta_Sans'] text-sm focus:outline-none focus:border-[#B99A62] focus:bg-white transition-all placeholder:text-gray-400"
                                >
                            </div>

                            <div class="space-y-2">
                                <label for="formMobile" class="block font-['Manrope'] text-xs uppercase tracking-wider text-[#171A18] font-semibold">
                                    Mobile Number <span class="text-[#B99A62]">*</span>
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3.5 bg-[#F5F1E8] border border-r-0 border-[#D8CDBA]/60 rounded-l-lg text-[#4A504B] font-['Manrope'] text-xs font-semibold">
                                        +91
                                    </span>
                                    <input 
                                        type="tel" 
                                        id="formMobile" 
                                        name="mobile" 
                                        required 
                                        placeholder="98100 00000"
                                        class="w-full px-4 py-3.5 bg-[#FAF8F4] border border-[#D8CDBA]/60 rounded-r-lg text-[#171A18] font-['Plus_Jakarta_Sans'] text-sm focus:outline-none focus:border-[#B99A62] focus:bg-white transition-all placeholder:text-gray-400"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Email -->
                        <div class="space-y-2">
                            <label for="formEmail" class="block font-['Manrope'] text-xs uppercase tracking-wider text-[#171A18] font-semibold">
                                Email Address <span class="text-[#B99A62]">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="formEmail" 
                                name="email" 
                                required 
                                placeholder="principals@familyoffice.com"
                                class="w-full px-4 py-3.5 bg-[#FAF8F4] border border-[#D8CDBA]/60 rounded-lg text-[#171A18] font-['Plus_Jakarta_Sans'] text-sm focus:outline-none focus:border-[#B99A62] focus:bg-white transition-all placeholder:text-gray-400"
                            >
                        </div>

                        <!-- Row 3: Enquiry Type -->
                        <div class="space-y-2">
                            <label class="block font-['Manrope'] text-xs uppercase tracking-wider text-[#171A18] font-semibold">
                                Enquiry Type <span class="text-[#B99A62]">*</span>
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <label class="flex items-center gap-2 p-3 bg-[#FAF8F4] border border-[#D8CDBA]/50 rounded-lg cursor-pointer hover:border-[#B99A62] transition-colors">
                                    <input type="radio" name="enquiry_type" value="Property Purchase" checked class="accent-[#243F34]">
                                    <span class="font-['Manrope'] text-xs font-medium text-[#171A18]">Purchase</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 bg-[#FAF8F4] border border-[#D8CDBA]/50 rounded-lg cursor-pointer hover:border-[#B99A62] transition-colors">
                                    <input type="radio" name="enquiry_type" value="Property Rental" <?= ($prefillType === 'rent') ? 'checked' : '' ?> class="accent-[#243F34]">
                                    <span class="font-['Manrope'] text-xs font-medium text-[#171A18]">Rental</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 bg-[#FAF8F4] border border-[#D8CDBA]/50 rounded-lg cursor-pointer hover:border-[#B99A62] transition-colors">
                                    <input type="radio" name="enquiry_type" value="Property Selling" class="accent-[#243F34]">
                                    <span class="font-['Manrope'] text-xs font-medium text-[#171A18]">Selling</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 bg-[#FAF8F4] border border-[#D8CDBA]/50 rounded-lg cursor-pointer hover:border-[#B99A62] transition-colors">
                                    <input type="radio" name="enquiry_type" value="General Enquiry" class="accent-[#243F34]">
                                    <span class="font-['Manrope'] text-xs font-medium text-[#171A18]">Advisory</span>
                                </label>
                            </div>
                        </div>

                        <!-- Row 4: Interested Location / Enclave -->
                        <div class="space-y-2">
                            <label for="formArea" class="block font-['Manrope'] text-xs uppercase tracking-wider text-[#171A18] font-semibold">
                                Prime Enclave of Interest
                            </label>
                            <select 
                                id="formArea" 
                                name="area_id" 
                                class="w-full px-4 py-3.5 bg-[#FAF8F4] border border-[#D8CDBA]/60 rounded-lg text-[#171A18] font-['Plus_Jakarta_Sans'] text-sm focus:outline-none focus:border-[#B99A62] focus:bg-white transition-all"
                            >
                                <option value="">Select Enclave (or All South Delhi)</option>
                                <?php foreach ($areasList as $ar): ?>
                                    <option value="<?= (int)$ar['id'] ?>" <?= ($prefillArea === $ar['slug']) ? 'selected' : '' ?>>
                                        <?= Format::e($ar['name']) ?> Enclave
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Row 5: Message -->
                        <div class="space-y-2">
                            <label for="formMessage" class="block font-['Manrope'] text-xs uppercase tracking-wider text-[#171A18] font-semibold">
                                Message &amp; Spatial Imperatives <span class="text-[#B99A62]">*</span>
                            </label>
                            <textarea 
                                id="formMessage" 
                                name="message" 
                                required 
                                rows="4" 
                                placeholder="Describe your residential preferences (e.g. plot size, floor, orientation, timeline, or reference number)..."
                                class="w-full p-4 bg-[#FAF8F4] border border-[#D8CDBA]/60 rounded-lg text-[#171A18] font-['Plus_Jakarta_Sans'] text-sm focus:outline-none focus:border-[#B99A62] focus:bg-white transition-all placeholder:text-gray-400"
                            ><?= !empty($prefillSubject) ? "Regarding: " . Format::e($prefillSubject) . "\n\n" : "" ?></textarea>
                        </div>

                        <!-- Row 6: Bilateral NDA Request Checkbox -->
                        <div class="flex items-start gap-3 pt-1">
                            <input 
                                type="checkbox" 
                                id="formNda" 
                                name="nda_requested" 
                                value="1"
                                class="mt-1 w-4 h-4 accent-[#243F34] cursor-pointer"
                            >
                            <label for="formNda" class="font-['Plus_Jakarta_Sans'] text-xs text-[#5C605D] leading-relaxed cursor-pointer">
                                I request a formal bilateral non-disclosure agreement (NDA) executed prior to reviewing confidential off-market property dossiers.
                            </label>
                        </div>

                        <!-- Submit Button with Loading State -->
                        <button 
                            type="submit" 
                            id="submitEnquiryBtn"
                            class="w-full py-4 px-8 bg-[#243F34] hover:bg-[#1B3128] text-white font-['Manrope'] text-xs uppercase tracking-[0.2em] font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-[#243F34]/20 flex items-center justify-center gap-3 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span id="btnText">Submit Enquiry</span>
                            <span id="btnSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                            <span id="btnArrow">&rarr;</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

</div>

<!-- Client-side Interactive AJAX Form Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactEnquiryForm');
    const submitBtn = document.getElementById('submitEnquiryBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');
    const btnArrow = document.getElementById('btnArrow');
    const alertBox = document.getElementById('enquiryAlert');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear previous alerts
            alertBox.classList.add('hidden');
            alertBox.className = 'p-4 rounded-xl text-xs font-[\'Manrope\'] font-medium transition-all hidden';

            // Basic Client Validation
            const name = document.getElementById('formName').value.trim();
            const mobile = document.getElementById('formMobile').value.trim();
            const email = document.getElementById('formEmail').value.trim();
            const message = document.getElementById('formMessage').value.trim();

            if (!name || name.length < 2) {
                showAlert('Please enter your full name.', 'error');
                document.getElementById('formName').focus();
                return;
            }

            if (!mobile || !/^[0-9+\s\-()]{8,20}$/.test(mobile)) {
                showAlert('Please enter a valid telephone or mobile contact number.', 'error');
                document.getElementById('formMobile').focus();
                return;
            }

            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showAlert('Please provide a valid email address for correspondence.', 'error');
                document.getElementById('formEmail').focus();
                return;
            }

            if (!message || message.length < 5) {
                showAlert('Please provide a brief message regarding your property requirements.', 'error');
                document.getElementById('formMessage').focus();
                return;
            }

            // Set Loading State
            submitBtn.disabled = true;
            btnText.textContent = 'Submitting Confidential Enquiry...';
            btnSpinner.classList.remove('hidden');
            btnArrow.classList.add('hidden');

            const formData = new FormData(contactForm);

            // Fetch request with X-Requested-With header to trigger isAjax()
            fetch(contactForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(res) {
                return res.json().catch(function() {
                    return { success: false, message: 'Server communication error. Please call our senior desk directly.' };
                });
            })
            .then(function(data) {
                if (data.success) {
                    showAlert(data.message || 'Thank you. Your enquiry has been received by our senior desk.', 'success');
                    contactForm.reset();
                    // Scroll alert into view smoothly
                    alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    showAlert(data.message || 'Unable to submit enquiry. Please verify your details or phone our desk.', 'error');
                }
            })
            .catch(function(err) {
                showAlert('A network error occurred. Please telephone our Senior Advisory Desk at <?= Format::e($phone) ?>.', 'error');
            })
            .finally(function() {
                submitBtn.disabled = false;
                btnText.textContent = 'Submit Enquiry';
                btnSpinner.classList.add('hidden');
                btnArrow.classList.remove('hidden');
            });
        });
    }

    function showAlert(msg, type) {
        alertBox.textContent = msg;
        alertBox.classList.remove('hidden');
        if (type === 'success') {
            alertBox.classList.add('bg-[#243F34]/10', 'text-[#243F34]', 'border', 'border-[#243F34]/30');
        } else {
            alertBox.classList.add('bg-red-50', 'text-red-800', 'border', 'border-red-200');
        }
    }
});
</script>
