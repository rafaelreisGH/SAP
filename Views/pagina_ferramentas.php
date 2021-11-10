<?php
include_once './header2.php';

?>

<div class="container">

    <div class="clearfix"></div>

    <div class="col-md-12">
        <H3>
            Ações disponíveis
        </H3>
        <div class="clearfix"><br></div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">

                <div class="card">
                    <h4 class="card-header">Registro de promoção</h4>
                    <div class="card-body">
                        <h5 class="card-title">Atualização em lote</h5>
                        <p class="card-text">Selecione os militares e atualize os registros de promoção em lote. Esta opção <strong> não interfere na antiguidade.</strong></p>
                        <a href="selecao_criterios_de_pesquisa.php" class="btn btn-primary">Selecionar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header">Limite Quantitativo</h4>
                    <div class="card-body">
                        <h5 class="card-title">Militares em geral</h5>
                        <p class="card-text">Documento destinado a exibir os militares que possuem ou possuirão interstício mínimo para a próxima promoção.</p>
                        <a href="selecao_criterios_de_pesquisa_LQ.php" class="btn btn-primary">Selecionar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header">Interstício para último posto</h4>
                    <div class="card-body">
                        <h5 class="card-title">Específico para Tenentes Coronéis</h5>
                        <p class="card-text">Documento destinado a exibir os Tenentes Coronéis que possuem ou possuirão interstício mínimo para promoção (por merecimento).</p>
                        <a href="selecao_criterios_de_pesquisa_LQ_TC.php" class="btn btn-primary">Selecionar</a>
                    </div>
                </div>
            </div>

        </div>
        
        <div class="clearfix"></br></div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header">Cadastro de militar</h4>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Informe os dados necessários e cadastre os militares no banco de dados.</p>
                        <a href="cadastrar_militar.php" class="btn btn-primary">Selecionar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header">Atualização de antiguidade</h4>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Realize a alteração de antiguidade de militares.<br><br></p>
                        <a href="selecao_criterios_de_pesquisa.php?alteracao_antiguidade=1" class="btn btn-primary">Selecionar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include_once './footer.php';
?>