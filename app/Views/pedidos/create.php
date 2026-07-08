<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Novo pedido</h1>
        <p class="text-muted mb-0">Cliente → peças → serviço → valor → pagamento → recibo → acompanhamento.</p>
    </div>
    <a href="/pedidos" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="post" action="/pedidos" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <select id="cliente_id" name="cliente_id" class="form-select" required>
                        <option value="">Selecione um cliente</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= (int) $cliente->getId() ?>"><?= htmlspecialchars($cliente->getNome()) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="servico_id" class="form-label">Serviço</label>
                    <select id="servico_id" name="servico_id" class="form-select" required>
                        <option value="">Selecione um serviço</option>
                        <?php foreach ($servicos as $servico): ?>
                            <option value="<?= (int) $servico->getId() ?>" data-preco="<?= (float) $servico->getPreco() ?>">
                                <?= htmlspecialchars($servico->getNome()) ?> - AOA <?= number_format($servico->getPreco(), 2, ',', '.') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="kilos" class="form-label">Peso (kg)</label>
                    <input id="kilos" name="kilos" type="number" min="0.1" step="0.01" value="1" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Valor estimado</label>
                    <div class="form-control bg-light" id="valorEstimado">AOA 0,00</div>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Estado do pedido</label>
                    <select id="status" name="status" class="form-select">
                        <option value="Pendente">Pendente</option>
                        <option value="Pago">Pago</option>
                        <option value="Cancelado">Cancelado</option>
                        <option value="Estornado">Estornado</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="observacoes" class="form-label">Observações</label>
                    <input id="observacoes" name="observacoes" type="text" class="form-control" placeholder="Ex.: roupa delicada">
                </div>
            </div>

            <div class="row g-3 mt-4">
                <div class="col-md-4">
                    <label for="estado_pagamento" class="form-label">Estado do pagamento</label>
                    <select id="estado_pagamento" name="estado_pagamento" class="form-select">
                        <option value="Pendente">Pendente</option>
                        <option value="Pago">Pago</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label for="documento" class="form-label">Documento (opcional)</label>
                    <input id="documento" name="documento" type="file" accept="image/*,application/pdf" class="form-control">
                </div>
            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar pedido</button>
                <button type="reset" class="btn btn-outline-secondary">Limpar</button>
            </div>
        </form>
    </div>
</div>

<script>
    const selectServico = document.getElementById('servico_id');
    const quantidadeInput = document.getElementById('kilos');
    const valorEstimado = document.getElementById('valorEstimado');

    function atualizarValor() {
        const selected = selectServico.selectedOptions[0];
        const preco = parseFloat(selected?.dataset.preco || '0');
        const quantidade = parseFloat(quantidadeInput.value || '1');
        const total = preco * quantidade; // price per kilo
        valorEstimado.textContent = 'AOA ' + total.toFixed(2).replace('.', ',');
    }

    selectServico.addEventListener('change', atualizarValor);
    quantidadeInput.addEventListener('input', atualizarValor);
    atualizarValor();
</script>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
