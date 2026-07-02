<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Contratar Novo Funcionário</h1>
    <a href="/funcionarios" class="btn btn-secondary">< Voltar</a>
</div>

<div class="card">
    <form action="/funcionarios" method="POST">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="usuario_id">Vincular a Conta de Usuário *</label>
                <select id="usuario_id" name="usuario_id" class="form-control" required>
                    <option value="">Selecione um Usuário</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario->getId() ?>"><?= htmlspecialchars($usuario->getNome()) ?> (<?= htmlspecialchars($usuario->getEmail()) ?>)</option>
                    <?php endforeach; ?>
                </select>
                <?php if (empty($usuarios)): ?>
                    <small style="color: var(--danger);">* Todos os usuários cadastrados já são funcionários ou não há usuários cadastrados. Crie um novo usuário primeiro em <a href="/usuarios/novo">Usuários</a>.</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="cargo">Cargo / Função *</label>
                <input type="text" id="cargo" name="cargo" class="form-control" placeholder="Ex: Atendente de Balcão, Lavador, Supervisor" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="salario">Salário Mensal (AOA) *</label>
                <input type="number" id="salario" name="salario" step="0.01" class="form-control" placeholder="Ex: 150000.00" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="data_admissao">Data de Admissão *</label>
                <input type="date" id="data_admissao" name="data_admissao" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" <?= empty($usuarios) ? 'disabled' : '' ?>>Salvar Funcionário</button>
    </form>
</div>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
