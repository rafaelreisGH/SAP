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
