<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\DAO\PagamentoDAO;
use App\DAO\PedidoDAO;
use App\DAO\ClienteDAO;
use App\Models\Pagamento;
use Dompdf\Dompdf;

class PagamentoController extends Controller {
    public function __construct() {
        Auth::requireAuth();
    }

    private function checkWritePermission(): void {
        if (Auth::isOperador()) {
            \App\Core\Session::flash('error', 'Acesso negado. Operadores não gerem pagamentos.');
            header('Location: /pagamentos');
            exit;
        }
    }

    private function checkAdminPermission(): void {
        if (!Auth::isAdmin()) {
            \App\Core\Session::flash('error', 'Acesso negado. Apenas administradores.');
            header('Location: /pagamentos');
            exit;
        }
    }

    private function checkAdminOrAtendentePermission(): void {
        if (!Auth::isAdmin() && !Auth::isAtendente()) {
            \App\Core\Session::flash('error', 'Acesso negado.');
            header('Location: /pagamentos');
            exit;
        }
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
        $this->checkWritePermission();
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
        $this->checkWritePermission();
        $pagamentoDAO = new PagamentoDAO();
        $pagamento = $pagamentoDAO->find((int) $id);
        if ($pagamento) {
            $pagamento->setStatus('Cancelado');
            $pagamentoDAO->update($pagamento);
        }
        $this->redirect('/pagamentos');
    }

    public function relatorios(): void {
        $this->checkAdminPermission();
        $pagamentoDAO = new PagamentoDAO();
        $pagamentos = $pagamentoDAO->all();

        $this->render('pagamentos.relatorios', [
            'title' => 'Relatórios de Pagamentos - LaundryPro',
            'activePage' => 'pagamentos',
            'pagamentos' => $pagamentos,
        ]);
    }

    public function relatoriosPdf(): void {
        Auth::requireAuth();
        $this->checkAdminOrAtendentePermission();

        $pagamentoDAO = new PagamentoDAO();
        $pagamentos = $pagamentoDAO->all();

        $viewFile = BASE_PATH . '/app/Views/pagamentos/relatorios_pdf.php';
        if (!file_exists($viewFile)) {
            $this->redirect('/pagamentos/relatorios?error=missing_view');
        }

        // Render the PDF HTML using the view
        ob_start();
        // expose $pagamentos to the view
        $pagamentos = $pagamentos;
        require $viewFile;
        $html = ob_get_clean();

        if (!class_exists('\Dompdf\\Dompdf')) {
            // If Dompdf not available, show the HTML page instead
            header('Content-Type: text/html; charset=utf-8');
            echo $html;
            exit;
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $filename = 'relatorio_pagamentos_' . date('Ymd_His') . '.pdf';
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }
}
