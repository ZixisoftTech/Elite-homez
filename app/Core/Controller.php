<?php
declare(strict_types=1);

namespace App\Core;

use App\Helpers\Session;

abstract class Controller {
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    protected function render(string $view, array $data = [], string $layout = 'main'): void {
        View::render($view, $data, $layout);
    }

    protected function renderAdmin(string $view, array $data = []): void {
        $this->requireAuth();
        View::render($view, $data, 'admin');
    }

    protected function json(array $data, int $statusCode = 200): void {
        $this->response->json($data, $statusCode);
    }

    protected function redirect(string $path): void {
        $config = require dirname(__DIR__) . '/Config/config.php';
        $baseUrl = $config['base_url'];
        $url = str_starts_with($path, 'http') ? $path : $baseUrl . '/' . ltrim($path, '/');
        $this->response->redirect($url);
    }

    protected function requireAuth(): void {
        if (!\App\Helpers\Auth::check()) {
            Session::setFlash('error', 'Please log in to access the administration panel.');
            $this->redirect('/admin/login');
        }
    }
}
