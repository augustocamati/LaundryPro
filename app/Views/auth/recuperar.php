<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Recuperar palavra-passe') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm border-0" style="width: min(480px, 100%);">
        <div class="card-body p-4 p-md-5">
            <h1 class="h3 mb-2">Recuperar palavra-passe</h1>
            <p class="text-muted mb-4">Informe o seu e-mail para receber um link de recuperação (simulado).</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="post" action="/recuperar-senha">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input id="email" name="email" type="email" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Enviar instruções</button>
            </form>

            <div class="mt-3 small"><a href="/login" class="text-decoration-none">Voltar para o login</a></div>
        </div>
    </div>
</div>
</body>
</html>
