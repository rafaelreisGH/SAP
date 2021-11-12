<?php
require_once '../ConexaoDB/conexao.php';

$criterio_posto_grad = $_POST['criterio_posto_grad'];
$criterio_quadro = $_POST['criterio_quadro'];
$posicao_maior = $_POST['antiguidade_atual'];
$posicao_menor = $_POST['antiguidade_informada'];

$vetor = array();

if ($posicao_maior > $posicao_menor) {
    $stmt = $conn->prepare("SELECT antiguidade, id FROM militar WHERE antiguidade >= :posicao_menor AND antiguidade <= :posicao_maior");
    $stmt->execute([
        ':posicao_menor' => $posicao_menor,
        ':posicao_maior' => $posicao_maior
    ]);
} else {
    $stmt = $conn->prepare("SELECT antiguidade, id FROM militar WHERE antiguidade >= :posicao_maior AND antiguidade <= :posicao_menor");
    $stmt->execute([
        ':posicao_menor' => $posicao_menor,
        ':posicao_maior' => $posicao_maior
    ]);
}

while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $valor = $resultado['antiguidade'];
    $key = $resultado['id'];
    $vetor += ["{$key}" => $valor];
}

require_once '../Controllers/ordenar_pela_antiguidade.php';
$vetor = ordenar($vetor, $posicao_maior, $posicao_menor);

foreach ($vetor as $id => $antiguidade) {
    $antiguidade = (int)$antiguidade;
    $stmt = $conn->prepare('UPDATE militar SET antiguidade = :antiguidade WHERE id = :id');
    $stmt->execute(array(
        ':id' => $id,
        ':antiguidade' => $antiguidade
    ));
}
if ($stmt) {
    header('Location:../Views/listar_militares_atualizar_antiguidade.php?sucesso=1&criterio_posto_grad='.$criterio_posto_grad.'&criterio_quadro='.$criterio_quadro.'');
}

