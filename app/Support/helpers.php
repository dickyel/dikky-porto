<?php

if (! function_exists('media_url')) {
    function media_url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (
            str_starts_with($path, 'uploads/')
            || str_starts_with($path, 'projects/')
            || str_starts_with($path, 'profiles/')
            || str_starts_with($path, 'services/')
            || str_starts_with($path, 'testimonials/')
        ) {
            return asset('storage/'.$path);
        }

        return asset($path);
    }
}
