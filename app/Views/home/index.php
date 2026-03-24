<section class="hero p-4 p-md-5 mb-4">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <h1 class="display-6 fw-bold">Find your future programme</h1>
            <p class="lead mb-0">Browse undergraduate and postgraduate courses, see modules by year, meet teaching staff, and register interest for updates.</p>
        </div>
        <div class="col-lg-4">
            <div class="bg-white text-dark rounded-4 p-3 shadow-sm">
                <form method="get" action="<?= e(url()) ?>" class="row g-2" aria-label="Programme search and filter form">
                    <div class="col-12">
                        <label class="form-label" for="search">Search</label>
                        <input type="text" class="form-control" id="search" name="search" value="<?= e($search) ?>" placeholder="e.g. Cyber Security">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="level">Level</label>
                        <select class="form-select" id="level" name="level">
                            <option value="">All levels</option>
                            <?php foreach ($levels as $item): ?>
                                <option value="<?= e($item['LevelName']) ?>" <?= $level === $item['LevelName'] ? 'selected' : '' ?>>
                                    <?= e($item['LevelName']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 d-grid">
                        <button class="btn btn-primary">Search programmes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h4 mb-0">Available programmes</h2>
    <span class="badge text-bg-secondary"><?= count($programmes) ?> result(s)</span>
</div>

<?php if (!$programmes): ?>
    <div class="alert alert-warning">No programmes matched your search.</div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($programmes as $programme): ?>
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm card-hover">
                    <?php if (!empty($programme['Image'])): ?>
                        <img src="<?= e($programme['Image']) ?>" class="programme-img rounded-top" alt="<?= e($programme['ImageAlt'] ?: $programme['ProgrammeName']) ?>">
                    <?php else: ?>
                        <div class="programme-img rounded-top d-flex align-items-center justify-content-center bg-light text-muted">No image</div>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <h3 class="h5 card-title mb-0"><?= e($programme['ProgrammeName']) ?></h3>
                            <span class="badge text-bg-primary"><?= e($programme['LevelName']) ?></span>
                        </div>
                        <p class="text-muted small mb-2">
                            Programme leader: <?= e($programme['ProgrammeLeaderName']) ?>
                            <?php if (!empty($programme['ProgrammeLeaderTitle'])): ?>
                                · <?= e($programme['ProgrammeLeaderTitle']) ?>
                            <?php endif; ?>
                        </p>
                        <p class="card-text"><?= e(mb_strimwidth($programme['Description'] ?? '', 0, 150, '...')) ?></p>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0">
                        <a class="btn btn-outline-primary w-100" href="<?= e(url('programme/' . (int) $programme['ProgrammeID'])) ?>">View programme</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
