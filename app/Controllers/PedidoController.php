<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\DAO\ClienteDAO;
use App\DAO\ItemPedidoDAO;
use App\DAO\PedidoDAO;
use App\DAO\ServicoDAO;
use App\Models\ItemPedido;
use App\Models\Pedido;

class PedidoController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $q = trim($_GET['q'] ?? '');
        $pedidoDAO = new PedidoDAO();
        $pedidos = $pedidoDAO->all();

        if ($q !== '') {
            $qLower = mb_strtolower($q);
            $pedidos = array_values(array_filter($pedidos, function ($pedido) use ($qLower): bool {
                return stripos((string) $pedido->getId(), $qLower) !== false
                    || stripos(mb_strtolower($pedido->getStatus()), $qLower) !== false;
            }));
        }

        $this->render('pedidos.index', [
            'title' => 'Pedidos - LaundryPro',
            'activePage' => 'pedidos',
            'pedidos' => $pedidos,
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
        $quantidade = max(1, (int) ($_POST['quantidade'] ?? 1));
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
            'status' => 'Pendente',
            'valor_total' => $servico->getPreco() * $quantidade,
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
            'quantidade' => $quantidade,
            'preco_unitario' => $servico->getPreco(),
            'subtotal' => $servico->getPreco() * $quantidade,
        ]);

        $itemPedidoDAO = new ItemPedidoDAO();
        $itemPedidoDAO->create($item);

        $this->redirect('/pedidos');
    }
}
