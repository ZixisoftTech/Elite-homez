<?php
use App\Helpers\Format;
use App\Helpers\SvgIcons;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];

$areas = $navAreas ?? [];
$services = $navServices ?? [];
$settings = $siteSettings ?? [];
$phone = $settings['phone_primary'] ?? '+91 9811044200';
$phoneClean = preg_replace('/[^0-9\+]/', '', $phone);
$waNum = $settings['whatsapp_number'] ?? '9811044200';
$waClean = preg_replace('/[^0-9]/', '', $waNum);
if (strlen($waClean) === 10) {
    $waClean = '91' . $waClean;
}
$rawUri = $_SERVER['REQUEST_URI'] ?? '/';
$basePath = $config['base_path'] ?? '';
$currentPath = parse_url($rawUri, PHP_URL_PATH) ?? '/';
if (!empty($basePath) && str_starts_with($currentPath, $basePath)) {
    $currentPath = substr($currentPath, strlen($basePath));
}
$currentPath = '/' . ltrim($currentPath, '/');
?>
<!-- ELITE HOMEZ BESPOKE FLOATING LUXURY HEADER -->
<div class="site-header-wrapper" id="siteHeaderWrapper">
    <header class="site-header" id="siteHeader">
        <div class="site-header-container">
            <!-- Left: Official Logo in Crisp Protected Pill -->
            <a href="<?= $baseUrl ?>/" class="site-logo" title="Elite Homez — your trust, our responsibility.">
                <div class="logo-pill">
                    <img src="<?= $baseUrl ?>/assets/images/logo.png" alt="Elite Homez — your trust, our responsibility." width="176" height="64" class="logo-img">
                </div>
            </a>

            <!-- Center: Perfectly Aligned Refined Desktop Navigation -->
            <nav class="desktop-nav" aria-label="Main Navigation">
                <a href="<?= $baseUrl ?>/" class="nav-link <?= ($currentPath === '/' || $currentPath === '') ? 'active' : '' ?>">
                    <span>Home</span>
                </a>
                
                <a href="<?= $baseUrl ?>/about-us" class="nav-link <?= str_starts_with($currentPath, '/about-us') ? 'active' : '' ?>">
                    <span>About Us</span>
                </a>

                <!-- Dynamic Properties Dropdown (For Sale & For Rent) -->
                <div class="nav-item-has-dropdown">
                    <a href="<?= $baseUrl ?>/properties" class="nav-link <?= str_starts_with($currentPath, '/properties') ? 'active' : '' ?>" aria-haspopup="true" aria-expanded="false">
                        <span>Properties</span>
                        <svg class="dropdown-caret" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="nav-dropdown" role="menu">
                        <div class="nav-dropdown-inner">
                            <div class="dropdown-eyebrow">Curated Portfolio</div>
                            <a href="<?= $baseUrl ?>/properties?type=sale" class="dropdown-link" role="menuitem">
                                <div class="dropdown-link-title" style="display: flex; align-items: center; justify-content: space-between;">
                                    <span>Properties For Sale</span>
                                    <span style="font-size: 0.625rem; letter-spacing: 0.05em; padding: 2px 7px; border-radius: 9999px; background: rgba(185, 154, 98, 0.2); color: #B99A62; font-weight: 700; border: 1px solid rgba(185, 154, 98, 0.3);">BUY</span>
                                </div>
                                <div class="dropdown-link-desc">Prime independent bungalows, luxury builder floors & penthouses.</div>
                            </a>
                            <a href="<?= $baseUrl ?>/properties?type=rent" class="dropdown-link" role="menuitem">
                                <div class="dropdown-link-title" style="display: flex; align-items: center; justify-content: space-between;">
                                    <span>Properties For Rent</span>
                                    <span style="font-size: 0.625rem; letter-spacing: 0.05em; padding: 2px 7px; border-radius: 9999px; background: rgba(36, 63, 52, 0.6); color: #DFCF9F; font-weight: 700; border: 1px solid rgba(223, 207, 159, 0.3);">RENT</span>
                                </div>
                                <div class="dropdown-link-desc">Diplomatic, expat, and high-net-worth luxury leasing mandates.</div>
                            </a>
                            <div style="border-top: 1px solid rgba(224, 215, 201, 0.15); margin-top: 0.5rem; padding-top: 0.5rem;">
                                <a href="<?= $baseUrl ?>/properties" class="dropdown-link" role="menuitem" style="padding-top: 0.35rem; padding-bottom: 0.35rem;">
                                    <div class="dropdown-link-title" style="color: #B99A62; font-size: 0.8rem; display: flex; align-items: center; justify-content: space-between;">
                                        <span>Explore All Properties</span>
                                        <span style="font-family: monospace;">&rarr;</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Dynamic Services Dropdown -->
                <div class="nav-item-has-dropdown">
                    <a href="<?= $baseUrl ?>/services" class="nav-link <?= str_starts_with($currentPath, '/services') ? 'active' : '' ?>" aria-haspopup="true" aria-expanded="false">
                        <span>Services</span>
                        <svg class="dropdown-caret" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="nav-dropdown" role="menu">
                        <div class="nav-dropdown-inner">
                            <div class="dropdown-eyebrow">Advisory Services</div>
                            <?php foreach ($services as $serv): ?>
                                <a href="<?= $baseUrl ?>/services/<?= Format::e($serv['slug']) ?>" class="dropdown-link" role="menuitem">
                                    <div class="dropdown-link-title"><?= Format::e($serv['name']) ?></div>
                                    <?php if (!empty($serv['short_description'])): ?>
                                        <div class="dropdown-link-desc"><?= Format::e(substr(strip_tags($serv['short_description']), 0, 65)) ?>...</div>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Locations / Service Areas Dropdown -->
                <div class="nav-item-has-dropdown">
                    <a href="<?= $baseUrl ?>/locations" class="nav-link <?= (str_starts_with($currentPath, '/locations') || str_starts_with($currentPath, '/areas')) ? 'active' : '' ?>" aria-haspopup="true" aria-expanded="false">
                        <span>Locations</span>
                        <svg class="dropdown-caret" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="nav-dropdown" role="menu">
                        <div class="nav-dropdown-inner">
                            <div class="dropdown-eyebrow">South Delhi Prime Enclaves</div>
                            <?php foreach ($areas as $area): ?>
                                <a href="<?= $baseUrl ?>/locations/<?= Format::e($area['slug']) ?>" class="dropdown-link" role="menuitem">
                                    <div class="dropdown-link-title"><?= Format::e($area['name']) ?></div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <a href="<?= $baseUrl ?>/contact-us" class="nav-link <?= str_starts_with($currentPath, '/contact-us') ? 'active' : '' ?>">
                    <span>Contact Us</span>
                </a>
            </nav>

            <!-- Right: Direct Telephone & Champagne Gold Pill CTA -->
            <div class="header-action-group">
                <a href="tel:<?= $phoneClean ?>" class="header-phone" title="Senior Advisory Desk">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    <span><?= Format::e($phone) ?></span>
                </a>

                <?php $headerEnquireLink = ($currentPath === '/' || $currentPath === '') ? '#confidential-desk' : $baseUrl . '/contact-us'; ?>
                <a href="<?= $headerEnquireLink ?>" class="btn-header-enquire" id="headerEnquireBtn">
                    <span>Enquire Now</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>

                <!-- Mobile Navigation Trigger -->
                <button type="button" class="mobile-menu-trigger" id="mobileMenuBtn" aria-label="Open Navigation Menu" aria-expanded="false" aria-controls="mobileDrawer">
                    <span class="hamburger-box">
                        <span class="hamburger-line line-1"></span>
                        <span class="hamburger-line line-2"></span>
                    </span>
                </button>
            </div>
        </div>
    </header>
</div>

<!-- POLISHED LUXURY MOBILE NAVIGATION DRAWER -->
<div class="mobile-drawer-overlay" id="mobileDrawerOverlay"></div>
<div class="mobile-drawer" id="mobileDrawer" role="dialog" aria-modal="true" aria-label="Mobile Navigation">
    <div class="drawer-header">
        <div class="logo-pill">
            <img src="<?= $baseUrl ?>/assets/images/logo.png" alt="Elite Homez" height="38" class="logo-img">
        </div>
        <button type="button" class="drawer-close-btn" id="drawerCloseBtn" aria-label="Close Navigation">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="drawer-content">
        <div class="drawer-eyebrow">NAVIGATION</div>
        <nav class="drawer-nav">
            <a href="<?= $baseUrl ?>/" class="drawer-link <?= ($currentPath === '/' || $currentPath === '') ? 'active' : '' ?>">Home</a>
            <a href="<?= $baseUrl ?>/about-us" class="drawer-link <?= str_starts_with($currentPath, '/about-us') ? 'active' : '' ?>">About Us</a>
            <!-- Properties in Drawer with Dropdown Accordion -->
            <div class="drawer-accordion">
                <div class="drawer-accordion-header">
                    <a href="<?= $baseUrl ?>/properties" class="drawer-accordion-title <?= str_starts_with($currentPath, '/properties') ? 'active' : '' ?>" style="text-decoration:none;">Properties</a>
                    <a href="<?= $baseUrl ?>/properties" class="drawer-all-link">All &rarr;</a>
                </div>
                <div class="drawer-subnav">
                    <a href="<?= $baseUrl ?>/properties?type=sale" class="drawer-sublink <?= ($currentPath === '/properties' && ($_GET['type'] ?? '') === 'sale') ? 'active' : '' ?>">
                        Properties For Sale (Buy)
                    </a>
                    <a href="<?= $baseUrl ?>/properties?type=rent" class="drawer-sublink <?= ($currentPath === '/properties' && ($_GET['type'] ?? '') === 'rent') ? 'active' : '' ?>">
                        Properties For Rent (Lease)
                    </a>
                </div>
            </div>
            
            <!-- Services in Drawer -->
            <div class="drawer-accordion">
                <div class="drawer-accordion-header">
                    <a href="<?= $baseUrl ?>/services" class="drawer-accordion-title <?= ($currentPath === '/services') ? 'active' : '' ?>" style="text-decoration:none;">Services</a>
                    <a href="<?= $baseUrl ?>/services" class="drawer-all-link">All &rarr;</a>
                </div>
                <div class="drawer-subnav">
                    <?php foreach ($services as $serv): ?>
                        <a href="<?= $baseUrl ?>/services/<?= Format::e($serv['slug']) ?>" class="drawer-sublink <?= ($currentPath === '/services/' . $serv['slug']) ? 'active' : '' ?>">
                            <?= Format::e($serv['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Locations in Drawer -->
            <div class="drawer-accordion">
                <div class="drawer-accordion-header">
                    <span class="drawer-accordion-title">Locations</span>
                    <a href="<?= $baseUrl ?>/locations" class="drawer-all-link">All Enclaves &rarr;</a>
                </div>
                <div class="drawer-subnav">
                    <?php foreach ($areas as $area): ?>
                        <a href="<?= $baseUrl ?>/locations/<?= Format::e($area['slug']) ?>" class="drawer-sublink <?= ($currentPath === '/locations/' . $area['slug']) ? 'active' : '' ?>">
                            <?= Format::e($area['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <a href="<?= $baseUrl ?>/contact-us" class="drawer-link <?= str_starts_with($currentPath, '/contact-us') ? 'active' : '' ?>">Contact Us</a>
        </nav>

        <div class="drawer-footer-actions">
            <div class="drawer-tagline">"your trust, our responsibility."</div>
            <a href="https://wa.me/<?= $waClean ?>?text=<?= urlencode('Hello Elite Homez, I would like to enquire about your luxury property portfolio.') ?>" target="_blank" rel="noopener noreferrer" class="btn-drawer-wa">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>WhatsApp Advisor</span>
            </a>
            <a href="tel:<?= $phoneClean ?>" class="btn-drawer-phone">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                <span>Call <?= Format::e($phone) ?></span>
            </a>
        </div>
    </div>
</div>
