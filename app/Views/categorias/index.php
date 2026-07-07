<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Categorias</h1>
        <p class="text-muted mb-0">Organize os serviços por tipo.</p>
    </div>
    <a href="/categorias/novo" class="btn btn-primary">Nova categoria</a>
</div>

<form method="get" action="/categorias" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="text" name="q" class="form-control" placeholder="Pesquisar por nome ou descrição" value="<?= htmlspecialchars($q ?? '') ?>">
    </div>
    <div class="col-md-4">
        <button class="btn btn-outline-secondary w-100" type="submit">Pesquisar</button>
    </div>
</form>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <?php if (!empty($categorias)): ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td><?= (int) $categoria->getId() ?></td>
                                <td><?= htmlspecialchars($categoria->getNome()) ?></td>
                                <td><?= htmlspecialchars($categoria->getDescricao() ?? '-') ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/categorias/<?= (int) $categoria->getId() ?>/editar" class="btn btn-sm btn-outline-secondary">Editar</a>
                                        <form action="/categorias/<?= (int) $categoria->getId() ?>/eliminar" method="post" onsubmit="return confirm('Eliminar esta categoria?');">
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted mb-0">Ainda não existem categorias.</p>
        <?php endif; ?>
    </div>
</div>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
