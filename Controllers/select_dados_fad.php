<?php

function select_dados_fad_por_id($conn, $id_da_fad)
{
    $resultado = array();
    //pegar no BD dados do militar selecionado
    try {
        $stmt = $conn->query("SELECT * FROM promocao.fad INNER JOIN militar
            ON militar.id = fad.militar_id WHERE fad.id = $id_da_fad ");


        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

    $rowCount = $stmt->rowCount();

    if ($rowCount) {
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $resultado;
}

function select_dados_fad_por_militar_id($conn, $militar_id, $posto_grad)
{
    $resultado = array();
    //pegar no BD dados do militar selecionado
    try {
        $stmt = $conn->prepare("SELECT * FROM promocao.fad WHERE fad.militar_id = :militar_id AND fad.grau_hierarquico_na_epoca = :posto_grad");
        $stmt->execute([
            ':militar_id' => $militar_id,
            ':posto_grad' => $posto_grad
        ]);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

    $rowCount = $stmt->rowCount();

    if ($rowCount) {
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $resultado;
}