<?php
require_once '../Controllers/nivel_admin.php';
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';

$usuario_id = (isset($_POST['militar_id'])) ? $_POST['militar_id'] : null;
//se o $usuario_id não for um inteiro, redireciona para acesso restrito
if ((!filter_var($usuario_id, FILTER_VALIDATE_INT))) {
    header('Location: ../Views/acesso_restrito.php');
}

$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

//VERIFICAR A QUANTIDADE DE RESULTADOS QUE CORRESPONDEM AO CAMPO PESQUISAR
$stmtPesquisar = $conn->prepare("SELECT COUNT(*) FROM militar WHERE status = 'ATIVO' AND posto_grad_mil != 'CEL BM' AND posto_grad_mil != 'ST BM'");
$stmtPesquisar->execute();
$total_resultados = $stmtPesquisar->fetchColumn();
//VARIÁVEIS DA PAGINAÇÃO
$itens_por_pagina = 20;
$numero_da_pagina = ceil($total_resultados / $itens_por_pagina);
$inicio = ($itens_por_pagina * $pagina) - $itens_por_pagina;
$stmt = $conn->prepare("SELECT * FROM militar WHERE status = 'ATIVO' AND posto_grad_mil != 'CEL BM'  ORDER BY antiguidade LIMIT " . $inicio . "," . $itens_por_pagina . "");
$stmt->execute();

?>

<div class="container">

    <div class="container">
        <div class="col-md-12">
            <ul class="nav nav-pills">
                <li role="presentation" class="active"><a href="pagina_admin_ver_usuarios.php">Voltar</a></li>
            </ul>
            <hr>
        </div>
        <div class="col-md-12">

            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Militares disponíveis</h3>
                        </div>

                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                            <tr>
                                <th>
                                    <p align="center">Conceder acesso</p>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($resultados = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $aux_id = $resultados['id'];
                                $aux_nome = $resultados['nome'];
                                $aux_posto_grad = $resultados['posto_grad_mil'];
                                $aux_quadro = $resultados['quadro'];

                                echo '<tr>'
                                    . '<td align="center"><form action="../Controllers/adicionar_acesso_a_militar.php" method="POST"><button class="btn btn-outline-primary" type="submit" name="militar_id" value="' . $aux_id . '"><i class="bi-person-plus-fill"></i></button>'
                                    .'<input type="hidden" name="usuario_id" value="' . $usuario_id . '"></form></td>'
                                    . '<td align="center">' . $aux_posto_grad . '</td>'
                                    . '<td align="center">' . $aux_nome . '</td>'
                                    . '<td align="center">' . $aux_quadro . '</td>';
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
                        <div class="col col-xs-4">Página <?php echo $pagina; ?> de <?php echo $numero_da_pagina; ?>
                        </div>
                        <div class="col col-xs-8">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <?php if ($pagina_anterior != 0) { ?>
                                            <a class="page-link" href="listar_militares.php?pagina=<?php echo $pagina_anterior ?>&pesquisar=<?php echo $pesquisar; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span>
                                            </a>
                                        <?php } else { ?>
                                            <a class="page-link"><span aria-hidden="true">&laquo;</span></a>
                                        <?php } ?>
                                    </li>
                                    <?php for ($i = 1; $i < $numero_da_pagina + 1; $i++) { ?>
                                        <li class="page-item"><a class="page-link" href="listar_militares.php?pagina=<?php echo $i ?>&pesquisar=<?php echo $pesquisar; ?>"><?php echo $i; ?></a></li>
                                    <?php } ?>
                                    <li class="page-item">
                                        <?php if ($pagina_posterior <= $numero_da_pagina) { ?>
                                            <a class="page-link" href="listar_militares.php?pagina=<?php echo $pagina_posterior; ?>&pesquisar=<?php echo $pesquisar; ?>" aria-label="Previous"><span aria-hidden="true">&raquo;</span>
                                            </a>
                                        <?php } else { ?>
                                            <span aria-hidden="true">&laquo;</span>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <?php
    include_once './footer2.php';
    ?>