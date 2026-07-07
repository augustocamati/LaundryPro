<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Editar serviço</h1>
        <p class="text-muted mb-0">Atualize preço, prazo e informações do serviço.</p>
    </div>
    <a href="/servicos" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="post" action="/servicos/<?= (int) $servico->getId() ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome</label>
                    <input id="nome" name="nome" type="text" class="form-control" value="<?= htmlspecialchars($servico->getNome()) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="categoria_id" class="form-label">Categoria</label>
                    <select id="categoria_id" name="categoria_id" class="form-select" required>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= (int) $categoria->getId() ?>" <?= (int) $categoria->getId() === (int) $servico->getCategoriaId() ? 'selected' : '' ?>><?= htmlspecialchars($categoria->getNome()) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="preco" class="form-label">Preço (AOA)</label>
                    <input id="preco" name="preco" type="number" min="0" step="0.01" class="form-control" value="<?= (float) $servico->getPreco() ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="prazo_dias" class="form-label">Tempo estimado (dias)</label>
                    <input id="prazo_dias" name="prazo_dias" type="number" min="1" class="form-control" value="<?= (int) $servico->getPrazoDias() ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="3"><?= htmlspecialchars($servico->getDescricao() ?? '') ?></textarea>
                </div>
            </div>
            <button class="btn btn-primary mt-4" type="submit">Guardar alterações</button>
        </form>
    </div>
</div>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
