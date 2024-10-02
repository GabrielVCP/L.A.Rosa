<?php
// verificar_login.php
session_start(); // Inicia a sessão
require '../config/config.php'; // Inclui a conexão com o banco de dados

// Recebe os dados enviados pelo formulário
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($email && $senha) {
    // Prepara a consulta SQL para buscar o corretor pelo e-mail
    $sql = "SELECT * FROM corretor WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);

    // Verifica se o corretor foi encontrado
    $corretor = $stmt->fetch();

    if ($corretor && password_verify($senha, $corretor['senha'])) {
        // Se a senha estiver correta, salva os dados na sessão
        $_SESSION['corretor_id'] = $corretor['id'];  // Armazena o ID do corretor na sessão
        $_SESSION['corretor_nome'] = $corretor['nome'];  // Armazena o nome do corretor
        $_SESSION['corretor_nivel'] = $corretor['nivel']; // Armazena o nível do corretor

        // Verifica o nível de acesso do corretor
        if ($corretor['nivel'] === 'admin') {
            // Redireciona para a página de administração se for admin
            header('Location: menu_admin.php');
        } else {
            // Redireciona para a página de corretor se for um corretor normal
            header('Location: menu.php');
        }
        exit;
    } else {
        // Se o login falhar, redireciona de volta para a página de login com mensagem de erro
        header('Location: index.php?erro=Login ou senha incorretos!');
        exit;
    }
} else {
    // Se o e-mail ou senha não forem preenchidos, redireciona com erro
    header('Location: index.php?erro=Preencha todos os campos!');
    exit;
}
?>