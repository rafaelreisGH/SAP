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

$vetor_antiguidade = array();
//LISTAR OS MILITARES QUE JÁ ESTAVAM NO POSTO/GRADUAÇÃO, E OS QUE ACABARAM DE ENTRAR, E TAMBÉM AQUELES QUE NÃO FORAM PROMOVIDOS ORDENANDO-OS PELA ANTIGUIDADE 
$stmt = $conn->prepare("SELECT id, nome, posto_grad_mil, antiguidade FROM militar WHERE antiguidade >= '$mais_moderno_anteriormente' AND antiguidade <= '$max' ORDER BY antiguidade");
$resultado = $stmt->execute();
while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $valor = $resultado['antiguidade'];
    $key = $resultado['id'];
    $vetor_antiguidade += ["{$key}" => $valor];
    echo "<br>";
}
print_r($vetor_antiguidade);
echo '<br>';

require_once '../Controllers/ordenar_pela_antiguidade.php';
foreach ($militar_id as $item) {
var_dump($item);
    die();
}

$aux = $vetor_antiguidade;
print_r($aux);

die();

$vetor_antiguidade = asort($vetor_antiguidade);
print_r($vetor_antiguidade);









die();





//array para gravar os militares que tiveram os registros alterados
$alteracoes = array();

//variável para montar a string do header Location
$location = "Location:../Views/listar_militares_promocao_em_lote.php?";

if (isset($_POST['militar_id'])) {
    $militar_id = $_POST['militar_id'];
    $aux = (int)$militar_id[0]; //incluído por causa do if PROMOÇÃO POR REQUERIMENTO

    foreach ($militar_id as $item) {
        //SELECT para buscar no BD resultado igual ao informado
        $stmt = $conn->prepare("SELECT * FROM registro_de_promocoes WHERE militar_id = " . $item . " AND  grau_hierarquico = '" . $promocao_posto_grad . "'");
        $resultado = $stmt->execute();

        //se encontra registro com o mesmo grau_hierarquico, atualiza o registo no BD
        //isso porque não pode haver duas promoções para o mesmo grau_hierarquico
        if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmt = $conn->prepare("UPDATE registro_de_promocoes SET a_contar_de = :data_promocao, modalidade = :modalidade, grau_hierarquico = :promocao_posto_grad  WHERE militar_id = :id AND grau_hierarquico = :promocao_posto_grad");
            $stmt->execute(array(
                ':id' => $item,
                ':data_promocao' => $data_promocao,
                ':modalidade' => $modalidade,
                ':promocao_posto_grad' => $promocao_posto_grad,
            ));

            $alteracoes[] = $item;
        } else {
            //se não encontrar nada, faz o insert na tabela registro_de_promocoes
            //FAZER INSERT NO BD
            $stmt = $conn->prepare("INSERT INTO registro_de_promocoes (a_contar_de, grau_hierarquico, modalidade, militar_id) VALUES (:data_promocao, :promocao_posto_grad, :modalidade, :id)");

            $stmt->execute(array(
                ':id' => $item,
                ':data_promocao' => $data_promocao,
                ':modalidade' => $modalidade,
                ':promocao_posto_grad' => $promocao_posto_grad,
            ));

            $alteracoes[] = $item;
        }
    }

    //mudar o posto/graduação
    //alterar a antiguidade








    //se a promocão for POR REQUERIMENTO automaticamente é liberada a antiguidade e inativado o militar.
    if ($modalidade == 'POR REQUERIMENTO') {
        header('Location:../Controllers/inativa_militar.php?id=' . $aux . '');
    } else {
        //concatenar as alteraçoes no $location
        //$location = "Location:../Views/listar_militares_data_em_lote.php?";
        $location .= "alteracoes_realizadas[]=" . implode("&alteracoes_realizadas[]=", $alteracoes);
        header("$location");
    }

    //tem de ter um header aqui
} else {
    header('Location:../Views/listar_militares_promocao_em_lote.php?nada_alterado=1');
}
