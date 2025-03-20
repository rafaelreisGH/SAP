<?php
// require_once '../ConexaoDB/conexao.php';
require_once '../Controllers/pega_intersticio.php';
require_once '../Controllers/pega_tempo_minimo_arregimentado.php';

$aux_posto_grad = pega_posto_grad($id, $conn);
$inter = pega_intersticio($aux_posto_grad, $conn);
$tempo_arregimentado_minimo = pega_tempo_minimo_arregimentado($aux_posto_grad, $conn);

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
