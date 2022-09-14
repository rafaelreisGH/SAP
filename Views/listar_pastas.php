<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';
include_once '../Controllers/verifica_permissoes.php';

//aqui começa a regra de negócio
require_once '../Controllers/busca_pastas.php';

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
    <h3><strong>Resultados de pesquisa</strong></h3>
    <hr>

    <form action="../Controllers/bloqueio_de_pastas.php" method="POST">
        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-md-4">
                    <button class="btn btn-outline-danger active" type="submit" name="buscar">Bloquear pastas promocionais</button>
                </div>
                <div class="col-md-4">
                    <?php

                    if (isset($erro)) echo '<br><font style="color:#ff0000"><i class="bi bi-exclamation-diamond">&nbsp' . $erro . '</i><br>';
                    ?>
                </div>
            </div>
            </br>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                            <tr>
                                <th>
                                    <p align="center"></br>

                                        <input type="checkbox" class="btn-check" id="btn-check" autocomplete="off" onclick="checkUncheck(this)">
                                        <label class="btn btn-light" for="btn-check"><strong>Selecionar todos</strong></label>
                                    </p>
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
                                <th>
                                    <p align="center">Semestre</p>
                                </th>
                                <th>
                                    <p align="center">Ano</p>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            if (isset($resultado)) {
                                foreach ($resultado as $item => $valor) {
                                    $aux_id = $valor['id'];
                                    $aux_nome = $valor['nome'];
                                    $aux_posto_grad = $valor['posto_grad_mil'];
                                    $aux_quadro = $valor['quadro'];

                                    echo '<tr>'
                                        . '<td align="center"><input class="form-check-input mt-0" type="checkbox" value="' . $aux_id . '" name="pasta_id[]"></td>'
                                        . '<td align="center">' . $aux_posto_grad . '</td>'
                                        . '<td align="center">' . $aux_nome . '</td>'
                                        . '<td align="center">' . $aux_quadro . '</td>'
                                        . '<td align="center">' . $valor['semestre_processo_promocional'] . 'º semestre</td>'
                                        . '<td align="center">' . $valor['ano_processo_promocional'] . '</td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </form>
</div>

<script>
    function checkUncheck(main) {
        all = document.getElementsByName('pasta_id[]');
        for (var a = 0; a < all.length; a++) {
            all[a].checked = main.checked;
        }
    }
</script>

<?php
include_once './footer.php';
?>