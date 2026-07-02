<?php

namespace App\Controllers;

use App\Core\Controller;
use App\DAO\UsuarioDAO;
use App\DAO\FuncionarioDAO;
use App\DAO\ClienteDAO;

class DashboardController extends Controller {
    public function index(): void {
        $totalUsuarios = 0;
        $totalFuncionarios = 0;
        $totalClientes = 0;
        $dbError = null;

        try {
            $usuarioDAO = new UsuarioDAO();
            $funcionarioDAO = new FuncionarioDAO();
            $clienteDAO = new ClienteDAO();

            $totalUsuarios = count($usuarioDAO->all());
            $totalFuncionarios = count($funcionarioDAO->all());
            $totalClientes = count($clienteDAO->all());
        } catch (\Throwable $e) {
            $dbError = "Não foi possível conectar ao banco de dados ou as tabelas não foram criadas. Certifique-se de executar o arquivo database/schema.sql no seu servidor MySQL. Erro: " . $e->getMessage();
        }

        $this->render('dashboard', [
            'title' => 'Painel Geral - LaundryPro',
            'activePage' => 'dashboard',
            'totalUsuarios' => $totalUsuarios,
            'totalFuncionarios' => $totalFuncionarios,
            'totalClientes' => $totalClientes,
            'dbError' => $dbError
        ]);
    }
}
