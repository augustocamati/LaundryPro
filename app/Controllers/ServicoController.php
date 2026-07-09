<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\DAO\CategoriaDAO;
use App\DAO\ServicoDAO;
use App\Models\Categoria;
use App\Models\Servico;

class ServicoController extends Controller {
    private ServicoDAO $servicoDAO;
    private CategoriaDAO $categoriaDAO;

    public function __construct() {
        Auth::requireAuth();
        if (!Auth::isAdmin()) {
            \App\Core\Session::flash('error', 'Acesso negado. Apenas administradores.');
            header('Location: /');
            exit;
        }
        $this->servicoDAO = new ServicoDAO();
        $this->categoriaDAO = new CategoriaDAO();
    }

    public function index(): void {
        $q = trim($_GET['q'] ?? '');
        $servicos = $this->servicoDAO->all();
        $categorias = $this->categoriaDAO->all();
        $categoriasById = [];
        foreach ($categorias as $categoria) {
            $categoriasById[(int) $categoria->getId()] = $categoria;
        }

        if ($q !== '') {
            $qLower = strtolower($q);
            $servicos = array_values(array_filter($servicos, function ($servico) use ($qLower, $categoriasById): bool {
                $categoriaNome = isset($categoriasById[(int) $servico->getCategoriaId()])
                    ? strtolower($categoriasById[(int) $servico->getCategoriaId()]->getNome())
                    : '';
                return stripos(strtolower($servico->getNome()), $qLower) !== false
                    || stripos(strtolower($servico->getDescricao() ?? ''), $qLower) !== false
                    || stripos($categoriaNome, $qLower) !== false;
            }));
        }

        $this->render('servicos.index', [
            'title' => 'Serviços - LaundryPro',
            'activePage' => 'servicos',
            'servicos' => $servicos,
            'categorias' => $categorias,
            'categoriasById' => $categoriasById,
            'q' => $q,
        ]);
    }

    public function create(): void {
        $this->render('servicos.create', [
            'title' => 'Novo Serviço - LaundryPro',
            'activePage' => 'servicos',
            'categorias' => $this->categoriaDAO->all(),
        ]);
    }

    public function store(): void {
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $categoriaId = (int) ($_POST['categoria_id'] ?? 0);
        $preco = (float) ($_POST['preco'] ?? 0);
        $prazoDias = max(1, (int) ($_POST['prazo_dias'] ?? 1));

        if ($nome === '' || $categoriaId <= 0 || $preco < 0) {
            throw new \Exception('Nome, categoria, preço e prazo são obrigatórios.');
        }

        $servico = new Servico([
            'categoria_id' => $categoriaId,
            'nome' => $nome,
            'descricao' => $descricao === '' ? null : $descricao,
            'preco' => $preco,
            'prazo_dias' => $prazoDias,
        ]);

        $this->servicoDAO->create($servico);
        $this->redirect('/servicos');
    }

    public function edit(string $id): void {
        $servico = $this->servicoDAO->find((int) $id);
        if (!$servico) {
            throw new \Exception('Serviço não encontrado.');
        }

        $this->render('servicos.edit', [
            'title' => 'Editar Serviço - LaundryPro',
            'activePage' => 'servicos',
            'servico' => $servico,
            'categorias' => $this->categoriaDAO->all(),
        ]);
    }

    public function update(string $id): void {
        $servico = $this->servicoDAO->find((int) $id);
        if (!$servico) {
            throw new \Exception('Serviço não encontrado.');
        }

        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $categoriaId = (int) ($_POST['categoria_id'] ?? 0);
        $preco = (float) ($_POST['preco'] ?? 0);
        $prazoDias = max(1, (int) ($_POST['prazo_dias'] ?? 1));

        if ($nome === '' || $categoriaId <= 0 || $preco < 0) {
            throw new \Exception('Nome, categoria, preço e prazo são obrigatórios.');
        }

        $servico->setCategoriaId($categoriaId);
        $servico->setNome($nome);
        $servico->setDescricao($descricao === '' ? null : $descricao);
        $servico->setPreco($preco);
        $servico->setPrazoDias($prazoDias);

        $this->servicoDAO->update($servico);
        $this->redirect('/servicos');
    }

    public function delete(string $id): void {
        $this->servicoDAO->delete((int) $id);
        $this->redirect('/servicos');
    }
}
