<?php
use App\Helpers\Format;

$settings = $siteSettings ?? [];
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$waClean = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($waClean) === 10) {
    $waClean = '91' . $waClean;
}
$waUrl = 'https://wa.me/' . $waClean . '?text=' . urlencode('Hello Elite Homez, I would like to enquire about your luxury property portfolio.');
?>
<!-- STICKY DIRECT CONNECT WHATSAPP BUTTON -->
<div id="sticky-whatsapp-widget" class="fixed bottom-6 right-6 z-[9999] flex items-center group pointer-events-auto">
    <!-- Pulsing Radar Glow -->
    <span class="absolute right-0 w-14 h-14 rounded-full bg-[#25D366]/30 animate-ping -z-10 pointer-events-none"></span>

    <a 
        href="<?= $waUrl ?>" 
        target="_blank" 
        rel="noopener noreferrer"
        class="flex items-center gap-3 bg-gradient-to-r from-[#25D366] to-[#1EA952] text-white px-4 py-3.5 sm:px-5 sm:py-3.5 rounded-full shadow-[0_10px_30px_rgba(37,211,102,0.45)] hover:shadow-[0_14px_35px_rgba(37,211,102,0.65)] hover:scale-105 active:scale-95 transition-all duration-300 border border-[#DFCF9F]/70 backdrop-blur-sm group cursor-pointer no-underline"
        aria-label="Direct WhatsApp Concierge (+91 9811044200)"
        title="Direct WhatsApp Concierge (+91 9811044200)"
    >
        <!-- Icon Container with Online Live Badge -->
        <div class="relative flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 sm:w-6 sm:h-6 fill-white drop-shadow-sm" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
            </svg>
            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-[#DFCF9F] border-2 border-[#243F34] animate-pulse"></span>
        </div>

        <!-- Text Label (Visible on all screens with luxury formatting) -->
        <div class="flex flex-col text-left pr-1">
            <span class="font-['Manrope'] text-[0.6rem] uppercase tracking-[0.22em] text-[#DFCF9F] font-bold leading-none mb-0.5">
                Direct Connect
            </span>
            <span class="font-['Plus_Jakarta_Sans'] text-xs font-bold text-white tracking-wide leading-tight flex items-center gap-1">
                WhatsApp Us
                <svg class="w-3.5 h-3.5 text-[#DFCF9F] transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </span>
        </div>
    </a>
</div>
