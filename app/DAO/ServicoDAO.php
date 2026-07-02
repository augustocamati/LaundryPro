<?php

namespace App\DAO;

use App\Models\Servico;

class ServicoDAO extends BaseDAO {
    protected string $table = 'servicos';
    protected string $modelClass = Servico::class;

    /**
     * Find services by category.
     *
     * @param int $categoriaId
     * @return Servico[]
     */
    public function findByCategoria(int $categoriaId): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE categoria_id = :categoria_id");
        $stmt->execute(['categoria_id' => $categoriaId]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Servico($row);
        }
        return $results;
    }
}
