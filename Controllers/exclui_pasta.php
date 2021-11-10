<?php

require_once '../ConexaoDB/conexao.php';

$id = $_POST['id'];
$ano = $_POST['ano'];
$semestre = $_POST['semestre'];

try {

    $stmt = $conn->prepare('DELETE FROM pasta_promocional WHERE militar_id = :id AND ano_processo_promocional = :ano AND semestre_processo_promocional = :semestre');
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':ano', $ano);
    $stmt->bindParam(':semestre', $semestre);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    if ($rowCount != 0) {
        header('Location:../Views/exclusão_de_pasta.php?militar_id=' . $id . '&erro=1');
    } else {
        header('Location:../Views/exclusão_de_pasta.php?militar_id=' . $id . '&erro=0');
    }
    //echo $stmt->rowCount();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

/*
$delete = "DELETE FROM pasta_promocional WHERE id_pasta_promocional = '" . $id . "' AND ano_processo_promocional = '".$ano."' AND semestre_processo_promocional = '".$ano."' ";

try {
    $conn->exec($delete);
    header('Location:../Views/exclusão_de_pasta.php?militar_id=' . $id . '&erro=1');
} catch (PDOException $e) {
    echo $delete . "<br>" . $e->getMessage();
    header('Location:../Views/exclusão_de_pasta.php?militar_id=' . $id . '&erro=0');
}
$conn = null;
*/