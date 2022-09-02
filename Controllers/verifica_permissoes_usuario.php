<?php

function verifica_permissao_usuario($conn, $militar_id)
{
    try {
        $stmt = $conn->prepare('SELECT militar_id FROM usuario_acesso_militar WHERE usuario_id = :id');
        $stmt->execute(array(
            ':id' => $_SESSION['id'],
        ));
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    //primeiro transpões as informações do ARRAY ASSOCIATIVO e coloca num ARRAY normal
    foreach ($res as $item) {
        $aux[] = $item['militar_id'];
    }

    //verificação propriamente dita e redirecionamento
    if (!in_array($militar_id, $aux)) {
        header('Location: ../Views/acesso_restrito.php');
    }
}
