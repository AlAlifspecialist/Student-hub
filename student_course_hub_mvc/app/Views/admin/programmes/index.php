<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Manage programmes</h1>
    <a class="btn btn-outline-secondary" href="<?= e(url('admin/dashboard')) ?>">Back to dashboard</a>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5"><?= $editing ? 'Edit programme' : 'Add programme' ?></h2>
                <form method="post" action="<?= e(url('admin/programmes')) ?>" class="row g-3">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="programme_id" value="<?= (int) ($editing['ProgrammeID'] ?? 0) ?>">

                    <div class="col-12">
                        <label class="form-label">Programme name</label>
                        <input class="form-control" type="text" name="programme_name" value="<?= e($editing['ProgrammeName'] ?? '') ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Level</label>
                        <select class="form-select" name="level_id" required>
                            <option value="">Select level</option>
                            <?php foreach ($levels as $level): ?>
                                <option value="<?= (int) $level['LevelID'] ?>" <?= (int) ($editing['LevelID'] ?? 0) === (int) $level['LevelID'] ? 'selected' : '' ?>>
                                    <?= e($level['LevelName']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Programme leader</label>
                        <select class="form-select" name="programme_leader_id">
                            <option value="">None</option>
                            <?php foreach ($staff as $member): ?>
                                <option value="<?= (int) $member['StaffID'] ?>" <?= (int) ($editing['ProgrammeLeaderID'] ?? 0) === (int) $member['StaffID'] ? 'selected' : '' ?>>
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

                    <div class="col-12 form-check">
                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" <?= (int) ($editing['IsPublished'] ?? 1) === 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_published">Published</label>
                    </div>

                    <div class="col-12 d-grid">
                        <button class="btn btn-primary"><?= $editing ? 'Update programme' : 'Create programme' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5">Programme list</h2>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Level</th>
                                <th>Leader</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($programmes as $programme): ?>
                            <tr>
                                <td><?= e($programme['ProgrammeName']) ?></td>
                                <td><?= e($programme['LevelName']) ?></td>
                                <td><?= e($programme['LeaderName']) ?></td>
                                <td>
                                    <?php if ((int) $programme['IsPublished'] === 1): ?>
                                        <span class="badge text-bg-success">Published</span>
                                    <?php else: ?>
                                        <span class="badge text-bg-secondary">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="d-flex gap-2 flex-wrap">
                                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('admin/programmes?edit=' . (int) $programme['ProgrammeID'])) ?>">Edit</a>
                                    <form method="post" action="<?= e(url('admin/programmes')) ?>" onsubmit="return confirm('Delete this programme?')">
                                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="programme_id" value="<?= (int) $programme['ProgrammeID'] ?>">
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
