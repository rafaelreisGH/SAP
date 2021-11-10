<?php
session_start();
require_once '../ConexaoDB/conexao.php';

$senhaNova = md5(filter_input(INPUT_POST, 'senhaNova', FILTER_SANITIZE_STRING));

$user_email = $_SESSION['email'];

try {
    $stmt = $conn->prepare("UPDATE usuarios SET senha = ?, senha_reset = false WHERE email = ?");
        
    $stmt->bindParam(1, $senhaNova, PDO::PARAM_STR);
    $stmt->bindParam(2, $user_email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt) {

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
    }
} catch (PDOException $ex) {
    return $ex->getMessage();
}
?>

