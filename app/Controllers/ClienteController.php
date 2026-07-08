<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Cliente;
use App\DAO\ClienteDAO;

class ClienteController extends Controller {
    private ClienteDAO $clienteDAO;

    public function __construct() {
        Auth::requireAuth();
        $this->clienteDAO = new ClienteDAO();
    }

    public function index(): void {
        $q = trim($_GET['q'] ?? '');
        $clientes = $this->clienteDAO->all();

        if ($q !== '') {
            $qLower = strtolower($q);
            $clientes = array_values(array_filter($clientes, function ($cliente) use ($qLower): bool {
                return stripos(strtolower($cliente->getNome()), $qLower) !== false
                    || stripos(strtolower($cliente->getEmail() ?? ''), $qLower) !== false
                    || stripos(strtolower($cliente->getTelefone() ?? ''), $qLower) !== false
                    || stripos(strtolower($cliente->getBi() ?? ''), $qLower) !== false;
            }));
        }

        $this->render('clientes.index', [
            'title' => 'Lista de Clientes - LaundryPro',
            'activePage' => 'clientes',
            'clientes' => $clientes,
            'q' => $q,
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
        $documentPath = null;

        if (empty($nome) || empty($telefone)) {
            throw new \Exception("Nome e telefone são campos obrigatórios.");
        }

        $cliente = new Cliente([
            'nome' => $nome,
            'email' => empty($email) ? null : $email,
            'telefone' => $telefone,
            'bi' => empty($bi) ? null : $bi,
            'endereco' => empty($endereco) ? null : $endereco,
            'document_path' => null
        ]);

        // Handle file upload (optional)
        if (!empty($_FILES['documento']['name'])) {
            $uploaded = $_FILES['documento'];
            if (is_uploaded_file($uploaded['tmp_name'])) {
                $maxSize = 5 * 1024 * 1024; // 5MB
                if ($uploaded['size'] <= $maxSize) {
                    $allowed = ['image/jpeg','image/png','application/pdf'];
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, $uploaded['tmp_name']);
                    finfo_close($finfo);
                    if (in_array($mime, $allowed)) {
                        $uploadDir = BASE_PATH . '/public/uploads/clients';
                        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                        $ext = pathinfo($uploaded['name'], PATHINFO_EXTENSION);
                        $filename = 'client_' . time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
                        $dest = $uploadDir . '/' . $filename;
                        if (move_uploaded_file($uploaded['tmp_name'], $dest)) {
                            $documentPath = '/uploads/clients/' . $filename;
                            $cliente->setDocumentPath($documentPath);
                        }
                    }
                }
            }
        }

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

        // Handle file upload (optional replacement)
        if (!empty($_FILES['documento']['name'])) {
            $uploaded = $_FILES['documento'];
            if (is_uploaded_file($uploaded['tmp_name'])) {
                $maxSize = 5 * 1024 * 1024; // 5MB
                $allowed = ['image/jpeg','image/png','application/pdf'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $uploaded['tmp_name']);
                finfo_close($finfo);
                if (in_array($mime, $allowed) && $uploaded['size'] <= $maxSize) {
                    $uploadDir = BASE_PATH . '/public/uploads/clients';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    $ext = pathinfo($uploaded['name'], PATHINFO_EXTENSION);
                    $filename = 'client_' . time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
                    $dest = $uploadDir . '/' . $filename;
                    if (move_uploaded_file($uploaded['tmp_name'], $dest)) {
                        // Optionally delete old file
                        if ($cliente->getDocumentPath()) {
                            $old = BASE_PATH . '/public' . $cliente->getDocumentPath();
                            if (file_exists($old)) unlink($old);
                        }
                        $cliente->setDocumentPath('/uploads/clients/' . $filename);
                    }
                }
            }
        }

        $this->clienteDAO->update($cliente);
        $this->redirect('/clientes');
    }

    public function delete(string $id): void {
        $this->clienteDAO->delete((int)$id);
        $this->redirect('/clientes');
    }
}
