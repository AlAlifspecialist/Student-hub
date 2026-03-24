<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

const BASE_PATH = __DIR__;

$config = require BASE_PATH . '/config/config.php';
$config['app']['base_path'] = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($config['app']['base_path'] === '/') {
    $config['app']['base_path'] = '';
}

$GLOBALS['app_config'] = $config;

require BASE_PATH . '/app/Core/helpers.php';

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $file = BASE_PATH . '/app/' . str_replace('\\', '/', $relative) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

$app = new App\Core\Application($config);
$app->run();
