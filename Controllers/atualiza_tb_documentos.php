<?php
require_once '../ConexaoDB/conexao.php';
//exclusivo para AIS
$id_pasta = isset($_POST['id_pasta']) ? $_POST['id_pasta'] : null;
$id_ais = isset($_POST['id_ais']) ? $_POST['id_ais'] : null;

//outros documentos
$dados_pasta = isset($_POST['dados_pasta']) ? $_POST['dados_pasta'] : null;
$tipo_doc = isset($_POST['tipo_do_documento']) ? $_POST['tipo_do_documento'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;

//outros documentos
if ((!is_null($dados_pasta)) && (!is_null($tipo_doc)) && (!is_null($status))) {
    switch ($status) {
        case '':
            $status = null;
            break;
    }
    try {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET ' . $tipo_doc . ' = :status WHERE id = :dados_pasta');
        $stmt->execute(array(
            ':status' => $status,
            ':dados_pasta' => $dados_pasta
        ));
        if ($stmt) {
            $sucesso = 1;
            header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $dados_pasta . '&sucesso[]=' . $sucesso . '&documento=' . $tipo_doc . '');
        } else {
            $sucesso = 0;
            header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $dados_pasta . '&sucesso[]=' . $sucesso . '&documento=' . $tipo_doc . '');
        }
    } catch (PDOException $ex) {
        return $ex->getMessage();
    }

    // salvar iD da AIS na pasta promocional
    if ((!is_null($id_pasta)) && (!is_null($id_ais))) {
        try {
            $stmt = $conn->prepare('UPDATE pasta_promocional SET ais_id = :id_ais WHERE id = :id_pasta');
            $stmt->execute(array(
                ':id_ais' => $id_ais,
                ':id_pasta' => $id_pasta
            ));
            if ($stmt) {
                $sucesso = 1;
                $documento = 'AIS';
                header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_pasta . '&sucesso[]=' . $sucesso . '&documento=' . $documento . '');
            } else {
                $sucesso = 0;
                $documento = 'AIS';
                header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_pasta . '&sucesso[]=' . $sucesso . '&documento=' . $documento . '');
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
}
