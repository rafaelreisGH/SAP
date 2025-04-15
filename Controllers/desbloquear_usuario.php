<?php

require_once '../ConexaoDB/conexao.php';

$nivel_de_acesso = isset($_POST['perfil']) ? $_POST['perfil'] : null;
$posto_grad = isset($_POST['posto_grad']) ? $_POST['posto_grad'] : null;
$usuario_a_desbloquear = isset($_POST['desbloquear']) ? filter_input(INPUT_POST, 'desbloquear', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW) : 0;

try {
    // Consulta o usuário para verificar o valor atual de senha_reset
    $stmt_check = $conn->prepare("SELECT email, senha_reset FROM usuarios WHERE id = :id");
    $stmt_check->bindParam(':id', $usuario_a_desbloquear, PDO::PARAM_INT);
    $stmt_check->execute();
    $usuario = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        throw new Exception("Usuário não encontrado.");
    }

    if ($usuario['senha_reset'] == 0) {
        // Usuário esqueceu a senha – aplicar senha padrão e forçar troca
        $senhaPadrao = password_hash("Sap@1234", PASSWORD_DEFAULT);

        $stmt_update = $conn->prepare("UPDATE usuarios SET status = 1, senha = :senha, senha_reset = 0, nivel_de_acesso = :nivel, posto_grad_usuario = :posto WHERE id = :id");
        $stmt_update->bindParam(':senha', $senhaPadrao, PDO::PARAM_STR);
    } else {
        // Usuário apenas aguardava desbloqueio
        $stmt_update = $conn->prepare("UPDATE usuarios SET status = 1, nivel_de_acesso = :nivel, posto_grad_usuario = :posto WHERE id = :id");
    }

    // Parâmetros comuns
    $stmt_update->bindParam(':nivel', $nivel_de_acesso, PDO::PARAM_STR);
    $stmt_update->bindParam(':posto', $posto_grad, PDO::PARAM_STR);
    $stmt_update->bindParam(':id', $usuario_a_desbloquear, PDO::PARAM_INT);

    $stmt_update->execute();

    // Redirecionamento após atualização
    header('Location:../Views/pagina_admin.php');
    exit;

} catch (PDOException $e) {
    echo "Erro ao atualizar usuário: " . $e->getMessage();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
