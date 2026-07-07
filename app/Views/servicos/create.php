<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Novo serviço</h1>
        <p class="text-muted mb-0">Cadastre um novo serviço com preço e prazo estimado.</p>
    </div>
    <a href="/servicos" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="post" action="/servicos">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome</label>
                    <input id="nome" name="nome" type="text" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="categoria_id" class="form-label">Categoria</label>
                    <select id="categoria_id" name="categoria_id" class="form-select" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= (int) $categoria->getId() ?>"><?= htmlspecialchars($categoria->getNome()) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="preco" class="form-label">Preço (AOA)</label>
                    <input id="preco" name="preco" type="number" min="0" step="0.01" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="prazo_dias" class="form-label">Tempo estimado (dias)</label>
                    <input id="prazo_dias" name="prazo_dias" type="number" min="1" value="1" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <button class="btn btn-primary mt-4" type="submit">Guardar</button>
        </form>
    </div>
</div>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
