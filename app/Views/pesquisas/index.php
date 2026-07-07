<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Pesquisas</h1>
        <p class="text-muted mb-0">Encontre pedidos por nome, código, telefone, estado, data ou categoria.</p>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="get" action="/pesquisas" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Campo</label>
                <select name="campo" class="form-select">
                    <option value="nome" <?= $campo === 'nome' ? 'selected' : '' ?>>Nome</option>
                    <option value="codigo" <?= $campo === 'codigo' ? 'selected' : '' ?>>Código</option>
                    <option value="telefone" <?= $campo === 'telefone' ? 'selected' : '' ?>>Telefone</option>
                    <option value="estado" <?= $campo === 'estado' ? 'selected' : '' ?>>Estado</option>
                    <option value="data" <?= $campo === 'data' ? 'selected' : '' ?>>Data</option>
                    <option value="categoria" <?= $campo === 'categoria' ? 'selected' : '' ?>>Categoria</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Termo</label>
                <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Ex.: Maria">
            </div>
            <div class="col-md-2">
                <label class="form-label">Estado</label>
                <select name="status" class="form-select">
                    <option value="">Todos</option>
                    <option value="Pendente" <?= $status === 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="Em Processamento" <?= $status === 'Em Processamento' ? 'selected' : '' ?>>Em Processamento</option>
                    <option value="Pronto" <?= $status === 'Pronto' ? 'selected' : '' ?>>Pronto</option>
                    <option value="Entregue" <?= $status === 'Entregue' ? 'selected' : '' ?>>Entregue</option>
                    <option value="Cancelado" <?= $status === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Data</label>
                <input type="date" name="data" class="form-control" value="<?= htmlspecialchars($data ?? '') ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Categoria</label>
                <select name="categoria" class="form-select">
                    <option value="">Todas</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= (int) $categoria->getId() ?>" <?= $categoriaId === (int) $categoria->getId() ? 'selected' : '' ?>><?= htmlspecialchars($categoria->getNome()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <?php if (!empty($resultados)): ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Telefone</th>
                            <th>Estado</th>
                            <th>Data</th>
                            <th>Categoria</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $resultado): ?>
                            <tr>
                                <td><?= (int) $resultado['id'] ?></td>
                                <td><?= htmlspecialchars($resultado['cliente_nome'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($resultado['cliente_telefone'] ?? '-') ?></td>
                                <td><span class="badge bg-info-subtle text-info-emphasis"><?= htmlspecialchars($resultado['status']) ?></span></td>
                                <td><?= htmlspecialchars($resultado['data_pedido']) ?></td>
                                <td>—</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted mb-0">Nenhum resultado encontrado.</p>
        <?php endif; ?>
    </div>
</div>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
