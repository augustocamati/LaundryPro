<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Clientes Cadastrados</h1>
    <a href="/clientes/novo" class="btn btn-primary">+ Novo Cliente</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>BI (Identidade)</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clientes)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted);">Nenhum cliente cadastrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= $cliente->getId() ?></td>
                            <td><strong><?= htmlspecialchars($cliente->getNome()) ?></strong></td>
                            <td><?= htmlspecialchars($cliente->getBi() ?? '-') ?></td>
                            <td><?= htmlspecialchars($cliente->getTelefone()) ?></td>
                            <td><?= htmlspecialchars($cliente->getEmail() ?? '-') ?></td>
                            <td><?= htmlspecialchars($cliente->getEndereco() ?? '-') ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="/clientes/<?= $cliente->getId() ?>/editar" class="btn btn-secondary btn-sm">Editar</a>
                                    <form action="/clientes/<?= $cliente->getId() ?>/eliminar" method="POST" onsubmit="return confirm('Deseja realmente eliminar este cliente?');" style="display:inline;">
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
