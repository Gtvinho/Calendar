
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['guest_login'])) {
        // Redirecionar para a página desejada para login como convidado
        header('Location: calendarioConvidado.php');
        exit();
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Verificar as credenciais
        if ($username === 'master' && $password === '123456') {
            // Iniciar a sessão
            session_start();
            
            // Armazenar o nome de usuário na sessão
            $_SESSION['username'] = $username;

            // Redirecionar para a página desejada para login regular
            header('Location: calendarioADM.php');
            exit();
        } else {
            // Credenciais incorretas
            $error_message = 'Nome de usuário ou senha inválidos.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="page">
        <form method="POST" class="formLogin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1>Login</h1>
            <p>Digite os seus dados de acesso no campo abaixo.</p>
            <label for="username">Usuário</label>
            <input type="text" name="username" placeholder="Usuário" autofocus required />
            <label for="password">Senha</label>
            <input type="password" name="password" placeholder="Senha" required />
            <input type="submit" value="Acessar" class="btn" />
            <input type="button" value="Convidado" class="btn" onclick="location.href='CalendarioDefinitivo.php'" />
        </form>
    </div>
</body>
</html>
</html>
