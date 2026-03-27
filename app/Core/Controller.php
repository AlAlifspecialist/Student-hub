<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'layouts/main'): void
    {
        extract($data, EXTR_SKIP);

        $viewFile = BASE_PATH . '/app/Views/' . $view . '.php';
        $layoutFile = BASE_PATH . '/app/Views/' . $layout . '.php';

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require $layoutFile;
    }
}
