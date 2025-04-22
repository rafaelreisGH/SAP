<?php
require_once '../vendor/autoload.php'; // Autoload do Composer para carregar as dependências
require_once '../ConexaoDB/conexao.php'; // Certifique-se de que o caminho está certo
require_once '../Logger/LoggerFactory.php';

// Usa o método estático da classe para obter a conexão
$conn = Conexao::getConexao();

// Cria o logger com essa conexão
$logger = LoggerFactory::createLogger($conn);

// Teste de log
$usuarioId = 123;
$logger->info('Usuário acessou a dashboard', ['usuario_id' => $usuarioId]);

echo "Log inserido com sucesso.";
