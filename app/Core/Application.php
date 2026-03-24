<?php
declare(strict_types=1);

namespace App\Core;

class Application
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function run(): void
    {
        $router = new Router();
        $routes = require BASE_PATH . '/config/routes.php';

        foreach ($routes as [$method, $pattern, $handler]) {
            $router->add($method, $pattern, $handler);
        }

        $router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
    }
}