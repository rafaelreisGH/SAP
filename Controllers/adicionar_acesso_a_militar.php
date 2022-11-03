<?php
require_once '../Controllers/nivel_admin.php';
require_once '../Controllers/verifica_permissoes.php';
require_once '../ConexaoDB/conexao.php';

$usuario_id = (isset($_POST['usuario_id'])) ? $_POST['usuario_id'] : null;
$militar_id = (isset($_POST['militar_id'])) ? $_POST['militar_id'] : null;

$opcao01 = ((isset($_POST['opcao01'])) && ($_POST['opcao01'] == 'on')) ? 1 : 0;
$opcao02 = ((isset($_POST['opcao02'])) && ($_POST['opcao02'] == 'on')) ? 1 : 0;
$opcao03 = ((isset($_POST['opcao03'])) && ($_POST['opcao03'] == 'on')) ? 1 : 0;

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

if ($rowCount == 0) {
    try {
        $stmt = $conn->prepare('INSERT INTO promocao.usuario_acesso_militar (militar_id, usuario_id, acesso_candidato, acesso_sadm, acesso_avaliador) VALUES (:militar, :usuario, :acesso_candidato, :acesso_sadm, :acesso_avaliador)');
        $stmt->execute(array(
            ':militar' => $militar_id,
            ':usuario' => $usuario_id,
            ':acesso_candidato' => $opcao01,
            ':acesso_sadm' => $opcao02,
            ':acesso_avaliador' => $opcao03
        ));
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }

    if ($stmt) {
        header("Location:../Views/pagina_admin_ver_usuarios.php?sucesso=2&usuario_id=$usuario_id");
    }
} else {
    header("Location:../Views/pagina_admin_ver_usuarios.php?sucesso=0&usuario_id=$usuario_id");
}
