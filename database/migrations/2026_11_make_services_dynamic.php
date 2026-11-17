<?php
declare(strict_types=1);

require dirname(__DIR__, 2) . '/app/Core/Database.php';

$db = \App\Core\Database::getConnection();

echo "Starting Services Dynamic Schema Migration...\n";

$columns = $db->query("SHOW COLUMNS FROM services")->fetchAll(PDO::FETCH_COLUMN);

$newColumns = [
    'hero_cta_text' => "VARCHAR(100) NULL DEFAULT 'Speak with an Advisor'",
    'hero_cta_url' => "VARCHAR(255) NULL DEFAULT '#confidential-desk'",
    'hero_features' => "JSON NULL",
    'banner_tag' => "VARCHAR(150) NULL DEFAULT 'Perspective · Discernment · Heritage'",
    'banner_btn_text' => "VARCHAR(100) NULL DEFAULT 'Request A Private Briefing'",
    'banner_btn_url' => "VARCHAR(255) NULL DEFAULT '#confidential-desk'",
    'why_eyebrow' => "VARCHAR(150) NULL DEFAULT 'Fiduciary Excellence'",
    'faqs_eyebrow' => "VARCHAR(150) NULL DEFAULT 'Bespoke Guidance & Clarity'",
    'faqs_title' => "VARCHAR(255) NULL DEFAULT 'Frequently Asked Questions'",
    'faqs_subtitle' => "VARCHAR(255) NULL DEFAULT 'Clear answers to the most common questions regarding our private advisory services and confidential engagement process.'",
    'faqs_items' => "JSON NULL",
    'enquiry_eyebrow' => "VARCHAR(150) NULL DEFAULT 'Confidential Dialogue'",
    'enquiry_title' => "VARCHAR(255) NULL DEFAULT 'Initiate a Private Advisory Briefing'",
    'enquiry_description' => "TEXT NULL",
    'enquiry_features' => "JSON NULL",
    'enquiry_btn_text' => "VARCHAR(100) NULL DEFAULT 'Submit Confidential Mandate'",
    'cta_eyebrow' => "VARCHAR(150) NULL DEFAULT 'Elite Homez Advisory'",
    'cta_title' => "VARCHAR(255) NULL DEFAULT 'The right property starts with the right advice.'",
    'cta_subtitle' => "TEXT NULL",
    'cta_image' => "VARCHAR(255) NULL DEFAULT '/assets/images/stitch/service-cta-dusk.jpg'",
    'cta_btn1_text' => "VARCHAR(100) NULL DEFAULT 'Explore Properties Catalogue'",
    'cta_btn1_url' => "VARCHAR(255) NULL DEFAULT '/properties'",
    'cta_btn2_text' => "VARCHAR(100) NULL DEFAULT 'Contact Advisory Desk'",
    'cta_btn2_url' => "VARCHAR(255) NULL DEFAULT '/contact-us'"
];

foreach ($newColumns as $columnName => $definition) {
    if (!in_array($columnName, $columns, true)) {
        echo "Adding column: {$columnName}...\n";
        $db->exec("ALTER TABLE services ADD `{$columnName}` {$definition}");
    } else {
        echo "Column {$columnName} already exists.\n";
    }
}

// Seed default FAQs and dynamic values for existing services if null
$services = $db->query("SELECT id, name, slug FROM services")->fetchAll(PDO::FETCH_ASSOC);

$defaultFaqs = [
    'luxury-property-buying-advisory' => [
        [
            'question' => 'How does the private client acquisition mandate work?',
            'answer' => 'We operate under an exclusive buy-side fiduciary agreement. Following a confidential discovery briefing to codify spatial, architectural, and financial parameters, we conduct structured market sweeps across private family office portfolios and off-market networks, presenting vetted properties with forensic title, zoning, and structural due diligence before private viewings.'
        ],
        [
            'question' => 'Are all property options shared kept strictly off-market?',
            'answer' => 'Over 70% of trophy transactions in premier South Delhi enclaves (such as Vasant Vihar, Jor Bagh, and Golf Links) are conducted off-market to preserve discretion. Our mandates provide direct access to verified private trusts, non-public developer inventory, and private resident listings.'
        ],
        [
            'question' => 'How does Elite Homez verify legal title and municipal sanctions?',
            'answer' => 'Every recommended property undergoes forensic 30-year title tracing, encumbrance audits, mutation deed reviews, and masterplan zoning checks led by independent senior property advocates before client offers are structured.'
        ],
        [
            'question' => 'What are your advisory fees and commercial terms?',
            'answer' => 'Our fee structure is completely transparent, success-contingent, and governed by bilateral advisory agreements without hidden markups, referral kickbacks, or split-broker conflicts.'
        ],
        [
            'question' => 'Can you assist international NRIs and foreign missions?',
            'answer' => 'Yes. We frequently act as authorized on-ground acquisition proxies for NRIs, global family offices, and foreign embassy chancery mandates, handling FEMA compliance, virtual walkthroughs, and legal conveyance.'
        ]
    ],
    'luxury-property-selling-mandate' => [
        [
            'question' => 'How do you safeguard owner privacy during property divestment?',
            'answer' => 'We never publish public listings, photographs, or addresses without explicit written consent. Prospective buyers are pre-screened for financial liquidity and identity verification, and all walkthroughs are conducted under strict non-disclosure covenants.'
        ],
        [
            'question' => 'How is pricing determined for trophy assets in South Delhi?',
            'answer' => 'We benchmark asset valuations against real closed transaction registries, circle rates, and micro-market plot indices rather than speculative portal asking prices, ensuring optimal capital extraction.'
        ],
        [
            'question' => 'What is the typical timeframe for an off-market disposition?',
            'answer' => 'A curated off-market mandate typically achieves binding terms within 45 to 90 days, depending on enclave inventory liquidity and buyer alignment.'
        ]
    ],
    'diplomatic-executive-leasing' => [
        [
            'question' => 'Do your properties meet diplomatic security protocol standards?',
            'answer' => 'Yes. We curate standalone residences, chancery buildings, and ambassadorial villas with secure setbacks, guard annexes, perimeter fortifications, and high-capacity MEP redundancy suited for accredited foreign missions.'
        ],
        [
            'question' => 'How are diplomatic lease agreements structured in Delhi?',
            'answer' => 'We draft standard diplomatic clause agreements with statutory tax deduction (TDS) exemptions, foreign mission covenants, and bilateral termination terms approved by legal consuls.'
        ]
    ],
    'real-estate-portfolio-advisory' => [
        [
            'question' => 'What does portfolio asset optimization entail?',
            'answer' => 'We conduct holistic diagnostics across residential and commercial holdings, evaluating lease yield performance, capital appreciation velocity, heritage encumbrances, and generational succession planning.'
        ],
        [
            'question' => 'Do you advise on redevelopment and builder floor conversions?',
            'answer' => 'Yes. We partner with India’s leading luxury architects and vetted tier-1 developers to structure joint-venture and turnkey collaboration agreements that maximize FAR and economic value for landholders.'
        ]
    ]
];

$defaultFeatures = [
    'hero_features' => ['South Delhi Enclaves', 'Zero Conflict of Interest', 'RERA Certified'],
    'enquiry_features' => ['Direct Senior Partner Representation', 'Strict Bilateral Non-Disclosure', 'Zero Commercial Bias']
];

foreach ($services as $srv) {
    $sid = (int) $srv['id'];
    $slug = $srv['slug'];

    $updates = [];
    $params = ['id' => $sid];

    // Check if faqs_items is empty
    $currFaqs = $db->query("SELECT faqs_items, hero_features, enquiry_features FROM services WHERE id = {$sid}")->fetch(PDO::FETCH_ASSOC);
    
    if (empty($currFaqs['faqs_items']) && isset($defaultFaqs[$slug])) {
        $updates[] = "faqs_items = :faqs_items";
        $params['faqs_items'] = json_encode($defaultFaqs[$slug], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    if (empty($currFaqs['hero_features'])) {
        $updates[] = "hero_features = :hero_features";
        $params['hero_features'] = json_encode($defaultFeatures['hero_features'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    if (empty($currFaqs['enquiry_features'])) {
        $updates[] = "enquiry_features = :enquiry_features";
        $params['enquiry_features'] = json_encode($defaultFeatures['enquiry_features'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    if (!empty($updates)) {
        $sql = "UPDATE services SET " . implode(', ', $updates) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        echo "Updated defaults for service: {$srv['name']}\n";
    }
}

echo "Migration completed successfully!\n";
