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
            <li role="presentation" class="active"><a href="../Views/cadastro_de_pasta.php?militar_id=<?= $militar_id ?>">Criar Pasta Promocional</a></li>
            <li role="presentation" class="active"><a href="../Views/cadastro_de_documentos.php?militar_id=<?= $militar_id ?>">Atualizar documentos</a></li>
            <li role="presentation" class="active"><a href="../Views/exclusão_de_documentos.php?militar_id=<?= $militar_id ?>">Exclusão de documentos</a></li>
            <li role="presentation" class="active"><a href="../Views/exclusão_de_pasta.php?militar_id=<?= $militar_id ?>">Excluir pasta</a></li>
        </ul>
        <hr>
    </div>
    <div class="col-md-12">
        <form>
            <h3>Militar Selecionado</h3>
            <div class="form-text">
                <p>
                    <?php
                    if (isset($_GET['erro'])) {
                        $erro = $_GET['erro'];
                        if ($erro == 1) {
                            echo '<br><font style="color:#ff0000"><i>*Erro! Favor cadastrar pasta promocional.<br>Ainda não há pasta promocional referente ao ' . $_GET['semestre'] . 'º de ' . $_GET['ano'] . ' para:&nbsp</i></font>';
                        }
                    }
                    ?>
                    <?= $posto_grad ?>&nbsp<?= $nome ?></p>
            </div>
        </form>
    </div>

    <div class="clearfix"></div>
    <br />

    <div class="clearfix"></div>
    <br />
    <div class="col-md-12">
        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="row">
                    <div class="col col-xs-6">
                        <h3 class="panel-title">Documentos lançados na pasta promocional</h3>
                        <?php
                        if (isset($_GET['sucesso'])) {
                            echo '<br><font style="color:#ff0000"><i>*Pasta promocional atualizada com sucesso!</i></font>';
                        }
                        if (isset($_GET['sucesso_exclusão'])) {
                            $i = $_GET['sucesso_exclusão'];
                            switch ($i) {
                                case 1:
                                    echo '<br><font style="color:#ff0000"><i>*Documento excluído com sucesso!</i></font>';
                                    break;
                                case 0:
                                    echo '<br><font style="color:#ff0000"><i>*Nada foi alterado! O documento pode já ter sido excluído ou foi informado um período para o qual não há pasta promocional criada. </i></font>';
                                    break;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th>Ano</th>
                            <th>Semestre</th>
                            <th>TAF</th>
                            <th>AIS</th>
                            <th>Certidão TJ 1ª Inst.</th>
                            <th>Certidão TJ 2ª Inst.</th>
                            <th>FAD</th>
                            <th>Certidão TRF Sç. Jud. MT</th>
                            <th>Certidão TRF-1</th>
                            <th>Nada Consta CORREG</th>
                            <th>Cursos/Estágios</th>
                            <th>Conceito Moral</th>
                        </tr> 
                    </thead>

                    <tbody>
                        <?php
                        try {
                            //PROCURA REGISTRO DE DOCUMENTOS CONFORME ID DO MILITAR
                            $consulta = $conn->query("SELECT * FROM pasta_promocional WHERE militar_id = '$militar_id'");
                            //percorrer os resultados
                            while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                $id_da_fad = $resultado['id'];
                                $aux_semestre_promocional = $resultado['semestre_processo_promocional'];
                                $aux_ano_promocional = $resultado['ano_processo_promocional'];
                                $aux_taf = $resultado['taf_id'];
                                $aux_ais = $resultado['ais_id'];
                                $aux_certidao_tj_1_inst = $resultado['certidao_tj_1_inst'];
                                $aux_certidao_tj_2_inst = $resultado['certidao_tj_2_inst'];
                                $aux_fad_ult_sem = $resultado['fad_id'];
                                $aux_certidao_trf_sj_mt = $resultado['certidao_trf_sj_mt'];
                                $aux_certidao_trf_1 = $resultado['certidao_trf_1'];
                                $aux_nada_consta_correg = $resultado['nada_consta_correg'];
                                $aux_cursos_e_estagios = $resultado['cursos_e_estagios'];
                                $aux_conceiro_moral = $resultado['conceito_moral'];

                                echo '<tr>'
                                . '<td>' . $aux_semestre_promocional . 'º semestre</td>'
                                . '<td>' . $aux_ano_promocional . '</td>'
                                . '<td>' . ucwords($aux_taf) . '</td>'
                                . '<td>' . ucwords($aux_ais) . '</td>'
                                . '<td>' . ucwords($aux_certidao_tj_1_inst) . '</td>'
                                . '<td>' . ucwords($aux_certidao_tj_2_inst) . '</td>'
                                . '<td>' . ucwords($aux_fad_ult_sem) . '</td>'
                                . '<td>' . ucwords($aux_certidao_trf_sj_mt) . '</td>'
                                . '<td>' . ucwords($aux_certidao_trf_1) . '</td>'
                                . '<td>' . ucwords($aux_nada_consta_correg) . '</td>'
                                . '<td>' . ucwords($aux_cursos_e_estagios) . '</td>'
                                . '<td>' . ucwords($aux_conceiro_moral) . '</td>'
                                ;
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

    <div class="clearfix"></div>
    <br />

    <?php
    include_once '../Views/footer.php';
    ?>
