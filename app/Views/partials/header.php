<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'LaundryPro' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            min-height: 100vh;
        }
        .sidebar {
            min-height: 100vh;
            background: #0f172a;
        }
        .sidebar .nav-link {
            color: #cbd5e1;
            border-radius: 0.5rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #1e293b;
            color: #fff;
        }
        .navbar-brand { font-weight: 700; }
        .card { border: 1px solid #e2e8f0; box-shadow: 0 0.125rem 0.75rem rgba(15, 23, 42, 0.06); }
        .table thead { background: #f8fafc; }
    </style>
</head>
<body>
    <div class="d-flex">
        <aside class="sidebar p-3" style="width: 260px;">
            <div class="navbar-brand text-white mb-4 fs-4">LaundryPro <span>🇦🇴</span></div>
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item"><a class="nav-link <?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>" href="/">Painel Geral</a></li>
                <li class="nav-item"><a class="nav-link <?= ($activePage ?? '') === 'perfis' ? 'active' : '' ?>" href="/perfis">Perfis / Cargos</a></li>
                <li class="nav-item"><a class="nav-link <?= ($activePage ?? '') === 'usuarios' ? 'active' : '' ?>" href="/usuarios">Usuários</a></li>
                <li class="nav-item"><a class="nav-link <?= ($activePage ?? '') === 'funcionarios' ? 'active' : '' ?>" href="/funcionarios">Funcionários</a></li>
                <li class="nav-item"><a class="nav-link <?= ($activePage ?? '') === 'clientes' ? 'active' : '' ?>" href="/clientes">Clientes</a></li>
                <li class="nav-item"><a class="nav-link <?= ($activePage ?? '') === 'categorias' ? 'active' : '' ?>" href="/categorias">Categorias</a></li>
                <li class="nav-item"><a class="nav-link <?= ($activePage ?? '') === 'servicos' ? 'active' : '' ?>" href="/servicos">Serviços</a></li>
                <li class="nav-item"><a class="nav-link <?= ($activePage ?? '') === 'pesquisas' ? 'active' : '' ?>" href="/pesquisas">Pesquisas</a></li>
                <li class="nav-item"><a class="nav-link <?= ($activePage ?? '') === 'pagamentos' ? 'active' : '' ?>" href="/pagamentos">Pagamentos</a></li>
                <li class="nav-item"><a class="nav-link <?= ($activePage ?? '') === 'pedidos' ? 'active' : '' ?>" href="/pedidos">Pedidos</a></li>
            </ul>
        </aside>
        <main class="flex-grow-1">
            <nav class="navbar navbar-light bg-white border-bottom px-4 py-3">
                <div class="navbar-brand mb-0 h1">Sistema de Lavanderia - Angola</div>
                <div class="d-flex align-items-center gap-2">
                    <?php if (\App\Core\Auth::check()): ?>
                        <span class="badge bg-primary-subtle text-primary-emphasis">Olá, <?= htmlspecialchars(\App\Core\Auth::nome() ?? 'Utilizador') ?></span>
                        <a href="/logout" class="btn btn-outline-danger btn-sm">Sair</a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-primary btn-sm">Entrar</a>
                    <?php endif; ?>
                </div>
            </nav>
            <div class="container-fluid p-4">
