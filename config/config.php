<?php
// config.php

// Dados de conexão ao banco de dados
$host = 'localhost';        // Servidor
$db   = 'larosa';  // Nome do banco de dados
$user = 'root';             // Usuário do banco de dados
$pass = '';   // Senha do banco de dados
$charset = 'utf8mb4';       // Charset recomendado para evitar problemas com acentuação

// Definindo o DSN (Data Source Name) para conexão com o banco MySQL
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Configurações adicionais de PDO para boas práticas
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Exibe erros como exceções
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna resultados como arrays associativos
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desabilita emulação de prepares (melhora a segurança)
];

try {
    // Criando a conexão PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Se a conexão for bem-sucedida, o código continua normalmente
} catch (PDOException $e) {
    // Em caso de erro, exibe a mensagem e finaliza o script
    die('Erro de conexão: ' . $e->getMessage());
}
?>