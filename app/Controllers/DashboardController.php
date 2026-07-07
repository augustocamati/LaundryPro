<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\DAO\UsuarioDAO;
use App\DAO\FuncionarioDAO;
use App\DAO\ClienteDAO;
use App\DAO\PedidoDAO;

class DashboardController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $stats = [
            'totalUsuarios'     => 0,
            'totalFuncionarios' => 0,
            'totalClientes'     => 0,
            'pedidosHoje'       => 0,
            'pedidosPendentes'  => 0,
            'faturacaoMes'      => 0.0,
            'graficoLabels'     => [],
            'graficoData'       => [],
            'ultimosPedidos'    => [],
            'pedidosProntos'    => [],
        ];
        $dbError = null;

        try {
            $stats['totalUsuarios']     = count((new UsuarioDAO())->all());
            $stats['totalFuncionarios'] = count((new FuncionarioDAO())->all());
            $stats['totalClientes']     = count((new ClienteDAO())->all());

            $pedidoDAO = new PedidoDAO();
            $stats['pedidosHoje']      = $pedidoDAO->countToday();
            $stats['pedidosPendentes'] = $pedidoDAO->countPendentes();
            $stats['faturacaoMes']     = $pedidoDAO->faturacaoMesAtual();
            $stats['ultimosPedidos']   = $pedidoDAO->ultimosPedidos(8);
            $stats['pedidosProntos']   = $pedidoDAO->pedidosProntos();

            // Build chart arrays (last 6 months)
            $meses = $pedidoDAO->faturacaoUltimos6Meses();
            foreach ($meses as $row) {
                [$ano, $mes] = explode('-', $row['mes']);
                $nomes = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
                $stats['graficoLabels'][] = $nomes[(int)$mes - 1] . '/' . substr($ano, 2);
                $stats['graficoData'][]   = (float) $row['total'];
            }
        } catch (\Throwable $e) {
            $dbError = "Não foi possível conectar ao banco de dados. Erro: " . $e->getMessage();
        }

        $this->render('dashboard', array_merge($stats, [
            'title'      => 'Painel Geral - LaundryPro',
            'activePage' => 'dashboard',
            'dbError'    => $dbError,
        ]));
    }
}
