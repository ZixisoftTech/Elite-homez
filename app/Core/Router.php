<?php
declare(strict_types=1);

namespace App\Core;

class Router {
    private array $routes = [];
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, array|callable $handler): void {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array|callable $handler): void {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array|callable $handler): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path === '' ? '/' : $path,
            'handler' => $handler
        ];
    }

    public function resolve(): void {
        $method = $this->request->getMethod();
        if ($method === 'HEAD') {
            $method = 'GET';
        }
        $uri = $this->request->getUri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $paramNames = [];
            $pattern = $this->convertRouteToRegex($route['path'], $paramNames);
            if (preg_match($pattern, $uri, $matches)) {
                $params = [];
                foreach ($paramNames as $name) {
                    if (isset($matches[$name])) {
                        $params[$name] = $matches[$name];
                    }
                }

                $this->executeHandler($route['handler'], $params);
                return;
            }
        }

        // No route matched — Render 404
        $this->renderNotFound();
    }

    private function convertRouteToRegex(string $path, array &$paramNames = []): string {
        $paramNames = [];
        $pattern = preg_replace_callback('/\{([a-zA-Z0-9_]+)(\:[^\}]+)?\}/', function ($matches) use (&$paramNames) {
            $paramNames[] = $matches[1];
            if (isset($matches[2])) {
                $regex = substr($matches[2], 1);
                return '(?P<' . $matches[1] . '>' . $regex . ')';
            }
            return '(?P<' . $matches[1] . '>[^/]+)';
        }, $path);

        return '#^' . $pattern . '$#u';
    }

    private function executeHandler(array|callable $handler, array $params): void {
        if (is_callable($handler)) {
            call_user_func_array($handler, array_values($params));
            return;
        }

        if (is_array($handler) && count($handler) === 2) {
            [$class, $method] = $handler;
            if (class_exists($class)) {
                $controller = new $class($this->request, $this->response);
                if (method_exists($controller, $method)) {
                    call_user_func_array([$controller, $method], array_values($params));
                    return;
                }
            }
        }

        throw new \RuntimeException("Handler execution failed for given route.");
    }

    private function renderNotFound(): void {
        $this->response->setStatusCode(404);
        $controller = new \App\Controllers\HomeController($this->request, $this->response);
        $controller->notFound();
    }
}
