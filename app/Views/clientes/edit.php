<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Editar Cliente: <?= htmlspecialchars($cliente->getNome()) ?></h1>
    <a href="/clientes" class="btn btn-secondary">< Voltar</a>
</div>

    <div class="card">
    <form action="/clientes/<?= $cliente->getId() ?>" method="POST" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="nome">Nome Completo *</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?= htmlspecialchars($cliente->getNome()) ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="bi">Bilhete de Identidade (BI)</label>
                <input type="text" id="bi" name="bi" class="form-control" value="<?= htmlspecialchars($cliente->getBi() ?? '') ?>" placeholder="Ex: 001234567LA012">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="telefone">Telefone *</label>
                <input type="text" id="telefone" name="telefone" class="form-control" value="<?= htmlspecialchars($cliente->getTelefone()) ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente->getEmail() ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="endereco">Endereço de Residência</label>
            <input type="text" id="endereco" name="endereco" class="form-control" value="<?= htmlspecialchars($cliente->getEndereco() ?? '') ?>" placeholder="Ex: Bairro Alvalade, Luanda">
        </div>

        <div class="form-group">
            <label class="form-label" for="documento">Documento (BI ou comprovante) - opcional</label>
            <?php if ($cliente->getDocumentPath()): ?>
                <div class="mb-2"><a href="<?= htmlspecialchars($cliente->getDocumentPath()) ?>" target="_blank">Ver documento atual</a></div>
            <?php endif; ?>
            <input type="file" id="documento" name="documento" accept="image/*,application/pdf" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Cliente</button>
    </form>
</div>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
