<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header.php';
require_once '../Controllers/funcoes_LQ.php';

function contar_vagas_ocupadas()
{
    global $conn;

    $total = [];

    // SGT BM
    $stmt_sgt = $conn->prepare("SELECT COUNT(*) FROM militar WHERE posto_grad_mil LIKE '%SGT BM'");

    $stmt_sgt->execute();
    $total_sgt = (int) $stmt_sgt->fetchColumn();

    $total["sgt"] = $total_sgt;

    // CB BM
    $stmt_cb = $conn->prepare("SELECT COUNT(*) FROM militar WHERE posto_grad_mil = 'CB BM'");
    $stmt_cb->execute();
    $total_cb = (int) $stmt_cb->fetchColumn();
    // SD BM
    $stmt_sd = $conn->prepare("SELECT COUNT(*) FROM militar WHERE posto_grad_mil = 'SD BM'");
    $stmt_sd->execute();
    $total_sd = (int) $stmt_sd->fetchColumn();

    $total["cb_sd"] = $total_sd + $total_cb;

    return $total;
}

function apurar_vagas_para_cabo()
{
    require_once '../Controllers/vagas_qpbm.php';
    $vagas_ocupadas = contar_vagas_ocupadas();
    echo $vagas_ocupadas["sgt"];

    $vagas_disponiveis = $qpbm['sgt'] - $vagas_ocupadas["sgt"];
    return $vagas_disponiveis;
}

// echo 'Vagas disponíveis para Cabo BM: ' . apurar_vagas_para_cabo() . '<br>';

// /*-------------------------------------------------------------------*/
//função para verificar quem pode ser promovido no respectivo processo promocional
$alteracoes_realizadas = processa_lista_de_candidatos($conn, "2025-07-02", "COMBATENTE");

// $alteracoes_realizadas = filtrar_sd($alteracoes_realizadas);
// $alteracoes_realizadas = filtrar_sd($alteracoes_realizadas);
$aux = isola_id_candidatos($alteracoes_realizadas);
echo '<pre>';
print_r($aux);
echo '</pre>';

