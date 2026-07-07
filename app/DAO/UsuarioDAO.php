<?php

namespace App\DAO;

use App\Models\Usuario;

class UsuarioDAO extends BaseDAO {
    protected string $table = 'usuarios';
    protected string $modelClass = Usuario::class;

    /** Find a user by email. */
    public function findByEmail(string $email): ?Usuario {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ? new Usuario($row) : null;
    }

    /** Find users by profile ID. */
    public function findByPerfil(int $perfilId): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE perfil_id = :perfil_id");
        $stmt->execute(['perfil_id' => $perfilId]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Usuario($row);
        }
        return $results;
    }

    /** Find a user by their password recovery token. */
    public function findByToken(string $token): ?Usuario {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table}
             WHERE token_recuperacao = :token
               AND token_expira_em > NOW()
             LIMIT 1"
        );
        $stmt->execute(['token' => $token]);
        $row = $stmt->fetch();
        return $row ? new Usuario($row) : null;
    }

    /** Set a recovery token for a user. */
    public function setRecoveryToken(int $userId, string $token, string $expiraEm): bool {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET token_recuperacao = :token, token_expira_em = :expira, updated_at = NOW()
             WHERE id = :id"
        );
        return $stmt->execute(['token' => $token, 'expira' => $expiraEm, 'id' => $userId]);
    }

    /** Clear the recovery token after password reset. */
    public function clearRecoveryToken(int $userId): bool {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET token_recuperacao = NULL, token_expira_em = NULL, updated_at = NOW()
             WHERE id = :id"
        );
        return $stmt->execute(['id' => $userId]);
    }

    /** Update the password hash directly. */
    public function updateSenha(int $userId, string $senhaHash): bool {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET senha = :senha, updated_at = NOW() WHERE id = :id"
        );
        return $stmt->execute(['senha' => $senhaHash, 'id' => $userId]);
    }
}
