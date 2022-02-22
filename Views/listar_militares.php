<?php
include_once './header.php';
require_once '../ConexaoDB/conexao.php';
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
if (!isset($_GET['pesquisar'])) {
    //redirecionar o usuário conforme seu nível de acesso
    session_start();
    switch ($_SESSION['nivel_de_acesso']) {
        case '2':
            header('Location: ../Views/pagina_admin.php');
            break;
        case '1':
            header('Location: ../Views/pagina_gestor.php');
            break;
        default:
            header('Location: ../Views/pagina_usuario.php');
            break;
    }
} else {
    $pesquisar = filter_input(INPUT_GET, 'pesquisar', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW);
    switch ($pesquisar) {
        case "":
            //VERIFICAR A QUANTIDADE DE RESULTADOS QUE CORRESPONDEM AO CAMPO PESQUISAR
            $stmtPesquisar = $conn->prepare("SELECT COUNT(*) FROM militar WHERE nome LIKE '%$pesquisar%' AND status = 'ATIVO'/* AND posto_grad_mil != 'CEL BM'*/");
            $stmtPesquisar->execute();
            $total_resultados = $stmtPesquisar->fetchColumn();
            //VARIÁVEIS DA PAGINAÇÃO
            $itens_por_pagina = 10;
            $numero_da_pagina = ceil($total_resultados / $itens_por_pagina);
            $inicio = ($itens_por_pagina * $pagina) - $itens_por_pagina;
            $stmt = $conn->prepare("SELECT * FROM militar WHERE nome LIKE '%$pesquisar%' AND status = 'ATIVO' /*AND posto_grad_mil != 'CEL BM'*/  ORDER BY antiguidade LIMIT " . $inicio . "," . $itens_por_pagina . "");
            $stmt->execute();
            break;
        default:
            //VERIFICAR A QUANTIDADE DE RESULTADOS QUE CORRESPONDEM AO CAMPO PESQUISAR
            $stmtPesquisar = $conn->prepare("SELECT COUNT(*) FROM militar WHERE nome LIKE '%$pesquisar%' AND status = 'ATIVO' AND posto_grad_mil != 'CEL BM'");
            $stmtPesquisar->execute();
            $total_resultados = $stmtPesquisar->fetchColumn();
            //VARIÁVEIS DA PAGINAÇÃO
            $itens_por_pagina = 10;
            $numero_da_pagina = ceil($total_resultados / $itens_por_pagina);
            $inicio = ($itens_por_pagina * $pagina) - $itens_por_pagina;
            $stmt = $conn->prepare("SELECT * FROM militar WHERE nome LIKE '%$pesquisar%' AND status = 'ATIVO' AND posto_grad_mil != 'CEL BM'  ORDER BY antiguidade LIMIT " . $inicio . "," . $itens_por_pagina . "");
            $stmt->execute();
            break;
    }
}

?>
<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="pagina_gestor.php">Voltar</a></li>
        </ul>
        <hr>
    </div>
    <div class="col-md-12">

        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="row">
                    <div class="col col-xs-6">
                        <h3 class="panel-title">Resultados de pesquisa para edição</h3>
                    </div>

                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th>
                                <p align="center">FAD</p>
                            </th>
                            <th>
                                <p align="center">Pasta<br>Promocional</p>
                            </th>
                            <th>
                                <p align="center">Editar dados</p>
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
                                <p align="center">Média</p>
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
                            $aux_media = $resultados['media'];
                            if ($aux_media == 0) {
                                $aux_media = 'N/D';
                            }

                            echo '<tr>'
                                . '<td align="center"><form action="../Views/teste_fad.php" method="POST"><button class="btn btn-info" type="submit" name="militar_id" value="' . $aux_id . '"><em class="glyphicon glyphicon-copy" title="Cadastrar FAD."></em></button></form></td>'
                                . '<td align="center"><form action="../Views/pasta_promocional_home.php" method="POST"><button class="btn btn-danger" type="submit" name="militar_id" value="' . $aux_id . '"><em class="glyphicon glyphicon-folder-open" title="Cadastrar Documentos."></em></button></form></td>'
                                . '<td align="center"><form action="../Views/visualizar_dados.php" method="POST"><button class="btn btn-success" type="submit" name="militar_id" value="' . $aux_id . '"><em class="glyphicon glyphicon-pencil" title="Editar dados"></em></button></form></td>'
                                . '<td align="center">' . $aux_posto_grad . '</td>'
                                . '<td align="center">' . $aux_nome . '</td>'
                                . '<td align="center">' . $aux_quadro . '</td>'
                                . '<td align="center">' . $aux_media . '</td>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
            //Verificar a pagina anterior e posterior
            $pagina_anterior = $pagina - 1;
            $pagina_posterior = $pagina + 1;
            ?>
            <div class="panel-footer">
                <div class="row">
                    <div class="col col-xs-4">Page <?php echo $pagina; ?> de <?php echo $numero_da_pagina; ?>
                    </div>
                    <div class="col col-xs-8">
                        <ul class="pagination hidden-xs pull-right">
                            <li>
                                <?php if ($pagina_anterior != 0) { ?>
                                    <a href="listar_militares.php?pagina=<?php echo $pagina_anterior ?>&pesquisar=<?php echo $pesquisar; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span>
                                    </a>
                                <?php } else { ?>
                                    <span aria-hidden="true">&laquo;</span>
                                <?php } ?>
                            </li>
                            <?php for ($i = 1; $i < $numero_da_pagina + 1; $i++) { ?>
                                <li><a href="listar_militares.php?pagina=<?php echo $i ?>&pesquisar=<?php echo $pesquisar; ?>"><?php echo $i; ?></a></li>
                            <?php } ?>
                            <li>
                                <?php if ($pagina_posterior <= $numero_da_pagina) { ?>
                                    <a href="listar_militares.php?pagina=<?php echo $pagina_posterior; ?>&pesquisar=<?php echo $pesquisar; ?>" aria-label="Previous"><span aria-hidden="true">&raquo;</span>
                                    </a>
                                <?php } else { ?>
                                    <span aria-hidden="true">&laquo;</span>
                                <?php } ?>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once './footer.php';
    ?>