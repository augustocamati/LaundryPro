<?php

namespace App\DAO;

use App\Models\Pedido;

class PedidoDAO extends BaseDAO {
    protected string $table = 'pedidos';
    protected string $modelClass = Pedido::class;

    /** Find orders by customer ID. */
    public function findByCliente(int $clienteId): array {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE cliente_id = :cliente_id ORDER BY data_pedido DESC"
        );
        $stmt->execute(['cliente_id' => $clienteId]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Pedido($row);
        }
        return $results;
    }

    /** Find orders by status. */
    public function findByStatus(string $status): array {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE status = :status ORDER BY data_pedido DESC"
        );
        $stmt->execute(['status' => $status]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Pedido($row);
        }
        return $results;
    }

    /** Count orders created today. */
    public function countToday(): int {
        $stmt = $this->db->query(
            "SELECT COUNT(*) FROM {$this->table} WHERE DATE(data_pedido) = CURDATE()"
        );
        return (int) $stmt->fetchColumn();
    }

    /** Count pending orders. */
    public function countPendentes(): int {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE status = :s"
        );
        $stmt->execute(['s' => 'Pendente']);
        return (int) $stmt->fetchColumn();
    }

    /** Sum faturação (total revenue) of paid orders this month. */
    public function faturacaoMesAtual(): float {
        $stmt = $this->db->query(
            "SELECT COALESCE(SUM(valor_total), 0)
             FROM {$this->table}
             WHERE MONTH(data_pedido) = MONTH(CURDATE())
               AND YEAR(data_pedido) = YEAR(CURDATE())
               AND status NOT IN ('Cancelado')"
        );
        return (float) $stmt->fetchColumn();
    }

    /** Monthly revenue for the last 6 months (for chart). */
    public function faturacaoUltimos6Meses(): array {
        $stmt = $this->db->query(
            "SELECT DATE_FORMAT(data_pedido, '%Y-%m') AS mes,
                    COALESCE(SUM(valor_total), 0) AS total
             FROM {$this->table}
             WHERE data_pedido >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
               AND status NOT IN ('Cancelado')
             GROUP BY mes
             ORDER BY mes ASC"
        );
        return $stmt->fetchAll();
    }

    /** Get the last N orders with client info. */
    public function ultimosPedidos(int $limit = 10): array {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.nome AS cliente_nome
             FROM {$this->table} p
             LEFT JOIN clientes c ON c.id = p.cliente_id
             ORDER BY p.data_pedido DESC
             LIMIT :limit"
        );
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Get all 'Pronto' orders waiting for pickup. */
    public function pedidosProntos(): array {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.nome AS cliente_nome, c.telefone AS cliente_telefone
             FROM {$this->table} p
             LEFT JOIN clientes c ON c.id = p.cliente_id
             WHERE p.status = :s
             ORDER BY p.data_entrega_prevista ASC"
        );
        $stmt->execute(['s' => 'Pronto']);
        return $stmt->fetchAll();
    }
}
