<?php
include_once './header2.php';
include_once '../Controllers/verifica_permissoes.php';
?>

<div class="container">

    <div class="clearfix"></div>

    <div class="col-md-12">
        <H3>
            Relatórios disponíveis
        </H3>
        <div class="clearfix"><br></div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header">Registros de promoções</h4>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Selecione o militar e confira os <strong>registros passados</strong> de promoção</strong>.</p>
                        <a href="listar_militares_relatorio_de_promocoes.php" class="btn btn-primary">Selecionar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
            </div>
            <div class="col-md-4">
            </div>

        </div>
        
        <div class="clearfix"></br></div>

        <div class="row">
        </div>
    </div>
</div>


<?php
include_once './footer.php';
?>