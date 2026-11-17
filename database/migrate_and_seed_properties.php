<?php
declare(strict_types=1);

/**
 * Migration and Seeder for Stitch Properties & Dossier Fields
 */

$host = '127.0.0.1';
$port = 3306;
$dbname = 'elite_homez';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Connected successfully to elite_homez database.\n";

// 1. Check and add columns
$existingColumns = [];
$stmt = $pdo->query("SHOW COLUMNS FROM properties");
while ($row = $stmt->fetch()) {
    $existingColumns[$row['Field']] = true;
}

$columnsToAdd = [
    'mandate_ref' => "VARCHAR(100) NULL AFTER slug",
    'rera_number' => "VARCHAR(100) NULL DEFAULT 'DLRERA2023A00892' AFTER mandate_ref",
    'sub_title' => "VARCHAR(255) NULL AFTER title",
    'orientation' => "VARCHAR(100) NULL AFTER floor_info",
    'ceiling_height' => "VARCHAR(50) NULL AFTER orientation",
    'architect_info' => "VARCHAR(150) NULL AFTER ceiling_height",
    'coordinates' => "VARCHAR(100) NULL AFTER google_map_url",
    'provenance_quote' => "TEXT NULL AFTER description",
    'lifestyle_quote' => "TEXT NULL AFTER provenance_quote"
];

foreach ($columnsToAdd as $col => $definition) {
    if (!isset($existingColumns[$col])) {
        $pdo->exec("ALTER TABLE properties ADD COLUMN {$col} {$definition}");
        echo "Added column {$col} to properties table.\n";
    } else {
        echo "Column {$col} already exists.\n";
    }
}

// 2. Fetch area IDs
$areaStmt = $pdo->query("SELECT id, slug FROM areas");
$areaMap = [];
while ($row = $areaStmt->fetch()) {
    $areaMap[$row['slug']] = (int)$row['id'];
}

// Ensure default fallback area
$defaultAreaId = reset($areaMap) ?: 1;

// 3. Define curated residences matching Stitch screens
$curatedProperties = [
    [
        'slug' => 'contemporary-penthouse-duplex-vasant-vihar',
        'title' => 'Contemporary Penthouse Duplex',
        'sub_title' => 'Block C, Diplomatic Enclave, Vasant Vihar, New Delhi',
        'mandate_ref' => 'EH-VV-408',
        'rera_number' => 'DLRERA2023A00892',
        'area_slug' => 'vasant-vihar',
        'property_type' => 'Ultra-Luxury Penthouse Duplex',
        'listing_type' => 'sale',
        'price' => 185000000.00,
        'price_display' => '₹ 18.50 Cr',
        'property_size' => '4,800 sq. ft.',
        'plot_size' => '6,500 sq. ft. parcel apportionment',
        'bedrooms' => 4,
        'bathrooms' => 5,
        'parking_spaces' => 4,
        'floor_info' => 'Levels 03 & 04 + Private Rooftop Deck',
        'orientation' => 'North-East Facing · Vastu Certified',
        'ceiling_height' => '2.80m Clearance',
        'architect_info' => 'Studio Khosla Architects · Completed 2023',
        'property_location' => 'Block C, Vasant Vihar, New Delhi',
        'google_map_url' => 'https://maps.google.com/?q=Vasant+Vihar+New+Delhi',
        'coordinates' => '28.5672° N, 77.1595° E',
        'description' => "Commissioned by an international connoisseur and conceived by premier architectural masters, this duplex penthouse represents an uncompromising synergy of contemporary monumental architecture and residential warmth across Levels 03 and 04, culminating in an exclusive private rooftop observatory deck. Entry is orchestrated via an encrypted, high-speed biometric elevator that opens directly into a bespoke fluted travertine vestibule.\n\nThe salon spans double-height volume with monolithic Roman travertine walls imported directly from Tivoli quarries. Double-glazed acoustic glass assemblies frame verdant views of mature neem and amaltas trees, muting urban ambience while admitting soft morning eastern light. A bespoke sculptural brass lighting installation anchors the formal entertaining pavilion.\n\nA dedicated culinary laboratory featuring custom Valcucine matte quartzite casework and integrated Gaggenau appliances connects seamlessly with a discreet secondary butler’s wet kitchen, dedicated service staff quarters, and separate freight lifts. The private suite level hosts four cavernous en-suite retreats, each finished with smoked European oak parquet, custom Poliform dressers, and continuous bookmatched Statuario marble baths.",
        'provenance_quote' => '"Curated geometry paired with raw, tactile travertine creates an acoustic stillness unique to South Delhi\'s diplomatic zone."',
        'lifestyle_quote' => 'A legacy asset crafted with timeless Dholpur stone and Italian travertine, overlooking the centuries-old canopy of South Delhi.',
        'featured_image' => '/assets/images/stitch/detail-hero-greatroom.jpg',
        'is_featured' => 1,
        'status' => 'published',
        'sort_order' => 1,
        'seo_title' => 'Contemporary Penthouse Duplex | Vasant Vihar | Elite Homez',
        'meta_description' => 'Ultra-luxury 4 BHK Penthouse Duplex in Block C, Vasant Vihar. 4,800 sq. ft., private elevator, double-height travertine salon, rooftop lap pool.',
        'gallery' => [
            ['path' => '/assets/images/stitch/detail-twilight-facade.jpg', 'caption' => '01 / Twilight Exterior & Bronze Louver Screen'],
            ['path' => '/assets/images/stitch/detail-quartzite-kitchen.jpg', 'caption' => '02 / Custom Valcucine Quartzite Kitchen'],
            ['path' => '/assets/images/stitch/detail-master-suite.jpg', 'caption' => '03 / Master Suite & Neem Terrace'],
            ['path' => '/assets/images/stitch/living-pavilion.jpg', 'caption' => '04 / Travertine Dining Pavilion & Courtyard']
        ]
    ],
    [
        'slug' => 'colonial-independent-bungalow-jor-bagh',
        'title' => 'Colonial Independent Bungalow',
        'sub_title' => 'Prime Boulevard, Jor Bagh, New Delhi',
        'mandate_ref' => 'EH-JB-102',
        'rera_number' => 'DLRERA2023A00892',
        'area_slug' => 'jor-bagh',
        'property_type' => 'Independent Heritage Bungalow',
        'listing_type' => 'sale',
        'price' => 410000000.00,
        'price_display' => '₹ 41.00 Cr',
        'property_size' => '7,200 sq. ft.',
        'plot_size' => '800 sq. yds Freehold',
        'bedrooms' => 6,
        'bathrooms' => 7,
        'parking_spaces' => 6,
        'floor_info' => 'Ground + 1 Floor + Staff Courtyard',
        'orientation' => 'North-East Corner · Vastu Certified',
        'ceiling_height' => '3.40m Clearance',
        'architect_info' => 'Colonial Heritage Restoration · 2022',
        'property_location' => 'Jor Bagh, Lutyens Perimeter, New Delhi',
        'google_map_url' => 'https://maps.google.com/?q=Jor+Bagh+New+Delhi',
        'coordinates' => '28.5880° N, 77.2185° E',
        'description' => 'Rare generational corner footprint nestled across lush ancient tree canopies. Featuring classical arched porticos, manicured formal lawns, separate staff quarters, and triple car courtyards.',
        'provenance_quote' => '"A century-old arboretum setting meeting timeless Anglo-Indian architectural refinement."',
        'lifestyle_quote' => 'Generational freehold title on prime Jor Bagh boulevard with uninterrupted parkland frontage.',
        'featured_image' => '/assets/images/stitch/jor-bagh-bungalow.jpg',
        'is_featured' => 1,
        'status' => 'published',
        'sort_order' => 2,
        'seo_title' => 'Colonial Independent Bungalow | Jor Bagh | Elite Homez',
        'meta_description' => 'Rare 800 sq. yds Freehold Colonial Bungalow in Jor Bagh. 6 Suites, expansive gardens, independent staff quarters.',
        'gallery' => [
            ['path' => '/assets/images/stitch/about-interior.jpg', 'caption' => 'Formal Heritage Salon'],
            ['path' => '/assets/images/stitch/hero-residence.jpg', 'caption' => 'Manicured Lawn & Portico']
        ]
    ],
    [
        'slug' => 'modern-minimalist-villa-golf-links',
        'title' => 'Modern Minimalist Villa with Lap Pool',
        'sub_title' => 'The Promenade, Golf Links, New Delhi',
        'mandate_ref' => 'EH-GL-218',
        'rera_number' => 'DLRERA2023A00892',
        'area_slug' => 'golf-links',
        'property_type' => 'Modern Architectural Villa',
        'listing_type' => 'sale',
        'price' => 350000000.00,
        'price_display' => '₹ 35.00 Cr',
        'property_size' => '8,200 sq. ft.',
        'plot_size' => '600 sq. yds Freehold',
        'bedrooms' => 5,
        'bathrooms' => 6,
        'parking_spaces' => 5,
        'floor_info' => 'Basement + Ground + 2 Floors',
        'orientation' => 'East Facing · Park Adjacency',
        'ceiling_height' => '3.00m Clearance',
        'architect_info' => 'Khosla Associates · Completed 2023',
        'property_location' => 'Golf Links Promenade, New Delhi',
        'google_map_url' => 'https://maps.google.com/?q=Golf+Links+New+Delhi',
        'coordinates' => '28.5960° N, 77.2340° E',
        'description' => 'Designed by celebrated architectural modernists, this residence features a 22-meter black granite lap pool, monolithic limestone facades, floor-to-ceiling acoustic glass, and full smart-building climate integration.',
        'provenance_quote' => '"A masterclass in restraint, privacy, and minimalist tropical design."',
        'lifestyle_quote' => 'Unmatched golf course adjacency offering serene morning vistas and absolute discretion.',
        'featured_image' => '/assets/images/stitch/golf-links-pool-villa.jpg',
        'is_featured' => 1,
        'status' => 'published',
        'sort_order' => 3,
        'seo_title' => 'Modern Minimalist Villa | Golf Links | Elite Homez',
        'meta_description' => 'Trophy 600 sq. yds Villa in Golf Links with 22-meter black granite lap pool, 5 suites, monolithic limestone facade.',
        'gallery' => [
            ['path' => '/assets/images/stitch/golf-links-villa.jpg', 'caption' => 'Poolside Pavilion & Sundeck'],
            ['path' => '/assets/images/stitch/minimalist-salon.jpg', 'caption' => 'Double-Height Living Salon']
        ]
    ],
    [
        'slug' => 'double-height-travertine-residence-chanakyapuri',
        'title' => 'Double-Height Travertine Residence',
        'sub_title' => 'Diplomatic Enclave & Anand Niketan, New Delhi',
        'mandate_ref' => 'EH-CK-090',
        'rera_number' => 'DLRERA2023A00892',
        'area_slug' => 'chanakyapuri',
        'property_type' => 'Diplomatic Builder Floor',
        'listing_type' => 'rent',
        'price' => 850000.00,
        'price_display' => '₹ 8.50 L / mo',
        'property_size' => '5,200 sq. ft.',
        'plot_size' => '1,000 sq. yds plot footprint',
        'bedrooms' => 4,
        'bathrooms' => 5,
        'parking_spaces' => 3,
        'floor_info' => 'Level 02 with Private Elevator',
        'orientation' => 'North Facing · Embassy Grade',
        'ceiling_height' => '3.20m Clearance',
        'architect_info' => 'Morphogenesis · 2023',
        'property_location' => 'Diplomatic Crescent, Chanakyapuri, New Delhi',
        'google_map_url' => 'https://maps.google.com/?q=Chanakyapuri+New+Delhi',
        'coordinates' => '28.5925° N, 77.1850° E',
        'description' => 'Curated specifically for diplomatic dignitaries and corporate chiefs. Features bronze acoustic paneling, expansive travertine salon, and private landscaped courtyard garden.',
        'provenance_quote' => '"Engineered to embassy-grade security standards with Italian marble finishes throughout."',
        'lifestyle_quote' => 'Positioned within the most secure diplomatic enclave in India, surrounded by green corridors.',
        'featured_image' => '/assets/images/stitch/living-pavilion.jpg',
        'is_featured' => 0,
        'status' => 'published',
        'sort_order' => 4,
        'seo_title' => 'Double-Height Travertine Residence | Chanakyapuri | Elite Homez',
        'meta_description' => 'Exclusive Diplomatic Floor in Chanakyapuri. 5,200 sq. ft., 4 bedrooms, private courtyard, double-height reception.',
        'gallery' => [
            ['path' => '/assets/images/stitch/detail-twilight-facade.jpg', 'caption' => 'Exterior Facade & Private Foyer']
        ]
    ],
    [
        'slug' => 'cantilevered-modern-garden-estate-shanti-niketan',
        'title' => 'Cantilevered Modern Garden Estate',
        'sub_title' => 'Westend Perimeter, Shanti Niketan, New Delhi',
        'mandate_ref' => 'EH-SN-510',
        'rera_number' => 'DLRERA2023A00892',
        'area_slug' => 'shanti-niketan',
        'property_type' => 'Trophy Garden Estate',
        'listing_type' => 'sale',
        'price' => 280000000.00,
        'price_display' => '₹ 28.00 Cr',
        'property_size' => '7,500 sq. ft.',
        'plot_size' => '800 sq. yds Freehold',
        'bedrooms' => 5,
        'bathrooms' => 6,
        'parking_spaces' => 4,
        'floor_info' => 'Ground + 2 Floors + Reflection Pool',
        'orientation' => 'North-East Facing',
        'ceiling_height' => '3.10m Clearance',
        'architect_info' => 'DDIR Architecture · 2023',
        'property_location' => 'Shanti Niketan, New Delhi',
        'google_map_url' => 'https://maps.google.com/?q=Shanti+Niketan+New+Delhi',
        'coordinates' => '28.5775° N, 77.1680° E',
        'description' => 'Dramatic cantilevered glass terraces with mature private tree canopy and an infinity reflection pool. Designed for world-class entertaining.',
        'provenance_quote' => '"Seamless dissolution between indoor luxury salons and dense botanical gardens."',
        'lifestyle_quote' => 'Quiet, leafy enclave offering sanctuary within minutes of Chanakyapuri.',
        'featured_image' => '/assets/images/stitch/golf-links-pool-villa.jpg',
        'is_featured' => 0,
        'status' => 'published',
        'sort_order' => 5,
        'seo_title' => 'Cantilevered Modern Garden Estate | Shanti Niketan | Elite Homez',
        'meta_description' => '7,500 sq. ft. modern garden estate in Shanti Niketan with reflection pool, 5 bedrooms, cantilevered terraces.',
        'gallery' => []
    ],
    [
        'slug' => 'bespoke-teak-travertine-living-pavilion-panchsheel',
        'title' => 'Bespoke Teak & Travertine Living Pavilion',
        'sub_title' => 'Panchsheel Park North, New Delhi',
        'mandate_ref' => 'EH-PP-304',
        'rera_number' => 'DLRERA2023A00892',
        'area_slug' => 'panchsheel-park',
        'property_type' => 'Luxury Builder Floor',
        'listing_type' => 'sale',
        'price' => 142500000.00,
        'price_display' => '₹ 14.25 Cr',
        'property_size' => '4,200 sq. ft.',
        'plot_size' => '500 sq. yds parcel share',
        'bedrooms' => 4,
        'bathrooms' => 5,
        'parking_spaces' => 3,
        'floor_info' => 'Level 01 with Private Lift & Courtyard',
        'orientation' => 'East Facing · Vastu Certified',
        'ceiling_height' => '3.00m Clearance',
        'architect_info' => 'Studio Lotus · 2022',
        'property_location' => 'Panchsheel Park North, New Delhi',
        'google_map_url' => 'https://maps.google.com/?q=Panchsheel+Park+New+Delhi',
        'coordinates' => '28.5440° N, 77.2150° E',
        'description' => 'Floor-to-ceiling glazed pavilion overlooking inward zen courtyard. Finished in book-matched Italian travertine and custom plantation teak.',
        'provenance_quote' => '"Artisanal craftsmanship where plantation teak meets monolithic Italian travertine."',
        'lifestyle_quote' => 'Peaceful, secure enclave with premier club facilities and wide avenues.',
        'featured_image' => '/assets/images/stitch/living-pavilion.jpg',
        'is_featured' => 0,
        'status' => 'published',
        'sort_order' => 6,
        'seo_title' => 'Bespoke Teak & Travertine Pavilion | Panchsheel Park | Elite Homez',
        'meta_description' => '4 BHK luxury floor in Panchsheel Park. 4,200 sq. ft., zen courtyard, book-matched Italian travertine.',
        'gallery' => []
    ],
    [
        'slug' => 'marble-travertine-courtyard-salon-vasant-vihar',
        'title' => 'The Marble & Travertine Courtyard Salon',
        'sub_title' => 'Block A, Vasant Vihar Enclave, New Delhi',
        'mandate_ref' => 'EH-VV-210',
        'rera_number' => 'DLRERA2023A00892',
        'area_slug' => 'vasant-vihar',
        'property_type' => 'Diplomatic Lease Residence',
        'listing_type' => 'rent',
        'price' => 675000.00,
        'price_display' => '₹ 6.75 L / mo',
        'property_size' => '3,900 sq. ft.',
        'plot_size' => '600 sq. yds footprint',
        'bedrooms' => 4,
        'bathrooms' => 4,
        'parking_spaces' => 2,
        'floor_info' => 'Level 01 Residence',
        'orientation' => 'North-East Facing',
        'ceiling_height' => '2.90m Clearance',
        'architect_info' => 'Bespoke Private Commission · 2023',
        'property_location' => 'Block A, Vasant Vihar, New Delhi',
        'google_map_url' => 'https://maps.google.com/?q=Vasant+Vihar+New+Delhi',
        'coordinates' => '28.5670° N, 77.1600° E',
        'description' => 'Tailored for international ambassadors and senior consulates. Includes dual service entries, security chambers, and curated reception salon.',
        'provenance_quote' => '"Refined diplomatic proportions with private courtyards and dedicated security chambers."',
        'lifestyle_quote' => 'Diplomatic perimeter security with seamless access to embassies and airport.',
        'featured_image' => '/assets/images/stitch/minimalist-salon.jpg',
        'is_featured' => 0,
        'status' => 'published',
        'sort_order' => 7,
        'seo_title' => 'Courtyard Salon Diplomatic Lease | Vasant Vihar | Elite Homez',
        'meta_description' => '4 BHK Diplomatic Lease in Vasant Vihar. 3,900 sq. ft., marble fireplace, private courtyard, dual service entries.',
        'gallery' => []
    ]
];

// Fetch all features for association
$featuresStmt = $pdo->query("SELECT id, slug FROM features");
$allFeatureIds = [];
while ($f = $featuresStmt->fetch()) {
    $allFeatureIds[] = (int)$f['id'];
}

foreach ($curatedProperties as $propData) {
    $areaId = $areaMap[$propData['area_slug']] ?? $defaultAreaId;
    $gallery = $propData['gallery'] ?? [];
    unset($propData['area_slug'], $propData['gallery']);

    $propData['area_id'] = $areaId;

    // Check if property with slug exists
    $checkStmt = $pdo->prepare("SELECT id FROM properties WHERE slug = :slug LIMIT 1");
    $checkStmt->execute(['slug' => $propData['slug']]);
    $existing = $checkStmt->fetch();

    if ($existing) {
        $propId = (int)$existing['id'];
        $setFields = [];
        foreach ($propData as $key => $val) {
            $setFields[] = "{$key} = :{$key}";
        }
        $updateSql = "UPDATE properties SET " . implode(', ', $setFields) . " WHERE id = :target_id";
        $updateStmt = $pdo->prepare($updateSql);
        $execParams = $propData;
        $execParams['target_id'] = $propId;
        $updateStmt->execute($execParams);
        echo "Updated property: {$propData['title']} (ID: {$propId})\n";
    } else {
        $fields = array_keys($propData);
        $placeholders = array_map(fn($f) => ":{$f}", $fields);
        $insertSql = "INSERT INTO properties (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->execute($propData);
        $propId = (int)$pdo->lastInsertId();
        echo "Created property: {$propData['title']} (ID: {$propId})\n";
    }

    // Associate features
    if (!empty($allFeatureIds)) {
        $pdo->prepare("DELETE FROM property_features WHERE property_id = :pid")->execute(['pid' => $propId]);
        $featInsert = $pdo->prepare("INSERT INTO property_features (property_id, feature_id) VALUES (:pid, :fid)");
        foreach ($allFeatureIds as $fid) {
            $featInsert->execute(['pid' => $propId, 'fid' => $fid]);
        }
    }

    // Add gallery images if specified
    if (!empty($gallery)) {
        $pdo->prepare("DELETE FROM property_images WHERE property_id = :pid")->execute(['pid' => $propId]);
        $imgInsert = $pdo->prepare("INSERT INTO property_images (property_id, image_path, caption, sort_order) VALUES (:pid, :path, :caption, :sort)");
        $sort = 1;
        foreach ($gallery as $g) {
            $imgInsert->execute([
                'pid' => $propId,
                'path' => $g['path'],
                'caption' => $g['caption'],
                'sort' => $sort++
            ]);
        }
    }
}

echo "Seeding completed successfully!\n";
