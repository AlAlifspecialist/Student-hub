<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h1 class="h3">Manage your interest</h1>
                <p class="text-muted">Enter your email address to view active and withdrawn programme subscriptions.</p>

                <form method="get" action="<?= e(url('interest/manage')) ?>" class="row g-3 mb-4">
                    <div class="col-md-9">
                        <label for="email" class="form-label">Email address</label>
                        <input class="form-control" type="email" name="email" id="email" value="<?= e($email) ?>" required>
                    </div>
                    <div class="col-md-3 d-grid align-self-end">
                        <button class="btn btn-primary">Find subscriptions</button>
                    </div>
                </form>

                <?php if ($email !== '' && !$records): ?>
                    <div class="alert alert-warning">No subscriptions found for that email address.</div>
                <?php endif; ?>

                <?php if ($records): ?>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Programme</th>
                                    <th>Name</th>
                                    <th>Registered</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($records as $record): ?>
                                <tr>
                                    <td><?= e($record['ProgrammeName']) ?></td>
                                    <td><?= e($record['StudentName']) ?></td>
                                    <td><?= e($record['RegisteredAt']) ?></td>
                                    <td>
                                        <?php if ((int) $record['IsActive'] === 1): ?>
                                            <span class="badge text-bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge text-bg-secondary">Withdrawn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ((int) $record['IsActive'] === 1): ?>
                                            <form action="<?= e(url('interest/withdraw')) ?>" method="post" class="d-inline">
                                                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                                <input type="hidden" name="interest_id" value="<?= (int) $record['InterestID'] ?>">
                                                <input type="hidden" name="email" value="<?= e($email) ?>">
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Withdraw this interest?')">Withdraw</button>
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
