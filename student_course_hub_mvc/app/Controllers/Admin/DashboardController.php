<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Dashboard;

class DashboardController extends BaseAdminController
{
    public function index(): void
    {
        $this->requireLogin();
        $stats = (new Dashboard())->stats();

        $this->render('admin/dashboard/index', [
            'pageTitle' => 'Admin Dashboard',
            'stats' => $stats,
        ]);
    }
}
