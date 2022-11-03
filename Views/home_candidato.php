<?php
require_once '../Controllers/nivel_usuario.php';
include_once '../Views/header2.php';
require_once '../ConexaoDB/conexao.php';

/* if (isset($_GET['militar_id']) && $_GET['militar_id'] != "") {
    $militar_id = $_GET['militar_id'];
    //pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $militar_id . "'");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado['nome'])) {
        $nome = $resultado['nome'];
        $posto_grad = $resultado['posto_grad_mil'];
    }
} else if (isset($_GET['militar_id']) && $_GET['militar_id'] == "") {
    //encaminha o usuário para a página acesso restrito
    header('Location: ../Views/acesso_restrito.php');
} */

require_once '../Controllers/select_dados_militar.php';
require_once '../Controllers/select_dados_fad.php';
if (isset($_POST['militar_id'])) {
    $militar_id = $_POST['militar_id'];
    $resultado = select_dados_militar_por_id($conn, $militar_id);
    if (isset($resultado[0])) {
        $nome = $resultado[0];
        $posto_grad = $resultado[1];
    }
    $resultado_fad = array();
    $resultado_fad = select_dados_fad_por_militar_id($conn, $militar_id, $posto_grad);
}
var_dump($resultado_fad);


require_once '../Controllers/verifica_permissoes_usuario.php';
verifica_permissao_usuario($conn, $militar_id);
?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <a class="btn btn-primary" href="pagina_usuario.php">Voltar</A>
        </ul>
        <hr>
    </div>
    <div class="col-md-12">
        <form>
            <h4>Militar Selecionado</h4>
            <div class="form-text">
                <p>
                    <?= $posto_grad ?>&nbsp<?= $nome ?></p>
            </div>
        </form>
    </div>

    <div class="clearfix"></div>
    <br />


    <div class="col-md-12">
        <div class="row">
            <div class="col col-md-12">
                <h4 class="panel-title"><strong>Registros de pastas promocionais</strong></h4>
                <hr>
            </div>
        </div>

        <div style="width: auto;">
            <ul>
                <!-- <ul class="list-group list-group-flush"> -->
                <?php
                try {
                    //PROCURA REGISTRO DE DOCUMENTOS CONFORME ID DO MILITAR
                    $consulta = $conn->query("SELECT id, ano_processo_promocional, semestre_processo_promocional FROM pasta_promocional WHERE militar_id = '$militar_id'");
                    $consulta2 = $conn->query("SELECT id, ano_processo_promocional, semestre_processo_promocional, pasta_bloqueada FROM pasta_promocional WHERE militar_id = '$militar_id'");
                    //percorrer os resultados
                    if (($consulta->fetch(PDO::FETCH_ASSOC)) == false) {
                        echo "Nenhum registro encontrado.</br>Entre em contato com a SCP/BM1, e solicite a criação da pasta promocional.";
                    }
                    while ($res = $consulta2->fetch(PDO::FETCH_ASSOC)) {
                        $id_da_pasta = $res['id'];
                        $aux_semestre_promocional = $res['semestre_processo_promocional'];
                        $aux_ano_promocional = $res['ano_processo_promocional'];
                        $aux_pasta_bloqueada = $res['pasta_bloqueada'];

                        echo '<li class="list-group-item">'
                            . '<p><strong>Processo promocional</br></strong>' . $aux_semestre_promocional . 'º semestre/' . $aux_ano_promocional . '</p>'
                            . '<ul class="nav nav-pills">';
                        echo '<li role="presentation" ><a class="btn btn-success" href="pasta_promocional_resumo.php?id_da_pasta=' . $id_da_pasta . '" role="button" target="_blank"><i class="bi bi-info-circle"></i>&nbspResumo</a></li>'
                            . '</ul></li><br>';
                    }
                } catch (PDOException $ex) {
                    return $ex->getMessage();
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col col-md-12">
                <h4 class="panel-title"><strong>Registros de Fichas de avaliação de desempenho (FAD)</strong></h4>
                <hr>
                

                <div class="row">
        <div class="col-md-12">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th>
                                <p align="center">Validar FAD</p>
                            </th>
                            <th>
                                <p align="center">Recusar recebimento</p>
                            </th>
                            <th>
                                <p align="center">Solicitar reavaliação</p>
                            </th>
                            <th>
                                <p align="center">Semestre/Ano</p>
                            </th>
                            <th>
                                <p align="center">Posto/Graduação</p>
                            </th>
                            <th>
                                <p align="center">Nota</p>
                            </th>
                            <th>
                                <p align="center">Avaliador</p>
                            </th>
                            <th>
                                <p align="center">Visualizar FAD</p>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        require_once '../Controllers/alias_posto_grad.php';
                        

                        if (isset($resultado_fad)) {
                            foreach ($resultado_fad as $item) {
                                $aux_id = $item['id'];
                                echo '<tr>';
                                switch ($item['acesso_candidato']) {
                                    case 1:
                                        echo '<td align="center"><form action="#" method="POST"><button type="submit" class="btn btn-outline-danger" type="submit" name="militar_id" value="' . $aux_id . '"><i class="bi bi-file-earmark-arrow-up-fill" title="Preencher FAD"></i>&nbspVer opções</button></form></td>';
                                        break;
                                    default:
                                        echo '<td align="center"><p>N/D</p></td>';
                                }
                                switch ($item['acesso_sadm']) {
                                    case 1:
                                        echo '<td align="center"><form action="../Views/pasta_promocional_home_candidato.php" method="POST"><button type="submit" class="btn btn-outline-primary" type="submit" name="militar_id" value="' . $aux_id . '"><i class="bi bi-file-earmark-arrow-up-fill" title="Enviar documentação"></i>&nbspVer opções</button></form></td>';
                                        break;
                                    default:
                                        echo '<td align="center"><p>N/D</p></td>';
                                }
                                switch ($item['acesso_avaliador']) {
                                    case 1:
                                        echo '<td align="center"><form action="../Views/formulario_fad.php" method="POST"><button type="submit" class="btn btn-outline-success" type="submit" name="militar_id" value="' . $aux_id . '"><i class="bi bi-file-earmark-arrow-up-fill" title="Preencher FAD"></i>&nbspAcessar formulário</button></form></td>';
                                        break;
                                    default:
                                        echo '<td align="center"><p>N/D</p></td>';
                                }
                                echo ''
                                    . '<td align="center">' . alias_posto_grad($item['posto_grad_mil']) . '</td>'
                                    . '<td align="center">' . $item['nome'] . '</td>'
                                    . '<td align="center">' . $item['quadro'] . '</td></tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <div class="col-md-12">
                </div>

            </div>
        </div>
    </div>

                    <?php
                    if (empty($resultado_fad)) {
                        echo '<p>Nenhum resultado de fad.</p></br>';
                    } else {
                        
                    }
                    ?>

                
            </div>
        </div>

        <div style="width: auto;">
        </div>
    </div>


    <br />
    <?php
    include_once '../Views/footer2.php';
    ?>