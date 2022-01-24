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
    <!-- <h6><strong>Referência:&nbsp</strong><?= $semestre_pasta ?>º semestre de <?= $ano_pasta ?></h3> -->
    <hr>
    <div class="col-md-12">
        </br>
        <h5><label class="form-label">Certidões da Justiça</label></h5>
        <hr>

        <div id="certidaoTj1Inst" class="row">

            <div class="form-group col-md-6">

                <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                    <label class="form-label">Certidão TJ-MT - 1ª instância</label>
                    <div class="input-group">
                        <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                        <input type="hidden" name="tipo_do_documento" value="certidao_tj_1_inst">
                        <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                        <input type="submit" class="btn btn-outline-success" value="Salvar">
                    </div>

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
        </br>
        <div id="certidaoTj2Inst" class="row">

            <div class="form-group col-md-6">

                <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                    <label class="form-label">Certidão TJ-MT - 2ª instância</label>
                    <div class="input-group">
                        <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                        <input type="hidden" name="tipo_do_documento" value="certidao_tj_2_inst">
                        <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                        <input type="submit" class="btn btn-outline-success" value="Salvar">
                    </div>

                </form>
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
        <div id="certidaoTRF1" class="row">

            <div class="form-group col-md-6">

                <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                    <label class="form-label">Certidão TRF-1</label>
                    <div class="input-group">
                        <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                        <input type="hidden" name="tipo_do_documento" value="certidao_trf_1">
                        <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                        <input type="submit" class="btn btn-outline-success" value="Salvar">
                    </div>

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
        </br>
        <div id="certidaoTRFSjMT" class="row">

            <div class="form-group col-md-6">

                <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                    <label class="form-label">Certidão TRF Seção Judiciária - MT</label>
                    <div class="input-group">
                        <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                        <input type="hidden" name="tipo_do_documento" value="certidao_trf_sj_mt">
                        <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                        <input type="submit" class="btn btn-outline-success" value="Salvar">
                    </div>

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
        </br>
    </div>
    <div class="col-md-12">
        </br>
        <h5><label class="form-label">Documentação <i>interna corporis</i></label></h5>
        <hr>

        <div id="nadaConstaCorregedoria" class="row">

            <div class="form-group col-md-6">

                <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                    <label class="form-label">Nada Consta da Corregedoria Geral</label>
                    <div class="input-group">
                        <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                        <input type="hidden" name="tipo_do_documento" value="nada_consta_correg">
                        <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                        <input type="submit" class="btn btn-outline-success" value="Salvar">
                    </div>

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
        </br>
        <div id="conceitoMoral" class="row">

            <div class="form-group col-md-6">

                <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                    <label class="form-label">Conceito Moral</label>
                    <div class="input-group">
                        <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                        <input type="hidden" name="tipo_do_documento" value="conceito_moral">
                        <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                        <input type="submit" class="btn btn-outline-success" value="Salvar">
                    </div>

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
        </br>
        <div id="cursos_e_estagios" class="row">

            <div class="form-group col-md-6">

                <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                    <label class="form-label">Cursos e Estágios</label>
                    <div class="input-group">
                        <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                        <input type="hidden" name="tipo_do_documento" value="cursos_e_estagios">
                        <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                        <input type="submit" class="btn btn-outline-success" value="Salvar">
                    </div>

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
        </br>

    </div>

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