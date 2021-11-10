<?php

include_once '../Views/header.php';
require_once '../ConexaoDB/conexao.php';

$data = $_POST['data'];

try {

    $stmt = $conn->prepare('INSERT INTO tb_data (data) VALUES (?)');
    $stmt->bindParam(1, $data);
    $stmt->execute();
    if ($stmt) {
        header('Location:../Controllers/data.php?data_get='.$data.'');
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>



<?php

include_once '../Views/footer.php';
?>