<?php

require_once '../ConexaoDB/conexao.php';

//REFERE-SE à INSERÇÃO
$data_realizacao = (isset($_POST['data_realizacao'])) ? $_POST['data_realizacao'] : null;
$data_publicacao = (isset($_POST['data_publicacao'])) ? $_POST['data_publicacao'] : null;
$numero_bge = (isset($_POST['numero_bge'])) ? $_POST['numero_bge'] : null;
// ---------------- //

// REFERE-SE à EXCLUSÃO
$exclusao = (isset($_POST['aux_id'])) ? $_POST['aux_id'] : null;

// ---------------- //
if (is_null($exclusao)) {
    if ((!is_null($data_realizacao)) && (!is_null($numero_bge))) {
        try {
            $stmt = $conn->prepare('SELECT data_do_taf, bge_numero FROM taf WHERE data_do_taf = :data_realizacao AND bge_numero = :numero_bge');
            $stmt->execute(array(
                ':data_realizacao' => $data_realizacao,
                ':numero_bge' => $numero_bge
            ));
        } catch (PDOException $ex) {
            echo "Falha: " . $ex->getMessage();
        }
        if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) { //se encontrou
            header('Location:../Views/cadastrar_taf.php?retorno=1');
        } else {
            try {
                $stmt = $conn->prepare('INSERT INTO taf (data_do_taf, data_public, bge_numero) VALUES (:a,:b,:c)');
                $stmt->execute(array(
                    ':a' => $data_realizacao,
                    ':b' => $data_publicacao,
                    ':c' => $numero_bge
                ));
                if ($stmt) header('Location:../Views/cadastrar_taf.php?retorno=2&dados[]=' . $data_realizacao . '&dados[]=' . $numero_bge . '&dados[]=' . $data_publicacao . '');
            } catch (PDOException $ex) {
                echo "Falha: " . $ex->getMessage();
            }
        }
    } else {
        header('Location:../Views/cadastrar_taf.php?retorno=3');
    }
} else {
    foreach ($exclusao as $item) {
        try {
            //remove o arquivo do servidor
            $stmt = $conn->query('SELECT taf_arquivo FROM taf WHERE id = ' . $item . '')->fetch();
            if (($stmt['taf_arquivo'] != '') && ($stmt['taf_arquivo'] != null)) {
                unlink($stmt['taf_arquivo']);
            }
            //apaga o registro da tabela no BD
            $stmt = $conn->prepare('DELETE FROM taf WHERE id = :id');
            $stmt->execute(array(
                ':id' => $item
            ));
            if ($stmt) header('Location:../Views/cadastrar_taf.php?retorno=4');
        } catch (PDOException $ex) {
            echo "Falha: " . $ex->getMessage();
        }
    }
}
