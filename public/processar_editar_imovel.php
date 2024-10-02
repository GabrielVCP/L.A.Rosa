<?php
// public/processar_editar_imovel.php
session_start();

// Verifica se o corretor está logado
if (!isset($_SESSION['corretor_id'])) {
    header('Location: index.php');
    exit;
}

require '../config/config.php';

// Recebe os dados do formulário
$imovel_id = $_POST['id'] ?? '';
$tipo = trim($_POST['tipo'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$estado = strtoupper(trim($_POST['estado'] ?? ''));
$valor = trim($_POST['valor'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$corretor_id = $_SESSION['corretor_id'];
$imagem = '';
$imagem_antiga = '';

$erros = [];

// Validações básicas
if (empty($imovel_id) || !is_numeric($imovel_id)) {
    $erros[] = "ID do imóvel inválido.";
}

if (empty($tipo)) {
    $erros[] = "Tipo é obrigatório.";
}

if (empty($endereco)) {
    $erros[] = "Endereço é obrigatório.";
}

if (empty($cidade)) {
    $erros[] = "Cidade é obrigatória.";
}

if (empty($estado) || strlen($estado) != 2) {
    $erros[] = "Estado é obrigatório e deve ter 2 letras (sigla).";
}

if (empty($valor) || !is_numeric($valor)) {
    $erros[] = "Valor é obrigatório e deve ser numérico.";
}

// Busca os dados atuais do imóvel
try {
    $sql = "SELECT * FROM imovel WHERE id = :id AND corretor_id = :corretor_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $imovel_id,
        ':corretor_id' => $corretor_id
    ]);
    $imovel_atual = $stmt->fetch();

    if (!$imovel_atual) {
        $erros[] = "Imóvel não encontrado.";
    } else {
        $imagem_antiga = $imovel_atual['imagem'];
    }
} catch (PDOException $e) {
    die('Erro ao buscar o imóvel: ' . $e->getMessage());
}

// Processa o upload da nova imagem, se houver
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $file_name = $_FILES['imagem']['name'];
    $file_tmp = $_FILES['imagem']['tmp_name'];
    $file_size = $_FILES['imagem']['size'];

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed)) {
        $erros[] = "Extensão de imagem não permitida. Apenas JPG, JPEG, PNG e GIF são aceitos.";
    }

    if ($file_size > 2 * 1024 * 1024) { // 2MB
        $erros[] = "O tamanho da imagem deve ser no máximo 2MB.";
    }

    if (empty($erros)) {
        // Gera um nome único para a imagem
        $imagem = uniqid() . '.' . $file_ext;
        $destino = '../uploads/imagens_imoveis/' . $imagem;

        // Move a imagem para o diretório de destino
        if (!move_uploaded_file($file_tmp, $destino)) {
            $erros[] = "Falha ao enviar a imagem.";
        } else {
            // Remove a imagem antiga, se existir
            if ($imagem_antiga && file_exists('../uploads/imagens_imoveis/' . $imagem_antiga)) {
                unlink('../uploads/imagens_imoveis/' . $imagem_antiga);
            }
        }
    }
} else {
    // Mantém a imagem antiga se não for enviada uma nova
    $imagem = $imagem_antiga;
}

if (empty($erros)) {
    try {
        // Prepara a consulta SQL com parâmetros preparados
        $sql = "UPDATE imovel SET 
                    tipo = :tipo,
                    endereco = :endereco,
                    cidade = :cidade,
                    estado = :estado,
                    valor = :valor,
                    descricao = :descricao,
                    imagem = :imagem,
                    atualizado_em = NOW()
                WHERE id = :id AND corretor_id = :corretor_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':tipo' => $tipo,
            ':endereco' => $endereco,
            ':cidade' => $cidade,
            ':estado' => $estado,
            ':valor' => $valor,
            ':descricao' => $descricao,
            ':imagem' => $imagem,
            ':id' => $imovel_id,
            ':corretor_id' => $corretor_id
        ]);

        // Redireciona com mensagem de sucesso
        header('Location: listar_imoveis.php?sucesso=Imóvel atualizado com sucesso!');
        exit;
    } catch (PDOException $e) {
        // Em caso de erro na consulta
        header('Location: editar_imovel.php?id=' . urlencode($imovel_id) . '&erro=Erro ao atualizar o imóvel: ' . urlencode($e->getMessage()));
        exit;
    }
} else {
    // Redireciona com mensagens de erro
    $mensagens = implode(' ', $erros);
    header('Location: editar_imovel.php?id=' . urlencode($imovel_id) . '&erro=' . urlencode($mensagens));
    exit;
}
