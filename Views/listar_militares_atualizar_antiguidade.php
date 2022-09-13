<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';

//verificar de houve alterações
$alteracoes_realizadas = isset($_GET['sucesso']) ? $_GET['sucesso'] : 0;

//declaração de variáveis
$criterio_posto_grad;
$criterio_quadro;
$nome;
$posto_grad;
$quadro;
$militar_id;
// --------------------------- //

//verificação dos POSTs
$where = array();
if (isset($_POST['criterio_posto_grad'])) {
    $criterio_posto_grad = $_POST['criterio_posto_grad'];
    $where[] = " posto_grad_mil = '{$criterio_posto_grad}'";
} else if (isset($_GET['criterio_posto_grad'])) {
    $criterio_posto_grad = $_GET['criterio_posto_grad'];
    $where[] = " posto_grad_mil = '{$criterio_posto_grad}'";
}
if (isset($_POST['criterio_quadro'])) {
    $criterio_quadro = $_POST['criterio_quadro'];
    $where[] = " quadro = '{$criterio_quadro}'";
} else if (isset($_GET['criterio_quadro'])) {
    $criterio_quadro = $_GET['criterio_quadro'];
    $where[] = " quadro = '{$criterio_quadro}'";
}
// --------------------------- //

//adicionar WHERE e AND automaticamente na query conforme os critérios
$sql = "SELECT nome, posto_grad_mil, id, quadro, antiguidade FROM militar";
// ==>> https://pt.stackoverflow.com/questions/77984/pesquisa-mysql-com-filtro-select-option
if (sizeof($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " AND militar.status = 'ATIVO' ORDER BY antiguidade";
$stmt = $conn->query($sql);
$stmt->execute();
// --------------------------- //

?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="selecao_criterios_de_pesquisa.php?alteracao_antiguidade=1" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
    </div>
    <h3><strong>Resultados de pesquisa</strong></h3>
    <hr>
    <form action="../Controllers/atualiza_antiguidade.php" method="POST" name="formAntiguidade" onsubmit="return validateForm()">
        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-md-4">
                    <div class="input-group mb-3">
                        <label for="basic-addon3" class="form-label">Inserir a antiguidade correta do militar selecionado</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Posição a ser ocupada</span>
                            <input type="number" class="form-control" name="antiguidade_informada" required>
                        </div>
                        <!-- Este parágrafo será chamado pelo script js no final da página -->
                        <p id="alertaErroAntiguidadeIgual" style="color:#FF0000"></p>
                        <!-- /////////////////////////////////////////////////////// -->
                    </div>

                    <input type="hidden" name="criterio_posto_grad" value="<?= $criterio_posto_grad ?>">
                    <input type="hidden" name="criterio_quadro" value="<?= $criterio_quadro ?>">

                    <button class="btn btn-outline-danger active" type="submit" name="buscar">Atualizar antiguidade</button>
                </div>
                <div class="col-md-4">
                    <?php
                    if ($alteracoes_realizadas == 1) {
                        echo '<p><font style="color:#ff0000"><i class="bi bi-person-check" fill="currentColor"></i><strong>&nbsp Alteração de antiguidade realizada com sucesso!</strong></font></p>';
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
                                        <input type="checkbox" class="btn-check" id="btn-check">
                                        <label class="btn btn-light" for="btn-check"><strong>Selecionar</strong></label>
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
                                    . '<td align="center"><input class="form-check-input mt-0" type="radio" value="' . $aux_antiguidade . '" name="antiguidade_atual" required></td>'
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
    function validateForm() {
        // abaixo serve para impedir que o formulário seja submetido caso as antiguidades sejam iguais.
        let antiguidade_informada = document.forms["formAntiguidade"]["antiguidade_informada"].value;
        let antiguidade_atual = document.forms["formAntiguidade"]["antiguidade_atual"].value;

        if (antiguidade_informada == antiguidade_atual) {
            document.getElementById('alertaErroAntiguidadeIgual').innerHTML = '* A antiguidade atual e a informada devem ser obrigatoriamente diferentes.'
            return false;
        } else if(antiguidade_informada == 0){
            document.getElementById('alertaErroAntiguidadeIgual').innerHTML = '* A antiguidade informada não pode ser igual a 0 (zero).'
            return false;
        }else {
            document.getElementById('alertaErroAntiguidadeIgual').innerHTML = ''
        }
    }
</script>

<?php
include_once './footer.php';
?>