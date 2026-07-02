<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Perfis de Acesso</h1>
    <a href="/perfis/novo" class="btn btn-primary">+ Novo Perfil</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Perfil</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($perfis)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted);">Nenhum perfil registado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($perfis as $perfil): ?>
                        <tr>
                            <td><?= $perfil->getId() ?></td>
                            <td><strong><?= htmlspecialchars($perfil->getNome()) ?></strong></td>
                            <td><?= htmlspecialchars($perfil->getDescricao() ?? '') ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="/perfis/<?= $perfil->getId() ?>/editar" class="btn btn-secondary btn-sm">Editar</a>
                                    <form action="/perfis/<?= $perfil->getId() ?>/eliminar" method="POST" onsubmit="return confirm('Deseja realmente eliminar este perfil?');" style="display:inline;">
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
