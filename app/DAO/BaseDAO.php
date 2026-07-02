<?php

namespace App\DAO;

use App\Core\Database;
use PDO;

abstract class BaseDAO {
    protected PDO $db;
    protected string $table;
    protected string $modelClass;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Fetch a record by ID and map it to its Model entity.
     *
     * @param int $id
     * @return object|null
     */
    public function find(int $id): ?object {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? new $this->modelClass($row) : null;
    }

    /**
     * Fetch all records from the table.
     *
     * @return array
     */
    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new $this->modelClass($row);
        }
        return $results;
    }

    /**
     * Insert a new record into the database.
     *
     * @param object $model
     * @return int|false
     */
    public function create(object $model): int|false {
        $data = $model->toArray();
        
        // Remove primary key if it's null (auto-increment)
        if (isset($data['id']) && $data['id'] === null) {
            unset($data['id']);
        }
        
        // Populate timestamps if they exist and are not set
        if (array_key_exists('created_at', $data) && $data['created_at'] === null) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        if (array_key_exists('updated_at', $data) && $data['updated_at'] === null) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        // Filter null values so SQL defaults can work
        $data = array_filter($data, fn($value) => $value !== null);

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute($data)) {
            $id = (int)$this->db->lastInsertId();
            if (method_exists($model, 'setId')) {
                $model->setId($id);
            }
            return $id;
        }
        return false;
    }

    /**
     * Update an existing record in the database.
     *
     * @param object $model
     * @return bool
     */
    public function update(object $model): bool {
        $data = $model->toArray();
        if (!isset($data['id']) || $data['id'] === null) {
            return false;
        }
        $id = $data['id'];
        unset($data['id']);

        if (array_key_exists('updated_at', $data)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $fields = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE {$this->table} SET $fields WHERE id = :primary_id";
        
        $params = array_merge($data, ['primary_id' => $id]);
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Delete a record by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
