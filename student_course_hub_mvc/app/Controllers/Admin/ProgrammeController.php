<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Level;
use App\Models\Programme;
use App\Models\Staff;

class ProgrammeController extends BaseAdminController
{
    public function index(): void
    {
        $this->requireRole(['super_admin', 'editor']);

        $programmeModel = new Programme();
        $editId = (int) ($_GET['edit'] ?? 0);
        $editing = $editId > 0 ? $programmeModel->findById($editId) : null;

        $this->render('admin/programmes/index', [
            'pageTitle' => 'Manage Programmes',
            'editing' => $editing,
            'programmes' => $programmeModel->allForAdmin(),
            'levels' => (new Level())->all(),
            'staff' => (new Staff())->all(),
        ]);
    }

    public function store(): void
    {
        $this->requireRole(['super_admin', 'editor']);
        verify_csrf();

        $action = $_POST['action'] ?? '';
        $programmeModel = new Programme();

        if ($action === 'delete') {
            $programmeModel->delete((int) ($_POST['programme_id'] ?? 0));
            flash('success', 'Programme deleted.');
            redirect('admin/programmes');
        }

        if ($action === 'save') {
            $name = trim($_POST['programme_name'] ?? '');
            $levelId = (int) ($_POST['level_id'] ?? 0);

            if ($name === '' || $levelId <= 0) {
                flash('danger', 'Programme name and level are required.');
                redirect('admin/programmes');
            }

            $programmeModel->save([
                'programme_id' => (int) ($_POST['programme_id'] ?? 0),
                'programme_name' => $name,
                'level_id' => $levelId,
                'programme_leader_id' => (int) ($_POST['programme_leader_id'] ?? 0),
                'description' => trim($_POST['description'] ?? ''),
                'image' => trim($_POST['image'] ?? ''),
                'image_alt' => trim($_POST['image_alt'] ?? ''),
                'is_published' => isset($_POST['is_published']) ? 1 : 0,
            ]);

            flash('success', ((int) ($_POST['programme_id'] ?? 0) > 0) ? 'Programme updated.' : 'Programme created.');
            redirect('admin/programmes');
        }

        redirect('admin/programmes');
    }
}
