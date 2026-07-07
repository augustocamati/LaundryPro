<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\DAO\PagamentoDAO;
use App\DAO\PedidoDAO;
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

        if ($q !== '') {
            $qLower = mb_strtolower($q);
            $pagamentos = array_values(array_filter($pagamentos, function ($pagamento) use ($qLower): bool {
                return stripos((string) $pagamento->getPedidoId(), $qLower) !== false
                    || stripos(mb_strtolower($pagamento->getMetodoPagamento()), $qLower) !== false
                    || stripos(mb_strtolower($pagamento->getStatus()), $qLower) !== false;
            }));
        }

        $this->render('pagamentos.index', [
            'title' => 'Pagamentos - LaundryPro',
            'activePage' => 'pagamentos',
            'pagamentos' => $pagamentos,
            'pedidos' => $pedidoDAO->all(),
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
