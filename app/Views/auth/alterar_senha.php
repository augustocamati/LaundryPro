<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Alterar palavra-passe') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm border-0" style="width: min(480px, 100%);">
        <div class="card-body p-4 p-md-5">
            <h1 class="h3 mb-2">Alterar palavra-passe</h1>
            <p class="text-muted mb-4">Defina uma nova palavra-passe para continuar a usar o sistema.</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="post" action="/alterar-senha">
                <?php if (!empty($token)): ?>
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <?php endif; ?>
                <?php if (empty($token) && \App\Core\Auth::check()): ?>
                    <div class="mb-3">
                        <label for="senha_atual" class="form-label">Palavra-passe atual</label>
                        <input id="senha_atual" name="senha_atual" type="password" class="form-control" required>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="nova_senha" class="form-label">Nova palavra-passe</label>
                    <input id="nova_senha" name="nova_senha" type="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="confirmar_senha" class="form-label">Confirmar palavra-passe</label>
                    <input id="confirmar_senha" name="confirmar_senha" type="password" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Guardar palavra-passe</button>
            </form>

            <div class="mt-3 small"><a href="/login" class="text-decoration-none">Voltar para o login</a></div>
        </div>
    </div>
</div>
</body>
</html>
