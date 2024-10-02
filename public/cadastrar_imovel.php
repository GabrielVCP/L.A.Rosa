<!-- public/cadastrar_imovel.php -->
<?php
session_start();

// Verifica se o corretor está logado
if (!isset($_SESSION['corretor_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Imóvel</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Cadastrar Novo Imóvel</h2>
        <form action="processar_cadastro_imovel.php" method="POST" enctype="multipart/form-data">
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" required>
                <option value="">Selecione</option>
                <option value="Casa">Casa</option>
                <option value="Apartamento">Apartamento</option>
                <option value="Terreno">Terreno</option>
                <!-- Adicione mais tipos conforme necessário -->
            </select>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" required>

            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" id="cidade" required>

            <label for="estado">Estado (Sigla):</label>
            <input type="text" name="estado" id="estado" maxlength="2" required>

            <label for="valor">Valor:</label>
            <input type="number" name="valor" id="valor" step="0.01" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" rows="4"></textarea>

            <label for="imagem">Imagem do Imóvel:</label>
            <input type="file" name="imagem" id="imagem" accept="image/*">

            <button type="submit">Cadastrar Imóvel</button>
        </form>

        <p><a href="menu.php">Voltar ao Menu</a></p>

        <!-- Exibe mensagem de sucesso ou erro, se houver -->
        <?php
        if (isset($_GET['sucesso'])) {
            echo '<p class="error" style="color: green;">' . htmlspecialchars($_GET['sucesso']) . '</p>';
        }
        if (isset($_GET['erro'])) {
            echo '<p class="error">' . htmlspecialchars($_GET['erro']) . '</p>';
        }
        ?>
    </div>
</body>
</html>
