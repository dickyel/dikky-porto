@php
  $gaId = config('services.google_analytics.measurement_id');
@endphp

@if (filled($gaId))
  <!-- Google Analytics (GA4) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', @js($gaId));
  </script>
@endif
