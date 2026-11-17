<?php
declare(strict_types=1);

/**
 * Hero Carousel Comprehensive QA Test Suite
 * Tests dynamic content, form persistence, edit retention, and frontend rendering.
 */

class TestClient {
    private string $cookieFile;
    private string $baseUrl;

    public function __construct(string $baseUrl) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->cookieFile = sys_get_temp_dir() . '/test_cookie_' . uniqid() . '.txt';
    }

    public function __destruct() {
        if (file_exists($this->cookieFile)) {
            @unlink($this->cookieFile);
        }
    }

    public function get(string $path): array {
        $ch = curl_init($this->baseUrl . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, '');
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $body = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ['status' => $status, 'body' => (string) $body];
    }

    public function post(string $path, array $data): array {
        $ch = curl_init($this->baseUrl . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, '');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $body = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ['status' => $status, 'body' => (string) $body];
    }

    public function extractCsrf(string $html): string {
        if (preg_match('/name=\"csrf_token\"\s+value=\"([^\"]+)\"/', $html, $m)) {
            return $m[1];
        }
        return '';
    }
}

$client = new TestClient('http://127.0.0.1:8080');
$passed = 0;
$failed = 0;

function assertCondition(string $testName, bool $condition, string $detail = '') {
    global $passed, $failed;
    if ($condition) {
        echo "  [PASS] {$testName}\n";
        $passed++;
    } else {
        echo "  [FAIL] {$testName}: {$detail}\n";
        $failed++;
    }
}

echo "========================================================================\n";
echo " ELITE HOMEZ — HERO CAROUSEL EXTENSIVE AUTOMATED QA VERIFICATION SUITE\n";
echo "========================================================================\n\n";

// ------------------------------------------------------------------
// TEST CASE 1: Admin Authentication
// ------------------------------------------------------------------
echo "--- TEST CASE 1: Admin Authentication & Session Management ---\n";
$loginPage = $client->get('/admin/login');
$csrf = $client->extractCsrf($loginPage['body']);
assertCondition("CSRF token generated on login view", !empty($csrf));

$loginRes = $client->post('/admin/login', [
    'csrf_token' => $csrf,
    'email' => 'admin@elitehomez.com',
    'password' => 'EliteAdmin2026!'
]);
assertCondition("Admin authentication succeeded with valid session", str_contains($loginRes['body'], 'Hero Carousel Slides') || str_contains($loginRes['body'], 'Dashboard'));

// ------------------------------------------------------------------
// TEST CASE 2: Create a Fresh Test Slide with Full Typography & Media
// ------------------------------------------------------------------
echo "\n--- TEST CASE 2: Create Carousel Slide with Complete Field Set ---\n";
$createPage = $client->get('/admin/carousel/create');
$createCsrf = $client->extractCsrf($createPage['body']);
assertCondition("CSRF token generated on create view", !empty($createCsrf));

$uniqueId = rand(1000, 9999);
$testSlideData = [
    'csrf_token' => $createCsrf,
    'eyebrow' => "CONFIDENTIAL ADVISORY {$uniqueId} · SOUTH DELHI",
    'title' => "Signature Architectural Estate {$uniqueId}. Diplomatic Greens.",
    'subtitle' => "Private garden mansion overlooking lush diplomatic acreage, bespoke interiors, private elevator.",
    'primary_btn_text' => "Request Private Dossier {$uniqueId}",
    'primary_btn_url' => "/contact-us?mandate={$uniqueId}",
    'secondary_btn_text' => "Explore Portfolio",
    'secondary_btn_url' => "/properties",
    'trust_badge_1' => "RERA Certified DLRERA2023A00892",
    'trust_badge_2' => "100% Strict Bilateral NDA",
    'dossier_eyebrow' => "Trophy Mandate Dossier #{$uniqueId}",
    'dossier_title' => "Diplomatic Row 6-Beds",
    'badge_text' => "Off-Market Sole Advisory",
    'image_url' => "/assets/images/areas/chanakyapuri.jpg",
    'is_active' => "1",
    'sort_order' => "0"
];

$storeRes = $client->post('/admin/carousel/store', $testSlideData);
assertCondition("Store POST request executed and redirected to index", $storeRes['status'] === 200);

$indexPage = $client->get('/admin/carousel');
assertCondition("Admin Carousel list displays new slide title", str_contains($indexPage['body'], "Signature Architectural Estate {$uniqueId}"));
assertCondition("Admin Carousel list displays new eyebrow badge", str_contains($indexPage['body'], "CONFIDENTIAL ADVISORY {$uniqueId}"));
assertCondition("Admin Carousel list displays primary button", str_contains($indexPage['body'], "Request Private Dossier {$uniqueId}"));

// Extract new slide ID
preg_match('/action=\"[^\"]*\/admin\/carousel\/toggle-status\/(\d+)\"/', $indexPage['body'], $slideIdMatch);
$targetSlideId = (int) ($slideIdMatch[1] ?? 0);
assertCondition("Target slide ID extracted successfully (#{$targetSlideId})", $targetSlideId > 0);

// ------------------------------------------------------------------
// TEST CASE 3: Verify Edit View Displays All Entered Data (No Disappearing Info)
// ------------------------------------------------------------------
echo "\n--- TEST CASE 3: Inspect Edit View for Slide #{$targetSlideId} (Zero Disappearing Info) ---\n";
$editPage = $client->get("/admin/carousel/edit/{$targetSlideId}");
$editHtml = $editPage['body'];

assertCondition("Edit page loaded HTTP 200", $editPage['status'] === 200);
assertCondition("Eyebrow preserved in input value", str_contains($editHtml, "value=\"CONFIDENTIAL ADVISORY {$uniqueId} · SOUTH DELHI\""));
assertCondition("Title preserved in input value", str_contains($editHtml, "value=\"Signature Architectural Estate {$uniqueId}. Diplomatic Greens.\""));
assertCondition("Subtitle preserved in textarea", str_contains($editHtml, "Private garden mansion overlooking lush diplomatic acreage"));
assertCondition("Primary button text preserved", str_contains($editHtml, "value=\"Request Private Dossier {$uniqueId}\""));
assertCondition("Primary button URL preserved", str_contains($editHtml, "value=\"/contact-us?mandate={$uniqueId}\""));
assertCondition("Secondary button text preserved", str_contains($editHtml, "value=\"Explore Portfolio\""));
assertCondition("Secondary button URL preserved", str_contains($editHtml, "value=\"/properties\""));
assertCondition("Trust pillar 1 preserved", str_contains($editHtml, "value=\"RERA Certified DLRERA2023A00892\""));
assertCondition("Trust pillar 2 preserved", str_contains($editHtml, "value=\"100% Strict Bilateral NDA\""));
assertCondition("Dossier eyebrow preserved", str_contains($editHtml, "value=\"Trophy Mandate Dossier #{$uniqueId}\""));
assertCondition("Dossier headline preserved", str_contains($editHtml, "value=\"Diplomatic Row 6-Beds\""));
assertCondition("Status pill badge preserved", str_contains($editHtml, "value=\"Off-Market Sole Advisory\""));
assertCondition("Image URL preserved", str_contains($editHtml, "value=\"/assets/images/areas/chanakyapuri.jpg\""));
assertCondition("Active checkbox remains checked", str_contains($editHtml, 'name="is_active" value="1" checked'));

// ------------------------------------------------------------------
// TEST CASE 4: Update Slide with Modified Data & Verify Retention
// ------------------------------------------------------------------
echo "\n--- TEST CASE 4: Update Slide #{$targetSlideId} & Assert Persistence ---\n";
$editCsrf = $client->extractCsrf($editHtml);
assertCondition("CSRF token extracted from edit form", !empty($editCsrf));

$updatedData = [
    'csrf_token' => $editCsrf,
    'eyebrow' => "UPDATED LUXURY MANDATE {$uniqueId}",
    'title' => "Grand Residence Jor Bagh {$uniqueId}. Private Courtyard.",
    'subtitle' => "Updated description: refined luxury with expansive terrace gardens.",
    'primary_btn_text' => "Acquire Residence {$uniqueId}",
    'primary_btn_url' => "/properties/jor-bagh-luxury-floor",
    'secondary_btn_text' => "Arrange Private Tour",
    'secondary_btn_url' => "/contact-us",
    'trust_badge_1' => "Strict Family Office Protocol",
    'trust_badge_2' => "Direct Owner Representative",
    'dossier_eyebrow' => "Jor Bagh Enclave Collection",
    'dossier_title' => "Bespoke 5,000 Sq.Ft Triplex",
    'badge_text' => "Off-Market Private Sale",
    'image_url' => "/assets/images/areas/jor-bagh.jpg",
    'is_active' => "1",
    'sort_order' => "0"
];

$updateRes = $client->post("/admin/carousel/update/{$targetSlideId}", $updatedData);
assertCondition("Update POST executed successfully", $updateRes['status'] === 200);
assertCondition("Success flash notification confirmed", str_contains($updateRes['body'], "Carousel slide updated successfully."));

// Fetch edit page again to verify updated values do NOT disappear
$recheckEdit = $client->get("/admin/carousel/edit/{$targetSlideId}");
$recheckHtml = $recheckEdit['body'];

assertCondition("Updated eyebrow retained", str_contains($recheckHtml, "value=\"UPDATED LUXURY MANDATE {$uniqueId}\""));
assertCondition("Updated title retained", str_contains($recheckHtml, "value=\"Grand Residence Jor Bagh {$uniqueId}. Private Courtyard.\""));
assertCondition("Updated subtitle retained", str_contains($recheckHtml, "Updated description: refined luxury with expansive terrace gardens."));
assertCondition("Updated primary button text retained", str_contains($recheckHtml, "value=\"Acquire Residence {$uniqueId}\""));
assertCondition("Updated primary button URL retained", str_contains($recheckHtml, "value=\"/properties/jor-bagh-luxury-floor\""));
assertCondition("Updated trust badge 1 retained", str_contains($recheckHtml, "value=\"Strict Family Office Protocol\""));
assertCondition("Updated trust badge 2 retained", str_contains($recheckHtml, "value=\"Direct Owner Representative\""));
assertCondition("Updated dossier eyebrow retained", str_contains($recheckHtml, "value=\"Jor Bagh Enclave Collection\""));
assertCondition("Updated dossier headline retained", str_contains($recheckHtml, "value=\"Bespoke 5,000 Sq.Ft Triplex\""));
assertCondition("Updated badge pill retained", str_contains($recheckHtml, "value=\"Off-Market Private Sale\""));
assertCondition("Updated image URL retained", str_contains($recheckHtml, "value=\"/assets/images/areas/jor-bagh.jpg\""));

// ------------------------------------------------------------------
// TEST CASE 5: Front-End Homepage Dynamic Hero Verification
// ------------------------------------------------------------------
echo "\n--- TEST CASE 5: Verify Front-End Homepage Renders Exact Dynamic Data ---\n";
$homePage = $client->get('/');
$homeHtml = $homePage['body'];

assertCondition("Hero renders dynamic Eyebrow", str_contains($homeHtml, "UPDATED LUXURY MANDATE {$uniqueId}"));
assertCondition("Hero renders dynamic Title part 1", str_contains($homeHtml, "Grand Residence Jor Bagh {$uniqueId}."));
assertCondition("Hero renders dynamic Title gold italic part 2", str_contains($homeHtml, "Private Courtyard."));
assertCondition("Hero renders dynamic Subtitle", str_contains($homeHtml, "Updated description: refined luxury with expansive terrace gardens."));
assertCondition("Hero renders dynamic Primary Button", str_contains($homeHtml, "Acquire Residence {$uniqueId}") && str_contains($homeHtml, "/properties/jor-bagh-luxury-floor"));
assertCondition("Hero renders dynamic Secondary Button", str_contains($homeHtml, "Arrange Private Tour"));
assertCondition("Hero renders dynamic Trust Pillar 1", str_contains($homeHtml, "Strict Family Office Protocol"));
assertCondition("Hero renders dynamic Trust Pillar 2", str_contains($homeHtml, "Direct Owner Representative"));
assertCondition("Hero renders dynamic Dossier Eyebrow", str_contains($homeHtml, "Jor Bagh Enclave Collection"));
assertCondition("Hero renders dynamic Dossier Title", str_contains($homeHtml, "Bespoke 5,000 Sq.Ft Triplex"));
assertCondition("Hero renders dynamic Floating Status Badge", str_contains($homeHtml, "Off-Market Private Sale"));
assertCondition("Hero renders dynamic Background Image", str_contains($homeHtml, "assets/images/areas/jor-bagh.jpg"));

// ------------------------------------------------------------------
// TEST CASE 6: Clean Up Test Slide
// ------------------------------------------------------------------
echo "\n--- TEST CASE 6: Delete Test Slide #{$targetSlideId} & Verify Removal ---\n";
$adminList = $client->get('/admin/carousel');
$delToken = $client->extractCsrf($adminList['body']);
$delRes = $client->post("/admin/carousel/delete/{$targetSlideId}", ['csrf_token' => $delToken]);
assertCondition("Delete POST executed successfully", $delRes['status'] === 200);

$afterList = $client->get('/admin/carousel');
assertCondition("Slide #{$targetSlideId} removed from admin carousel list", !str_contains($afterList['body'], "Grand Residence Jor Bagh {$uniqueId}"));

echo "\n========================================================================\n";
echo " FINAL QA RESULTS: Total Tests: " . ($passed + $failed) . " | Passed: {$passed} | Failed: {$failed}\n";
echo "========================================================================\n";

if ($failed === 0) {
    echo "\n>>> ALL 40+ QA TEST CASES PASSED POSITIVELY! <<<\n";
    exit(0);
} else {
    echo "\n>>> QA SUITE FAILED: {$failed} ASSERTIONS FAILED <<<\n";
    exit(1);
}
