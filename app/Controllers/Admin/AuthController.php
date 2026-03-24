<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\AdminUser;

class AuthController extends BaseAdminController
{
    public function showLogin(): void
    {
        if (admin_logged_in()) {
            redirect('admin/dashboard');
        }

        $this->render('admin/auth/login', ['pageTitle' => 'Admin Login']);
    }

    public function login(): void
    {
        verify_csrf();

        $username = trim($_POST['username'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $admin = (new AdminUser())->findActiveByUsername($username);

        if ($admin && password_verify($password, $admin['PasswordHash'])) {
            $_SESSION['admin'] = [
                'id' => $admin['AdminID'],
                'username' => $admin['Username'],
                'full_name' => $admin['FullName'],
                'role' => $admin['Role'],
            ];

            flash('success', 'Welcome back, ' . $admin['FullName'] . '.');
            redirect('admin/dashboard');
        }

        flash('danger', 'Invalid username or password.');
        redirect('admin/login');
    }

    public function logout(): void
    {
        unset($_SESSION['admin']);
        flash('success', 'You have been logged out.');
        redirect('admin/login');
    }
}
