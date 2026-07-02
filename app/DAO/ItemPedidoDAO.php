<?php

namespace App\DAO;

use App\Models\ItemPedido;

class ItemPedidoDAO extends BaseDAO {
    protected string $table = 'itens_pedido';
    protected string $modelClass = ItemPedido::class;

    /**
     * Find items of a specific order.
     *
     * @param int $pedidoId
     * @return ItemPedido[]
     */
    public function findByPedido(int $pedidoId): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE pedido_id = :pedido_id");
        $stmt->execute(['pedido_id' => $pedidoId]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new ItemPedido($row);
        }
        return $results;
    }
}
