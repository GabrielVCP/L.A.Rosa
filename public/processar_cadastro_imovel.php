<?php
// public/processar_cadastro_imovel.php
session_start();

// Verifica se o corretor está logado
if (!isset($_SESSION['corretor_id'])) {
    header('Location: index.php');
    exit;
}

require '../config/config.php';

// Recebendo e validando os dados do formulário
$tipo = trim($_POST['tipo'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$estado = strtoupper(trim($_POST['estado'] ?? ''));
$valor = trim($_POST['valor'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$corretor_id = $_SESSION['corretor_id'];
$imagem = '';

$erros = [];

// Validações básicas
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

// Processa o upload da imagem, se houver
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
        }
    }
}

if (empty($erros)) {
    try {
        // Prepara a consulta SQL com parâmetros preparados
        $sql = "INSERT INTO imovel (corretor_id, tipo, endereco, cidade, estado, valor, descricao, imagem) 
                VALUES (:corretor_id, :tipo, :endereco, :cidade, :estado, :valor, :descricao, :imagem)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':corretor_id' => $corretor_id,
            ':tipo' => $tipo,
            ':endereco' => $endereco,
            ':cidade' => $cidade,
            ':estado' => $estado,
            ':valor' => $valor,
            ':descricao' => $descricao,
            ':imagem' => $imagem
        ]);

        // Redireciona com mensagem de sucesso
        header('Location: cadastrar_imovel.php?sucesso=Imóvel cadastrado com sucesso!');
        exit;
    } catch (PDOException $e) {
        // Em caso de erro na consulta
        header('Location: cadastrar_imovel.php?erro=Erro ao cadastrar o imóvel: ' . urlencode($e->getMessage()));
        exit;
    }
} else {
    // Redireciona com mensagens de erro
    $mensagens = implode(' ', $erros);
    header('Location: cadastrar_imovel.php?erro=' . urlencode($mensagens));
    exit;
}
