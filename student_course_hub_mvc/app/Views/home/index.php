<section class="hero p-4 p-md-5 mb-4 shadow-sm">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <span class="hero-eyebrow">Prospective student website</span>
            <h1 class="display-6 fw-bold hero-title">Find your future programme</h1>
            <p class="lead mb-0 hero-subtitle">
                Browse undergraduate and postgraduate courses, see modules by year,
                meet teaching staff, and register interest for updates.
            </p>
        </div>
        <div class="col-lg-4">
            <div class="bg-white text-dark rounded-4 p-3 shadow-sm search-panel">
                <form method="get" action="<?= e(url()) ?>" class="row g-2" aria-label="Programme search and filter form">
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="search">Search</label>
                        <input type="text" class="form-control form-control-modern" id="search" name="search" value="<?= e($search) ?>" placeholder="e.g. Cyber Security">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="level">Level</label>
                        <select class="form-select form-control-modern" id="level" name="level">
                            <option value="">All levels</option>
                            <?php foreach ($levels as $item): ?>
                                <option value="<?= e($item['LevelName']) ?>" <?= $level === $item['LevelName'] ? 'selected' : '' ?>>
                                    <?= e($item['LevelName']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 d-grid">
                        <button class="btn btn-primary btn-modern">Search programmes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="d-flex justify-content-between align-items-center mb-3 section-header flex-wrap gap-2">
    <h2 class="h4 mb-0 fw-bold">Available programmes</h2>
    <span class="badge text-bg-secondary results-badge"><?= count($programmes) ?> result(s)</span>
</div>

<?php if (!$programmes): ?>
    <div class="alert alert-warning shadow-sm border-0 rounded-4">No programmes matched your search.</div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($programmes as $programme): ?>
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm card-hover programme-card">
                    <?php if (!empty($programme['Image'])): ?>
                        <img src="<?= e($programme['Image']) ?>" class="programme-img rounded-top" alt="<?= e($programme['ImageAlt'] ?: $programme['ProgrammeName']) ?>">
                    <?php else: ?>
                        <div class="programme-img rounded-top d-flex align-items-center justify-content-center bg-light text-muted no-image-placeholder">
                            No image
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <h3 class="h5 card-title mb-0 programme-title"><?= e($programme['ProgrammeName']) ?></h3>
                            <span class="badge text-bg-primary rounded-pill px-3 py-2"><?= e($programme['LevelName']) ?></span>
                        </div>

                        <p class="text-muted small mb-2 programme-meta">
                            Programme leader: <?= e($programme['ProgrammeLeaderName']) ?>
                            <?php if (!empty($programme['ProgrammeLeaderTitle'])): ?>
                                · <?= e($programme['ProgrammeLeaderTitle']) ?>
                            <?php endif; ?>
                        </p>

                        <p class="card-text programme-description">
                            <?= e(mb_strimwidth($programme['Description'] ?? '', 0, 150, '...')) ?>
                        </p>
                    </div>

                    <div class="card-footer bg-white border-0 pt-0">
                        <a class="btn btn-outline-primary w-100 btn-modern-outline" href="<?= e(url('programme/' . (int) $programme['ProgrammeID'])) ?>">
                            View programme
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>