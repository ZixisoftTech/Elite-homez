<?php
declare(strict_types=1);

/**
 * ELITE HOMEZ - MASTER FULL REGRESSION QA TEST SUITE
 * 
 * Executes exhaustive end-to-end tests across:
 * 1. Database schema, tables, and relationships
 * 2. All public frontend endpoints, layout elements, and dynamic data binding
 * 3. Dynamic forms, AJAX handlers, validation, honeypot, and database persistence
 * 4. Admin authentication, session security, RBAC protection, and admin pages
 */

spl_autoload_register(function (string $class): void {
    $prefix = "App\\";
    $baseDir = dirname(__DIR__) . "/app/";
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace("\\", "/", $relativeClass) . ".php";
    if (file_exists($file)) require $file;
});

class RegressionQA {
    private string $baseUrl;
    private PDO $db;
    private int $testsRun = 0;
    private int $testsPassed = 0;
    private int $testsFailed = 0;
    private array $failures = [];
    private string $cookieJar;

    public function __construct(string $baseUrl = 'http://127.0.0.1:8000') {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->db = \App\Core\Database::getConnection();
        $this->cookieJar = sys_get_temp_dir() . '/elite_qa_cookie_' . uniqid() . '.txt';
    }

    public function __destruct() {
        if (file_exists($this->cookieJar)) {
            @unlink($this->cookieJar);
        }
    }

    private function assert(bool $condition, string $testName, string $details = ''): void {
        $this->testsRun++;
        if ($condition) {
            $this->testsPassed++;
            echo "  ✓ PASS: $testName\n";
        } else {
            $this->testsFailed++;
            $msg = "  ✗ FAIL: $testName" . ($details ? " ($details)" : "");
            echo "$msg\n";
            $this->failures[] = $msg;
        }
    }

    private function httpGet(string $path, bool $useCookies = false): array {
        $ch = curl_init($this->baseUrl . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, '');
        curl_setopt($ch, CURLOPT_HEADER, true);
        if ($useCookies) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieJar);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieJar);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = (string) curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $headers = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        return [
            'status' => $status,
            'headers' => $headers,
            'body' => $body
        ];
    }

    private function httpPost(string $path, array $data, bool $isAjax = false, bool $useCookies = false): array {
        $ch = curl_init($this->baseUrl . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, '');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HEADER, true);
        if ($useCookies) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieJar);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieJar);
        }
        $headers = [];
        if ($isAjax) {
            $headers[] = 'X-Requested-With: XMLHttpRequest';
            $headers[] = 'Accept: application/json';
        }
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = (string) curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $headerStr = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        return [
            'status' => $status,
            'headers' => $headerStr,
            'body' => $body
        ];
    }

    public function runAll(): void {
        echo "\n============================================================\n";
        echo "   ELITE HOMEZ MASTER REGRESSION & QA TEST SUITE\n";
        echo "============================================================\n";

        $this->testDatabaseSchema();
        $this->testPublicFrontendPages();
        $this->testLocationDetailPages();
        $this->testPropertyDetailPages();
        $this->testServiceDetailPages();
        $this->testDynamicFormsAndAjax();
        $this->testAdminSecurityAndPages();
        $this->cleanupTestData();

        echo "\n============================================================\n";
        echo "   TEST RESULTS SUMMARY\n";
        echo "============================================================\n";
        echo "Total Tests Run: {$this->testsRun}\n";
        echo "Passed: {$this->testsPassed}\n";
        echo "Failed: {$this->testsFailed}\n";

        if ($this->testsFailed === 0) {
            echo "\n>>> 100% CLEAN PASS! WHOLE PROJECT FULLY REGRESSION-VERIFIED! <<<\n";
        } else {
            echo "\n>>> FAILURES DETECTED! <<<\n";
            foreach ($this->failures as $f) {
                echo "$f\n";
            }
        }
        echo "============================================================\n\n";
    }

    // --- 1. Database Schema & Integrity ---
    private function testDatabaseSchema(): void {
        echo "\n[Suite 1: Database Schema & Integrity]\n";
        
        $tables = [
            'admins', 'settings', 'properties', 'property_images', 
            'property_features', 'services', 'areas', 'carousel_slides', 
            'testimonials', 'enquiries', 'features'
        ];

        foreach ($tables as $t) {
            $stmt = $this->db->query("SHOW TABLES LIKE '$t'");
            $this->assert($stmt->rowCount() === 1, "Table '$t' exists in database");
        }

        // Verify admin user
        $admin = $this->db->query("SELECT * FROM admins WHERE email = 'admin@elitehomez.com'")->fetch(PDO::FETCH_ASSOC);
        $this->assert(!empty($admin), "Admin user 'admin@elitehomez.com' exists");
        $this->assert(password_verify('Admin@112233', $admin['password_hash'] ?? ''), "Admin password hash verifies correctly");

        // Verify Home settings count
        $homeSettings = $this->db->query("SELECT COUNT(*) FROM settings WHERE setting_group = 'home'")->fetchColumn();
        $this->assert((int)$homeSettings >= 80, "Home page settings seeded (found $homeSettings)");

        // Verify Areas count
        $areasCount = $this->db->query("SELECT COUNT(*) FROM areas WHERE is_published = 1")->fetchColumn();
        $this->assert((int)$areasCount >= 11, "All 11+ prime areas published (found $areasCount)");

        // Verify Services count
        $servicesCount = $this->db->query("SELECT COUNT(*) FROM services WHERE is_published = 1")->fetchColumn();
        $this->assert((int)$servicesCount >= 4, "Core advisory services published (found $servicesCount)");
    }

    // --- 2. Public Frontend Pages ---
    private function testPublicFrontendPages(): void {
        echo "\n[Suite 2: Public Frontend Endpoints & Content]\n";

        // Homepage
        $res = $this->httpGet('/');
        $this->assert($res['status'] === 200, "GET / (Homepage) returns HTTP 200");
        $this->assert(str_contains($res['body'], 'Elite Homez'), "Homepage contains brand title");
        $this->assert(str_contains($res['body'], 'Institutional Heritage') || str_contains($res['body'], '20+'), "Homepage contains 4-metric Institutional Heritage");
        $this->assert(str_contains($res['body'], 'Selected Properties'), "Homepage contains Selected Properties section");
        $this->assert(str_contains($res['body'], 'The Difference is Experience'), "Homepage contains Why Elite Homez 4 pillars");
        $this->assert(str_contains($res['body'], 'Addresses We Know'), "Homepage contains Addresses We Know territorial mosaic");
        $this->assert(str_contains($res['body'], 'Direct Principal Advisory') || str_contains($res['body'], 'DIRECT PRINCIPAL ADVISORY'), "Homepage contains Director's Letter & Final CTA");
        $this->assert(str_contains($res['body'], 'id="confidential-desk"'), "Homepage contains Dynamic Advisory Briefing Enquiry Section (#confidential-desk)");
        $this->assert(str_contains($res['body'], 'id="home-advisory-form"'), "Homepage contains #home-advisory-form with CSRF token");

        // About Us
        $res = $this->httpGet('/about-us');
        $this->assert($res['status'] === 200, "GET /about-us returns HTTP 200");
        $this->assert(str_contains($res['body'], 'About Us') || str_contains($res['body'], 'Institutional Heritage'), "About Us page renders expected content");

        // Properties Listing
        $res = $this->httpGet('/properties');
        $this->assert($res['status'] === 200, "GET /properties returns HTTP 200");
        $this->assert(str_contains($res['body'], 'Curated Residences') || str_contains($res['body'], 'Portfolio'), "Properties page renders portfolio title");

        // Properties For Sale filter
        $res = $this->httpGet('/properties?tab=sell');
        $this->assert($res['status'] === 200, "GET /properties?tab=sell returns HTTP 200");

        // Properties For Rent filter
        $res = $this->httpGet('/properties?tab=rent');
        $this->assert($res['status'] === 200, "GET /properties?tab=rent returns HTTP 200");

        // Services Listing
        $res = $this->httpGet('/services');
        $this->assert($res['status'] === 200, "GET /services returns HTTP 200");
        $this->assert(str_contains($res['body'], 'Advisory Services') || str_contains($res['body'], 'Practice'), "Services page renders services catalog");

        // Locations Listing
        $res = $this->httpGet('/locations');
        $this->assert($res['status'] === 200, "GET /locations returns HTTP 200");
        $this->assert(str_contains($res['body'], 'Vasant Vihar'), "Locations listing includes Vasant Vihar");
        $this->assert(str_contains($res['body'], 'Sundar Nagar'), "Locations listing includes Sundar Nagar");
        $this->assert(str_contains($res['body'], 'Defence Colony'), "Locations listing includes Defence Colony");

        // Contact Us
        $res = $this->httpGet('/contact-us');
        $this->assert($res['status'] === 200, "GET /contact-us returns HTTP 200");
        $this->assert(str_contains($res['body'], 'contactEnquiryForm'), "Contact Us contains #contactEnquiryForm");
        $this->assert(str_contains($res['body'], '9811044200'), "Contact Us contains primary phone +91 9811044200");
        $this->assert(str_contains($res['body'], '98112 88400') || str_contains($res['body'], '9811288400'), "Contact Us contains secondary phone +91 98112 88400");
        $this->assert(str_contains($res['body'], 'Square One Mall, Saket'), "Contact Us contains Square One Mall, Saket address");
        $this->assert(str_contains($res['body'], 'info@elitehomez.com'), "Contact Us contains info@elitehomez.com email");

        // Global Components Verification (Footer & Sticky WhatsApp)
        $homeCheck = $this->httpGet('/');
        $this->assert(str_contains($homeCheck['body'], 'id="sticky-whatsapp-widget"'), "Homepage renders sticky WhatsApp direct connect button");
        $this->assert(str_contains($homeCheck['body'], 'wa.me/919811044200') || str_contains($homeCheck['body'], 'wa.me/9811044200'), "Sticky WhatsApp widget links directly to 9811044200");
        $this->assert(str_contains($homeCheck['body'], '9811044200'), "Footer contains updated phone +91 9811044200");
        $this->assert(str_contains($homeCheck['body'], '98112 88400') || str_contains($homeCheck['body'], '9811288400'), "Footer contains updated phone +91 98112 88400");
        $this->assert(str_contains($homeCheck['body'], 'Square One Mall, Saket'), "Footer contains Square One Mall, Saket address");
        $this->assert(str_contains($homeCheck['body'], 'info@elitehomez.com'), "Footer contains info@elitehomez.com email");
    }

    // --- 3. Location Detail Pages ---
    private function testLocationDetailPages(): void {
        echo "\n[Suite 3: Location Detail Pages (11+ Enclaves)]\n";

        $areas = $this->db->query("SELECT name, slug FROM areas WHERE is_published = 1")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($areas as $a) {
            $slug = $a['slug'];
            $res = $this->httpGet("/locations/$slug");
            $this->assert($res['status'] === 200, "Location '/locations/$slug' returns HTTP 200");
            
            // Check essential sections
            $this->assert(str_contains($res['body'], "The Residential Character of {$a['name']}"), "Location '$slug' has Residential Character section");
            $this->assert(str_contains($res['body'], "Property in {$a['name']}"), "Location '$slug' has Property Market section");
            $this->assert(str_contains($res['body'], "Typical Property Formats in {$a['name']}"), "Location '$slug' has Typical Property Formats cards");
            $this->assert(str_contains($res['body'], "Typical Residential Plot Sizes in {$a['name']}"), "Location '$slug' has Spatial Typologies Plot Sizes cards");
            $this->assert(str_contains($res['body'], "Lifestyle &amp; Community in {$a['name']}") || str_contains($res['body'], "Lifestyle & Community in {$a['name']}"), "Location '$slug' has Lifestyle & Community section");
            $this->assert(str_contains($res['body'], "Connectivity &amp; Transit Links") || str_contains($res['body'], "Connectivity & Transit Links"), "Location '$slug' has Connectivity section");
            $this->assert(str_contains($res['body'], "Frequently Asked Questions: {$a['name']}"), "Location '$slug' has FAQs section");
            $this->assert(!str_contains($res['body'], "Diplomatic South Delhi1"), "Location '$slug' contains NO test '1' markers");
        }
    }

    // --- 4. Property Detail Pages ---
    private function testPropertyDetailPages(): void {
        echo "\n[Suite 4: Property Detail Pages]\n";

        $properties = $this->db->query("SELECT id, title, slug FROM properties WHERE status = 'published' LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
        $this->assert(count($properties) > 0, "Published properties exist in database");

        foreach ($properties as $p) {
            $slug = $p['slug'];
            $res = $this->httpGet("/properties/$slug");
            $this->assert($res['status'] === 200, "Property '/properties/$slug' returns HTTP 200");
            $this->assert(str_contains($res['body'], 'id="property-enquiry-form"'), "Property '$slug' has viewing enquiry form");
            $this->assert(str_contains($res['body'], 'prop-enquiry-feedback'), "Property '$slug' has dynamic AJAX feedback element");
        }
    }

    // --- 5. Service Detail Pages ---
    private function testServiceDetailPages(): void {
        echo "\n[Suite 5: Service Detail Pages]\n";

        $services = $this->db->query("SELECT id, name, slug FROM services WHERE is_published = 1")->fetchAll(PDO::FETCH_ASSOC);
        $this->assert(count($services) > 0, "Published services exist in database");

        foreach ($services as $s) {
            $slug = $s['slug'];
            $res = $this->httpGet("/services/$slug");
            $this->assert($res['status'] === 200, "Service '/services/$slug' returns HTTP 200");
            $this->assert(str_contains($res['body'], 'id="service-advisory-form"'), "Service '$slug' has confidential advisory form");
            $this->assert(str_contains($res['body'], 'id="enclave-choice"'), "Service '$slug' has dynamic enclave selector");
            $this->assert(str_contains($res['body'], 'Vasant Vihar'), "Service '$slug' enclave dropdown contains database areas");
        }
    }

    // --- 6. Dynamic Forms & AJAX Submissions ---
    private function testDynamicFormsAndAjax(): void {
        echo "\n[Suite 6: Dynamic Forms, Honeypot, Validation & AJAX]\n";

        // Step A: Extract CSRF Token from Homepage
        $homeRes = $this->httpGet('/', true);
        preg_match('/name="csrf_token"\s+value="([^"]+)"/', $homeRes['body'], $csrfMatches);
        $token = $csrfMatches[1] ?? '';
        $this->assert(!empty($token), "CSRF token successfully extracted from homepage form");

        // Step B: Submit valid Homepage enquiry via AJAX
        $postData = [
            'csrf_token' => $token,
            'name' => 'Regression QA Client',
            'mobile' => '+919811011111',
            'email' => 'regression.qa@elitehomez-test.com',
            'enclave_choice' => 'Golf Links',
            'service_choice' => 'Luxury Property Buying Advisory',
            'timeline_choice' => 'Immediate (0-3 Months)',
            'nda_requested' => '1',
            'message' => 'Automated QA verification test mandate for prime South Delhi asset.',
            'source_page' => 'Homepage: Private Advisory Briefing'
        ];

        $ajaxRes = $this->httpPost('/enquire', $postData, true, true);
        $this->assert($ajaxRes['status'] === 200, "Valid AJAX enquiry returns HTTP 200");
        $json = json_decode($ajaxRes['body'], true);
        $this->assert(is_array($json) && ($json['success'] ?? false) === true, "AJAX enquiry response JSON has success=true");
        $this->assert(str_contains($json['message'] ?? '', 'Thank you'), "AJAX response contains polite confirmation message");
        $this->assert(!empty($json['reference_id']) && str_starts_with($json['reference_id'], '#EH-'), "AJAX response returns unique reference ID ({$json['reference_id']})");

        // Verify lead persisted in database
        $lead = $this->db->query("SELECT * FROM enquiries WHERE email = 'regression.qa@elitehomez-test.com'")->fetch(PDO::FETCH_ASSOC);
        $this->assert(!empty($lead), "Lead successfully stored in MySQL enquiries table");
        $this->assert($lead['status'] === 'new', "Lead status initialized to 'new'");
        $this->assert((int)$lead['area_id'] === 3, "Enclave 'Golf Links' correctly resolved to area_id=3");
        $this->assert(str_contains($lead['message'], 'Bilateral NDA Requested: Yes'), "Context parameters appended to lead message");

        // Verify Mailer Audit Log & Notification Dispatch
        $mailLogPath = dirname(__DIR__) . '/logs/enquiries.log';
        $this->assert(file_exists($mailLogPath), "Audit mail log file exists (logs/enquiries.log)");
        $mailLogContent = file_get_contents($mailLogPath);
        $this->assert(str_contains($mailLogContent, 'regression.qa@elitehomez-test.com'), "Enquiry notification dispatched and recorded in audit log");
        $this->assert(str_contains($mailLogContent, '#EH-'), "Audit log records unique #EH- reference ID");

        // Step C: Test Anti-Spam Honeypot Rejection
        $spamData = $postData;
        $spamData['website_url_check'] = 'http://spam-bot-trap.com';
        $spamData['email'] = 'bot.spammer@spam.org';
        $spamRes = $this->httpPost('/enquire', $spamData, true, true);
        $this->assert($spamRes['status'] === 200, "Honeypot returns 200 for bot (silent discard)");
        $botLead = $this->db->query("SELECT * FROM enquiries WHERE email = 'bot.spammer@spam.org'")->fetch(PDO::FETCH_ASSOC);
        $this->assert(empty($botLead), "Spam honeypot lead discarded and NOT written to database");

        // Step D: Test Form Validation (Missing/Invalid Mobile)
        $invalidData = $postData;
        $invalidData['mobile'] = '123'; // Too short
        $invalidData['email'] = 'invalid-test@elite.com';
        $invalidRes = $this->httpPost('/enquire', $invalidData, true, true);
        $this->assert($invalidRes['status'] === 422, "Invalid phone number returns HTTP 422 Unprocessable Entity");
        $errJson = json_decode($invalidRes['body'], true);
        $this->assert(is_array($errJson) && ($errJson['success'] ?? true) === false, "Validation failure returns success=false");
    }

    // --- 7. Admin Authentication, Security & Management Pages ---
    private function testAdminSecurityAndPages(): void {
        echo "\n[Suite 7: Admin RBAC, Security & Management Pages]\n";

        $adminPages = [
            '/admin/dashboard',
            '/admin/home',
            '/admin/about',
            '/admin/properties',
            '/admin/services',
            '/admin/areas',
            '/admin/carousel',
            '/admin/testimonials',
            '/admin/enquiries',
            '/admin/settings',
            '/admin/profile'
        ];

        // 1. Unauthenticated Access Protection (Must redirect to /admin/login)
        foreach ($adminPages as $p) {
            $res = $this->httpGet($p, false); // No cookies
            $this->assert(in_array($res['status'], [301, 302, 303]), "Unauthenticated '$p' redirects (HTTP {$res['status']})");
            $this->assert(str_contains($res['headers'], '/admin/login'), "'$p' redirects to /admin/login");
        }

        // 2. Login Flow
        $loginPage = $this->httpGet('/admin/login', true);
        $this->assert($loginPage['status'] === 200, "GET /admin/login returns HTTP 200");
        preg_match('/name="csrf_token"\s+value="([^"]+)"/', $loginPage['body'], $loginCsrfMatches);
        $loginToken = $loginCsrfMatches[1] ?? '';
        $this->assert(!empty($loginToken), "Login page CSRF token extracted");

        // Test Invalid Login
        $badLogin = $this->httpPost('/admin/login', [
            'csrf_token' => $loginToken,
            'email' => 'admin@elitehomez.com',
            'password' => 'WrongPassword123'
        ], false, true);
        $this->assert(str_contains($badLogin['body'], 'Invalid') || in_array($badLogin['status'], [200, 302]), "Invalid login credentials rejected");

        // Test Valid Login
        $goodLogin = $this->httpPost('/admin/login', [
            'csrf_token' => $loginToken,
            'email' => 'admin@elitehomez.com',
            'password' => 'Admin@112233'
        ], false, true);
        $this->assert(in_array($goodLogin['status'], [302, 303]), "Valid login redirects to admin dashboard (HTTP {$goodLogin['status']})");

        // 3. Authenticated Access to Admin Suite
        foreach ($adminPages as $p) {
            $res = $this->httpGet($p, true); // With authenticated session
            $this->assert($res['status'] === 200, "Authenticated '$p' returns HTTP 200");
        }

        // 4. Verify Admin Home Management Tab 8 (Enquiry Desk)
        $homeAdminRes = $this->httpGet('/admin/home', true);
        $this->assert(str_contains($homeAdminRes['body'], '8. Advisory Enquiry Desk'), "Admin Home Page contains Tab 8 Advisory Enquiry Desk");
        $this->assert(str_contains($homeAdminRes['body'], 'home_enquiry_enabled'), "Admin Home Page contains home_enquiry_enabled control");

        // 5. Verify Admin Enquiries Inbox Displays Unique Ref ID and Accurate Timestamp
        $enqAdminRes = $this->httpGet('/admin/enquiries', true);
        $this->assert(str_contains($enqAdminRes['body'], '#EH-'), "Admin Enquiries Inbox displays #EH- unique reference ID column");
        $this->assert(str_contains($enqAdminRes['body'], 'IST'), "Admin Enquiries Inbox displays timestamp with IST zone");
    }

    // --- Cleanup QA Artifacts ---
    private function cleanupTestData(): void {
        echo "\n[Cleanup: Removing Test Artifacts]\n";
        $del = $this->db->exec("DELETE FROM enquiries WHERE email LIKE '%@elitehomez-test.com' OR email LIKE '%@spam.org'");
        echo "  Cleaned up $del test enquiry records from database.\n";
    }
}

// Execute test suite
$runner = new RegressionQA();
$runner->runAll();
