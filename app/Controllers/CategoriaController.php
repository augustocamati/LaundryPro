<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\DAO\CategoriaDAO;
use App\Models\Categoria;

class CategoriaController extends Controller {
    private CategoriaDAO $categoriaDAO;

    public function __construct() {
        Auth::requireAuth();
        $this->categoriaDAO = new CategoriaDAO();
    }

    public function index(): void {
        $q = trim($_GET['q'] ?? '');
        $categorias = $this->categoriaDAO->all();

        if ($q !== '') {
            $qLower = mb_strtolower($q);
            $categorias = array_values(array_filter($categorias, function ($categoria) use ($qLower): bool {
                return stripos(mb_strtolower($categoria->getNome()), $qLower) !== false
                    || stripos(mb_strtolower($categoria->getDescricao() ?? ''), $qLower) !== false;
            }));
        }

        $this->render('categorias.index', [
            'title' => 'Categorias - LaundryPro',
            'activePage' => 'categorias',
            'categorias' => $categorias,
            'q' => $q,
        ]);
    }

    public function create(): void {
        $this->render('categorias.create', [
            'title' => 'Nova Categoria - LaundryPro',
            'activePage' => 'categorias',
        ]);
    }

    public function store(): void {
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');

        if ($nome === '') {
            throw new \Exception('O nome da categoria é obrigatório.');
        }

        $categoria = new Categoria([
            'nome' => $nome,
            'descricao' => $descricao === '' ? null : $descricao,
        ]);

        $this->categoriaDAO->create($categoria);
        $this->redirect('/categorias');
    }

    public function edit(string $id): void {
        $categoria = $this->categoriaDAO->find((int) $id);
        if (!$categoria) {
            throw new \Exception('Categoria não encontrada.');
        }

        $this->render('categorias.edit', [
            'title' => 'Editar Categoria - LaundryPro',
            'activePage' => 'categorias',
            'categoria' => $categoria,
        ]);
    }

    public function update(string $id): void {
        $categoria = $this->categoriaDAO->find((int) $id);
        if (!$categoria) {
            throw new \Exception('Categoria não encontrada.');
        }

        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');

        if ($nome === '') {
            throw new \Exception('O nome da categoria é obrigatório.');
        }

        $categoria->setNome($nome);
        $categoria->setDescricao($descricao === '' ? null : $descricao);
        $this->categoriaDAO->update($categoria);
        $this->redirect('/categorias');
    }

    public function delete(string $id): void {
        $this->categoriaDAO->delete((int) $id);
        $this->redirect('/categorias');
    }
}
