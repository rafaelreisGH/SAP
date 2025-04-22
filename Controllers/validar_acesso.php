<?php
session_start();
require_once '../ConexaoDB/conexao.php';
$conn = Conexao::getConexao();

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha_digitada = filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW);

// Consulta o usuário pelo e-mail
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($senha_digitada, $usuario['senha'])) {
    // Login válido - configura sessão
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['email'] = $usuario['email'];
    $_SESSION['nivel_de_acesso'] = $usuario['nivel_de_acesso'];
    $_SESSION['senha_reset'] = $usuario['senha_reset'];
    $_SESSION['posto_grad_usuario'] = $usuario['posto_grad_usuario'];
    $_SESSION['logado'] = true;

    // Redirecionamento conforme situação
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
    exit;
}

// Login falhou
header('Location: ../index.php?erro=1');
exit;
?>
