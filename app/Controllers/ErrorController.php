<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    public function notFound(): void
    {
        $this->render('errors/404', ['pageTitle' => '404 Not Found']);
    }

    public function forbidden(): void
    {
        http_response_code(403);
        $this->render('errors/403', ['pageTitle' => '403 Forbidden']);
    }
}
