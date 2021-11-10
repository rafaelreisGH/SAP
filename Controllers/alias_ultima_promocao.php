<?php
/*Este arquivo Controller serve apenas para colocar a data no formato brasileiro
*/

function alias_ultima_promocao($ultima_promocao)
{
    //converter a data vinda do BD MYSQL para formato brasileiro
    return implode("/",array_reverse(explode("-",$ultima_promocao)));
    /*******************************************/
}
