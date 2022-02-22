<?php
require_once '../ConexaoDB/conexao.php';

//inicialização de variáveis
//$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$nome = isset($_POST['nome']) ? filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW) : "";
//$nome = strtoupper($nome);
$posto_grad = $_POST['posto_grad'];
$quadro = $_POST['quadro'];;

//variável para montar a string do header Location
$location = "Location:../Views/cadastrar_militar.php?";

//verifica se existe a mesma pessoa no BD
$stmt = $conn->prepare('SELECT nome, posto_grad_mil, quadro FROM militar WHERE nome = :nome AND posto_grad_mil = :posto_grad AND quadro = :quadro');
$stmt->execute(array(
    ':nome' => $nome,
    ':posto_grad' => $posto_grad,
    ':quadro' => $quadro
));

if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //se econtrou militar com mesmas características no BD um erro é gerado
    $location .= 'erro=1';
} else {
    //selecionar maior antiguidade existente
    $stmt = $conn->query('SELECT max(antiguidade) FROM militar');
    $antiguidade = $stmt->fetch();
    $antiguidade = $antiguidade['max(antiguidade)'];
    //
    //inserir registro, inclusive com a antiguidade
    $stmt = $conn->prepare('INSERT INTO militar (nome, posto_grad_mil, quadro, antiguidade, militar.status) VALUES (:nome, :posto_grad, :quadro, :antiguidade, :ativo)');
    $stmt->execute(array(
        ':nome' => $nome,
        ':posto_grad' => $posto_grad,
        ':quadro' => $quadro,
        ':antiguidade' => $antiguidade + 1,
        //INSERI O MILITAR RECÉM CADASTRADO COMO ATIVO
        ':ativo' => 'ATIVO'
    ));
    if ($stmt) {
        $location .= 'sucesso[]=' . $nome . '&sucesso[]=' . $posto_grad . '&sucesso[]=' . $quadro . '';
    } else {
        $location .= 'erroNoBD=1';
    }
}

header($location);
