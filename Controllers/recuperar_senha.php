<?php
session_start();
require_once '../ConexaoDB/conexao.php';
$conn = Conexao::getConexao();

$user_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

try {
    // Verifica se o e-mail existe
    $verifica = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $verifica->bindParam(1, $user_email, PDO::PARAM_STR);
    $verifica->execute();

    if ($verifica->rowCount() === 0) {
        // E-mail não encontrado
        $_SESSION['mensagem_erro'] = "E-mail não encontrado no sistema.";
        header("Location: ../Views/esqueci_senha.php");
        exit;
    }

    // Define a senha padrão e gera o hash
    $senhaPadrao = "sap@CBMMT";
    $senhaHash = password_hash($senhaPadrao, PASSWORD_DEFAULT);

    // Atualiza a senha e marca como senha provisória
    $stmt = $conn->prepare("UPDATE usuarios SET senha = ?, senha_reset = 0, usuarios.status = 0 WHERE email = ?");
    $stmt->bindParam(1, $senhaHash, PDO::PARAM_STR);
    $stmt->bindParam(2, $user_email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount()) {
        $_SESSION['mensagem_sucesso'] = "Senha redefinida com sucesso! Solicite o desbloqueio junto ao admin e depois faça o login com a senha informada pelo Admin.";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['mensagem_erro'] = "Falha ao redefinir a senha.";
        header("Location: ../Views/esqueci_senha.php");
        exit;
    }
} catch (PDOException $ex) {
    echo "Erro ao redefinir a senha: " . $ex->getMessage();
}


