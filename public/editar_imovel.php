<?php
// public/editar_imovel.php
session_start();

// Verifica se o corretor está logado
if (!isset($_SESSION['corretor_id'])) {
    header('Location: index.php');
    exit;
}

require '../config/config.php';

// Obtém o ID do imóvel a ser editado
$imovel_id = $_GET['id'] ?? '';

if (empty($imovel_id) || !is_numeric($imovel_id)) {
    header('Location: listar_imoveis.php?erro=ID inválido.');
    exit;
}

// Busca os dados do imóvel
try {
    $sql = "SELECT * FROM imovel WHERE id = :id AND corretor_id = :corretor_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $imovel_id,
        ':corretor_id' => $_SESSION['corretor_id']
    ]);
    $imovel = $stmt->fetch();

    if (!$imovel) {
        header('Location: listar_imoveis.php?erro=Imóvel não encontrado.');
        exit;
    }
} catch (PDOException $e) {
    die('Erro ao buscar o imóvel: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Imóvel</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Editar Imóvel</h2>
        <form action="processar_editar_imovel.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($imovel['id']); ?>">

            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" required>
                <option value="">Selecione</option>
                <option value="Casa" <?php if ($imovel['tipo'] == 'Casa') echo 'selected'; ?>>Casa</option>
                <option value="Apartamento" <?php if ($imovel['tipo'] == 'Apartamento') echo 'selected'; ?>>Apartamento</option>
                <option value="Terreno" <?php if ($imovel['tipo'] == 'Terreno') echo 'selected'; ?>>Terreno</option>
                <!-- Adicione mais tipos conforme necessário -->
            </select>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" value="<?php echo htmlspecialchars($imovel['endereco']); ?>" required>

            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" id="cidade" value="<?php echo htmlspecialchars($imovel['cidade']); ?>" required>

            <label for="estado">Estado (Sigla):</label>
            <input type="text" name="estado" id="estado" maxlength="2" value="<?php echo htmlspecialchars($imovel['estado']); ?>" required>

            <label for="valor">Valor:</label>
            <input type="number" name="valor" id="valor" step="0.01" value="<?php echo htmlspecialchars($imovel['valor']); ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" rows="4"><?php echo htmlspecialchars($imovel['descricao']); ?></textarea>

            <label for="imagem">Imagem do Imóvel:</label>
            <?php if ($imovel['imagem']): ?>
                <div>
                    <img src="../uploads/imagens_imoveis/<?php echo htmlspecialchars($imovel['imagem']); ?>" alt="Imagem do Imóvel" width="150"><br>
                    <span>Deixe vazio para manter a imagem atual.</span>
                </div>
            <?php else: ?>
                <span>Sem Imagem</span>
            <?php endif; ?>
            <input type="file" name="imagem" id="imagem" accept="image/*">

            <button type="submit">Atualizar Imóvel</button>
        </form>

        <p><a href="listar_imoveis.php">Voltar à Lista de Imóveis</a></p>

        <!-- Exibe mensagem de erro, se houver -->
        <?php
        if (isset($_GET['erro'])) {
            echo '<p class="error">' . htmlspecialchars($_GET['erro']) . '</p>';
        }
        ?>
    </div>
</body>
</html>
