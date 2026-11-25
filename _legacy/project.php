<?php
require_once __DIR__ . '/includes/bootstrap.php';

$slug = trim((string) ($_GET['slug'] ?? ''));
$project = $slug !== '' ? get_project_by_slug($slug) : null;

if (!$project) {
    http_response_code(404);
}

$others = array_values(array_filter(
    get_projects(),
    static fn(array $p): bool => ($p['id'] ?? null) !== ($project['id'] ?? null)
));
$others = array_slice($others, 0, 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $project ? e($project['title']) . ' — Dikky' : 'Project not found — Dikky' ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/pages.css" />
</head>
<body>
  <header class="site-header">
    <a href="index.php" class="logo" aria-label="Dikky home">
      <span class="logo-mark">D</span>
    </a>
    <nav class="nav-pill" aria-label="Primary">
      <a href="index.php#home" class="nav-link">Home</a>
      <a href="index.php#about" class="nav-link">About</a>
      <a href="index.php#portfolio" class="nav-link is-active">Portfolio</a>
      <a href="index.php#contact" class="nav-link">Contact</a>
    </nav>
    <a href="index.php#contact" class="btn btn-outline btn-talk">Let's talk</a>
    <button class="menu-toggle" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span>
    </button>
  </header>

  <main class="page-main">
    <?php if (!$project): ?>
      <section class="page-shell">
        <p class="eyebrow">404</p>
        <h1 class="page-title">Project not found</h1>
        <p class="page-lead">Project ini belum tersedia atau slug-nya salah.</p>
        <a class="btn btn-accent" href="index.php#portfolio">Back to portfolio</a>
      </section>
    <?php else: ?>
      <section class="project-hero">
        <div class="project-hero-copy">
          <a class="back-link" href="index.php#portfolio">← Back to work</a>
          <p class="eyebrow"><?= e($project['category'] ?? '') ?></p>
          <h1 class="page-title"><?= e($project['title'] ?? '') ?></h1>
          <p class="page-lead"><?= e($project['summary'] ?? '') ?></p>
          <div class="project-meta">
            <div><span>Client</span><strong><?= e($project['client'] ?? '—') ?></strong></div>
            <div><span>Year</span><strong><?= e($project['year'] ?? '—') ?></strong></div>
            <div>
              <span>Tags</span>
              <strong><?= e(implode(' · ', $project['tags'] ?? [])) ?></strong>
            </div>
          </div>
        </div>
        <div class="project-hero-media">
          <img src="<?= e($project['cover'] ?? '') ?>" alt="<?= e($project['title'] ?? '') ?>" />
        </div>
      </section>

      <section class="page-shell project-body">
        <?php foreach (preg_split('/\n\s*\n/', (string) ($project['description'] ?? '')) as $paragraph): ?>
          <?php if (trim($paragraph) !== ''): ?>
            <p><?= nl2br(e(trim($paragraph))) ?></p>
          <?php endif; ?>
        <?php endforeach; ?>
      </section>

      <?php if (!empty($project['gallery'])): ?>
      <section class="page-shell">
        <h2 class="section-title">Gallery</h2>
        <div class="project-gallery">
          <?php foreach ($project['gallery'] as $image): ?>
            <figure>
              <img src="<?= e($image) ?>" alt="<?= e($project['title'] ?? '') ?> gallery" />
            </figure>
          <?php endforeach; ?>
        </div>
      </section>
      <?php endif; ?>

      <?php if ($others): ?>
      <section class="page-shell">
        <div class="portfolio-head">
          <h2 class="section-title">More work</h2>
          <a href="index.php#portfolio" class="text-link">View all <span aria-hidden="true">↗</span></a>
        </div>
        <div class="project-grid">
          <?php foreach ($others as $item): ?>
          <a class="project-card" href="project.php?slug=<?= e(urlencode($item['slug'] ?? '')) ?>">
            <img src="<?= e($item['cover'] ?? '') ?>" alt="<?= e($item['title'] ?? '') ?>" />
            <div class="project-info">
              <h3><?= e($item['title'] ?? '') ?></h3>
              <p><?= e($item['category'] ?? '') ?></p>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </section>
      <?php endif; ?>
    <?php endif; ?>
  </main>

  <footer class="site-footer">
    <p>© <span id="year"></span> Dikky. All rights reserved.</p>
    <p><a href="admin/login.php">Admin</a></p>
  </footer>
  <script src="js/main.js"></script>
</body>
</html>
