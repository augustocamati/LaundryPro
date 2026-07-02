<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'LaundryPro' ?></title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --background: #f8fafc;
            --surface: #ffffff;
            --text: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--background); color: var(--text); display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 260px; background-color: #1e293b; color: white; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 24px; font-size: 20px; font-weight: bold; border-bottom: 1px solid #334155; display: flex; align-items: center; gap: 8px; }
        .sidebar-menu { list-style: none; padding: 20px 0; flex-grow: 1; }
        .sidebar-menu li a { display: block; padding: 12px 24px; color: #cbd5e1; text-decoration: none; font-size: 15px; transition: 0.2s; }
        .sidebar-menu li a:hover, .sidebar-menu li.active a { background-color: #334155; color: white; }
        
        /* Main Layout */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; }
        .navbar { height: 70px; background-color: var(--surface); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 30px; justify-content: space-between; }
        .container { padding: 30px; max-width: 1200px; width: 100%; margin: 0 auto; flex-grow: 1; }
        
        /* Typography */
        h1 { font-size: 28px; margin-bottom: 20px; color: var(--text); }
        h2 { font-size: 20px; color: var(--text); }
        
        /* Cards & Surfaces */
        .card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 24px; }
        
        /* Buttons */
        .btn { display: inline-flex; align-items: center; padding: 10px 18px; border-radius: 6px; font-size: 14px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: 0.2s; gap: 5px; }
        .btn-primary { background-color: var(--primary); color: white; }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .btn-secondary { background-color: #64748b; color: white; }
        .btn-secondary:hover { background-color: #475569; }
        .btn-danger { background-color: var(--danger); color: white; }
        .btn-danger:hover { background-color: #dc2626; }
        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 4px; }
        
        /* Tables */
        .table-responsive { width: 100%; overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { padding: 14px 16px; text-align: left; border-bottom: 1px solid var(--border); }
        .table th { background-color: #f1f5f9; color: var(--text-muted); font-weight: 600; font-size: 13px; text-transform: uppercase; }
        .table tr:hover { background-color: #f8fafc; }
        
        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: 600; color: #475569; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 6px; font-size: 14px; color: var(--text); }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        
        /* Badges */
        .badge { display: inline-flex; padding: 4px 8px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-info { background-color: #e0f2fe; color: #0369a1; }
        
        .flex-container { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-group { display: flex; gap: 8px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">LaundryPro <span>🇦🇴</span></div>
        <ul class="sidebar-menu">
            <li class="<?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>"><a href="/">Painel Geral</a></li>
            <li class="<?= ($activePage ?? '') === 'perfis' ? 'active' : '' ?>"><a href="/perfis">Perfis / Cargos</a></li>
            <li class="<?= ($activePage ?? '') === 'usuarios' ? 'active' : '' ?>"><a href="/usuarios">Usuários</a></li>
            <li class="<?= ($activePage ?? '') === 'funcionarios' ? 'active' : '' ?>"><a href="/funcionarios">Funcionários</a></li>
            <li class="<?= ($activePage ?? '') === 'clientes' ? 'active' : '' ?>"><a href="/clientes">Clientes</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="navbar">
            <h2>Sistema de Lavanderia - Angola</h2>
            <div>
                <span class="badge badge-info">Ambiente Local</span>
            </div>
        </div>
        <div class="container">
