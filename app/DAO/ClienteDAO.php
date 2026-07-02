<?php

namespace App\DAO;

use App\Models\Cliente;

class ClienteDAO extends BaseDAO {
    protected string $table = 'clientes';
    protected string $modelClass = Cliente::class;

    /**
     * Find a customer by email.
     *
     * @param string $email
     * @return Cliente|null
     */
    public function findByEmail(string $email): ?Cliente {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ? new Cliente($row) : null;
    }

    /**
     * Find a customer by BI (Bilhete de Identidade).
     *
     * @param string $bi
     * @return Cliente|null
     */
    public function findByBi(string $bi): ?Cliente {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE bi = :bi LIMIT 1");
        $stmt->execute(['bi' => $bi]);
        $row = $stmt->fetch();
        return $row ? new Cliente($row) : null;
    }
}
