<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';

echo '<div class="container"><div class="col-md-12">';

// --------------------------- //
$id = isset($_POST['id_documento']) ? $_POST['id_documento'] : null;
// --------------------------- //
$sucesso_servidor = null;
$sucesso_bd = null;

// --------------------------- //
if (!is_null($id)) {
    try {
        $stmt = $conn->prepare('SELECT caminho_do_arquivo FROM documento WHERE id = :id');
        $stmt->execute(array(
            ':id' => $id,
        ));
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    //Se achar o resultado da consulta
    //tenta excluir o arquivo do servidor
    if ($stmt) {
        $caminho = $res['caminho_do_arquivo'];
        if (unlink($caminho)) $sucesso_servidor = 1;
        else echo 'Erro ao excluir arquivo do servidor.</br>';
    }
    // se conseguir excluir do servidor
    //tenta excluir o registro do BD
    if ($sucesso_servidor == 1) {
        try {
            $conn->prepare('DELETE FROM documento WHERE id = ?')->execute([$id]);
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        if ($conn) {
            $sucesso_bd = 1;
        } else {
            echo 'Erro ao excluir arquivo do banco de dados.</br>';
        }
    }
}

if ((($sucesso_servidor == 1)) && (($sucesso_bd == 1))) {
    echo 'Documento excluído do servidor.';
    echo '<br>Documento excluído do Banco de dados.';
} else {
    echo 'Erro ao excluir arquivos.';
}
echo '<hr>'
    . '<A class="btn btn-primary" HREF="javascript:javascript:history.go(-1)">Voltar</A>';
