<?php
// public/listar_imoveis.php
session_start();

// Verifica se o corretor está logado
if (!isset($_SESSION['corretor_id'])) {
    header('Location: index.php');
    exit;
}

require '../config/config.php';

// Busca todos os imóveis cadastrados pelo corretor
$corretor_id = $_SESSION['corretor_id'];

try {
    $sql = "SELECT * FROM imovel WHERE corretor_id = :corretor_id ORDER BY criado_em DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':corretor_id' => $corretor_id]);
    $imoveis = $stmt->fetchAll();
} catch (PDOException $e) {
    die('Erro ao listar imóveis: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar Imóveis</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        /* Estilização adicional para a tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .actions a {
            margin-right: 10px;
            color: #3498db;
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Imóveis</h2>
        <p><a href="menu.php">Voltar ao Menu</a></p>
        <p><a href="cadastrar_imovel.php">Cadastrar Novo Imóvel</a></p>

        <?php if (count($imoveis) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Endereço</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>Valor</th>
                        <th>Descrição</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($imoveis as $imovel): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($imovel['id']); ?></td>
                            <td><?php echo htmlspecialchars($imovel['tipo']); ?></td>
                            <td><?php echo htmlspecialchars($imovel['endereco']); ?></td>
                            <td><?php echo htmlspecialchars($imovel['cidade']); ?></td>
                            <td><?php echo htmlspecialchars($imovel['estado']); ?></td>
                            <td><?php echo 'R$ ' . number_format($imovel['valor'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($imovel['descricao']); ?></td>
                            <td>
                                <?php if ($imovel['imagem']): ?>
                                    <img src="../uploads/imagens_imoveis/<?php echo htmlspecialchars($imovel['imagem']); ?>" alt="Imagem do Imóvel" width="100">
                                <?php else: ?>
                                    Sem Imagem
                                <?php endif; ?>
                            </td>
                            <td class="actions">
                                <a href="editar_imovel.php?id=<?php echo $imovel['id']; ?>">Editar</a>
                                <a href="deletar_imovel.php?id=<?php echo $imovel['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este imóvel?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum imóvel cadastrado ainda.</p>
        <?php endif; ?>
    </div>
</body>
</html>
