<?php

require dirname(__DIR__, 2) . '/app/Core/Database.php';

use App\Core\Database;

$pdo = new PDO('mysql:host=127.0.0.1;port=3306;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('CREATE DATABASE IF NOT EXISTS `laundrypro` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
$pdo->exec('USE `laundrypro`');

// Ensure schema tables exist.
$schemaPath = dirname(__DIR__) . '/schema.sql';
if (file_exists($schemaPath)) {
    $schemaSql = file_get_contents($schemaPath);
    $pdo->exec($schemaSql);
}

$pdo = Database::getConnection();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
foreach (['logs', 'pagamentos', 'itens_pedido', 'pedidos', 'funcionarios', 'usuarios', 'clientes', 'servicos', 'categorias', 'perfis'] as $table) {
    $pdo->exec("DELETE FROM `$table`");
    $pdo->exec("ALTER TABLE `$table` AUTO_INCREMENT = 1");
}
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

function ensureId(PDO $pdo, string $table, array $where, array $data): int {
    $fields = array_keys($where);
    $whereSql = implode(' AND ', array_map(fn($field) => "$field = :$field", $fields));
    $stmt = $pdo->prepare("SELECT id FROM `$table` WHERE $whereSql LIMIT 1");
    foreach ($where as $field => $value) {
        $stmt->bindValue(':'.$field, $value);
    }
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        return (int) $row['id'];
    }

    $columns = array_keys($data);
    $placeholders = implode(', ', array_map(fn($field) => ':'.$field, $columns));
    $columnList = implode(', ', $columns);
    $insert = $pdo->prepare("INSERT INTO `$table` ($columnList) VALUES ($placeholders)");
    foreach ($data as $field => $value) {
        $insert->bindValue(':'.$field, $value);
    }
    $insert->execute();
    return (int) $pdo->lastInsertId();
}

$perfis = [
    ['Admin', 'Gestão completa do sistema'],
    ['Atendente', 'Atende clientes e cria pedidos'],
    ['Operador', 'Processa e entrega pedidos'],
];

$perfilIds = [];
foreach ($perfis as [$nome, $descricao]) {
    $perfilIds[$nome] = ensureId($pdo, 'perfis', ['nome' => $nome], ['nome' => $nome, 'descricao' => $descricao]);
}

$usuarios = [
    ['admin', 'Administrador', 'admin@laundrypro.com', password_hash('123456', PASSWORD_BCRYPT), '923000001', 'ativo', $perfilIds['Admin']],
    ['ana', 'Ana Costa', 'ana@laundrypro.com', password_hash('123456', PASSWORD_BCRYPT), '923000002', 'ativo', $perfilIds['Atendente']],
    ['mario', 'Mário Fernandes', 'mario@laundrypro.com', password_hash('123456', PASSWORD_BCRYPT), '923000003', 'ativo', $perfilIds['Operador']],
];

$userIds = [];
foreach ($usuarios as [$username, $nome, $email, $senha, $telefone, $status, $perfilId]) {
    $userId = ensureId($pdo, 'usuarios', ['email' => $email], [
        'perfil_id' => $perfilId,
        'nome' => $nome,
        'email' => $email,
        'senha' => $senha,
        'telefone' => $telefone,
        'status' => $status,
    ]);
    $userIds[$username] = $userId;
}

$funcionarios = [
    ['Administrador', 450000.00, '2024-01-10', $userIds['admin']],
    ['Assistente de Atendimento', 180000.00, '2024-02-20', $userIds['ana']],
    ['Operador de Lavanderia', 220000.00, '2024-03-05', $userIds['mario']],
];
$funcionarioIds = [];
foreach ($funcionarios as [$cargo, $salario, $dataAdmissao, $usuarioId]) {
    $funcionarioId = ensureId($pdo, 'funcionarios', ['usuario_id' => $usuarioId], [
        'usuario_id' => $usuarioId,
        'cargo' => $cargo,
        'salario' => $salario,
        'data_admissao' => $dataAdmissao,
    ]);
    $funcionarioIds[$usuarioId] = $funcionarioId;
}

$clientes = [
    ['Maria Silva', 'maria@example.com', '923111111', '004501A', 'Rua 1, Cacuaco'],
    ['João Pereira', 'joao@example.com', '923222222', '004502B', 'Av. 24 de Julho'],
    ['Ana Mendes', 'ana.mendes@example.com', '923333333', '004503C', 'Rua das Flores'],
    ['Carlos Ngoma', 'carlos@example.com', '923444444', '004504D', 'Maianga'],
];

$clienteIds = [];
foreach ($clientes as [$nome, $email, $telefone, $bi, $endereco]) {
    $clienteIds[$email] = ensureId($pdo, 'clientes', ['email' => $email], [
        'nome' => $nome,
        'email' => $email,
        'telefone' => $telefone,
        'bi' => $bi,
        'endereco' => $endereco,
    ]);
}

$categorias = [
    ['Lavagem', 'Serviços de lavagem e secagem'],
    ['Passadoria', 'Serviços de passar e acabar peças'],
    ['Limpeza', 'Limpeza especializada'],
    ['Express', 'Serviço rápido para urgências'],
];

$categoriaIds = [];
foreach ($categorias as [$nome, $descricao]) {
    $categoriaIds[$nome] = ensureId($pdo, 'categorias', ['nome' => $nome], ['nome' => $nome, 'descricao' => $descricao]);
}

$servicos = [
    ['Lavagem Normal', 'Lavagem completa de roupas comuns', $categoriaIds['Lavagem'], 1800.00, 2],
    ['Lavagem Premium', 'Lavagem com tratamento especial', $categoriaIds['Lavagem'], 3200.00, 3],
    ['Passadoria Simples', 'Passar camisas e roupas leves', $categoriaIds['Passadoria'], 1200.00, 1],
    ['Limpeza de Casaco', 'Limpeza especializada de casacos', $categoriaIds['Limpeza'], 4500.00, 4],
    ['Serviço Express', 'Entrega rápida em 24 horas', $categoriaIds['Express'], 2800.00, 1],
];

$servicoIds = [];
foreach ($servicos as [$nome, $descricao, $categoriaId, $preco, $prazo]) {
    $servicoIds[$nome] = ensureId($pdo, 'servicos', ['nome' => $nome], [
        'categoria_id' => $categoriaId,
        'nome' => $nome,
        'descricao' => $descricao,
        'preco' => $preco,
        'prazo_dias' => $prazo,
    ]);
}

$pedidos = [
    ['2024-06-25 09:30:00', '2024-06-27 09:30:00', 'Pendente', $clienteIds['maria@example.com'], $funcionarioIds[$userIds['ana']], 'Roupa para lavagem'],
    ['2024-06-26 10:00:00', '2024-06-28 10:00:00', 'Em Processamento', $clienteIds['joao@example.com'], $funcionarioIds[$userIds['mario']], 'Vestido para passar'],
    ['2024-06-27 08:15:00', '2024-06-29 08:15:00', 'Pronto', $clienteIds['ana.mendes@example.com'], $funcionarioIds[$userIds['ana']], 'Casaco limpo'],
    ['2024-06-28 14:00:00', '2024-06-30 14:00:00', 'Entregue', $clienteIds['carlos@example.com'], $funcionarioIds[$userIds['mario']], 'Entrega concluída'],
    ['2024-06-29 16:45:00', '2024-07-02 16:45:00', 'Cancelado', $clienteIds['maria@example.com'], $funcionarioIds[$userIds['ana']], 'Cliente cancelou'],
];

$pedidoIds = [];
foreach ($pedidos as [$dataPedido, $dataEntregaPrevista, $status, $clienteId, $funcionarioId, $observacoes]) {
    $pedidoId = ensureId($pdo, 'pedidos', ['cliente_id' => $clienteId, 'data_pedido' => $dataPedido], [
        'cliente_id' => $clienteId,
        'funcionario_id' => $funcionarioId,
        'data_pedido' => $dataPedido,
        'data_entrega_prevista' => $dataEntregaPrevista,
        'status' => $status,
        'valor_total' => 0.00,
        'observacoes' => $observacoes,
    ]);
    $pedidoIds[] = $pedidoId;
}

$itens = [
    [$pedidoIds[0], $servicoIds['Lavagem Normal'], 3, 1800.00, 5400.00],
    [$pedidoIds[1], $servicoIds['Passadoria Simples'], 2, 1200.00, 2400.00],
    [$pedidoIds[2], $servicoIds['Limpeza de Casaco'], 1, 4500.00, 4500.00],
    [$pedidoIds[3], $servicoIds['Lavagem Premium'], 2, 3200.00, 6400.00],
    [$pedidoIds[4], $servicoIds['Serviço Express'], 1, 2800.00, 2800.00],
];
foreach ($itens as [$pedidoId, $servicoId, $quantidade, $precoUnitario, $subtotal]) {
    ensureId($pdo, 'itens_pedido', ['pedido_id' => $pedidoId, 'servico_id' => $servicoId], [
        'pedido_id' => $pedidoId,
        'servico_id' => $servicoId,
        'quantidade' => $quantidade,
        'preco_unitario' => $precoUnitario,
        'subtotal' => $subtotal,
    ]);
}

$pagamentos = [
    [$pedidoIds[0], 5400.00, 'Dinheiro', 'Pago', '2024-06-25 10:15:00'],
    [$pedidoIds[1], 2400.00, 'Pix', 'Pago', '2024-06-26 10:45:00'],
    [$pedidoIds[2], 4500.00, 'Cartao_Credito', 'Pago', '2024-06-27 09:00:00'],
    [$pedidoIds[3], 6400.00, 'Cartao_Debito', 'Pago', '2024-06-28 15:10:00'],
];
foreach ($pagamentos as [$pedidoId, $valor, $metodo, $status, $data]) {
    ensureId($pdo, 'pagamentos', ['pedido_id' => $pedidoId], [
        'pedido_id' => $pedidoId,
        'valor' => $valor,
        'metodo_pagamento' => $metodo,
        'status' => $status,
        'data_pagamento' => $data,
    ]);
}

$logs = [
    ['login', 'Usuário admin iniciou sessão', '127.0.0.1', $userIds['admin']],
    ['criar_pedido', 'Pedido criado para Maria Silva', '127.0.0.1', $userIds['ana']],
    ['editar_servico', 'Serviço de lavagem atualizado', '127.0.0.1', $userIds['mario']],
];
foreach ($logs as [$acao, $descricao, $ipAddress, $usuarioId]) {
    ensureId($pdo, 'logs', ['acao' => $acao, 'descricao' => $descricao], [
        'usuario_id' => $usuarioId,
        'acao' => $acao,
        'descricao' => $descricao,
        'ip_address' => $ipAddress,
    ]);
}

// Update pedidos totals to match their items.
echo "Dados fictícios inseridos com sucesso.\n";
