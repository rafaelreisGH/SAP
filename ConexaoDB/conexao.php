<?php

$servername = "localhost";
$myDB = "promocao";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8mb4", $username, $password);
    // Configurando o modo de erro para exceção
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo "Connected successfully"; // Pode ser removido para produção
} catch (PDOException $e) {
    // Registra o erro em um arquivo de log em vez de exibir na tela
    error_log("Connection failed: " . $e->getMessage(), 3, "errors.log");
    
    // Opcional: Exibir uma mensagem genérica para o usuário
    die("Erro ao conectar ao banco de dados.");
}
?>