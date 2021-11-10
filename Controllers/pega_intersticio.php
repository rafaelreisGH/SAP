<?php 
//-------------------------------------------------------//
function pega_instersticio($posto_grad, $intersticio_bd)
{

    switch ($posto_grad) {
        case 'TC BM':
            return $intersticio_bd['tc_cel'];
        case 'MAJ BM':
            return $intersticio_bd['maj_tc'];
        case 'CAP BM':
            return $intersticio_bd['cap_maj'];
        case '1º TEN BM':
            return $intersticio_bd['1ten_cap'];
        case '2º TEN BM':
            return $intersticio_bd['2ten_1ten'];
        case 'ASP OF BM':
            return $intersticio_bd['asp_2ten'];
        case 'ST BM':
            return $intersticio_bd['st_2ten'];
        case '1º SGT BM':
            return $intersticio_bd['1sgt_st'];
        case '2º SGT BM':
            return $intersticio_bd['2sgt_1sgt'];
        case '3º SGT BM':
            return $intersticio_bd['3sgt_2sgt'];
        case 'CB BM':
            return $intersticio_bd['cb_3sgt'];
        case 'SD BM':
            return $intersticio_bd['sd_cb'];
    }
}
