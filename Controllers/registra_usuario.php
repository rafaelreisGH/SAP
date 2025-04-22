<?php

require_once '../ConexaoDB/conexao.php';
$conn = Conexao::getConexao();
// Função de validação de senha
require_once '../Controllers/validar_senha.php';

// Captura dos dados
$nome  = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha_original = filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW);

// Inicialização de erros
$erros = [];

// Validação da senha
$senha_valida = validarSenha($senha_original);
if ($senha_valida !== true) {
    $erros['erro_senha'] = $senha_valida;
}

// Validação do e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros['email_invalido'] = 1;
}

// Verifica se o nome já existe
$stmt_nome = $conn->prepare("SELECT 1 FROM usuarios WHERE nome = :nome LIMIT 1");
$stmt_nome->bindParam(':nome', $nome);
$stmt_nome->execute();
if ($stmt_nome->fetch()) {
    $erros['erro_nome'] = 1;
}

// Verifica se o e-mail já existe
$stmt_email = $conn->prepare("SELECT 1 FROM usuarios WHERE email = :email LIMIT 1");
$stmt_email->bindParam(':email', $email);
$stmt_email->execute();
if ($stmt_email->fetch()) {
    $erros['erro_email'] = 1;
}

// Redireciona com os erros, se houver
if (!empty($erros)) {
    $query_string = http_build_query($erros);
    header("Location:../Views/inscrevase.php?$query_string");
    exit;
}

// Se chegou aqui, está tudo certo — cadastrar usuário

// Gera hash seguro da senha
$senha_hash = password_hash($senha_original, PASSWORD_DEFAULT);

// Insere no banco explicitando status como 0 (bloqueado) e senha_reset como 1
$stmt = $conn->prepare("
    INSERT INTO usuarios (nome, email, senha, senha_reset, status) 
    VALUES (:nome, :email, :senha, :reset, :status)
");
$stmt->bindValue(':nome', $nome);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':senha', $senha_hash);
$stmt->bindValue(':reset', 1);   // senha já definida
$stmt->bindValue(':status', 0);  // bloqueado até aprovação do admin

if ($stmt->execute()) {
    header('Location:../Views/recem_cadastrado.php');
    exit;
} else {
    // Caso haja erro inesperado no insert (opcionalmente logar isso)
    header('Location:../Views/inscrevase.php?erro_interno=1');
    exit;
}
