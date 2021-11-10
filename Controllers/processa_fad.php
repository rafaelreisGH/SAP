<?php

require_once '../ConexaoDB/conexao.php';

$id = $_POST['id'];
$ano = $_POST['ano'];
$semestre = $_POST['semestre'];
$pontuacao = $_POST['pontuacao'];

$consulta = $conn->query("SELECT id, semestre, ano FROM fad WHERE militar_id = '" . $id . "'"
        . "AND semestre = '" . $semestre . "' "
        . "AND ano = '" . $ano . "'");
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
//declaração de variáveis auxiliares
$aux_ano;
$aux_sem;
$id_fad;
if (isset($resultado)) {
    $aux_ano = $resultado['ano'];
    $aux_sem = $resultado['semestre'];
    $id_fad = $resultado['id_fad'];
}
if (($aux_ano == $ano) && ($aux_sem == $semestre)) {
    $stmt = $conn->prepare("UPDATE fad SET ano = :ano, semestre = :semestre, nota = :nota, militar_id = :militar_id WHERE id = :id");
    $stmt->execute(array(
        ':id' => $id_fad,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':nota' => $pontuacao,
        ':militar_id' => $id,
    ));
    header('Location:../Views/insere_fad.php?militar_id=' . $id . '&erro=1');
} else {
    $stmt = $conn->prepare("INSERT INTO fad (ano, semestre, nota, militar_id) VALUES (?,?,?,?)");
    $stmt->bindParam(1, $ano);
    $stmt->bindParam(2, $semestre);
    $stmt->bindParam(3, $pontuacao);
    $stmt->bindParam(4, $id);
    $stmt->execute();
    if ($stmt) {
        header('Location:../Views/insere_fad.php?nota=' . $pontuacao . '&militar_id=' . $id . '&semestre=' . $semestre . '&id=' . $semestre . '&ano=' . $ano . '');
    }
}



