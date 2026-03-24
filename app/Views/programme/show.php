<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <?php if (!empty($programme['Image'])): ?>
                <img src="<?= e($programme['Image']) ?>" class="programme-img rounded-top" alt="<?= e($programme['ImageAlt'] ?: $programme['ProgrammeName']) ?>">
            <?php endif; ?>
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <h1 class="h2 mb-0"><?= e($programme['ProgrammeName']) ?></h1>
                    <span class="badge text-bg-primary"><?= e($programme['LevelName']) ?></span>
                </div>
                <p><?= nl2br(e($programme['Description'])) ?></p>

                <h2 class="h4 mt-4">Programme leader</h2>
                <div class="p-3 bg-light rounded-3">
                    <p class="mb-1 fw-semibold"><?= e($programme['ProgrammeLeaderName']) ?></p>
                    <p class="mb-1 text-muted">
                        <?= e($programme['JobTitle'] ?: 'Programme Leader') ?>
                        <?php if (!empty($programme['Department'])): ?>
                            · <?= e($programme['Department']) ?>
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($programme['Bio'])): ?>
                        <p class="mb-0"><?= e($programme['Bio']) ?></p>
                    <?php endif; ?>
                </div>

                <h2 class="h4 mt-4">Modules by year</h2>
                <?php foreach ($modulesByYear as $year => $items): ?>
                    <section class="mb-4" aria-labelledby="year-<?= (int) $year ?>">
                        <h3 id="year-<?= (int) $year ?>" class="h5 mb-3">
                            <span class="badge text-bg-dark year-badge">Year <?= (int) $year ?></span>
                        </h3>
                        <div class="row g-3">
                            <?php foreach ($items as $module): ?>
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <?php if (!empty($module['Image'])): ?>
                                            <img src="<?= e($module['Image']) ?>" class="module-img rounded-top" alt="<?= e($module['ImageAlt'] ?: $module['ModuleName']) ?>">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h4 class="h6"><?= e($module['ModuleName']) ?></h4>
                                            <p class="small text-muted mb-2">
                                                Module leader: <?= e($module['ModuleLeaderName']) ?>
                                                <?php if (!empty($module['ModuleLeaderTitle'])): ?>
                                                    · <?= e($module['ModuleLeaderTitle']) ?>
                                                <?php endif; ?>
                                            </p>
                                            <p class="small"><?= e($module['Description']) ?></p>
                                            <?php if ((int) $module['SharedProgrammeCount'] > 1): ?>
                                                <span class="badge text-bg-info">Shared by <?= (int) $module['SharedProgrammeCount'] ?> programme(s)</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm sticky-top" style="top: 1rem;">
            <div class="card-body">
                <h2 class="h4">Register your interest</h2>
                <p class="text-muted">Enter your details to receive updates about this programme.</p>

                <form action="<?= e(url('interest/register')) ?>" method="post" class="row g-3">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="programme_id" value="<?= (int) $programme['ProgrammeID'] ?>">

                    <div class="col-12">
                        <label class="form-label" for="student_name">Your name</label>
                        <input class="form-control" type="text" name="student_name" id="student_name" maxlength="100" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="email">Email address</label>
                        <input class="form-control" type="email" name="email" id="email" maxlength="255" required>
                    </div>

                    <div class="col-12 d-grid">
                        <button class="btn btn-primary">Register interest</button>
                    </div>
                </form>

                <hr>
                <p class="small mb-0">Already signed up? <a href="<?= e(url('interest/manage')) ?>">Manage or withdraw your interest</a>.</p>
            </div>
        </div>
    </div>
</div>
