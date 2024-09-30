<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerador de Senhas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        label { display: block; margin: 10px 0 5px; }
        input[type="number"], input[type="submit"], button { margin-bottom: 10px; }
        h2 { color: green; }
        .error { color: red; }
        #senhaGerada { margin-top: 20px; }
        button { cursor: pointer; }
        button:hover { background-color: #f0f0f0; }
    </style>
    <script>
        function copiarSenha() {
            const senha = document.getElementById("senha").innerText;
            navigator.clipboard.writeText(senha).then(() => {
                alert("Senha copiada para a área de transferência!");
            });
        }

        function disableButton() {
            document.querySelector('input[type="submit"]').disabled = true;
        }
    </script>
</head>
<body>
    <h1>Gerador de Senhas</h1>
    <p>Escolha o comprimento e os tipos de caracteres que deseja incluir na senha.</p>
    
    <form method="post" onsubmit="disableButton()">
        <label for="comprimento">Comprimento (4-12):</label>
        <input type="number" name="comprimento" min="4" max="12" value="12" required>

        <fieldset>
            <legend>Incluir:</legend>
            <label>
                <input type="checkbox" name="usarMaiusculas">
                Maiúsculas
            </label>
            <label>
                <input type="checkbox" name="usarNumeros">
                Números
            </label>
            <label>
                <input type="checkbox" name="usarCaracteresEspeciais">
                Caracteres Especiais
            </label>
        </fieldset>

        <input type="submit" value="Gerar Senha">
    </form>

    <div id="senhaGerada" aria-live="polite">
        <?php
        function gerarSenha($comprimento, $usarMaiusculas, $usarNumeros, $usarCaracteresEspeciais) {
            $lowercase = 'abcdefghijklmnopqrstuvwxyz';
            $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $numbers = '0123456789';
            $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';

            $caracteres = $lowercase;

            if ($usarMaiusculas) {
                $caracteres .= $uppercase;
            }
            if ($usarNumeros) {
                $caracteres .= $numbers;
            }
            if ($usarCaracteresEspeciais) {
                $caracteres .= $specialChars;
            }

            if (empty($caracteres)) {
                throw new InvalidArgumentException('Pelo menos uma opção de caracteres deve ser selecionada.');
            }

            $senha = '';
            for ($i = 0; $i < $comprimento; $i++) {
                $senha .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }

            return $senha;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comprimento = intval($_POST['comprimento']);
            $usarMaiusculas = isset($_POST['usarMaiusculas']);
            $usarNumeros = isset($_POST['usarNumeros']);
            $usarCaracteresEspeciais = isset($_POST['usarCaracteresEspeciais']);

            try {
                $senhaGerada = gerarSenha($comprimento, $usarMaiusculas, $usarNumeros, $usarCaracteresEspeciais);
                echo "<h2>Senha gerada: <span id='senha'>" . htmlspecialchars($senhaGerada) . "</span></h2>";
                echo "<button onclick='copiarSenha()'>Copiar Senha</button>";
            } catch (InvalidArgumentException $e) {
                echo "<h2 class='error'>Erro: " . htmlspecialchars($e->getMessage()) . "</h2>";
            }
        }
        ?>
    </div>
</body>
</html>
