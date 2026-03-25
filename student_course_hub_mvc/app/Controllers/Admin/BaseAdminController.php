<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;

abstract class BaseAdminController extends Controller
{
    protected function requireLogin(): void
    {
        if (!admin_logged_in()) {
            flash('danger', 'Please log in first.');
            redirect('admin/login');
        }
    }

    protected function requireRole(array $roles): void
    {
        $this->requireLogin();

        if (!admin_has_role($roles)) {
            http_response_code(403);
            $this->render('errors/403', ['pageTitle' => 'Access Denied']);
            exit;
        }
    }
}
