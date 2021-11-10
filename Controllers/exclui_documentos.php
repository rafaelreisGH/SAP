<?php

require_once '../ConexaoDB/conexao.php';

$id = $_POST['id'];
$ano = $_POST['ano'];
$semestre = $_POST['semestre'];

$documento_a_ser_excluido = $_POST['documento_a_ser_excluido'];
$aux = '';
$sucesso;

//verifica se existe pasta promocional

try {
    if ($documento_a_ser_excluido == 'taf') {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET taf = :aux WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
        $stmt->execute(array(
            ':id' => $id,
            ':semestre' => $semestre,
            ':ano' => $ano,
            ':aux' => $aux
        ));
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $sucesso = 1;
        } else {
            $sucesso = 0;
        }
    }
    if ($documento_a_ser_excluido == 'ais') {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET ais = :aux WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
        $stmt->execute(array(
            ':id' => $id,
            ':semestre' => $semestre,
            ':ano' => $ano,
            ':aux' => $aux
        ));
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $sucesso = 1;
        } else {
            $sucesso = 0;
        }
    }
    if ($documento_a_ser_excluido == 'certidao_tj_1_inst') {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET certidao_tj_1_inst = :aux WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
        $stmt->execute(array(
            ':id' => $id,
            ':semestre' => $semestre,
            ':ano' => $ano,
            ':aux' => $aux
        ));
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $sucesso = 1;
        } else {
            $sucesso = 0;
        }
    }
    if ($documento_a_ser_excluido == 'certidao_tj_2_inst') {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET certidao_tj_2_inst = :aux WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
        $stmt->execute(array(
            ':id' => $id,
            ':semestre' => $semestre,
            ':ano' => $ano,
            ':aux' => $aux
        ));
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $sucesso = 1;
        } else {
            $sucesso = 0;
        }
    }
    if ($documento_a_ser_excluido == 'fad_ultimo_semestre') {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET fad_ultimo_semestre = :aux WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
        $stmt->execute(array(
            ':id' => $id,
            ':semestre' => $semestre,
            ':ano' => $ano,
            ':aux' => $aux
        ));
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $sucesso = 1;
        } else {
            $sucesso = 0;
        }
    }
    if ($documento_a_ser_excluido == 'certidao_trf_sj_mt') {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET certidao_trf_sj_mt = :aux WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
        $stmt->execute(array(
            ':id' => $id,
            ':semestre' => $semestre,
            ':ano' => $ano,
            ':aux' => $aux
        ));
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $sucesso = 1;
        } else {
            $sucesso = 0;
        }
    }
    if ($documento_a_ser_excluido == 'certidao_trf_1') {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET certidao_trf_1 = :aux WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
        $stmt->execute(array(
            ':id' => $id,
            ':semestre' => $semestre,
            ':ano' => $ano,
            ':aux' => $aux
        ));
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $sucesso = 1;
        } else {
            $sucesso = 0;
        }
    }
    if ($documento_a_ser_excluido == 'nada_consta_correg') {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET nada_consta_correg = :aux WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
        $stmt->execute(array(
            ':id' => $id,
            ':semestre' => $semestre,
            ':ano' => $ano,
            ':aux' => $aux
        ));
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $sucesso = 1;
        } else {
            $sucesso = 0;
        }
    }
    if ($documento_a_ser_excluido == 'cursos_e_estagios') {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET cursos_e_estagios = :aux WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
        $stmt->execute(array(
            ':id' => $id,
            ':semestre' => $semestre,
            ':ano' => $ano,
            ':aux' => $aux
        ));
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $sucesso = 1;
        } else {
            $sucesso = 0;
        }
    }
    if ($documento_a_ser_excluido == 'conceito_moral') {
        $stmt = $conn->prepare('UPDATE pasta_promocional SET conceito_moral = :aux WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
        $stmt->execute(array(
            ':id' => $id,
            ':semestre' => $semestre,
            ':ano' => $ano,
            ':aux' => $aux
        ));
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $sucesso = 1;
        } else {
            $sucesso = 0;
        }
    }
    header('Location:../Views/pasta_promocional_home.php?militar_id=' . $id . '&sucesso_exclusão=' . $sucesso . '');
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}