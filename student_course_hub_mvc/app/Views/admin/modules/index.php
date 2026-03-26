<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Manage modules</h1>
    <a class="btn btn-outline-secondary" href="<?= e(url('admin/dashboard')) ?>">Back to dashboard</a>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5"><?= $editing ? 'Edit module' : 'Add module' ?></h2>
                <form method="post" action="<?= e(url('admin/modules')) ?>" class="row g-3">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="module_id" value="<?= (int) ($editing['ModuleID'] ?? 0) ?>">

                    <div class="col-12">
                        <label class="form-label">Module name</label>
                        <input class="form-control" type="text" name="module_name" value="<?= e($editing['ModuleName'] ?? '') ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Module leader</label>
                        <select class="form-select" name="module_leader_id">
                            <option value="">None</option>
                            <?php foreach ($staff as $member): ?>
                                <option value="<?= (int) $member['StaffID'] ?>" <?= (int) ($editing['ModuleLeaderID'] ?? 0) === (int) $member['StaffID'] ? 'selected' : '' ?>>
                                    <?= e($member['Name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4"><?= e($editing['Description'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Image path</label>
                        <input class="form-control" type="text" name="image" value="<?= e($editing['Image'] ?? '') ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Image alt text</label>
                        <input class="form-control" type="text" name="image_alt" value="<?= e($editing['ImageAlt'] ?? '') ?>">
                    </div>

                    <div class="col-12 d-grid">
                        <button class="btn btn-primary"><?= $editing ? 'Update module' : 'Create module' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5">Module list</h2>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Leader</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($modules as $module): ?>
                            <tr>
                                <td><?= e($module['ModuleName']) ?></td>
                                <td><?= e($module['LeaderName']) ?></td>
                                <td class="d-flex gap-2 flex-wrap">
                                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('admin/modules?edit=' . (int) $module['ModuleID'])) ?>">Edit</a>
                                    <form method="post" action="<?= e(url('admin/modules')) ?>" onsubmit="return confirm('Delete this module?')">
                                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="module_id" value="<?= (int) $module['ModuleID'] ?>">
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
