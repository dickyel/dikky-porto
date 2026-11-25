<?php
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_login();

$projects = get_projects();
$user = current_user();
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard — Dikky Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/pages.css" />
</head>
<body class="admin-body">
  <aside class="admin-sidebar">
    <a href="../index.php" class="logo" aria-label="Home">
      <span class="logo-mark">D</span>
    </a>
    <p class="admin-brand">Dikky Admin</p>
    <nav>
      <a class="is-active" href="index.php">Projects</a>
      <a href="project-edit.php">Tambah Project</a>
      <a href="../index.php" target="_blank" rel="noopener">Lihat Website</a>
    </nav>
    <div class="admin-user">
      <strong><?= e($user['name'] ?? 'Admin') ?></strong>
      <a href="logout.php">Logout</a>
    </div>
  </aside>

  <main class="admin-main">
    <div class="admin-top">
      <div>
        <p class="eyebrow">Dashboard</p>
        <h1>Projects</h1>
      </div>
      <a class="btn btn-accent" href="project-edit.php">+ Project baru</a>
    </div>

    <?php if ($flash): ?>
      <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
    <?php endif; ?>

    <?php if (!$projects): ?>
      <div class="empty-state">
        <h2>Belum ada project</h2>
        <p>Tambahkan project pertama supaya portfolio jadi dinamis.</p>
        <a class="btn btn-accent" href="project-edit.php">Tambah project</a>
      </div>
    <?php else: ?>
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Project</th>
              <th>Category</th>
              <th>Year</th>
              <th>Featured</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($projects as $project): ?>
            <tr>
              <td>
                <div class="admin-project-cell">
                  <img src="<?= e($project['cover'] ?? '') ?>" alt="" />
                  <div>
                    <strong><?= e($project['title'] ?? '') ?></strong>
                    <span><?= e($project['slug'] ?? '') ?></span>
                  </div>
                </div>
              </td>
              <td><?= e($project['category'] ?? '') ?></td>
              <td><?= e($project['year'] ?? '') ?></td>
              <td><?= !empty($project['featured']) ? 'Yes' : '—' ?></td>
              <td class="admin-actions">
                <a href="../project.php?slug=<?= e(urlencode($project['slug'] ?? '')) ?>" target="_blank" rel="noopener">View</a>
                <a href="project-edit.php?id=<?= e(urlencode($project['id'] ?? '')) ?>">Edit</a>
                <form method="post" action="project-delete.php" onsubmit="return confirm('Hapus project ini?');">
                  <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
                  <input type="hidden" name="id" value="<?= e($project['id'] ?? '') ?>" />
                  <button type="submit">Hapus</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>
