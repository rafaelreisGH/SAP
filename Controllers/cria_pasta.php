<?php

require_once '../ConexaoDB/conexao.php';

$id = $_POST['id'];
echo $id . '<br>';
$ano = $_POST['ano'];
$semestre = $_POST['semestre'];

$consulta = $conn->query("SELECT id, semestre_processo_promocional, ano_processo_promocional FROM pasta_promocional WHERE militar_id = '" . $id . "'"
    . "AND semestre_processo_promocional = '" . $semestre . "' "
    . "AND ano_processo_promocional = '" . $ano . "'");
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
//declaração de variáveis auxiliares
if ($resultado) {
    header('Location:../Views/cadastro_de_pasta.php?militar_id=' . $id . '&erro=0');
} else {
    $stmt = $conn->prepare("INSERT INTO pasta_promocional (ano_processo_promocional, semestre_processo_promocional, militar_id) VALUES (?,?,?)");
    $stmt->bindParam(1, $ano);
    $stmt->bindParam(2, $semestre);
    $stmt->bindParam(3, $id);
    $stmt->execute();
    if ($stmt) {
        header('Location:../Views/cadastro_de_pasta.php?militar_id=' . $id . '&erro=1');
    }
}
