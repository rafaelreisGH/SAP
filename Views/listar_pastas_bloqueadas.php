<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';
include_once '../Controllers/verifica_permissoes.php';

$erro = isset($_GET['erro']) ? $_GET['erro'] : null;
$bloqueadas = isset($_GET['alteracoes_realizadas']) ? $_GET['alteracoes_realizadas'] : null;

?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="selecao_criterios_de_pesquisa_pasta.php" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
    </div>
    <h3><strong>Resultados do bloqueio de pastas</strong></h3>
    <hr>
    <?php
    if (!is_null($erro)) {
        switch ($erro) {
            case 1:
                echo '<p>Nenhuma pasta foi selecionada.</p></br>';
                break;
        }
    }
    ?>


    <div class="col-md-12">
        <div class="panel panel-default panel-table">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th>
                                <p align="center">Posto/Graduação</p>
                            </th>
                            <th>
                                <p align="center">Nome</p>
                            </th>
                            <th>
                                <p align="center">Quadro</p>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php

                        if (isset($bloqueadas) && !empty($bloqueadas)) {
                            require_once '../Controllers/select_dados_militar.php';
                            $dados = array();
                            $dados = select_dados_militar_por_id_da_pasta($conn, $bloqueadas);
                        }

                        foreach ($dados as $item) {
                            $aux_nome = $item['nome'];
                            $aux_posto_grad = $item['posto_grad_mil'];
                            $aux_quadro = $item['quadro'];

                            echo '<tr>'
                                . '<td align="center">' . $aux_posto_grad . '</td>'
                                . '<td align="center">' . $aux_nome . '</td>'
                                . '<td align="center">' . $aux_quadro . '</td>';
                        }

                        ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>

</div>



<?php
include_once './footer.php';
?>