<?php

namespace App\DAO;

use App\Models\Categoria;

class CategoriaDAO extends BaseDAO {
    protected string $table = 'categorias';
    protected string $modelClass = Categoria::class;

    /**
     * Find a category by name.
     *
     * @param string $nome
     * @return Categoria|null
     */
    public function findByName(string $nome): ?Categoria {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE nome = :nome LIMIT 1");
        $stmt->execute(['nome' => $nome]);
        $row = $stmt->fetch();
        return $row ? new Categoria($row) : null;
    }
}
