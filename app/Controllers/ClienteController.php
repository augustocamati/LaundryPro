<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Cliente;
use App\DAO\ClienteDAO;

class ClienteController extends Controller {
    private ClienteDAO $clienteDAO;

    public function __construct() {
        $this->clienteDAO = new ClienteDAO();
    }

    public function index(): void {
        $clientes = $this->clienteDAO->all();
        $this->render('clientes.index', [
            'title' => 'Lista de Clientes - LaundryPro',
            'activePage' => 'clientes',
            'clientes' => $clientes
        ]);
    }

    public function create(): void {
        $this->render('clientes.create', [
            'title' => 'Novo Cliente - LaundryPro',
            'activePage' => 'clientes'
        ]);
    }

    public function store(): void {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? null;
        $telefone = $_POST['telefone'] ?? '';
        $bi = $_POST['bi'] ?? null;
        $endereco = $_POST['endereco'] ?? null;

        if (empty($nome) || empty($telefone)) {
            throw new \Exception("Nome e telefone são campos obrigatórios.");
        }

        $cliente = new Cliente([
            'nome' => $nome,
            'email' => empty($email) ? null : $email,
            'telefone' => $telefone,
            'bi' => empty($bi) ? null : $bi,
            'endereco' => empty($endereco) ? null : $endereco
        ]);

        $this->clienteDAO->create($cliente);
        $this->redirect('/clientes');
    }

    public function edit(string $id): void {
        $cliente = $this->clienteDAO->find((int)$id);
        if (!$cliente) {
            throw new \Exception("Cliente não encontrado.");
        }

        $this->render('clientes.edit', [
            'title' => 'Editar Cliente - LaundryPro',
            'activePage' => 'clientes',
            'cliente' => $cliente
        ]);
    }

    public function update(string $id): void {
        $cliente = $this->clienteDAO->find((int)$id);
        if (!$cliente) {
            throw new \Exception("Cliente não encontrado.");
        }

        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? null;
        $telefone = $_POST['telefone'] ?? '';
        $bi = $_POST['bi'] ?? null;
        $endereco = $_POST['endereco'] ?? null;

        if (empty($nome) || empty($telefone)) {
            throw new \Exception("Nome e telefone são campos obrigatórios.");
        }

        $cliente->setNome($nome);
        $cliente->setEmail(empty($email) ? null : $email);
        $cliente->setTelefone($telefone);
        $cliente->setBi(empty($bi) ? null : $bi);
        $cliente->setEndereco(empty($endereco) ? null : $endereco);

        $this->clienteDAO->update($cliente);
        $this->redirect('/clientes');
    }

    public function delete(string $id): void {
        $this->clienteDAO->delete((int)$id);
        $this->redirect('/clientes');
    }
}
