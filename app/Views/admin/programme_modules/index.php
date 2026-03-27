<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Manage programme modules</h1>
    <a class="btn btn-outline-secondary" href="<?= e(url('admin/dashboard')) ?>">Back to dashboard</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5">Assign module to programme</h2>
                <form method="post" action="<?= e(url('admin/programme-modules')) ?>" class="row g-3">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="save">

                    <div class="col-12">
                        <label class="form-label">Programme</label>
                        <select class="form-select" name="programme_id" required>
                            <option value="">Select programme</option>
                            <?php foreach ($programmes as $programme): ?>
                                <option value="<?= (int) $programme['ProgrammeID'] ?>"><?= e($programme['ProgrammeName']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Module</label>
                        <select class="form-select" name="module_id" required>
                            <option value="">Select module</option>
                            <?php foreach ($modules as $module): ?>
                                <option value="<?= (int) $module['ModuleID'] ?>"><?= e($module['ModuleName']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Year of study</label>
                        <input class="form-control" type="number" name="year" min="1" max="6" required>
                    </div>

                    <div class="col-12 d-grid">
                        <button class="btn btn-primary">Save assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5">Current mappings</h2>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Programme</th>
                                <th>Year</th>
                                <th>Module</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($mappings as $mapping): ?>
                            <tr>
                                <td><?= e($mapping['ProgrammeName']) ?></td>
                                <td><?= (int) $mapping['Year'] ?></td>
                                <td><?= e($mapping['ModuleName']) ?></td>
                                <td>
                                    <form method="post" action="<?= e(url('admin/programme-modules')) ?>" onsubmit="return confirm('Remove this assignment?')">
                                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="programme_module_id" value="<?= (int) $mapping['ProgrammeModuleID'] ?>">
                                        <button class="btn btn-sm btn-outline-danger">Remove</button>
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
