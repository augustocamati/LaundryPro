<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Pagamentos</h1>
        <p class="text-muted mb-0">Registe, pesquise, cancele e acompanhe pagamentos.</p>
    </div>
    <?php if (\App\Core\Auth::isAdmin()): ?>
        <a href="/pagamentos/relatorios" class="btn btn-outline-secondary">Relatórios</a>
    <?php endif; ?>
</div>

<form method="get" action="/pagamentos" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="text" name="q" class="form-control" placeholder="Pesquisar por pedido, método ou estado" value="<?= htmlspecialchars($q ?? '') ?>">
    </div>
    <div class="col-md-4">
        <button class="btn btn-outline-secondary w-100" type="submit">Pesquisar</button>
    </div>
</form>

<?php if (!\App\Core\Auth::isOperador()): ?>
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h2 class="h5 mb-3">Registrar pagamento</h2>
        <form method="post" action="/pagamentos/registrar" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Pedido</label>
                <select id="pedido_select" name="pedido_id" class="form-select" required>
                    <option value="">Selecione</option>
                    <?php foreach ($pedidos as $pedido): ?>
                        <option value="<?= (int) $pedido->getId() ?>" data-valor="<?= number_format($pedido->getValorTotal(), 2, '.', '') ?>" data-cliente="<?= htmlspecialchars($clientesById[(int)$pedido->getClienteId()]->getNome() ?? '') ?>" data-status="<?= htmlspecialchars($pedido->getStatus()) ?>">#<?= (int) $pedido->getId() ?> - <?= htmlspecialchars($clientesById[(int)$pedido->getClienteId()]->getNome() ?? '') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Valor</label>
                <input id="valor_input" type="number" name="valor" class="form-control" min="0" step="0.01" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Cliente</label>
                <input id="cliente_nome" type="text" class="form-control" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">Método</label>
                <select name="metodo_pagamento" class="form-select">
                    <option>Dinheiro</option>
                    <option>Cartao_Credito</option>
                    <option>Cartao_Debito</option>
                    <option>Pix</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Estado</label>
                <select name="status" class="form-select">
                    <option>Pago</option>
                    <option>Pendente</option>
                    <option>Cancelado</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h2 class="h5 mb-3">Pagamentos registados</h2>
        <?php if (!empty($pagamentos)): ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pedido</th>
                            <th>Valor</th>
                            <th>Método</th>
                            <th>Status</th>
                            <?php if (!\App\Core\Auth::isOperador()): ?>
                                <th>Ações</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagamentos as $pagamento): ?>
                                <tr>
                                    <td><?= (int) $pagamento->getId() ?></td>
                                    <td>#<?= (int) $pagamento->getPedidoId() ?></td>
                                    <td><?= htmlspecialchars($clientesById[(int)$pedidosById[(int)$pagamento->getPedidoId()]->getClienteId()]->getNome() ?? '') ?></td>
                                    <td>AOA <?= number_format($pagamento->getValor(), 2, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($pagamento->getMetodoPagamento()) ?></td>
                                    <td><?= htmlspecialchars($pagamento->getStatus()) ?></td>
                                    <?php if (!\App\Core\Auth::isOperador()): ?>
                                        <td>
                                            <?php if ($pagamento->getStatus() !== 'Cancelado'): ?>
                                                <form action="/pagamentos/<?= (int) $pagamento->getId() ?>/cancelar" method="post" style="display:inline;">
                                                    <button class="btn btn-sm btn-outline-danger" type="submit">Cancelar</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted mb-0">Nenhum pagamento registado.</p>
        <?php endif; ?>
    </div>
</div>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

<script>
    (function () {
        const select = document.getElementById('pedido_select');
        const valorInput = document.getElementById('valor_input');
        const clienteNome = document.getElementById('cliente_nome');

        function preencher() {
            const opt = select.selectedOptions[0];
            if (!opt || !opt.value) {
                valorInput.value = '';
                clienteNome.value = '';
                return;
            }
            valorInput.value = opt.dataset.valor || '';
            clienteNome.value = opt.dataset.cliente || '';
        }

        select.addEventListener('change', preencher);
        preencher();
    })();
</script>
