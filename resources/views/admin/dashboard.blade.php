@extends('layouts.admin')

@section('title', 'Dashboard — Dikky Admin')

@section('content')
  <div class="admin-top">
    <div>
      <p class="eyebrow">Selamat datang</p>
      <h1>Halo, {{ explode(' ', auth()->user()->name)[0] }} 👋</h1>
      <p class="admin-lead">Kelola isi portfolio dari satu tempat. Pilih bagian yang mau diubah.</p>
    </div>
    <div class="admin-top-actions">
      <a class="btn btn-outline" href="{{ route('admin.traffic.index') }}">Detail traffic</a>
      <a class="btn btn-outline" href="{{ route('home') }}" target="_blank" rel="noopener">Lihat website</a>
      <a class="btn btn-accent" href="{{ route('admin.projects.create') }}">+ Project baru</a>
    </div>
  </div>

  @php $maxChart = max(1, $chart->max('total')); @endphp

  <div class="traffic-summary">
    <article class="stat-card">
      <strong>{{ number_format($traffic['today']) }}</strong>
      <span>Views hari ini</span>
      <small>{{ number_format($traffic['today_unique']) }} pengunjung unik</small>
    </article>
    <article class="stat-card">
      <strong>{{ number_format($traffic['week']) }}</strong>
      <span>7 hari terakhir</span>
      <small>{{ number_format($traffic['week_unique']) }} pengunjung unik</small>
    </article>
    <article class="stat-card">
      <strong>{{ number_format($traffic['month']) }}</strong>
      <span>Bulan ini</span>
      <small>{{ number_format($traffic['total']) }} total sepanjang waktu</small>
    </article>
  </div>

  <div class="traffic-card" style="margin-bottom:1.5rem">
    <div class="admin-section-head" style="margin-bottom:.85rem">
      <h2>Views 7 hari terakhir</h2>
      <a class="text-link" href="{{ route('admin.traffic.index') }}">Selengkapnya</a>
    </div>
    <div class="traffic-bars">
      @foreach($chart as $day)
        <div class="traffic-bar-item">
          <div class="traffic-bar-track">
            <div class="traffic-bar-fill" style="height: {{ round(($day['total'] / $maxChart) * 100) }}%"></div>
          </div>
          <strong>{{ $day['total'] }}</strong>
          <span>{{ $day['label'] }}</span>
        </div>
      @endforeach
    </div>
  </div>

  <div class="quick-grid">
    <a class="quick-card" href="{{ route('admin.profile.edit') }}">
      <span class="quick-icon">✎</span>
      <strong>Profil & Hero</strong>
      <p>Nama, bio, foto, teks about, dan contact</p>
      <span class="quick-go">Atur →</span>
    </a>

    <a class="quick-card" href="{{ route('admin.tools.index') }}">
      <span class="quick-icon">◆</span>
      <strong>Tools (EXP)</strong>
      <p>{{ $counts['tools'] }} tools aktif di badge hero</p>
      <span class="quick-go">Atur →</span>
    </a>

    <a class="quick-card" href="{{ route('admin.stats.index') }}">
      <span class="quick-icon">#</span>
      <strong>Statistik Hero</strong>
      <p>{{ $counts['stats'] }} angka di bawah foto</p>
      <span class="quick-go">Atur →</span>
    </a>

    <a class="quick-card" href="{{ route('admin.services.index') }}">
      <span class="quick-icon">☰</span>
      <strong>Services</strong>
      <p>{{ $counts['services'] }} layanan di accordion</p>
      <span class="quick-go">Atur →</span>
    </a>

    <a class="quick-card" href="{{ route('admin.testimonials.index') }}">
      <span class="quick-icon">★</span>
      <strong>Testimonials</strong>
      <p>{{ $counts['testimonials'] }} testimoni klien</p>
      <span class="quick-go">Atur →</span>
    </a>

    <a class="quick-card" href="{{ route('admin.projects.index') }}">
      <span class="quick-icon">▣</span>
      <strong>Projects</strong>
      <p>{{ $counts['projects'] }} project · {{ $counts['featured'] }} featured</p>
      <span class="quick-go">Kelola →</span>
    </a>
  </div>

  <div class="admin-section-head">
    <h2>Project terbaru</h2>
    <a class="text-link" href="{{ route('admin.projects.index') }}">Lihat semua</a>
  </div>

  @if ($recentProjects->isEmpty())
    <div class="empty-state">
      <h2>Belum ada project</h2>
      <p>Tambahkan project pertama supaya showcase di homepage terisi.</p>
      <a class="btn btn-accent" href="{{ route('admin.projects.create') }}">Tambah project</a>
    </div>
  @else
    <div class="recent-grid">
      @foreach ($recentProjects as $project)
        <article class="recent-card">
          <img src="{{ media_url($project->cover) }}" alt="{{ $project->title }}" />
          <div class="recent-card-body">
            <p class="recent-cat">{{ $project->category }}</p>
            <h3>{{ $project->title }}</h3>
            <div class="recent-actions">
              <a href="{{ route('projects.show', $project) }}" target="_blank" rel="noopener">Lihat</a>
              <a href="{{ route('admin.projects.edit', $project) }}">Edit</a>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  @endif
@endsection
