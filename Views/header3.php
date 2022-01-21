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
    <!-- bootstrap - link cdn -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <!--<link rel="stylesheet" href="../css/bootstrap.css">-->
    <link rel="icon" href="../imagens/Vetor CBMMT.png">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-light">
            <div class="container">
                <img src="../imagens/Vetor CBMMT.png" style="width: 45px; padding: 5px 0 5px 0;" />
                <!--/.nav-collapse -->
            </div>
        </nav>

        <div class="clearfix"></div>
    </div>