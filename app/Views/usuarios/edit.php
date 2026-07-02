<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Editar Usuário: <?= htmlspecialchars($usuario->getNome()) ?></h1>
    <a href="/usuarios" class="btn btn-secondary">< Voltar</a>
</div>

<div class="card">
    <form action="/usuarios/<?= $usuario->getId() ?>" method="POST">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="nome">Nome Completo *</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?= htmlspecialchars($usuario->getNome()) ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">E-mail *</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario->getEmail()) ?>" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="senha">Palavra-passe (Deixe em branco para manter a atual)</label>
                <input type="password" id="senha" name="senha" class="form-control">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control" value="<?= htmlspecialchars($usuario->getTelefone() ?? '') ?>">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="perfil_id">Perfil de Acesso *</label>
                <select id="perfil_id" name="perfil_id" class="form-control" required>
                    <?php foreach ($perfis as $perfil): ?>
                        <option value="<?= $perfil->getId() ?>" <?= $perfil->getId() === $usuario->getPerfilId() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($perfil->getNome()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Estado</label>
                <select id="status" name="status" class="form-control">
                    <option value="ativo" <?= $usuario->getStatus() === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                    <option value="inativo" <?= $usuario->getStatus() === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
    </form>
</div>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
