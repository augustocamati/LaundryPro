<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\DAO\PedidoDAO;
use App\Helpers\LoggerHelper;

class RelatorioController extends Controller {
    public function download(): void {
        Auth::requireAuth();

        $pedidoDAO = new PedidoDAO();
        // Fetch up to 1000 most recent orders for the report
        $pedidos = $pedidoDAO->ultimosPedidos(1000);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=relatorio_pedidos_' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');
        
        // Output BOM to ensure UTF-8 characters are displayed correctly in Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Add headers
        fputcsv($output, ['ID Pedido', 'Cliente', 'Data Pedido', 'Status', 'Valor Total']);

        foreach ($pedidos as $pedido) {
            fputcsv($output, [
                $pedido['id'] ?? '-',
                $pedido['cliente_nome'] ?? '-',
                $pedido['data_pedido'] ?? '-',
                $pedido['status'] ?? '-',
                $pedido['valor_total'] ?? '0.00'
            ]);
        }

        fclose($output);

        if (class_exists('\App\Helpers\LoggerHelper')) {
            LoggerHelper::log('DOWNLOAD_RELATORIO', 'Descarregou o relatório de pedidos em CSV.');
        }

        exit;
    }
}
