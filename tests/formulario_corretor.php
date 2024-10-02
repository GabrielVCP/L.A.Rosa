<!-- index.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema de Corretores</title>
    <link rel="stylesheet" href="..assets/style.css"> <!-- Importa o CSS -->
</head>
<body>
    <div class="container">
        <h2>Cadastro do Corretor</h2>
        
        <!-- Formulário de login -->
        <form action="cadastro_corretor.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="nome" name="nome" id="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <label for="nivel">nivel:</label>
            <select name="nivel" id="nivel">
                <option value="corretor">Corretor</option>
                <option value="admin">Administrador</option>
            </select>

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