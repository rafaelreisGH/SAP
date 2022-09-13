<?php
require_once '../Controllers/nivel_gestor.php';
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
$where[] = " status = 'ATIVO'";
if (isset($_POST['criterio_posto_grad'])) {
    $criterios_posto_grad = $_POST['criterio_posto_grad'];
    $where[] = " posto_grad_mil = '{$criterios_posto_grad}'";
} else if (isset($_GET['criterio_posto_grad'])) {
    $criterios_posto_grad = $_GET['criterio_posto_grad'];
    $where[] = " posto_grad_mil = '{$criterios_posto_grad}'";
}
if (isset($_POST['criterio_quadro'])) {
    $criterios_quadro = $_POST['criterio_quadro'];
    $where[] = " quadro = '{$criterios_quadro}'";
} else if (isset($_GET['criterio_quadro'])) {
    $criterios_quadro = $_GET['criterio_quadro'];
    $where[] = " quadro = '{$criterios_quadro}'";
}
// --------------------------- //

//adicionar WHERE e AND automaticamente na query conforme os critérios
$sql = "SELECT nome, posto_grad_mil, id, quadro, antiguidade FROM militar";
// ==>> https://pt.stackoverflow.com/questions/77984/pesquisa-mysql-com-filtro-select-option
if (sizeof($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
//INSERI UM ORDER BY ANTIGUIDADE
$sql .= " ORDER BY antiguidade";
$stmt = $conn->query($sql);
$stmt->execute();
// --------------------------- //

?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="selecao_criterios_de_pesquisa.php?pasta=1" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
    </div>
    <h3><strong>Resultados de pesquisa</strong></h3>
    <hr>
    <form action="../Controllers/cria_pasta_em_lote.php" method="POST">
        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-md-4">
                    <div class="input-group mb-3">
                        <label for="basic-addon3" class="form-label">Informações da pasta</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Ano da pasta</span>
                            <select class="form-control" id="exampleFormControlSelect1" name="ano">
                                <?php
                                $ano_atual = date("Y");
                                for ($i = $ano_atual; $i >= 2014; $i--) {
                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                                ?>
                            </select>
                            <small id="anoHelp" class="form-text text-muted">Insira o <strong>ano</strong> correspondente ao processo promocional.</small>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Semestre da pasta</span>
                            <select class="form-control" id="exampleFormControlSelect2" name="semestre">
                                <option value="1" <?php if (date("m") <= 6) echo 'selected'; ?>>1º Semestre</option>
                                <option value="2" <?php if (date("m") >= 7) echo 'selected'; ?>>2º Semestre</option>
                            </select>
                            <small id="anoHelp" class="form-text text-muted">Insira o <strong>semestre</strong> correspondente ao processo promocional.</small>
                        </div>
                    </div>


                    <input type="hidden" class="form-control" name="criterio_posto_grad" value="<?= $criterios_posto_grad ?>">
                    <input type="hidden" class="form-control" name="criterio_quadro" value="<?= $criterios_quadro ?>">

                    <button class="btn btn-outline-danger active" type="submit" name="buscar">Criar pasta promocional</button>

                </div>
                <div class="col-md-4">
                    <?php
                    if ($nada_alterado == 1) {
                        echo '<br><font style="color:#ff0000"><i>*Nenhum registro foi inserido, pois não foi selecionado nenhum militar.</i><br>';
                    } else if (!empty($nada_alterado)) {
                        echo '<br><br><font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspO(s) militar(es) selecionado(s) já possui(em) pasta promocional cadastrada.';
                    }
                    if (!empty($alteracoes_realizadas)) {
                        echo '<font style="color:#ff0000">Alterações realizadas no cadastro dos seguintes militares:<br>';
                        foreach ($alteracoes_realizadas as $item) {
                            $stmt2 = $conn->prepare("SELECT nome, posto_grad_mil, antiguidade FROM militar WHERE id = '" . $item . "' ORDER BY antiguidade");
                            $resultado = $stmt2->execute();
                            while ($resultado = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                $_nome = $resultado['nome'];
                                $_posto_grad = $resultado['posto_grad_mil'];
                            }
                            echo '<br><font style="color:#ff0000"><i>*' . $_posto_grad . ' ' . $_nome . '.</i>';
                        }
                        echo '<br><br><font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspO(s) militar(es) selecionado(s) e não listado(s) já possui(em) pasta promocional cadastrada.';
                    }
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
                                    <p align="center">Antiguidade</p>
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
                                $aux_antiguidade = $resultados['antiguidade'];

                                echo '<tr>'
                                    . '<td align="center"><input class="form-check-input mt-0" type="checkbox" value="' . $aux_id . '" name="militar_id[]"></td>'
                                    . '<td align="center">' . $aux_posto_grad . '</td>'
                                    . '<td align="center">' . $aux_nome . '</td>'
                                    . '<td align="center">' . $aux_quadro . '</td>'
                                    . '<td align="center">' . $aux_antiguidade . '</td>';
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
</script>

<?php
include_once './footer.php';
?>