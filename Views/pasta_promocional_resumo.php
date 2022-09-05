<?php
require_once '../Controllers/nivel_usuario.php';
include_once '../Views/header2.php';
require_once '../ConexaoDB/conexao.php';

if (isset($_GET['id_da_pasta'])) {
    $id_da_pasta = $_GET['id_da_pasta'];

    //se o GET for igual a 0, ou não for uma string
    //bloqueia o acesso
    if (filter_var($id_da_pasta, FILTER_VALIDATE_INT) === 0 || filter_var($id_da_pasta, FILTER_VALIDATE_INT) === false) {
        header('Location: ../Views/acesso_restrito.php');
        exit();
    }

    //pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT militar.nome, militar.posto_grad_mil, pasta_promocional.semestre_processo_promocional, pasta_promocional.ano_processo_promocional
        FROM militar
        INNER JOIN pasta_promocional
        ON militar.id = pasta_promocional.militar_id
        WHERE pasta_promocional.id = '" . $id_da_pasta . "'");
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($res)) {
        $militar = $res['posto_grad_mil'];
        $militar = $militar . ' ' . $res['nome'];
        $aux_semestre_promocional = $res['semestre_processo_promocional'];
        $aux_ano_promocional = $res['ano_processo_promocional'];
    }

    //pegar os documentos salvos no BD
    $stmt = $conn->query("SELECT descricao, documento_valido, informacao FROM documento WHERE pasta_promo_id = '" . $id_da_pasta . "'");
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!isset($resultado)) echo "Nenhum resultado encontrado.";
}

//impedir acesso de pasta promocional que não lhe pertence
require_once '../Controllers/verifica_permissoes_usuario.php';
verifica_permissao_usuario_resumo($conn, $id_da_pasta);
?>

<div class="container">
    <div class="col-md-12">
        <h4>Militar Selecionado</h4>
        <div class="form-text">
            <p><?= $militar ?></p>
        </div>
    </div>

    <hr>

    <div class="col-md-12">
        <h4><strong>Documentos constantes na pasta promocional</strong></h4>

        <div class="form-text">
            <p><Strong>Referência:&nbsp</Strong>
                <?php
                echo $aux_semestre_promocional . 'º semestre de ';
                echo $aux_ano_promocional;
                ?>
            </p>
        </div>
        <hr>
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-body">
                    <div class="row justify-content-center">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                                <tr>
                                    <th>
                                        <p align="center">Ordem</p>
                                    </th>
                                    <th>
                                        <p align="center"></br>
                                            <label><strong>Documento</strong></label>
                                        </p>
                                    </th>
                                    <th>
                                        <p align="center">Status</p>
                                    </th>
                                    <th>
                                        <p align="center">Observação da SCP</p>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                try {
                                    include_once '../Controllers/alias_nomes_de_documentos.php';
                                } catch (PDOException $ex) {
                                    return $ex->getMessage();
                                }

                                $ordem = 1;
                                foreach ($resultado as $item) {
                                    $aux = $item;

                                    if ($aux['documento_valido'] == 1) {
                                        $validade = 'Em conformidade';
                                    } else if ($aux['documento_valido'] === 0) {
                                        $validade = 'Requisito não cumprido';
                                    } else {
                                        $validade = 'N/D';
                                    }

                                    switch ($aux['informacao']) {
                                        case null:
                                            $info = 'N/D';
                                            break;
                                        default:
                                            $info = $aux['informacao'];
                                            break;
                                    }
                                    
                                    echo '<tr>'
                                        . '<td align="center">' . $ordem . '</td>'
                                        . '<td align="center">' . alias_documentos($aux['descricao']) . '</td>'
                                        . '<td align="center">' . $validade . '</td>'
                                        . '<td align="center">' . $info . '</td>'
                                        . '</tr>';
                                    $ordem++;
                                }

                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="col-md-12">
        <h4><strong>Documentos faltantes</strong></h4>
        <div class="form-text">
            <p>
                <?php

                $doc = array('certidao_tj_1_inst', 'certidao_tj_2_inst', 'certidao_trf_1', 'certidao_tse', 'nada_consta_correg', 'conceito_moral', 'cursos_e_estagios', 'militar_tem_taf_id', 'ais_id', 'media_das_avaliacoes');

                foreach ($resultado as $item) {
                    $vetor[] = $item['descricao'];
                }

                foreach ($doc as $item) {
                    if (!in_array($item, $vetor)) {
                        echo alias_documentos($item) . '<br>';
                    } else {
                        continue;
                    }
                }
                ?>
            </p>
        </div>

        <div class="clearfix"></div>
        <br />
        <?php
        include_once '../Views/footer.php';
        ?>