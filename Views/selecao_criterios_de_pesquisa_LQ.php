<?php
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';
include_once '../Controllers/verifica_permissoes.php';
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
    <form action="../Controllers/processa_LQ.php" method="POST" name="formLQ" onsubmit="return validateForm()">
        <h3><strong>Seleção de critérios para Limite de Quantitativo por Antiguidade</strong></h3>
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
                            <option value="" selected disabled>Selecione o dia e o mês</option>
                            <option value="07-02">02 de julho</option>
                            <option value="12-02">02 de dezembro</option>
                            <option value="12-21">21 de dezembro</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="quadroMilitar">Quadro</span>
                        <select class="form-select" name="criterio_quadro">
                            <option value="" selected disabled>Selecione o quadro</option>
                            <option value="COMBATENTE">COMBATENTE</option>
                            <option value="COMPLEMENTAR">COMPLEMENTAR</option>
                            <option value="SAÚDE">SAÚDE</option>
                        </select>
                    </div>
                </div>
            </div>
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
        let o = document.forms["formLQ"]["criterio_quadro"].value;
        if (o == "") {
            alert("O quesito QUADRO deve ser preenchido");
            return false;
        }
    }
</script>

<?php
include_once './footer2.php';
?>