<?php

namespace App\DAO;

use App\Models\Perfil;

class PerfilDAO extends BaseDAO {
    protected string $table = 'perfis';
    protected string $modelClass = Perfil::class;

    /**
     * Find a profile by its name.
     *
     * @param string $nome
     * @return Perfil|null
     */
    public function findByName(string $nome): ?Perfil {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE nome = :nome LIMIT 1");
        $stmt->execute(['nome' => $nome]);
        $row = $stmt->fetch();
        return $row ? new Perfil($row) : null;
    }
}
