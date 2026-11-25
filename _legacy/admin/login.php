<?php
require_once dirname(__DIR__) . '/includes/bootstrap.php';

if (is_logged_in()) {
    redirect(base_url('admin/index.php'));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $error = 'Session tidak valid. Coba lagi.';
    } else {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $error = 'Username dan password wajib diisi.';
        } elseif (attempt_login($username, $password)) {
            flash('success', 'Login berhasil. Selamat datang kembali.');
            redirect(base_url('admin/index.php'));
        } else {
            $error = 'Username atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — Dikky Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/pages.css" />
</head>
<body class="auth-body">
  <main class="auth-card">
    <a href="../index.php" class="logo" aria-label="Back home">
      <span class="logo-mark">D</span>
    </a>
    <p class="eyebrow">Admin access</p>
    <h1>Welcome back</h1>
    <p class="auth-sub">Masuk untuk mengelola project portfolio secara dinamis.</p>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" class="auth-form" autocomplete="on">
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>" />
      <label>
        <span>Username</span>
        <input type="text" name="username" required value="<?= e($_POST['username'] ?? '') ?>" placeholder="admin" />
      </label>
      <label>
        <span>Password</span>
        <input type="password" name="password" required placeholder="••••••••" />
      </label>
      <button type="submit" class="btn btn-accent btn-lg" style="width:100%">Login</button>
    </form>

    <p class="auth-hint">Default: <strong>admin</strong> / <strong>admin123</strong></p>
    <a class="text-link" href="../index.php">← Kembali ke website</a>
  </main>
</body>
</html>
