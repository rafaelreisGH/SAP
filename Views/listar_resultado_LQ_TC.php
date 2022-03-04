<?php
include_once './header2.php';
include_once '../Controllers/verifica_permissoes.php';
include_once '../Controllers/processa_LQ_TC.php';

//GET para verificar se nada foi alterado
//ou seja, se o usuário não selecionou nenhum militar
//não é realizado nenhuma operação no BD
$nada_alterado = (isset($_GET['nada_alterado'])) ? $_GET['nada_alterado'] : 0;

//verificar de houve alterações
// if (isset($_GET['militar_com_intersticio'])) {
//     $alteracoes_realizadas = $_GET['militar_com_intersticio'];
// }

$parametro_data = (isset($_GET['data'])) ? $_GET['data'] : null;
?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="selecao_criterios_de_pesquisa_LQ_TC.php" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
        <h3>
            <strong>Tenentes Coronéis com insterstício</strong>
        </h3>
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
                <?php
                if ($nada_alterado == 1) {
                    echo '<p align="center">Nenhum resultado encontrado.</p>';
                }
                ?>
            </div>

        </div>
    </div>
</div>


<?php
include_once './footer.php';
?>