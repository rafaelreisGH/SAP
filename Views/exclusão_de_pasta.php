<?php
include_once '../Views/header.php';
require_once '../ConexaoDB/conexao.php';

if (isset($_GET['militar_id'])) {
    $militar_id = $_GET['militar_id'];
//pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $militar_id . "'");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado['nome'])) {
        $nome = $resultado['nome'];
        $posto_grad = $resultado['posto_grad_mil'];
    }
}
if (isset($_POST['militar_id'])) {
    $militar_id = $_POST['militar_id'];
//pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $militar_id . "'");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado['nome'])) {
        $nome = $resultado['nome'];
        $posto_grad = $resultado['posto_grad_mil'];
    }
}
/*
  $nota_url = isset($_GET['nota']) ? $_GET['nota'] : 0;
  $id_url = isset($_GET['militar_id']) ? $_GET['militar_id'] : 0;
  $semestre_url = isset($_GET['semestre']) ? $_GET['semestre'] : 0;
  $ano_url = isset($_GET['ano']) ? $_GET['ano'] : 0;
 */
?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="../Views/pagina_gestor.php">Voltar</a></li>
            <li role="presentation" class="active"><a href="../Views/pasta_promocional_home.php?militar_id=<?=$militar_id?>">Início da pasta</a></li>
            <li role="presentation" class="active"><a href="../Views/cadastro_de_documentos.php?militar_id=<?=$militar_id?>">Cadastrar documentos</a></li>
        </ul>
        <hr>
    </div>
    <div class="col-md-12">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form>
                <h3>Militar Selecionado</h3>
                <div class="form-text">
                    <p><?= $posto_grad ?>&nbsp<?= $nome ?></p>
                </div>
            </form>
        </div>
        <div class="col-md-4"></div>
   
    </div>
    <div class="clearfix"></div>
    
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <form action="../Controllers/exclui_pasta.php" method="POST">
            <h3>Exclusão de Pasta Promocional</h3>
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
                <small id="anoHelp" class="form-text text-muted">Insira o <strong>ano</strong> correspondente ao processo promocional.</small>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Semestre</label>
                <select class="form-control" id="exampleFormControlSelect2" name="semestre">
                    <option value="1">1º Semestre</option>
                    <option value="2">2º Semestre</option>
                </select>
                <small id="anoHelp" class="form-text text-muted">Insira o <strong>semestre</strong> correspondente ao processo promocional.</small>
            </div>

            <div class="form-group">
                <input type="hidden" name="id" value="<?= $militar_id ?>">
            </div>

            <button class="btn btn-danger">Excluir pasta promocional</button>
        </form>
        <?php
        if (isset($_GET['erro'])) {
            $erro = $_GET['erro'];
            if ($erro == 0) {
                echo '<br><font style="color:#ff0000"><i>*Não havia pasta promocional criada no período informado.<br>'
                . 'Portanto nenhuma alteração foi <strong>realizada</strong>.</i></font>';
            } else if ($erro == 1) {
                echo '<br><font style="color:#ff0000"><i>*Pasta promocional excluída com sucesso!</i></font>';
            }
        }
        ?>
    </div>
    <div class="col-md-4"></div>
    <div class="clearfix"></div>
    <br />
</div>

<?php
include_once '../Views/footer.php';
?>
