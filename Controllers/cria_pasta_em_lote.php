<?php
require_once '../ConexaoDB/conexao.php';

//CASO NENHUM MILITAR SEJA SELECIONADO
//Redireciona para a página de seleção de critérios
$criterios_posto_grad = (isset($_POST['criterio_posto_grad'])) ? $_POST['criterio_posto_grad'] : null;
$criterios_quadro = (isset($_POST['criterio_quadro'])) ? $_POST['criterio_quadro'] : null;

if (isset($_POST['militar_id'])) {
    $militar_id = $_POST['militar_id'];
} else { // se não for selecionado nenhum militar
    header('Location:../Views/listar_militares_criar_pasta_em_lote.php?nada_alterado=1&criterio_posto_grad=' . $criterios_posto_grad . '&criterio_quadro=' . $criterios_quadro . '');
}

$id = $_POST['militar_id'];
$ano = $_POST['ano'];
$semestre = $_POST['semestre'];

foreach ($id as $item) {
    try {
        $consulta = $conn->query("SELECT id, semestre_processo_promocional, ano_processo_promocional FROM pasta_promocional WHERE militar_id = '" . $item . "'"
            . "AND semestre_processo_promocional = '" . $semestre . "' "
            . "AND ano_processo_promocional = '" . $ano . "'");
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    //conta quantos resultados obtive a consulta
    $rowCount = $consulta->rowCount();

    //array para gravar os militares que tiveram os registros alterados
    $alteracoes = array();

    /* se o resultado for igual a zero
    significa que não há registro no BD
    Portanto tenta-inserir o registro */
    if (!$rowCount) {
        //
        try {
            $stmt = $conn->prepare("INSERT INTO pasta_promocional (ano_processo_promocional, semestre_processo_promocional, militar_id) VALUES (?,?,?)");
            $stmt->bindParam(1, $ano);
            $stmt->bindParam(2, $semestre);
            $stmt->bindParam(3, $item);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
        if ($stmt) {
            $alteracoes[] = $item;
        }
    } else $nada_alterado[] = $item;
}

//variável para montar a string do header Location
$location = 'Location:../Views/listar_militares_criar_pasta_em_lote.php?criterio_posto_grad=' . $criterios_posto_grad . '&criterio_quadro=' . $criterios_quadro . '&';

if (sizeof($alteracoes)) {
    $location .= "alteracoes_realizadas[]=" . implode("&alteracoes_realizadas[]=", $alteracoes);
    header($location);
} else {
    $location .= "nada_alterado[]=" . implode("&nada_alterado[]=", $nada_alterado);
    header($location);
}
