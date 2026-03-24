<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Prospective student mailing list</h1>
        <p class="text-muted mb-0">View, clean, and export interest registrations.</p>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-success" href="<?= e(url('admin/students/export')) ?>">Export CSV</a>
        <a class="btn btn-outline-secondary" href="<?= e(url('admin/dashboard')) ?>">Back to dashboard</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Programme</th>
                        <th>Student</th>
                        <th>Email</th>
                        <th>Registered</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= e($student['ProgrammeName']) ?></td>
                        <td><?= e($student['StudentName']) ?></td>
                        <td><?= e($student['Email']) ?></td>
                        <td><?= e($student['RegisteredAt']) ?></td>
                        <td>
                            <?php if ((int) $student['IsActive'] === 1): ?>
                                <span class="badge text-bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge text-bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ((int) $student['IsActive'] === 1): ?>
                                <form method="post" action="<?= e(url('admin/students')) ?>" onsubmit="return confirm('Deactivate this interest record?')">
                                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                    <input type="hidden" name="interest_id" value="<?= (int) $student['InterestID'] ?>">
                                    <button class="btn btn-sm btn-outline-danger">Deactivate</button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted small">No action</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
