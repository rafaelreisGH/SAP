<?php

require_once '../ConexaoDB/conexao.php';

$id_militar = $_POST['id'];
$semestre = $_POST['semestre'];
$ano = $_POST['ano'];
$postoGradNoPerioAvaliado = filter_input(INPUT_POST, 'postoGradNoPerioAvaliado', FILTER_SANITIZE_STRING);
$pontuacao = filter_input(INPUT_POST, 'pontuacao', FILTER_VALIDATE_FLOAT);

$consulta = $conn->query("SELECT id, semestre, ano FROM fad WHERE militar_id = '" . $id_militar . "'"
    . "AND semestre = '" . $semestre . "' "
    . "AND ano = '" . $ano . "'");
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
//declaração de variáveis auxiliares
$aux_ano;
$aux_sem;
$id_militar_fad;
if (!empty($resultado)) {
    $aux_ano = $resultado['ano'];
    $aux_sem = $resultado['semestre'];
    $id_militar_fad = $resultado['id'];
    if (($aux_ano == $ano) && ($aux_sem == $semestre)) {
        // $stmt = $conn->prepare("UPDATE fad SET ano = :ano, semestre = :semestre, nota = :nota, militar_id = :militar_id WHERE id = :id");
        // $stmt->execute(array(
        //     ':id' => $id_militar_fad,
        //     ':ano' => $ano,
        //     ':semestre' => $semestre,
        //     ':nota' => $pontuacao,
        //     ':militar_id' => $id_militar,
        // ));
        header('Location:../Views/insere_fad.php?militar_id=' . $id_militar . '&erro=1');
    }
} else {
    $stmt = $conn->prepare("INSERT INTO fad (ano, semestre, nota, militar_id, grau_hierarquico_na_epoca) VALUES (?,?,?,?,?)");
    $stmt->bindParam(1, $ano);
    $stmt->bindParam(2, $semestre);
    $stmt->bindParam(3, $pontuacao);
    $stmt->bindParam(4, $id_militar);
    $stmt->bindParam(5, $postoGradNoPerioAvaliado);
    $stmt->execute();
    if ($stmt) {
        header('Location:../Views/insere_fad.php?nota=' . $pontuacao . '&militar_id=' . $id_militar . '&semestre=' . $semestre . '&id=' . $semestre . '&ano=' . $ano . '');
    }
}
