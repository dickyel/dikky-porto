<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — Dikky Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}" />
</head>
<body class="auth-body">
  <main class="auth-card">
    <a href="{{ route('home') }}" class="logo" aria-label="Back home">
      <span class="logo-mark">D</span>
    </a>
    <p class="eyebrow">Admin access</p>
    <h1>Welcome back</h1>
    <p class="auth-sub">Masuk untuk mengelola project portfolio secara dinamis.</p>

    @if ($errors->any())
      <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="auth-form" autocomplete="on">
      @csrf
      <label>
        <span>Email</span>
        <input type="email" name="email" required value="{{ old('email', 'admin@dikky.dev') }}" placeholder="admin@dikky.dev" />
      </label>
      <label>
        <span>Password</span>
        <input type="password" name="password" required placeholder="••••••••" />
      </label>
      <button type="submit" class="btn btn-accent btn-lg" style="width:100%">Login</button>
    </form>

    <p class="auth-hint">Demo: <strong>admin@dikky.dev</strong> / <strong>admin123</strong></p>
    <a class="text-link" href="{{ route('home') }}">← Kembali ke website</a>
  </main>
</body>
</html>
