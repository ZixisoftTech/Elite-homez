<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Helpers\Uploader;
use App\Models\CarouselSlide;

class CarouselAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $carouselModel = new CarouselSlide();
        $slides = $carouselModel->allOrdered();

        $this->renderAdmin('admin/carousel/index', [
            'slides' => $slides,
            'seo' => ['title' => 'Hero Carousel Slider | Elite Homez Admin']
        ]);
    }

    public function create(): void {
        $this->requireAuth();
        $this->renderAdmin('admin/carousel/create', [
            'seo' => ['title' => 'Add Carousel Slide | Elite Homez']
        ]);
    }

    public function store(): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token validation failed.');
            $this->redirect('/admin/carousel/create');
            return;
        }

        $title = trim((string) $this->request->post('title', ''));
        $subtitle = trim((string) $this->request->post('subtitle', ''));
        $eyebrow = trim((string) ($this->request->post('eyebrow') ?: $this->request->post('badge') ?: 'CONFIDENTIAL ADVISORY · PRIVATE MANDATES'));
        $dossierEyebrow = trim((string) $this->request->post('dossier_eyebrow', 'Trophy Estate Dossier'));
        $dossierTitle = trim((string) $this->request->post('dossier_title', 'South Delhi Prime Enclaves'));
        $badgeText = trim((string) $this->request->post('badge_text', 'Off-Market Mandate'));
        $trustBadge1 = trim((string) $this->request->post('trust_badge_1', 'RERA Certified Advisory'));
        $trustBadge2 = trim((string) $this->request->post('trust_badge_2', '100% Non-Disclosure Mandates'));

        $primaryBtnText = trim((string) ($this->request->post('primary_btn_text') ?: $this->request->post('btn_primary_text') ?: 'Explore Properties'));
        $primaryBtnUrl = trim((string) ($this->request->post('primary_btn_url') ?: $this->request->post('btn_primary_link') ?: '/properties'));
        $secondaryBtnText = trim((string) ($this->request->post('secondary_btn_text') ?: $this->request->post('btn_secondary_text') ?: 'Speak With an Advisor'));
        $secondaryBtnUrl = trim((string) ($this->request->post('secondary_btn_url') ?: $this->request->post('btn_secondary_link') ?: '/contact-us'));
        $isActive = $this->request->post('is_active') ? 1 : 0;
        $sortOrder = (int) $this->request->post('sort_order', 0);

        if (empty($title)) {
            Session::setFlash('error', 'Slide title/headline is required.');
            $this->redirect('/admin/carousel/create');
            return;
        }

        $directImage = trim((string) ($this->request->post('image_url') ?: $this->request->post('image_path') ?: ''));
        $imagePath = !empty($directImage) ? $directImage : '/assets/images/stitch/hero-residence.jpg';
        $file = $this->request->file('image');
        if ($file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($file, 'carousel');
            if ($upload['success']) {
                $imagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Hero image upload failed: ' . $upload['message']);
                $this->redirect('/admin/carousel/create');
                return;
            }
        }

        $carouselModel = new CarouselSlide();
        $carouselModel->create([
            'title' => $title,
            'subtitle' => $subtitle,
            'eyebrow' => $eyebrow,
            'image' => $imagePath,
            'dossier_eyebrow' => $dossierEyebrow,
            'dossier_title' => $dossierTitle,
            'badge_text' => $badgeText,
            'trust_badge_1' => $trustBadge1,
            'trust_badge_2' => $trustBadge2,
            'primary_btn_text' => $primaryBtnText,
            'primary_btn_url' => $primaryBtnUrl,
            'secondary_btn_text' => $secondaryBtnText,
            'secondary_btn_url' => $secondaryBtnUrl,
            'is_active' => $isActive,
            'sort_order' => $sortOrder
        ]);

        Session::setFlash('success', "Carousel slide created successfully.");
        $this->redirect('/admin/carousel');
    }

    public function edit(string $id): void {
        $this->requireAuth();
        $carouselModel = new CarouselSlide();
        $slide = $carouselModel->find((int) $id);
        if (!$slide) {
            Session::setFlash('error', 'Carousel slide not found.');
            $this->redirect('/admin/carousel');
            return;
        }

        // Ensure backward-compatible aliases for views
        $slide['badge'] = $slide['badge'] ?? $slide['eyebrow'] ?? '';
        $slide['image_url'] = $slide['image_url'] ?? $slide['image'] ?? '';
        $slide['btn_primary_text'] = $slide['btn_primary_text'] ?? $slide['primary_btn_text'] ?? '';
        $slide['btn_primary_link'] = $slide['btn_primary_link'] ?? $slide['primary_btn_url'] ?? '';
        $slide['btn_secondary_text'] = $slide['btn_secondary_text'] ?? $slide['secondary_btn_text'] ?? '';
        $slide['btn_secondary_link'] = $slide['btn_secondary_link'] ?? $slide['secondary_btn_url'] ?? '';

        $this->renderAdmin('admin/carousel/edit', [
            'slide' => $slide,
            'seo' => ['title' => 'Edit Carousel Slide | Elite Homez Admin']
        ]);
    }

    public function update(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token validation failed.');
            $this->redirect("/admin/carousel/edit/{$id}");
            return;
        }

        $carouselModel = new CarouselSlide();
        $slide = $carouselModel->find((int) $id);
        if (!$slide) {
            Session::setFlash('error', 'Carousel slide not found.');
            $this->redirect('/admin/carousel');
            return;
        }

        $title = trim((string) $this->request->post('title', ''));
        $subtitle = trim((string) $this->request->post('subtitle', ''));
        $eyebrow = trim((string) ($this->request->post('eyebrow') ?: $this->request->post('badge') ?: 'CONFIDENTIAL ADVISORY · PRIVATE MANDATES'));
        $dossierEyebrow = trim((string) $this->request->post('dossier_eyebrow', 'Trophy Estate Dossier'));
        $dossierTitle = trim((string) $this->request->post('dossier_title', 'South Delhi Prime Enclaves'));
        $badgeText = trim((string) $this->request->post('badge_text', 'Off-Market Mandate'));
        $trustBadge1 = trim((string) $this->request->post('trust_badge_1', 'RERA Certified Advisory'));
        $trustBadge2 = trim((string) $this->request->post('trust_badge_2', '100% Non-Disclosure Mandates'));

        $primaryBtnText = trim((string) ($this->request->post('primary_btn_text') ?: $this->request->post('btn_primary_text') ?: 'Explore Properties'));
        $primaryBtnUrl = trim((string) ($this->request->post('primary_btn_url') ?: $this->request->post('btn_primary_link') ?: '/properties'));
        $secondaryBtnText = trim((string) ($this->request->post('secondary_btn_text') ?: $this->request->post('btn_secondary_text') ?: 'Speak With an Advisor'));
        $secondaryBtnUrl = trim((string) ($this->request->post('secondary_btn_url') ?: $this->request->post('btn_secondary_link') ?: '/contact-us'));
        $isActive = $this->request->post('is_active') ? 1 : 0;
        $sortOrder = (int) $this->request->post('sort_order', 0);

        if (empty($title)) {
            Session::setFlash('error', 'Slide title is required.');
            $this->redirect("/admin/carousel/edit/{$id}");
            return;
        }

        $directImage = trim((string) ($this->request->post('image_url') ?: $this->request->post('image_path') ?: ''));
        $imagePath = !empty($directImage) ? $directImage : (!empty($slide['image']) ? $slide['image'] : '/assets/images/stitch/hero-residence.jpg');
        $file = $this->request->file('image');
        if ($file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($file, 'carousel');
            if ($upload['success']) {
                $imagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Hero image upload failed: ' . $upload['message']);
                $this->redirect("/admin/carousel/edit/{$id}");
                return;
            }
        }

        $carouselModel->update((int) $id, [
            'title' => $title,
            'subtitle' => $subtitle,
            'eyebrow' => $eyebrow,
            'image' => $imagePath,
            'dossier_eyebrow' => $dossierEyebrow,
            'dossier_title' => $dossierTitle,
            'badge_text' => $badgeText,
            'trust_badge_1' => $trustBadge1,
            'trust_badge_2' => $trustBadge2,
            'primary_btn_text' => $primaryBtnText,
            'primary_btn_url' => $primaryBtnUrl,
            'secondary_btn_text' => $secondaryBtnText,
            'secondary_btn_url' => $secondaryBtnUrl,
            'is_active' => $isActive,
            'sort_order' => $sortOrder
        ]);

        Session::setFlash('success', "Carousel slide updated successfully.");
        $this->redirect("/admin/carousel/edit/{$id}");
    }

    public function toggleStatus(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/carousel');
            return;
        }

        $carouselModel = new CarouselSlide();
        $slide = $carouselModel->find((int) $id);
        if ($slide) {
            $newStatus = !empty($slide['is_active']) ? 0 : 1;
            $carouselModel->update((int) $id, ['is_active' => $newStatus]);
            $statusLabel = $newStatus ? 'Active (Live on Hero)' : 'Inactive (Hidden)';
            Session::setFlash('success', "Slide status changed to {$statusLabel}.");
        }
        $this->redirect('/admin/carousel');
    }

    public function delete(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/carousel');
            return;
        }

        $carouselModel = new CarouselSlide();
        $carouselModel->delete((int) $id);
        Session::setFlash('success', 'Carousel slide deleted successfully.');
        $this->redirect('/admin/carousel');
    }
}
