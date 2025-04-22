<?php
// Logger/LoggerFactory.php

use Monolog\Logger;

require_once 'DBHandler.php';
require_once '../ConexaoDB/conexao.php'; // ou ajuste conforme seu projeto

class LoggerFactory
{
    public static function createLogger(): Logger
    {
        $logger = new Logger('app');
        $pdo = Conexao::getConexao(); // Usa sua classe de conexão
        $logger->pushHandler(new DBHandler($pdo));

        return $logger;
    }
}
