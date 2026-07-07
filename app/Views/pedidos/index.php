<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Pedidos</h1>
        <p class="text-muted mb-0">Fluxo principal do sistema: cliente, peças, serviço, valor, pagamento e acompanhamento.</p>
    </div>
    <a href="/pedidos/novo" class="btn btn-primary">Novo pedido</a>
</div>

<form method="get" action="/pedidos" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="text" name="q" class="form-control" placeholder="Pesquisar por código ou estado" value="<?= htmlspecialchars($q ?? '') ?>">
    </div>
    <div class="col-md-4">
        <button class="btn btn-outline-secondary w-100" type="submit">Pesquisar</button>
    </div>
</form>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h2 class="h5 mb-3">Lista de pedidos</h2>
        <?php if (!empty($pedidos)): ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Valor</th>
                            <th>Entrega prevista</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= (int) $pedido->getId() ?></td>
                                <td><?= htmlspecialchars($clientesById[(int)$pedido->getClienteId()]->getNome() ?? $pedido->getClienteId()) ?></td>
                                <td><span class="badge bg-info-subtle text-info-emphasis"><?= htmlspecialchars($pedido->getStatus()) ?></span></td>
                                <td>AOA <?= number_format($pedido->getValorTotal(), 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($pedido->getDataEntregaPrevista()) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted mb-0">Ainda não existem pedidos registados.</p>
        <?php endif; ?>
    </div>
</div>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
