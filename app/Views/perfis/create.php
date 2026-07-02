<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Criar Novo Perfil</h1>
    <a href="/perfis" class="btn btn-secondary">< Voltar</a>
</div>

<div class="card">
    <form action="/perfis" method="POST">
        <div class="form-group">
            <label class="form-label" for="nome">Nome do Perfil *</label>
            <input type="text" id="nome" name="nome" class="form-control" placeholder="Ex: Administrador, Operador, Recepcionista" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4" placeholder="Breve resumo das permissões e funções deste perfil..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Perfil</button>
    </form>
</div>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
