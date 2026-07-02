<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Usuários do Sistema</h1>
    <a href="/usuarios/novo" class="btn btn-primary">+ Novo Usuário</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Perfil</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted);">Nenhum usuário registado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <?php 
                            $perfilObj = $perfilDAO->find($usuario->getPerfilId());
                            $perfilNome = $perfilObj ? $perfilObj->getNome() : 'Desconhecido';
                        ?>
                        <tr>
                            <td><?= $usuario->getId() ?></td>
                            <td><strong><?= htmlspecialchars($usuario->getNome()) ?></strong></td>
                            <td><?= htmlspecialchars($usuario->getEmail()) ?></td>
                            <td><?= htmlspecialchars($usuario->getTelefone() ?? '-') ?></td>
                            <td><span class="badge badge-info"><?= htmlspecialchars($perfilNome) ?></span></td>
                            <td>
                                <?php if ($usuario->getStatus() === 'ativo'): ?>
                                    <span class="badge badge-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="/usuarios/<?= $usuario->getId() ?>/editar" class="btn btn-secondary btn-sm">Editar</a>
                                    <form action="/usuarios/<?= $usuario->getId() ?>/eliminar" method="POST" onsubmit="return confirm('Deseja realmente eliminar este usuário?');" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
