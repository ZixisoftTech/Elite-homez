-- ============================================================
-- ELITE HOMEZ — DATABASE MIGRATION
-- Add Show on Home Page Tags to Services & Areas
-- Create Dynamic Carousel Slides Table
-- ============================================================

-- 1. Add show_on_home to services if not exists
SET @exist_services := (
    SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE() 
    AND table_name = 'services' 
    AND column_name = 'show_on_home'
);
SET @sql_services := IF(@exist_services = 0, 
    'ALTER TABLE services ADD COLUMN show_on_home TINYINT(1) NOT NULL DEFAULT 0 AFTER is_published, ADD INDEX idx_services_home (show_on_home, is_published)', 
    'SELECT "Column show_on_home already exists in services"'
);
PREPARE stmt_services FROM @sql_services;
EXECUTE stmt_services;
DEALLOCATE PREPARE stmt_services;

-- 2. Add show_on_home to areas if not exists
SET @exist_areas := (
    SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE() 
    AND table_name = 'areas' 
    AND column_name = 'show_on_home'
);
SET @sql_areas := IF(@exist_areas = 0, 
    'ALTER TABLE areas ADD COLUMN show_on_home TINYINT(1) NOT NULL DEFAULT 0 AFTER is_published, ADD INDEX idx_areas_home (show_on_home, is_published)', 
    'SELECT "Column show_on_home already exists in areas"'
);
PREPARE stmt_areas FROM @sql_areas;
EXECUTE stmt_areas;
DEALLOCATE PREPARE stmt_areas;

-- 3. Create carousel_slides table
CREATE TABLE IF NOT EXISTS carousel_slides (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle TEXT NULL,
    eyebrow VARCHAR(150) NULL DEFAULT 'CONFIDENTIAL ADVISORY · PRIVATE MANDATES',
    image VARCHAR(255) NOT NULL,
    dossier_title VARCHAR(255) NULL,
    badge_text VARCHAR(100) NULL DEFAULT 'Off-Market Mandate',
    primary_btn_text VARCHAR(100) NULL DEFAULT 'Explore Properties',
    primary_btn_url VARCHAR(255) NULL DEFAULT '/properties',
    secondary_btn_text VARCHAR(100) NULL DEFAULT 'Speak With an Advisor',
    secondary_btn_url VARCHAR(255) NULL DEFAULT '/contact-us',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_carousel_active_sort (is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tag initial services for homepage
UPDATE services SET show_on_home = 1 WHERE is_published = 1 LIMIT 4;

-- 5. Tag initial areas for homepage
UPDATE areas SET show_on_home = 1 WHERE slug IN ('vasant-vihar', 'jor-bagh', 'golf-links', 'chanakyapuri');

-- 6. Seed initial carousel slides if empty
INSERT INTO carousel_slides (title, subtitle, eyebrow, image, dossier_title, badge_text, primary_btn_text, primary_btn_url, secondary_btn_text, secondary_btn_url, is_active, sort_order)
SELECT 'Exceptional Homes.<br><span class="stitch-gold-italic">Exceptional Living.</span>', 
       'Trusted expertise for distinguished properties and meaningful real-estate decisions across India\'s most prestigious capital enclaves.',
       'CONFIDENTIAL ADVISORY · PRIVATE MANDATES',
       '/assets/images/stitch/hero-residence.jpg',
       'Chanakyapuri & Vasant Vihar Enclave',
       'Off-Market Mandate',
       'Explore Properties',
       '/properties',
       'Speak With an Advisor',
       '/contact-us',
       1,
       1
WHERE NOT EXISTS (SELECT 1 FROM carousel_slides LIMIT 1);

INSERT INTO carousel_slides (title, subtitle, eyebrow, image, dossier_title, badge_text, primary_btn_text, primary_btn_url, secondary_btn_text, secondary_btn_url, is_active, sort_order)
SELECT 'Discreet Acquisitions.<br><span class="stitch-gold-italic">Generational Trust.</span>', 
       'Navigating off-market trophy estates and diplomatic enclaves with absolute discretion and forensic title verification.',
       'PRIVATE WEALTH & FAMILY OFFICE PRACTICE',
       '/assets/images/stitch/golf-links-villa.jpg',
       'The Fairway Promenade · Golf Links',
       'Trophy Asset Division',
       'View Curated Portfolio',
       '/properties',
       'Schedule Consultation',
       '/contact-us',
       1,
       2
WHERE (SELECT COUNT(*) FROM carousel_slides) = 1;

INSERT INTO carousel_slides (title, subtitle, eyebrow, image, dossier_title, badge_text, primary_btn_text, primary_btn_url, secondary_btn_text, secondary_btn_url, is_active, sort_order)
SELECT 'Architectural Rigor.<br><span class="stitch-gold-italic">Sovereign Addresses.</span>', 
       'Over two decades representing discerning buyers, embassies, and industrial families in Lutyens\' Delhi and Southern Ridge enclaves.',
       'ESTABLISHED 2004 · TWO DECADES OF INTEGRITY',
       '/assets/images/stitch/jor-bagh-bungalow.jpg',
       'Botanical Perimeter · Jor Bagh Heritage',
       '100% Verified Title',
       'Explore Enclaves',
       '/about-us',
       'Direct Partner Line',
       '/contact-us',
       1,
       3
WHERE (SELECT COUNT(*) FROM carousel_slides) = 2;
