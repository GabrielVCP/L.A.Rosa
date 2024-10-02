<?php
// cadastro_corretor.php
require '../config/config.php'; // Inclui a conexão com o banco de dados

// Recebendo dados do formulário (com validação básica)
$nome = $_POST['nome'] ?? ''; // Verifica se o campo foi enviado
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$nivel = $_POST['nivel'] ?? '';
$telefone = $_POST['telefone'] ?? '';

if ($nome && $email && $senha) {
    // Hash seguro da senha (utiliza o algoritmo padrão do PHP)
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Usando parâmetros preparados para inserir os dados de forma segura
    $sql = "INSERT INTO corretor (nome, email, senha, nivel, telefone) VALUES (:nome, :email, :senha, :nivel, :telefone)";
    $stmt = $pdo->prepare($sql);

    // Executando a query com os valores fornecidos
    $stmt->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':senha' => $senhaHash,
        ':nivel' => $nivel,
        ':telefone' => $telefone
    ]);

    echo "Corretor cadastrado com sucesso!";
} else {
    echo "Preencha todos os campos obrigatórios!";
}