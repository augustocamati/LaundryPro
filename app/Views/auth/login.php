<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Entrar - LaundryPro') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #eff6ff, #f8fafc); min-height: 100vh; }
    </style>
</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm border-0" style="width: min(420px, 100%);">
        <div class="card-body p-4 p-md-5">
            <h1 class="h3 mb-2">Entrar no LaundryPro</h1>
            <p class="text-muted mb-4">Gestão simples, rápida e segura da sua lavanderia.</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="post" action="/login">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input id="email" name="email" type="email" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Palavra-passe</label>
                    <input id="senha" name="senha" type="password" class="form-control" required>
                </div>
                <div class="form-check mb-3">
                    <input id="lembrar" name="lembrar" type="checkbox" class="form-check-input">
                    <label for="lembrar" class="form-check-label">Lembrar sessão</label>
                </div>
                <button class="btn btn-primary w-100" type="submit">Entrar</button>
            </form>

            <div class="d-flex justify-content-between mt-3 small">
                <a href="/recuperar-senha" class="text-decoration-none">Recuperar palavra-passe</a>
                <a href="/alterar-senha" class="text-decoration-none">Alterar palavra-passe</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
