<?php
$host = 'localhost'; // Endereço do servidor MySQL
$db = 'usuarios_sistema'; // Nome do banco de dados
$user = 'root'; // Usuário do MySQL (geralmente 'root')
$pass = 'root'; // Senha do MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>
