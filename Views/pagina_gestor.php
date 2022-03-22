<?php
include_once './header.php';
// include_once '../Controllers/verifica_permissoes.php';
// $update_xml_no_bd = isset($_GET['update']) ? $_GET['update'] : 0;
?>

<div class="container">

    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="pagina_ferramentas.php">Ferramentas</a></li>
            <li role="presentation" class="active"><a href="pagina_relatorios.php">Relatórios</a></li>
        </ul>
        <hr>
    </div>
    <div class="clearfix">

    </div>
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <h3>SAP - CBMMT</h3><br>               
        <h4>Pesquisar militar</h4>
        <form class="navbar-form navbar-left" method="GET" action="../Views/listar_militares.php">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Digite o nome" name="pesquisar">
            </div>
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>
    </div>

    <div class="col-md-4"></div>

    <div class="clearfix"></div>
    <br />
    <div class="col-md-4"></div>
    <div class = "col-md-4"></div>
    <div class = "col-md-4"></div>

</div>

<?php
include_once './footer.php';
?>