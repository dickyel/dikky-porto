<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $project->title }} — Dikky</title>
  <meta name="description" content="{{ $project->summary }}" />
  <link rel="canonical" href="{{ route('projects.show', $project) }}" />
  <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('sitemap') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}" />
  @include('partials.analytics')
</head>
<body class="detail-page">
  <header class="page-header">
    <div class="page-header-left">
      <a href="{{ route('home') }}" class="logo" aria-label="Dikky home">
        <span class="logo-mark">D</span>
      </a>
      <a class="page-back" href="{{ route('home') }}#portfolio">← Portfolio</a>
    </div>
    <nav class="page-header-nav" aria-label="Primary">
      <a class="nav-link" href="{{ route('home') }}">Home</a>
      <a class="nav-link is-active" href="{{ route('home') }}#portfolio">Work</a>
      <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
    </nav>
    <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}" class="btn btn-outline page-header-cta">Admin</a>
  </header>

  <section class="detail-hero">
    <img src="{{ media_url($project->cover) }}" alt="{{ $project->title }}" />
    <div class="detail-hero-overlay"></div>
    <div class="detail-hero-content">
      <p class="eyebrow">{{ $project->category }}</p>
      <h1>{{ $project->title }}</h1>
      <div class="detail-meta">
        <span>Client: {{ $project->client }}</span>
        <span>Year: {{ $project->year }}</span>
      </div>
    </div>
    <button
      type="button"
      class="detail-zoom-btn"
      data-lightbox
      data-lightbox-src="{{ media_url($project->cover) }}"
      aria-label="Perbesar gambar"
    >
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
        <path d="M20 20l-3.5-3.5M11 8v6M8 11h6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
      </svg>
      Zoom
    </button>
  </section>

  <section class="detail-body">
    <div class="detail-copy">
      <h2>Overview</h2>
      <p>{{ $project->summary }}</p>
      <h2>Case study</h2>
      <p>{{ $project->description }}</p>
    </div>
    <aside class="detail-side">
      <dl>
        <div>
          <dt>Client</dt>
          <dd>{{ $project->client }}</dd>
        </div>
        <div>
          <dt>Year</dt>
          <dd>{{ $project->year }}</dd>
        </div>
        <div>
          <dt>Category</dt>
          <dd>{{ $project->category }}</dd>
        </div>
        <div>
          <dt>Tags</dt>
          <dd>
            <div class="tag-row">
              @foreach(($project->tags ?? []) as $tag)
                <span class="tag">{{ $tag }}</span>
              @endforeach
            </div>
          </dd>
        </div>
      </dl>
      <a href="{{ route('home') }}#contact" class="btn btn-accent detail-side-cta">Start a project</a>
    </aside>
  </section>

  <section class="detail-gallery" aria-label="Project gallery">
    @foreach(($project->gallery ?? [$project->cover]) as $image)
      <img
        src="{{ media_url($image) }}"
        alt="{{ $project->title }} gallery"
        data-lightbox
        data-lightbox-src="{{ media_url($image) }}"
        tabindex="0"
        role="button"
        aria-label="Perbesar gambar gallery"
      />
    @endforeach
  </section>

  @if($next)
    <section class="detail-next">
      <div>
        <p>Next project</p>
        <strong>{{ $next->title }}</strong>
      </div>
      <a class="btn btn-accent" href="{{ route('projects.show', $next) }}">View case</a>
    </section>
  @endif

  <footer class="site-footer detail-footer">
    <p>© {{ date('Y') }} Dikky. All rights reserved.</p>
    <a class="text-link" href="{{ route('home') }}#portfolio">← Back to portfolio</a>
  </footer>

  <script src="{{ asset('js/lightbox.js') }}"></script>
</body>
</html>
