<?php
include_once '../Views/header2.php';
require_once '../ConexaoDB/conexao.php';


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

            <form action="" method="POST" name="formCadastro" onsubmit="return validateForm()">
                <label class="form-label">Dados do Teste de Aptidão Física</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Data de realização</span>
                    <input type="date" class="form-control" name="data_realizacao">
                </div>
                <p id="alertaDataVazia1" style="color:#FF0000"></p>

                <div class="input-group mb-3">
                    <span class="input-group-text">Número do Boletim</span>
                    <input type="number" class="form-control" name="numero_bge" placeholder="Informe o número">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Data do Boletim</span>
                    <input type="date" class="form-control" name="data_publicacao">
                </div>
                <p id="alertaDataVazia2" style="color:#FF0000"></p>

                <hr>
                <button class="btn btn-outline-success active" type="submit">Salvar</button>
            </form>
        </div>
        <?php
        if (!is_null($erro)) {
            echo '<p><font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i> Alerta!</font></p>';
            foreach ($erro as $item) {
                echo '<p><font style="color:#ff0000">' . $item . '</font></p>';
            }
        }
        if (!is_null($sucesso_cadastro)) {
            echo '<p><font style="color:#0000ff"><i class="bi bi-person-check" fill="currentColor"></i><strong>&nbspMilitar cadastrado com sucesso!</strong></font></p>';
            $array = ['Nome:', 'Posto/Grad.:', 'Quadro:'];
            $aux = 0;
            foreach ($sucesso_cadastro as $item) {
                echo '<p><font style="color:#0000ff">' . $array[$aux] . '&nbsp';
                echo $item . '</font></p>';
                $aux++;
            }
        }
        ?>
    </div>
</div>

<script>
    function validateForm() {
        // abaixo serve para Limite de Quantitativo
        let aux1 = document.forms["formCadastro"]["data_realizacao"].value;
        if (aux1 == "" || is_null(aux1)) {
            //alert("O nome deve ser preenchido.");
            document.getElementById('alertaDataVazia1').innerHTML = '* A data do TAF deve ser preenchida.'
            return false;
        } else {
            document.getElementById('alertaDataVazia1').innerHTML = ''
        }
        
        let aux2 = document.forms["formCadastro"]["data_publicacao"].value;
        if (aux2 == "" || is_null(aux2)) {
            //alert("O QUADRO deve ser selecionado.");
            document.getElementById('alertaDataVazia2').innerHTML = '* A data da publicação deve ser preenchida.'
            return false;
        } else {
            document.getElementById('alertaDataVazia2').innerHTML = ''
        }
    }
</script>



<?php
include_once './footer2.php';
?>