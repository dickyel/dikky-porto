<?php

declare(strict_types=1);

function users_file(): string
{
    return DATA_PATH . '/users.json';
}

function get_users(): array
{
    $users = read_json(users_file(), []);
    return is_array($users) ? $users : [];
}

function attempt_login(string $username, string $password): bool
{
    foreach (get_users() as $user) {
        if (($user['username'] ?? '') !== $username) {
            continue;
        }

        if (!password_verify($password, (string) ($user['password'] ?? ''))) {
            return false;
        }

        $_SESSION['user'] = [
            'username' => $user['username'],
            'name' => $user['name'] ?? $user['username'],
        ];
        return true;
    }

    return false;
}

function logout_user(): void
{
    unset($_SESSION['user']);
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function require_login(): void
{
    if (!is_logged_in()) {
        flash('error', 'Silakan login dulu untuk membuka dashboard.');
        redirect(base_url('admin/login.php'));
    }
}
