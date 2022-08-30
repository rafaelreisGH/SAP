<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';
include_once '../Controllers/processa_LQ.php';

$parametro_data = (isset($_GET['data'])) ? $_GET['data'] : null;

list($ano, $mes, $dia) = explode("-", $lq_ano);
$lq_ano = $dia . '/' . $mes . '/' . $ano;
?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="selecao_criterios_de_pesquisa_LQ.php" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
        <h3>
            <strong>Limite de Quantitativo</strong>
        </h3>
        <p>Data considerada:&nbsp
            <?= $lq_ano; ?></p>
        <p><em>São relacionados os candidatos que completarão o interstício mínimo previsto para cada posto ou graduação até a data considerada, bem como aqueles que já haviam completado.</em></p>
        <hr>
        <?php
        require_once '../Controllers/alias_ultima_promocao.php';
        if (!is_null($parametro_data)) {
            $parametro_data = alias_ultima_promocao($parametro_data);
            echo "<p><i>Promoção em {$parametro_data}.</i></p>";
        }
        ?>

        <div class="panel-body">
            <table class="table table-striped table-bordered table-list">
                <thead>
                    <tr>
                        <th>
                            <p align="center">Última promoção</p>
                        </th>
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
                    require_once '../Controllers/alias_posto_grad.php';
                    require_once '../Controllers/alias_ultima_promocao.php';

                    if (isset($alteracoes_realizadas)) {
                        foreach ($alteracoes_realizadas as $item) {
                            $auxiliar = explode(",", $item);
                            //deixar no formato de data brasileiro
                            //$auxiliar[0] = alias_ultima_promocao($auxiliar[0]);
                            /*****************/
                            echo '<tr>'
                                . '<td align="center">' . alias_ultima_promocao($auxiliar[0]) . '</td>'
                                . '<td align="center">' . alias_posto_grad($auxiliar[1]) . '</td>'
                                . '<td align="center">' . $auxiliar[2] . '</td>'
                                . '<td align="center">' . $auxiliar[3] . '</td>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="col-md-12">
            </div>

        </div>
    </div>
</div>


<?php
include_once './footer.php';
?>