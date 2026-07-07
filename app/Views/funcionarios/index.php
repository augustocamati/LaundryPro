<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Funcionários Registados</h1>
    <a href="/funcionarios/novo" class="btn btn-primary">+ Novo Funcionário</a>
</div>

<form method="get" action="/funcionarios" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="text" name="q" class="form-control" placeholder="Pesquisar por nome ou cargo" value="<?= htmlspecialchars($q ?? '') ?>">
    </div>
    <div class="col-md-4">
        <button class="btn btn-outline-secondary w-100" type="submit">Pesquisar</button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Funcionário</th>
                    <th>Cargo / Função</th>
                    <th>Salário (AOA)</th>
                    <th>Data de Admissão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($funcionarios)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">Nenhum funcionário registado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($funcionarios as $funcionario): ?>
                        <?php 
                            $usuarioObj = $usuarioDAO->find($funcionario->getUsuarioId());
                            $usuarioNome = $usuarioObj ? $usuarioObj->getNome() : 'Conta Eliminada';
                        ?>
                        <tr>
                            <td><?= $funcionario->getId() ?></td>
                            <td><strong><?= htmlspecialchars($usuarioNome) ?></strong></td>
                            <td><?= htmlspecialchars($funcionario->getCargo()) ?></td>
                            <td><?= number_format($funcionario->getSalario(), 2, ',', '.') ?> Kz</td>
                            <td><?= date('d/m/Y', strtotime($funcionario->getDataAdmissao())) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="/funcionarios/<?= $funcionario->getId() ?>/editar" class="btn btn-secondary btn-sm">Editar</a>
                                    <form action="/funcionarios/<?= $funcionario->getId() ?>/eliminar" method="POST" onsubmit="return confirm('Deseja realmente eliminar este funcionário?');" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
