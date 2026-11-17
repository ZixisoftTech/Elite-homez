<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Helpers\Uploader;
use App\Models\Testimonial;

class TestimonialAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $testimonialModel = new Testimonial();
        $testimonials = $testimonialModel->all('sort_order ASC, id DESC');

        $this->renderAdmin('admin/testimonials/index', [
            'testimonials' => $testimonials,
            'seo' => ['title' => 'Client Testimonials Management | Elite Homez']
        ]);
    }

    public function create(): void {
        $this->requireAuth();
        $this->renderAdmin('admin/testimonials/create', [
            'seo' => ['title' => 'Add Client Testimonial | Elite Homez']
        ]);
    }

    public function store(): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/testimonials/create');
            return;
        }

        $name = trim((string) $this->request->post('client_name', ''));
        $designation = trim((string) $this->request->post('designation', ''));
        $text = trim((string) $this->request->post('testimonial', ''));
        $rating = max(1, min(5, (int) $this->request->post('rating', 5)));
        $status = $this->request->post('status') ? 1 : 0;
        $sortOrder = (int) $this->request->post('sort_order', 0);

        if (empty($name) || empty($text)) {
            Session::setFlash('error', 'Client name and testimonial feedback are required.');
            $this->redirect('/admin/testimonials/create');
            return;
        }

        $directImage = trim((string) ($this->request->post('image_url') ?: $this->request->post('image_path') ?: ''));
        $imagePath = !empty($directImage) ? $directImage : null;
        $file = $this->request->file('image');
        if ($file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($file, 'testimonials');
            if ($upload['success']) {
                $imagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Testimonial photo upload failed: ' . $upload['message']);
                $this->redirect('/admin/testimonials/create');
                return;
            }
        }

        $testimonialModel = new Testimonial();
        $testimonialModel->create([
            'client_name' => $name,
            'designation' => $designation,
            'testimonial' => $text,
            'rating' => $rating,
            'image_path' => $imagePath,
            'status' => $status,
            'sort_order' => $sortOrder
        ]);

        Session::setFlash('success', 'Testimonial added successfully.');
        $this->redirect('/admin/testimonials');
    }

    public function edit(string $id): void {
        $this->requireAuth();
        $testimonialModel = new Testimonial();
        $testimonial = $testimonialModel->find((int) $id);
        if (!$testimonial) {
            Session::setFlash('error', 'Testimonial not found.');
            $this->redirect('/admin/testimonials');
            return;
        }

        $this->renderAdmin('admin/testimonials/edit', [
            'testimonial' => $testimonial,
            'seo' => ['title' => "Edit Testimonial | Elite Homez"]
        ]);
    }

    public function update(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect("/admin/testimonials/edit/{$id}");
            return;
        }

        $name = trim((string) $this->request->post('client_name', ''));
        $designation = trim((string) $this->request->post('designation', ''));
        $text = trim((string) $this->request->post('testimonial', ''));
        $rating = max(1, min(5, (int) $this->request->post('rating', 5)));
        $status = $this->request->post('status') ? 1 : 0;
        $sortOrder = (int) $this->request->post('sort_order', 0);

        $testimonialModel = new Testimonial();
        $testimonial = $testimonialModel->find((int) $id);
        if (!$testimonial) {
            Session::setFlash('error', 'Testimonial not found.');
            $this->redirect('/admin/testimonials');
            return;
        }

        $directImage = trim((string) ($this->request->post('image_url') ?: $this->request->post('image_path') ?: ''));
        $imagePath = !empty($directImage) ? $directImage : $testimonial['image_path'];
        $file = $this->request->file('image');
        if ($file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($file, 'testimonials');
            if ($upload['success']) {
                $imagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Testimonial photo upload failed: ' . $upload['message']);
                $this->redirect("/admin/testimonials/edit/{$id}");
                return;
            }
        }

        $testimonialModel->update((int) $id, [
            'client_name' => $name,
            'designation' => $designation,
            'testimonial' => $text,
            'rating' => $rating,
            'image_path' => $imagePath,
            'status' => $status,
            'sort_order' => $sortOrder
        ]);

        Session::setFlash('success', 'Testimonial updated.');
        $this->redirect('/admin/testimonials');
    }

    public function delete(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/testimonials');
            return;
        }

        $testimonialModel = new Testimonial();
        $testimonialModel->delete((int) $id);
        Session::setFlash('success', 'Testimonial deleted.');
        $this->redirect('/admin/testimonials');
    }
}
