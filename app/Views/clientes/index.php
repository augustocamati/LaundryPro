<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Clientes Cadastrados</h1>
    <a href="/clientes/novo" class="btn btn-primary">+ Novo Cliente</a>
</div>

<form method="get" action="/clientes" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="text" name="q" class="form-control" placeholder="Pesquisar por nome, telefone, e-mail ou BI" value="<?= htmlspecialchars($q ?? '') ?>">
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
