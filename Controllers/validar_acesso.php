<?php

session_start();

require_once '../ConexaoDB/conexao.php';

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = md5(filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW));

try {
    //$stmt = $conn->query("SELECT * FROM usuarios WHERE email = '".$email."' AND senha = '".$senha."'");
    $stmt = $conn->query("SELECT nome, email, nivel_de_acesso, senha_reset, posto_grad_usuario FROM usuarios WHERE email = '" . $email . "' AND senha = '" . $senha . "'");

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    //   echo $resultado['email'] . '<br />';

    if (isset($resultado['email'])) {
        //recuperar dados do usuário e colocá-los na sessão
        $_SESSION['nome'] = $resultado['nome'];
        $_SESSION['email'] = $resultado['email'];
        $_SESSION['nivel_de_acesso'] = $resultado['nivel_de_acesso'];
        $_SESSION['senha_reset'] = $resultado['senha_reset'];
        $_SESSION['posto_grad_usuario'] = $resultado['posto_grad_usuario'];
    } else {
        header('Location: ../index.php?erro=1');
    }
    if ($_SESSION['senha_reset'] == 0) {
        header('Location: ../Views/pagina_muda_senha.php');
    } else {
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