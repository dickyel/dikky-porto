@extends('layouts.admin')

@section('title', 'Traffic — Dikky Admin')

@section('content')
  @php $maxChart = max(1, $chart->max('total')); @endphp

  <div class="admin-top">
    <div>
      <p class="eyebrow">Analitik</p>
      <h1>Traffic Website</h1>
      <p class="admin-lead">Pantau berapa orang yang membuka portfolio kamu.</p>
    </div>
    <a class="btn btn-outline" href="{{ route('home') }}" target="_blank" rel="noopener">Buka website</a>
  </div>

  <div class="traffic-summary">
    <article class="stat-card">
      <strong>{{ number_format($traffic['today']) }}</strong>
      <span>Views hari ini</span>
      <small>{{ number_format($traffic['today_unique']) }} unik</small>
    </article>
    <article class="stat-card">
      <strong>{{ number_format($traffic['week']) }}</strong>
      <span>7 hari terakhir</span>
      <small>{{ number_format($traffic['week_unique']) }} unik</small>
    </article>
    <article class="stat-card">
      <strong>{{ number_format($traffic['month']) }}</strong>
      <span>Bulan ini</span>
      <small>{{ number_format($traffic['total']) }} total</small>
    </article>
  </div>

  <div class="traffic-card">
    <h2>Views per hari</h2>
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

  <div class="traffic-split">
    <div class="traffic-card">
      <h2>Halaman paling dilihat</h2>
      @if($topPages->isEmpty())
        <p class="admin-lead">Belum ada data. Buka website dulu supaya traffic masuk.</p>
      @else
        <div class="admin-table-wrap" style="box-shadow:none;border:0">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Halaman</th>
                <th>Views</th>
              </tr>
            </thead>
            <tbody>
              @foreach($topPages as $page)
                <tr>
                  <td><code>{{ $page->path }}</code></td>
                  <td><strong>{{ number_format($page->total) }}</strong></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

    <div class="traffic-card">
      <h2>Kunjungan terbaru</h2>
      @if($recent->isEmpty())
        <p class="admin-lead">Belum ada kunjungan tercatat.</p>
      @else
        <div class="admin-table-wrap" style="box-shadow:none;border:0">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Waktu</th>
                <th>Halaman</th>
                <th>IP</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recent as $view)
                <tr>
                  <td>{{ $view->viewed_at?->format('d M H:i') }}</td>
                  <td><code>{{ $view->path }}</code></td>
                  <td>{{ $view->ip }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
@endsection
