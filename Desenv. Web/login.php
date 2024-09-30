<?php
session_start(); // Inicia a sessão

include 'conexao.php'; // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica se o usuário existe no banco de dados
    $sql = "SELECT * FROM usuarios WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Busca o usuário no banco

    if ($user && password_verify($password, $user['senha'])) {
        // Se a senha estiver correta, inicia a sessão do usuário
        $_SESSION['username'] = $user['username']; // Armazena o nome de usuário na sessão
        header('Location: index.php'); // Redireciona para a página index.php
        exit(); // Encerra o script após o redirecionamento
    } else {
        echo "Nome de usuário ou senha inválidos.";
    }
}
?>

<!-- Formulário de Login -->
<form action="login.php" method="POST">
    Nome de Usuário: <input type="text" name="username" required><br>
    Senha: <input type="password" name="password" required><br>
    <button type="submit">Entrar</button>
</form>
