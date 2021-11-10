<?php
require_once '../ConexaoDB/conexao.php';

$antiguidade = (int)$_POST['antiguidade'];
$numero_liberado = $antiguidade;

$vetor = array();

//pegar as antiguidades dos militares a partir do que será inativado
$stmt = $conn->prepare("SELECT id, antiguidade FROM militar WHERE antiguidade >= :antiguidade ORDER BY antiguidade");
$stmt->execute([
    ':antiguidade' => $antiguidade
]);
while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $valor = $resultado['antiguidade'];
    $key = $resultado['id'];
    $vetor += ["{$key}" => $valor];
}
//------------------

//esta variável grava o id do militar inativado
$aux = array_search($antiguidade, $vetor);
//liberar no BD a antiguidade do militar inativado e coloca o status como inativo
$stmt = $conn->prepare('UPDATE militar SET antiguidade = null, status = "INATIVO" WHERE id = :id');
$stmt->execute(array(
    ':id' => $aux
));
//------------------

//chamada da função de liberação/ordenação de antiguidade
require_once "../Controllers/libera_antiguidade.php";
$vetor = liberarAntiguidade($vetor, $numero_liberado);
//------------------



foreach ($vetor as $id => $antiguidade) {
    $antiguidade = $antiguidade;

    $stmt = $conn->prepare('UPDATE militar SET antiguidade = :antiguidade WHERE id = :id');
    $stmt->execute(array(
        ':id' => $id,
        ':antiguidade' => $antiguidade
    ));
}
if ($stmt) {
    header('Location:../Views/listar_militares.php?pesquisar=');
}
