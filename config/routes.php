<?php
declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\ProgrammeController;
use App\Controllers\InterestController;
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ProgrammeController as AdminProgrammeController;
use App\Controllers\Admin\ModuleController as AdminModuleController;
use App\Controllers\Admin\ProgrammeModuleController;
use App\Controllers\Admin\StudentController;

return [
    ['GET', '', [HomeController::class, 'index']],
    ['GET', 'programme/{id}', [ProgrammeController::class, 'show']],

    ['POST', 'interest/register', [InterestController::class, 'store']],
    ['GET', 'interest/manage', [InterestController::class, 'manage']],
    ['POST', 'interest/withdraw', [InterestController::class, 'withdraw']],

    ['GET', 'admin/login', [AuthController::class, 'showLogin']],
    ['POST', 'admin/login', [AuthController::class, 'login']],
    ['GET', 'admin/logout', [AuthController::class, 'logout']],

    ['GET', 'admin', [DashboardController::class, 'index']],
    ['GET', 'admin/dashboard', [DashboardController::class, 'index']],

    ['GET', 'admin/programmes', [AdminProgrammeController::class, 'index']],
    ['POST', 'admin/programmes', [AdminProgrammeController::class, 'store']],

    ['GET', 'admin/modules', [AdminModuleController::class, 'index']],
    ['POST', 'admin/modules', [AdminModuleController::class, 'store']],

    ['GET', 'admin/programme-modules', [ProgrammeModuleController::class, 'index']],
    ['POST', 'admin/programme-modules', [ProgrammeModuleController::class, 'store']],

    ['GET', 'admin/students', [StudentController::class, 'index']],
    ['POST', 'admin/students', [StudentController::class, 'store']],
    ['GET', 'admin/students/export', [StudentController::class, 'export']],
];
