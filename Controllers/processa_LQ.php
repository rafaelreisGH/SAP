<?php

require_once '../ConexaoDB/conexao.php';
//cálculo do intervalo de tempo entre as datas
require_once 'date_difference.php';

//preparação de variáveis
$lq_ano = isset($_POST['criterio_ano_promocao_futura']) ? $_POST['criterio_ano_promocao_futura'] : null;
$lq_dia_mes = isset($_POST['criterio_dia_mes_promocao_futura']) ? $_POST['criterio_dia_mes_promocao_futura'] : null;

$lq_ano .= '-' . $lq_dia_mes; //concatena as variáveis numa string apenas
unset($lq_dia_mes); //destrói a variável
/*************************/

//interstício teste
//salvar em variaveis os intersticios
//$intersticio = 3;
//$consulta =  $conn->query("SELECT * FROM intersticio");
//$intersticio_bd = $consulta->fetch(PDO::FETCH_ASSOC);

//variável para montar a string do header Location
$location = "Location:../Views/listar_resultado_LQ.php?data={$lq_ano}&";

//CONSULTA
//aqui os TEN CEL e ST são excluídos
//uma vez que não TEN CEL não é promovido por antiguidade
//os CEL também por estarem no último posto
//e
//porque ST só sai oficial se passar no QCO, ou se for por requerimento
$consulta = $conn->query("SELECT registro_de_promocoes.a_contar_de, registro_de_promocoes.grau_hierarquico, registro_de_promocoes.militar_id, militar.id, militar.nome, militar.posto_grad_mil, militar.quadro, militar.antiguidade FROM registro_de_promocoes CROSS JOIN militar WHERE registro_de_promocoes.militar_id = militar.id AND militar.posto_grad_mil != 'TC BM' AND militar.posto_grad_mil != 'ST BM' AND militar.posto_grad_mil != 'CEL BM' ORDER BY militar.antiguidade")->fetchAll();

if (!empty($consulta)) {
    foreach ($consulta as $resultado) {
        $aux_a_contar_de = $resultado['a_contar_de'];
        $aux_posto_grad = $resultado['grau_hierarquico'];
        $aux_nome = $resultado['nome'];
        $aux_posto_grad_atual = $resultado['posto_grad_mil'];
        $aux_quadro = $resultado['quadro'];

        //verificacao do insterstício
        //calcula a diferença entre a data informada e a última promoção
        $intervalo = dateDifference($lq_ano, $aux_a_contar_de);

        //funçao pega_intersticio
        require_once 'pega_intersticio.php';
        $intersticio = pega_instersticio($aux_posto_grad_atual, $conn);

        //o interstício deve ser igual ou maior E o posto/grad atual tem de ser igual ao do registro
        if (($intervalo >= $intersticio) && ($aux_posto_grad == $aux_posto_grad_atual)) {
            $alteracoes_realizadas[] = "{$aux_a_contar_de},{$aux_posto_grad},{$aux_nome},{$aux_quadro}";
        }
    }
    if (empty($alteracoes_realizadas)) {
        header("Location:../Views/nenhum_resultado.php");
    }
} else {
    header("Location:../Views/nenhum_resultado.php");
}
