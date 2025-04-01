<?php
require_once '../ConexaoDB/conexao.php';
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

function processa_documentos_de_candidatos($conn, $semestre, $ano, $lista)
{
    $lista = isola_id_candidatos($lista);
    $id_dos_militares = array_map('intval', $lista);

    foreach ($id_dos_militares as $item) {
        $id_dos_militares[$item] = $item;
    }

    $resultados = []; // Array para armazenar os resultados
    foreach ($id_dos_militares as $item) {
        $stmt = $conn->prepare("SELECT DISTINCT
            militar.id,
            militar.posto_grad_mil, 
            militar.nome,
            militar.antiguidade,
            militar.quadro,
            documento_promocao.doc_promo_nome,
            documento_promocao.doc_status_id
        FROM militar
            INNER JOIN pasta_promocional 
                ON pasta_promocional.militar_id = militar.id
            LEFT JOIN documento_promocao 
                ON documento_promocao.pasta_promocional_id = pasta_promocional.id
        WHERE
            pasta_promocional.ano_processo_promocional = :ano 
            AND pasta_promocional.semestre_processo_promocional = :semestre
            AND militar.id = :militar_id
            AND militar.posto_grad_mil NOT IN ('TC BM', 'ST BM', 'CEL BM')
        ORDER BY militar.antiguidade;");

        $stmt->bindValue(':ano', $ano, PDO::PARAM_INT);
        $stmt->bindValue(':semestre', $semestre, PDO::PARAM_INT);
        $stmt->bindValue(':militar_id', $item, PDO::PARAM_INT);

        $stmt->execute();
        $consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($consulta)) {
            $resultados[$item] = $consulta; // Armazena os resultados para cada militar
        } else {
            return false; // Retorna falso se não houver resultados
        }
    }

    foreach ($resultados as $militar_id => &$dados) { // Passagem por referência (&) para modificar os valores diretamente
        foreach ($dados as &$dado) {
            switch ($dado['doc_status_id']) {
                case 1:
                    $dado['doc_status_id'] = 'O.K.';
                    break;
                case 2:
                    $dado['doc_status_id'] = 'N.E.';
                    break;
                case 3:
                    $dado['doc_status_id'] = 'E.R.';
                    break;
            }
        }
        unset($dados); // Evita problemas de referência ao modificar outras variáveis depois
    }
    return $resultados;
}

function obterAnoESemestre($data)
{
    // Verifica se já está no formato Y-m-d
    $dataObj = DateTime::createFromFormat("Y-m-d", $data);

    if (!$dataObj || $dataObj->format("Y-m-d") !== $data) {
        // Se não estiver no formato Y-m-d, tenta converter do formato d/m/Y
        $dataObj = DateTime::createFromFormat("d/m/Y", $data);

        if (!$dataObj) {
            return ["erro" => "Formato de data inválido"];
        }
    }

    $ano = $dataObj->format("Y");
    $mesDia = $dataObj->format("m-d"); // Obtém mês e dia no formato MM-DD

    if ($mesDia <= "07-02") {
        $semestre = 1; // Primeiro semestre
    } elseif ($mesDia <= "12-02") {
        $semestre = 2; // Segundo semestre (até 02 de dezembro)
    } else {
        $semestre = 2; // Segundo semestre (depois de 02 de dezembro, incluindo 21 de dezembro)
    }

    return ["ano" => $ano, "semestre" => $semestre];
}

function isola_id_candidatos($lista)
{
    if (isset($lista)) {
        foreach ($lista as $item) {
            $auxiliar[] = explode(",", $item);
        }
    }

    foreach ($auxiliar as $subarray) {
        if (isset($subarray[4])) { // Verifica se a posição 4 existe
            $id_dos_militares[] = $subarray[4]; // Adiciona ao array final
        }
    }

    return $id_dos_militares;
}

function criarPastaPromocionalEmLote($lista, $lq_ano, $conn)
{
    $id = isola_id_candidatos($lista);
    $data = obterAnoESemestre($lq_ano);
    $ano_processo_promocional = $data['ano'];
    $semestre_processo_promocional = $data['semestre'];

    $sucesso = []; // array para armazenar os id das pastas promocionais

    foreach ($id as $item) {
        // Verifica se já existe o registro
        $stmt = $conn->prepare("SELECT COUNT(*) FROM pasta_promocional 
                                WHERE militar_id = :militar_id 
                                AND ano_processo_promocional = :ano 
                                AND semestre_processo_promocional = :semestre");

        $stmt->bindValue(':militar_id', $item, PDO::PARAM_INT);
        $stmt->bindValue(':ano', $ano_processo_promocional, PDO::PARAM_INT);
        $stmt->bindValue(':semestre', $semestre_processo_promocional, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetchColumn() == 0) { // Se não existir, insere
            $stmt = $conn->prepare("INSERT INTO pasta_promocional (militar_id, ano_processo_promocional, semestre_processo_promocional) 
                                    VALUES (:militar_id, :ano_processo_promocional, :semestre_processo_promocional)");

            $stmt->bindValue(':militar_id', $item, PDO::PARAM_INT);
            $stmt->bindValue(':ano_processo_promocional', $ano_processo_promocional, PDO::PARAM_INT);
            $stmt->bindValue(':semestre_processo_promocional', $semestre_processo_promocional, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $id = $conn->lastInsertId(); // Obtém o ID da pasta promocional criada
                $sucesso[] = ['id_militar' => (int)$item, 'id_pasta' => (int)$id]; // Adiciona o ID ao array de sucesso
            }
        }
    }
    return $sucesso; // Retorna verdadeiro se pelo menos um registro foi inserido
}

function criaDocumentosVazios($pastas_id, $conn)
{
    $sucesso = false; // Flag para verificar se ao menos um registro foi inserido

    foreach ($pastas_id as $item) {
        $stmt = $conn->prepare("INSERT INTO documento_promocao (militar_id, pasta_promocional_id, doc_promo_nome, doc_status_id)
        VALUES (:militar_id, :pasta, 'cert_1JE', 2),(:militar_id, :pasta, 'cert_2JE', 2),(:militar_id, :pasta, 'cert_1JF', 2),(:militar_id, :pasta, 'cert_2JF', 2),(:militar_id, :pasta, 'cert_tse', 2),(:militar_id, :pasta, 'fad', 2),(:militar_id, :pasta, 'rta', 2),(:militar_id, :pasta, 'ais', 2)");

        $stmt->bindValue(':militar_id', $item["id_militar"], PDO::PARAM_INT);
        $stmt->bindValue(':pasta', $item["id_pasta"], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $sucesso = true; // Indica que pelo menos uma inserção foi feita
        }
    }
    return $sucesso; // Retorna verdadeiro se pelo menos um registro foi inserido
}

function extrairDadosRecursivo($documentacao, &$resultado = [])
{
    foreach ($documentacao as $key => $item) {
        $resultado[] = array_merge([$key, $item[0]["posto_grad_mil"], $item[0]["nome"], $item[0]["quadro"]], extrairStatus($item, 0));
    }
    return $resultado;
}

function extrairStatus($item, $index)
{
    if (!isset($item[$index]["doc_status_id"])) {
        return []; // Base da recursão: retorna um array vazio se o índice não existir
    }
    return array_merge([$item[$index]["doc_status_id"]], extrairStatus($item, $index + 1));
}
