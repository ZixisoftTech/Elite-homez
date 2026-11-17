<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\Session;
use App\Helpers\Uploader;
use App\Models\Service;

class ServiceAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $serviceModel = new Service();
        $services = $serviceModel->all('sort_order ASC, name ASC');

        $this->renderAdmin('admin/services/index', [
            'services' => $services,
            'seo' => ['title' => 'Advisory Services Management | Elite Homez']
        ]);
    }

    public function create(): void {
        $this->requireAuth();
        $this->renderAdmin('admin/services/create', [
            'seo' => ['title' => 'Add Advisory Service | Elite Homez']
        ]);
    }

    public function store(): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/services/create');
            return;
        }

        $name = trim((string) $this->request->post('name', ''));
        $shortDesc = trim((string) $this->request->post('short_description', ''));
        $content = trim((string) $this->request->post('content', ''));
        $icon = trim((string) $this->request->post('icon', 'compass'));
        $isPublished = $this->request->post('is_published') ? 1 : 0;
        $showOnHome = $this->request->post('show_on_home') ? 1 : 0;
        $sortOrder = (int) $this->request->post('sort_order', 0);
        $seoTitle = trim((string) $this->request->post('seo_title', ''));
        $metaDesc = trim((string) $this->request->post('meta_description', ''));

        if (empty($name) || empty($shortDesc)) {
            Session::setFlash('error', 'Service name and summary lead description are required.');
            $this->redirect('/admin/services/create');
            return;
        }

        $serviceModel = new Service();
        $rawSlug = trim((string) $this->request->post('slug', ''));
        $slug = !empty($rawSlug) ? Format::slug($rawSlug) : Format::slug($name);
        if ($serviceModel->findBySlug($slug)) {
            $slug .= '-' . rand(10, 99);
        }

        // Process repeaters
        $approachStatsJson = $this->encodeRepeater($this->request->post('approach_stats'));
        $deliverablesItemsJson = $this->encodeRepeater($this->request->post('deliverables_items'));
        $roadmapStepsJson = $this->encodeRepeater($this->request->post('roadmap_steps'));
        $whyPillarsJson = $this->encodeRepeater($this->request->post('why_pillars'));
        $valuePropCheckmarksJson = $this->encodeStringRepeater($this->request->post('value_prop_checkmarks'));
        $audienceProfilesJson = $this->encodeRepeater($this->request->post('audience_profiles'));
        $faqsItemsJson = $this->encodeRepeater($this->request->post('faqs_items'));
        $heroFeaturesJson = $this->encodeStringRepeater($this->request->post('hero_features'));
        $enquiryFeaturesJson = $this->encodeStringRepeater($this->request->post('enquiry_features'));

        // Primary Hero Image
        $directImage = trim((string) ($this->request->post('image_url') ?: $this->request->post('image_path') ?: ''));
        $imagePath = !empty($directImage) ? $directImage : '/assets/images/services/residential-advisory.jpg';
        $file = $this->request->file('image');
        if ($file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($file, 'services');
            if ($upload['success']) {
                $imagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Primary service image upload failed: ' . $upload['message']);
                $this->redirect('/admin/services/create');
                return;
            }
        }

        // Parallax Banner Image
        $directBanner = trim((string) ($this->request->post('banner_image_url') ?: ''));
        $bannerImagePath = !empty($directBanner) ? $directBanner : '/assets/images/stitch/service-living-pause.jpg';
        $bannerFile = $this->request->file('banner_image');
        if ($bannerFile && isset($bannerFile['error']) && $bannerFile['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($bannerFile, 'services');
            if ($upload['success']) {
                $bannerImagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Banner image upload failed: ' . $upload['message']);
                $this->redirect('/admin/services/create');
                return;
            }
        }

        // Showcase Image
        $directShowcase = trim((string) ($this->request->post('showcase_image_url') ?: ''));
        $showcaseImagePath = !empty($directShowcase) ? $directShowcase : '/assets/images/stitch/service-master-suite.jpg';
        $showcaseFile = $this->request->file('showcase_image');
        if ($showcaseFile && isset($showcaseFile['error']) && $showcaseFile['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($showcaseFile, 'services');
            if ($upload['success']) {
                $showcaseImagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Showcase image upload failed: ' . $upload['message']);
                $this->redirect('/admin/services/create');
                return;
            }
        }

        // Bottom CTA Image
        $directCtaImg = trim((string) ($this->request->post('cta_image_url') ?: ''));
        $ctaImagePath = !empty($directCtaImg) ? $directCtaImg : '/assets/images/stitch/service-cta-dusk.jpg';
        $ctaFile = $this->request->file('cta_image');
        if ($ctaFile && isset($ctaFile['error']) && $ctaFile['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($ctaFile, 'services');
            if ($upload['success']) {
                $ctaImagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'CTA image upload failed: ' . $upload['message']);
                $this->redirect('/admin/services/create');
                return;
            }
        }

        $serviceModel->create([
            'name' => $name,
            'slug' => $slug,
            'short_description' => $shortDesc,
            'content' => $content,
            'icon' => $icon,
            'image' => $imagePath,
            'hero_badge' => trim((string) $this->request->post('hero_badge', '')),
            'hero_tagline' => trim((string) $this->request->post('hero_tagline', 'ELITE HOMEZ · PRIVATE REAL ESTATE ADVISORY')),
            'hero_fiduciary_title' => trim((string) $this->request->post('hero_fiduciary_title', 'Exclusive Buy-Side Mandate')),
            'hero_fiduciary_badge' => trim((string) $this->request->post('hero_fiduciary_badge', 'Zero Conflict')),
            'hero_cta_text' => trim((string) $this->request->post('hero_cta_text', 'Speak with an Advisor')),
            'hero_cta_url' => trim((string) $this->request->post('hero_cta_url', '#confidential-desk')),
            'hero_features' => $heroFeaturesJson,
            'approach_eyebrow' => trim((string) $this->request->post('approach_eyebrow', 'The Elite Homez Approach')),
            'approach_title' => trim((string) $this->request->post('approach_title', 'Property decisions deserve a more personal, discreet approach.')),
            'approach_description' => trim((string) $this->request->post('approach_description', '')),
            'approach_stats' => $approachStatsJson,
            'deliverables_eyebrow' => trim((string) $this->request->post('deliverables_eyebrow', 'Systematic Due Diligence')),
            'deliverables_title' => trim((string) $this->request->post('deliverables_title', 'What We Do')),
            'deliverables_subtitle' => trim((string) $this->request->post('deliverables_subtitle', 'A rigorous, institutional methodology tailored specifically to high-value residential acquisitions.')),
            'deliverables_items' => $deliverablesItemsJson,
            'roadmap_eyebrow' => trim((string) $this->request->post('roadmap_eyebrow', 'Acquisition Roadmap')),
            'roadmap_title' => trim((string) $this->request->post('roadmap_title', 'From Requirement to Handover')),
            'roadmap_subtitle' => trim((string) $this->request->post('roadmap_subtitle', 'A structured journey engineered for absolute peace of mind and decisive execution.')),
            'roadmap_steps' => $roadmapStepsJson,
            'banner_tag' => trim((string) $this->request->post('banner_tag', 'Perspective · Discernment · Heritage')),
            'banner_quote' => trim((string) $this->request->post('banner_quote', '“Access matters. Judgement matters more.”')),
            'banner_subquote' => trim((string) $this->request->post('banner_subquote', 'Our role is not simply to show you property. It is to help you make an enduring, generational decision.')),
            'banner_btn_text' => trim((string) $this->request->post('banner_btn_text', 'Request A Private Briefing')),
            'banner_btn_url' => trim((string) $this->request->post('banner_btn_url', '#confidential-desk')),
            'banner_image' => $bannerImagePath,
            'why_eyebrow' => trim((string) $this->request->post('why_eyebrow', 'Fiduciary Excellence')),
            'why_title' => trim((string) $this->request->post('why_title', 'Why Elite Homez')),
            'why_subtitle' => trim((string) $this->request->post('why_subtitle', 'Institutional experience, total discretion, and granular mastery of premier South Delhi real estate.')),
            'why_pillars' => $whyPillarsJson,
            'showcase_image' => $showcaseImagePath,
            'showcase_caption' => trim((string) $this->request->post('showcase_caption', 'Private Residence · Vasant Vihar')),
            'showcase_tag' => trim((string) $this->request->post('showcase_tag', 'Curated Acquisition')),
            'value_prop_eyebrow' => trim((string) $this->request->post('value_prop_eyebrow', 'Beyond Brokering')),
            'value_prop_title' => trim((string) $this->request->post('value_prop_title', 'More than a property transaction. An enduring generational asset.')),
            'value_prop_body' => trim((string) $this->request->post('value_prop_body', '')),
            'value_prop_checkmarks' => $valuePropCheckmarksJson,
            'audience_eyebrow' => trim((string) $this->request->post('audience_eyebrow', 'Tailored Client Desks')),
            'audience_title' => trim((string) $this->request->post('audience_title', 'Who We Help')),
            'audience_subtitle' => trim((string) $this->request->post('audience_subtitle', 'Our advisory practice is crafted specifically for discerning purchasers with distinct governance criteria.')),
            'audience_profiles' => $audienceProfilesJson,
            'faqs_eyebrow' => trim((string) $this->request->post('faqs_eyebrow', 'Bespoke Guidance & Clarity')),
            'faqs_title' => trim((string) $this->request->post('faqs_title', 'Frequently Asked Questions')),
            'faqs_subtitle' => trim((string) $this->request->post('faqs_subtitle', 'Clear answers to the most common questions regarding our private advisory services.')),
            'faqs_items' => $faqsItemsJson,
            'enquiry_eyebrow' => trim((string) $this->request->post('enquiry_eyebrow', 'Confidential Dialogue')),
            'enquiry_title' => trim((string) $this->request->post('enquiry_title', 'Initiate a Private Advisory Briefing')),
            'enquiry_description' => trim((string) $this->request->post('enquiry_description', '')),
            'enquiry_features' => $enquiryFeaturesJson,
            'enquiry_btn_text' => trim((string) $this->request->post('enquiry_btn_text', 'Submit Confidential Mandate')),
            'cta_eyebrow' => trim((string) $this->request->post('cta_eyebrow', 'Elite Homez Advisory')),
            'cta_title' => trim((string) $this->request->post('cta_title', 'The right property starts with the right advice.')),
            'cta_subtitle' => trim((string) $this->request->post('cta_subtitle', 'Discover a more considered, confidential way to navigate premier Delhi NCR real estate.')),
            'cta_image' => $ctaImagePath,
            'cta_btn1_text' => trim((string) $this->request->post('cta_btn1_text', 'Explore Properties Catalogue')),
            'cta_btn1_url' => trim((string) $this->request->post('cta_btn1_url', '/properties')),
            'cta_btn2_text' => trim((string) $this->request->post('cta_btn2_text', 'Contact Advisory Desk')),
            'cta_btn2_url' => trim((string) $this->request->post('cta_btn2_url', '/contact-us')),
            'is_published' => $isPublished,
            'show_on_home' => $showOnHome,
            'sort_order' => $sortOrder,
            'seo_title' => $seoTitle ?: "{$name} | Elite Homez Advisory",
            'meta_description' => $metaDesc ?: substr(strip_tags($shortDesc), 0, 160)
        ]);

        Session::setFlash('success', "Service '{$name}' created successfully.");
        $this->redirect('/admin/services');
    }

    public function edit(string $id): void {
        $this->requireAuth();
        $serviceModel = new Service();
        $service = $serviceModel->find((int) $id);
        if (!$service) {
            Session::setFlash('error', 'Service not found.');
            $this->redirect('/admin/services');
            return;
        }

        $this->renderAdmin('admin/services/edit', [
            'service' => $service,
            'seo' => ['title' => "Edit {$service['name']} | Elite Homez Admin"]
        ]);
    }

    public function update(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect("/admin/services/edit/{$id}");
            return;
        }

        $serviceModel = new Service();
        $service = $serviceModel->find((int) $id);
        if (!$service) {
            Session::setFlash('error', 'Service not found.');
            $this->redirect('/admin/services');
            return;
        }

        $name = trim((string) $this->request->post('name', ''));
        $shortDesc = trim((string) $this->request->post('short_description', ''));
        $content = trim((string) $this->request->post('content', ''));
        $icon = trim((string) $this->request->post('icon', $service['icon'] ?? 'compass'));
        $isPublished = $this->request->post('is_published') ? 1 : 0;
        $showOnHome = $this->request->post('show_on_home') ? 1 : 0;
        $sortOrder = (int) $this->request->post('sort_order', 0);
        $seoTitle = trim((string) $this->request->post('seo_title', ''));
        $metaDesc = trim((string) $this->request->post('meta_description', ''));

        if (empty($name) || empty($shortDesc)) {
            Session::setFlash('error', 'Service name and short description are required.');
            $this->redirect("/admin/services/edit/{$id}");
            return;
        }

        // Handle slug
        $rawSlug = trim((string) $this->request->post('slug', ''));
        $targetSlug = !empty($rawSlug) ? Format::slug($rawSlug) : Format::slug($name);
        $existing = $serviceModel->findBySlug($targetSlug);
        if ($existing && (int)$existing['id'] !== (int)$id) {
            $targetSlug .= '-' . rand(10, 99);
        }

        // Process repeaters
        $approachStatsJson = $this->encodeRepeater($this->request->post('approach_stats'));
        $deliverablesItemsJson = $this->encodeRepeater($this->request->post('deliverables_items'));
        $roadmapStepsJson = $this->encodeRepeater($this->request->post('roadmap_steps'));
        $whyPillarsJson = $this->encodeRepeater($this->request->post('why_pillars'));
        $valuePropCheckmarksJson = $this->encodeStringRepeater($this->request->post('value_prop_checkmarks'));
        $audienceProfilesJson = $this->encodeRepeater($this->request->post('audience_profiles'));
        $faqsItemsJson = $this->encodeRepeater($this->request->post('faqs_items'));
        $heroFeaturesJson = $this->encodeStringRepeater($this->request->post('hero_features'));
        $enquiryFeaturesJson = $this->encodeStringRepeater($this->request->post('enquiry_features'));

        // Primary Hero Image
        $directImage = trim((string) ($this->request->post('image_url') ?: $this->request->post('image_path') ?: ''));
        $imagePath = !empty($directImage) ? $directImage : (!empty($service['image']) ? $service['image'] : '/assets/images/services/residential-advisory.jpg');
        $file = $this->request->file('image');
        if ($file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($file, 'services');
            if ($upload['success']) {
                $imagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Primary service image upload failed: ' . $upload['message']);
                $this->redirect("/admin/services/edit/{$id}");
                return;
            }
        }

        // Parallax Banner Image
        $directBanner = trim((string) ($this->request->post('banner_image_url') ?: ''));
        $bannerImagePath = !empty($directBanner) ? $directBanner : ($service['banner_image'] ?? '/assets/images/stitch/service-living-pause.jpg');
        $bannerFile = $this->request->file('banner_image');
        if ($bannerFile && isset($bannerFile['error']) && $bannerFile['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($bannerFile, 'services');
            if ($upload['success']) {
                $bannerImagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Banner image upload failed: ' . $upload['message']);
                $this->redirect("/admin/services/edit/{$id}");
                return;
            }
        }

        // Showcase Image
        $directShowcase = trim((string) ($this->request->post('showcase_image_url') ?: ''));
        $showcaseImagePath = !empty($directShowcase) ? $directShowcase : ($service['showcase_image'] ?? '/assets/images/stitch/service-master-suite.jpg');
        $showcaseFile = $this->request->file('showcase_image');
        if ($showcaseFile && isset($showcaseFile['error']) && $showcaseFile['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($showcaseFile, 'services');
            if ($upload['success']) {
                $showcaseImagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Showcase image upload failed: ' . $upload['message']);
                $this->redirect("/admin/services/edit/{$id}");
                return;
            }
        }

        // Bottom CTA Image
        $directCtaImg = trim((string) ($this->request->post('cta_image_url') ?: ''));
        $ctaImagePath = !empty($directCtaImg) ? $directCtaImg : ($service['cta_image'] ?? '/assets/images/stitch/service-cta-dusk.jpg');
        $ctaFile = $this->request->file('cta_image');
        if ($ctaFile && isset($ctaFile['error']) && $ctaFile['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($ctaFile, 'services');
            if ($upload['success']) {
                $ctaImagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'CTA image upload failed: ' . $upload['message']);
                $this->redirect("/admin/services/edit/{$id}");
                return;
            }
        }

        $serviceModel->update((int) $id, [
            'name' => $name,
            'slug' => $targetSlug,
            'short_description' => $shortDesc,
            'content' => $content,
            'icon' => $icon,
            'image' => $imagePath,
            'hero_badge' => trim((string) $this->request->post('hero_badge', '')),
            'hero_tagline' => trim((string) $this->request->post('hero_tagline', 'ELITE HOMEZ · PRIVATE REAL ESTATE ADVISORY')),
            'hero_fiduciary_title' => trim((string) $this->request->post('hero_fiduciary_title', 'Exclusive Buy-Side Mandate')),
            'hero_fiduciary_badge' => trim((string) $this->request->post('hero_fiduciary_badge', 'Zero Conflict')),
            'hero_cta_text' => trim((string) $this->request->post('hero_cta_text', 'Speak with an Advisor')),
            'hero_cta_url' => trim((string) $this->request->post('hero_cta_url', '#confidential-desk')),
            'hero_features' => $heroFeaturesJson,
            'approach_eyebrow' => trim((string) $this->request->post('approach_eyebrow', 'The Elite Homez Approach')),
            'approach_title' => trim((string) $this->request->post('approach_title', 'Property decisions deserve a more personal, discreet approach.')),
            'approach_description' => trim((string) $this->request->post('approach_description', '')),
            'approach_stats' => $approachStatsJson,
            'deliverables_eyebrow' => trim((string) $this->request->post('deliverables_eyebrow', 'Systematic Due Diligence')),
            'deliverables_title' => trim((string) $this->request->post('deliverables_title', 'What We Do')),
            'deliverables_subtitle' => trim((string) $this->request->post('deliverables_subtitle', 'A rigorous, institutional methodology tailored specifically to high-value residential acquisitions.')),
            'deliverables_items' => $deliverablesItemsJson,
            'roadmap_eyebrow' => trim((string) $this->request->post('roadmap_eyebrow', 'Acquisition Roadmap')),
            'roadmap_title' => trim((string) $this->request->post('roadmap_title', 'From Requirement to Handover')),
            'roadmap_subtitle' => trim((string) $this->request->post('roadmap_subtitle', 'A structured journey engineered for absolute peace of mind and decisive execution.')),
            'roadmap_steps' => $roadmapStepsJson,
            'banner_tag' => trim((string) $this->request->post('banner_tag', 'Perspective · Discernment · Heritage')),
            'banner_quote' => trim((string) $this->request->post('banner_quote', '“Access matters. Judgement matters more.”')),
            'banner_subquote' => trim((string) $this->request->post('banner_subquote', 'Our role is not simply to show you property. It is to help you make an enduring, generational decision.')),
            'banner_btn_text' => trim((string) $this->request->post('banner_btn_text', 'Request A Private Briefing')),
            'banner_btn_url' => trim((string) $this->request->post('banner_btn_url', '#confidential-desk')),
            'banner_image' => $bannerImagePath,
            'why_eyebrow' => trim((string) $this->request->post('why_eyebrow', 'Fiduciary Excellence')),
            'why_title' => trim((string) $this->request->post('why_title', 'Why Elite Homez')),
            'why_subtitle' => trim((string) $this->request->post('why_subtitle', 'Institutional experience, total discretion, and granular mastery of premier South Delhi real estate.')),
            'why_pillars' => $whyPillarsJson,
            'showcase_image' => $showcaseImagePath,
            'showcase_caption' => trim((string) $this->request->post('showcase_caption', 'Private Residence · Vasant Vihar')),
            'showcase_tag' => trim((string) $this->request->post('showcase_tag', 'Curated Acquisition')),
            'value_prop_eyebrow' => trim((string) $this->request->post('value_prop_eyebrow', 'Beyond Brokering')),
            'value_prop_title' => trim((string) $this->request->post('value_prop_title', 'More than a property transaction. An enduring generational asset.')),
            'value_prop_body' => trim((string) $this->request->post('value_prop_body', '')),
            'value_prop_checkmarks' => $valuePropCheckmarksJson,
            'audience_eyebrow' => trim((string) $this->request->post('audience_eyebrow', 'Tailored Client Desks')),
            'audience_title' => trim((string) $this->request->post('audience_title', 'Who We Help')),
            'audience_subtitle' => trim((string) $this->request->post('audience_subtitle', 'Our advisory practice is crafted specifically for discerning purchasers with distinct governance criteria.')),
            'audience_profiles' => $audienceProfilesJson,
            'faqs_eyebrow' => trim((string) $this->request->post('faqs_eyebrow', 'Bespoke Guidance & Clarity')),
            'faqs_title' => trim((string) $this->request->post('faqs_title', 'Frequently Asked Questions')),
            'faqs_subtitle' => trim((string) $this->request->post('faqs_subtitle', 'Clear answers to the most common questions regarding our private advisory services.')),
            'faqs_items' => $faqsItemsJson,
            'enquiry_eyebrow' => trim((string) $this->request->post('enquiry_eyebrow', 'Confidential Dialogue')),
            'enquiry_title' => trim((string) $this->request->post('enquiry_title', 'Initiate a Private Advisory Briefing')),
            'enquiry_description' => trim((string) $this->request->post('enquiry_description', '')),
            'enquiry_features' => $enquiryFeaturesJson,
            'enquiry_btn_text' => trim((string) $this->request->post('enquiry_btn_text', 'Submit Confidential Mandate')),
            'cta_eyebrow' => trim((string) $this->request->post('cta_eyebrow', 'Elite Homez Advisory')),
            'cta_title' => trim((string) $this->request->post('cta_title', 'The right property starts with the right advice.')),
            'cta_subtitle' => trim((string) $this->request->post('cta_subtitle', 'Discover a more considered, confidential way to navigate premier Delhi NCR real estate.')),
            'cta_image' => $ctaImagePath,
            'cta_btn1_text' => trim((string) $this->request->post('cta_btn1_text', 'Explore Properties Catalogue')),
            'cta_btn1_url' => trim((string) $this->request->post('cta_btn1_url', '/properties')),
            'cta_btn2_text' => trim((string) $this->request->post('cta_btn2_text', 'Contact Advisory Desk')),
            'cta_btn2_url' => trim((string) $this->request->post('cta_btn2_url', '/contact-us')),
            'is_published' => $isPublished,
            'show_on_home' => $showOnHome,
            'sort_order' => $sortOrder,
            'seo_title' => $seoTitle ?: "{$name} | Elite Homez Advisory",
            'meta_description' => $metaDesc ?: substr(strip_tags($shortDesc), 0, 160)
        ]);

        Session::setFlash('success', "Service '{$name}' updated successfully.");
        $this->redirect("/admin/services/edit/{$id}");
    }

    public function toggleShowOnHome(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/services');
            return;
        }

        $serviceModel = new Service();
        $service = $serviceModel->find((int) $id);
        if ($service) {
            $newVal = !empty($service['show_on_home']) ? 0 : 1;
            $serviceModel->update((int) $id, ['show_on_home' => $newVal]);
            $label = $newVal ? 'Tagged to show on Home Page' : 'Removed from Home Page';
            Session::setFlash('success', "Service '{$service['name']}': {$label}.");
        }
        $this->redirect('/admin/services');
    }

    public function toggleStatus(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/services');
            return;
        }

        $serviceModel = new Service();
        $service = $serviceModel->find((int) $id);
        if ($service) {
            $newPublished = !empty($service['is_published']) ? 0 : 1;
            $serviceModel->update((int) $id, ['is_published' => $newPublished]);
            $statusLabel = $newPublished ? 'Active (Published)' : 'Inactive (Draft)';
            Session::setFlash('success', "Service '{$service['name']}' status changed to {$statusLabel}.");
        }
        $this->redirect('/admin/services');
    }

    public function delete(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/services');
            return;
        }

        $serviceModel = new Service();
        $service = $serviceModel->find((int) $id);
        if ($service) {
            $serviceModel->delete((int) $id);
            Session::setFlash('success', "Service '{$service['name']}' deleted successfully.");
        }
        $this->redirect('/admin/services');
    }

    /**
     * Encode an associative repeater array into JSON, skipping empty rows.
     */
    private function encodeRepeater(mixed $raw): string {
        if (!is_array($raw)) {
            return json_encode([], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $cleaned = [];
        foreach ($raw as $item) {
            if (is_array($item)) {
                $hasContent = false;
                $cleanedRow = [];
                foreach ($item as $k => $v) {
                    $val = is_string($v) ? trim($v) : $v;
                    $cleanedRow[$k] = $val;
                    if (!empty($val)) {
                        $hasContent = true;
                    }
                }
                if ($hasContent) {
                    $cleaned[] = $cleanedRow;
                }
            }
        }
        return json_encode(array_values($cleaned), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Encode a simple string array into JSON, skipping empty lines.
     */
    private function encodeStringRepeater(mixed $raw): string {
        if (!is_array($raw)) {
            return json_encode([], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $cleaned = [];
        foreach ($raw as $val) {
            if (is_string($val) && trim($val) !== '') {
                $cleaned[] = trim($val);
            }
        }
        return json_encode(array_values($cleaned), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
