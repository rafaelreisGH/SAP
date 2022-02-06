<?php
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';

echo '<div class="container"><div class="col-md-12">';

// --------------------------- //
$documento = $_POST['tipo_do_documento'];
$id = $_POST['id_pasta'];
// --------------------------- //
$sucesso_pasta = null;
$sucesso_servidor = null;

// --------------------------- //
try {
    //pegar no BD dados do militar selecionado
    $stmt = $conn->query('SELECT ' . $documento . ' FROM promocao.pasta_promocional WHERE id = ' . $id . '');
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt) {
        $caminho = $res[$documento];
        unlink($caminho);
        $sucesso_pasta = 1;
    }
} catch (PDOException $ex) {
    return $ex->getMessage();
}
try {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET ' . $documento . ' = :campo_a_ser_apagado WHERE id = :id');
    $stmt->execute(array(
        ':id' => $id,
        ':campo_a_ser_apagado' => NULL
    ));
    if ($stmt) {
        $sucesso_servidor = 1;
    }
} catch (PDOException $ex) {
    return $ex->getMessage();
}

if ((!is_null($sucesso_pasta)) && (!is_null($sucesso_servidor))) {
    echo 'Documento excluído do servidor.';
    echo '<br>Documento excluído do Banco de dados.';
    echo '<hr>'
        . '<a href="edicao_documentos_pasta_promo.php?id_da_pasta=' . $_POST['id_pasta'] . '"><button class="btn btn-outline-success active" type="button">Voltar</button></a>';
} else {
    echo 'Erro ao excluir arquivos.';
}
// --------------------------- //

die();
// --------------------------- //
echo "Documento excluído com sucesso.";

echo '<hr>'
    . '<a href="edicao_documentos_pasta_promo.php?id_da_pasta=' . $_POST['id_pasta'] . '"><button class="btn btn-outline-success active" type="button">Voltar</button></a>';
echo "Falha na exclusão do documento.";
// --------------------------- //


// function excluiDoBanco($documento, $id)
// {
//     $stmt = $conn->prepare('UPDATE pasta_promocional SET ' . $documento . ' = :campo_a_ser_apagado WHERE id = :id');
//     $stmt->execute(array(
//         ':id' => $id,
//         ':campo_a_ser_apagado' => NULL
//     ));
//     if ($stmt) {
//         return 1;
//     } else {
//         return 0;
//     }
// }

// function excluiDaPasta($documento, $id)
// {
//     require_once '../ConexaoDB/conexao.php';
//     try {
//         //pegar no BD dados do militar selecionado
//         $stmt = $conn->query('SELECT ' . $documento . ' FROM promocao.pasta_promocional WHERE id = ' . $id . '');
//         $res = $stmt->fetch(PDO::FETCH_ASSOC);
//         if ($stmt) {
//             $caminho = $res[$documento];
//             unlink($caminho);
//         }
//         unset($stmt);
//     } catch (PDOException $ex) {
//         return $ex->getMessage();
//     }
// }
