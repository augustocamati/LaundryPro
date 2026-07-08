<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatório de Pagamentos</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size:12px; }
        h1 { font-size:16px; }
        table { width:100%; border-collapse: collapse; margin-top:12px; }
        th, td { border:1px solid #ccc; padding:6px 8px; text-align:left; }
        th { background:#f0f0f0; }
        .summary { margin-top:12px; }
    </style>
</head>
<body>
    <h1>Relatório de Pagamentos</h1>
    <p>Gerado em: <?= date('d/m/Y H:i:s') ?></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pedido ID</th>
                <th>Valor (AOA)</th>
                <th>Método</th>
                <th>Estado</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pagamentos as $p): ?>
                <tr>
                    <td><?= (int) $p->getId() ?></td>
                    <td><?= (int) $p->getPedidoId() ?></td>
                    <td><?= number_format($p->getValor(), 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($p->getMetodoPagamento()) ?></td>
                    <td><?= htmlspecialchars($p->getStatus()) ?></td>
                    <td><?= htmlspecialchars($p->getDataPagamento()) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="summary">
        <strong>Total pago:</strong>
        AOA <?= number_format(array_sum(array_map(fn($p) => $p->getStatus() === 'Pago' ? $p->getValor() : 0, $pagamentos)), 2, ',', '.') ?>
    </div>
</body>
</html>
