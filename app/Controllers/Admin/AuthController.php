<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Helpers\Session;

class AuthController extends Controller {
    public function showLogin(): void {
        if (Auth::check()) {
            $this->redirect('/admin/dashboard');
            return;
        }

        $this->render('admin/auth/login', [
            'seo' => ['title' => 'Admin Authentication | Elite Homez']
        ], ''); // no wrapper layout
    }

    public function login(): void {
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'Security token expired. Please try again.');
            $this->redirect('/admin/login');
            return;
        }

        $email = (string) $this->request->post('email', '');
        $password = (string) $this->request->post('password', '');
        $ip = $this->request->ip();

        $result = Auth::attempt($email, $password, $ip);

        if ($result['success']) {
            Session::setFlash('success', 'Welcome back, ' . htmlspecialchars($result['admin']['name'], ENT_QUOTES));
            $this->redirect('/admin/dashboard');
            return;
        }

        Session::setFlash('error', $result['message']);
        $this->redirect('/admin/login');
    }

    public function logout(): void {
        $token = (string) $this->request->post('csrf_token', '');
        if (Csrf::validate($token)) {
            Auth::logout();
            Session::setFlash('success', 'You have been securely signed out.');
        }
        $this->redirect('/admin/login');
    }
}
