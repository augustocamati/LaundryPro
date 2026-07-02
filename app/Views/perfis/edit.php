<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Editar Perfil: <?= htmlspecialchars($perfil->getNome()) ?></h1>
    <a href="/perfis" class="btn btn-secondary">< Voltar</a>
</div>

<div class="card">
    <form action="/perfis/<?= $perfil->getId() ?>" method="POST">
        <div class="form-group">
            <label class="form-label" for="nome">Nome do Perfil *</label>
            <input type="text" id="nome" name="nome" class="form-control" value="<?= htmlspecialchars($perfil->getNome()) ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4"><?= htmlspecialchars($perfil->getDescricao() ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
    </form>
</div>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
