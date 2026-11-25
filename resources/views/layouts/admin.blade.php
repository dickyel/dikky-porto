<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dashboard — Dikky Admin')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}" />
</head>
<body class="admin-body" id="adminBody">
  <div class="admin-overlay" id="adminOverlay"></div>

  <aside class="admin-sidebar">
    <div class="admin-sidebar-head">
      <a href="{{ route('admin.dashboard') }}" class="logo" aria-label="Dashboard">
        <span class="logo-mark">D</span>
      </a>
      <div>
        <p class="admin-brand">Dikky Admin</p>
        <p class="admin-brand-sub">Kelola portfolio</p>
      </div>
    </div>

    <nav>
      <p class="nav-group">Utama</p>
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
        <span class="nav-ico">⌂</span> Dashboard
      </a>
      <a href="{{ route('admin.traffic.index') }}" class="{{ request()->routeIs('admin.traffic.*') ? 'is-active' : '' }}">
        <span class="nav-ico">◉</span> Traffic
      </a>

      <p class="nav-group">Isi Website</p>
      <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'is-active' : '' }}">
        <span class="nav-ico">✎</span> Profil & Hero
      </a>
      <a href="{{ route('admin.tools.index') }}" class="{{ request()->routeIs('admin.tools.*') ? 'is-active' : '' }}">
        <span class="nav-ico">◆</span> Tools (EXP)
      </a>
      <a href="{{ route('admin.stats.index') }}" class="{{ request()->routeIs('admin.stats.*') ? 'is-active' : '' }}">
        <span class="nav-ico">#</span> Statistik Hero
      </a>
      <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'is-active' : '' }}">
        <span class="nav-ico">☰</span> Services
      </a>
      <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials.*') ? 'is-active' : '' }}">
        <span class="nav-ico">★</span> Testimonials
      </a>

      <p class="nav-group">Portfolio</p>
      <a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.index') || request()->routeIs('admin.projects.edit') ? 'is-active' : '' }}">
        <span class="nav-ico">▣</span> Semua Project
      </a>
      <a href="{{ route('admin.projects.create') }}" class="{{ request()->routeIs('admin.projects.create') ? 'is-active' : '' }}">
        <span class="nav-ico">+</span> Tambah Project
      </a>

      <p class="nav-group">Lainnya</p>
      <a href="{{ route('home') }}" target="_blank" rel="noopener">
        <span class="nav-ico">↗</span> Lihat Website
      </a>
    </nav>

    <div class="admin-user">
      <div class="admin-user-meta">
        <span class="admin-avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        <div class="admin-user-text">
          <strong>{{ auth()->user()->name }}</strong>
          <span class="admin-user-email">{{ auth()->user()->email }}</span>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="admin-logout">Keluar</button>
      </form>
    </div>
  </aside>

  <main class="admin-main">
    <div class="admin-mobile-bar">
      <button class="btn btn-outline admin-mobile-toggle" id="sidebarToggle" type="button">☰ Menu</button>
      <a href="{{ route('home') }}" class="btn btn-accent" target="_blank" rel="noopener">Lihat site</a>
    </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    @yield('content')
  </main>

  <script>
    const body = document.getElementById('adminBody');
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('adminOverlay');

    const closeSidebar = () => body.classList.remove('sidebar-open');
    const openSidebar = () => body.classList.add('sidebar-open');

    toggle?.addEventListener('click', () => {
      body.classList.toggle('sidebar-open');
    });
    overlay?.addEventListener('click', closeSidebar);
  </script>
</body>
</html>
