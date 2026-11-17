<?php
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$areas = $navAreas ?? [];
$services = $navServices ?? [];
$settings = $siteSettings ?? [];

$brandDesc = $settings['footer_brand_text'] ?? 'Elite Homez is an independent bespoke property advisory firm orchestrating the acquisition, disposition, and structured valuation of premier residential assets and prime generational estates across South Delhi.';
$phone = $settings['phone_primary'] ?? '+91 9811044200';
$phoneClean = preg_replace('/[^0-9\+]/', '', $phone);
$phone2 = $settings['phone_secondary'] ?? '+91 98112 88400';
$phone2Clean = preg_replace('/[^0-9\+]/', '', $phone2);
$email = $settings['email_primary'] ?? 'info@elitehomez.com';
$address = $settings['office_address'] ?? '225, 2nd Floor, Square One Mall, Saket, New Delhi - 110017 (India)';
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$waClean = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($waClean) === 10) {
    $waClean = '91' . $waClean;
}
$waDisplay = $settings['whatsapp_display'] ?? '+91 98110 44200';
$rera = $settings['rera_number'] ?? 'DLRERA2023A00892';
?>
<footer class="site-footer">
    <!-- Top Accent Hairline -->
    <div class="footer-top-accent"></div>

    <div class="site-container">
        <div class="footer-grid">
            <!-- Col 1: Brand & Official Logo -->
            <div class="footer-col-brand">
                <div class="footer-logo-wrap">
                    <div class="logo-pill">
                        <img src="<?= $baseUrl ?>/assets/images/logo.png" alt="Elite Homez — your trust, our responsibility." width="176" height="64" class="logo-img">
                    </div>
                </div>
                <div class="footer-motto">
                    <span class="motto-quote">"your trust, our responsibility."</span>
                </div>
                <p class="footer-description">
                    <?= Format::e($brandDesc) ?>
                </p>
                <div class="footer-statutory-pill">
                    <span class="statutory-dot"></span>
                    <span class="statutory-text">RERA Reg: <?= Format::e($rera) ?></span>
                </div>
            </div>

            <!-- Col 2: Navigation -->
            <div class="footer-col">
                <span class="footer-heading">Navigation</span>
                <ul class="footer-links">
                    <li><a href="<?= $baseUrl ?>/">Home</a></li>
                    <li><a href="<?= $baseUrl ?>/about-us">About Us</a></li>
                    <li><a href="<?= $baseUrl ?>/properties">Curated Properties</a></li>
                    <li><a href="<?= $baseUrl ?>/locations">South Delhi Enclaves</a></li>
                    <li><a href="<?= $baseUrl ?>/contact-us">Contact Advisory Desk</a></li>
                    <li><a href="<?= $baseUrl ?>/properties?type=bungalow">Bungalows &amp; Estates</a></li>
                </ul>
            </div>

            <!-- Col 3: Services -->
            <div class="footer-col">
                <span class="footer-heading">Advisory Services</span>
                <ul class="footer-links">
                    <li><a href="<?= $baseUrl ?>/services/buy-property">Buy Property</a></li>
                    <li><a href="<?= $baseUrl ?>/services/sell-property">Sell Property</a></li>
                    <li><a href="<?= $baseUrl ?>/services/rent-property">Rent Property</a></li>
                    <li><a href="<?= $baseUrl ?>/services/property-advisory">Property Advisory</a></li>
                    <li><a href="<?= $baseUrl ?>/contact-us">Family Office Services</a></li>
                    <li><a href="<?= $baseUrl ?>/contact-us">Private Off-Market Briefs</a></li>
                </ul>
            </div>

            <!-- Col 4: Prime Enclaves -->
            <div class="footer-col">
                <span class="footer-heading">Prime Enclaves</span>
                <ul class="footer-links">
                    <li><a href="<?= $baseUrl ?>/locations/vasant-vihar">Vasant Vihar</a></li>
                    <li><a href="<?= $baseUrl ?>/locations/jor-bagh">Jor Bagh</a></li>
                    <li><a href="<?= $baseUrl ?>/locations/golf-links">Golf Links</a></li>
                    <li><a href="<?= $baseUrl ?>/locations/chanakyapuri">Chanakyapuri</a></li>
                    <li><a href="<?= $baseUrl ?>/locations/hauz-khas">Hauz Khas</a></li>
                    <li><a href="<?= $baseUrl ?>/locations" class="footer-link-highlight">Explore All 9 Enclaves &rarr;</a></li>
                </ul>
            </div>

            <!-- Col 5: Private Desk -->
            <div class="footer-col footer-col-desk">
                <span class="footer-heading">Senior Desk</span>
                <div class="footer-desk-details">
                    <div class="desk-item">
                        <span class="desk-label">Telephone</span>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.35rem; align-items: center;">
                            <a href="tel:<?= $phoneClean ?>" class="desk-val phone-highlight"><?= Format::e($phone) ?></a>
                            <span style="color: rgba(224, 215, 201, 0.4);">|</span>
                            <a href="tel:<?= $phone2Clean ?>" class="desk-val phone-highlight"><?= Format::e($phone2) ?></a>
                        </div>
                    </div>
                    <div class="desk-item">
                        <span class="desk-label">Confidential Email</span>
                        <a href="mailto:<?= Format::e($email) ?>" class="desk-val"><?= Format::e($email) ?></a>
                    </div>
                    <div class="desk-item">
                        <span class="desk-label">WhatsApp Concierge</span>
                        <a href="https://wa.me/<?= $waClean ?>?text=<?= urlencode('Hello Elite Homez, I would like to enquire about your luxury property portfolio.') ?>" target="_blank" rel="noopener noreferrer" class="desk-val wa-highlight">
                            <?= Format::e($waDisplay) ?> &rarr;
                        </a>
                    </div>
                    <div class="desk-item">
                        <span class="desk-label">Office Location</span>
                        <p class="desk-address"><?= Format::e($address) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discretion & Legal Bar -->
        <div class="footer-bottom-bar">
            <div class="footer-bottom-left">
                <span class="nda-badge">✦ All advisory mandates conducted under strict bilateral non-disclosure agreements.</span>
            </div>
            <div class="footer-bottom-right">
                <a href="<?= $baseUrl ?>/privacy-policy">Privacy Policy</a>
                <span class="bottom-sep">•</span>
                <a href="<?= $baseUrl ?>/terms-and-disclaimer">Terms &amp; Disclaimer</a>
                <span class="bottom-sep">•</span>
                <span>&copy; <?= date('Y') ?> Elite Homez. All Rights Reserved.</span>
            </div>
        </div>
    </div>
</footer>
