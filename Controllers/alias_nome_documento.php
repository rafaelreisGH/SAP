<?php
/*Este arquivo Controller serve apenas para renomear os postos e graduações
de modo que o VARCHAR do BD apareça no HTML mais amigavelmente
*/

function alias_nome_documento($nome_documento)
{
    switch ($nome_documento) {
        case 'cert_tjmt_1_criminal':
            return 'Certidão TJ-MT - 1ª instância - criminal';
            break;
        case 'cert_tjmt_2_criminal':
            return 'Certidão TJ-MT - 2ª instância - criminal';
            break;
        case 'cert_trf1_1_criminal':
            return 'Certidão TRF-1 - 1ª instância - criminal';
            break;
        case 'cert_trf1_2_criminal':
            return 'Certidão TRF-1 - 2ª instância - criminal';
            break;
        case 'cert_trf_sç_jud_mt':
            return 'Certidão TRF-1 - Seção Judiciária/MT';
            break;
        case '2º TEN BM':
            return '2º Tenente';
            break;
        case 'ASP OF BM':
            return 'Aspirante-a-oficial';
            break;
        case 'ST BM':
            return 'Subtenente';
            break;
        case '1º SGT BM':
            return '1º Sargento ';
            break;
        case '2º SGT BM':
            return '2º Sargento';
            break;
        case '3º SGT BM':
            return '3º Sargento';
            break;
        case 'CB BM':
            return 'Cabo';
            break;
        case 'SD BM':
            return 'Soldado';
            break;

    }
}
