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
    header('Location:../Views/pasta_promocional_home.php?militar_id=' . $militar_id . '&erro=1&ano='.$ano.'&semestre='.$semestre.'');
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
        <div class="col-md-4">
            <div style="position:fixed">
                <label>Atalhos para navegação rápida</label><br>
                <form>
                    <a href='#topo'>Topo</a><br><br>
                    <a href='#labelAno'>Ano</a><br>
                    <a href='#labelSemestre'>Semestre</a><br>
                    <a href='#labelTaf'>T.A.F.</a><br>
                    <a href='#exampleFormControlSelect4'>A.I.S.</a><br>
                    <a href='#exampleFormControlSelect5'>Certidão TJ 1ª Instância</a><br>
                    <a href='#exampleFormControlSelect6'>Certidão TJ 2ª Instância</a><br>
                    <a href='#exampleFormControlSelect7'>F.A.D.</a><br>
                    <a href='#exampleFormControlSelect8'>Certidão TRF Sç. Jud. MT</a><br>
                    <a href='#exampleFormControlSelect9'>Certidão TRF-1</a><br>
                    <a href='#exampleFormControlSelect10'>Nada Consta CORREG</a><br>
                    <a href='#exampleFormControlSelect11'>Cursos e estágios</a><br>
                    <a href='#exampleFormControlSelect12'>Conceito Moral</a><br><br>
                    <a href='#rodape'>Rodapé</a>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <form action="#" method="POST" accept-charset="UTF-8">
                <h3>Atualização de Documentos</h3>
                <div class="form-group">
                    <label for="exampleFormControlSelect1" id="labelAno">Ano</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="ano">
                        <option value="<?=$ano?>"><?=$ano?></option>
                        <?php
                        $ano_atual = date("Y");
                        for ($i = $ano_atual-1; $i >= 2014; $i--) {
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>                
                    </select>
                    <small id="anoHelp" class="form-text text-muted">Insira o <strong>ano</strong> correspondente ao processo promocional.</small>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect2"  id="labelSemestre">Semestre</label>
                    <select class="form-control" id="exampleFormControlSelect2" name="semestre">  

                        <?php
                        $mes_atual = date("m");
                        if ($mes_atual <= 6) {
                            echo '<option value="1" selected>1º Semestre</option><option value="2">2º Semestre</option>';
                        } else {
                            echo '<option value="1">1º Semestre</option><option value="2" selected>2º Semestre</option>';
                        }
                        ?>
                        <!--código anterior
                            <option value="1">1º Semestre</option>
                        <option value="2">2º Semestre</option>-->
                    </select>
                    <small id="semestreHelp" class="form-text text-muted">Insira o <strong>semestre</strong> correspondente ao processo promocional.</small>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect3" id="labelTaf">Resultado do T.A.F.</label>
                    <select class="form-control" id="exampleFormControlSelect3" name="resultado_do_taf">
                        <option value="" selected></option>
                        <option value="apto">Apto</option>
                        <option value="inapto">Inapto</option>
                    </select>
                    <small id="tafHelp" class="form-text text-muted">Insira o resultado do <strong>taf</strong> correspondente ao processo promocional.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect4">Resultado da A.I.S.</label>
                    <select class="form-control" id="exampleFormControlSelect4" name="resultado_da_ais">
                        <option value="" selected></option>
                        <option value="apto">Apto</option>
                        <option value="inapto">Inapto</option>
                        <option value="restrição parcial">Restrição parcial</option>
                        <option value="restrição total">Restrição total</option>
                    </select>
                    <small id="tafHelp" class="form-text text-muted">Insira o resultado da <strong>Ata de Inspeção de Saúde</strong> correspondente ao processo promocional.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect5">Certidão TJ 1ª Instância</label>
                    <select class="form-control" id="exampleFormControlSelect5" name="certidao_tj_1_instancia">
                        <option value="" selected></option>
                        <option value="nada consta">Nada consta</option>
                        <option value="positiva">Responde a processo</option>
                    </select>
                    <small id="certidaoTj1instanciaHelp" class="form-text text-muted">Insira a informação sobre a <strong>Certidão do TJ/MT 1ª Instância</strong>.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect6">Certidão TJ 2ª Instância</label>
                    <select class="form-control" id="exampleFormControlSelect6" name="certidao_tj_2_instancia">
                        <option value="" selected></option>
                        <option value="nada consta">Nada consta</option>
                        <option value="positiva">Responde a processo</option>
                    </select>
                    <small id="certidaoTj2instanciaHelp" class="form-text text-muted">Insira a informação sobre a <strong>Certidão do TJ/MT 2ª Instância</strong>.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect7">F.A.D. do último semestre</label>
                    <select class="form-control" id="exampleFormControlSelect7" name="fad">
                        <option value="" selected></option>
                        <option value="presente">Presente</option>
                        <option value="ausente">Ausente</option>
                    </select>
                    <small id="fadHelp" class="form-text text-muted">Insira o status da <strong>última F.A.D.</strong>.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect8">Certidão TRF Sç. Jud. MT</label>
                    <select class="form-control" id="exampleFormControlSelect8" name="certidao_trf_sç_jud_mt">
                        <option value="" selected></option>
                        <option value="nada consta">Nada Consta</option>
                        <option value="positiva">Responde a processo</option>
                    </select>
                    <small id="certidaoTrfScJudMtHelp" class="form-text text-muted">Insira a informação sobre a <strong>Certidão do TRF Seção Judiciária Mato Grosso</strong>.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect9">Certidão TRF-1</label>
                    <select class="form-control" id="exampleFormControlSelect9" name="certidao_trf_1">
                        <option value="" selected></option>
                        <option value="nada consta">Nada Consta</option>
                        <option value="positiva">Responde a processo</option>
                    </select>
                    <small id="certidaoTrf1Help" class="form-text text-muted">Insira a informação sobre a <strong>Certidão do TRF-1</strong>.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect10">Nada Consta CORREG</label>
                    <select class="form-control" id="exampleFormControlSelect10" name="nada_consta_correg">
                        <option value="" selected></option>
                        <option value="nada consta">Nada Consta</option>
                        <option value="positiva">Responde a processo interno</option>
                    </select>
                    <small id="nadaConstaCorregHelp" class="form-text text-muted">Insira a informação sobre a <strong>Certidão da CORREG</strong>.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect11">Cursos e Estágios</label>
                    <select class="form-control" id="exampleFormControlSelect11" name="cursos_e_estagios">
                        <option value="" selected></option>
                        <option value="possui">Possui</option>
                        <option value="não possui">Não possui</option>
                    </select>
                    <small id="cursosEestágiosHelp" class="form-text text-muted">Insira a informação sobre a <strong>Cursos e estágios</strong> requeridos.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect12">Conceito Moral</label>
                    <select class="form-control" id="exampleFormControlSelect12" name="conceito_moral">
                        <option value="" selected></option>
                        <option value="possui">Possui conceito moral</option>
                        <option value="não possui">Não possui conceito moral</option>
                    </select>
                    <small id="conceitoMoralHelp" class="form-text text-muted">Insira a informação sobre o <strong>Conceito Moral</strong>.</small>
                </div>


                <div class="form-group">
                    <input type="hidden" name="id" value="<?= $militar_id ?>">
                </div>

                <button id="rodape" class="btn btn-primary">Atualiza pasta promocional</button>
            </form>
        </div>
        <div class="col-md-4">
            
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12"><br></div>
</div>


<?php
include_once '../Views/footer.php';
?>
