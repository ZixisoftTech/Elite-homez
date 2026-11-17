<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Models\Admin;

class ProfileAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $adminModel = new Admin();
        $admin = $adminModel->find(Auth::id());

        if (!$admin) {
            Session::setFlash('error', 'Administrator account not found.');
            $this->redirect('/admin/dashboard');
            return;
        }

        $this->renderAdmin('admin/profile/index', [
            'admin' => $admin,
            'pageHeading' => 'Administrator Profile & Security',
            'seo' => ['title' => 'Admin Profile & Security | Elite Homez']
        ]);
    }

    public function updateProfile(): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'Security token invalid or expired. Please try again.');
            $this->redirect('/admin/profile');
            return;
        }

        $name = trim((string) $this->request->post('name', ''));
        $email = strtolower(trim((string) $this->request->post('email', '')));
        $adminId = Auth::id();

        if (empty($name)) {
            Session::setFlash('error', 'Administrator name cannot be empty.');
            $this->redirect('/admin/profile');
            return;
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::setFlash('error', 'Please provide a valid email address.');
            $this->redirect('/admin/profile');
            return;
        }

        $adminModel = new Admin();
        // Check if email already used by another admin
        $existing = $adminModel->findBy('email', $email);
        if ($existing && (int)$existing['id'] !== $adminId) {
            Session::setFlash('error', 'That email address is already in use by another account.');
            $this->redirect('/admin/profile');
            return;
        }

        $adminModel->update($adminId, [
            'name' => $name,
            'email' => $email,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Update active session data
        Session::set('admin_name', $name);
        Session::set('admin_email', $email);

        Session::setFlash('success', 'Profile information updated successfully.');
        $this->redirect('/admin/profile');
    }

    public function updatePassword(): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'Security token invalid or expired. Please try again.');
            $this->redirect('/admin/profile');
            return;
        }

        $currentPassword = (string) $this->request->post('current_password', '');
        $newPassword = (string) $this->request->post('new_password', '');
        $confirmPassword = (string) $this->request->post('confirm_password', '');
        $adminId = Auth::id();

        $adminModel = new Admin();
        $admin = $adminModel->find($adminId);

        if (!$admin) {
            Session::setFlash('error', 'Administrator record not found.');
            $this->redirect('/admin/profile');
            return;
        }

        // Verify current password
        if (!password_verify($currentPassword, $admin['password_hash'])) {
            Session::setFlash('error', 'Current password is incorrect. Please verify and try again.');
            $this->redirect('/admin/profile');
            return;
        }

        // Validate new password length
        if (strlen($newPassword) < 8) {
            Session::setFlash('error', 'New password must be at least 8 characters long.');
            $this->redirect('/admin/profile');
            return;
        }

        // Validate password confirmation
        if ($newPassword !== $confirmPassword) {
            Session::setFlash('error', 'New password and confirmation password do not match.');
            $this->redirect('/admin/profile');
            return;
        }

        // Prevent reusing the exact same password
        if (password_verify($newPassword, $admin['password_hash'])) {
            Session::setFlash('error', 'The new password cannot be the same as your current password.');
            $this->redirect('/admin/profile');
            return;
        }

        // Hash and store
        $newHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
        $adminModel->update($adminId, [
            'password_hash' => $newHash,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        Session::setFlash('success', 'Your password has been changed successfully.');
        $this->redirect('/admin/profile');
    }
}
