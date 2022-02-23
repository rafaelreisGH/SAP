<?php

require_once '../ConexaoDB/conexao.php';

//REFERE-SE à INSERÇÃO
$militar_id = (isset($_POST['militar_id'])) ? $_POST['militar_id'] : null;
$data_realizacao = (isset($_POST['data_realizacao'])) ? $_POST['data_realizacao'] : null;
$data_publicacao = (isset($_POST['data_publicacao'])) ? $_POST['data_publicacao'] : null;
$numero_bge = (isset($_POST['numero_bge'])) ? $_POST['numero_bge'] : null;
$aptidao = (isset($_POST['aptidao'])) ? $_POST['aptidao'] : null;
$restricoes = (isset($_POST['restricoes'])) ? $_POST['restricoes'] : null;
// ---------------- //

// REFERE-SE à EXCLUSÃO
$exclusao = (isset($_POST['aux_id'])) ? $_POST['aux_id'] : null;

// ---------------- //
if (is_null($exclusao)) {
    if ((!is_null($data_realizacao)) && (!is_null($numero_bge))) {
        try {
            $stmt = $conn->prepare('SELECT data_da_inspecao, bge_numero FROM ais WHERE data_da_inspecao = :data_realizacao AND bge_numero = :numero_bge AND militar_id = :militar_id');
            $stmt->execute(array(
                ':data_realizacao' => $data_realizacao,
                ':numero_bge' => $numero_bge,
                ':militar_id' => $militar_id
            ));
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) { //se encontrou
            header('Location:../Views/cadastrar_ais.php?retorno=1&militar_id=' . $militar_id . '');
        } else {
            try {
                $stmt = $conn->prepare('INSERT INTO ais (data_da_inspecao, data_public, bge_numero, aptidao, restricoes, militar_id) VALUES (:a,:b,:c,:d,:e,:f)');
                $stmt->execute(array(
                    ':a' => $data_realizacao,
                    ':b' => $data_publicacao,
                    ':c' => $numero_bge,
                    ':d' => $aptidao,
                    ':e' => $restricoes,
                    ':f' => $militar_id
                ));
                if ($stmt) header('Location:../Views/cadastrar_ais.php?retorno=2&dados[]=' . $data_realizacao . '&dados[]=' . $numero_bge . '&dados[]=' . $data_publicacao . '&militar_id=' . $militar_id . '');
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        }
    } else {
        header('Location:../Views/cadastrar_ais.php?retorno=3&militar_id=' . $militar_id . '');
    }
} else {
    try {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET ais_id = null WHERE ais_id = :id');
        $stmt->execute(array(
            ':id' => $exclusao
        ));

        //consulta no BD o caminho do arquivo que estava salvo no servidor
        $stmt = $conn->query('SELECT caminho_do_arquivo FROM ais WHERE id = ' . $exclusao . '')->fetch();
        //se encontrar resultado
        if (!empty($stmt)) {
            //apaga o arquivo do servidor
            unlink($stmt['caminho_do_arquivo']);
        }
        //apaga todo o registro de ais do BD
        $stmt = $conn->prepare('DELETE FROM ais WHERE id = :id');
        $stmt->execute(array(
            ':id' => $exclusao
        ));

        if ($stmt) header('Location:../Views/cadastrar_ais.php?retorno=4&militar_id=' . $militar_id . '');
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}
