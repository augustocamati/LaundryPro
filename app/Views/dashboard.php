<?php require 'partials/header.php'; ?>

<h1>Painel de Controle</h1>

<?php if (isset($dbError) && $dbError): ?>
    <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
        <strong>Alerta de Configuração:</strong> <?= htmlspecialchars($dbError) ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">
    
    <!-- Card Usuários -->
    <div class="card" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 14px; font-weight: 600; text-transform: uppercase;">Usuários Registados</p>
            <h2 style="font-size: 36px; margin-top: 10px; font-weight: bold;"><?= $totalUsuarios ?></h2>
        </div>
        <div style="font-size: 40px;">👥</div>
    </div>

    <!-- Card Funcionários -->
    <div class="card" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 14px; font-weight: 600; text-transform: uppercase;">Funcionários</p>
            <h2 style="font-size: 36px; margin-top: 10px; font-weight: bold;"><?= $totalFuncionarios ?></h2>
        </div>
        <div style="font-size: 40px;">💼</div>
    </div>

    <!-- Card Clientes -->
    <div class="card" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 14px; font-weight: 600; text-transform: uppercase;">Clientes Cadastrados</p>
            <h2 style="font-size: 36px; margin-top: 10px; font-weight: bold;"><?= $totalClientes ?></h2>
        </div>
        <div style="font-size: 40px;">👤</div>
    </div>

</div>

<div class="card">
    <h2 style="margin-bottom: 10px;">Bem-vindo ao LaundryPro 🇦🇴</h2>
    <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: 15px;">
        Este é o sistema de gestão de lavandarias personalizado para o mercado de Angola. A arquitetura foi desenvolvida utilizando o padrão **DAO (Data Access Object)** para persistência de dados e **Entity Models** puras para representação de dados.
    </p>
    <p style="color: var(--text-muted); line-height: 1.6;">
        Utilize o menu lateral para navegar e realizar as operações de <strong>CRUD</strong> de Perfis, Usuários, Funcionários e Clientes.
    </p>
</div>

<?php require 'partials/footer.php'; ?>
