<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';
$conn = Conexao::getConexao();

if (isset($_GET['relatorio']) && ($_GET['relatorio'] == 1)) {
    $action = "listar_resultado_LQ_TC_documentos.php";
    $relatorio = "Relatório de documentação entregue à Secretaria das Comissões de Promoção (SCP)";
} else {
    $action = "listar_resultado_LQ_TC.php";
    $relatorio = "Seleção de critérios para Limite de Quantitativo por Antiguidade";
}
?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="pagina_ferramentas.php" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
    </div>
    <form action="<?= $action ?>" method="POST" name="formLQ" onsubmit="return validateForm()">

        <h3><strong>Seleção de critérios de pesquisa TCs com interstício</strong></h3>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-3">
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="ano_promocao_futura">Ano</span>
                        <select class="form-select" name="criterio_ano_promocao_futura" id="FormControlSelectAno">
                            <?php
                            $ano_atual = date("Y");
                            for ($i = $ano_atual; $i <= ($ano_atual + 4); $i++) {
                                echo "<option value=" . $i . ">" . $i . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="dia_mes_promocao_futura">Dia/mês</span>
                        <select class="form-select" name="criterio_dia_mes_promocao_futura">
                            <!-- <option value="" selected disabled>Selecione o dia e o mês</option> -->
                            <!-- <option value="07-02">02 de julho</option> -->
                            <option value="12-02" selected>02 de dezembro</option>
                            <!-- <option value="12-21">21 de dezembro</option> -->
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="quadroMilitar">Quadro</span>
                        <select class="form-select" name="criterio_quadro">
                            <!-- <option value="" selected disabled>Selecione o quadro</option> -->
                            <option value="COMBATENTE" selected>COMBATENTE</option>
                            <!-- <option value="COMPLEMENTAR">COMPLEMENTAR</option> -->
                            <!-- <option value="SAÚDE">SAÚDE</option> -->
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="criar_pasta" value="1" id="flexCheckPasta">
                        <label class="form-check-label" for="flexCheckPasta">
                            Criar pastas promocionais?
                        </label>
                    </div>
                </div>
            </div>
            </br>
            <button class="btn btn-outline-primary active" type="submit" name="buscar">Buscar</button>
        </div>
</div>
</form>
</div>

<script>
    function validateForm() {
        // abaixo serve para Limite de Quantitativo
        let m = document.forms["formLQ"]["criterio_ano_promocao_futura"].value;
        if (m == "") {
            alert("O quesito ANO deve ser preenchido");
            return false;
        }
        let n = document.forms["formLQ"]["criterio_dia_mes_promocao_futura"].value;
        console.log(n);
        if (n == "") {
            alert("O quesito DIA/MêS deve ser preenchido");
            return false;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const checkbox = document.querySelector('#flexCheckPasta');

        form.addEventListener('submit', function(e) {
            if (checkbox.checked) {
                const confirmar = confirm("Você tem certeza que deseja criar as pastas promocionais?");
                if (!confirmar) {
                    e.preventDefault(); // Cancela o envio do form
                }
            }
        });
    });
</script>

<?php
include_once './footer2.php';
?>