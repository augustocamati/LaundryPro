<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Serviços</h1>
        <p class="text-muted mb-0">Gerencie os serviços disponíveis, preços e tempos estimados.</p>
    </div>
    <a href="/servicos/novo" class="btn btn-primary">Novo serviço</a>
</div>

<form method="get" action="/servicos" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="text" name="q" class="form-control" placeholder="Pesquisar por nome, descrição ou categoria" value="<?= htmlspecialchars($q ?? '') ?>">
    </div>
    <div class="col-md-4">
        <button class="btn btn-outline-secondary w-100" type="submit">Pesquisar</button>
    </div>
</form>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <?php if (!empty($servicos)): ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Serviço</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Prazo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($servicos as $servico): ?>
                            <tr>
                                <td><?= (int) $servico->getId() ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($servico->getNome()) ?></strong>
                                    <div class="text-muted small"><?= htmlspecialchars($servico->getDescricao() ?? '') ?></div>
                                </td>
                                <td><?= isset($categoriasById[$servico->getCategoriaId()]) ? htmlspecialchars($categoriasById[$servico->getCategoriaId()]->getNome()) : '-' ?></td>
                                <td>AOA <?= number_format($servico->getPreco(), 2, ',', '.') ?></td>
                                <td><?= (int) $servico->getPrazoDias() ?> dia(s)</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/servicos/<?= (int) $servico->getId() ?>/editar" class="btn btn-sm btn-outline-secondary">Editar</a>
                                        <form action="/servicos/<?= (int) $servico->getId() ?>/eliminar" method="post" onsubmit="return confirm('Eliminar este serviço?');">
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
            <p class="text-muted mb-0">Ainda não existem serviços.</p>
        <?php endif; ?>
    </div>
</div>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
