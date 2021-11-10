<?php
require_once '../ConexaoDB/conexao.php';

$id = $_POST['id'];
$ano = $_POST['ano'];
$semestre = $_POST['semestre'];
$resultado_do_taf = $_POST['resultado_do_taf'];
$resultado_da_ais = $_POST['resultado_da_ais'];
$certidao_tj_1_instancia = $_POST['certidao_tj_1_instancia'];
$certidao_tj_2_instancia = $_POST['certidao_tj_2_instancia'];
$fad = $_POST['fad'];
$certidao_trf_sç_jud_mt = $_POST['certidao_trf_sç_jud_mt'];
$certidao_trf_1 = $_POST['certidao_trf_1'];
$nada_consta_correg = $_POST['nada_consta_correg'];
$cursos_e_estagios = $_POST['cursos_e_estagios'];
$conceito_moral = $_POST['conceito_moral'];

$sucesso; $sucesso_ais; $sucesso_tj_1; $sucesso_tj_2; $sucesso_fad; $sucesso_trf_sj; $sucesso_trf_1; $sucesso_correg; $sucesso_cursos; $sucesso_conceito;

//atualização resultados do TAF
if ($resultado_do_taf != '') {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET taf = :taf WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
    $stmt->execute(array(
        ':id' => $id,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':taf' => $resultado_do_taf
    ));
    if($stmt){
        $sucesso = 1;
    } else {
        $sucesso = 0;
    }
}
//atualização resultados da AIS
if ($resultado_da_ais != '') {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET ais = :ais WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
    $stmt->execute(array(
        ':id' => $id,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':ais' => $resultado_da_ais
    ));
    if($stmt){
        $sucesso_ais = 1;
    } else {
        $sucesso_ais = 0;
    }
}
//atualização $certidao_tj_1_instancia
if ($certidao_tj_1_instancia != '') {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET certidao_tj_1_inst = :certidao_tj_1_inst WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
    $stmt->execute(array(
        ':id' => $id,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':certidao_tj_1_inst' => $certidao_tj_1_instancia
    ));
    if($stmt){
        $sucesso_tj_1 = 1;
    } else {
        $sucesso_tj_1 = 0;
    }
}
//atualização $certidao_tj_2_instancia
if ($certidao_tj_2_instancia != '') {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET certidao_tj_2_inst = :certidao_tj_2_inst WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
    $stmt->execute(array(
        ':id' => $id,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':certidao_tj_2_inst' => $certidao_tj_2_instancia
    ));
    if($stmt){
        $sucesso_tj_2 = 1;
    } else {
        $sucesso_tj_2 = 0;
    }
}
//atualização $fad
if ($fad != '') {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET fad_ultimo_semestre = :fad_ultimo_semestre WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
    $stmt->execute(array(
        ':id' => $id,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':fad_ultimo_semestre' => $fad
    ));
    if($stmt){
        $sucesso_fad = 1;
    } else {
        $sucesso_fad = 0;
    }
}
//atualização $certidao_trf_sç_jud_mt
if ($certidao_trf_sç_jud_mt != '') {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET certidao_trf_sj_mt = :certidao_trf_sj_mt WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
    $stmt->execute(array(
        ':id' => $id,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':certidao_trf_sj_mt' => $certidao_trf_sç_jud_mt
    ));
    if($stmt){
        $sucesso_trf_sj = 1;
    } else {
        $sucesso_trf_sj = 0;
    }
}
//atualização $certidao_trf_1
if ($certidao_trf_1 != '') {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET certidao_trf_1 = :certidao_trf_1 WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
    $stmt->execute(array(
        ':id' => $id,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':certidao_trf_1' => $certidao_trf_1
    ));
    if($stmt){
        $sucesso_trf_1 = 1;
    } else {
        $sucesso_trf_1 = 0;
    }
}
//atualização $nada_consta_correg
if ($nada_consta_correg != '') {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET nada_consta_correg = :nada_consta_correg WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
    $stmt->execute(array(
        ':id' => $id,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':nada_consta_correg' => $nada_consta_correg
    ));
    if($stmt){
        $sucesso_correg = 1;
    } else {
        $sucesso_correg = 0;
    }
}
//atualização $cursos_e_estagios
if ($cursos_e_estagios != '') {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET cursos_e_estagios = :cursos_e_estagios WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
    $stmt->execute(array(
        ':id' => $id,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':cursos_e_estagios' => $cursos_e_estagios
    ));
    if($stmt){
        $sucesso_cursos = 1;
    } else {
        $sucesso_cursos = 0;
    }
}
//atualização $cursos_e_estagios
if ($conceito_moral != '') {
    $stmt = $conn->prepare('UPDATE pasta_promocional SET conceito_moral = :conceito_moral WHERE militar_id = :id AND semestre_processo_promocional = :semestre AND ano_processo_promocional = :ano');
    $stmt->execute(array(
        ':id' => $id,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':conceito_moral' => $conceito_moral
    ));
    if($stmt){
        $sucesso_conceito = 1;
    } else {
        $sucesso_conceito = 0;
    }
}

header('Location:../Views/pasta_promocional_home.php?militar_id=' . $id . '&sucesso[]='.$sucesso.'&sucesso[]='.$sucesso_ais.'&sucesso[]='.$sucesso_tj_1.'&sucesso[]='.$sucesso_tj_2.'&sucesso[]='.$sucesso_fad.'&sucesso[]='.$sucesso_trf_sj.'&sucesso[]='.$sucesso_trf_1.'&sucesso[]='.$sucesso_correg.'&sucesso[]='.$sucesso_cursos.'&sucesso[]='.$sucesso_conceito.'');
