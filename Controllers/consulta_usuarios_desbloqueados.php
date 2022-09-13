<?php
function consulta_usuarios_desbloqueados($conn){

    try {
        $stmt = $conn->query("SELECT id, nome, posto_grad_usuario, email FROM usuarios WHERE nivel_de_acesso = 3");
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}