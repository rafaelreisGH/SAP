<?php
include_once './header2.php';

echo '<div class="container"><div class="col-md-12">';

// --------------------------- //
$documento = $_POST['tipo_do_documento'];
$id = $_POST['id_pasta'];

if(excluiDoBanco($documento, $id)){
    echo "Documento excluído com sucesso.";

    echo '<hr>'
    .'<a href="edicao_documentos_pasta_promo.php?id_da_pasta=' . $_POST['id_pasta'] . '"><button class="btn btn-outline-success active" type="button">Voltar</button></a>';
} else {
    echo "Falha na exclusão do documento.";
}
// --------------------------- //

function excluiDoBanco($documento, $id)
{
    require_once '../ConexaoDB/conexao.php';
    $stmt = $conn->prepare('UPDATE pasta_promocional SET ' . $documento . ' = :campo_a_ser_apagado WHERE id = :id');
    $stmt->execute(array(
        ':id' => $id,
        ':campo_a_ser_apagado' => NULL
    ));
    if ($stmt) {
        return 1;
    } else {
        return 0;
    }
}
