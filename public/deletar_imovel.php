<?php
// public/deletar_imovel.php
session_start();

// Verifica se o corretor está logado
if (!isset($_SESSION['corretor_id'])) {
    header('Location: index.php');
    exit;
}

require '../config/config.php';

// Obtém o ID do imóvel a ser deletado
$imovel_id = $_GET['id'] ?? '';

if (empty($imovel_id) || !is_numeric($imovel_id)) {
    header('Location: listar_imoveis.php?erro=ID inválido.');
    exit;
}

$corretor_id = $_SESSION['corretor_id'];

try {
    // Busca os dados do imóvel para remover a imagem, se existir
    $sql = "SELECT imagem FROM imovel WHERE id = :id AND corretor_id = :corretor_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $imovel_id,
        ':corretor_id' => $corretor_id
    ]);
    $imovel = $stmt->fetch();

    if (!$imovel) {
        header('Location: listar_imoveis.php?erro=Imóvel não encontrado.');
        exit;
    }

    // Remove o registro do banco de dados
    $sql = "DELETE FROM imovel WHERE id = :id AND corretor_id = :corretor_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $imovel_id,
        ':corretor_id' => $corretor_id
    ]);

    // Remove a imagem do diretório, se existir
    if ($imovel['imagem'] && file_exists('../uploads/imagens_imoveis/' . $imovel['imagem'])) {
        unlink('../uploads/imagens_imoveis/' . $imovel['imagem']);
    }

    // Redireciona com mensagem de sucesso
    header('Location: listar_imoveis.php?sucesso=Imóvel excluído com sucesso!');
    exit;
} catch (PDOException $e) {
    // Em caso de erro na consulta
    header('Location: listar_imoveis.php?erro=Erro ao excluir o imóvel: ' . urlencode($e->getMessage()));
    exit;
}
