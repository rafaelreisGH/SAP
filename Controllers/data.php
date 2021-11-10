<?php
include_once '../Views/header.php';
require_once '../ConexaoDB/conexao.php';
?>
<form action="teste_data.php" method="POST">
    <label>Data</label>
    <input type="date" name="data" value="" />
    <input type="submit" value="Salvar" />
    <br>
</form>

<?php
if (isset($_GET['data_get'])) {
    $aux = $_GET['data_get'];
    echo $aux . '<br>';
    list($ano, $mes, $dia) = explode("-", $aux);
    echo $dia.'/'.$mes.'/'.$ano;
}
?>

<?php
include_once '../Views/footer.php';
?>

