<?php

namespace App\Core;

class Session {
    /**
     * Start a session if not already started.
     */
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_name('LAUNDRYPRO_SESS');
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'secure'   => false, // set true in HTTPS production
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy(): void {
        self::start();
        session_unset();
        session_destroy();
        // Expire the session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
    }

    /** Flash messages: set on next request, then cleared. */
    public static function flash(string $key, string $message): void {
        self::start();
        $_SESSION['_flash'][$key] = $message;
    }

    public static function getFlash(string $key): ?string {
        self::start();
        $msg = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $msg;
    }
}
