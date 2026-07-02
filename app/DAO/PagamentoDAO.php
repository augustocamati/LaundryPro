<?php

namespace App\DAO;

use App\Models\Pagamento;

class PagamentoDAO extends BaseDAO {
    protected string $table = 'pagamentos';
    protected string $modelClass = Pagamento::class;

    /**
     * Find payments for a specific order.
     *
     * @param int $pedidoId
     * @return Pagamento[]
     */
    public function findByPedido(int $pedidoId): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE pedido_id = :pedido_id");
        $stmt->execute(['pedido_id' => $pedidoId]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Pagamento($row);
        }
        return $results;
    }
}
