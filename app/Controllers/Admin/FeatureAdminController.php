<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\Session;
use App\Models\Feature;

class FeatureAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $featureModel = new Feature();
        $features = $featureModel->allOrdered();

        $this->renderAdmin('admin/features/index', [
            'features' => $features,
            'seo' => ['title' => 'Master Features & Amenities Library | Elite Homez']
        ]);
    }

    public function store(): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/features');
            return;
        }

        $name = trim((string) $this->request->post('name', ''));
        $icon = trim((string) $this->request->post('icon', 'check-circle'));
        $sortOrder = (int) $this->request->post('sort_order', 0);
        $status = $this->request->post('status') === 'inactive' ? 'inactive' : 'active';

        if (empty($name)) {
            Session::setFlash('error', 'Feature name is required.');
            $this->redirect('/admin/features');
            return;
        }

        $slug = Format::slug($name);
        $featureModel = new Feature();

        // Check duplicate slug
        if ($featureModel->findBySlug($slug)) {
            $slug .= '-' . rand(10, 99);
        }

        $featureModel->create([
            'name' => $name,
            'slug' => $slug,
            'icon' => $icon ?: 'check-circle',
            'status' => $status,
            'sort_order' => $sortOrder
        ]);

        Session::setFlash('success', "Feature '{$name}' added to Master Library.");
        $this->redirect('/admin/features');
    }

    public function update(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF token invalid.');
            $this->redirect('/admin/features');
            return;
        }

        $featureModel = new Feature();
        $feature = $featureModel->find((int) $id);
        if (!$feature) {
            Session::setFlash('error', 'Feature not found.');
            $this->redirect('/admin/features');
            return;
        }

        $name = trim((string) $this->request->post('name', ''));
        $icon = trim((string) $this->request->post('icon', $feature['icon']));
        $sortOrder = (int) $this->request->post('sort_order', $feature['sort_order']);
        $status = $this->request->post('status') === 'inactive' ? 'inactive' : 'active';

        if (empty($name)) {
            Session::setFlash('error', 'Feature name cannot be empty.');
            $this->redirect('/admin/features');
            return;
        }

        $featureModel->update((int) $id, [
            'name' => $name,
            'icon' => $icon,
            'status' => $status,
            'sort_order' => $sortOrder
        ]);

        Session::setFlash('success', "Feature '{$name}' updated.");
        $this->redirect('/admin/features');
    }

    public function toggleStatus(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/features');
            return;
        }

        $featureModel = new Feature();
        $feature = $featureModel->find((int) $id);
        if ($feature) {
            $newStatus = $feature['status'] === 'active' ? 'inactive' : 'active';
            $featureModel->update((int) $id, ['status' => $newStatus]);
            Session::setFlash('success', "Status toggled to {$newStatus}.");
        }
        $this->redirect('/admin/features');
    }

    public function delete(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/features');
            return;
        }

        $featureModel = new Feature();
        $feature = $featureModel->find((int) $id);
        if (!$feature) {
            Session::setFlash('error', 'Feature not found.');
            $this->redirect('/admin/features');
            return;
        }

        if ($featureModel->isFeatureInUse((int) $id)) {
            Session::setFlash('error', "Cannot delete '{$feature['name']}': it is currently associated with active properties. Please deactivate it instead.");
            $this->redirect('/admin/features');
            return;
        }

        $featureModel->delete((int) $id);
        Session::setFlash('success', "Feature deleted successfully.");
        $this->redirect('/admin/features');
    }
}
