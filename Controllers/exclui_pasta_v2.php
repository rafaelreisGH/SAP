<?php

require_once '../ConexaoDB/conexao.php';

$id = $_POST['id_da_pasta'];
$militar_id = $_POST['militar_id'];

try {
    $stmt = $conn->prepare('DELETE FROM pasta_promocional WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $success = $stmt->execute(); // Armazena o resultado da execução

    // Verifica se a exclusão foi bem-sucedida
    if ($success && $stmt->rowCount() > 0) {
        header('Location:../Views/pasta_promocional_home.php?militar_id=' . $militar_id . '');
    } else {
        header('Location:../Views/acesso_restrito.php');
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
