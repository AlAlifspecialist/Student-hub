<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Interest;
use App\Models\Programme;

class InterestController extends Controller
{
    public function store(): void
    {
        if (!is_post()) {
            redirect('');
        }

        verify_csrf();

        $programmeId = (int) ($_POST['programme_id'] ?? 0);
        $studentName = trim($_POST['student_name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($programmeId <= 0 || $studentName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash('danger', 'Please provide a valid name and email address.');
            redirect('programme/' . $programmeId);
        }

        $programmeModel = new Programme();
        if (!$programmeModel->findPublishedById($programmeId)) {
            flash('danger', 'Selected programme is not available.');
            redirect('');
        }

        $interestModel = new Interest();
        if ($interestModel->register($programmeId, $studentName, $email)) {
            flash('success', 'Interest registered successfully. You can manage subscriptions using your email address.');
        } else {
            flash('danger', 'Something went wrong while saving your interest.');
        }

        redirect('programme/' . $programmeId);
    }

    public function manage(): void
    {
        $email = trim($_GET['email'] ?? '');
        $records = [];

        if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $records = (new Interest())->findByEmail($email);
        }

        $this->render('interest/manage', [
            'pageTitle' => 'Manage Interest',
            'email' => $email,
            'records' => $records,
        ]);
    }

    public function withdraw(): void
    {
        if (!is_post()) {
            redirect('interest/manage');
        }

        verify_csrf();
        $interestId = (int) ($_POST['interest_id'] ?? 0);
        $email = trim($_POST['email'] ?? '');

        if ($interestId > 0) {
            (new Interest())->withdraw($interestId);
            flash('success', 'Your interest has been withdrawn.');
        }

        redirect('interest/manage' . ($email !== '' ? '?email=' . urlencode($email) : ''));
    }
}
