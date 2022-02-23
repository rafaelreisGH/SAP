<?php
include_once '../Views/header.php';
require_once '../ConexaoDB/conexao.php';

if (isset($_GET['militar_id'])) {
    $id = $_GET['militar_id'];
    //pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $id . "'");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado['nome'])) {
        $nome = $resultado['nome'];
        $posto_grad = $resultado['posto_grad_mil'];
    }
}
if (isset($_POST['militar_id'])) {
    $id = $_POST['militar_id'];
    //pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $id . "'");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado['nome'])) {
        $nome = $resultado['nome'];
        $posto_grad = $resultado['posto_grad_mil'];
    }
}
$nota_url = isset($_GET['nota']) ? $_GET['nota'] : 0;
$id_url = isset($_GET['militar_id']) ? $_GET['militar_id'] : 0;
$semestre_url = isset($_GET['semestre']) ? $_GET['semestre'] : 0;
$ano_url = isset($_GET['ano']) ? $_GET['ano'] : 0;
?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="../Views/pagina_ferramentas.php">Voltar</a></li>
        </ul>
        <hr>
    </div>
    <div class="col-md-3">
        <form>
            <h3>Militar Selecionado</h3>
            <div class="form-text">
                <label>ID Militar</label>
                <p><?= $id ?></p>
            </div>
            <div class="form-text">
                <label>Posto/Graduação</label>
                <p><?= $posto_grad ?></p>
            </div>
            <div class="form-text">
                <label>Nome</label>
                <p><?= $nome ?></p>
            </div>
            <div class="form-text">
                <label>Média</label>
                <?php
                $stmtPesquisar = $conn->query("SELECT nota FROM fad WHERE militar_id = '$id'");
                $stmtPesquisar->execute();

                $resultado = $stmtPesquisar->fetchAll(PDO::FETCH_COLUMN, 0);
                $elementos = count($resultado);
                if ($elementos >= 3) {
                    sort($resultado);
                    array_shift($resultado);
                    array_pop($resultado);
                    $qtde = sizeof($resultado);
                    $media = array_sum($resultado) / $qtde;
                    //echo "Média: " . number_format($media,2) . "</br>";
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
                <p><?php
                    $consulta = $conn->query("SELECT media FROM militar WHERE id = '" . $id . "' ");
                    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                    if (isset($resultado['media'])) {
                        $media = $resultado['media'];
                        echo number_format($media, 2);
                    } else {
                        echo "Ainda não há notas suficientes para calcular a média.";
                    }
                    ?>

                    <?php
                    if ($nota_url > 0) {
                        echo '<h3>Último registro</h3>';
                        echo '<p><label>Nota registrada:&nbsp</label>' . $nota_url . ' ponto(s).</p>';
                        echo '<p><label>Referente ao:&nbsp</label>' . $semestre_url . 'º semestre de ' . $ano_url . '.</p>';
                        //echo '<p><label>Em favor de: </label>' . $posto_grad . ' ' . $nome . '.</p>';
                    }
                    ?>
                </p>
            </div>
        </form>

    </div>

    <div class="col-md-4">
        <?php
        if (isset($_GET['erro'])) {
            $erro = $_GET['erro'];
            if ($erro == 1) {
                echo '<br><font style="color:#ff0000"><i>*Já havia registro de FAD no período informado.<br>'
                    . 'Exclua antes o registro anterior.</i></font>';
            }
        }
        ?>
        <form action="../Controllers/processa_fad.php" method="POST">
            <h3>Lançamento de notas</h3>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Ano</label>
                <select class="form-control" id="exampleFormControlSelect1" name="ano">
                    <?php
                    $ano_atual = date("Y");
                    for ($i = $ano_atual; $i >= 2014; $i--) {
                        echo "<option value=" . $i . ">" . $i . "</option>";
                    }
                    ?>
                </select>
                <small id="anoHelp" class="form-text text-muted">Insira o <strong>ano</strong> correspondente da F.A.D.</small>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Semestre</label>
                <select class="form-control" id="exampleFormControlSelect2" name="semestre">
                    <option value="1">1º Semestre</option>
                    <option value="2">2º Semestre</option>
                </select>
                <small id="anoHelp" class="form-text text-muted">Insira o <strong>semestre</strong> correspondente da F.A.D.</small>
            </div>
            <div class="form-group">
                <label for="formControlNumber">Nota:</label>
                <input id="formControlNumber" type="number" class="form-control" name="pontuacao" min="1" max="6" step="0.1" value="5">
                <small id="notaHelp" class="form-text text-muted">Insira a <strong>nota</strong> da F.A.D.</small>
            </div>

            <div class="form-group">
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

            <div class="form-group">
                <input type="hidden" name="id" value="<?= $id ?>">
            </div>

            <button class="btn btn-primary">Salvar</button>
        </form>

    </div>

    <div class="col-md-5">
        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="row">
                    <div class="col col-xs-6">
                        <h3 class="panel-title">Registros de FAD</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th>Semestre</th>
                            <th>Ano</th>
                            <th>Nota</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        try {
                            //PROCURA REGISTRO DE FAD CONFORME ID DO MILITAR
                            $consulta = $conn->query("SELECT id, ano, semestre, nota FROM fad WHERE militar_id = '$id' ORDER BY ano ASC");
                            //percorrer os resultados
                            while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                $id_da_fad = $resultado['id'];
                                $aux_semestre = $resultado['semestre'];
                                $aux_ano = $resultado['ano'];
                                $aux_nota = $resultado['nota'];

                                echo '<tr>'
                                    . '<td>' . $aux_semestre . 'º semestre</td>'
                                    . '<td>' . $aux_ano . '</td>'
                                    . '<td>' . $aux_nota . '</td>'
                                    . '<td align="center"><form action="../Controllers/exclui_fad.php" method="POST"><input type="hidden" name="militar_id" value="' . $id . '"><input type="hidden" name="exclui_fad_original" value="1">'
                                    .'<button class="btn btn-danger" type="submit" name="id_da_fad" value="' . $id_da_fad . '"><em class="glyphicon glyphicon-trash" title="Excluir FAD."></em></button></form></td>';
                            }
                        } catch (PDOException $ex) {
                            return $ex->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                $sucesso = (isset($_GET['sucesso'])) ? $_GET['sucesso'] : null;
                if (!is_null($sucesso)){
                    echo '<font style="color:#ff0000"><i>Registro excluído com sucesso.</i></font>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../Views/footer.php';
?>