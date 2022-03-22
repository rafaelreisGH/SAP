<?php

/*
1 => Gestor
2 => Administrador
3 => Usuário
*/

switch ($_SERVER['PHP_SELF']) {
    case '/Views/pagina_gestor.php':
        $nivel_requerido = 1;
        break;
    case '/Views/pagina_admin.php':
        $nivel_requerido = 2;
        break;
    // default: 
    //nível padrão requerido é o de gestor
        // $nivel_requerido = 1;
}

if (isset($_SESSION['nivel_de_acesso']) && ($_SESSION['nivel_de_acesso'] != $nivel_requerido)) {
    header('Location: ../Views/acesso_restrito.php');
    exit();
}
