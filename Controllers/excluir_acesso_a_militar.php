<?php
require_once '../Controllers/nivel_admin.php';
require_once '../Controllers/verifica_permissoes.php';
require_once '../ConexaoDB/conexao.php';

$usuario_id = (isset($_POST['usuario_id'])) ? $_POST['usuario_id'] : null;
$militar_id = (isset($_POST['militar_id'])) ? $_POST['militar_id'] : null;

//se o $usuario_id não for um inteiro, redireciona para acesso restrito
if ((!filter_var($usuario_id, FILTER_VALIDATE_INT)) || (!filter_var($militar_id, FILTER_VALIDATE_INT))) {
    header('Location: ../Views/acesso_restrito.php');
}

try {
    $stmt = $conn->prepare('SELECT id FROM promocao.usuario_acesso_militar WHERE usuario_id = :usuario AND militar_id = :militar');
    $stmt->execute(array(
        ':usuario' => $usuario_id,
        ':militar' => $militar_id
    ));
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
//conta quantos resultados obtive a consulta
$rowCount = $stmt->rowCount();

if ($rowCount != 0) {
    $rowCount = 0;
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $deleteCount = 0;
    foreach ($resultado as $item) {
        $resultado = $item['id'];
        try {
            $stmt = $conn->prepare('DELETE FROM promocao.usuario_acesso_militar WHERE id = :id');
            $stmt->execute(array(
                ':id' => $resultado
            ));
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
        }
        $deleteCount += $stmt->rowCount();
    }
    header("Location:../Views/pagina_admin_ver_usuarios.php?sucesso=1&usuario_id=$usuario_id");
} else {
    header("Location:../Views/pagina_admin_ver_usuarios.php?sucesso=0&usuario_id=$usuario_id");
}
