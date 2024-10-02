<!-- index.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Corretores</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Importa o CSS -->
</head>
<body>
    <div class="container">
        <h2>Login do Corretor</h2>
        
        <!-- Formulário de login -->
        <form action="verificar_login.php" method="POST">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <button type="submit">Entrar</button>
        </form>

        <!-- Exibe mensagem de erro, se houver -->
        <?php
        if (isset($_GET['erro'])) {
            echo '<p class="error">' . htmlspecialchars($_GET['erro']) . '</p>';
        }
        ?>
    </div>
</body>
</html>