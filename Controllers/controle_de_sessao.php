<?php
session_start();

//tempo limite de sessão
if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 900)) { //900 => 15 minutos
    
    // Log do logout por inatividade
    require_once __DIR__ . '/../Logger/LoggerFactory.php';
    $logger = LoggerFactory::createLogger();
    $logger->info('Deslogado por inatividade', [
        'id' => $_SESSION['id'],
        'usuario' => $_SESSION['nome'],
        'email' => $_SESSION['email'],
        'perfil' => $_SESSION['nivel_de_acesso']
    ]);

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