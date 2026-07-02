<?php

namespace App\DAO;

use App\Models\Log;

class LogDAO extends BaseDAO {
    protected string $table = 'logs';
    protected string $modelClass = Log::class;

    /**
     * Find logs by user ID.
     *
     * @param int $usuarioId
     * @return Log[]
     */
    public function findByUsuario(int $usuarioId): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE usuario_id = :usuario_id ORDER BY created_at DESC");
        $stmt->execute(['usuario_id' => $usuarioId]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Log($row);
        }
        return $results;
    }
}
