<?php

namespace App\DAO;

use App\Models\Pedido;

class PedidoDAO extends BaseDAO {
    protected string $table = 'pedidos';
    protected string $modelClass = Pedido::class;

    /**
     * Find orders by customer ID.
     *
     * @param int $clienteId
     * @return Pedido[]
     */
    public function findByCliente(int $clienteId): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE cliente_id = :cliente_id ORDER BY data_pedido DESC");
        $stmt->execute(['cliente_id' => $clienteId]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Pedido($row);
        }
        return $results;
    }

    /**
     * Find orders by status.
     *
     * @param string $status
     * @return Pedido[]
     */
    public function findByStatus(string $status): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE status = :status ORDER BY data_pedido DESC");
        $stmt->execute(['status' => $status]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Pedido($row);
        }
        return $results;
    }
}
