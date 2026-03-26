<?php $flash = get_flash(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? config('app.name')) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="<?= e(asset('public/assets/css/app.css')) ?>?v=74" rel="stylesheet">
</head>
<body>

<a href="#main-content" class="skip-link">Skip to main content</a>

<header class="site-header premium-header">
    <div class="site-container nav-wrapper">
        <a class="site-brand premium-brand" href="<?= e(url()) ?>">
            Student Course Hub
        </a>

        <nav class="site-nav premium-nav" aria-label="Main navigation">
            <a href="<?= e(url()) ?>"><?= e(t('browse_programmes')) ?></a>
            <a href="<?= e(url('interest/manage')) ?>"><?= e(t('manage_interest')) ?></a>

            <?php if (admin_logged_in()): ?>
                <a href="<?= e(url('admin/dashboard')) ?>"><?= e(t('admin')) ?></a>
            <?php else: ?>
                <a href="<?= e(url('admin/login')) ?>"><?= e(t('admin')) ?></a>
            <?php endif; ?>

            <div class="premium-lang-group">
                <a class="lang-link premium-lang-link <?= current_lang() === 'en' ? 'active-lang' : '' ?>" href="<?= e(url()) ?>?lang=en">EN</a>
                <span class="lang-separator premium-separator">/</span>
                <a class="lang-link premium-lang-link <?= current_lang() === 'da' ? 'active-lang' : '' ?>" href="<?= e(url()) ?>?lang=da">DA</a>
            </div>

            <?php if (admin_logged_in()): ?>
                <a class="premium-login-btn" href="<?= e(url('admin/logout')) ?>"><?= e(t('logout')) ?></a>
            <?php else: ?>
                <a class="premium-login-btn" href="<?= e(url('admin/login')) ?>"><?= e(t('login')) ?></a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="site-container page-main" id="main-content">
    <?php if ($flash): ?>
        <div class="alert-box alert-<?= e($flash['type']) ?>">
            <span><?= e($flash['message']) ?></span>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()" aria-label="Close">×</button>
        </div>
    <?php endif; ?>

    <?= $content ?>
</main>

<footer class="site-footer premium-footer">
    <div class="site-container footer-text">
        Student Course Hub MVC &copy; <?= date('Y') ?>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.page-programme-card');

    cards.forEach(function (card) {
        const video = card.querySelector('.programme-hover-video');
        if (!video) return;

        card.addEventListener('mouseenter', function () {
            video.play().catch(function () {});
        });

        card.addEventListener('mouseleave', function () {
            video.pause();
            video.currentTime = 0;
        });
    });
});
</script>

</body>
</html>