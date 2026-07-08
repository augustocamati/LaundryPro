<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Relatórios de pagamentos</h1>
        <p class="text-muted mb-0">Resumo simples de pagamentos registados.</p>
    </div>
    <a href="/pagamentos" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="d-flex justify-content-end mb-3">
    <a href="/pagamentos/relatorios/pdf" class="btn btn-primary me-2">Baixar PDF</a>
    <a href="/pagamentos" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="h6 text-muted">Total pago</h2>
                <div class="display-6">AOA <?= number_format(array_sum(array_map(fn($p) => $p->getStatus() === 'Pago' ? $p->getValor() : 0, $pagamentos)), 2, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="h6 text-muted">Pendentes</h2>
                <div class="display-6"><?= count(array_filter($pagamentos, fn($p) => $p->getStatus() === 'Pendente')) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="h6 text-muted">Cancelados</h2>
                <div class="display-6"><?= count(array_filter($pagamentos, fn($p) => $p->getStatus() === 'Cancelado')) ?></div>
            </div>
        </div>
    </div>
</div>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
