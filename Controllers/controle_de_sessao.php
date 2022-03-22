<?php
session_start();
//tempo limite de sessão
if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 900)) {//900 => 15 minutos
    session_unset(); 
    session_destroy(); 
    header('Location: ../index.php?erro=2');
    exit();
}
$_SESSION['start'] = time();
//verifica se o usuário fez o login
//se não fez, é redirecionado para a página index.php
if (!isset($_SESSION['logado'])) {
    header('Location: ../index.php?erro=2');
    exit();
}