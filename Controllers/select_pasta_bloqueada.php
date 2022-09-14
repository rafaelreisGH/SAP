<?php

function verifica_pasta_bloqueada($conn, $id)
{
    try {
        $stmt = $conn->query("SELECT pasta_promocional.id FROM pasta_promocional WHERE pasta_promocional.id = $id AND pasta_promocional.pasta_bloqueada = 1");
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

    $rowCount = $stmt->rowCount();

    if ($rowCount) {
        return true;
    } else {
        return false;
    }
}
