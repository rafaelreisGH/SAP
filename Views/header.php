<?php
session_start();
//verifica se o usuário fez o login
//se não fez, é redirecionado para a página index.php
if (!isset($_SESSION['email'])) {
    header('Location: ../index.php?erro=1');
}
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>SAP - CBMMT</title>		
        <!-- jquery - link cdn -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <!-- bootstrap - link cdn -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="../css/bootstrap.css">-->
        <link rel="icon" href="../imagens/Vetor CBMMT.png">

        

    </head>
    <body>
        <!-- Static navbar -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img src="../imagens/Vetor CBMMT.png" style="width: 45px; padding: 5px 0 5px 0;"/>
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../sair.php">Sair</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

