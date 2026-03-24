<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Admin dashboard</h1>
        <p class="text-muted mb-0">Signed in as <?= e(current_admin()['full_name']) ?> (<?= e(current_admin()['role']) ?>)</p>
    </div>
    <a class="btn btn-outline-secondary" href="<?= e(url('admin/logout')) ?>">Log out</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Programmes</div><div class="display-6"><?= (int) $stats['programmeCount'] ?></div></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Published</div><div class="display-6"><?= (int) $stats['publishedCount'] ?></div></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Modules</div><div class="display-6"><?= (int) $stats['moduleCount'] ?></div></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Active interests</div><div class="display-6"><?= (int) $stats['interestCount'] ?></div></div></div></div>
</div>

<div class="list-group shadow-sm">
    <?php if (admin_has_role(['super_admin', 'editor'])): ?>
        <a href="<?= e(url('admin/programmes')) ?>" class="list-group-item list-group-item-action">Manage programmes</a>
        <a href="<?= e(url('admin/modules')) ?>" class="list-group-item list-group-item-action">Manage modules</a>
        <a href="<?= e(url('admin/programme-modules')) ?>" class="list-group-item list-group-item-action">Assign modules to programmes</a>
    <?php endif; ?>

    <?php if (admin_has_role(['super_admin', 'mailer'])): ?>
        <a href="<?= e(url('admin/students')) ?>" class="list-group-item list-group-item-action">View mailing list</a>
    <?php endif; ?>
</div>
