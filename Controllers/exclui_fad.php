<?php
require_once '../ConexaoDB/conexao.php';

$id_da_fad = $_POST['id_da_fad'];
$id = $_POST['militar_id'];

//para tratar quando os dados vem da insere_fad.php
$original = (isset($_POST['exclui_fad_original'])) ? $_POST['exclui_fad_original'] : null;

$delete = "DELETE FROM fad WHERE id = '" . $id_da_fad . "'";

try {
    $conn->exec($delete);
    if (!is_null($original)) header('Location:../Views/insere_fad.php?militar_id=' . $id . '&sucesso=1');
    else header('Location:../Views/teste_fad.php?militar_id=' . $id . '');
} catch (PDOException $e) {
    echo $delete . "<br>" . $e->getMessage();
}
$conn = null;
