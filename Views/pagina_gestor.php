<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills">
                <li role="presentation" class="nav-item"><a class="nav-link active" href="pagina_ferramentas.php">Ferramentas</a></li>
                <li role="presentation" class="active"><a class="nav-link active" style="margin-left: 10px;" href="pagina_relatorios.php">Relatórios</a></li>
            </ul>
            <hr>
        </div>
    </div>

    <div class="row g-3 align-items-center">
        <h1 class="display-6">Página inicial - perfil gestor</h1>
        <div class="col-md-4">
            <form class="navbar-form navbar-left" method="GET" action="../Views/listar_militares.php">
                <div class="mb-3">
                    <label for="InputNome" class="form-label">Acessar dados de candidato</label>
                    <input id="InputNome" type="text" class="form-control" placeholder="Digite o nome" name="pesquisar">
                    <div id="emailHelp" class="form-text">Insira o nome completo ou parte dele.</div>
                </div>
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>
    </div>
</div>

<?php
include_once './footer.php';
?>