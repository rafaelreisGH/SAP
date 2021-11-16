<?php
require_once '../ConexaoDB/conexao.php';

if (isset($_POST['data_promocao'])) {
    $data_promocao = $_POST['data_promocao'];
}
if (isset($_POST['modalidade'])) {
    $modalidade = $_POST['modalidade'];
}
if (isset($_POST['promocao_posto_grad'])) {
    $promocao_posto_grad = $_POST['promocao_posto_grad'];
}
if (isset($_POST['militar_id'])) {
    $militar_id = $_POST['militar_id'];
}
//---------------------------//

//ANTES DE SE REALIZAR A ALTERAÇÃO DO POSTO/GRADUAÇÃO
//PEGAR O MILITAR MAIS MODERNO ATUALMENTO NO POSTO/GRADUAÇÃO EM QUESTÃO
$vetor_antiguidade_mais_moderno_anteriormente = array();
$stmt = $conn->prepare("SELECT antiguidade FROM militar WHERE posto_grad_mil = '$promocao_posto_grad'");
$resultado = $stmt->execute();
while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $vetor_antiguidade_mais_moderno_anteriormente[] = $resultado['antiguidade'];
}
$mais_moderno_anteriormente = (int)max($vetor_antiguidade_mais_moderno_anteriormente);
//---------------------------//

//ALTERAR O POSTO/GRADUAÇÃO
/* 
    foreach ($militar_id as $item) {
        $stmt = $conn->prepare("UPDATE militar SET posto_grad_mil = :promocao_posto_grad  WHERE id = :id");
        $stmt->execute(array(
            ':id' => $item,
            ':promocao_posto_grad' => $promocao_posto_grad,
        ));
    }
} */
//---------------------------//

//CONSULTAR A ANTIGUIDADE DOS MILITARES NO NOVO POSTO/GRADUAÇÃO
//---------------------------//

// vetor para armazenar os militares e sua antiguidade
$vetor_antiguidade_anterior = array();

foreach ($militar_id as $item) {
    $stmt = $conn->prepare("SELECT id, nome, antiguidade FROM militar WHERE id = '$item'");
    $resultado = $stmt->execute();
    while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $valor = $resultado['antiguidade'];
        $chave = $resultado['id'];
        $vetor_antiguidade_anterior += ["{$chave}" => $valor];
    }
}
$max = (int)max($vetor_antiguidade_anterior); //pega a antiguidade do militar de maior antiguidade nominal -- militar mais moderno promovido

//
/* print_r($vetor_antiguidade_anterior);
echo "<br>"; */
//

$vetor_antiguidade = array();
//LISTAR OS MILITARES QUE JÁ ESTAVAM NO POSTO/GRADUAÇÃO, E OS QUE ACABARAM DE ENTRAR, E TAMBÉM AQUELES QUE NÃO FORAM PROMOVIDOS ORDENANDO-OS PELA ANTIGUIDADE 
$stmt = $conn->prepare("SELECT id, nome, posto_grad_mil, antiguidade FROM militar WHERE antiguidade >= '$mais_moderno_anteriormente' AND antiguidade <= '$max' ORDER BY antiguidade");
$resultado = $stmt->execute();
while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $valor = $resultado['antiguidade'];
    $key = $resultado['id'];
    $vetor_antiguidade += ["{$key}" => $valor];
}

/* echo '<br>';
echo 'vetor anterior';
print_r($vetor_antiguidade);
echo '<br>';
echo '<br>'; */

//-------------------------------------------------------------------//
//Aqui o $vetor_antiguidade perde o primeiro elemento
$chaves = $vetor_antiguidade;
$chaves = array_flip($chaves);
array_shift($chaves);
array_shift($vetor_antiguidade);
$vetor_antiguidade = array_combine($chaves, $vetor_antiguidade);
/* echo '<br>';
echo 'vetor depois da modificação';
print_r($vetor_antiguidade);
echo '<br>';
echo '<br>'; */
//-------------------------------------------------------------------//

require_once '../Controllers/ordenar_pela_antiguidade.php';
foreach ($vetor_antiguidade_anterior as $item => $value) {
    $antiguidade = $value;
    if (($antiguidade - $mais_moderno_anteriormente) > 0) {
        $vetor_antiguidade[$item] = $mais_moderno_anteriormente + 1;
        $chave = array_search($mais_moderno_anteriormente + 1, $vetor_antiguidade);
        $vetor_antiguidade[$chave] = $antiguidade;
        $mais_moderno_anteriormente++;
    } else {
        break;
    }
}
asort($vetor_antiguidade);
print_r($vetor_antiguidade);

//array para gravar os militares que tiveram os registros alterados
$alteracoes = array();

//variável para montar a string do header Location
$location = "Location:../Views/listar_militares_promocao_em_lote.php?";
