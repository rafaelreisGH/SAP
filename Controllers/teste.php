<?php

//apagar a linha abaixo depois
require_once '../ConexaoDB/conexao.php';
require_once '../Controllers/pega_intersticio.php';

// ----------------------- Execução do Cálculo ----------------------- //
$aux_id = 18;
$aux_posto_grad = 'TC BM';

$intersticio = obter_intersticio($aux_posto_grad, $conn);
echo "$intersticio anos de interstício mínimo.<br>";

$dias_afastados = obter_dias_afastados($aux_id, $aux_posto_grad, $conn);
echo "$dias_afastados dias afastados por LTIP no posto/grad = $aux_posto_grad<br>";

$data_promocao = obter_ultima_promocao($aux_id, $conn);
if (!$data_promocao) {
    die("Erro: Não há registro de última promoção.");
}
echo "Última promoção: $data_promocao<br>";

$data_inicio = new DateTime($data_promocao);
$dias_totais = calcular_dias_totais($data_inicio, $intersticio);
echo "$dias_totais dias totais para a próxima promoção.<br>";

$dias_restantes = $dias_totais - $dias_afastados;
$data_futura = calcular_data_futura($data_inicio, $dias_restantes);
echo "Dia em que completa o interstício (descontada a LTIP): " . $data_futura->format('Y-m-d') . "<br>";

$data_promocao_oficial = calcular_data_promocao($data_futura);
echo "Data oficial de promoção: $data_promocao_oficial<br>";




// ----------------------- Funções ----------------------- //

function obter_intersticio($posto_grad, $conn) {
    return pega_intersticio($posto_grad, $conn);
}

function obter_dias_afastados($militar_id, $posto_grad, $conn) {
    $stmt = $conn->prepare("SELECT SUM(qtde_de_dias) FROM tempo_nao_arregimentado WHERE militar_id = :a AND posto_grad_na_epoca = :b AND categoria = 'inciso2'");
    $stmt->bindParam(':a', $militar_id, PDO::PARAM_INT);
    $stmt->bindParam(':b', $posto_grad, PDO::PARAM_STR);
    $stmt->execute();
    return (int) $stmt->fetchColumn() ?? 0;
}

function obter_ultima_promocao($militar_id, $conn) {
    $stmt = $conn->prepare("SELECT ultima_promocao FROM militar WHERE id = :id");
    $stmt->bindParam(':id', $militar_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function calcular_dias_totais($data_inicio, $intersticio) {
    $data_atual = clone $data_inicio;
    $data_atual->add(new DateInterval("P{$intersticio}Y"));
    return $data_inicio->diff($data_atual)->days;
}

function calcular_data_futura($data_inicio, $dias_restantes) {
    $data_futura = clone $data_inicio;
    $data_futura->add(new DateInterval("P{$dias_restantes}D"));
    return $data_futura;
}

function calcular_data_promocao($data) {
    $data = clone $data;
    $ano = $data->format('Y');

    $julho = new DateTime("$ano-07-02");
    $dezembro = new DateTime("$ano-12-02");

    if ($data < $julho) {
        return $julho->format('Y-m-d');
    }
    if ($data < $dezembro) {
        return $dezembro->format('Y-m-d');
    }

    $proximo_julho = new DateTime(($ano + 1) . "-07-02");
    return $proximo_julho->format('Y-m-d');
}






/*

$aux_id = 52;
$aux_posto_grad = 'MAJ BM';

require_once '../Controllers/pega_intersticio.php';
$intersticio = pega_intersticio($aux_posto_grad, $conn);
echo $intersticio . ' anos de interstício mínimo.<br>';

// Buscar o total de dias afastados por LTIP
$stmt = $conn->prepare("SELECT SUM(qtde_de_dias) FROM tempo_nao_arregimentado WHERE militar_id = :a AND posto_grad_na_epoca = :b AND categoria = 'inciso2'");
$stmt->bindParam(':a', $aux_id, PDO::PARAM_INT);
$stmt->bindParam(':b', $aux_posto_grad, PDO::PARAM_STR);
$stmt->execute();
$dias_afastados_por_LTIP = (int) $stmt->fetchColumn() ?? 0; // Se for NULL, define como 0

echo $dias_afastados_por_LTIP . ' dias afastado em LTIP no posto/grad = ' . $aux_posto_grad . '<br>';

// Buscar a última data de promoção
$stmt = $conn->prepare("SELECT ultima_promocao FROM militar WHERE id = :id");
$stmt->bindParam(':id', $aux_id, PDO::PARAM_INT);
$stmt->execute();
$data_promocao = $stmt->fetchColumn();

if (!$data_promocao) {
    die("Erro: Não há registro de última promoção.");
}

echo 'Última promoção: ' . $data_promocao . '<br>';

// Calcular o tempo total desde a última promoção
$data_inicio = new DateTime($data_promocao);
$data_atual = clone $data_inicio;
$data_atual->add(new DateInterval("P{$intersticio}Y")); // Adiciona os anos de interstício
$intervalo = $data_inicio->diff($data_atual);
$dias_totais = $intervalo->days;

echo $dias_totais . ' dias totais para a próxima promoção.<br>';

// Calcular futura data de promoção
$dias_restantes = $dias_totais - $dias_afastados_por_LTIP;
$data_futura = clone $data_inicio;
$data_futura->add(new DateInterval("P{$dias_restantes}D"));
echo 'Dia em que completa o interstício (descontada a LTIP): ' . $data_futura->format('Y-m-d') . '<br>';

// Calcular data de promoção ajustada
$teste = calcular_data_promocao($data_futura);
echo 'Data oficial de promoção: ' . $teste . '<br>';

// Função para determinar a data de promoção
function calcular_data_promocao($data)
{
    $data = clone $data; // Clona para evitar modificar o objeto original
    $ano = $data->format('Y');

    // Define as datas de promoção no mesmo ano
    $julho = new DateTime("$ano-07-02");
    $dezembro = new DateTime("$ano-12-02");

    // Ajusta a data final para a próxima data de promoção
    if ($data < $julho) {
        return $julho->format('Y-m-d'); // Se for antes de 2 de julho, ajusta para 2 de julho
    }
    if ($data < $dezembro) {
        return $dezembro->format('Y-m-d'); // Se for antes de 2 de dezembro, ajusta para 2 de dezembro
    }

    // Se passar de 2 de dezembro, vai para 2 de julho do próximo ano
    $proximo_julho = new DateTime(($ano + 1) . "-07-02");
    return $proximo_julho->format('Y-m-d');
}
*/

