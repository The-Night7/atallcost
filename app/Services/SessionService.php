<?php

declare(strict_types=1);

namespace App\Services;

final class SessionService
{
    public function flash(string $type, string $message): void
    {
        $_SESSION['_flash'] = ['type' => $type, 'message' => $message];
    }

    public function consumeFlash(): ?array
    {
        $flash = $_SESSION['_flash'] ?? null;
        unset($_SESSION['_flash']);
        return $flash;
    }

    public function csrfToken(): string
    {
        if (!isset($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_csrf'];
    }

    public function verifyCsrfToken(string $token): bool
    {
        return hash_equals((string) ($_SESSION['_csrf'] ?? ''), $token);
    }

    public function login(array $profile, ?array $authSession = null): void
    {
        session_regenerate_id(true);
        $_SESSION['user'] = $profile;
        $_SESSION['auth_session'] = $authSession;
    }

    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public function authSession(): ?array
    {
        return $_SESSION['auth_session'] ?? null;
    }

    public function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'], $params['httponly']);
        }
        session_destroy();
    }
}
