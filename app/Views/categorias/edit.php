<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Editar categoria</h1>
        <p class="text-muted mb-0">Atualize os detalhes da categoria.</p>
    </div>
    <a href="/categorias" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="post" action="/categorias/<?= (int) $categoria->getId() ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input id="nome" name="nome" type="text" class="form-control" value="<?= htmlspecialchars($categoria->getNome()) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="3"><?= htmlspecialchars($categoria->getDescricao() ?? '') ?></textarea>
            </div>
            <button class="btn btn-primary" type="submit">Guardar alterações</button>
        </form>
    </div>
</div>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
