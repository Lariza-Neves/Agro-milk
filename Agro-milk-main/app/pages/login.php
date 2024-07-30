<?php require_once ("../config/conecta.php");
    if(isset($_POST['acessar']))
    {
        login($connect);
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2d3246;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #3b4252;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-container h2 {
            color: #ffffff;
            margin-bottom: 20px;
            border-bottom: 1px solid #ffffff;
            padding-bottom: 10px;
        }
        .login-container label {
            color: #ffffff;
            display: block;
            margin-bottom: 5px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-bottom: 1px solid #ffffff;
            background: none;
            color: #ffffff;
            font-size: 16px;
        }
        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #bf616a;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background-color: #d08770;
        }
        .login-container a {
            color: #ffffff;
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="../actions/verifica_login.php" method="post">
            <label for="username">Usuário</label>
            <input type="text" id="login_adm" name="login_adm">
            
            <label for="password">Senha</label>
            <input type="password" id="senha_adm" name="senha_adm" required>
            
            <input type="submit" name= "acessar" value="Acessar" required>
        </form>
        <a href="#">Esqueceu a senha?</a>
    </div>
</body>
</html>
