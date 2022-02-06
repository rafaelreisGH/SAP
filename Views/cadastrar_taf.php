<?php
include_once '../Views/header2.php';
require_once '../ConexaoDB/conexao.php';

$retorno = (isset($_GET['retorno'])) ? $_GET['retorno'] : null;
$sucesso_cadastro = (isset($_GET['dados'])) ? $_GET['dados'] : null;

try {
    $stmt = $conn->query("SELECT * FROM promocao.taf");
    // $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    return $ex->getMessage();
}

?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <?php
            echo ('<li class="nav-item"><a class="nav-link active" aria-current="page" href="../Views/pagina_ferramentas.php">Voltar</a></li>');
            ?>
        </ul>
        <hr>
    </div>

    <h3><strong>Inserção de dados sobre TAF</strong></h3>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <form action="../Controllers/inserir_evento_taf.php" method="POST" name="formCadastro">
                <label class="form-label">Dados do Teste de Aptidão Física</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Data de realização</span>
                    <input type="date" class="form-control" name="data_realizacao" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Número do Boletim</span>
                    <input type="number" class="form-control" name="numero_bge" placeholder="Informe o número" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Data do Boletim</span>
                    <input type="date" class="form-control" name="data_publicacao" required>
                </div>

                <hr>
                <button class="btn btn-outline-success active" type="submit">Salvar</button>
            </form>
        </div>

        <div class="col-md-6">
            <br>
            <?php
            if (!is_null($retorno)) {
                switch ($retorno) {
                    case 1:
                        echo 'O TAF já foi cadastrado anteriormente.';
                        break;
                    case 2:
                        echo '<p><font style="color:#0000ff"><i class="bi bi-person-check" fill="currentColor"></i><strong>&nbspO TAF foi cadastrado com sucesso!</strong></font></p>';
                        $array = ['Data de realização:', 'BGE nº:', 'Data de publicação:'];
                        $aux = 0;
                        foreach ($sucesso_cadastro as $item) {
                            echo '<p><font style="color:#0000ff">' . $array[$aux] . '&nbsp';
                            echo $item . '</font></p>';
                            $aux++;
                        }
                        break;
                    case 3:
                        echo '<p><font style="color:#0000ff">Erro na tentativa de cadastro.</font></p>';
                        break;
                    case 4:
                        echo '<p><font style="color:#0000ff">Registro(s) excluído(s) com sucesso.</font></p>';
                        break;
                }
            }
            ?>
        </div>
    </div>

    <hr>
    <h3><strong>Edição de dados sobre TAF</strong></h3>
    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-body">
                    <form action="../Controllers/inserir_evento_taf.php" method="POST">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                                <tr>
                                    <th>
                                        <p align="center"></br>

                                            <input type="checkbox" class="btn-check" id="btn-check" autocomplete="off" onclick="checkUncheck(this)">
                                            <label class="btn btn-light" for="btn-check"><strong>Selecionar todos</strong></label>
                                        </p>
                                    </th>
                                    <th>
                                        <p align="center">TAF realizado em</p>
                                    </th>
                                    <th>
                                        <p align="center">Número do BGE</p>
                                    </th>
                                    <th>
                                        <p align="center">BGE publicado em</p>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $aux_id = $resultado['id'];
                                    $aux_data_do_taf = $resultado['data_do_taf'];
                                    $aux_bge = $resultado['bge_numero'];
                                    $aux_data_public = $resultado['data_public'];

                                    require_once '../Controllers/alias_ultima_promocao.php';
                                    $aux_data_do_taf = alias_ultima_promocao($aux_data_do_taf);
                                    $aux_data_public = alias_ultima_promocao($aux_data_public);

                                    echo '<tr>'
                                        . '<td align="center"><input class="form-check-input mt-0" type="checkbox" value="' . $aux_id . '" name="aux_id[]"></td>'
                                        . '<td align="center">' . $aux_data_do_taf . '</td>'
                                        . '<td align="center">' . $aux_bge . '</td>'
                                        . '<td align="center">' . $aux_data_public . '</td>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <button class="btn btn-outline-danger active" type="submit" name="excluir">Excluir registro(s)</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<br>

<script>
    function checkUncheck(main) {
        all = document.getElementsByName('aux_id[]');
        for (var a = 0; a < all.length; a++) {
            all[a].checked = main.checked;
        }
    }
</script>

<?php
include_once './footer2.php';
?>