<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldTrack($request, $response)) {
            return $response;
        }

        try {
            PageView::query()->create([
                'path' => '/'.ltrim($request->path(), '/'),
                'ip' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500) ?: null,
                'referer' => substr((string) $request->headers->get('referer'), 0, 500) ?: null,
                'viewed_at' => now(),
            ]);
        } catch (\Throwable) {
            // Jangan ganggu halaman kalau tracking gagal.
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($request->ajax() || $request->expectsJson()) {
            return false;
        }

        if ($response->getStatusCode() >= 400) {
            return false;
        }

        $path = $request->path();

        if (
            $request->is('admin')
            || $request->is('admin/*')
            || $request->is('login')
            || $request->is('logout')
            || $request->is('up')
            || $request->is('storage/*')
            || $request->is('sitemap.xml')
            || $request->is('robots.txt')
        ) {
            return false;
        }

        $agent = strtolower((string) $request->userAgent());
        $bots = ['bot', 'spider', 'crawl', 'slurp', 'facebookexternalhit', 'preview'];

        foreach ($bots as $bot) {
            if (str_contains($agent, $bot)) {
                return false;
            }
        }

        // Hindari hit asset yang kebawa ke web middleware.
        if (preg_match('/\.(css|js|jpg|jpeg|png|gif|webp|svg|ico|map|woff2?|ttf)$/i', $path)) {
            return false;
        }

        return true;
    }
}
