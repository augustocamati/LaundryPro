<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\DAO\PagamentoDAO;
use App\DAO\PedidoDAO;
use App\DAO\ClienteDAO;
use App\Models\Pagamento;

class PagamentoController extends Controller {
    public function __construct() {
        Auth::requireAuth();
    }

    public function index(): void {
        $q = trim($_GET['q'] ?? '');
        $pagamentoDAO = new PagamentoDAO();
        $pedidoDAO = new PedidoDAO();
        $pagamentos = $pagamentoDAO->all();

        // Fetch pending orders for the dropdown only
        $pedidosPendentes = $pedidoDAO->findByStatus('Pendente');

        // Build cliente map for display in payments list
        $clienteDAO = new ClienteDAO();
        $clientes = $clienteDAO->all();
        $clientesById = [];
        foreach ($clientes as $c) {
            $clientesById[(int) $c->getId()] = $c;
        }

        // Build pedidos map (all orders) for lookup by id
        $pedidosAll = $pedidoDAO->all();
        $pedidosById = [];
        foreach ($pedidosAll as $p) {
            $pedidosById[(int) $p->getId()] = $p;
        }

        if ($q !== '') {
            $qLower = strtolower($q);
            $pagamentos = array_values(array_filter($pagamentos, function ($pagamento) use ($qLower): bool {
                return stripos((string) $pagamento->getPedidoId(), $qLower) !== false
                    || stripos(strtolower($pagamento->getMetodoPagamento()), $qLower) !== false
                    || stripos(strtolower($pagamento->getStatus()), $qLower) !== false;
            }));
        }

        $this->render('pagamentos.index', [
            'title' => 'Pagamentos - LaundryPro',
            'activePage' => 'pagamentos',
            'pagamentos' => $pagamentos,
            'pedidos' => $pedidosPendentes,
            'clientesById' => $clientesById,
            'pedidosById' => $pedidosById,
            'q' => $q,
        ]);
    }

    public function registrar(): void {
        $pedidoId = (int) ($_POST['pedido_id'] ?? 0);
        $valor = (float) ($_POST['valor'] ?? 0);
        $metodo = trim($_POST['metodo_pagamento'] ?? 'Dinheiro');
        $status = trim($_POST['status'] ?? 'Pago');

        if ($pedidoId <= 0 || $valor <= 0) {
            $this->redirect('/pagamentos?error=invalid');
        }

        $pagamento = new Pagamento([
            'pedido_id' => $pedidoId,
            'valor' => $valor,
            'metodo_pagamento' => $metodo,
            'status' => $status,
            'data_pagamento' => date('Y-m-d H:i:s'),
        ]);

        $pagamentoDAO = new PagamentoDAO();
        $pagamentoDAO->create($pagamento);

        // Atualiza o status do pedido ao registrar o pagamento
        $pedidoDAO = new PedidoDAO();
        $pedido = $pedidoDAO->find($pedidoId);
        if ($pedido) {
            $pedido->setStatus($status);
            $pedidoDAO->update($pedido);
        }

        $this->redirect('/pagamentos');
    }

    public function cancelar(string $id): void {
        $pagamentoDAO = new PagamentoDAO();
        $pagamento = $pagamentoDAO->find((int) $id);
        if ($pagamento) {
            $pagamento->setStatus('Cancelado');
            $pagamentoDAO->update($pagamento);
        }
        $this->redirect('/pagamentos');
    }

    public function relatorios(): void {
        $pagamentoDAO = new PagamentoDAO();
        $pagamentos = $pagamentoDAO->all();

        $this->render('pagamentos.relatorios', [
            'title' => 'Relatórios de Pagamentos - LaundryPro',
            'activePage' => 'pagamentos',
            'pagamentos' => $pagamentos,
        ]);
    }
}
