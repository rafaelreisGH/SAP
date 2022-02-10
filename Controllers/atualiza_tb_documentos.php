<?php
require_once '../ConexaoDB/conexao.php';
// var_dump($_POST);
// die();

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

    $stmt = $conn->prepare('UPDATE pasta_promocional SET ' . $tipo_doc . ' = :status WHERE id = :dados_pasta');
    $stmt->execute(array(
        ':status' => $status,
        ':dados_pasta' => $dados_pasta
    ));

    if ($stmt) {
        $sucesso = 1;
        header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $dados_pasta . '&sucesso=' . $sucesso . '&documento=' . $tipo_doc . '');
    } else {
        $sucesso = 0;
        header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $dados_pasta . '&sucesso=' . $sucesso . '&documento=' . $tipo_doc . '');
    }
} else if (isset($_POST['id_taf'])) {
    $id_da_pasta = $_POST['id_da_pasta'];
    $id_taf = $_POST['id_taf'];
    $id_militar = $_POST['id_militar'];

    //VERIFICAR NO BD SE JÁ EXISTE REGISTRO DO MESMO (ID)TAF PARA O MESMO MILITAR
    $stmt = $conn->query('SELECT militar_tem_taf.id FROM promocao.militar_tem_taf WHERE taf_id = ' . $id_taf . ' AND militar_id = ' . $id_militar . '')->fetch();

    //SE EXISTIR FAZ UM UPDATE NA TABELA
    if ($stmt == true) {
        $militar_tem_taf_id = $stmt['id'];

        $stmt = $conn->prepare('UPDATE promocao.militar_tem_taf SET aptidao = :a, mencao = :b, tipo_do_taf = :c, militar_id = :d, taf_id =:e WHERE taf_id = ' . $id_taf . ' AND militar_id = ' . $id_militar . '');
        $stmt->execute(array(
            ':a' => $_POST['taf_aptidao'],
            ':b' => $_POST['taf_mencao'],
            ':c' => $_POST['taf_tipo'],
            ':d' => $_POST['id_militar'],
            ':e' => $_POST['id_taf']
        ));
    } else {
        //SE NÃO EXISTIR, FAZ UM INSERT
        $stmt = $conn->prepare('INSERT INTO promocao.militar_tem_taf (aptidao, mencao, tipo_do_taf, militar_id, taf_id) VALUES (:a, :b, :c, :d, :e)');
        $stmt->execute(array(
            ':a' => $_POST['taf_aptidao'],
            ':b' => $_POST['taf_mencao'],
            ':c' => $_POST['taf_tipo'],
            ':d' => $_POST['id_militar'],
            ':e' => $_POST['id_taf']
        ));

        //AGORA ATUALIZA A PASTA PROMOCIONAL
        //descobrir qual o id da inserçao acima para poder atualizar a tabela pasta_promocional
        $stmt = $conn->query('SELECT militar_tem_taf.id FROM promocao.militar_tem_taf WHERE taf_id = ' . $id_taf . ' AND militar_id = ' . $id_militar . '')->fetch();
        $militar_tem_taf_id = $stmt['id'];

        //ATUALIZA PASTA PROMOCIONAL
        $stmt = $conn->prepare('UPDATE promocao.pasta_promocional SET militar_tem_taf_id = :a WHERE id = :id');
        $stmt->execute(array(
            ':a' => $militar_tem_taf_id,
            ':id' => $id_da_pasta
        ));

        if ($stmt) {
            $sucesso = 1;
            $documento = 'TAF';
            header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_da_pasta . '&sucesso=' . $sucesso . '&documento=' . $documento . '&militar_tem_taf_id=' . $militar_tem_taf_id . '');
        } else {
            $sucesso = 0;
            $documento = 'TAF';
            header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_da_pasta . '&sucesso[=' . $sucesso . '&documento=' . $documento . '');
        }
    }
    //ATUALIZA PASTA PROMOCIONAL
    $stmt = $conn->prepare('UPDATE promocao.pasta_promocional SET militar_tem_taf_id = :a WHERE id = :id');
    $stmt->execute(array(
        ':a' => $militar_tem_taf_id,
        ':id' => $id_da_pasta
    ));

    if ($stmt) {
        $sucesso = 1;
        $documento = 'TAF';
        header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_da_pasta . '&sucesso=' . $sucesso . '&documento=' . $documento . '&militar_tem_taf_id=' . $militar_tem_taf_id . '');
    } else {
        $sucesso = 0;
        $documento = 'TAF';
        header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_da_pasta . '&sucesso=' . $sucesso . '&documento=' . $documento . '');
    }

//A PARTIR DAQUI É AIS

} else if (is_null($id_ais)) {
    $sucesso = 0;
    $documento = 'AIS';
    header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_pasta . '&sucesso=' . $sucesso . '&documento=' . $documento . '');
} else {

    //VERIFICAR SE A MESMA AIS JÁ CONSTA NO BD
    $stmt = $conn->query('SELECT ais_id FROM promocao.pasta_promocional WHERE ais_id = ' . $id_ais . '')->fetch();
    //Se não encontra nenhum resultado, faz um UPDATE
    if (!$stmt) {
        $stmt = $conn->prepare('UPDATE promocao.pasta_promocional SET ais_id = :ais WHERE id = '. $id_pasta .'');
        $stmt->execute(array(
            ':ais' => $id_ais
        ));
        if ($stmt) {
            $sucesso = 1;
            $documento = 'AIS';
            header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_pasta . '&sucesso=' . $sucesso . '&documento=' . $documento . '');
        } else {
            $sucesso = 0;
            $documento = 'AIS';
            header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_pasta . '&sucesso=' . $sucesso . '&documento=' . $documento . '');
        }
    } else {

    }
}
