<?php
require_once '../Controllers/nivel_usuario.php';
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
$stmt = $conn->query("SELECT militar_id, semestre_processo_promocional, ano_processo_promocional FROM pasta_promocional WHERE id = '$id_da_pasta'");
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($resultado['militar_id'])) {
    $militar_id = $resultado['militar_id'];
    $semestre_pasta = $resultado['semestre_processo_promocional'];
    $ano_pasta = $resultado['ano_processo_promocional'];

    $stmt = $conn->query("SELECT nome, posto_grad_mil FROM militar WHERE id = '" . $militar_id . "'");
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($res['nome'])) {
        $nome = $res['nome'];
        $posto_grad = $res['posto_grad_mil'];
    }
}
// --------------------------- //
require_once '../Controllers/verifica_permissoes_usuario.php';
verifica_permissao_usuario($conn, $militar_id);
?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="pasta_promocional_home_candidato.php?militar_id=<?= $militar_id ?>" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
    </div>

    <h4><strong>Edição de documentos da pasta</strong></h4>
    <div class="form-text">
        <p><?= $posto_grad ?>&nbsp<?= $nome ?></br>
            Referência:&nbsp<?= $semestre_pasta ?>º semestre de <?= $ano_pasta ?></p>
    </div>
    <hr>

    <h5><label class="form-label">Certidões da Justiça</label></h5>
    <hr>

    <div id="certidoesJustiça" class="col-md-12">
        <div id="certidaoTj1Inst" class="col">
            <div class="row">
                <div class="form-group col-md-6">
                    <form enctype="multipart/form-data" action="arquivos_upload_candidato.php" method="post">
                        <label class="form-label">Certidão TJ-MT - 1ª instância</label>
                        <div class="input-group">
                            <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                            <input type="hidden" name="tipo_do_documento" value="certidao_tj_1_inst">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>
                    </form>
                </div>

                <?php
                $stmt = $conn->query("SELECT documento.id, documento_valido, informacao, visto_em, caminho_do_arquivo FROM documento WHERE pasta_promo_id = '$id_da_pasta' AND descricao = 'certidao_tj_1_inst'");
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                if (isset($resultado['id'])) {
                    $id_documento = $resultado['id'];
                    $certidao_tj_1_inst = $resultado['caminho_do_arquivo'];
                    echo '<div class="form-group col-md-6">'
                        . '<label class="form-label">Ações disponíveis:</label>'
                        . '<form action="arquivos_excluir_candidato.php" method="post">'
                        . '<div class="form-group">'
                        . '<a target="_blank" href="' . $certidao_tj_1_inst . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                        . '<input type="hidden" name="id_documento" value="' . $id_documento . '">'
                        . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                        . '</div>'
                        . '</form>'
                        . '</div>';
                }
                ?>
            </div>

            <?php
            if ((isset($resultado['documento_valido'])) && ($resultado['documento_valido'] == 1)) {
                echo '<div class="row"><div class="form-text">'
                    . '<p>'
                    . '<font style="color:#0000ff"><i class="bi bi-check-circle" fill="currentColor"></i>&nbsp'
                    . 'Certidão TJ-MT - 1ª instância: documento em conformidade.</font></br></p>'
                    . '</div></div>';
            } else if ((isset($resultado['documento_valido'])) && ($resultado['documento_valido'] == 0)) {
                echo '<p><font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspInformação da SCP:<br>';
                echo  $resultado['informacao'] . '.';
                echo '</font></p>';
            }
            ?>

        </div>

        <br>

        <div id="certidaoTj2Inst" class="col">
            <div class="row">
                <div class="form-group col-md-6">
                    <form enctype="multipart/form-data" action="arquivos_upload_candidato.php" method="post">
                        <label class="form-label">Certidão TJ-MT - 2ª instância</label>
                        <div class="input-group">
                            <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                            <input type="hidden" name="tipo_do_documento" value="certidao_tj_2_inst">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>

                    </form>
                </div>

                <?php
                $stmt = $conn->query("SELECT documento.id, documento_valido, informacao, visto_em, caminho_do_arquivo FROM documento WHERE pasta_promo_id = '$id_da_pasta' AND descricao = 'certidao_tj_2_inst'");
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                if (isset($resultado['id'])) {
                    $id_documento = $resultado['id'];
                    $certidao_tj_2_inst = $resultado['caminho_do_arquivo'];
                    echo '<div class="form-group col-md-6">'
                        . '<label class="form-label">Ações disponíveis:</label>'
                        . '<form action="arquivos_excluir_candidato.php" method="post">'
                        . '<div class="form-group">'
                        . '<a target="_blank" href="' . $certidao_tj_2_inst . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                        . '<input type="hidden" name="id_documento" value="' . $id_documento . '">'
                        . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                        . '</div>'
                        . '</form>'
                        . '</div>';
                }
                ?>
            </div>

            <?php
            if ((isset($resultado['documento_valido'])) && ($resultado['documento_valido'] == 1)) {
                echo '<div class="row"><div class="form-text">'
                    . '<p>'
                    . '<font style="color:#0000ff"><i class="bi bi-check-circle" fill="currentColor"></i>&nbsp'
                    . 'Certidão TJ-MT - 2ª instância: documento em conformidade.</font></br></p>'
                    . '</div></div>';
            } else if ((isset($resultado['documento_valido'])) && ($resultado['documento_valido'] == 0)) {
                echo '<p><font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspInformação da SCP:<br>';
                echo  $resultado['informacao'] . '.';
                echo '</font></p>';
            }
            ?>

        </div>

        </br>

        <div id="certidaoTRF1" class="col">
            <div class="row">
                <div class="form-group col-md-6">
                    <form enctype="multipart/form-data" action="arquivos_upload_candidato.php" method="post">
                        <label class="form-label">Certidão Conjunta TRF-1 e TRF-1 Seção Judiciária MT</label>
                        <div class="input-group">
                            <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                            <input type="hidden" name="tipo_do_documento" value="certidao_trf_1">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>

                    </form>
                </div>

                <?php
                $stmt = $conn->query("SELECT documento.id, documento_valido, informacao, visto_em, caminho_do_arquivo FROM documento WHERE pasta_promo_id = '$id_da_pasta' AND descricao = 'certidao_trf_1'");
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                if (isset($resultado['id'])) {
                    $id_documento = $resultado['id'];
                    $cert_trf_1 = $resultado['caminho_do_arquivo'];
                    echo '<div class="form-group col-md-6">'
                        . '<label class="form-label">Ações disponíveis:</label>'
                        . '<form action="arquivos_excluir_candidato.php" method="post">'
                        . '<div class="form-group">'
                        . '<a target="_blank" href="' . $cert_trf_1 . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                        . '<input type="hidden" name="id_documento" value="' . $id_documento . '">'
                        . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                        . '</div>'
                        . '</form>'
                        . '</div>';
                }
                ?>
            </div>

            <?php
            if ((isset($resultado['documento_valido'])) && ($resultado['documento_valido'] == 1)) {
                echo '<div class="row"><div class="form-text">'
                    . '<p>'
                    . '<font style="color:#0000ff"><i class="bi bi-check-circle" fill="currentColor"></i>&nbsp'
                    . 'Certidão TRF-1: documento em conformidade.</font></br></p>'
                    . '</div></div>';
            } else if ((isset($resultado['documento_valido'])) && ($resultado['documento_valido'] == 0)) {
                echo '<p><font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspInformação da SCP:<br>';
                echo  $resultado['informacao'] . '.';
                echo '</font></p>';
            }
            ?>

        </div>

        </br>

        <div id="certidaoCrimesEleitorais" class="col">
            <div class="row">
                <div class="form-group col-md-6">
                    <form enctype="multipart/form-data" action="arquivos_upload_candidato.php" method="post">
                        <label class="form-label">Certidão de Crimes Eleitorais - TSE</label>
                        <div class="input-group">
                            <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                            <input type="hidden" name="tipo_do_documento" value="certidao_tse">
                            <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                            <input type="submit" class="btn btn-outline-success" value="Salvar">
                        </div>
                        <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>

                    </form>
                </div>

                <?php
                $stmt = $conn->query("SELECT documento.id, documento_valido, informacao, visto_em, caminho_do_arquivo FROM documento WHERE pasta_promo_id = '$id_da_pasta' AND descricao = 'certidao_tse'");
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                if (isset($resultado['id'])) {
                    $id_documento = $resultado['id'];
                    $certidao_tse = $resultado['caminho_do_arquivo'];
                    echo '<div class="form-group col-md-6">'
                        . '<label class="form-label">Ações disponíveis:</label>'
                        . '<form action="arquivos_excluir_candidato.php" method="post">'
                        . '<div class="form-group">'
                        . '<a target="_blank" href="' . $certidao_tse . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                        . '<input type="hidden" name="id_documento" value="' . $id_documento . '">'
                        . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                        . '</div>'
                        . '</form>'
                        . '</div>';
                }
                ?>
            </div>
            <?php
            if ((isset($resultado['documento_valido'])) && ($resultado['documento_valido'] == 1)) {
                echo '<div class="row"><div class="form-text">'
                    . '<p>'
                    . '<font style="color:#0000ff"><i class="bi bi-check-circle" fill="currentColor"></i>&nbsp'
                    . 'Certidão TJ-MT - 2ª instância: documento em conformidade.</font></br></p>'
                    . '</div></div>';
            } else if ((isset($resultado['documento_valido'])) && ($resultado['documento_valido'] == 0)) {
                echo '<p><font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspInformação da SCP:<br>';
                echo  $resultado['informacao'] . '.';
                echo '</font></p>';
            }

            ?>
        </div>

    </div>

    <?php
    include_once './footer.php';
    ?>