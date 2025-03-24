<?php
require_once '../Controllers/funcoes_intersticio.php';

function pega_tempo_minimo_arregimentado($posto_grad, $conn)
{
    $consulta =  $conn->query("SELECT * FROM promocao.tempo_arregimentado")->fetch(PDO::FETCH_ASSOC); 
    switch ($posto_grad) {
        case 'TC BM':
            return $consulta['tempo_tc'];
        case 'MAJ BM':
            return $consulta['tempo_maj'];
        case 'CAP BM':
            return $consulta['tempo_cap'];
        case '1º TEN BM':
            return $consulta['tempo_1ten'];
        case '2º TEN BM':
            return $consulta['tempo_2ten'];
        case 'ST BM':
            return $consulta['tempo_st'];
        case '1º SGT BM':
            return $consulta['tempo_1sgt'];
        case '2º SGT BM':
            return $consulta['tempo_2sgt'];
        case '3º SGT BM':
            return $consulta['tempo_3sgt'];
        case 'CB BM':
            return $consulta['tempo_cb'];
        case 'SD BM':
            return $consulta['tempo_sd'];
    }
}

// Buscar o posto/graduação do militar
function pega_posto_grad($militar_id, $conn)
{
    $stmt = $conn->prepare("SELECT posto_grad_mil FROM militar WHERE id = :id");
    $stmt->bindParam(':id', $militar_id, PDO::PARAM_INT);
    $stmt->execute();
    $aux_posto_grad = $stmt->fetchColumn();

    if (!$aux_posto_grad) {
        return false;
    } else {
        return $aux_posto_grad;
    }
}

function calcularTempoArregimentado($militar_id, $intersticio, $tempo_arregimentado_minimo, $conn)
{
    $tempo_arregimentado_minimo *= 30;
    
    // Buscar a última data de promoção
    $stmt = $conn->prepare("SELECT ultima_promocao FROM militar WHERE id = :id");
    $stmt->bindParam(':id', $militar_id, PDO::PARAM_INT);
    $stmt->execute();
    $data_promocao = $stmt->fetchColumn();
    
    if (!$data_promocao) {
        return false; // Se não houver promoção registrada
    }
    // Calcular o tempo total desde a última promoção
    $data_inicio = new DateTime($data_promocao);
    $data_atual = clone $data_inicio;
    $data_atual->add(new DateInterval('P' . $intersticio . 'Y')); // Adiciona os anos de interstício
    $intervalo = $data_inicio->diff($data_atual);
    $dias_totais = $intervalo->days;
    
    // Buscar o total de dias afastados
    $stmt = $conn->prepare("SELECT SUM(qtde_de_dias) FROM tempo_nao_arregimentado WHERE militar_id = :id");
    $stmt->bindParam(':id', $militar_id, PDO::PARAM_INT);
    $stmt->execute();
    $dias_afastados = (int)$stmt->fetchColumn();

    // Calcular o tempo arregimentado restante
    $tempo_arregimentado_atual = $dias_totais - $dias_afastados;

    // Atualizar no banco de dados
    if ($tempo_arregimentado_atual >= $tempo_arregimentado_minimo) {
        $stmt = $conn->prepare("UPDATE militar SET tempo_arregimentado = TRUE WHERE id = :id");
        $stmt->bindParam(':id', $militar_id, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE militar SET tempo_arregimentado = FALSE WHERE id = :id");
        $stmt->bindParam(':id', $militar_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    // return $tempo_arregimentado_atual;
}
