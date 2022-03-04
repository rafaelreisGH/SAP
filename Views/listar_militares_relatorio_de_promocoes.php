<?php
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';
include_once '../Controllers/verifica_permissoes.php';

$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

if (isset($_GET['pesquisar'])) {
    $pesquisar = filter_input(INPUT_GET, 'pesquisar');
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
            $stmt = $conn->prepare("SELECT * FROM militar WHERE nome LIKE '%$pesquisar%' AND status = 'ATIVO' /*AND posto_grad_mil != 'CEL BM'*/  ORDER BY antiguidade LIMIT " . $inicio . "," . $itens_por_pagina . "");
            $stmt->execute();
            break;
    }
}

?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="pagina_relatorios.php" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
    </div>
    <h3>
        <strong>Registros de promoção</strong>
    </h3>
    <hr>

    <div class="col-md-12">
        <form action="" method="GET">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="nomeMilitar">Nome</span>
                            <input class="form-control" name="pesquisar" id="nome" placeholder="Digite um nome">
                        </div>
                    </div>
                    <button class="btn btn-outline-primary active" type="submit">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>
    <hr>
    <div class="col-md-12">
        <div class="panel panel-default panel-table">
            <div class="panel-body">
                <form action="../Views/relatorio_de_promocoes.php" method="POST">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                            <tr>
                                <th>
                                    <p align="center"></br>
                                        <label><strong>Selecionar</strong></label>
                                    </p>
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
                                    <p align="center">Antiguidade</p>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            //só mostra a tabela se houver resultados na pesquisa
                            if (isset($stmt)) {
                                while ($resultados = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $aux_id = $resultados['id'];
                                    $aux_nome = $resultados['nome'];
                                    $aux_posto_grad = $resultados['posto_grad_mil'];
                                    $aux_quadro = $resultados['quadro'];
                                    $aux_antiguidade = $resultados['antiguidade'];

                                    echo '<tr>'
                                        . '<td align="center"><input class="form-check-input mt-0" type="radio" name="militar_id" value="' . $aux_id . '" required></td>'
                                        . '<td align="center">' . $aux_posto_grad . '</td>'
                                        . '<td align="center">' . $aux_nome . '</td>'
                                        . '<td align="center">' . $aux_quadro . '</td>'
                                        . '<td align="center">' . $aux_antiguidade . '</td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    //só mostra a tabela se houver resultados na pesquisa
                    if (isset($stmt)) {
                        echo '<br><button id="btnRelatorio" class="btn btn-outline-danger active" type="submit">Gerar relatório</button><br><br>';
                    }
                    ?>
                </form>
            </div>

            <?php
            //Verificar a pagina anterior e posterior
            $pagina_anterior = $pagina - 1;
            $pagina_posterior = $pagina + 1;
            ?>
            <div class="panel-footer">
                <div class="row">
                    <div class="col">Page <?php echo $pagina; ?> de <?php echo $numero_da_pagina = isset($numero_da_pagina) ? $numero_da_pagina : 1; ?>
                    </div>
                    <div class="col">
                        <ul class="pagination">
                            <li class="page-item">
                                <?php if ($pagina_anterior != 0) { ?>
                                    <a class="page-link" href="listar_militares_relatorio_de_promocoes.php?pagina=<?php echo $pagina_anterior ?>&pesquisar=<?php echo $pesquisar; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span>
                                    </a>
                                <?php } else { ?>
                                    <a class="page-link"><span aria-hidden="true">&laquo;</span></a>
                                <?php } ?>
                            </li>
                            <?php for ($i = 1; $i < $numero_da_pagina + 1; $i++) { ?>
                                <li class="page-item"><a class="page-link" href="listar_militares_relatorio_de_promocoes.php?pagina=<?php echo $i ?>&pesquisar=<?php if (isset($pesquisar)) echo $pesquisar; ?>"><?php echo $i; ?></a></li>
                            <?php } ?>
                            <li class="page-item">
                                <?php if ($pagina_posterior <= $numero_da_pagina) { ?>
                                    <a class="page-link" href="listar_militares_relatorio_de_promocoes.php?pagina=<?php echo $pagina_posterior; ?>&pesquisar=<?php echo $pesquisar; ?>" aria-label="Previous"><span aria-hidden="true">&raquo;</span>
                                    </a>
                                <?php } else { ?>
                                    <a class="page-link"><span aria-hidden="true">&laquo;</span></a>
                                <?php } ?>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include_once './footer2.php';
?>