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

        <div class="row">

            <div class="form-group col-md-6">

                <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                    <label class="form-label">Certidão TJ-MT - 1ª instância</label>
                    <div class="input-group">
                        <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                        <input type="submit" class="btn btn-outline-success" value="Salvar">
                        <input type="hidden" name="tipo_do_documento" value="certidao_tj_1_inst">
                        <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                    </div>

                </form>
            </div>

            <div class="form-group col-md-6">
                <?php
                if (isset($resultado['certidao_tj_1_inst'])) {
                    $cert_tj_1 = $resultado['certidao_tj_1_inst'];
                    echo '<label class="form-label">Ações disponíveis:</label>'
                        . '<form action="arquivos_excluir.php" method="post">'
                        . '<div class="form-group">'
                        . '<a target="_blank" href="' . $cert_tj_1 . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
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
        <div class="row">
            <div class="form-group col-md-6">
                <label for="inputGroupFile04" class="form-label">Certidão TJ-MT - 1ª instância</label>
                <div class="input-group">
                    <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    <button class="btn btn-outline-success" type="button" id="inputGroupFileAddon04">Salvar</button>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="inputGroupFile04" class="form-label">Certidão TJ-MT - 2ª instância</label>
                <div class="input-group">
                    <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    <button class="btn btn-outline-success" type="button" id="inputGroupFileAddon04">Salvar</button>
                </div>
            </div>
        </div>
        </br>
        <hr>
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