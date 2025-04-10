<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';
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
                    <h4 class="card-header">Relatórios de promoções</h4>
                    <div class="card-body">
                        <h5 class="card-title">Promoções passadas</h5>
                        <p class="card-text">Selecione o militar e confira os <strong>registros passados</strong> de promoção</strong>.</p>
                        <a href="listar_militares_relatorio_de_promocoes.php" class="btn btn-primary">Selecionar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header">Documentos entregues</h4>
                    <div class="card-body">
                        <h5 class="card-title">Militares constantes no LQ</h5>
                        <p class="card-text">Relatório de documentação entregue à Secretaria das Comissões de Promoção (SCP)</strong>.</p>
                        <a href="selecao_criterios_de_pesquisa_LQ.php?relatorio=1" class="btn btn-primary">Selecionar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            <div class="card">
                    <h4 class="card-header">Documentos entregues (TC BM)</h4>
                    <div class="card-body">
                        <h5 class="card-title">Específico para tenentes-coronéis</h5>
                        <p class="card-text">Relatório de documentação entregue à Secretaria das Comissões de Promoção (SCP)</strong>.</p>
                        <a href="selecao_criterios_de_pesquisa_LQ_TC.php?relatorio=1" class="btn btn-primary">Selecionar</a>
                    </div>
                </div>
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