<?php
class Conexao {
    private static $conn;

    public static function getConexao() {
        if (!self::$conn) {
            $servername = "localhost";
            $myDB = "promocao";
            $username = "root";
            $password = "root";

            try {
                self::$conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8mb4", $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                error_log("Connection failed: " . $e->getMessage(), 3, "errors.log");
                die("Erro ao conectar ao banco de dados.");
            }
        }

        return self::$conn;
    }
}
