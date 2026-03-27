<?php
$programmeVideos = [
    'MSc Artificial Intelligence' => asset('public/assets/video/programmes/ai.mp4'),
    'MSc Cyber Security' => asset('public/assets/video/programmes/cyber.mp4'),
    'MSc Data Science' => asset('public/assets/video/programmes/data.mp4'),
    'MSc Machine Learning' => asset('public/assets/video/programmes/ml.mp4'),
    'MSc Software Engineering' => asset('public/assets/video/programmes/software-msc.mp4'),
    'BSc Artificial Intelligence' => asset('public/assets/video/programmes/ai-bsc.mp4'),
    'BSc Computer Science' => asset('public/assets/video/programmes/cs.mp4'),
    'BSc Cyber Security' => asset('public/assets/video/programmes/cyber-bsc.mp4'),
    'BSc Data Science' => asset('public/assets/video/programmes/data-bsc.mp4'),
    'BSc Software Engineering' => asset('public/assets/video/programmes/software.mp4'),
];

$heroVideo = $programmeVideos[$programme['ProgrammeName']] ?? null;
?>

<section class="programme-eth-wrap">
    <div class="programme-eth-main-full">

        <nav class="programme-eth-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= e(url()) ?>"><?= e(t('home')) ?></a>
            <span>/</span>
            <a href="<?= e(url()) ?>"><?= e(t('browse_programmes')) ?></a>
            <span>/</span>
            <span><?= e(translate_programme_name($programme['ProgrammeName'])) ?></span>
        </nav>

        <section class="programme-eth-hero">
            <div class="programme-eth-meta">
                <span class="programme-eth-level"><?= e(translate_level($programme['LevelName'])) ?></span>
            </div>

            <h1 class="programme-eth-title">
                <?= e(translate_programme_name($programme['ProgrammeName'])) ?>
            </h1>

            <p class="programme-eth-intro">
                <?= e(translate_programme_description($programme['ProgrammeName'], $programme['Description'] ?? '')) ?>
            </p>
        </section>

        <?php if ($heroVideo): ?>
            <figure class="programme-eth-video-figure">
                <video class="programme-eth-video" autoplay muted loop playsinline>
                    <source src="<?= e($heroVideo) ?>" type="video/mp4">
                </video>
                <div class="programme-eth-video-overlay"></div>
            </figure>
        <?php elseif (!empty($programme['Image'])): ?>
            <figure class="programme-eth-video-figure">
                <img
                    src="<?= e($programme['Image']) ?>"
                    alt="<?= e($programme['ImageAlt'] ?: $programme['ProgrammeName']) ?>"
                    class="programme-eth-image"
                >
            </figure>
        <?php endif; ?>

        <div class="programme-leader-interest-row">

            <section class="programme-leader-highlight">
                <div class="programme-leader-label"><?= e(t('programme_leader')) ?></div>

                <div class="programme-leader-box">
                    <div class="programme-leader-content">
                        <h2 class="programme-leader-name"><?= e($programme['ProgrammeLeaderName']) ?></h2>

                        <p class="programme-leader-role">
                            <?= e(translate_leader_title($programme['JobTitle'] ?: t('programme_leader'))) ?>
                            <?php if (!empty($programme['Department'])): ?>
                                · <?= e($programme['Department']) ?>
                            <?php endif; ?>
                        </p>

                        <?php if (!empty($programme['Bio'])): ?>
                            <p class="programme-leader-bio"><?= e($programme['Bio']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <aside class="programme-interest-side">
                <div class="programme-eth-interest programme-interest-inline programme-interest-dark">
                    <div class="programme-eth-section-label interest-dark-label"><?= e(t('manage_interest')) ?></div>
                    <h2 class="programme-eth-interest-title interest-dark-title"><?= e(t('register_interest_title')) ?></h2>
                    <p class="programme-eth-interest-text interest-dark-text"><?= e(t('register_interest_text')) ?></p>

                    <form action="<?= e(url('interest/register')) ?>" method="post" class="interest-form-premium">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                        <input type="hidden" name="programme_id" value="<?= (int) $programme['ProgrammeID'] ?>">

                        <div class="premium-field interest-dark-field">
                            <label for="student_name"><?= e(t('your_name')) ?></label>
                            <input type="text" name="student_name" id="student_name" maxlength="100" required>
                        </div>

                        <div class="premium-field interest-dark-field">
                            <label for="email"><?= e(t('email_address')) ?></label>
                            <input type="email" name="email" id="email" maxlength="255" required>
                        </div>

                        <button class="premium-primary-button interest-dark-button" type="submit">
                            <?= e(t('register_interest_btn')) ?>
                        </button>
                    </form>

                    <div class="programme-eth-interest-footer interest-dark-footer">
                        <a href="<?= e(url('interest/manage')) ?>"><?= e(t('manage_or_withdraw')) ?></a>
                    </div>
                </div>
            </aside>

        </div>

        <section class="programme-modules-highlight">
            <div class="programme-modules-heading-row">
                <div class="programme-modules-label"><?= e(t('modules_by_year')) ?></div>
                <h2 class="programme-modules-title"><?= e(t('modules_by_year')) ?></h2>
            </div>

            <?php foreach ($modulesByYear as $year => $items): ?>
                <section class="programme-year-section" aria-labelledby="year-<?= (int) $year ?>">
                    <div class="programme-year-header">
                        <span id="year-<?= (int) $year ?>" class="programme-year-badge"><?= e(t('year')) ?> <?= (int) $year ?></span>
                    </div>

                    <div class="programme-module-ultra-grid">
                        <?php foreach ($items as $module): ?>
                            <article class="programme-module-card-premium">
                                <?php if (!empty($module['Image'])): ?>
                                    <img
                                        src="<?= e($module['Image']) ?>"
                                        alt="<?= e($module['ImageAlt'] ?: $module['ModuleName']) ?>"
                                        class="programme-module-card-image"
                                    >
                                <?php endif; ?>

                                <h3 class="programme-module-card-title">
                                    <?= e(translate_module_name($module['ModuleName'])) ?>
                                </h3>

                                <p class="programme-module-card-meta">
                                    <?= e(t('module_leader')) ?>: <?= e($module['ModuleLeaderName']) ?>
                                    <?php if (!empty($module['ModuleLeaderTitle'])): ?>
                                        · <?= e(translate_leader_title($module['ModuleLeaderTitle'])) ?>
                                    <?php endif; ?>
                                </p>

                                <p class="programme-module-card-description">
                                    <?= e($module['Description']) ?>
                                </p>

                                <?php if ((int) $module['SharedProgrammeCount'] > 1): ?>
                                    <div class="programme-module-card-shared">
                                        <?= e(t('shared_by')) ?> <?= (int) $module['SharedProgrammeCount'] ?> <?= e(t('programmes_count')) ?>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </section>

    </div>
</section>