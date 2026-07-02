<?php

namespace App\DAO;

use App\Models\Usuario;

class UsuarioDAO extends BaseDAO {
    protected string $table = 'usuarios';
    protected string $modelClass = Usuario::class;

    /**
     * Find a user by email.
     *
     * @param string $email
     * @return Usuario|null
     */
    public function findByEmail(string $email): ?Usuario {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ? new Usuario($row) : null;
    }

    /**
     * Find users by profile ID.
     *
     * @param int $perfilId
     * @return Usuario[]
     */
    public function findByPerfil(int $perfilId): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE perfil_id = :perfil_id");
        $stmt->execute(['perfil_id' => $perfilId]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Usuario($row);
        }
        return $results;
    }
}
