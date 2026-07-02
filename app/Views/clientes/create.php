<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<div class="flex-container">
    <h1>Cadastrar Novo Cliente</h1>
    <a href="/clientes" class="btn btn-secondary">< Voltar</a>
</div>

<div class="card">
    <form action="/clientes" method="POST">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="nome">Nome Completo *</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Ex: Francisco João" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="bi">Bilhete de Identidade (BI)</label>
                <input type="text" id="bi" name="bi" class="form-control" placeholder="Ex: 001234567LA012">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="telefone">Telefone *</label>
                <input type="text" id="telefone" name="telefone" class="form-control" placeholder="Ex: +244 923 000 000" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="cliente@provedor.ao">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="endereco">Endereço de Residência</label>
            <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Ex: Bairro Alvalade, Luanda">
        </div>

        <button type="submit" class="btn btn-primary">Salvar Cliente</button>
    </form>
</div>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
