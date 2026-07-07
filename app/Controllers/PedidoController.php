<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\DAO\ClienteDAO;
use App\DAO\ItemPedidoDAO;
use App\DAO\PedidoDAO;
use App\DAO\ServicoDAO;
use App\DAO\PagamentoDAO;
use App\Models\ItemPedido;
use App\Models\Pedido;
use App\Models\Pagamento;

class PedidoController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $q = trim($_GET['q'] ?? '');
        $pedidoDAO = new PedidoDAO();
        $pedidos = $pedidoDAO->all();

        // Build a mapping clientId => cliente object for display
        $clienteDAO = new ClienteDAO();
        $clientes = $clienteDAO->all();
        $clientesById = [];
        foreach ($clientes as $c) {
            $clientesById[(int) $c->getId()] = $c;
        }

        if ($q !== '') {
            $qLower = strtolower($q);
            $pedidos = array_values(array_filter($pedidos, function ($pedido) use ($qLower): bool {
                return stripos((string) $pedido->getId(), $qLower) !== false
                    || stripos(strtolower($pedido->getStatus()), $qLower) !== false;
            }));
        }

        $this->render('pedidos.index', [
            'title' => 'Pedidos - LaundryPro',
            'activePage' => 'pedidos',
            'pedidos' => $pedidos,
            'clientesById' => $clientesById,
            'q' => $q,
        ]);
    }

    public function create(): void {
        Auth::requireAuth();

        $clienteDAO = new ClienteDAO();
        $servicoDAO = new ServicoDAO();

        $this->render('pedidos.create', [
            'title' => 'Novo Pedido - LaundryPro',
            'activePage' => 'pedidos',
            'clientes' => $clienteDAO->all(),
            'servicos' => $servicoDAO->all(),
            'error' => null,
            'success' => null,
        ]);
    }

    public function store(): void {
        Auth::requireAuth();

        $clienteId = (int) ($_POST['cliente_id'] ?? 0);
        $servicoId = (int) ($_POST['servico_id'] ?? 0);
        $kilos = max(0.1, (float) ($_POST['kilos'] ?? 1));
        $status = trim($_POST['status'] ?? 'Pendente');
        $estadoPagamento = trim($_POST['estado_pagamento'] ?? 'Pendente');
        $observacoes = trim($_POST['observacoes'] ?? '');

        if ($clienteId <= 0 || $servicoId <= 0) {
            $this->redirect('/pedidos/novo?error=cliente_servico');
        }

        $servicoDAO = new ServicoDAO();
        $servico = $servicoDAO->find($servicoId);
        if (!$servico) {
            $this->redirect('/pedidos/novo?error=servico');
        }

        $pedido = new Pedido([
            'cliente_id' => $clienteId,
            'data_entrega_prevista' => date('Y-m-d H:i:s', strtotime('+3 days')),
            'status' => $status,
            'valor_total' => $servico->getPreco() * $kilos,
            'observacoes' => $observacoes,
        ]);

        $pedidoDAO = new PedidoDAO();
        $pedidoId = $pedidoDAO->create($pedido);
        if (!$pedidoId) {
            $this->redirect('/pedidos/novo?error=salvar');
        }

        $item = new ItemPedido([
            'pedido_id' => $pedidoId,
            'servico_id' => $servicoId,
            'quantidade' => $kilos,
            'preco_unitario' => $servico->getPreco(),
            'subtotal' => $servico->getPreco() * $kilos,
        ]);

        $itemPedidoDAO = new ItemPedidoDAO();
        $itemPedidoDAO->create($item);

        // If order was created and marked as paid, create a payment record
        if (strtolower($estadoPagamento) === 'pago') {
            $pagamento = new Pagamento([
                'pedido_id' => $pedidoId,
                'valor' => $pedido->getValorTotal(),
                'metodo_pagamento' => 'Dinheiro',
                'status' => 'Pago',
                'data_pagamento' => date('Y-m-d H:i:s'),
            ]);
            $pagamentoDAO = new PagamentoDAO();
            $pagamentoDAO->create($pagamento);
        }

        $this->redirect('/pedidos');
    }
}
