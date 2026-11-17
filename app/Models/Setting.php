<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Setting extends Model {
    protected string $table = 'settings';

    public function getAllAsMap(): array {
        $rows = $this->all('id ASC');
        $map = [];
        foreach ($rows as $r) {
            $map[$r['setting_key']] = $r['setting_value'];
        }
        return $map;
    }

    public function getAllKeyValue(): array {
        return $this->getAllAsMap();
    }

    public function getVal(string $key, string $default = ''): string {
        $row = $this->findBy('setting_key', $key);
        return $row ? (string) $row['setting_value'] : $default;
    }

    public function setVal(string $key, string $val, string $group = 'general'): bool {
        $existing = $this->findBy('setting_key', $key);
        if ($existing) {
            return $this->update((int) $existing['id'], ['setting_value' => $val]);
        } else {
            $this->create([
                'setting_key' => $key,
                'setting_value' => $val,
                'setting_group' => $group
            ]);
            return true;
        }
    }

    public function getByGroup(string $group): array {
        $stmt = $this->db->prepare("SELECT setting_key, setting_value FROM {$this->table} WHERE setting_group = :grp ORDER BY id ASC");
        $stmt->execute([':grp' => $group]);
        $rows = $stmt->fetchAll();
        $map = [];
        foreach ($rows as $r) {
            $map[$r['setting_key']] = $r['setting_value'];
        }
        return $map;
    }

    public static function getDefaultAboutSettings(): array {
        return [
            // Section 1: Hero
            'about_hero_badge' => 'Get to Know Elite Homez',
            'about_hero_title' => 'Where Exceptional Homes',
            'about_hero_title_italic' => 'Meet Exceptional Experiences.',
            'about_hero_desc' => 'At Elite Homez, we believe finding the right property is about more than just an address. It is about discovering a lifestyle, making confident decisions and experiencing real estate with trust, expertise and personal attention.',
            'about_hero_btn1_text' => 'Explore Our Approach',
            'about_hero_btn1_link' => '#our-story',
            'about_hero_btn2_text' => 'WhatsApp Senior Advisor',
            'about_hero_btn2_link' => '',
            'about_hero_card_eyebrow' => 'Institutional Heritage',
            'about_hero_card_title' => 'South Delhi Advisory',
            'about_hero_card_desc' => 'Two decades of continuous private representation safeguarding family estates and generational capital across premier diplomatic enclaves.',
            'about_hero_card_tag1' => 'RERA DLRERA2023A00892',
            'about_hero_card_tag2' => 'Est. 2004',
            'about_hero_image' => '/assets/images/stitch/about-flagship-architecture.jpg',

            // Section 2: Our Story
            'about_story_eyebrow' => 'Our Story',
            'about_story_title' => 'A Journey Built Around',
            'about_story_title_italic' => 'Exceptional Real Estate.',
            'about_story_p1' => 'Elite Homez is dedicated to bringing a more thoughtful and personalised approach to luxury real estate. We understand that every property represents an aspiration, an investment and an important life decision.',
            'about_story_p2' => 'Our approach combines market understanding, professional guidance and personal attention to help clients explore exceptional residential opportunities across South Delhi.',
            'about_story_covenant_eyebrow' => 'The Elite Homez Covenant',
            'about_story_covenant_quote' => 'Your trust, our responsibility. Not merely an operational motto, but an absolute fiduciary anchor protecting generational legacy.',
            'about_story_badge_number' => '20+',
            'about_story_badge_text1' => 'Years of',
            'about_story_badge_text2' => 'Bespoke Advisory',
            'about_story_highlight_1' => 'South Delhi Specialisation',
            'about_story_highlight_2' => 'Bespoke Client Portfolios',
            'about_story_highlight_3' => 'Discreet Representation',
            'about_story_image_primary' => '/assets/images/about/about-living-room.jpg',
            'about_story_image_secondary' => '/assets/images/stitch/about-interior.jpg',

            // Section 3: Experience & Expertise
            'about_stats_eyebrow' => 'Experience & Expertise',
            'about_stats_title' => 'Two Decades of Dedicated Advisory',
            'about_stats_desc' => "Built upon intimate knowledge of South Delhi's premier residential enclaves, sustained client relationships, and uncompromised title scrutiny.",
            'about_stat_1_num' => '20+',
            'about_stat_1_title' => 'Years of Experience',
            'about_stat_1_desc' => "Continuous active advisory across South Delhi's most prestigious neighbourhoods.",
            'about_stat_2_num' => '10',
            'about_stat_2_title' => 'Prime Enclaves Mastered',
            'about_stat_2_desc' => 'Granular street-level understanding from Vasant Vihar to Golf Links and Chanakyapuri.',
            'about_stat_3_num' => '100%',
            'about_stat_3_title' => 'Verified Clean Titles',
            'about_stat_3_desc' => 'Rigorous statutory legal checks and complete chain-of-title verification before screening.',
            'about_stat_4_num' => '1:1',
            'about_stat_4_title' => 'Partner-Led Advocacy',
            'about_stat_4_desc' => 'Personal principal attention with zero delegation to junior intermediaries.',

            // Section 4: Our Philosophy
            'about_philosophy_eyebrow' => 'Our Philosophy',
            'about_philosophy_title' => 'Real Estate Is Personal.',
            'about_philosophy_title_italic' => 'So Is Our Approach.',
            'about_philosophy_lead_quote' => 'We believe exceptional real estate experiences begin with understanding people.',
            'about_philosophy_desc' => 'Every client has different expectations, preferences and ambitions. Our focus is to understand those needs and provide thoughtful property guidance throughout the journey.',
            'about_philosophy_tenet1_num' => '01 · Discretion',
            'about_philosophy_tenet1_desc' => 'Protecting client identity and financial privacy at every stage.',
            'about_philosophy_tenet2_num' => '02 · Selectivity',
            'about_philosophy_tenet2_desc' => 'Curating only residences of unquestionable architectural and legal integrity.',
            'about_philosophy_image' => '/assets/images/stitch/about-cinematic-pause.jpg',
            'about_philosophy_card_eyebrow' => 'Brand Thesis',
            'about_philosophy_card_quote' => 'The most meaningful addresses are found through patience, discernment and trusted relationships.',

            // Section 5: Why Choose Elite Homez
            'about_why_eyebrow' => 'Distinctive Value',
            'about_why_title' => 'Why Choose Elite Homez',
            'about_why_desc' => 'Designed for discerning buyers and investors seeking a professional, personal, and relationship-driven property journey.',
            'about_why_1_num' => '01',
            'about_why_1_tag' => 'Advisory Touch',
            'about_why_1_title' => 'Personalised Guidance',
            'about_why_1_desc' => 'Understanding individual preferences and helping clients explore suitable property opportunities tailored to spatial, family, and investment goals.',
            'about_why_2_num' => '02',
            'about_why_2_tag' => 'Specialisation',
            'about_why_2_title' => 'Luxury Property Focus',
            'about_why_2_desc' => 'A focused approach to premium residential properties, generational bungalows, and prestigious addresses across the capital.',
            'about_why_3_num' => '03',
            'about_why_3_tag' => 'Micro-Market',
            'about_why_3_title' => 'Local Market Understanding',
            'about_why_3_desc' => "Deep, nuanced knowledge of South Delhi's premium residential neighbourhoods, road widths, plot scales, and zoning conventions.",
            'about_why_4_num' => '04',
            'about_why_4_tag' => 'Competence',
            'about_why_4_title' => 'Professional Expertise',
            'about_why_4_desc' => 'Experience-driven guidance throughout the property discovery process, title diligence, valuation benchmarking, and formal closing.',
            'about_why_5_num' => '05',
            'about_why_5_tag' => 'Integrity',
            'about_why_5_title' => 'Transparent Communication',
            'about_why_5_desc' => 'Clear information, unvarnished property assessments, and professional interaction at every stage without speculative exaggeration.',
            'about_why_6_num' => '06',
            'about_why_6_tag' => 'Fiduciary Anchor',
            'about_why_6_title' => 'Client-First Approach',
            'about_why_6_desc' => 'Building enduring multi-generational relationships through active listening, absolute discretion, and personalised service.',

            // Section 6: Service Areas Text
            'about_areas_eyebrow' => 'Service Areas',
            'about_areas_title' => 'Exceptional Addresses.',
            'about_areas_title_italic' => 'Distinctive Lifestyles.',
            'about_areas_desc' => 'Explore the prestigious neighbourhoods where Elite Homez advises clients on premier residences, bungalows, and exclusive builder floors.',
            'about_areas_btn_text' => 'View All Enclave Dossiers',
            'about_areas_btn_link' => '/locations',

            // Section 7: Director's Message
            'about_director_eyebrow' => 'Leadership & Vision',
            'about_director_title' => 'A Commitment to Trust,',
            'about_director_title_italic' => 'Excellence and Relationships.',
            'about_director_quote' => 'When a family entrusts us with their residential acquisition or disposition, they are not simply commissioning a transaction—they are placing their privacy, capital, and family legacy in our care.',
            'about_director_p1' => 'Our responsibility is to protect that trust without compromise, providing honest, unvarnished counsel that stands the test of decades. In an industry frequently oriented toward transactional velocity, we intentionally choose discernment, discretion, and partner-level stewardship.',
            'about_director_p2' => 'Every mandate we accept is handled personally, with complete transparency and adherence to regulatory governance under RERA.',
            'about_director_signoff_name' => 'Senior Advisory Directorate',
            'about_director_signoff_title' => 'Managing Principals · Elite Homez',
            'about_director_signoff_sub' => 'RERA Registered Real Estate Advisory · DLRERA2023A00892',
            'about_director_badge_title' => 'Fiduciary Leadership',
            'about_director_badge_quote' => 'Protecting privacy, capital and family legacy across generations.',
            'about_director_image' => '/assets/images/about/director.jpg',

            // Section 8: Testimonials / Reviews Text
            'about_reviews_eyebrow' => 'Client Trust',
            'about_reviews_title' => 'Relationships Built on Trust.',
            'about_reviews_desc' => 'Hear from the discerning individuals and families who have experienced our personalised approach to luxury real estate.',

            // Section 9: Final Call to Action
            'about_cta_eyebrow' => 'Private Advisory Mandates',
            'about_cta_title' => 'Your Next Chapter Begins',
            'about_cta_title_italic' => 'with the Right Address.',
            'about_cta_desc' => 'Discover exceptional properties and experience a more personalised approach to luxury real estate.',
            'about_cta_btn1_text' => 'Explore Properties',
            'about_cta_btn1_link' => '/properties',
            'about_cta_btn2_text' => 'Contact Our Team',
            'about_cta_btn2_link' => '/contact-us',
            'about_cta_btn3_text' => 'WhatsApp Concierge',
            'about_cta_btn3_link' => '',
            'about_cta_note1' => 'Direct Senior Partner Access',
            'about_cta_note2' => 'Bilateral NDA Protocols',
            'about_cta_note3' => 'RERA Certified',
            'about_cta_image' => '/assets/images/stitch/service-cta-dusk.jpg',

            // SEO Metadata
            'about_seo_title' => 'About Elite Homez | Where Exceptional Homes Meet Exceptional Experiences',
            'about_seo_description' => 'Discover Elite Homez — two decades of trusted advisory, unparalleled discretion, and personalised luxury real estate expertise across South Delhi.'
        ];
    }

    public function getAboutSettings(): array {
        $defaults = self::getDefaultAboutSettings();
        $dbSettings = $this->getByGroup('about');
        return array_merge($defaults, $dbSettings);
    }

    public static function getDefaultHomeSettings(): array {
        return [
            // Section 1: Hero Carousel & Rail
            'home_hero_default_eyebrow' => 'PRIVATE LUXURY ADVISORY · SOUTH DELHI',
            'home_hero_default_title' => 'Discover a More Exclusive<br><span class="hero-gold-italic">Way to Live.</span>',
            'home_hero_default_subtitle' => 'Exceptional homes. Prestigious addresses. Personalised real estate expertise across South Delhi.',
            'home_hero_default_btn1_text' => 'Explore Properties',
            'home_hero_default_btn1_url' => '/properties',
            'home_hero_default_btn2_text' => 'Speak With an Advisor',
            'home_hero_default_btn2_url' => '/contact-us',
            'home_hero_default_trust1' => '20+ Years Leadership',
            'home_hero_default_trust2' => '100% Non-Disclosure Mandates',
            'home_hero_default_trust3' => 'RERA Registered',
            'home_hero_default_dossier_eyebrow' => 'Featured Residence Dossier',
            'home_hero_default_dossier_title' => 'Golf Links Promenade · ₹35.00 Cr',
            'home_hero_default_badge' => 'Off-Market Mandate',
            'home_hero_rail_text' => 'ELITE HOMEZ · SOUTH DELHI BESPOKE ADVISORY',

            // Section 2: Institutional Heritage & 4 Metrics (Forest Green Block)
            'home_manifesto_eyebrow' => 'Institutional Heritage',
            'home_manifesto_title' => 'More than a property. A relationship built around trust.',
            'home_stat_1_num' => '20+',
            'home_stat_1_title' => 'Years of Leadership',
            'home_stat_1_desc' => "Direct senior partner stewardship across Delhi's premier capital enclaves since 2004.",
            'home_stat_2_num' => '₹1,200 Cr+',
            'home_stat_2_title' => 'Transacted Asset Volume',
            'home_stat_2_desc' => 'Unrivaled access to off-market generational residences and private family estates.',
            'home_stat_3_num' => '100%',
            'home_stat_3_title' => 'Forensic Title Diligence',
            'home_stat_3_desc' => 'Zero legacy encumbrance assurance, zoning audits, and complete RERA statutory compliance.',
            'home_stat_4_num' => 'Strict NDA',
            'home_stat_4_title' => 'Family Office Discretion',
            'home_stat_4_desc' => 'Bilateral non-disclosure protocols protecting client confidentiality and wealth structures.',

            // Section 3: Selected Properties
            'home_properties_eyebrow' => 'Curated Portfolio',
            'home_properties_title' => 'Selected Properties',
            'home_properties_desc' => 'A considered collection of exceptional South Delhi residences.',
            'home_properties_btn_text' => 'View All Properties',
            'home_properties_btn_url' => '/properties',

            // Section 4: Advisory Scope & Categories (Dark Charcoal Block)
            'home_services_eyebrow' => 'Structured Advisory Scope',
            'home_services_title' => 'Find Your Next Address.',

            // Section 5: Why Elite Homez / 4 Pillars (Forest Green Block)
            'home_why_eyebrow' => 'Institutional Excellence',
            'home_why_title' => 'The Difference is Experience.',
            'home_why_quote' => '"Because acquiring or transferring generational real estate requires more than brokerage."',
            'home_pillar_1_num' => '01',
            'home_pillar_1_title' => 'LOCAL KNOWLEDGE',
            'home_pillar_1_desc' => "Unrivalled transaction intelligence across South Delhi's premier micro-markets, municipal FAR statutes, and clear title genealogy.",
            'home_pillar_1_tag' => 'Forensic Due Diligence',
            'home_pillar_2_num' => '02',
            'home_pillar_2_title' => 'DISCREET ADVISORY',
            'home_pillar_2_desc' => 'Complete transaction privacy, family-office protocol, and non-disclosure governance protecting generational reputation.',
            'home_pillar_2_tag' => 'Strict Bilateral NDAs',
            'home_pillar_3_num' => '03',
            'home_pillar_3_title' => 'OFF-MARKET ACCESS',
            'home_pillar_3_desc' => 'Direct access to trophy estates, heritage bungalows, and private residences that never enter public digital portals.',
            'home_pillar_3_tag' => 'Private Enclave Network',
            'home_pillar_4_num' => '04',
            'home_pillar_4_title' => 'SENIOR STEWARDSHIP',
            'home_pillar_4_desc' => 'Senior partners directly stewarding every valuation, private viewing, and statutory contract closure.',
            'home_pillar_4_tag' => 'Principal Level Trust',

            // Section 6: Areas of Expertise (Territorial Atlas)
            'home_areas_eyebrow' => 'Territorial Mastery',
            'home_areas_title' => 'Addresses We Know.',
            'home_areas_desc' => 'Intimate familiarity with distinctive micro-markets and the rare residences within them.',
            'home_areas_ticker_label' => 'Additional Prime South Delhi Enclaves:',

            // Section 7: Director's Message / Fiduciary Leadership
            'home_director_eyebrow' => "DIRECTOR'S LETTER",
            'home_director_title' => '"Discretion is not merely a courtesy. In high-value real estate, it is the cornerstone of trust."',
            'home_director_pullquote' => 'Over the last twenty years, we have seen prime Delhi real estate transition through cycles, zoning shifts, and generational changes. What has never changed is the value of personal integrity.',
            'home_director_p1' => 'When high-net-worth families, single family offices, and diplomatic missions entrust us with their residential mandates, they are looking for more than square footage. They require forensic legal clarity, absolute privacy, and an unhurried advisor who tells them the honest truth about an asset before a single rupee is committed.',
            'home_director_p2' => 'At Elite Homez, our motto "your trust, our responsibility" is our binding covenant. Every transaction is directly steered by our senior partners with generational commitment.',
            'home_director_credentials_eyebrow' => 'FOUNDING PRINCIPAL',
            'home_director_credentials_name' => 'Managing Director',
            'home_director_credentials_title' => 'Elite Homez Property Advisory',
            'home_director_signoff' => 'Elite Homez Advisory',
            'home_director_badge' => '✦ Senior Partner Desk',
            'home_director_image' => '/assets/images/stitch/about-director-office.jpg',

            // Section 8: Confidential Dialogue Enquiry Desk
            'home_enquiry_enabled' => '1',
            'home_enquiry_eyebrow' => 'Confidential Dialogue',
            'home_enquiry_title' => 'Initiate a Private Advisory Briefing',
            'home_enquiry_desc' => 'Share your parameters. A designated Elite Homez Senior Partner will contact you under strict bilateral confidentiality.',
            'home_enquiry_feature_1' => 'Protected by bilateral non-disclosure covenants',
            'home_enquiry_feature_2' => 'Senior partner consultation within 4 business hours',
            'home_enquiry_feature_3' => 'Verified freehold credentials & micro-market intelligence',
            'home_enquiry_btn_text' => 'Request Confidential Consultation',
            'home_enquiry_wa_text' => 'Direct WhatsApp Concierge',

            // Section 9: Final Enquiry (Cinematic Finale)
            'home_cta_eyebrow' => 'DIRECT PRINCIPAL ADVISORY',
            'home_cta_title' => 'Your next address deserves the right advice.',
            'home_cta_desc' => 'Speak with Elite Homez about your next property decision. Our advisory desk offers uncompromised discretion, deep enclave records, and partner-level stewardship.',
            'home_cta_btn1_text' => 'Speak With an Advisor',
            'home_cta_btn1_url' => '/contact-us',
            'home_cta_btn2_text' => 'Direct WhatsApp Concierge',
            'home_cta_btn2_url' => '',
            'home_cta_note' => 'All discussions are treated with strict professional confidentiality under bilateral NDAs.',
            'home_cta_image' => '/assets/images/stitch/hero-residence.jpg',

            // Section 9: SEO & Metadata
            'home_seo_title' => 'Elite Homez | Premium Luxury Real Estate Property Advisory',
            'home_seo_description' => 'Elite Homez — your trust, our responsibility. Over 20 years of trusted advisory in prime luxury residences, villas, and builder floors in Vasant Vihar, Jor Bagh, Golf Links, and Chanakyapuri.'
        ];
    }

    public function getHomeSettings(): array {
        $defaults = self::getDefaultHomeSettings();
        $dbSettings = $this->getByGroup('home');
        return array_merge($defaults, $dbSettings);
    }
}
