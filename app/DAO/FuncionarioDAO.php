<?php

namespace App\DAO;

use App\Models\Funcionario;

class FuncionarioDAO extends BaseDAO {
    protected string $table = 'funcionarios';
    protected string $modelClass = Funcionario::class;

    /**
     * Find employee details by user ID.
     *
     * @param int $usuarioId
     * @return Funcionario|null
     */
    public function findByUsuarioId(int $usuarioId): ?Funcionario {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE usuario_id = :usuario_id LIMIT 1");
        $stmt->execute(['usuario_id' => $usuarioId]);
        $row = $stmt->fetch();
        return $row ? new Funcionario($row) : null;
    }
}
