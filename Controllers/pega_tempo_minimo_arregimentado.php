<?php
//-------------------------------------------------------//
function pega_tempo_minimo_arregimentado($posto_grad, $conn)
{
    $consulta =  $conn->query("SELECT * FROM promocao.tempo_arregimentado")->fetch(PDO::FETCH_ASSOC); 
    switch ($posto_grad) {
        case 'TC BM':
            return $consulta['tempo_tc'];
        case 'MAJ BM':
            return $consulta['tempo_maj'];
        case 'CAP BM':
            return $consulta['tempo_cap'];
        case '1º TEN BM':
            return $consulta['tempo_1ten'];
        case '2º TEN BM':
            return $consulta['tempo_2ten'];
        case 'ST BM':
            return $consulta['tempo_st'];
        case '1º SGT BM':
            return $consulta['tempo_1sgt'];
        case '2º SGT BM':
            return $consulta['tempo_2sgt'];
        case '3º SGT BM':
            return $consulta['tempo_3sgt'];
        case 'CB BM':
            return $consulta['tempo_cb'];
        case 'SD BM':
            return $consulta['tempo_sd'];
    }
}
