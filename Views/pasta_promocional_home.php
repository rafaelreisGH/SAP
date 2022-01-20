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




        <div class="row">
            <div class="col col-md-12">
                <h3 class="panel-title"><strong>Registros de pastas promocionais</strong></h3>
                <hr>
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

        <div class="card" style="width: auto;">
            <ul class="list-group list-group-flush">
                <?php
                try {
                    //PROCURA REGISTRO DE DOCUMENTOS CONFORME ID DO MILITAR
                    $consulta = $conn->query("SELECT id, ano_processo_promocional, semestre_processo_promocional FROM pasta_promocional WHERE militar_id = '$militar_id'");
                    //percorrer os resultados
                    while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
                        $id_da_pasta = $resultado['id'];
                        $aux_semestre_promocional = $resultado['semestre_processo_promocional'];
                        $aux_ano_promocional = $resultado['ano_processo_promocional'];

                        echo '<li class="list-group-item">'
                            . '<p><strong>Processo promocional</br></strong>' . $aux_semestre_promocional . 'º semestre/' . $aux_ano_promocional . '</p>'
                            . '<ul class="nav nav-pills">'
                            .'<li role="presentation" ><a class="btn btn-success" href="edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_da_pasta . '" role="button"><em class="glyphicon glyphicon-pencil" title="Cadastrar Documentos."></em></a></li>'
                            . '<li role="presentation" ><a class="btn btn-info" href="#" role="button"><em class="glyphicon glyphicon-eye-open" title="Visualizar Documentos."></em></a></li>'
                            . '<li role="presentation" ><a class="btn btn-danger" href="#" role="button"><em class="glyphicon glyphicon-remove" title="Remover Documentos."></em></a></li>'
                            . '</ul></li><br>';
                    }
                } catch (PDOException $ex) {
                    return $ex->getMessage();
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="clearfix"></div>
    <br />
    <?php
    include_once '../Views/footer.php';
    ?>