<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Interest;

class StudentController extends BaseAdminController
{
    public function index(): void
    {
        $this->requireRole(['super_admin', 'mailer']);

        $this->render('admin/students/index', [
            'pageTitle' => 'Mailing List',
            'students' => (new Interest())->all(),
        ]);
    }

    public function store(): void
    {
        $this->requireRole(['super_admin', 'mailer']);
        verify_csrf();

        (new Interest())->deactivate((int) ($_POST['interest_id'] ?? 0));
        flash('success', 'Interest record deactivated.');
        redirect('admin/students');
    }

    public function export(): void
    {
        $this->requireRole(['super_admin', 'mailer']);
        $rows = (new Interest())->all();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="mailing-list.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['InterestID', 'ProgrammeName', 'StudentName', 'Email', 'RegisteredAt', 'IsActive']);
        foreach ($rows as $row) {
            fputcsv($out, [
                $row['InterestID'],
                $row['ProgrammeName'],
                $row['StudentName'],
                $row['Email'],
                $row['RegisteredAt'],
                $row['IsActive'],
            ]);
        }
        fclose($out);
        exit;
    }
}
