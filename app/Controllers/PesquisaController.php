<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\DAO\PedidoDAO;
use App\DAO\ClienteDAO;
use App\DAO\ServicoDAO;
use App\DAO\CategoriaDAO;

class PesquisaController extends Controller {
    public function __construct() {
        Auth::requireAuth();
    }

    public function index(): void {
        $pedidoDAO = new PedidoDAO();
        $clienteDAO = new ClienteDAO();
        $servicoDAO = new ServicoDAO();
        $categoriaDAO = new CategoriaDAO();

        $term = trim($_GET['q'] ?? '');
        $field = $_GET['campo'] ?? 'nome';
        $status = $_GET['status'] ?? '';
        $categoriaId = (int) ($_GET['categoria'] ?? 0);
        $data = trim($_GET['data'] ?? '');

        $resultados = [];
        if ($term !== '' || $status !== '' || $categoriaId > 0 || $data !== '') {
            $sql = 'SELECT p.*, c.nome AS cliente_nome, c.telefone AS cliente_telefone FROM pedidos p LEFT JOIN clientes c ON c.id = p.cliente_id WHERE 1=1';
            $params = [];

            if ($term !== '') {
                switch ($field) {
                    case 'codigo':
                        $sql .= ' AND p.id = :term';
                        $params['term'] = (int) $term;
                        break;
                    case 'telefone':
                        $sql .= ' AND c.telefone LIKE :term';
                        $params['term'] = '%' . $term . '%';
                        break;
                    case 'estado':
                        $sql .= ' AND p.status LIKE :term';
                        $params['term'] = '%' . $term . '%';
                        break;
                    case 'data':
                        $sql .= ' AND DATE(p.data_pedido) = :term';
                        $params['term'] = $term;
                        break;
                    case 'categoria':
                        $sql .= ' AND EXISTS (SELECT 1 FROM itens_pedido ip JOIN servicos s ON s.id = ip.servico_id WHERE ip.pedido_id = p.id AND s.categoria_id = :term)';
                        $params['term'] = $categoriaId;
                        break;
                    case 'nome':
                    default:
                        $sql .= ' AND c.nome LIKE :term';
                        $params['term'] = '%' . $term . '%';
                        break;
                }
            }

            if ($status !== '') {
                $sql .= ' AND p.status = :status';
                $params['status'] = $status;
            }

            if ($data !== '') {
                $sql .= ' AND DATE(p.data_pedido) = :data';
                $params['data'] = $data;
            }

            if ($categoriaId > 0 && $field !== 'categoria') {
                $sql .= ' AND EXISTS (SELECT 1 FROM itens_pedido ip JOIN servicos s ON s.id = ip.servico_id WHERE ip.pedido_id = p.id AND s.categoria_id = :categoria_id)';
                $params['categoria_id'] = $categoriaId;
            }

            $sql .= ' ORDER BY p.data_pedido DESC';
            $stmt = $this->db->prepare($sql); // placeholder
        }

        $this->render('pesquisas.index', [
            'title' => 'Pesquisas - LaundryPro',
            'activePage' => 'pesquisas',
            'resultados' => $resultados,
            'q' => $term,
            'campo' => $field,
            'status' => $status,
            'data' => $data,
            'categoriaId' => $categoriaId,
            'clientes' => $clienteDAO->all(),
            'categorias' => $categoriaDAO->all(),
            'servicos' => $servicoDAO->all(),
        ]);
    }
}
