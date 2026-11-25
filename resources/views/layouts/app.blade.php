<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dikky — Designer & Developer')</title>
  <meta name="description" content="@yield('description', 'Portfolio of Dikky — product designer and developer crafting digital experiences.')" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  @stack('styles')
</head>
<body class="@yield('body_class')">
  @yield('content')
  @stack('scripts')
</body>
</html>
