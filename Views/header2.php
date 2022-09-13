<?php
include_once '../Controllers/controle_de_sessao.php';
include_once '../Controllers/verifica_permissoes.php'; //verifica o perfil do usuário, e bloqueia página que não pode acessar
?>

<!DOCTYPE HTML>
<html lang="pt-br">

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>SAP - CBMMT</title>
    <!-- bootstrap - link cdn -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">  
    <!--<link rel="stylesheet" href="../css/bootstrap.css">-->
    <link rel="icon" href="../imagens/Vetor CBMMT.png">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-light">
            <div class="container">
                <img src="../imagens/Vetor CBMMT.png" style="width: 45px; padding: 5px 0 5px 0;" />
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../sair.php">Sair</a></li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>

        <?php
        $pagina;
        if (isset($nivel)) {
            switch ($nivel) {
                case 1:
                    $pagina = 'pagina_gestor.php';
                    break;
                case 2:
                    $pagina = 'pagina_admin.php';
                    break;
                case 3:
                    $pagina = 'pagina_usuario.php';
                    break;
            }
        }
        ?>

        <div class="col-md-12">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link " aria-current="page" href="<?= $pagina ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../sair.php">Sair</a></li>
            </ul>
            <hr>
        </div>
        <div class="clearfix"></div>
    </div>