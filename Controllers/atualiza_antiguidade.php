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
function ordenar(array $vetor, $posicao_maior, $posicao_menor)
{
    if ($posicao_maior > $posicao_menor) {
        $key_anterior = array_search($posicao_maior, $vetor);
        $contador = count($vetor);

        $vetor2 = $vetor; //salva os resultados em outro vetor para poder ser trabalhado
        array_pop($vetor2); //descarta a última posição

        //a última posição então fica somente neste vetor
        $a2 = array_splice($vetor, $contador - 1, 1); //a key é resetada para 0

        //aqui a key volta a ser o id
        $a2[$key_anterior] = $a2[0];
        unset($a2[0]); //a key anterior é descartada

        //os elementos do $vetor2 são adicionados o vetor $a2
        foreach ($vetor2 as $key => $valor) {
            $a2 += [$key => $valor];
        }
        //os valores dos elementos são ordenador conforme a antiguidade
        foreach ($a2 as &$valor) {
            $valor = $posicao_menor;
            $posicao_menor++;
        }
        return  $a2; //depois dar retorno
    } else {
        asort($vetor);
        $key_anterior = array_search($posicao_maior, $vetor);
        $vetor2 = $vetor; //salva os resultados em outro vetor para poder ser trabalhado
        array_splice($vetor, 1);
        $vetor[$key_anterior] = $vetor[0];
        unset($vetor[0]);
        array_merge($vetor2, $vetor);
        $vetor2 = array_reverse($vetor2, true);
        array_pop($vetor2);
        $vetor2 = array_reverse($vetor2, true);
        foreach ($vetor as $key => $valor) {
            $vetor2 += [$key => $valor];
        }
        foreach ($vetor2 as &$valor) {
            $valor = $posicao_maior;
            $posicao_maior++;
        }
        return $vetor2;
    }
}
