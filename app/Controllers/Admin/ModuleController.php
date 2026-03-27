<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Module;
use App\Models\Staff;

class ModuleController extends BaseAdminController
{
    public function index(): void
    {
        $this->requireRole(['super_admin', 'editor']);

        $moduleModel = new Module();
        $editId = (int) ($_GET['edit'] ?? 0);
        $editing = $editId > 0 ? $moduleModel->findById($editId) : null;

        $this->render('admin/modules/index', [
            'pageTitle' => 'Manage Modules',
            'editing' => $editing,
            'modules' => $moduleModel->allForAdmin(),
            'staff' => (new Staff())->all(),
        ]);
    }

    public function store(): void
    {
        $this->requireRole(['super_admin', 'editor']);
        verify_csrf();

        $action = $_POST['action'] ?? '';
        $moduleModel = new Module();

        if ($action === 'delete') {
            $id = (int) ($_POST['module_id'] ?? 0);
            if ($moduleModel->isAssigned($id)) {
                flash('danger', 'Cannot delete a module already assigned to a programme.');
                redirect('admin/modules');
            }

            $moduleModel->delete($id);
            flash('success', 'Module deleted.');
            redirect('admin/modules');
        }

        if ($action === 'save') {
            $name = trim($_POST['module_name'] ?? '');
            if ($name === '') {
                flash('danger', 'Module name is required.');
                redirect('admin/modules');
            }

            $moduleModel->save([
                'module_id' => (int) ($_POST['module_id'] ?? 0),
                'module_name' => $name,
                'module_leader_id' => (int) ($_POST['module_leader_id'] ?? 0),
                'description' => trim($_POST['description'] ?? ''),
                'image' => trim($_POST['image'] ?? ''),
                'image_alt' => trim($_POST['image_alt'] ?? ''),
            ]);

            flash('success', ((int) ($_POST['module_id'] ?? 0) > 0) ? 'Module updated.' : 'Module created.');
            redirect('admin/modules');
        }

        redirect('admin/modules');
    }
}
