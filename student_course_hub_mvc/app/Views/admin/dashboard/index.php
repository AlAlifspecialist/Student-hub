<div class="admin-dashboard-top">
    <div>
        <h1 class="admin-dashboard-title">Admin dashboard</h1>
        <p class="admin-dashboard-subtitle">
            Signed in as <?= e(current_admin()['full_name']) ?> (<?= e(current_admin()['role']) ?>)
        </p>

<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Programmes</div>
        <div class="admin-stat-number"><?= (int) $stats['programmeCount'] ?></div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Published</div>
        <div class="admin-stat-number"><?= (int) $stats['publishedCount'] ?></div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Modules</div>
        <div class="admin-stat-number"><?= (int) $stats['moduleCount'] ?></div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Active interests</div>
        <div class="admin-stat-number"><?= (int) $stats['interestCount'] ?></div>
    </div>
</div>

<div class="admin-action-grid">
    <?php if (admin_has_role(['super_admin', 'editor'])): ?>
        <article class="admin-action-card">
            <h2 class="admin-action-title">Programmes</h2>
            <p class="admin-action-text">
                Create, update, delete and publish or unpublish programmes.
            </p>
            <a class="admin-action-btn" href="<?= e(url('admin/programmes')) ?>">
                Manage programmes
            </a>
        </article>

        <article class="admin-action-card">
            <h2 class="admin-action-title">Modules</h2>
            <p class="admin-action-text">
                Add and update modules, module descriptions and leader assignments.
            </p>
            <a class="admin-action-btn" href="<?= e(url('admin/modules')) ?>">
                Manage modules
            </a>
        </article>

        <article class="admin-action-card">
            <h2 class="admin-action-title">Programme modules</h2>
            <p class="admin-action-text">
                Assign modules to programmes and organise them by study year.
            </p>
            <a class="admin-action-btn" href="<?= e(url('admin/programme-modules')) ?>">
                Assign modules
            </a>
        </article>
    <?php endif; ?>

    <?php if (admin_has_role(['super_admin', 'mailer'])): ?>
        <article class="admin-action-card">
            <h2 class="admin-action-title">Mailing list</h2>
            <p class="admin-action-text">
                View active student interest registrations and export a CSV mailing list.
            </p>
            <a class="admin-action-btn" href="<?= e(url('admin/students')) ?>">
                Open mailing list
            </a>
        </article>
    <?php endif; ?>
</div>