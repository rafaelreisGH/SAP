<?php

require_once '../ConexaoDB/conexao.php';

$id = $_POST['id'];
echo $id.'<br>';
$ano = $_POST['ano'];
$semestre = $_POST['semestre'];

$consulta = $conn->query("SELECT id, semestre_processo_promocional, ano_processo_promocional FROM pasta_promocional WHERE militar_id = '" . $id . "'"
        . "AND semestre_processo_promocional = '" . $semestre . "' "
        . "AND ano_processo_promocional = '" . $ano . "'");
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
//declaração de variáveis auxiliares
$aux_ano;
$aux_sem;
$id_pasta;
if (isset($resultado)) {
    $aux_ano = $resultado['ano_processo_promocional'];
    $aux_sem = $resultado['semestre_processo_promocional'];
    $id_pasta = $resultado['id'];
}
if (($aux_ano == $ano) && ($aux_sem == $semestre)) {
    $stmt = $conn->prepare("UPDATE pasta_promocional SET ano_processo_promocional = :ano, semestre_processo_promocional = :semestre, militar_id = :militar_id WHERE id = :id");
    $stmt->execute(array(
        ':id' => $id_pasta,
        ':ano' => $ano,
        ':semestre' => $semestre,
        ':militar_id' => $id,
    ));
    //header('Location:../Views/insere_fad.php?militar_id=' . $id . '&erro=1');
    header('Location:../Views/cadastro_de_pasta.php?militar_id=' . $id . '&erro=0');
} else {
    $stmt = $conn->prepare("INSERT INTO pasta_promocional (ano_processo_promocional, semestre_processo_promocional, militar_id) VALUES (?,?,?)");
    $stmt->bindParam(1, $ano);
    $stmt->bindParam(2, $semestre);
    $stmt->bindParam(3, $id);
    $stmt->execute();
    if ($stmt) {
        header('Location:../Views/cadastro_de_pasta.php?militar_id=' . $id . '&erro=1');
    }
}



