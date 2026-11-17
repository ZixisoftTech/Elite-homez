<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/app/Core/Database.php';

$pdo = \App\Core\Database::getConnection();

// Check which columns already exist
$stmt = $pdo->query("DESCRIBE areas");
$existingCols = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $existingCols[] = $row['Field'];
}

$columnsToAdd = [
    'hero_monograph_text' => "VARCHAR(255) NULL DEFAULT NULL AFTER hero_subtitle",
    'hero_metrics' => "LONGTEXT NULL DEFAULT NULL AFTER hero_monograph_text",
    'character_highlights' => "LONGTEXT NULL DEFAULT NULL AFTER overview",
    'fiduciary_note' => "TEXT NULL DEFAULT NULL AFTER property_market",
    'property_types_eyebrow' => "VARCHAR(255) NULL DEFAULT 'Residential Asset Categories' AFTER property_types",
    'property_types_title' => "VARCHAR(255) NULL DEFAULT NULL AFTER property_types_eyebrow",
    'plot_sizes_eyebrow' => "VARCHAR(255) NULL DEFAULT 'Spatial Typologies' AFTER plot_sizes",
    'plot_sizes_title' => "VARCHAR(255) NULL DEFAULT NULL AFTER plot_sizes_eyebrow",
    'plot_sizes_description' => "TEXT NULL DEFAULT NULL AFTER plot_sizes_title",
    'lifestyle_eyebrow' => "VARCHAR(255) NULL DEFAULT 'Neighborhood Ambiance' AFTER lifestyle",
    'lifestyle_title' => "VARCHAR(255) NULL DEFAULT NULL AFTER lifestyle_eyebrow",
    'connectivity_eyebrow' => "VARCHAR(255) NULL DEFAULT 'Arterial Infrastructure' AFTER connectivity",
    'connectivity_title' => "VARCHAR(255) NULL DEFAULT 'Connectivity & Transit Links' AFTER connectivity_eyebrow",
    'banner_eyebrow' => "VARCHAR(255) NULL DEFAULT 'Elite Homez Private Office' AFTER advisory_content",
    'banner_title' => "VARCHAR(255) NULL DEFAULT 'Local Knowledge. Better Property Decisions.' AFTER banner_eyebrow",
    'banner_description' => "TEXT NULL DEFAULT NULL AFTER banner_title",
    'banner_btn1_text' => "VARCHAR(150) NULL DEFAULT 'Initiate Private Mandate' AFTER banner_description",
    'banner_btn1_url' => "VARCHAR(255) NULL DEFAULT NULL AFTER banner_btn1_text",
    'banner_btn2_text' => "VARCHAR(150) NULL DEFAULT 'Call Advisory Desk' AFTER banner_btn1_url",
    'banner_btn2_url' => "VARCHAR(255) NULL DEFAULT NULL AFTER banner_btn2_text",
    'faqs_eyebrow' => "VARCHAR(255) NULL DEFAULT 'Local Advisory Insights' AFTER faqs",
    'faqs_title' => "VARCHAR(255) NULL DEFAULT NULL AFTER faqs_eyebrow",
    'cta_eyebrow' => "VARCHAR(255) NULL DEFAULT 'Fiduciary Client Representation' AFTER hero_image_alt",
    'cta_title' => "VARCHAR(255) NULL DEFAULT NULL AFTER cta_eyebrow",
    'cta_description' => "TEXT NULL DEFAULT NULL AFTER cta_title",
    'cta_btn1_text' => "VARCHAR(150) NULL DEFAULT 'Share Your Requirement' AFTER cta_description",
    'cta_btn1_url' => "VARCHAR(255) NULL DEFAULT NULL AFTER cta_btn1_text",
    'cta_btn2_text' => "VARCHAR(150) NULL DEFAULT 'WhatsApp Advisory' AFTER cta_btn1_url",
    'cta_btn2_url' => "VARCHAR(255) NULL DEFAULT NULL AFTER cta_btn2_text",
];

foreach ($columnsToAdd as $col => $def) {
    if (!in_array($col, $existingCols, true)) {
        try {
            $pdo->exec("ALTER TABLE areas ADD COLUMN `{$col}` {$def}");
            echo "Added column `{$col}` to areas.\n";
        } catch (\PDOException $e) {
            echo "Failed adding `{$col}`: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Column `{$col}` already exists.\n";
    }
}

// Now populate default values for existing areas
$areas = $pdo->query("SELECT id, name, sort_order, advisory_content FROM areas")->fetchAll(PDO::FETCH_ASSOC);
foreach ($areas as $a) {
    $id = (int)$a['id'];
    $name = $a['name'];
    $idx = str_pad((string)($a['sort_order'] ?? $id), 2, '0', STR_PAD_LEFT);

    $defaultMetrics = json_encode([
        ['label' => 'Active Mandates', 'value' => 'Off-Market'],
        ['label' => 'Title Status', 'value' => 'Freehold'],
        ['label' => 'Zoning', 'value' => 'Low Density'],
        ['label' => 'Security', 'value' => 'Diplomatic A1']
    ], JSON_UNESCAPED_SLASHES);

    $defaultHighlights = json_encode([
        'Strict Residential Zoning',
        'High Owner-Occupancy',
        'Off-Market Mandates'
    ], JSON_UNESCAPED_SLASHES);

    $defaultFiduciaryNote = "Property values in {$name} vary significantly based on plot size, road width, frontage, construction quality, location within the neighbourhood, and property condition. Contact Elite Homez for current property-specific guidance.";

    $advContent = !empty($a['advisory_content']) ? $a['advisory_content'] : "Elite Homez maintains direct relationships with multi-generational resident owners and premier developers in {$name}. We operate off-market to present verified residential assets with complete discretion.";

    $stmt = $pdo->prepare("
        UPDATE areas SET 
            hero_monograph_text = COALESCE(NULLIF(hero_monograph_text, ''), :mono),
            hero_metrics = COALESCE(NULLIF(hero_metrics, ''), :metrics),
            character_highlights = COALESCE(NULLIF(character_highlights, ''), :highlights),
            fiduciary_note = COALESCE(NULLIF(fiduciary_note, ''), :fiduciary_note),
            property_types_eyebrow = COALESCE(NULLIF(property_types_eyebrow, ''), 'Residential Asset Categories'),
            property_types_title = COALESCE(NULLIF(property_types_title, ''), :pt_title),
            plot_sizes_eyebrow = COALESCE(NULLIF(plot_sizes_eyebrow, ''), 'Spatial Typologies'),
            plot_sizes_title = COALESCE(NULLIF(plot_sizes_title, ''), :ps_title),
            plot_sizes_description = COALESCE(NULLIF(plot_sizes_description, ''), :ps_desc),
            lifestyle_eyebrow = COALESCE(NULLIF(lifestyle_eyebrow, ''), 'Neighborhood Ambiance'),
            lifestyle_title = COALESCE(NULLIF(lifestyle_title, ''), :life_title),
            connectivity_eyebrow = COALESCE(NULLIF(connectivity_eyebrow, ''), 'Arterial Infrastructure'),
            connectivity_title = COALESCE(NULLIF(connectivity_title, ''), 'Connectivity & Transit Links'),
            banner_eyebrow = COALESCE(NULLIF(banner_eyebrow, ''), 'Elite Homez Private Office'),
            banner_title = COALESCE(NULLIF(banner_title, ''), 'Local Knowledge. Better Property Decisions.'),
            banner_description = COALESCE(NULLIF(banner_description, ''), :adv_content),
            banner_btn1_text = COALESCE(NULLIF(banner_btn1_text, ''), 'Initiate Private Mandate'),
            banner_btn1_url = COALESCE(NULLIF(banner_btn1_url, ''), :b1_url),
            banner_btn2_text = COALESCE(NULLIF(banner_btn2_text, ''), 'Call Advisory Desk'),
            faqs_eyebrow = COALESCE(NULLIF(faqs_eyebrow, ''), 'Local Advisory Insights'),
            faqs_title = COALESCE(NULLIF(faqs_title, ''), :faq_title),
            cta_eyebrow = COALESCE(NULLIF(cta_eyebrow, ''), 'Fiduciary Client Representation'),
            cta_title = COALESCE(NULLIF(cta_title, ''), :cta_title),
            cta_description = COALESCE(NULLIF(cta_description, ''), :cta_desc),
            cta_btn1_text = COALESCE(NULLIF(cta_btn1_text, ''), 'Share Your Requirement'),
            cta_btn1_url = COALESCE(NULLIF(cta_btn1_url, ''), :c1_url),
            cta_btn2_text = COALESCE(NULLIF(cta_btn2_text, ''), 'WhatsApp Advisory')
        WHERE id = :id
    ");

    $stmt->execute([
        ':mono' => "Territory Monograph {$idx} · South Delhi",
        ':metrics' => $defaultMetrics,
        ':highlights' => $defaultHighlights,
        ':fiduciary_note' => $defaultFiduciaryNote,
        ':pt_title' => "Typical Property Formats in {$name}",
        ':ps_title' => "Typical Residential Plot Sizes in {$name}",
        ':ps_desc' => "Plot footprints in {$name} dictate permissible floor area ratio (FAR), setback requirements, and basement depth. Available property sizes vary considerably across individual listings.",
        ':life_title' => "Lifestyle & Community in {$name}",
        ':adv_content' => $advContent,
        ':b1_url' => "/contact-us?subject=" . urlencode("{$name} Confidential Advisory"),
        ':faq_title' => "Frequently Asked Questions: {$name}",
        ':cta_title' => "Begin Your Residential Search in {$name}",
        ':cta_desc' => "Whether seeking an off-market independent bungalow or a bespoke modern builder floor, Elite Homez provides verified confidential guidance.",
        ':c1_url' => "/contact-us?subject=" . urlencode("Direct Inquiry: {$name}"),
        ':id' => $id
    ]);
    echo "Updated defaults for area {$id} ({$name}).\n";
}

echo "Migration completed successfully!\n";
