<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Programme;
use App\Models\Level;

class HomeController extends Controller
{
    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $level = trim($_GET['level'] ?? '');

        $programmeModel = new Programme();
        $levelModel = new Level();

        $this->render('home/index', [
            'pageTitle' => 'Explore Programmes',
            'search' => $search,
            'level' => $level,
            'programmes' => $programmeModel->searchPublished($search, $level),
            'levels' => $levelModel->all(),
        ]);
    }
}
