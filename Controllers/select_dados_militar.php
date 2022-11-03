<?php

function select_dados_militar_por_id_da_pasta($conn, $vetor)
{
    $resultado = array();
    foreach ($vetor as $id) {
        //pegar no BD dados do militar selecionado
        try {
            $stmt = $conn->query("SELECT militar.id, militar.nome, militar.posto_grad_mil, militar.quadro
    FROM militar
    INNER JOIN pasta_promocional
    ON militar.id = pasta_promocional.militar_id
    WHERE pasta_promocional.id = $id ");
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        $rowCount = $stmt->rowCount();

        if ($rowCount) {
            $resultado[] = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    return $resultado;
}

function select_dados_militar_por_id_da_pasta2($conn, $vetor)
{
    $resultado = array();
    foreach ($vetor as $id) {
        //pegar no BD dados do militar selecionado
        try {
            $stmt = $conn->query("SELECT militar.id, militar.nome, militar.posto_grad_mil, militar.quadro, pasta_promocional.ano_processo_promocional, pasta_promocional.semestre_processo_promocional
    FROM militar
    INNER JOIN pasta_promocional
    ON militar.id = pasta_promocional.militar_id
    WHERE pasta_promocional.id = $id ");
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        $rowCount = $stmt->rowCount();

        if ($rowCount) {
            $resultado[] = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    return $resultado;
}

function select_dados_militar_por_id($conn, $id)
{
    $resultado = array();
    //pegar no BD dados do militar selecionado
    try {
        $stmt = $conn->query("SELECT militar.id, militar.nome, militar.posto_grad_mil FROM militar WHERE militar.id = $id ");
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

    $rowCount = $stmt->rowCount();

    if ($rowCount) {
        $aux[] = $stmt->fetch(PDO::FETCH_ASSOC);
        $resultado[] = $aux[0]['nome'];
        $resultado[] = $aux[0]['posto_grad_mil'];
    }

    return $resultado;
}

function select_dados_avaliador()
{
    $aux1 = $_SESSION['nome'];
    $aux2 = $_SESSION['posto_grad_usuario'];

    $resultado = $aux1 . " - " . $aux2;

    return $resultado;
}