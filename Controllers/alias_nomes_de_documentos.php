<?php
/*Este arquivo Controller serve apenas para renomear os nomes dos documentos
de modo que o VARCHAR do BD apareça no HTML mais amigavelmente
*/

function alias_documentos($doc)
{
    switch ($doc) {
        case 'certidao_tj_1_inst':
            return 'Certidão TJ-MT - 1ª instância';
            break;
        case 'certidao_tj_2_inst':
            return 'Certidão TJ-MT - 2ª instância';
            break;
        case 'certidao_trf_1':
            return 'Certidão Conjunta do TRF';
            break;
        case 'certidao_tse':
            return 'Certidão de Crimes eleitorais (TSE)';
            break;
        case 'nada_consta_correg':
            return 'Nada Consta da Corregdoria Geral';
            break;
        case 'conceito_moral':
            return 'Conceito Moral';
            break;
        case 'cursos_e_estagios':
            return 'Cursos e estágios';
            break;
        case 'militar_tem_taf_id':
            return 'Teste de Aptidão Física (TAF)';
            break;
        case 'ais_id':
            return 'Ata de inspeção de saúde';
            break;
        case 'media_das_avaliacoes':
            return 'Avaliação individual';
            break;

    }
}
