<?php
require_once '../Controllers/nivel_gestor.php';
include_once '../Views/header.php';
require_once '../ConexaoDB/conexao.php';
//^^^^APAGAR DAQUI PARA CIMA DEPOIS

if (isset($_POST['militar_id'])) {
    $id = $_POST['militar_id'];
    //pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $id . "'");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado['nome'])) {
        $nome = $resultado['nome'];
        $posto_grad = $resultado['posto_grad_mil'];
        $quadro = $resultado['quadro'];
    }
} else if (isset($_GET['militar_id'])) {
    $id = $_GET['militar_id'];
    //pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $id . "'");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado['nome'])) {
        $nome = $resultado['nome'];
        $posto_grad = $resultado['posto_grad_mil'];
        $quadro = $resultado['quadro'];
        $media = $resultado['media'];
        $militar_id = $resultado['id'];
    }
} else {
    header('Location:../Views/acesso_restrito.php');
}

$nota_url = isset($_GET['nota']) ? $_GET['nota'] : 0;
$id_url = isset($_GET['militar_id']) ? $_GET['militar_id'] : 0;
$semestre_url = isset($_GET['semestre']) ? $_GET['semestre'] : 0;
$ano_url = isset($_GET['ano']) ? $_GET['ano'] : 0;
?>

<script type="text/javascript" src="../js/meus_scripts/atualiza_resumo.js"></script>
<script type="text/javascript" src="../js/meus_scripts/valida_formulario.js"></script>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="../Views/listar_militares.php">Voltar</a></li>
        </ul>
        <hr>
    </div>

    <div class="row">

        <div class="col-md-12">
            <form>
                <h3><strong>Militar avaliado</strong></h3></br>
                <div class="form-text col-md-12">
                    <p><?= $posto_grad ?> <?= $nome ?></p>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <form name="myForm" action="../Controllers/processa_fad.php" method="POST" onload="atualiza_resumo();" onchange="atualiza_resumo();" onsubmit="return validateForm()">
                <h3><strong>Ficha de avaliação de desempenho</strong></h3></br>

                <div class="col-md-12">
                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <label for="FormControlSelectAno">Ano</label>
                            <select class="form-control" id="FormControlSelectAno" name="ano">
                                <?php
                                $ano_atual = date("Y");
                                for ($i = $ano_atual; $i >= 2014; $i--) {
                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                                ?>
                            </select>
                            <small id="anoHelp" class="form-text text-muted">Insira o <strong>ano</strong> correspondente da F.A.D.</small>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="FormControlSelectSemestre">Semestre</label>
                            <select class="form-control" id="FormControlSelectSemestre" name="semestre">
                                <option value="1">1º Semestre</option>
                                <option value="2">2º Semestre</option>
                            </select>
                            <small id="anoHelp" class="form-text text-muted">Insira o <strong>semestre</strong> correspondente da F.A.D.</small>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12">

                        <div class="form-group col-md-6">

                            <label for="FormControlSelectPostoGrad">Posto/Graduação no período avaliado</label>
                            <select class="form-control" id="FormControlSelectPostoGrad" name="postoGradNoPerioAvaliado" required>
                                <option value=""></option>
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
                            <small id="anoHelp" class="form-text text-muted">Informe o <strong>posto/graduação</strong> do militar no período correspondente desta avaliação.</small>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputQuadro">Quadro</label>
                            <input class="form-control" type="text" placeholder="<?= $quadro ?>" id="inputQuadro" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <label for="FormControlSelectPostoGrad">Posto/Graduação no período avaliado</label>
                            <input type="number" class="form-control" name="pontuacao" min="0" max="6" step="0.1" value="6">
                            <small id="anoHelp" class="form-text text-muted">Informe a <strong>pontuação</strong> informada na FAD em questão.</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $id ?>">
                    </div>

                    <!-- AQUI VAI A NOTA CALCULADA NO JAVASCRIPT ATUALIZA_RESUMO.JS-->
                    <div class="form-group">
                        <input type="hidden" id="nota" name="notaCalculada" value="">
                    </div>
                    <!-- ****************************************************** -->

                    <div class="form-group col-md-12">
                        <button class="btn btn-primary">Salvar</button>
                        <input type="reset" class="btn btn-secondary">
                    </div>
                </div>

            </form>

            <hr>
            <div class="form-group col-md-12">
                <h3><strong>Arquivo digital da FAD</strong></h3></br>
                <?php
                if (isset($_GET['erro']) && ($_GET['erro']) == 2) {
                    echo '<p><font style="color:#0000ff"><i class="bi bi-exclamation-circle" fill="currentColor"></i><strong>&nbspÉ preciso informar a situação da FAD e/ou enviar o arquivo digital.</strong></font></p>';
                }
                ?>
            </div>

            <div class="col-md-12">

                <form action="upload_url_fad.php" method="post">

                    <div class="form-group col-md-12">
                        <label for="FormControlSelectDocumento">Especifique a FAD</label>
                        <select id="FormControlSelectDocumento" name="documento_id" class="form-control" required>
                            <option value="" selected>Selecione</option>
                            <?php
                            try {
                                $stmt = $conn->prepare('SELECT * FROM fad WHERE militar_id = :id AND grau_hierarquico_na_epoca = :posto_grad');
                                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                                $stmt->bindParam(':posto_grad', $posto_grad, PDO::PARAM_STR);
                                $stmt->execute();

                                while ($consulta_fad = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $aux_id = $consulta_fad['id'];
                                    $aux_nota = $consulta_fad['nota'];
                                    $aux_semestre = $consulta_fad['semestre'];
                                    $aux_ano = $consulta_fad['ano'];

                                    echo '<option value="' . $aux_id . '">Nota: ' . $aux_nota . ' - ' . $aux_semestre . 'º SEM/' . $aux_ano . '</option>';
                                }
                            } catch (PDOException $ex) {
                                echo $ex->getMessage();
                            }
                            ?>
                        </select>
                        <small class="form-text text-muted">Informe a <strong>FAD</strong> correspondente.</small>
                    </div>

                    <div class="form-group col-md-12">
                        <input type="url" name="documento_url" class="form-control" placeholder="Insira a URL do documento" required>
                        <!-- <input type="hidden" name="tipo_do_documento" value="fad"> -->
                        <input type="hidden" name="militar_id" value="<?= $id ?>">
                        <small class="form-text text-muted">Insira a <strong>URL</strong> do documento correspondente.</small>
                    </div>

                    <div class="form-group col-md-12">
                        <input type="submit" class="btn btn-primary" value="Salvar">
                    </div>
                </form>
            </div>



        </div>

        <div class="col-md-5">
            <table class="table table-striped" style="text-align: center;">
                <caption>Média do militar avaliado</caption>
                <tbody>
                    <tr>
                        <th scope="row">Média</th>
                        <td colspan="5">
                            <p>
                                <?php
                                $stmtPesquisar = $conn->query("SELECT nota FROM fad WHERE militar_id = '$id' AND grau_hierarquico_na_epoca = '$posto_grad'");
                                $stmtPesquisar->execute();

                                $resultado = $stmtPesquisar->fetchAll(PDO::FETCH_COLUMN, 0);
                                $elementos = count($resultado);

                                if ($elementos >= 3) {
                                    sort($resultado);
                                    array_shift($resultado);
                                    array_pop($resultado);
                                    $qtde = sizeof($resultado);
                                    $media = array_sum($resultado) / $qtde;
                                    //inserção da média no BD
                                    $stmt3 = $conn->prepare("UPDATE militar SET media = ? WHERE id = '$id'");
                                    $stmt3->bindParam(1, $media);
                                    $stmt3->execute();
                                } else {
                                    //vai colocar a média como ZERO quando houver menos de 3 notas de FAD
                                    $stmt4 = $conn->prepare("UPDATE militar SET media = 0 WHERE id = '$id'");
                                    $stmt4->execute();
                                }
                                ?>
                                <?php
                                $consulta = $conn->query("SELECT media FROM militar WHERE id = '" . $id . "' ");
                                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                                if (isset($resultado['media'])  && $resultado['media'] != 0) {
                                    $media = $resultado['media'];
                                    echo number_format($media, 2);
                                } else {
                                    echo "Ainda não há notas suficientes para calcular a média.";
                                }
                                ?>
                            <p>

                        </td>
                    </tr>
                </tbody>
            </table>

            <?php
            if (isset($_GET['erro'])) {
                $erro = $_GET['erro'];
                if ($erro == 1) {
                    echo '<br><font style="color:#ff0000"><i>*Já havia registro de FAD no período informado.<br>'
                        . 'Portanto o registro foi <strong>atualizado</strong>.</i></font>';
                }
            }
            ?>
            </p>
            <table class="table table-striped">
                <caption>Registros de Ficha de Avaliação</caption>
                <thead>
                    <tr>
                        <th>Semestre</th>
                        <th>Ano</th>
                        <th>Nota</th>
                        <th>Excluir</th>
                        <th>Visualizar</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    try {
                        //PROCURA REGISTRO DE FAD CONFORME ID DO MILITAR
                        $stmt = $conn->prepare("SELECT id, ano, semestre, nota, caminho_do_arquivo FROM fad WHERE militar_id = :id ORDER BY ano ASC");
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();

                        // Percorrer os resultados
                        while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $id_da_fad = $resultado['id'];
                            $aux_semestre = $resultado['semestre'];
                            $aux_ano = $resultado['ano'];
                            $aux_nota = $resultado['nota'];
                            $aux_url = $resultado['caminho_do_arquivo'];

                            echo '<tr>'
                                . '<td>' . $aux_semestre . 'º semestre</td>'
                                . '<td>' . $aux_ano . '</td>'
                                . '<td>' . $aux_nota . '</td>'
                                . '<td><form action="../Controllers/exclui_fad.php" method="POST"><input type="hidden" name="militar_id" value="' . $id . '"><button class="btn btn-danger" type="submit" name="id_da_fad" value="' . $id_da_fad . '"><em class="glyphicon glyphicon-trash" title="Excluir FAD."></em></button></form></td>';
                            if ($aux_url == null) echo '<td align="center">N/C</td>';
                            else echo '<td align="center"><a target="_blank" href="' . $aux_url . '"><button class="btn btn-success" type="button"><i class="bi bi-eye-fill"></i><em class="glyphicon glyphicon-eye-open" title="Visualizar FAD."></em> Visualizar</button></a>&nbsp</td>';
                        }
                    } catch (PDOException $ex) {
                        return $ex->getMessage();
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

</div>

<?php
include_once '../Views/footer.php';
?>