<?php
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';

// --------------------------- //
if (isset($_GET['id_da_pasta'])) {
    $id_da_pasta = $_GET['id_da_pasta'];
} else if (isset($_POST['id_da_pasta'])) {
    $id_da_pasta = $_POST['id_da_pasta'];
}

// --------------------------- //

// --------------------------- //
//pegar no BD dados do militar selecionado
$stmt = $conn->query("SELECT * FROM pasta_promocional WHERE id = '$id_da_pasta'");
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($resultado['militar_id'])) {
    $militar_id = $resultado['militar_id'];
    $semestre_pasta = $resultado['semestre_processo_promocional'];
    $ano_pasta = $resultado['ano_processo_promocional'];

    $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $militar_id . "'");
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($res['nome'])) {
        $nome = $res['nome'];
        $posto_grad = $res['posto_grad_mil'];
    }
}
// --------------------------- //

?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="pasta_promocional_home.php?militar_id=<?= $militar_id ?>" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
    </div>

    <div class="col-md-12">
        <h4>Militar Selecionado</h4>
        <div class="form-text">
            <p><?= $posto_grad ?>&nbsp<?= $nome ?></p>
        </div>
    </div>
    <hr>
    <h3><strong>Edição de documentos da pasta</strong></h3>
    <h6>Referência:&nbsp<?= $semestre_pasta ?>º semestre de <?= $ano_pasta ?></h6>
    <hr>

    <?php
    $sucesso = (isset($_GET['sucesso'])) ? $_GET['sucesso'] : null;
    $documento = (isset($_GET['documento'])) ? $_GET['documento'] : null;
    switch ($documento) {
        case 'certidao_tj_1_situacao':
            $documento = "Certidão TJ-MT 1ª Instância";
            break;
        case 'certidao_tj_2_situacao':
            $documento = "Certidão TJ-MT 2ª Instância";
            break;
        case 'certidao_trf_1_situacao':
            $documento = "Certidão TRF-1";
            break;
        case 'certidao_trf_sj_mt_situacao':
            $documento = "Certidão TRF Sç. Jud. MT";
            break;
        case 'nada_consta_correg_situacao':
            $documento = "Nada Consta da Corregedoria";
            break;
        case 'conceito_moral_situacao':
            $documento = "Conceito Moral";
            break;
        case 'cursos_e_estagios_situacao':
            $documento = "Cursos e estágios";
            break;
    }
    if ((!is_null($sucesso)) && (!is_null($documento))) {
        if (($sucesso[0] == 1) && (!is_null($documento))) {
            echo '<p><font style="color:#ff0000"><i class="bi bi-person-check" fill="currentColor"></i>&nbspAlteração de dados bem sucedida para <strong>' . $documento . '</strong>.</font></p>';
        } else {
            echo '<p>Observação:<br>';
            echo 'Falha ao cadastrar a ' . $documento . '!';
            echo '</p>';
        }
    }
    ?>

    <h5><label class="form-label">Certidões da Justiça</label></h5>
    <hr>

    <div id="certidoesJustiça" class="col-md-12">

        <div id="certidaoTj1Inst" class="col">

            <div class="row">

                <div class="form-group col-md-6">
                    <form action="../Controllers/atualiza_tb_documentos.php" method="post">
                        <label class="form-label">Certidão TJ-MT - 1ª instância</label>
                        <div class="input-group">
                            <span class="input-group-text">Status</span>
                            <select class="form-select" name="status" required>
                                <option selected disabled>Selecione a situação</option>
                                <option value="NEGATIVA">Certidão negativa</option>
                                <option value="POSITIVA">Certidão positiva</option>
                                <option value="">Ausente</option>
                            </select>
                            <input type="hidden" name="tipo_do_documento" value="certidao_tj_1_situacao">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Informe a <strong>situação</strong> correspondente.</small>
                    </form>
                </div>
                <div class="form-group col-md-6">
                    <?php
                    try {
                        $resultado_certidao_tj_1_situacao = $conn->query('SELECT certidao_tj_1_situacao  from pasta_promocional WHERE pasta_promocional.id = ' . $id_da_pasta . '')->fetch();
                        if (!is_null($resultado_certidao_tj_1_situacao[0]) /*&& ($resultado_certidao_tj_1_situacao[0] != '')*/) {
                            echo '<br><strong>Último registro:</strong> <br> ';
                            echo 'Certidão ' . $resultado_certidao_tj_1_situacao['certidao_tj_1_situacao'];
                        }
                    } catch (PDOException $ex) {
                        return $ex->getMessage();
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">
                        <div class="input-group">
                            <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                            <input type="hidden" name="tipo_do_documento" value="certidao_tj_1_inst">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>

                    </form>
                </div>

                <div class="form-group col-md-6">
                    <?php
                    if (isset($resultado['certidao_tj_1_inst'])) {
                        $cert_trf_sj_mt = $resultado['certidao_tj_1_inst'];
                        echo '<label class="form-label">Ações disponíveis:</label>'
                            . '<form action="arquivos_excluir.php" method="post">'
                            . '<div class="form-group">'
                            . '<a target="_blank" href="' . $cert_trf_sj_mt . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                            . '<input type="hidden" name="tipo_do_documento" value="certidao_tj_1_inst">'
                            . '<input type="hidden" name="id_pasta" value="' . $id_da_pasta . '">'
                            . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                            . '</div>'
                            . '</form>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <br>

        <div id="certidaoTj2Inst" class="col">

            <div class="row">

                <div class="form-group col-md-6">

                    <form action="../Controllers/atualiza_tb_documentos.php" method="post">
                        <label class="form-label">Certidão TJ-MT - 2ª instância</label>
                        <div class="input-group">
                            <span class="input-group-text">Status</span>
                            <select class="form-select" name="status" required>
                                <option selected disabled>Selecione a situação</option>
                                <option value="NEGATIVA">Certidão negativa</option>
                                <option value="POSITIVA">Certidão positiva</option>]
                                <option value="">Ausente</option>
                            </select>
                            <input type="hidden" name="tipo_do_documento" value="certidao_tj_2_situacao">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Informe a <strong>situação</strong> correspondente.</small>
                    </form>
                </div>

                <div class="form-group col-md-6">
                    <?php
                    try {
                        $resultado_certidao_tj_2_situacao = $conn->query('SELECT certidao_tj_2_situacao  from pasta_promocional WHERE pasta_promocional.id = ' . $id_da_pasta . '')->fetch();
                        if (!is_null($resultado_certidao_tj_2_situacao[0]) /*&& ($resultado_certidao_tj_2_situacao[0] != '')*/) {
                            echo '<br><strong>Último registro:</strong> <br> ';
                            echo 'Certidão ' . $resultado_certidao_tj_2_situacao['certidao_tj_2_situacao'];
                        }
                    } catch (PDOException $ex) {
                        return $ex->getMessage();
                    }
                    ?>
                </div>

            </div>

            <div class="row">

                <div class="form-group col-md-6">

                    <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                        <div class="input-group">
                            <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                            <input type="hidden" name="tipo_do_documento" value="certidao_tj_2_inst">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>

                    </form>
                </div>
            </div>

            <div class="form-group col-md-6">
                <?php
                if (isset($resultado['certidao_tj_2_inst'])) {
                    $cert_tj_2 = $resultado['certidao_tj_2_inst'];
                    echo '<label class="form-label">Ações disponíveis:</label>'
                        . '<form action="arquivos_excluir.php" method="post">'
                        . '<div class="form-group">'
                        . '<a target="_blank" href="' . $cert_tj_2 . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                        . '<input type="hidden" name="tipo_do_documento" value="certidao_tj_2_inst">'
                        . '<input type="hidden" name="id_pasta" value="' . $id_da_pasta . '">'
                        . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                        . '</div>'
                        . '</form>';
                }
                ?>
            </div>
        </div>
        </br>

        <div id="certidaoTRF1" class="col">

            <div class="row">
                <div class="form-group col-md-6">
                    <form action="../Controllers/atualiza_tb_documentos.php" method="post">
                        <label class="form-label">Certidão TRF-1</label>
                        <div class="input-group">
                            <span class="input-group-text">Status</span>
                            <select class="form-select" name="status" required>
                                <option selected disabled>Selecione a situação</option>
                                <option value="NEGATIVA">Certidão negativa</option>
                                <option value="POSITIVA">Certidão positiva</option>
                                <option value="">Ausente</option>
                            </select>
                            <input type="hidden" name="tipo_do_documento" value="certidao_trf_1_situacao">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Informe a <strong>situação</strong> correspondente.</small>
                    </form>
                </div>

                <div class="form-group col-md-6">
                    <?php
                    try {
                        $resultado_certidao_trf_1_situacao = $conn->query('SELECT certidao_trf_1_situacao  from pasta_promocional WHERE pasta_promocional.id = ' . $id_da_pasta . '')->fetch();
                        if (!is_null($resultado_certidao_trf_1_situacao[0]) /*&& ($resultado_certidao_trf_1_situacao[0] != '')*/) {
                            echo '<br><strong>Último registro:</strong> <br> ';
                            echo 'Certidão ' . $resultado_certidao_trf_1_situacao['certidao_trf_1_situacao'];
                        }
                    } catch (PDOException $ex) {
                        return $ex->getMessage();
                    }
                    ?>

                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                        <div class="input-group">
                            <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                            <input type="hidden" name="tipo_do_documento" value="certidao_trf_1">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>

                    </form>

                </div>


                <div class="form-group col-md-6">
                    <?php
                    if (isset($resultado['certidao_trf_1'])) {
                        $cert_trf_1 = $resultado['certidao_trf_1'];
                        echo '<label class="form-label">Ações disponíveis:</label>'
                            . '<form action="arquivos_excluir.php" method="post">'
                            . '<div class="form-group">'
                            . '<a target="_blank" href="' . $cert_trf_1 . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                            . '<input type="hidden" name="tipo_do_documento" value="certidao_trf_1">'
                            . '<input type="hidden" name="id_pasta" value="' . $id_da_pasta . '">'
                            . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                            . '</div>'
                            . '</form>';
                    }
                    ?>
                </div>
            </div>

        </div>
        </br>
        <div id="certidaoTRFSjMT" class="col">

            <div class="row">
                <div class="form-group col-md-6">
                    <form action="../Controllers/atualiza_tb_documentos.php" method="post">
                        <label class="form-label">Certidão TRF Seção Judiciária - MT</label>
                        <div class="input-group">
                            <span class="input-group-text">Status</span>
                            <select class="form-select" name="status" required>
                                <option selected disabled>Selecione a situação</option>
                                <option value="NEGATIVA">Certidão negativa</option>
                                <option value="POSITIVA">Certidão positiva</option>
                                <option value="">Ausente</option>
                            </select>
                            <input type="hidden" name="tipo_do_documento" value="certidao_trf_sj_mt_situacao">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Informe a <strong>situação</strong> correspondente.</small>
                    </form>
                </div>
                <div class="form-group col-md-6">
                    <?php
                    try {
                        $resultado_certidao_trf_sj_mt_situacao = $conn->query('SELECT certidao_trf_sj_mt_situacao  from pasta_promocional WHERE pasta_promocional.id = ' . $id_da_pasta . '')->fetch();
                        if (!is_null($resultado_certidao_trf_sj_mt_situacao[0]) /*&& ($resultado_certidao_trf_sj_mt_situacao[0] != '')*/) {
                            echo '<br><strong>Último registro:</strong> <br> ';
                            echo 'Certidão ' . $resultado_certidao_trf_sj_mt_situacao['certidao_trf_sj_mt_situacao'];
                        }
                    } catch (PDOException $ex) {
                        return $ex->getMessage();
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                        <div class="input-group">
                            <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                            <input type="hidden" name="tipo_do_documento" value="certidao_trf_sj_mt">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>

                    </form>
                </div>

                <div class="form-group col-md-6">
                    <?php
                    if (isset($resultado['certidao_trf_sj_mt'])) {
                        $cert_trf_sj_mt = $resultado['certidao_trf_sj_mt'];
                        echo '<label class="form-label">Ações disponíveis:</label>'
                            . '<form action="arquivos_excluir.php" method="post">'
                            . '<div class="form-group">'
                            . '<a target="_blank" href="' . $cert_trf_sj_mt . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                            . '<input type="hidden" name="tipo_do_documento" value="certidao_trf_sj_mt">'
                            . '<input type="hidden" name="id_pasta" value="' . $id_da_pasta . '">'
                            . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                            . '</div>'
                            . '</form>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </br>
    <div class="col-md-12">
        </br>
        <h5><label class="form-label">Documentação <i>interna corporis</i></label></h5>
        <hr>

        <div id="nadaConstaCorregedoria" class="col">

            <div class="row">
                <div class="form-group col-md-6">
                    <form action="../Controllers/atualiza_tb_documentos.php" method="post">
                        <label class="form-label">Nada Consta da Corregedoria Geral</label>
                        <div class="input-group">
                            <span class="input-group-text">Status</span>
                            <select class="form-select" name="status" required>
                                <option selected disabled>Selecione a situação</option>
                                <option value="NEGATIVA">Certidão negativa</option>
                                <option value="POSITIVA">Certidão positiva</option>
                                <option value="">Ausente</option>
                            </select>
                            <input type="hidden" name="tipo_do_documento" value="nada_consta_correg_situacao">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Informe a <strong>situação</strong> correspondente.</small>
                    </form>
                </div>
                <div class="form-group col-md-6">
                    <?php
                    try {
                        $resultado_nada_consta_correg_situacao = $conn->query('SELECT nada_consta_correg_situacao  from pasta_promocional WHERE pasta_promocional.id = ' . $id_da_pasta . '')->fetch();
                        if (!is_null($resultado_nada_consta_correg_situacao[0]) /*&& ($resultado_nada_consta_correg_situacao[0] != '')*/) {
                            echo '<br><strong>Último registro:</strong> <br> ';
                            echo 'Certidão ' . $resultado_nada_consta_correg_situacao['nada_consta_correg_situacao'];
                        }
                    } catch (PDOException $ex) {
                        return $ex->getMessage();
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                        <div class="input-group">
                            <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                            <input type="hidden" name="tipo_do_documento" value="nada_consta_correg">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>
                    </form>
                </div>
                <div class="form-group col-md-6">
                    <?php
                    if (isset($resultado['nada_consta_correg'])) {
                        $nada_consta_correg = $resultado['nada_consta_correg'];
                        echo '<label class="form-label">Ações disponíveis:</label>'
                            . '<form action="arquivos_excluir.php" method="post">'
                            . '<div class="form-group">'
                            . '<a target="_blank" href="' . $nada_consta_correg . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                            . '<input type="hidden" name="tipo_do_documento" value="nada_consta_correg">'
                            . '<input type="hidden" name="id_pasta" value="' . $id_da_pasta . '">'
                            . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                            . '</div>'
                            . '</form>';
                    }
                    ?>
                </div>
            </div>

        </div>
        </br>

        <div id="conceitoMoral" class="col">
            <div class="row">
                <div class="form-group col-md-6">
                    <form action="../Controllers/atualiza_tb_documentos.php" method="post">
                        <label class="form-label">Conceito Moral</label>
                        <div class="input-group">
                            <span class="input-group-text">Status</span>
                            <select class="form-select" name="status" required>
                                <option selected disabled>Selecione a situação</option>
                                <option value="SIM">Possui conceito moral</option>
                                <option value="NÃO">Não possui conceito moral</option>
                                <option value="">Nada consta</option>
                            </select>
                            <input type="hidden" name="tipo_do_documento" value="conceito_moral_situacao">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Informe a <strong>situação</strong> correspondente.</small>
                    </form>
                </div>
                <div class="form-group col-md-6">
                    <?php
                    try {
                        $resultado_conceito_moral_situacao = $conn->query('SELECT conceito_moral_situacao  from pasta_promocional WHERE pasta_promocional.id = ' . $id_da_pasta . '')->fetch();
                        if (!is_null($resultado_conceito_moral_situacao[0]) /*&& ($resultado_conceito_moral_situacao[0] != '')*/) {
                            echo '<br><strong>Último registro:</strong> <br> ';
                            echo 'Possui conceito moral? ' . $resultado_conceito_moral_situacao['conceito_moral_situacao'];
                        }
                    } catch (PDOException $ex) {
                        return $ex->getMessage();
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">
                        <div class="input-group">
                            <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                            <input type="hidden" name="tipo_do_documento" value="conceito_moral">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>
                    </form>
                </div>
                <div class="form-group col-md-6">
                    <?php
                    if (isset($resultado['conceito_moral'])) {
                        $conceito_moral = $resultado['conceito_moral'];
                        echo '<label class="form-label">Ações disponíveis:</label>'
                            . '<form action="arquivos_excluir.php" method="post">'
                            . '<div class="form-group">'
                            . '<a target="_blank" href="' . $conceito_moral . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                            . '<input type="hidden" name="tipo_do_documento" value="conceito_moral">'
                            . '<input type="hidden" name="id_pasta" value="' . $id_da_pasta . '">'
                            . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                            . '</div>'
                            . '</form>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </br>

    <div id="cursos_e_estagios" class="col">
        <div class="row">
            <div class="form-group col-md-6">
                <form action="../Controllers/atualiza_tb_documentos.php" method="post">
                    <label class="form-label">Cursos e Estágios</label>
                    <div class="input-group">
                        <span class="input-group-text">Status</span>
                        <select class="form-select" name="status" required>
                            <option selected disabled>Selecione a situação</option>
                            <option value="SIM">Possui</option>
                            <option value="NÃO">Não possui</option>
                            <option value="">Nada consta</option>
                        </select>
                        <input type="hidden" name="tipo_do_documento" value="cursos_e_estagios_situacao">
                        <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                        <input type="submit" class="btn btn-outline-success" value="Salvar">
                    </div>
                    <small class="form-text text-muted">Informe a <strong>situação</strong> correspondente.</small>
                </form>
            </div>
            <div class="form-group col-md-6">
                <?php
                try {
                    $resultado_cursos_e_estagios_situacao = $conn->query('SELECT cursos_e_estagios_situacao  from pasta_promocional WHERE pasta_promocional.id = ' . $id_da_pasta . '')->fetch();
                    if (!is_null($resultado_cursos_e_estagios_situacao[0]) /*&& ($resultado_cursos_e_estagios_situacao[0] != '')*/) {
                        echo '<br><strong>Último registro:</strong> <br> ';
                        echo 'Possui cursos e estágios? ' . $resultado_cursos_e_estagios_situacao['cursos_e_estagios_situacao'];
                    }
                } catch (PDOException $ex) {
                    return $ex->getMessage();
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                    <div class="input-group">
                        <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                        <input type="hidden" name="tipo_do_documento" value="cursos_e_estagios">
                        <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                        <input type="submit" class="btn btn-outline-success" value="Salvar">
                    </div>
                    <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>

                </form>
            </div>
            <div class="form-group col-md-6">
                <?php
                if (isset($resultado['cursos_e_estagios'])) {
                    $cursos_e_estagios = $resultado['cursos_e_estagios'];
                    echo '<label class="form-label">Ações disponíveis:</label>'
                        . '<form action="arquivos_excluir.php" method="post">'
                        . '<div class="form-group">'
                        . '<a target="_blank" href="' . $cursos_e_estagios . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                        . '<input type="hidden" name="tipo_do_documento" value="cursos_e_estagios">'
                        . '<input type="hidden" name="id_pasta" value="' . $id_da_pasta . '">'
                        . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                        . '</div>'
                        . '</form>';
                }
                ?>
            </div>
        </div>
    </div>
    </br>

    <div id="taf" class="row">

        <div class="form-group col-md-6">

            <form action="cadastrar_taf.php" method="post">

                <label class="form-label">Avaliação de desempenho físico</label>
                <div class="input-group">
                    <span class="input-group-text">Selecionar TAF.</span>
                    <select class="form-select" name="criterio_ano_promocao_futura">
                        <?php
                        $ano_atual = date("Y");
                        for ($i = $ano_atual; $i <= ($ano_atual + 4); $i++) {
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="tipo_do_documento" value="taf">
                    <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                    <input type="submit" class="btn btn-outline-success" value="Salvar">
                </div>

            </form>
        </div>
    </div>

    </br>

    <div id="ais" class="row">
        <div class="form-group col-md-6">
            <form action="../Controllers/atualiza_tb_documentos.php" method="post">
                <label class="form-label">Ata de inspeção de saúde</label>
                <div class="input-group">
                    <span class="input-group-text">Selecionar A.I.S.</span>
                    <select class="form-select" name="id_ais">
                        <option selected disabled>Selecione a situação</option>
                        <?php
                        try {
                            //pegar no BD dados do militar selecionado
                            if (isset($militar_id)) {
                                $stmt = $conn->query("SELECT * FROM promocao.ais WHERE militar_id = '" . $militar_id . "'");
                                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                                if ($res) {
                                    $id_ais = $res['id'];
                                    $data_ais = $res['data_da_inspecao'];
                                    $aptidao = $res['aptidao'];
                                    require_once '../Controllers/alias_ultima_promocao.php';
                                    echo "<option value=" . $id_ais . ">Data: " . alias_ultima_promocao($data_ais) . " - Resultado: " . ucfirst(strtolower($aptidao)) . "</option>";
                                }
                            }
                        } catch (PDOException $ex) {
                            return $ex->getMessage();
                        }
                        ?>
                    </select>

                    <input type="hidden" name="id_pasta" value="<?= $id_da_pasta ?>">
                    <input type="submit" class="btn btn-outline-success" value="Salvar">
                </div>
            </form>

        </div>
        <div class="form-group col-md-6">
            <?php

            try {
                $resultado_ais = $conn->query('SELECT ais.aptidao, ais.bge_numero, ais.data_da_inspecao, ais.data_public  from pasta_promocional inner join ais on pasta_promocional.ais_id = ais.id WHERE pasta_promocional.id = ' . $id_da_pasta . '')->fetch();

                if ($resultado_ais) {
                    require_once '../Controllers/alias_ultima_promocao.php';
                    echo '<br><strong>Último registro de AIS</strong> <br> ';
                    echo 'Resultado: ' . $resultado_ais['aptidao'] . ' - ';
                    echo 'data: ' . alias_ultima_promocao($resultado_ais['data_da_inspecao']) . ' - ';
                    echo 'BGE nº ' . $resultado_ais['bge_numero'] . ', ';
                    echo 'de ' . alias_ultima_promocao($resultado_ais['data_public']) . '.';
                }
            } catch (PDOException $ex) {
                return $ex->getMessage();
            }
            ?>
        </div>

    </div>

    </br>
</div>

<script>
    function checkUncheck(main) {
        all = document.getElementsByName('militar_id[]');
        for (var a = 0; a < all.length; a++) {
            all[a].checked = main.checked;
        }
    }

    function mostraDica() {
        document.getElementById('paragrafoDica').innerHTML = 'Caso já exista registrada promoção para o mesmo posto/graduação, as informações serão atualizadas no banco de dados sobrescrevendo o registro anterior.'
    }

    function escondeDica() {
        document.getElementById('paragrafoDica').innerHTML = ''
    }
</script>

<?php
include_once './footer.php';
?>