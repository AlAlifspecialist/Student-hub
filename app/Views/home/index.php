<section class="page-breadcrumb-wrap">
    <nav aria-label="breadcrumb" class="site-container">
        <ol class="page-breadcrumb">
            <li><a href="<?= e(url()) ?>"><?= e(t('home')) ?></a></li>
            <li><?= e(t('browse_programmes')) ?></li>
        </ol>
    </nav>
</section>

<section class="page-hero video-hero">
    <video class="hero-video" autoplay muted loop playsinline>
        <source src="<?= e(asset('public/assets/video/campus-loop.mp4')) ?>" type="video/mp4">
    </video>

    <div class="video-overlay"></div>

    <div class="site-container page-hero-overlay">
        <div class="page-hero-tag"><?= e(t('hero_tagline')) ?></div>
        <h1 class="page-hero-title page-hero-title-overlay"><?= e(t('hero_title')) ?></h1>
    </div>
</section>

<section class="page-info-section">
    <div class="site-container">
        <div class="two-column-grid info-grid">
            <div class="page-link-block">
                <h2 class="page-section-heading"><?= e(t('learn_more')) ?></h2>

                <a href="#search-section" class="page-line-link">
                    <span><?= e(t('search_btn')) ?></span>
                    <span>→</span>
                </a>

                <a href="#programmes-section" class="page-line-link">
                    <span><?= e(t('available')) ?></span>
                    <span>→</span>
                </a>

                <a href="<?= e(url('interest/manage')) ?>" class="page-line-link">
                    <span><?= e(t('manage_interest')) ?></span>
                    <span>→</span>
                </a>

                <a href="<?= e(url('admin/login')) ?>" class="page-line-link">
                    <span><?= e(t('admin')) ?></span>
                    <span>→</span>
                </a>
            </div>

            <div class="page-directory-block">
                <div class="page-directory-label"><?= e(t('directory')) ?></div>
                <h3 class="page-directory-title"><?= e(t('find_your_way')) ?></h3>
                <p class="page-directory-text">
                    <?= e(t('directory_text')) ?>
                </p>
                <a href="#programmes-section" class="page-directory-link">→ <?= e(t('browse_available')) ?></a>
            </div>
        </div>

        <div class="stats-grid page-stats-row">
            <div class="stat-box">
                <div class="page-stat-number"><?= count($programmes) ?></div>
                <div class="page-stat-label"><?= e(t('available')) ?></div>
            </div>
            <div class="stat-box">
                <div class="page-stat-number"><?= count($levels) ?></div>
                <div class="page-stat-label"><?= e(t('level_label')) ?></div>
            </div>
            <div class="stat-box">
                <div class="page-stat-number">24/7</div>
                <div class="page-stat-label"><?= e(t('access')) ?></div>
            </div>
            <div class="stat-box">
                <div class="page-stat-number">100%</div>
                <div class="page-stat-label"><?= e(t('student_focused')) ?></div>
            </div>
        </div>
    </div>
</section>

<section id="search-section" class="page-search-section">
    <div class="site-container">
        <div class="page-search-panel">
            <div class="search-layout">
                <div class="search-intro">
                    <h2 class="page-section-heading"><?= e(t('search_btn')) ?></h2>
                    <p class="page-muted-text">
                        <?= e(t('search_help_text')) ?>
                    </p>
                </div>

                <form method="get" action="<?= e(url()) ?>" class="search-form" aria-label="Programme search and filter form">
                    <div class="field-group">
                        <label class="field-label" for="search"><?= e(t('search_label')) ?></label>
                        <input
                            type="text"
                            class="page-input"
                            id="search"
                            name="search"
                            value="<?= e($search) ?>"
                            placeholder="<?= e(t('search_placeholder')) ?>"
                        >
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="level"><?= e(t('level_label')) ?></label>
                        <select class="page-input" id="level" name="level">
                            <option value=""><?= e(t('all_levels')) ?></option>
                            <?php foreach ($levels as $item): ?>
                                <option value="<?= e($item['LevelName']) ?>" <?= $level === $item['LevelName'] ? 'selected' : '' ?>>
                                    <?= e(translate_level($item['LevelName'])) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field-group button-group">
                        <label class="field-label invisible-label">Search</label>
                        <button class="page-search-btn" type="submit"><?= e(t('search_btn')) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section id="programmes-section" class="page-programmes-section">
    <div class="site-container">
        <div class="section-topbar">
            <h2 class="page-section-heading"><?= e(t('available')) ?></h2>
            <div class="page-results-count"><?= count($programmes) ?> <?= e(t('result_count')) ?></div>
        </div>

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
        ?>

        <?php if (!$programmes): ?>
            <div class="alert-box alert-warning">
                <span><?= e(t('no_results')) ?></span>
            </div>
        <?php else: ?>
            <div class="cards-grid">
                <?php foreach ($programmes as $programme): ?>
                    <?php $videoSrc = $programmeVideos[$programme['ProgrammeName']] ?? null; ?>
                    <div class="page-programme-card">
                        <?php if ($videoSrc): ?>
                            <div class="programme-media">
                                <video
                                    class="programme-hover-video"
                                    muted
                                    loop
                                    playsinline
                                    preload="metadata"
                                >
                                    <source src="<?= e($videoSrc) ?>" type="video/mp4">
                                </video>
                            </div>
                        <?php elseif (!empty($programme['Image'])): ?>
                            <img
                                src="<?= e($programme['Image']) ?>"
                                class="programme-img"
                                alt="<?= e($programme['ImageAlt'] ?: $programme['ProgrammeName']) ?>"
                            >
                        <?php else: ?>
                            <div class="programme-img page-no-image">
                                <?= e(t('no_image')) ?>
                            </div>
                        <?php endif; ?>

                        <div class="page-programme-body">
                            <div class="programme-head">
                                <h3 class="page-programme-title"><?= e(translate_programme_name($programme['ProgrammeName'])) ?></h3>
                                <span class="page-level-badge"><?= e(translate_level($programme['LevelName'])) ?></span>
                            </div>

                            <p class="page-programme-meta">
                                <?= e(t('programme_leader')) ?>: <?= e($programme['ProgrammeLeaderName']) ?>
                                <?php if (!empty($programme['ProgrammeLeaderTitle'])): ?>
                                    · <?= e(translate_leader_title($programme['ProgrammeLeaderTitle'])) ?>
                                <?php endif; ?>
                            </p>

                            <p class="page-programme-description">
                                <?= e(mb_strimwidth(translate_programme_description($programme['ProgrammeName'], $programme['Description'] ?? ''), 0, 150, '...')) ?>
                            </p>

                            <a class="page-programme-link" href="<?= e(url('programme/' . (int) $programme['ProgrammeID'])) ?>">
                                → <?= e(t('view_programme')) ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>