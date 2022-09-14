<?php

    // --------------------------- //
if (isset($_POST['ano']) && isset($_POST['semestre'])) {
    //verificação dos POSTs
    $where = array();
    $where[] = " status = 'ATIVO'";
    $ano = $_POST['ano'];
    $semestre = $_POST['semestre'];
    $where[] = " pasta_promocional.ano_processo_promocional = '{$ano}'";
    $where[] = " pasta_promocional.semestre_processo_promocional = '{$semestre}'";
    $where[] = " pasta_promocional.pasta_bloqueada = 0";
} else {
    $erro = 'É preciso informar o ano e o semestre como parâmetros de busca.';
}
// --------------------------- //

// --------------------------- //
//pegar no BD dados do militar selecionado
//adicionar WHERE e AND automaticamente na query conforme os critérios
$sql = "SELECT pasta_promocional.id, militar.nome, militar.posto_grad_mil, militar.quadro, pasta_promocional.semestre_processo_promocional, pasta_promocional.ano_processo_promocional
FROM militar
INNER JOIN pasta_promocional
ON militar.id = pasta_promocional.militar_id";
// ==>> https://pt.stackoverflow.com/questions/77984/pesquisa-mysql-com-filtro-select-option
if (sizeof($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
//INSERI UM ORDER BY ANTIGUIDADE
$sql .= " ORDER BY antiguidade";
$stmt = $conn->query($sql);
$stmt->execute();

$rowCount = $stmt->rowCount();

if ($rowCount) {
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $erro = 'Nenhuma pasta promocional encontrada com os dados informados.';
}
// --------------------------- //

