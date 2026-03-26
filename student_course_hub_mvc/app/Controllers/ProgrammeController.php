<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Programme;

class ProgrammeController extends Controller
{
    public function show(string $id): void
    {
        $programmeModel = new Programme();
        $programme = $programmeModel->findPublishedById((int) $id);

        if (!$programme) {
            http_response_code(404);
            $this->render('errors/404', ['pageTitle' => 'Programme Not Found']);
            return;
        }

        $this->render('programme/show', [
            'pageTitle' => $programme['ProgrammeName'],
            'programme' => $programme,
            'modulesByYear' => $programmeModel->modulesGroupedByYear((int) $id),
        ]);
    }
}
