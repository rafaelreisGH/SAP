<?php
require_once '../ConexaoDB/conexao.php';

$id_da_fad = $_POST['id_da_fad'];
$id = $_POST['militar_id'];

$delete = "DELETE FROM fad WHERE id = '" . $id_da_fad . "'";

try {
    $conn->exec($delete);
    header('Location:../Views/teste_fad.php?militar_id=' . $id . '');
    }
catch(PDOException $e)
    {
    echo $delete . "<br>" . $e->getMessage();
    }
$conn = null;
