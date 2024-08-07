<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="2138227.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../public/css/login__logasso.css">
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['ativa']) && $_SESSION['ativa'] === TRUE) {
        if ($_SESSION['tipo'] === 'admin') {
            header("Location: ../pages/gerencia.php");
        } elseif ($_SESSION['tipo'] === 'user') {
            header("Location: ../pages/tabela.php?id=" . $_SESSION['id']);
        }
        exit();
    }
    ?>

    <div class="main-login">
        <div class="left-login">
            <img src="../public/img/mlogo.png" class="left-login-img" alt="...">
        </div>
        <div class="right-login">
            <div class="card-login">
                <h1>LOGIN</h1>
                <?php

                if (isset($_SESSION['msgLogin'])) {
                    echo "<p style='color:red;'>" . $_SESSION['msgLogin'] . "</p>";
                    unset($_SESSION['msgLogin']);
                }
                ?>
                <form action="../actions/verifica_login.php" method="post">
                    <div class="textfield">
                        <label for="login">Usuário: </label>
                        <input type="text" name="login" placeholder="usuário" required>
                    </div>
                    <div class="textfield">
                        <label for="senha">Senha: </label>
                        <input type="password" name="senha" placeholder="senha" required>
                    </div>
                    <button type="submit" name="acessar" class="btn-login">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>