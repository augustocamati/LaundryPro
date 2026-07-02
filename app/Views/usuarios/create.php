<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Criar Novo Usuário</h1>
    <a href="/usuarios" class="btn btn-secondary">< Voltar</a>
</div>

<div class="card">
    <form action="/usuarios" method="POST">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="nome">Nome Completo *</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Ex: António Manuel" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">E-mail *</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="exemplo@laundry.co.ao" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="senha">Palavra-passe *</label>
                <input type="password" id="senha" name="senha" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control" placeholder="Ex: +244 923 000 000">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="perfil_id">Perfil de Acesso *</label>
                <select id="perfil_id" name="perfil_id" class="form-control" required>
                    <option value="">Selecione um Perfil</option>
                    <?php foreach ($perfis as $perfil): ?>
                        <option value="<?= $perfil->getId() ?>"><?= htmlspecialchars($perfil->getNome()) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (empty($perfis)): ?>
                    <small style="color: var(--danger);">* Nenhum perfil cadastrado. Crie um perfil primeiro em <a href="/perfis/novo">Perfis</a>.</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Estado</label>
                <select id="status" name="status" class="form-control">
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" <?= empty($perfis) ? 'disabled' : '' ?>>Salvar Usuário</button>
    </form>
</div>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
