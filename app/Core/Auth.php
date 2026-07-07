<?php

namespace App\Core;

use App\DAO\UsuarioDAO;

class Auth {
    /**
     * Check if a user is logged in.
     */
    public static function check(): bool {
        Session::start();

        if (Session::has('auth_user_id')) {
            return true;
        }

        $cookie = $_COOKIE['lp_remember'] ?? null;
        if (!$cookie) {
            return false;
        }

        $parts = explode('|', base64_decode($cookie, true) ?: '', 2);
        if (count($parts) !== 2) {
            return false;
        }

        [$userId, $hash] = $parts;
        $userId = (int) $userId;
        if ($userId <= 0) {
            return false;
        }

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->find($userId);
        if (!$usuario) {
            return false;
        }

        $expectedHash = hash('sha256', $usuario->getNome() . $usuario->getId());
        if (!hash_equals($expectedHash, $hash)) {
            return false;
        }

        self::login($usuario->getId(), $usuario->getNome(), $usuario->getPerfilId());
        return true;
    }

    /**
     * Log a user in by storing their identity in the session.
     */
    public static function login(int $userId, string $nome, int $perfilId): void {
        Session::start();
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);
        Session::set('auth_user_id', $userId);
        Session::set('auth_user_nome', $nome);
        Session::set('auth_user_perfil_id', $perfilId);
        // Remember-me cookie: 30 days
        setcookie('lp_remember', base64_encode($userId . '|' . hash('sha256', $nome . $userId)), [
            'expires'  => time() + (30 * 24 * 3600),
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    /**
     * Log the current user out.
     */
    public static function logout(): void {
        Session::destroy();
        setcookie('lp_remember', '', time() - 3600, '/');
    }

    /**
     * Get the logged-in user's ID.
     */
    public static function id(): ?int {
        return Session::get('auth_user_id');
    }

    /**
     * Get the logged-in user's name.
     */
    public static function nome(): ?string {
        return Session::get('auth_user_nome');
    }

    /**
     * Get the logged-in user's profile ID.
     */
    public static function perfilId(): ?int {
        return Session::get('auth_user_perfil_id');
    }

    /**
     * Require the user to be logged in, redirect to login otherwise.
     */
    public static function requireAuth(): void {
        if (!self::check()) {
            Session::flash('error', 'Faça login para continuar.');
            header('Location: /login');
            exit;
        }
    }
}
