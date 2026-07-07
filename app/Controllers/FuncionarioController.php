<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Funcionario;
use App\DAO\FuncionarioDAO;
use App\DAO\UsuarioDAO;

class FuncionarioController extends Controller {
    private FuncionarioDAO $funcionarioDAO;
    private UsuarioDAO $usuarioDAO;

    public function __construct() {
        Auth::requireAuth();
        $this->funcionarioDAO = new FuncionarioDAO();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function index(): void {
        $q = trim($_GET['q'] ?? '');
        $funcionarios = $this->funcionarioDAO->all();

        if ($q !== '') {
            $qLower = mb_strtolower($q);
            $funcionarios = array_values(array_filter($funcionarios, function ($funcionario) use ($qLower): bool {
                $usuario = $this->usuarioDAO->find($funcionario->getUsuarioId());
                $nome = $usuario ? mb_strtolower($usuario->getNome()) : '';
                return stripos($nome, $qLower) !== false
                    || stripos(mb_strtolower($funcionario->getCargo()), $qLower) !== false;
            }));
        }

        $this->render('funcionarios.index', [
            'title' => 'Lista de Funcionários - LaundryPro',
            'activePage' => 'funcionarios',
            'funcionarios' => $funcionarios,
            'usuarioDAO' => $this->usuarioDAO,
            'q' => $q,
        ]);
    }

    public function create(): void {
        $usuarios = $this->usuarioDAO->all();
        
        // Filter out users who are already employees
        $funcionarios = $this->funcionarioDAO->all();
        $existingUserIds = array_map(fn($f) => $f->getUsuarioId(), $funcionarios);
        
        $availableUsuarios = array_filter($usuarios, fn($u) => !in_array($u->getId(), $existingUserIds));

        $this->render('funcionarios.create', [
            'title' => 'Novo Funcionário - LaundryPro',
            'activePage' => 'funcionarios',
            'usuarios' => $availableUsuarios
        ]);
    }

    public function store(): void {
        $usuarioId = (int)($_POST['usuario_id'] ?? 0);
        $cargo = $_POST['cargo'] ?? '';
        $salario = (float)($_POST['salario'] ?? 0.0);
        $dataAdmissao = $_POST['data_admissao'] ?? '';

        if ($usuarioId === 0 || empty($cargo) || $salario <= 0 || empty($dataAdmissao)) {
            throw new \Exception("Preencha todos os campos obrigatórios.");
        }

        $funcionario = new Funcionario([
            'usuario_id' => $usuarioId,
            'cargo' => $cargo,
            'salario' => $salario,
            'data_admissao' => $dataAdmissao
        ]);

        $this->funcionarioDAO->create($funcionario);
        $this->redirect('/funcionarios');
    }

    public function edit(string $id): void {
        $funcionario = $this->funcionarioDAO->find((int)$id);
        if (!$funcionario) {
            throw new \Exception("Funcionário não encontrado.");
        }

        $usuarios = $this->usuarioDAO->all();

        $this->render('funcionarios.edit', [
            'title' => 'Editar Funcionário - LaundryPro',
            'activePage' => 'funcionarios',
            'funcionario' => $funcionario,
            'usuarios' => $usuarios
        ]);
    }

    public function update(string $id): void {
        $funcionario = $this->funcionarioDAO->find((int)$id);
        if (!$funcionario) {
            throw new \Exception("Funcionário não encontrado.");
        }

        $usuarioId = (int)($_POST['usuario_id'] ?? 0);
        $cargo = $_POST['cargo'] ?? '';
        $salario = (float)($_POST['salario'] ?? 0.0);
        $dataAdmissao = $_POST['data_admissao'] ?? '';

        if ($usuarioId === 0 || empty($cargo) || $salario <= 0 || empty($dataAdmissao)) {
            throw new \Exception("Preencha todos os campos obrigatórios.");
        }

        $funcionario->setUsuarioId($usuarioId);
        $funcionario->setCargo($cargo);
        $funcionario->setSalario($salario);
        $funcionario->setDataAdmissao($dataAdmissao);

        $this->funcionarioDAO->update($funcionario);
        $this->redirect('/funcionarios');
    }

    public function delete(string $id): void {
        $this->funcionarioDAO->delete((int)$id);
        $this->redirect('/funcionarios');
    }
}
