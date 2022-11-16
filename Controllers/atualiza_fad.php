<?php
require_once '../ConexaoDB/conexao.php';

// exit();

//se o botão validar for clicado
//se existir o id da fad
//se o id for INT
if (isset($_POST['btn_validar']) && isset($_POST['fad_id']) && intval($_POST['fad_id'])) {
    $id = intval($_POST['fad_id']);
    require_once '../Controllers/select_dados_fad.php';
    if (fad_existe($conn, $id)) {
        try {
            $stmt = $conn->prepare("UPDATE promocao.fad SET fad.ciente_do_avaliado = 1, fad.data_do_ciente = CURRENT_TIMESTAMP()  WHERE fad.id = :id ");
            $stmt->execute([
                ':id' => $id                
            ]);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        $rowCount = $stmt->rowCount();

        if ($rowCount) {
            //redireciona com sucesso na URL
            header('Location: ../Views/home_candidato.php?sucesso=fad_validada&militar_id=' . $_POST['militar_id'] . '');
        }
    } else {
        //redireciona com o erro na URL
        header('Location: ../Views/home_candidato.php?erro=fad_inexistente&militar_id=' . $_POST['militar_id'] . '');
    }
} else {
    //redireciona para acesso restrito
    header('Location: ../Views/acesso_restrito.php');
}





$id_militar = $_POST['id'];
$semestre = $_POST['semestre'];
$ano = $_POST['ano'];
$postoGradNoPerioAvaliado = filter_input(INPUT_POST, 'postoGradNoPerioAvaliado', FILTER_SANITIZE_STRING);
$pontuacao = filter_input(INPUT_POST, 'pontuacao', FILTER_VALIDATE_FLOAT);

$consulta = $conn->query("SELECT id, semestre, ano FROM fad WHERE militar_id = '" . $id_militar . "'"
    . "AND semestre = '" . $semestre . "' "
    . "AND ano = '" . $ano . "'");
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
//declaração de variáveis auxiliares
$aux_ano;
$aux_sem;
$id_militar_fad;
if (!empty($resultado)) {
    $aux_ano = $resultado['ano'];
    $aux_sem = $resultado['semestre'];
    $id_militar_fad = $resultado['id'];
    if (($aux_ano == $ano) && ($aux_sem == $semestre)) {
        // $stmt = $conn->prepare("UPDATE fad SET ano = :ano, semestre = :semestre, nota = :nota, militar_id = :militar_id WHERE id = :id");
        // $stmt->execute(array(
        //     ':id' => $id_militar_fad,
        //     ':ano' => $ano,
        //     ':semestre' => $semestre,
        //     ':nota' => $pontuacao,
        //     ':militar_id' => $id_militar,
        // ));
        header('Location:../Views/insere_fad.php?militar_id=' . $id_militar . '&erro=1');
    }
} else {
    $stmt = $conn->prepare("INSERT INTO fad (ano, semestre, nota, militar_id, grau_hierarquico_na_epoca) VALUES (?,?,?,?,?)");
    $stmt->bindParam(1, $ano);
    $stmt->bindParam(2, $semestre);
    $stmt->bindParam(3, $pontuacao);
    $stmt->bindParam(4, $id_militar);
    $stmt->bindParam(5, $postoGradNoPerioAvaliado);
    $stmt->execute();
    if ($stmt) {
        header('Location:../Views/insere_fad.php?nota=' . $pontuacao . '&militar_id=' . $id_militar . '&semestre=' . $semestre . '&id=' . $semestre . '&ano=' . $ano . '');
    }
}
