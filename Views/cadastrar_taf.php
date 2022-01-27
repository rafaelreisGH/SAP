<?php
include_once '../Views/header2.php';
require_once '../ConexaoDB/conexao.php';

$retorno = (isset($_GET['retorno'])) ? $_GET['retorno'] : null;
$sucesso_cadastro = (isset($_GET['dados'])) ? $_GET['dados'] : null;

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
    <div class="row justify-content-center">
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

        <div class="col-md-3">
            <?php
            if (!is_null($retorno)) {
                switch ($retorno) {
                    case 1:
                        echo 'O TAF já foi cadastrado anteriormente.';
                        break;
                    case 2:
                        echo '<p><font style="color:#0000ff"><i class="bi bi-person-check" fill="currentColor"></i><strong>&nbspO TAF foi cadastrado com sucesso!</strong></font></p>';
                        $array = ['Data de realização:', 'Data de publicação:', 'BGE nº:'];
                        $aux = 0;
                        foreach ($sucesso_cadastro as $item) {
                            echo '<p><font style="color:#0000ff">' . $array[$aux] . '&nbsp';
                            echo $item . '</font></p>';
                            $aux++;
                        }
                        break;
                    case 3:
                        echo 'Erro na tentativa de cadastro.';
                        break;
                }
            }

            ?>
        </div>

    </div>
</div>



<?php
include_once './footer2.php';
?>