<?php
session_start();
require_once '../ConexaoDB/conexao.php';
require_once '../Controllers/validar_senha.php';

$senhaNova = filter_input(INPUT_POST, 'senhaNova', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW);
$user_email = $_SESSION['email'];

// Valida a senha
$validacao = validarSenha($senhaNova);
if ($validacao !== true) {
    // Redireciona com erro se a senha for inválida
    header("Location: ../Views/redefinir_senha.php?erro_senha=" . urlencode($validacao));
    exit;
}

try {
    // Gera o hash da nova senha
    $senhaHash = password_hash($senhaNova, PASSWORD_DEFAULT);

    // Atualiza no banco
    $stmt = $conn->prepare("UPDATE usuarios SET senha = ?, senha_reset = 0 WHERE email = ?");
    $stmt->bindParam(1, $senhaHash, PDO::PARAM_STR);
    $stmt->bindParam(2, $user_email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount()) {
        // Redireciona conforme o nível de acesso
        switch ($_SESSION['nivel_de_acesso']) {
            case '2':
                header('Location: ../Views/pagina_admin.php');
                break;
            case '1':
                header('Location: ../Views/pagina_gestor.php');
                break;
            default:
                header('Location: ../Views/pagina_usuario.php');
                break;
        }
    } else {
        header('Location: ../Views/erro.php?msg=Senha não atualizada');
    }
} catch (PDOException $ex) {
    echo "Erro ao atualizar a senha: " . $ex->getMessage();
}
?>

