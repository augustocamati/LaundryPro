<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Usuario;
use App\DAO\UsuarioDAO;
use App\DAO\PerfilDAO;

class UsuarioController extends Controller {
    private UsuarioDAO $usuarioDAO;
    private PerfilDAO $perfilDAO;

    public function __construct() {
        Auth::requireAuth();
        if (!Auth::isAdmin()) {
            \App\Core\Session::flash('error', 'Acesso negado. Apenas administradores.');
            header('Location: /');
            exit;
        }
        $this->usuarioDAO = new UsuarioDAO();
        $this->perfilDAO = new PerfilDAO();
    }

    public function index(): void {
        $q = trim($_GET['q'] ?? '');
        $usuarios = $this->usuarioDAO->all();

        if ($q !== '') {
            $qLower = strtolower($q);
            $usuarios = array_values(array_filter($usuarios, function ($usuario) use ($qLower): bool {
                $perfil = $this->perfilDAO->find($usuario->getPerfilId());
                $perfilNome = $perfil ? strtolower($perfil->getNome()) : '';
                return stripos(strtolower($usuario->getNome()), $qLower) !== false
                    || stripos(strtolower($usuario->getEmail()), $qLower) !== false
                    || stripos(strtolower($usuario->getTelefone() ?? ''), $qLower) !== false
                    || stripos($perfilNome, $qLower) !== false;
            }));
        }

        $this->render('usuarios.index', [
            'title' => 'Lista de Usuários - LaundryPro',
            'activePage' => 'usuarios',
            'usuarios' => $usuarios,
            'perfilDAO' => $this->perfilDAO,
            'q' => $q,
        ]);
    }

    public function create(): void {
        $perfis = $this->perfilDAO->all();
        $this->render('usuarios.create', [
            'title' => 'Novo Usuário - LaundryPro',
            'activePage' => 'usuarios',
            'perfis' => $perfis
        ]);
    }

    public function store(): void {
        $perfilId = (int)($_POST['perfil_id'] ?? 0);
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $telefone = $_POST['telefone'] ?? null;
        $status = $_POST['status'] ?? 'ativo';

        if (empty($nome) || empty($email) || empty($senha) || $perfilId === 0) {
            throw new \Exception("Preencha todos os campos obrigatórios.");
        }

        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

        $usuario = new Usuario([
            'perfil_id' => $perfilId,
            'nome' => $nome,
            'email' => $email,
            'senha' => $senhaHash,
            'telefone' => $telefone,
            'status' => $status
        ]);

        $this->usuarioDAO->create($usuario);
        $this->redirect('/usuarios');
    }

    public function edit(string $id): void {
        $usuario = $this->usuarioDAO->find((int)$id);
        if (!$usuario) {
            throw new \Exception("Usuário não encontrado.");
        }

        $perfis = $this->perfilDAO->all();
        $this->render('usuarios.edit', [
            'title' => 'Editar Usuário - LaundryPro',
            'activePage' => 'usuarios',
            'usuario' => $usuario,
            'perfis' => $perfis
        ]);
    }

    public function update(string $id): void {
        $usuario = $this->usuarioDAO->find((int)$id);
        if (!$usuario) {
            throw new \Exception("Usuário não encontrado.");
        }

        $perfilId = (int)($_POST['perfil_id'] ?? 0);
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $telefone = $_POST['telefone'] ?? null;
        $status = $_POST['status'] ?? 'ativo';

        if (empty($nome) || empty($email) || $perfilId === 0) {
            throw new \Exception("Preencha todos os campos obrigatórios.");
        }

        $usuario->setPerfilId($perfilId);
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setTelefone($telefone);
        $usuario->setStatus($status);

        if (!empty($senha)) {
            $usuario->setSenha(password_hash($senha, PASSWORD_BCRYPT));
        }

        $this->usuarioDAO->update($usuario);
        $this->redirect('/usuarios');
    }

    public function delete(string $id): void {
        $this->usuarioDAO->delete((int)$id);
        $this->redirect('/usuarios');
    }
}
