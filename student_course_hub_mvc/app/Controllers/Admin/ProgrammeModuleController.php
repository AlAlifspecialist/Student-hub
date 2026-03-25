<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Module;
use App\Models\Programme;
use App\Models\ProgrammeModule;

class ProgrammeModuleController extends BaseAdminController
{
    public function index(): void
    {
        $this->requireRole(['super_admin', 'editor']);

        $this->render('admin/programme_modules/index', [
            'pageTitle' => 'Manage Programme Modules',
            'programmes' => (new Programme())->allSimple(),
            'modules' => (new Module())->allSimple(),
            'mappings' => (new ProgrammeModule())->allMappings(),
        ]);
    }

    public function store(): void
    {
        $this->requireRole(['super_admin', 'editor']);
        verify_csrf();

        $action = $_POST['action'] ?? '';
        $mappingModel = new ProgrammeModule();

        if ($action === 'delete') {
            $mappingModel->delete((int) ($_POST['programme_module_id'] ?? 0));
            flash('success', 'Programme-module mapping removed.');
            redirect('admin/programme-modules');
        }

        if ($action === 'save') {
            try {
                $mappingModel->assign(
                    (int) ($_POST['programme_id'] ?? 0),
                    (int) ($_POST['module_id'] ?? 0),
                    (int) ($_POST['year'] ?? 0)
                );
                flash('success', 'Module assigned to programme.');
            } catch (\Throwable $e) {
                flash('danger', 'Could not save this mapping. It may already exist.');
            }
            redirect('admin/programme-modules');
        }

        redirect('admin/programme-modules');
    }
}
