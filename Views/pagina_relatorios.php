<?php
include_once './header.php';

$update_xml_no_bd = isset($_GET['update']) ? $_GET['update'] : 0;
?>

<div class="container">

    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="pagina_gestor.php">Home</a></li>
        </ul>
        <hr>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <H3>
                    Relatórios disponíveis
                </H3>
            </div>
        </div>
        <div class="clearfix"><br></div>
    </div>

    <div class="col-md-12">
        <div class="col-md-4">
            <div class="card">
                <h4 class="card-header">Limite de Quantitativo</h4>
                <div class="card-body">
                    <!--<h5 class="card-title">Special title treatment</h5>-->
                    <p class="card-text">Documento destinado a exibir os militares que possuem ou possuirão interstício mínimo para a próxima promoção.</p>
                    <a href="../Controllers/gera_limite_quantitativo.php" class="btn btn-primary">Gerar Relatório</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h4 class="card-header">Limite de Quantitativo</h4>
                <div class="card-body">
                    <!--<h5 class="card-title">Special title treatment</h5>-->
                    <p class="card-text">Documento destinado a exibir os militares que possuem ou possuirão interstício mínimo para a próxima promoção.</p>
                    <a href="#" class="btn btn-primary">Gerar Relatório</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h4 class="card-header">Limite de Quantitativo</h4>
                <div class="card-body">
                    <!--<h5 class="card-title">Special title treatment</h5>-->
                    <p class="card-text">Documento destinado a exibir os militares que possuem ou possuirão interstício mínimo para a próxima promoção.</p>
                    <a href="#" class="btn btn-primary">Gerar Relatório</a>
                </div>
            </div>
        </div>

    </div>
</div>


<?php
include_once './footer.php';
?>