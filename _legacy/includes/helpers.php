<?php

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text) ?? '';
    return trim($text, '-') ?: 'project';
}

function read_json(string $file, mixed $default = []): mixed
{
    if (!is_file($file)) {
        return $default;
    }

    $raw = file_get_contents($file);
    if ($raw === false || $raw === '') {
        return $default;
    }

    $data = json_decode($raw, true);
    return json_last_error() === JSON_ERROR_NONE ? $data : $default;
}

function write_json(string $file, mixed $data): bool
{
    $dir = dirname($file);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    return file_put_contents($file, $json . PHP_EOL, LOCK_EX) !== false;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(?string $token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

function base_url(string $path = ''): string
{
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir = str_replace('\\', '/', dirname($script));

    // Normalize when called from /admin/*
    if (str_ends_with($dir, '/admin')) {
        $dir = dirname($dir);
    }

    if ($dir === '/' || $dir === '\\' || $dir === '.') {
        $dir = '';
    }

    return rtrim($dir, '/') . '/' . ltrim($path, '/');
}
