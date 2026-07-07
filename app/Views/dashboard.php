<?php require 'partials/header.php'; ?>

<h1>Painel de Controle</h1>

<?php if (isset($dbError) && $dbError): ?>
    <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
        <strong>Alerta de Configuração:</strong> <?= htmlspecialchars($dbError) ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 14px; font-weight: 600; text-transform: uppercase;">Clientes</p>
            <h2 style="font-size: 36px; margin-top: 10px; font-weight: bold;"><?= $totalClientes ?></h2>
        </div>
        <div style="font-size: 40px;">👤</div>
    </div>
    <div class="card" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 14px; font-weight: 600; text-transform: uppercase;">Pedidos hoje</p>
            <h2 style="font-size: 36px; margin-top: 10px; font-weight: bold;"><?= $pedidosHoje ?></h2>
        </div>
        <div style="font-size: 40px;">🧺</div>
    </div>
    <div class="card" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 14px; font-weight: 600; text-transform: uppercase;">Pendentes</p>
            <h2 style="font-size: 36px; margin-top: 10px; font-weight: bold;"><?= $pedidosPendentes ?></h2>
        </div>
        <div style="font-size: 40px;">⏳</div>
    </div>
    <div class="card" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 14px; font-weight: 600; text-transform: uppercase;">Faturação</p>
            <h2 style="font-size: 28px; margin-top: 10px; font-weight: bold;">AOA <?= number_format($faturacaoMes, 2, ',', '.') ?></h2>
        </div>
        <div style="font-size: 40px;">💰</div>
    </div>
</div>

<div class="card" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h2>Faturação mensal</h2>
        <span class="badge badge-success">Últimos 6 meses</span>
    </div>
    <?php if (!empty($graficoLabels)): ?>
        <div style="display:flex; align-items:flex-end; gap: 12px; min-height: 220px;">
            <?php for ($i = 0; $i < count($graficoLabels); $i++): ?>
                <?php $value = (float) ($graficoData[$i] ?? 0); $height = $value > 0 ? min(100, 18 + ($value / max(1, max($graficoData))) * 70) : 12; ?>
                <div style="flex: 1; display:flex; flex-direction:column; align-items:center; gap: 8px;">
                    <div style="width: 100%; min-height: 150px; display:flex; align-items:flex-end; justify-content:center;">
                        <div style="width: 100%; max-width: 44px; height: <?= $height ?>%; background: linear-gradient(180deg, #60a5fa 0%, #2563eb 100%); border-radius: 8px 8px 0 0;"></div>
                    </div>
                    <div style="font-size: 12px; color: var(--text-muted); text-align:center;"><?= htmlspecialchars($graficoLabels[$i]) ?><br><strong><?= number_format($value, 2, ',', '.') ?></strong></div>
                </div>
            <?php endfor; ?>
        </div>
    <?php else: ?>
        <p style="color: var(--text-muted);">Ainda não existem dados de faturação para exibir.</p>
    <?php endif; ?>
</div>

<div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 24px;">
    <div class="card" style="margin-bottom: 0;">
        <h2 style="margin-bottom: 16px;">Últimos pedidos</h2>
        <?php if (!empty($ultimosPedidos)): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ultimosPedidos as $pedido): ?>
                            <tr>
                                <td><?= (int) ($pedido['id'] ?? 0) ?></td>
                                <td><?= htmlspecialchars($pedido['cliente_nome'] ?? 'Cliente') ?></td>
                                <td><span class="badge badge-info"><?= htmlspecialchars($pedido['status'] ?? '-') ?></span></td>
                                <td>AOA <?= number_format((float) ($pedido['valor_total'] ?? 0), 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p style="color: var(--text-muted);">Ainda não há pedidos registados.</p>
        <?php endif; ?>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <h2 style="margin-bottom: 16px;">Pedidos prontos</h2>
        <?php if (!empty($pedidosProntos)): ?>
            <ul style="list-style:none; display:flex; flex-direction:column; gap: 12px;">
                <?php foreach ($pedidosProntos as $pedido): ?>
                    <li style="border: 1px solid var(--border); border-radius: 8px; padding: 12px 14px;">
                        <strong><?= htmlspecialchars($pedido['cliente_nome'] ?? 'Cliente') ?></strong>
                        <div style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Entrega prevista: <?= htmlspecialchars($pedido['data_entrega_prevista'] ?? '-') ?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p style="color: var(--text-muted);">Não há pedidos prontos no momento.</p>
        <?php endif; ?>
    </div>
</div>

<?php require 'partials/footer.php'; ?>
