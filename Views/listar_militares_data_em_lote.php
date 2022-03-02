<?php
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';
include_once '../Controllers/verifica_permissoes.php';

//GET para verificar se nada foi alterado
//ou seja, se o usuário não selecionou nenhum militar
//não é realizado nenhuma operação no BD
$nada_alterado = (isset($_GET['nada_alterado'])) ? $_GET['nada_alterado'] : 0;

//verificar se houve alterações
if (isset($_GET['alteracoes_realizadas'])) {
    $alteracoes_realizadas = $_GET['alteracoes_realizadas'];
}

//declaração de variáveis
$criterios_posto_grad;
$criterios_quadro;
$nome;
$posto_grad;
$quadro;
$militar_id;
// --------------------------- //

//verificação dos POSTs
$where = array();
if (isset($_POST['criterio_posto_grad'])) {
    $criterios_posto_grad = $_POST['criterio_posto_grad'];
    $where[] = " posto_grad_mil = '{$criterios_posto_grad}'";
}
if (isset($_POST['criterio_quadro'])) {
    $criterios_quadro = $_POST['criterio_quadro'];
    $where[] = " quadro = '{$criterios_quadro}'";
}
// --------------------------- //

//adicionar WHERE e AND automaticamente na query conforme os critérios
$sql = "SELECT nome, posto_grad_mil, id, quadro FROM militar";
// ==>> https://pt.stackoverflow.com/questions/77984/pesquisa-mysql-com-filtro-select-option
if (sizeof($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$stmt = $conn->query($sql);
$stmt->execute();
// --------------------------- //

?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="selecao_criterios_de_pesquisa.php" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
    </div>
    <h3><strong>Resultados de pesquisa</strong></h3>
    <hr>
    <form action="../Controllers/inserir_registro_de_promocao.php" method="POST">
        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-md-4">
                    <div class="input-group mb-3">
                        <label for="basic-addon3" class="form-label">Inserir registro de promoção</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Data da promoção</span>
                            <input type="date" class="form-control" name="data_promocao" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Modalidade</span>
                            <select class="form-select" name="modalidade" required>
                                <option selected disabled>Selecione</option>
                                <option value="POR ANTIGUIDADE">POR ANTIGUIDADE</option>
                                <option value="POR MERECIMENTO">POR MERECIMENTO</option>
                                <option value="POR RESSARCIMENTO DE PRETERIÇÃO">POR RESSARCIMENTO DE PRETERIÇÃO</option>
                                <option value="POR REQUERIMENTO">POR REQUERIMENTO</option>
                                <option value="POR ATO DE BRAVURA">POR ATO DE BRAVURA</option>
                                <option value="POR INVALIDEZ">POR INVALIDEZ</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Posto/Graduação</span>
                            <select class="form-select" name="promocao_posto_grad" id="FormControlSelectPosto" required>
                                <option selected disabled>Selecione</option>
                                <option value="CEL BM">Coronel</option>
                                <option value="TC BM">Tenente Coronel</option>
                                <option value="MAJ BM">Major</option>
                                <option value="CAP BM">Capitão</option>
                                <option value="1º TEN BM">1º Tenente</option>
                                <option value="2º TEN BM">2º Tenente</option>
                                <option value="ASP OF BM">Aspirante-a-oficial</option>
                                <option value="ST BM">Sub-tentente</option>
                                <option value="1º SGT BM">1º Sargento</option>
                                <option value="2º SGT BM">2º Sargento</option>
                                <option value="3º SGT BM">3º Sargento</option>
                                <option value="CB BM">Cabo</option>
                                <option value="SD BM">Soldado</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-outline-danger active" type="submit" name="buscar">Atualizar data</button>
                </div>
                <div class="col-md-4">
                    <?php
                    if ($nada_alterado == 1) {
                        echo '<br><font style="color:#ff0000"><i>*Nenhum registro foi inserido. Selecione ao menos um militar.</i><br>';
                    }
                    if (!empty($alteracoes_realizadas)) {
                        foreach ($alteracoes_realizadas as $item) {
                            //$stmt2 = $conn->prepare("SELECT nome, posto_grad_mil FROM militar WHERE id = " . $item . "");
                            $stmt2 = $conn->prepare("SELECT militar.nome, militar.posto_grad_mil, registro_de_promocoes.a_contar_de FROM militar CROSS JOIN registro_de_promocoes WHERE militar.id = registro_de_promocoes.militar_id AND militar.id = '" . $item . "'");
                            $resultado = $stmt2->execute();

                            while ($resultado = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                $_nome = $resultado['nome'];
                                $_posto_grad = $resultado['posto_grad_mil'];
                                $_a_contar_de = $resultado['a_contar_de'];
                                require_once '../Controllers/alias_ultima_promocao.php';
                                $_a_contar_de = alias_ultima_promocao($_a_contar_de);
                            }
                            echo '<br><font style="color:#ff0000"><i>*Registro alterado para ' . $_posto_grad . ' ' . $_nome . '. Data: ' . $_a_contar_de . '.</i>';
                        }
                    }
                    ?>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" type="button" onmouseout="escondeDica()" onmouseover="mostraDica()">
                        <i class="bi bi-question-square-fill"></i>&nbsp Observação
                    </button>
                    <div>
                        </br>
                        <p id="paragrafoDica" align="justify"></p>
                    </div>
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
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            while ($resultados = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $aux_id = $resultados['id'];
                                $aux_nome = $resultados['nome'];
                                $aux_posto_grad = $resultados['posto_grad_mil'];
                                $aux_quadro = $resultados['quadro'];

                                echo '<tr>'
                                    . '<td align="center"><input class="form-check-input mt-0" type="checkbox" value="' . $aux_id . '" name="militar_id[]"></td>'
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
    </form>
</div>

<script>
    function checkUncheck(main) {
        all = document.getElementsByName('militar_id[]');
        for (var a = 0; a < all.length; a++) {
            all[a].checked = main.checked;
        }
    }
    function mostraDica(){
        document.getElementById('paragrafoDica').innerHTML = 'Caso já exista registrada promoção para o mesmo posto/graduação, as informações serão atualizadas no banco de dados sobrescrevendo o registro anterior.'
    }
    function escondeDica(){
        document.getElementById('paragrafoDica').innerHTML = ''
    }
</script>

<?php
include_once './footer.php';
?>