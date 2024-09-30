<?php
include 'conexao.php'; // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gerar o hash da senha
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Inserir o novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (username, senha) VALUES (:username, :senha)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute(['username' => $username, 'senha' => $hashedPassword]);
        
        // Se o cadastro foi bem-sucedido
        $cadastro_sucesso = true;
        
    } catch (PDOException $e) {
        // Em caso de erro, exibe uma mensagem
        echo "Erro ao registrar usuário: " . $e->getMessage();
        $cadastro_sucesso = false;
    }

    // Lógica de redirecionamento
    if ($cadastro_sucesso) {
        // Redireciona para a página de login após o cadastro bem-sucedido
        header('Location: login.php');
        exit(); // Para o script após o redirecionamento
    }
}
?>

<!-- Formulário de Registro -->
<form action="registro.php" method="POST">
    Nome de Usuário: <input type="text" name="username" required><br>
    Senha: <input type="password" name="password" required><br>
    <button type="submit">Registrar</button>
</form>
