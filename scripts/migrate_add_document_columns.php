<?php
// Migração: adiciona document_path em clientes e pedidos se ausente
require __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

try {
    $pdo = Database::getConnection();
    $dbNameStmt = $pdo->query('SELECT DATABASE() as db');
    $dbName = $dbNameStmt->fetchColumn();

    $tables = [
        'clientes' => 'document_path VARCHAR(255) NULL',
        'pedidos'  => 'document_path VARCHAR(255) NULL',
    ];

    foreach ($tables as $table => $definition) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :db AND TABLE_NAME = :table AND COLUMN_NAME = 'document_path'");
        $stmt->execute(['db' => $dbName, 'table' => $table]);
        $exists = (int) $stmt->fetchColumn() > 0;
        if ($exists) {
            echo "OK: column document_path already exists on $table\n";
            continue;
        }

        $sql = "ALTER TABLE `$table` ADD COLUMN $definition";
        $pdo->exec($sql);
        echo "Added document_path to $table\n";
    }

    echo "Migration completed.\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
