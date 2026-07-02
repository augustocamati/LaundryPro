<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Editar Funcionário</h1>
    <a href="/funcionarios" class="btn btn-secondary">< Voltar</a>
</div>

<div class="card">
    <form action="/funcionarios/<?= $funcionario->getId() ?>" method="POST">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="usuario_id">Conta de Usuário Vinculada *</label>
                <select id="usuario_id" name="usuario_id" class="form-control" required>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario->getId() ?>" <?= $usuario->getId() === $funcionario->getUsuarioId() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($usuario->getNome()) ?> (<?= htmlspecialchars($usuario->getEmail()) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="cargo">Cargo / Função *</label>
                <input type="text" id="cargo" name="cargo" class="form-control" value="<?= htmlspecialchars($funcionario->getCargo()) ?>" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="salario">Salário Mensal (AOA) *</label>
                <input type="number" id="salario" name="salario" step="0.01" class="form-control" value="<?= htmlspecialchars($funcionario->getSalario()) ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="data_admissao">Data de Admissão *</label>
                <input type="date" id="data_admissao" name="data_admissao" class="form-control" value="<?= htmlspecialchars($funcionario->getDataAdmissao()) ?>" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Funcionário</button>
    </form>
</div>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
