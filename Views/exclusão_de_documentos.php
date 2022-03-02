<?php
include_once '../Views/header.php';
require_once '../ConexaoDB/conexao.php';
include_once '../Controllers/verifica_permissoes.php';

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

//verificar se existe pasta promocional cadastrada para o militar
$ano = date("Y");
$semestre;
$mes = date("m");
if ($mes <= 6) {
    $semestre = 1;
} else {
    $semestre = 2;
}
//consulta
$consulta = $conn->query("SELECT * FROM pasta_promocional WHERE militar_id = '" . $militar_id . "'"
        . "AND semestre_processo_promocional = '" . $semestre . "' "
        . "AND ano_processo_promocional = '" . $ano . "'");
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
//declaração de variáveis auxiliares
//$aux_ano;
//$aux_sem;
//$id_pasta_promocional;
if ($resultado == NULL) {
    header('Location:../Views/pasta_promocional_home.php?militar_id=' . $militar_id . '&erro=1&ano=' . $ano . '&semestre=' . $semestre . '');
}
?>
<div class="container">

    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="pagina_gestor.php">Voltar</a></li>
            <li role="presentation" class="active"><a href="pasta_promocional_home.php?militar_id=<?= $militar_id ?>">Início da Pasta</a></li>
        </ul>
        <hr>
    </div>

    <div class="col-md-12">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form id="topo">
                <h3>Militar Selecionado</h3>
                <div class="form-text">
                    <p><?= $posto_grad ?>&nbsp<?= $nome ?></p>
                </div>

            </form>
        </div>
        <div class="col-md-4"></div>
    </div>

    <div class="col-md-12">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form action="../Controllers/exclui_documentos.php" method="POST" accept-charset="UTF-8">
                <h3>Exclusão de Documentos</h3>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Ano</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="ano">
                        <?php
                        $ano_atual = date("Y");
                        for ($i = 2019; $i <= $ano_atual; $i++) {
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>                
                    </select>
                    <small id="anoHelp" class="form-text text-muted">Insira o <strong>ano</strong> da pasta promocional correspondente.</small>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect2">Semestre</label>
                    <select class="form-control" id="exampleFormControlSelect2" name="semestre">

                        <?php
                        $mes_atual = date("m");
                        if ($mes_atual <= 6) {
                            echo '<option value="1" selected>1º Semestre</option><option value="2">2º Semestre</option>';
                        } else {
                            echo '<option value="1">1º Semestre</option><option value="2" selected>2º Semestre</option>';
                        }
                        ?>
                    </select>
                    <small id="semestreHelp" class="form-text text-muted">Insira o <strong>semestre</strong> da pasta promocional correspondente.</small>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Documento:</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="documento_a_ser_excluido" required>
                            <option value=""></option>
                            <option value="taf">Resultado do TAF</option>
                            <option value="ais">Resultado da AIS</option>
                            <option value="certidao_tj_1_inst">Certidão TJ 1ª instância</option>
                            <option value="certidao_tj_2_inst">Certidão TJ 2ª instância</option>
                            <option value="fad_ultimo_semestre">FAD</option>
                            <option value="certidao_trf_sj_mt">Certidão TRF Sç. Jud. MT</option>
                            <option value="certidao_trf_1">Certidão TRF-1</option>
                            <option value="nada_consta_correg">Nada Consta CORREG</option>
                            <option value="cursos_e_estagios">Cursos e estágios</option>
                            <option value="conceito_moral">Conceito Moral</option>
                        </select>
                        <small id="excluirHelp" class="form-text text-muted">Selecione o documento a ser excluído da pasta promocional.</small>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $militar_id ?>">
                    </div>

                    <button id="rodape" class="btn btn-danger">Excluir documento</button>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12"><br></div>
</div>


<?php
include_once '../Views/footer.php';
?>
