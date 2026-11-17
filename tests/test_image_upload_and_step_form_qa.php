<?php
declare(strict_types=1);

/**
 * Elite Homez - Comprehensive Automated QA Verification Suite
 * 
 * Verifies:
 * 1. Image file uploads and updates in Carousel slides.
 * 2. Image file uploads and updates in Testimonials.
 * 3. Frontend homepage verification of dynamic uploaded images.
 * 4. Service Area Multi-Step Form validation (glitch prevention: reject incomplete, accept complete).
 * 5. Service Area Edit and Hero Image update.
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
        $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        return ['status' => $status, 'body' => (string) $body, 'url' => $effectiveUrl];
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
        $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        return ['status' => $status, 'body' => (string) $body, 'url' => $effectiveUrl];
    }

    public function postMultipart(string $path, array $fields, array $files = []): array {
        $ch = curl_init($this->baseUrl . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, '');
        curl_setopt($ch, CURLOPT_POST, true);

        $postData = $fields;
        foreach ($files as $name => $filePath) {
            if (file_exists($filePath)) {
                $postData[$name] = new CURLFile($filePath, mime_content_type($filePath) ?: 'image/jpeg', basename($filePath));
            }
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $body = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        return ['status' => $status, 'body' => (string) $body, 'url' => $effectiveUrl];
    }

    public function extractCsrf(string $html): string {
        if (preg_match('/name=["\']csrf_token["\']\s+value=["\']([^"\']+)["\']/', $html, $m)) {
            return $m[1];
        }
        if (preg_match('/value=["\']([^"\']+)["\']\s+name=["\']csrf_token["\']/', $html, $m)) {
            return $m[1];
        }
        return '';
    }
}

function createDummyImage(int $w, int $h, int $r, int $g, int $b, string $label): string {
    $img = imagecreatetruecolor($w, $h);
    $bg = imagecolorallocate($img, $r, $g, $b);
    imagefilledrectangle($img, 0, 0, $w, $h, $bg);
    $textColor = imagecolorallocate($img, 255, 255, 255);
    imagestring($img, 5, 20, 20, $label, $textColor);
    $path = sys_get_temp_dir() . '/dummy_' . uniqid() . '.jpg';
    imagejpeg($img, $path, 90);
    imagedestroy($img);
    return $path;
}

$client = new TestClient('http://127.0.0.1:8080');
$passed = 0;
$failed = 0;

function report(bool $condition, string $msg) {
    global $passed, $failed;
    if ($condition) {
        echo "  [PASS] {$msg}\n";
        $passed++;
    } else {
        echo "  [FAIL] {$msg}\n";
        $failed++;
    }
}

echo "========================================================================\n";
echo " ELITE HOMEZ — IMAGE UPLOAD & SERVICE AREA STEP-FORM QA TEST SUITE\n";
echo "========================================================================\n\n";

// --- 1. ADMIN AUTHENTICATION ---
echo "--- 1. Admin Authentication ---\n";
$loginView = $client->get('/admin/login');
$csrf = $client->extractCsrf($loginView['body']);
report(!empty($csrf), "CSRF token extracted on login page");

$auth = $client->post('/admin/login', [
    'csrf_token' => $csrf,
    'email' => 'admin@elitehomez.com',
    'password' => 'EliteAdmin2026!'
]);
report(strpos($auth['body'], 'Dashboard') !== false || strpos($auth['url'], 'dashboard') !== false, "Admin authenticated successfully");

// --- 2. CAROUSEL IMAGE FILE UPLOAD & UPDATE ---
echo "\n--- 2. Carousel Slide: Image File Upload & Update QA ---\n";
$carouselCreateView = $client->get('/admin/carousel/create');
$csrf = $client->extractCsrf($carouselCreateView['body']);
report(!empty($csrf), "CSRF token obtained for Carousel Create form");

$dummySlideImg1 = createDummyImage(1200, 800, 20, 40, 80, "CAROUSEL TEST SLIDE 1");
$createRes = $client->postMultipart('/admin/carousel/store', [
    'csrf_token' => $csrf,
    'title' => 'QA Upload Slide Title',
    'subtitle' => 'Testing carousel file upload capability',
    'eyebrow' => 'OFF-MARKET UPLOAD TEST',
    'dossier_eyebrow' => 'Penthouse Dossier',
    'dossier_title' => 'Golf Links Residence',
    'badge_text' => 'Private Exclusive',
    'trust_badge_1' => 'RERA Certified',
    'trust_badge_2' => '100% Verified',
    'primary_btn_text' => 'View Penthouse',
    'primary_btn_url' => '/properties',
    'secondary_btn_text' => 'Inquire Now',
    'secondary_btn_url' => '/contact-us',
    'is_active' => '1',
    'sort_order' => '99'
], ['image' => $dummySlideImg1]);

report(strpos($createRes['body'], 'QA Upload Slide Title') !== false, "Slide created with file upload and appears in admin index");

// Find slide ID
preg_match('/\/admin\/carousel\/edit\/(\d+)[^>]*>[^<]*QA Upload Slide Title/s', $createRes['body'], $idMatch);
if (empty($idMatch)) {
    preg_match_all('/\/admin\/carousel\/edit\/(\d+)/', $createRes['body'], $allIds);
    $slideId = end($allIds[1]) ?? null;
} else {
    $slideId = $idMatch[1];
}
report(!empty($slideId), "Extracted created slide ID: #{$slideId}");

// Check that image file was saved to /uploads/carousel/
$slideEditView = $client->get("/admin/carousel/edit/{$slideId}");
preg_match('/name="image_url"[^>]*value="([^"]+)"/', $slideEditView['body'], $imgMatch);
$slideImg1Url = $imgMatch[1] ?? '';
report(strpos($slideImg1Url, '/uploads/carousel/') === 0, "Uploaded image stored in /uploads/carousel/: {$slideImg1Url}");
$serverDocRoot = '/Applications/XAMPP/xamppfiles/htdocs/Antigravity/Elite-Homez/public';
report(file_exists($serverDocRoot . $slideImg1Url), "Physical carousel image file confirmed on disk");

// Now update with a second uploaded image
$dummySlideImg2 = createDummyImage(1200, 800, 10, 80, 40, "CAROUSEL TEST SLIDE 2 UPDATED");
$csrf = $client->extractCsrf($slideEditView['body']);
$updateRes = $client->postMultipart("/admin/carousel/update/{$slideId}", [
    'csrf_token' => $csrf,
    'title' => 'QA Upload Slide Title (Updated)',
    'subtitle' => 'Testing carousel file upload update',
    'eyebrow' => 'OFF-MARKET UPLOAD TEST (UPDATED)',
    'dossier_eyebrow' => 'Penthouse Dossier',
    'dossier_title' => 'Golf Links Residence',
    'badge_text' => 'Private Exclusive',
    'trust_badge_1' => 'RERA Certified',
    'trust_badge_2' => '100% Verified',
    'primary_btn_text' => 'View Penthouse',
    'primary_btn_url' => '/properties',
    'secondary_btn_text' => 'Inquire Now',
    'secondary_btn_url' => '/contact-us',
    'is_active' => '1',
    'sort_order' => '99'
], ['image' => $dummySlideImg2]);

report(strpos($updateRes['body'], 'Carousel slide updated successfully') !== false, "Carousel update response confirmed success flash");
$slideEditView2 = $client->get("/admin/carousel/edit/{$slideId}");
preg_match('/name="image_url"[^>]*value="([^"]+)"/', $slideEditView2['body'], $imgMatch2);
$slideImg2Url = $imgMatch2[1] ?? '';
report(strpos($slideImg2Url, '/uploads/carousel/') === 0 && $slideImg2Url !== $slideImg1Url, "Slide updated to new distinct file upload: {$slideImg2Url}");
report(file_exists($serverDocRoot . $slideImg2Url), "Physical updated carousel image confirmed on disk");

// Cleanup test slide
$delCsrf = $client->extractCsrf($client->get('/admin/carousel')['body']);
$client->post("/admin/carousel/delete/{$slideId}", ['csrf_token' => $delCsrf]);
@unlink($dummySlideImg1);
@unlink($dummySlideImg2);

// --- 3. TESTIMONIAL IMAGE FILE UPLOAD & UPDATE ---
echo "\n--- 3. Testimonial: Image File Upload & Update QA ---\n";
$testimCreateView = $client->get('/admin/testimonials/create');
$csrf = $client->extractCsrf($testimCreateView['body']);
report(!empty($csrf), "CSRF token extracted for Testimonial Create form");

$dummyAvatar1 = createDummyImage(400, 400, 200, 100, 50, "AVATAR 1");
$testimCreateRes = $client->postMultipart('/admin/testimonials/store', [
    'csrf_token' => $csrf,
    'client_name' => 'QA Test Client HNI',
    'designation' => 'Managing Director, Sovereign Capital',
    'testimonial' => 'Elite Homez provided exemplary discreet advisory during our luxury bungalow acquisition in Jor Bagh.',
    'rating' => '5',
    'status' => '1',
    'sort_order' => '-1'
], ['image' => $dummyAvatar1]);

report(strpos($testimCreateRes['body'], 'QA Test Client HNI') !== false, "Testimonial created and listed in admin index");

// Find testimonial ID
if (preg_match('/<tr[^>]*>(?:(?!<\/tr>).)*?QA Test Client HNI.*?\/admin\/testimonials\/edit\/(\d+)/s', $testimCreateRes['body'], $tMatch)) {
    $testimId = $tMatch[1];
} else if (preg_match('/\/admin\/testimonials\/edit\/(\d+)/', $testimCreateRes['body'], $tMatch)) {
    $testimId = $tMatch[1];
} else {
    $testimId = null;
}
report(!empty($testimId), "Extracted created testimonial ID: #{$testimId}");

$testimEditView = $client->get("/admin/testimonials/edit/{$testimId}");
preg_match('/name="image_url"[^>]*value="([^"]+)"/', $testimEditView['body'], $tImgMatch);
$tImg1Url = $tImgMatch[1] ?? '';
report(strpos($tImg1Url, '/uploads/testimonials/') === 0, "Uploaded testimonial avatar stored in /uploads/testimonials/: {$tImg1Url}");
report(file_exists($serverDocRoot . $tImg1Url), "Physical avatar image confirmed on disk");

// Now update with a second uploaded avatar image
$dummyAvatar2 = createDummyImage(400, 400, 50, 150, 220, "AVATAR 2 UPDATED");
$csrf = $client->extractCsrf($testimEditView['body']);
$testimUpdateRes = $client->postMultipart("/admin/testimonials/update/{$testimId}", [
    'csrf_token' => $csrf,
    'client_name' => 'QA Test Client HNI (Updated)',
    'designation' => 'Chief Executive, Sovereign Capital',
    'testimonial' => 'Elite Homez provided extraordinary discreet advisory for our high-value transaction.',
    'rating' => '5',
    'status' => '1',
    'sort_order' => '-1'
], ['image' => $dummyAvatar2]);

$testimEditView2 = $client->get("/admin/testimonials/edit/{$testimId}");
preg_match('/name="image_url"[^>]*value="([^"]+)"/', $testimEditView2['body'], $tImgMatch2);
$tImg2Url = $tImgMatch2[1] ?? '';
report(strpos($tImg2Url, '/uploads/testimonials/') === 0 && $tImg2Url !== $tImg1Url, "Testimonial updated with new avatar image: {$tImg2Url}");
report(file_exists($serverDocRoot . $tImg2Url), "Physical updated avatar file exists on disk");

// Verify frontend homepage displays this testimonial and its updated image
$homeRes = $client->get('/');
report(strpos($homeRes['body'], 'QA Test Client HNI (Updated)') !== false, "Frontend homepage renders updated client name");
report(strpos($homeRes['body'], $tImg2Url) !== false, "Frontend homepage renders updated avatar image path: {$tImg2Url}");

// Cleanup test testimonial
$delCsrf = $client->extractCsrf($client->get('/admin/testimonials')['body']);
$client->post("/admin/testimonials/delete/{$testimId}", ['csrf_token' => $delCsrf]);
@unlink($dummyAvatar1);
@unlink($dummyAvatar2);

// --- 4. SERVICE AREA STEP FORM VALIDATION (NEGATIVE TEST) ---
echo "\n--- 4. Service Area Step Form: Glitch Prevention (Negative Test) ---\n";
$areaCreateView = $client->get('/admin/areas/create');
$csrf = $client->extractCsrf($areaCreateView['body']);
report(!empty($csrf), "CSRF token extracted for Area Create form");

// Attempt to submit only Step 1, omitting Market, Lifestyle, Advisory, FAQs, Alt Text, and SEO
$incompleteRes = $client->post('/admin/areas/store', [
    'csrf_token' => $csrf,
    'name' => 'Incomplete QA Test Area',
    'hero_title' => 'Incomplete Title',
    'short_description' => 'Short summary only'
    // Missing: overview, property_market, lifestyle, connectivity, buyer_info, rental_info, faqs, hero_image_alt, seo_title, meta_description
]);

report(
    strpos($incompleteRes['body'], 'All 7 steps must be completed') !== false ||
    strpos($incompleteRes['body'], 'Incomplete fields:') !== false,
    "Backend rejected incomplete submission and flashed 7-step completion requirement"
);

// Verify that the incomplete area was NOT added to the database
$areaList = $client->get('/admin/areas');
report(strpos($areaList['body'], 'Incomplete QA Test Area') === false, "Incomplete area was not created in database");

// --- 5. SERVICE AREA COMPLETE 7-STEP SUBMISSION (POSITIVE TEST) ---
echo "\n--- 5. Service Area Step Form: Full 7-Step Submission & Image Upload ---\n";
$areaHeroImg1 = createDummyImage(1600, 900, 30, 30, 30, "SUNDER NAGAR HERO");
$csrf = $client->extractCsrf($client->get('/admin/areas/create')['body']);

$completeRes = $client->postMultipart('/admin/areas/store', [
    'csrf_token' => $csrf,
    // Step 1: Overview & Identity
    'name' => 'Sunder Nagar QA Elite',
    'hero_title' => 'Ultra-Luxury Mansions & Estates in Sunder Nagar',
    'hero_subtitle' => 'Historic prestige bordering Delhi Zoo and prestigious art institutions.',
    'short_description' => 'Sunder Nagar is one of central-south Delhi’s most serene and exclusive boutique residential enclaves.',
    'overview' => 'Sunder Nagar presents an intimate enclave characterized by wide green avenues, low-density residences, and proximity to diplomatic avenues.',
    // Step 2: Market & Property Types
    'property_market' => 'Property valuations in Sunder Nagar command ₹80,000 to ₹1,20,000 per sq ft for standalone builder floors and historic bungalows.',
    'property_types' => json_encode(['Luxury Builder Floors', 'Heritage Bungalows', 'Penthouse Duplexes']),
    'plot_sizes' => json_encode(['500 sq yds', '800 sq yds', '1200 sq yds']),
    // Step 3: Lifestyle & Connectivity
    'lifestyle' => 'Quiet, leafy neighborhood culture celebrated for Sunder Nagar Market art galleries, handicrafts, and upscale dining.',
    'connectivity' => 'Direct access to Mathura Road, Dr Zakir Hussain Marg, Delhi Golf Club, and Khan Market in under 5 minutes.',
    'nearby_landmarks' => json_encode(['Delhi Zoo', 'Khan Market', 'Sunder Nursery', 'Delhi Golf Club']),
    'schools' => json_encode(['Delhi Public School Mathura Road', 'Modern School Barakhamba']),
    'healthcare' => json_encode(['Max Healthcare', 'Fortis C-Doc', 'Apollo Hospital']),
    'shopping' => json_encode(['Sunder Nagar Market', 'Khan Market', 'The Claridges Arcade']),
    'recreation' => json_encode(['Delhi Golf Club', 'Gymkhana Club nearby', 'Sunder Nursery heritage walks']),
    // Step 4: Advisory & Considerations
    'buyer_information' => 'Buyer considerations involve verifying clear freehold land titles and building height clearances.',
    'rental_information' => 'High rental yields from diplomatic personnel, cultural attaches, and senior expatriate corporate leadership.',
    'advisory_content' => 'Elite Homez maintains off-market mandates with private families in Sunder Nagar ensuring strictly confidential advisory.',
    // Step 5: FAQs
    'faqs' => json_encode([
        ['question' => 'What is the average plot size in Sunder Nagar?', 'answer' => 'Standard plots range between 500 to 1,200 square yards.'],
        ['question' => 'Are properties in Sunder Nagar freehold?', 'answer' => 'Yes, most residential estates have been converted to clear freehold titles.']
    ]),
    // Step 6: Visual Assets & Hero Image
    'hero_image_alt' => 'Sunder Nagar Luxury Mansions South Delhi',
    'gallery' => json_encode(['/assets/images/areas/sunder-nagar-1.jpg', '/assets/images/areas/sunder-nagar-2.jpg']),
    // Step 7: SEO & Publishing Controls
    'seo_title' => 'Luxury Real Estate & Mansions in Sunder Nagar | Elite Homez',
    'meta_description' => 'Explore luxury residences, private mansions, and bespoke floors in Sunder Nagar, South Delhi with Elite Homez advisory.',
    'primary_keyword' => 'luxury homes in Sunder Nagar Delhi',
    'secondary_keywords' => 'Sunder Nagar mansions, buy property Sunder Nagar, luxury real estate South Delhi',
    'is_published' => '1',
    'show_on_home' => '1',
    'sort_order' => '10'
], ['hero_image' => $areaHeroImg1]);

report(
    strpos($completeRes['body'], 'Sunder Nagar QA Elite') !== false ||
    strpos($completeRes['body'], 'Area created successfully') !== false,
    "Full 7-step submission succeeded and redirected to Area admin index"
);

// Find area ID
$areaListHtml = $client->get('/admin/areas')['body'];
if (preg_match('/<tr[^>]*>(?:(?!<\/tr>).)*?Sunder Nagar QA Elite.*?\/admin\/areas\/edit\/(\d+)/s', $areaListHtml, $areaMatch)) {
    $areaId = $areaMatch[1];
} else if (preg_match('/\/admin\/areas\/edit\/(\d+)/', $areaListHtml, $areaMatch)) {
    $areaId = $areaMatch[1];
} else {
    $areaId = null;
}
report(!empty($areaId), "Extracted created service area ID: #{$areaId}");

// Check area edit view and uploaded image
$areaEditView = $client->get("/admin/areas/edit/{$areaId}");
preg_match('/name="hero_image_url"[^>]*value="([^"]+)"/', $areaEditView['body'], $areaImgMatch);
$areaImg1Url = $areaImgMatch[1] ?? '';
report(strpos($areaImg1Url, '/uploads/areas/') === 0, "Area hero image saved in /uploads/areas/: {$areaImg1Url}");
report(file_exists($serverDocRoot . $areaImg1Url), "Physical area hero image exists on disk");

// --- 6. SERVICE AREA EDIT & HERO IMAGE UPDATE ---
echo "\n--- 6. Service Area: Edit & Hero Image Update QA ---\n";
$areaHeroImg2 = createDummyImage(1600, 900, 10, 60, 100, "SUNDER NAGAR HERO UPDATED");
$csrf = $client->extractCsrf($areaEditView['body']);

$areaUpdateRes = $client->postMultipart("/admin/areas/update/{$areaId}", [
    'csrf_token' => $csrf,
    'name' => 'Sunder Nagar QA Elite',
    'hero_title' => 'Grand Architectural Estates in Sunder Nagar',
    'hero_subtitle' => 'Historic prestige bordering Delhi Zoo and prestigious art institutions.',
    'short_description' => 'Sunder Nagar is one of central-south Delhi’s most serene and exclusive boutique residential enclaves.',
    'overview' => 'Sunder Nagar presents an intimate enclave characterized by wide green avenues, low-density residences, and proximity to diplomatic avenues.',
    'property_market' => 'Updated property valuations commanding prime price points.',
    'property_types' => json_encode(['Luxury Builder Floors', 'Heritage Bungalows']),
    'plot_sizes' => json_encode(['600 sq yds', '1200 sq yds']),
    'lifestyle' => 'Leafy avenues and private gardens.',
    'connectivity' => 'Direct access to Mathura Road.',
    'nearby_landmarks' => json_encode(['Delhi Zoo', 'Khan Market']),
    'schools' => json_encode(['DPS Mathura Road']),
    'healthcare' => json_encode(['Max Healthcare']),
    'shopping' => json_encode(['Sunder Nagar Market']),
    'recreation' => json_encode(['Delhi Golf Club']),
    'buyer_information' => 'Buyer considerations involve title verifications.',
    'rental_information' => 'High rental yields from embassy attaches.',
    'advisory_content' => 'Strictly confidential advisory.',
    'faqs' => json_encode([['question' => 'Q1?', 'answer' => 'A1!']]),
    'hero_image_alt' => 'Updated Sunder Nagar Alt Text',
    'gallery' => json_encode([]),
    'seo_title' => 'Updated Sunder Nagar SEO Title',
    'meta_description' => 'Updated Sunder Nagar SEO Meta Description',
    'primary_keyword' => 'luxury homes in Sunder Nagar',
    'secondary_keywords' => 'sunder nagar real estate',
    'is_published' => '1',
    'show_on_home' => '1',
    'sort_order' => '10'
], ['hero_image' => $areaHeroImg2]);

report(
    strpos($areaUpdateRes['body'], 'updated successfully') !== false,
    "Service Area updated successfully via multi-step edit form"
);

$areaEditView2 = $client->get("/admin/areas/edit/{$areaId}");
preg_match('/name="hero_image_url"[^>]*value="([^"]+)"/', $areaEditView2['body'], $areaImgMatch2);
$areaImg2Url = $areaImgMatch2[1] ?? '';
report(strpos($areaImg2Url, '/uploads/areas/') === 0 && $areaImg2Url !== $areaImg1Url, "Hero image updated to new file: {$areaImg2Url}");
report(file_exists($serverDocRoot . $areaImg2Url), "Physical updated hero image exists on disk");

// Verify frontend area page renders updated data and image
$areaSlugRes = $client->get('/areas/sunder-nagar-qa-elite');
report($areaSlugRes['status'] === 200, "Frontend service area page loaded HTTP 200");
report(strpos($areaSlugRes['body'], 'Grand Architectural Estates in Sunder Nagar') !== false, "Frontend page renders updated hero title");
report(strpos($areaSlugRes['body'], $areaImg2Url) !== false, "Frontend page renders updated hero image URL");

// --- 7. CLEANUP ---
echo "\n--- 7. Cleanup Test Entities ---\n";
$delAreaCsrf = $client->extractCsrf($client->get('/admin/areas')['body']);
$client->post("/admin/areas/delete/{$areaId}", ['csrf_token' => $delAreaCsrf]);
$checkAreaGone = $client->get('/admin/areas');
report(strpos($checkAreaGone['body'], 'Sunder Nagar QA Elite') === false, "Test Service Area removed cleanly from database");

@unlink($areaHeroImg1);
@unlink($areaHeroImg2);

echo "\n========================================================================\n";
echo " FINAL QA VERIFICATION RESULTS: Total: " . ($passed + $failed) . " | Passed: {$passed} | Failed: {$failed}\n";
echo "========================================================================\n\n";

if ($failed === 0) {
    echo ">>> ALL QA TEST CASES PASSED POSITIVELY! <<<\n";
    exit(0);
} else {
    echo ">>> QA SUITE FAILED: {$failed} ASSERTIONS FAILED <<<\n";
    exit(1);
}
