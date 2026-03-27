<?php
declare(strict_types=1);

function config(?string $key = null, mixed $default = null): mixed
{
    $config = $GLOBALS['app_config'] ?? [];

    if ($key === null) {
        return $config;
    }

    $value = $config;
    foreach (explode('.', $key) as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function base_url(): string
{
    return config('app.base_path', '');
}

function url(string $path = ''): string
{
    $base = rtrim((string) base_url(), '/');
    $path = trim($path, '/');

    if ($path === '') {
        return $base !== '' ? $base . '/' : '/';
    }

    return ($base !== '' ? $base : '') . '/' . $path;
}

function asset(string $path): string
{
    return url($path);
}

function redirect(string $path): never
{
    header('Location: ' . (str_starts_with($path, 'http') ? $path : url($path)));
    exit;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    if (!$token || !$sessionToken || !hash_equals($sessionToken, $token)) {
        http_response_code(419);
        exit('Invalid CSRF token.');
    }
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function old(string $key, string $default = ''): string
{
    return e($_POST[$key] ?? $default);
}

function current_admin(): ?array
{
    return $_SESSION['admin'] ?? null;
}

function admin_logged_in(): bool
{
    return current_admin() !== null;
}

function admin_has_role(array $roles): bool
{
    $admin = current_admin();
    if (!$admin) {
        return false;
    }

    return in_array($admin['role'], $roles, true);
}

function current_lang(): string
{
    return $_SESSION['lang'] ?? 'en';
}

function t(string $key): string
{
    static $translations = null;
    static $loadedLang = null;

    $lang = current_lang();

    if ($translations === null || $loadedLang !== $lang) {
        $file = BASE_PATH . '/config/lang/' . $lang . '.php';

        if (file_exists($file)) {
            $translations = require $file;
        } else {
            $translations = require BASE_PATH . '/config/lang/en.php';
        }

        $loadedLang = $lang;
    }

    return $translations[$key] ?? $key;
}

function translated_content(): array
{
    static $content = null;

    if ($content === null) {
        $file = BASE_PATH . '/config/lang/content.php';
        $content = file_exists($file) ? require $file : [];
    }

    return $content[current_lang()] ?? [];
}

function translate_level(string $value): string
{
    $content = translated_content();
    return $content['levels'][$value] ?? $value;
}

function translate_leader_title(?string $value): string
{
    if (!$value) {
        return '';
    }

    $content = translated_content();
    return $content['leader_titles'][$value] ?? $value;
}

function translate_programme_name(string $value): string
{
    $content = translated_content();
    return $content['programmes'][$value]['name'] ?? $value;
}

function translate_programme_description(?string $name, ?string $description): string
{
    if (!$name || !$description) {
        return (string) $description;
    }

    $content = translated_content();
    return $content['programmes'][$name]['description'] ?? $description;
}

function translate_module_name(string $value): string
{
    $content = translated_content();
    return $content['modules'][$value] ?? $value;
}