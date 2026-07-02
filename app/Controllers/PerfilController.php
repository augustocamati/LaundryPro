<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Perfil;
use App\DAO\PerfilDAO;

class PerfilController extends Controller {
    private PerfilDAO $perfilDAO;

    public function __construct() {
        $this->perfilDAO = new PerfilDAO();
    }

    public function index(): void {
        $perfis = $this->perfilDAO->all();
        $this->render('perfis.index', [
            'title' => 'Lista de Perfis - LaundryPro',
            'activePage' => 'perfis',
            'perfis' => $perfis
        ]);
    }

    public function create(): void {
        $this->render('perfis.create', [
            'title' => 'Novo Perfil - LaundryPro',
            'activePage' => 'perfis'
        ]);
    }

    public function store(): void {
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';

        if (empty($nome)) {
            throw new \Exception("O nome do perfil é obrigatório.");
        }

        $perfil = new Perfil([
            'nome' => $nome,
            'descricao' => $descricao
        ]);

        $this->perfilDAO->create($perfil);
        $this->redirect('/perfis');
    }

    public function edit(string $id): void {
        $perfil = $this->perfilDAO->find((int)$id);
        if (!$perfil) {
            throw new \Exception("Perfil não encontrado.");
        }

        $this->render('perfis.edit', [
            'title' => 'Editar Perfil - LaundryPro',
            'activePage' => 'perfis',
            'perfil' => $perfil
        ]);
    }

    public function update(string $id): void {
        $perfil = $this->perfilDAO->find((int)$id);
        if (!$perfil) {
            throw new \Exception("Perfil não encontrado.");
        }

        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';

        if (empty($nome)) {
            throw new \Exception("O nome do perfil é obrigatório.");
        }

        $perfil->setNome($nome);
        $perfil->setDescricao($descricao);

        $this->perfilDAO->update($perfil);
        $this->redirect('/perfis');
    }

    public function delete(string $id): void {
        $this->perfilDAO->delete((int)$id);
        $this->redirect('/perfis');
    }
}
