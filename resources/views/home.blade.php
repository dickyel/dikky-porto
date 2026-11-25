<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dikky — Designer & Developer</title>
  <meta name="description" content="Portfolio of Dikky — product designer and developer crafting digital experiences." />
  <link rel="canonical" href="{{ route('home') }}" />
  <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('sitemap') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  @include('partials.analytics')
</head>
<body>
  <header class="site-header">
    <a href="{{ route('home') }}#home" class="logo" aria-label="Dikky home">
      <span class="logo-mark">D</span>
    </a>

    <nav class="nav-pill" aria-label="Primary">
      <a href="#home" class="nav-link is-active">Home</a>
      <a href="#about" class="nav-link">About</a>
      <a href="#portfolio" class="nav-link">Portfolio</a>
      <a href="#contact" class="nav-link">Contact</a>
    </nav>

    <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}" class="btn btn-outline btn-talk">
      Admin
      <span class="btn-icon" aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
        </svg>
      </span>
    </a>

    <button class="menu-toggle" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span>
    </button>
  </header>

  <main>
    <!-- HERO -->
    <section id="home" class="hero">
      <div class="hero-card">
        <div class="hero-content">
          <p class="hero-greeting reveal">{!! nl2br(e($profile->greeting)) !!}</p>
          <h1 class="hero-title reveal">{!! nl2br(e($profile->headline)) !!}</h1>
          <a href="{{ $profile->hire_url }}" class="btn btn-accent reveal">{{ $profile->hire_label }}</a>
          <p class="hero-sub reveal">{{ $profile->bio }}</p>
        </div>

        <div class="hero-visual">
          <img
            class="hero-photo"
            src="{{ media_url($profile->photo ?: 'src/foto.jpeg') }}"
            alt="Portrait of Dikky"
          />

          @if($tools->isNotEmpty())
            <aside class="exp-card reveal">
              <span class="exp-label">EXP in:</span>
              <div class="exp-icons">
                @foreach($tools as $tool)
                  <span class="exp-icon" title="{{ $tool->name }}">
                    {!! $tool->renderIcon() !!}
                  </span>
                @endforeach
              </div>
            </aside>
          @endif
        </div>

        @if($stats->isNotEmpty())
          <div class="hero-stats">
            @foreach($stats as $stat)
              <div class="stat reveal">
                <strong>{{ $stat->value }}</strong>
                <span>{{ $stat->label }}</span>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="about">
      <p class="about-status reveal">{{ $profile->availability }}</p>
      <div class="about-copy">
        <p class="reveal">
          <span class="tone-dark">{{ $profile->about_dark_1 }}</span>
          <span class="tone-mute">{{ $profile->about_mute_1 }}</span>
          <span class="tone-dark">{{ $profile->about_dark_2 }}</span>
          <span class="tone-mute">{{ $profile->about_mute_2 }}</span>
        </p>
        <a href="{{ $featured ? route('projects.show', $featured) : '#portfolio' }}" class="text-link reveal">{{ $profile->about_cta_label }} <span aria-hidden="true">↗</span></a>
      </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="services">
      <div class="services-head">
        <h2 class="section-title reveal">{!! nl2br(e($profile->services_heading)) !!}</h2>
        <div class="services-aside reveal">
          <p>{{ $profile->services_subtext }}</p>
          <a href="#contact" class="btn btn-accent">{{ $profile->services_button_label }}</a>
        </div>
      </div>

      <div class="service-list" data-accordion>
        @foreach($services as $index => $service)
          <article class="service-item {{ $index === 0 ? 'is-open' : '' }}">
            <button class="service-trigger" type="button" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
              <span class="service-name">{{ $service->title }}</span>
              <span class="service-meta">
                @if($service->thumbnail)
                  <img class="service-thumb" src="{{ media_url($service->thumbnail) }}" alt="" />
                @endif
                <span class="service-chevron" aria-hidden="true"></span>
              </span>
            </button>
            <div class="service-panel">
              <div class="service-panel-inner">
                <div class="service-info">
                  <p>{{ $service->description }}</p>
                  @if(!empty($service->stats))
                    <div class="service-stats">
                      @foreach($service->stats as $serviceStat)
                        <div>
                          <strong>{{ $serviceStat['value'] ?? '' }}</strong>
                          <span>{{ $serviceStat['label'] ?? '' }}</span>
                        </div>
                      @endforeach
                    </div>
                  @endif
                </div>
                @if($service->preview_image)
                  <div class="service-preview">
                    <img src="{{ media_url($service->preview_image) }}" alt="{{ $service->title }} preview" />
                  </div>
                @endif
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </section>

    <!-- PORTFOLIO -->
    <section id="portfolio" class="portfolio">
      <div class="portfolio-head">
        <h2 class="section-title reveal">{!! nl2br(e($profile->showcase_heading)) !!}</h2>
        @if($featured)
          <a href="{{ route('projects.show', $featured) }}" class="text-link reveal">View all work <span aria-hidden="true">↗</span></a>
        @endif
      </div>

      @if($featured)
        <a class="showcase-card reveal" href="{{ route('projects.show', $featured) }}">
          <img class="showcase-bg" src="{{ media_url($featured->cover) }}" alt="{{ $featured->title }}" />
          <div class="showcase-overlay"></div>
          <div class="showcase-content">
            <p class="showcase-tag">{{ $featured->category }}</p>
            <h3>{{ $featured->title }}</h3>
          </div>
          <span class="showcase-cta" aria-hidden="true">
            <span>View<br />Case</span>
          </span>
        </a>
      @endif

      @if($projects->isNotEmpty())
        <div class="project-grid">
          @foreach($projects as $project)
            <a class="project-card reveal" href="{{ route('projects.show', $project) }}">
              <img src="{{ media_url($project->cover) }}" alt="{{ $project->title }}" />
              <div class="project-info">
                <h3>{{ $project->title }}</h3>
                <p>{{ $project->category }}</p>
              </div>
            </a>
          @endforeach
        </div>
      @endif
    </section>

    <!-- TESTIMONIALS -->
    <section class="testimonials" aria-label="Testimonials">
      <div class="marquee" aria-hidden="true">
        <div class="marquee-track">
          <span>TESTIMONIALS</span><span>•</span>
          <span>TESTIMONIALS</span><span>•</span>
          <span>TESTIMONIALS</span><span>•</span>
          <span>TESTIMONIALS</span><span>•</span>
          <span>TESTIMONIALS</span><span>•</span>
          <span>TESTIMONIALS</span><span>•</span>
        </div>
      </div>

      <div class="testimonial-row">
        @foreach($testimonials as $testimonial)
          <article class="t-card {{ $testimonial->featured ? 'is-featured' : '' }}">
            <p>“{{ $testimonial->quote }}”</p>
            @if($testimonial->visual_image)
              <div class="t-visual">
                <img src="{{ media_url($testimonial->visual_image) }}" alt="Product still" />
              </div>
            @endif
            <div class="t-author">
              @if($testimonial->avatar)
                <img src="{{ media_url($testimonial->avatar) }}" alt="" />
              @endif
              <div>
                <strong>{{ $testimonial->author_name }}</strong>
                <span>{{ $testimonial->author_role }}</span>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" class="contact">
      <div class="contact-card reveal">
        <p class="contact-eyebrow">{{ $profile->contact_eyebrow }}</p>
        <h2>{!! nl2br(e($profile->contact_heading)) !!}</h2>
        <a href="mailto:{{ $profile->contact_email }}" class="btn btn-accent btn-lg">Start a conversation</a>
        <div class="contact-links">
          <a href="https://dribbble.com" target="_blank" rel="noopener">Dribbble</a>
          <a href="https://linkedin.com" target="_blank" rel="noopener">LinkedIn</a>
          <a href="https://instagram.com" target="_blank" rel="noopener">Instagram</a>
          <a href="https://github.com" target="_blank" rel="noopener">GitHub</a>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <p>© {{ date('Y') }} Dikky. All rights reserved.</p>
    <p>Designed with intent · Built for founders</p>
  </footer>

  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
