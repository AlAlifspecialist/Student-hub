<?php $flash = get_flash(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? config('app.name')) ?></title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- App CSS (cache refresh added) -->
    <link href="<?= e(asset('public/assets/css/app.css')) ?>?v=5" rel="stylesheet">
</head>
<body>

<a href="#main-content" class="skip-link">Skip to main content</a>

<nav class="navbar navbar-expand-lg bg-white border-bottom mb-4">
    <div class="container">

        <a class="navbar-brand fw-bold" href="<?= e(url()) ?>">
            Student Course Hub
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#siteNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="siteNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="<?= e(url()) ?>">Browse Programmes</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= e(url('interest/manage')) ?>">Manage Interest</a>
                </li>

                <li class="nav-item">
                    <?php if (admin_logged_in()): ?>
                        <a class="nav-link" href="<?= e(url('admin/dashboard')) ?>">Admin</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?= e(url('admin/login')) ?>">Admin</a>
                    <?php endif; ?>
                </li>

                <?php if (admin_logged_in()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= e(url('admin/logout')) ?>">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= e(url('admin/login')) ?>">Login</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5" id="main-content">

    <?php if ($flash): ?>
        <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show">
            <?= e($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?= $content ?>

</div>

<footer class="border-top bg-white py-4">
    <div class="container text-muted small">
        Student Course Hub MVC &copy; <?= date('Y') ?>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>