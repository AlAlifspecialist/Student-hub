<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $pattern, array $handler): void
    {
        $pattern = trim($pattern, '/');
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';

        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'regex' => $regex,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = $this->normalize($uri);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (!preg_match($route['regex'], $path, $matches)) {
                continue;
            }

            [$controllerClass, $action] = $route['handler'];
            $controller = new $controllerClass();
            $params = [];
            foreach ($matches as $key => $value) {
                if (!is_int($key)) {
                    $params[] = $value;
                }
            }

            call_user_func_array([$controller, $action], $params);
            return;
        }

        http_response_code(404);
        $controller = new \App\Controllers\ErrorController();
        $controller->notFound();
    }

    private function normalize(string $uri): string
    {
        $path = trim((string) parse_url($uri, PHP_URL_PATH), '/');
        $base = trim((string) config('app.base_path', ''), '/');

        if ($base !== '') {
            if ($path === $base) {
                return '';
            }
            if (str_starts_with($path, $base . '/')) {
                $path = substr($path, strlen($base) + 1);
            }
        }

        return trim($path, '/');
    }
}
