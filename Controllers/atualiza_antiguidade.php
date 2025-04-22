<?php
require_once '../ConexaoDB/conexao.php';
$conn = Conexao::getConexao(); // Obtém a conexão ativa

$criterio_posto_grad = $_POST['criterio_posto_grad'];
$criterio_quadro = $_POST['criterio_quadro'];
$antiguidade_atual = $_POST['antiguidade_atual'];
$nova_antiguidade = $_POST['antiguidade_informada'];

$vetor = array();

if ($antiguidade_atual > $nova_antiguidade) {
    $stmt = $conn->prepare("SELECT antiguidade, id FROM militar WHERE antiguidade >= :posicao_menor AND antiguidade <= :posicao_maior");
    $stmt->execute([
        ':posicao_menor' => $nova_antiguidade,
        ':posicao_maior' => $antiguidade_atual
    ]);
} else {
    $stmt = $conn->prepare("SELECT antiguidade, id FROM militar WHERE antiguidade >= :posicao_maior AND antiguidade <= :posicao_menor");
    $stmt->execute([
        ':posicao_menor' => $nova_antiguidade,
        ':posicao_maior' => $antiguidade_atual
    ]);
}

while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $valor = $resultado['antiguidade'];
    $key = $resultado['id'];
    $vetor += ["{$key}" => $valor];
}

require_once '../Controllers/ordenar_pela_antiguidade.php';
$vetor = ordenar($vetor, $antiguidade_atual, $nova_antiguidade);

foreach ($vetor as $id => $antiguidade) {
    $antiguidade = (int)$antiguidade;
    $stmt = $conn->prepare('UPDATE militar SET antiguidade = :antiguidade WHERE id = :id');
    $stmt->execute(array(
        ':id' => $id,
        ':antiguidade' => $antiguidade
    ));
}

unset($vetor);

if ($stmt) {
    header('Location:../Views/listar_militares_atualizar_antiguidade.php?sucesso=1&criterio_posto_grad='.$criterio_posto_grad.'&criterio_quadro='.$criterio_quadro.'');
}

