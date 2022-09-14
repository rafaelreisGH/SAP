<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';

$alteracao_antiguidade = isset($_GET['alteracao_antiguidade']) ? $_GET['alteracao_antiguidade'] : null;
$promover = isset($_GET['promover']) ? $_GET['promover'] : null;
$pasta = isset($_GET['pasta']) ? $_GET['pasta'] : null;

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
    <form action="listar_pastas.php" method="POST">
        <h3>
            <strong>Seleção de critérios de pesquisa</strong>
        </h3>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="col">
                    <div class="input-group mb-3">
                        <label for="basic-addon3" class="form-label">Informações da pasta</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Ano da pasta</span>
                            <select class="form-control" id="exampleFormControlSelect1" name="ano">
                                <?php
                                $ano_atual = date("Y");
                                for ($i = $ano_atual; $i >= 2014; $i--) {
                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                                ?>
                            </select>
                            <small id="anoHelp" class="form-text text-muted">Insira o <strong>ano</strong> correspondente ao processo promocional.</small>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Semestre da pasta</span>
                            <select class="form-control" id="exampleFormControlSelect2" name="semestre">
                                <option value="1" <?php if (date("m") <= 6) echo 'selected'; ?>>1º Semestre</option>
                                <option value="2" <?php if (date("m") >= 7) echo 'selected'; ?>>2º Semestre</option>
                            </select>
                            <small id="anoHelp" class="form-text text-muted">Insira o <strong>semestre</strong> correspondente ao processo promocional.</small>
                        </div>
                    </div>
                </div>
                <button class="btn btn-outline-primary active" type="submit" name="buscar">Buscar</button>
            </div>
        </div>
    </form>
</div>

<?php
include_once './footer2.php';
?>