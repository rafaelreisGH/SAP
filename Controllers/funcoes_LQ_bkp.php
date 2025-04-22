<?php
require_once '../ConexaoDB/conexao.php';
$conn = Conexao::getConexao();
require_once '../Controllers/date_difference.php';
require_once '../Controllers/funcoes_intersticio.php';

function processa_lista_de_candidatos($conn, $lq_ano)
{
    $consulta = $conn->query(
        "SELECT registro_de_promocoes.a_contar_de, registro_de_promocoes.grau_hierarquico, " .
            "registro_de_promocoes.militar_id, militar.id, militar.nome, militar.posto_grad_mil, " .
            "militar.quadro, militar.antiguidade, militar.data_cumprimento_intersticio, militar.id " .
            "FROM registro_de_promocoes " .
            "CROSS JOIN militar " .
            "WHERE registro_de_promocoes.militar_id = militar.id " .
            "AND militar.posto_grad_mil NOT IN ('TC BM', 'ST BM', 'CEL BM') " .
            "ORDER BY militar.antiguidade"
    )->fetchAll();

    if (empty($consulta)) {
        header("Location:../Views/nenhum_resultado.php");
        exit();
    }

    require_once 'funcoes_intersticio.php';
    $alteracoes_realizadas = [];

    foreach ($consulta as $resultado) {
        $aux_a_contar_de = $resultado['a_contar_de'];
        $aux_posto_grad = $resultado['grau_hierarquico'];
        $aux_nome = $resultado['nome'];
        $aux_posto_grad_atual = $resultado['posto_grad_mil'];
        $aux_quadro = $resultado['quadro'];
        $aux_cumprimento_intersticio = $resultado['data_cumprimento_intersticio'];
        $aux_id = $resultado['id'];

        if (is_null($aux_cumprimento_intersticio)) {
            $intervalo = dateDifference($lq_ano, $aux_a_contar_de);
            $intersticio = pega_intersticio($aux_posto_grad_atual, $conn);

            if (($intervalo >= $intersticio) && ($aux_posto_grad == $aux_posto_grad_atual)) {
                $alteracoes_realizadas[] = "$aux_a_contar_de,$aux_posto_grad,$aux_nome,$aux_quadro,$aux_id";
            }
        } else {
            if ((tem_intersticio($lq_ano, $aux_cumprimento_intersticio)) && ($aux_posto_grad == $aux_posto_grad_atual)) {
                $alteracoes_realizadas[] = "$aux_cumprimento_intersticio,$aux_posto_grad,$aux_nome,$aux_quadro,$aux_id";
            }
        }
    }
    if (empty($alteracoes_realizadas)) {
        header("Location:../Views/nenhum_resultado.php");
        exit();
    }

    return $alteracoes_realizadas;
}

function processa_documentos_de_candidatos($conn, $semestre, $ano)
{
    $stmt = $conn->prepare("SELECT 
        militar.id,
        militar.posto_grad_mil, 
        militar.nome,
        militar.antiguidade,
        militar.quadro,
        documento_promocao.doc_promo_nome,
        documento_promocao.doc_status_id
    FROM militar
    INNER JOIN pasta_promocional ON pasta_promocional.militar_id = militar.id
    LEFT JOIN documento_promocao ON documento_promocao.militar_id = militar.id
    WHERE 
        pasta_promocional.ano_processo_promocional = :ano 
        AND pasta_promocional.semestre_processo_promocional = :semestre
        AND militar.posto_grad_mil NOT IN ('TC BM', 'ST BM', 'CEL BM')
    ORDER BY militar.antiguidade;");
    $stmt->execute([
        ':ano' => $ano,
        ':semestre' => $semestre
    ]);
    $consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '<pre>';
    print_r($consulta); // Debugging line to check the fetched data
    echo '</pre>';

    if (empty($consulta)) {
        header("Location:../Views/nenhum_resultado.php");
        exit();
    }

    $documentacao_entregue = [];

    foreach ($consulta as $resultado) {
        $aux_id = $resultado['id'];
        $aux_nome = $resultado['nome'];
        $aux_posto_grad = $resultado['posto_grad_mil'];
        $aux_quadro = $resultado['quadro'];
        $aux_doc_nome = $resultado['doc_promo_nome'];
        $aux_doc_status = $resultado['doc_status_id'];

        //traduz o status do documento para o nome
        switch ($aux_doc_status) {
            case 1:
                $aux_doc_status = "O.K.";
                break;
            case 2:
                $aux_doc_status = "N.E.";
                break;
            case 3:
                $aux_doc_status = "E.R.";
                break;
        }

        $documentacao_entregue[] = "$aux_id,$aux_posto_grad,$aux_nome,$aux_quadro,$aux_doc_nome,$aux_doc_status";
    }
    return $documentacao_entregue;
}

function obterAnoESemestre($data)
{
    $dataObj = new DateTime($data);
    $ano = $dataObj->format("Y"); // Obtém o ano
    $mes = $dataObj->format("n"); // Obtém o número do mês

    $semestre = ($mes <= 6) ? 1 : 2; // Define o semestre

    return ["ano" => $ano, "semestre" => $semestre];
}
