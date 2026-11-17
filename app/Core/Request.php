<?php
declare(strict_types=1);

namespace App\Core;

class Request {
    private string $method;
    private string $uri;
    private array $getParams;
    private array $postParams;
    private array $files;
    private array $server;

    public function __construct() {
        $this->server = $_SERVER;
        $this->method = strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
        $this->getParams = $this->sanitize($_GET);
        $this->postParams = $this->sanitize($_POST);
        $this->files = $_FILES;
        $this->uri = $this->parseUri();
    }

    private function parseUri(): string {
        $requestUri = $this->server['REQUEST_URI'] ?? '/';
        $path = parse_url($requestUri, PHP_URL_PATH) ?? '/';

        // Strip subfolder if running in subdirectory
        $scriptName = $this->server['SCRIPT_NAME'] ?? '';
        $baseDir = str_replace('\\', '/', dirname($scriptName));
        
        if ($baseDir !== '/' && $baseDir !== '.' && str_starts_with($path, $baseDir)) {
            $path = substr($path, strlen($baseDir));
        } elseif (str_ends_with($baseDir, '/public')) {
            $parentDir = dirname($baseDir);
            if ($parentDir !== '/' && $parentDir !== '.' && str_starts_with($path, $parentDir)) {
                $path = substr($path, strlen($parentDir));
            }
        }

        // Clean trailing slashes except for root
        $path = rtrim($path, '/');
        return $path === '' ? '/' : $path;
    }

    private function sanitize(mixed $data): mixed {
        if (is_array($data)) {
            $cleaned = [];
            foreach ($data as $key => $value) {
                $cleaned[$key] = $this->sanitize($value);
            }
            return $cleaned;
        }
        if (is_string($data)) {
            return trim($data);
        }
        return $data;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function isPost(): bool {
        return $this->method === 'POST';
    }

    public function isGet(): bool {
        return $this->method === 'GET';
    }

    public function getUri(): string {
        return $this->uri;
    }

    public function get(string $key, mixed $default = null): mixed {
        return $this->getParams[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed {
        return $this->postParams[$key] ?? $default;
    }

    public function all(): array {
        return array_merge($this->getParams, $this->postParams);
    }

    public function file(string $key): ?array {
        return $this->files[$key] ?? null;
    }

    public function isAjax(): bool {
        if (!empty($this->server['HTTP_X_REQUESTED_WITH']) && 
            strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return true;
        }
        if (!empty($this->server['HTTP_ACCEPT']) && 
            str_contains(strtolower($this->server['HTTP_ACCEPT']), 'application/json')) {
            return true;
        }
        if (!empty($this->server['CONTENT_TYPE']) && 
            str_contains(strtolower($this->server['CONTENT_TYPE']), 'application/json')) {
            return true;
        }
        return false;
    }

    public function ip(): string {
        if (!empty($this->server['HTTP_CLIENT_IP'])) {
            return $this->server['HTTP_CLIENT_IP'];
        }
        if (!empty($this->server['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $this->server['HTTP_X_FORWARDED_FOR']);
            return trim($ips[0]);
        }
        return $this->server['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    public function userAgent(): string {
        return substr($this->server['HTTP_USER_AGENT'] ?? 'Unknown', 0, 255);
    }
}
