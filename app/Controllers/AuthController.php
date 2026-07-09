<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;
use App\DAO\UsuarioDAO;

class AuthController extends Controller {
    private UsuarioDAO $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    // ─────────────────────────────────────────────
    //  LOGIN
    // ─────────────────────────────────────────────

    public function loginForm(): void {
        if (Auth::check()) {
            $this->redirect('/');
        }
        $this->render('auth.login', [
            'title' => 'Entrar - LaundryPro',
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ]);
    }

    public function login(): void {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $lembrar = isset($_POST['lembrar']);

        if (empty($email) || empty($senha)) {
            Session::flash('error', 'Preencha o e-mail e a palavra-passe.');
            $this->redirect('/login');
            return;
        }

        $usuario = $this->usuarioDAO->findByEmail($email);

        if (!$usuario || !password_verify($senha, $usuario->getSenha())) {
            Session::flash('error', 'E-mail ou palavra-passe incorretos.');
            $this->redirect('/login');
            return;
        }

        if ($usuario->getStatus() !== 'ativo') {
            Session::flash('error', 'A sua conta está inativa. Contacte o administrador.');
            $this->redirect('/login');
            return;
        }

        Auth::login($usuario->getId(), $usuario->getNome(), $usuario->getPerfilId());

        if (!$lembrar) {
            // Remove the persistent cookie if "remember me" not checked
            setcookie('lp_remember', '', time() - 3600, '/');
        }

        if (class_exists('\App\Helpers\LoggerHelper')) {
            \App\Helpers\LoggerHelper::log('LOGIN', "Usuário '{$usuario->getNome()}' iniciou sessão.");
        }

        $this->redirect('/');
    }

    // ─────────────────────────────────────────────
    //  LOGOUT
    // ─────────────────────────────────────────────

    public function logout(): void {
        if (class_exists('\App\Helpers\LoggerHelper') && \App\Core\Auth::check()) {
            \App\Helpers\LoggerHelper::log('LOGOUT', "Usuário '" . \App\Core\Auth::nome() . "' encerrou sessão.");
        }
        Auth::logout();
        Session::flash('success', 'Sessão terminada com sucesso.');
        $this->redirect('/login');
    }

    // ─────────────────────────────────────────────
    //  RECUPERAR SENHA (simulada)
    // ─────────────────────────────────────────────

    public function recuperarForm(): void {
        $this->render('auth.recuperar', [
            'title'   => 'Recuperar Palavra-passe - LaundryPro',
            'error'   => Session::getFlash('error'),
            'success' => Session::getFlash('success'),
        ]);
    }

    public function recuperar(): void {
        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            Session::flash('error', 'Insira o seu e-mail.');
            $this->redirect('/recuperar-senha');
            return;
        }

        $usuario = $this->usuarioDAO->findByEmail($email);

        // Always show success (avoid user enumeration)
        if ($usuario && $usuario->getStatus() === 'ativo') {
            $token   = bin2hex(random_bytes(32)); // 64-char hex token
            $expira  = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $this->usuarioDAO->setRecoveryToken($usuario->getId(), $token, $expira);

            // In production you would send an email. Here we simulate with a link:
            Session::flash('success',
                "✅ Link de recuperação gerado (simulado):<br>" .
                "<a href='/alterar-senha?token=$token' style='color:#2563eb;font-weight:bold;'>" .
                "/alterar-senha?token=$token</a>"
            );
        } else {
            Session::flash('success', 'Se o e-mail existir no sistema, receberá as instruções em breve.');
        }

        $this->redirect('/recuperar-senha');
    }

    // ─────────────────────────────────────────────
    //  ALTERAR SENHA (via token ou autenticado)
    // ─────────────────────────────────────────────

    public function alterarSenhaForm(): void {
        $token = $_GET['token'] ?? null;

        // If logged in without a token – just show the change-password form
        if (!$token && Auth::check()) {
            $this->render('auth.alterar_senha', [
                'title'   => 'Alterar Palavra-passe - LaundryPro',
                'token'   => null,
                'error'   => Session::getFlash('error'),
                'success' => Session::getFlash('success'),
            ]);
            return;
        }

        // Token-based (recovery link)
        if ($token) {
            $usuario = $this->usuarioDAO->findByToken($token);
            if (!$usuario) {
                Session::flash('error', 'Link inválido ou expirado. Solicite um novo.');
                $this->redirect('/recuperar-senha');
                return;
            }
            $this->render('auth.alterar_senha', [
                'title'   => 'Definir Nova Palavra-passe - LaundryPro',
                'token'   => $token,
                'error'   => Session::getFlash('error'),
                'success' => Session::getFlash('success'),
            ]);
            return;
        }

        $this->redirect('/login');
    }

    public function alterarSenha(): void {
        $token       = $_POST['token'] ?? null;
        $senhaAtual  = $_POST['senha_atual'] ?? null;
        $novaSenha   = $_POST['nova_senha'] ?? '';
        $confirmar   = $_POST['confirmar_senha'] ?? '';

        if (strlen($novaSenha) < 6) {
            Session::flash('error', 'A nova palavra-passe deve ter pelo menos 6 caracteres.');
            $redirect = $token ? "/alterar-senha?token=$token" : '/alterar-senha';
            $this->redirect($redirect);
            return;
        }

        if ($novaSenha !== $confirmar) {
            Session::flash('error', 'As palavras-passe não coincidem.');
            $redirect = $token ? "/alterar-senha?token=$token" : '/alterar-senha';
            $this->redirect($redirect);
            return;
        }

        // Via recovery token
        if ($token) {
            $usuario = $this->usuarioDAO->findByToken($token);
            if (!$usuario) {
                Session::flash('error', 'Link inválido ou expirado.');
                $this->redirect('/recuperar-senha');
                return;
            }
            $hash = password_hash($novaSenha, PASSWORD_BCRYPT);
            $this->usuarioDAO->updateSenha($usuario->getId(), $hash);
            $this->usuarioDAO->clearRecoveryToken($usuario->getId());
            Session::flash('success', 'Palavra-passe alterada com sucesso! Faça login.');
            $this->redirect('/login');
            return;
        }

        // Via authenticated session
        if (Auth::check()) {
            $usuario = $this->usuarioDAO->find(Auth::id());
            if (!$usuario || !password_verify($senhaAtual, $usuario->getSenha())) {
                Session::flash('error', 'A palavra-passe atual está incorreta.');
                $this->redirect('/alterar-senha');
                return;
            }
            $hash = password_hash($novaSenha, PASSWORD_BCRYPT);
            $this->usuarioDAO->updateSenha($usuario->getId(), $hash);
            Session::flash('success', 'Palavra-passe alterada com sucesso!');
            $this->redirect('/alterar-senha');
            return;
        }

        $this->redirect('/login');
    }
}
