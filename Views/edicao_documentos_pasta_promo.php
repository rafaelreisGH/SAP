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
            echo '<p><font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspObservação:<br>';
            echo 'Falha ao cadastrar a ' . $documento . '!';
            echo '</font></p>';
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

    <div id="taf" class="col">
        <div class="row">
            <div class="form-group col-md-6">
                <form action="../Controllers/atualiza_tb_documentos.php" method="post" name="formTAF" onsubmit="return validateForm()">
                    <label class="form-label">Avaliação de desempenho físico</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Selecionar TAF</span>
                        <select class="form-select" name="id_taf" required>
                            <option selected disabled>Selecione o TAF</option>
                            <?php

                            $stmt = $conn->query("SELECT * FROM taf");
                            $res = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($res) {
                                $id_taf = $res['id'];
                                $data_taf = $res['data_do_taf'];
                                $bge = $res['bge_numero'];
                                $public = $res['data_public'];
                                require_once '../Controllers/alias_ultima_promocao.php';
                                echo "<option value=" . $id_taf . ">Data: " . alias_ultima_promocao($data_taf) . " - BGE: " . $bge . ", de " . alias_ultima_promocao($public) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <p id="alertaIdTafVazio" style="color:#FF0000"></p>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Aprovação no TAF</span>
                        <select class="form-select" name="taf_aptidao" required>
                            <option selected disabled>Selecione a situação</option>
                            <option value="APTO">Apto</option>
                            <option value="INAPTO">Inapto</option>
                        </select>
                    </div>
                    <p id="alertaAptidaoVazio" style="color:#FF0000"></p>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Menção obtida</span>
                        <select class="form-select" name="taf_mencao" required>
                            <option selected disabled>Selecione a menção</option>
                            <option value="E">Excelente</option>
                            <option value="MB">Muito Bom</option>
                            <option value="B">Bom</option>
                            <option value="R">Regular</option>
                            <option value="I">Insuficiente</option>
                            <option value="">Sem menção (TAF Alternativo)</option>
                        </select>
                    </div>
                    <p id="alertaMencaoVazio" style="color:#FF0000"></p>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Tipo do TAF</span>
                        <select class="form-select" name="taf_tipo" required>
                            <option selected disabled>Selecione o tipo</option>
                            <option value="ALTERNATIVO">Alternativo (TAF-5)</option>
                            <option value="PADRÃO">Padrão (TAF-3)</option>
                        </select>
                    </div>
                    <p id="alertaTipoVazio" style="color:#FF0000"></p>

                    <input type="hidden" name="id_da_pasta" value="<?= $id_da_pasta ?>">
                    <input type="hidden" name="id_militar" value="<?= $militar_id ?>">
                    <button type="submit" class="btn btn-outline-success">Salvar</button>

                </form>
            </div>
            <div class="form-group col-md-6">
                <?php
                if (isset($_GET['militar_tem_taf_id'])) {
                    $militar_tem_taf_id = $_GET['militar_tem_taf_id'];
                    try {
                        $resultado_taf = $conn->query('SELECT aptidao, mencao, tipo_do_taf FROM militar_tem_taf INNER JOIN pasta_promocional on militar_tem_taf.id = pasta_promocional.militar_tem_taf_id  WHERE militar_tem_taf.id = ' . $militar_tem_taf_id . '')->fetch();
                    } catch (PDOException $ex) {
                        echo "Falha: " . $ex->getMessage();
                    }

                    if ($resultado_taf) {
                        echo '<br><strong>Último registro de TAF</strong> <br> ';
                        echo 'Resultado: ' . $resultado_taf['aptidao'] . ' <br> ';
                        echo 'Menção: ' . $resultado_taf['mencao'] . '<br> ';
                        echo 'Tipo do TAF: ' . $resultado_taf['tipo_do_taf'] . '';
                    }
                } else {
                    $resultado_taf = $conn->query('SELECT militar_tem_taf_id FROM pasta_promocional WHERE id = ' . $id_da_pasta . '')->fetch();

                    $auxiliar = $resultado_taf['militar_tem_taf_id'];
                    if ($auxiliar != null) {
                        $resultado_taf = $conn->query('SELECT aptidao, mencao, tipo_do_taf FROM militar_tem_taf INNER JOIN pasta_promocional on militar_tem_taf.id = pasta_promocional.militar_tem_taf_id  WHERE militar_tem_taf.id = ' . $auxiliar . '')->fetch();

                        if ($resultado_taf) {
                            echo '<br><strong>Último registro de TAF</strong> <br> ';
                            echo 'Resultado: ' . $resultado_taf['aptidao'] . ' <br> ';
                            echo 'Menção: ' . $resultado_taf['mencao'] . '<br> ';
                            echo 'Tipo do TAF: ' . $resultado_taf['tipo_do_taf'] . '';
                        }
                    }
                }
                ?>
            </div>
        </div>

    </div>

    </br>

    <div id="ais" class="col">
        <div class="row">
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
                                    $stmt = $conn->query("SELECT * FROM ais WHERE militar_id = '" . $militar_id . "'");
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
                } catch (PDOException $ex) {
                    echo "Falha: " . $ex->getMessage();
                }

                if ($resultado_ais) {
                    require_once '../Controllers/alias_ultima_promocao.php';
                    echo '<br><strong>Último registro de AIS</strong> <br> ';
                    echo 'Resultado: ' . $resultado_ais['aptidao'] . ' - ';
                    echo 'data: ' . alias_ultima_promocao($resultado_ais['data_da_inspecao']) . ' - ';
                    echo 'BGE nº ' . $resultado_ais['bge_numero'] . ', ';
                    echo 'de ' . alias_ultima_promocao($resultado_ais['data_public']) . '.';
                }
                ?>
            </div>

        </div>
    </div>
</div>

</br>

</br>

<script>
    function validateForm() {
        // abaixo serve para Limite de Quantitativo
        let aux1 = document.forms["formTAF"]["id_taf"].value;
        if (aux1 == "Selecione o TAF") {
            document.getElementById('alertaIdTafVazio').innerHTML = '* É necessário especificar um TAF. Deve-se cadastrar o Evento TAF, caso não conste nenhum. <a href="/Views/cadastrar_taf.php">Clique aqui</a> para acessar a página de cadastro de TAF'
            return false;
        } else {
            document.getElementById('alertaIdTafVazio').innerHTML = ''
        }
        let aux2 = document.forms["formTAF"]["taf_aptidao"].value;
        if (aux2 == "Selecione a situação") {
            document.getElementById('alertaAptidaoVazio').innerHTML = '* Informe se o militar foi aprovado ou não.'
            return false;
        } else {
            document.getElementById('alertaAptidaoVazio').innerHTML = ''
        }
        let aux3 = document.forms["formTAF"]["taf_mencao"].value;
        if (aux3 == "Selecione a menção") {
            document.getElementById('alertaMencaoVazio').innerHTML = '* Informe a menção obtida.'
            return false;
        } else {
            document.getElementById('alertaMencaoVazio').innerHTML = ''
        }
        let aux4 = document.forms["formTAF"]["taf_tipo"].value;
        if (aux4 == "Selecione o tipo") {
            document.getElementById('alertaTipoVazio').innerHTML = '* Informe o tipo do TAF.'
            return false;
        } else {
            document.getElementById('alertaTipoVazio').innerHTML = ''
        }
    }
</script>

<?php
include_once './footer.php';
?>