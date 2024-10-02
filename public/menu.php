<?php
// menu.php
session_start();

// Verifica se o corretor está logado
if (!isset($_SESSION['corretor_id'])) {
    header('Location: index.php');
    exit;
}

// Exibe o nome do corretor
$nomeCorretor = $_SESSION['corretor_nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu do Corretor</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Importa o CSS -->
</head>
<body>
    <div class="container">
        <h2>Bem-vindo, <?php echo htmlspecialchars($nomeCorretor); ?>!</h2>

        <p>Escolha uma opção:</p>
        <ul>
            <li><a href="cadastrar_imovel.php">Cadastrar Imóvel</a></li>
            <li><a href="cadastrar_cliente.php">Cadastrar Cliente</a></li>
            <li><a href="listar_imoveis.php">Listar Imóveis</a></li>
            <li><a href="listar_clientes.php">Listar Clientes</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </div>
</body>
</html>