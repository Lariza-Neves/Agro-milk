<?php
include '../config/conecta.php';
session_start();

function login($connect) {
    if (isset($_POST['acessar']) && !empty($_POST['login']) && !empty($_POST['senha'])) {
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $senha = sha1($_POST['senha']);
        $queryAdm = "SELECT * FROM administradores WHERE login = '$login' AND senha = '$senha'";
        $queryUser = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'";

        // Executar consultas e verificar erros
        $executarAdm = mysqli_query($connect, $queryAdm);
        if (!$executarAdm) {
            die('Erro na consulta para administradores: ' . mysqli_error($connect));
        }
        $executarUser = mysqli_query($connect, $queryUser);
        if (!$executarUser) {
            die('Erro na consulta para usuários: ' . mysqli_error($connect));
        }

        $returnAdm = mysqli_fetch_assoc($executarAdm);
        $returnUser = mysqli_fetch_assoc($executarUser);

        if (!empty($returnAdm['login'])) {
            $_SESSION['login'] = $returnAdm['login'];
            $_SESSION['id'] = $returnAdm['id'];
            $_SESSION['tipo'] = 'admin';
            $_SESSION['ativa'] = TRUE;
            header("Location: ../pages/tabela.php"); // Redirecionar para o painel do admin
        } elseif (!empty($returnUser['login'])) {
            $_SESSION['login'] = $returnUser['login'];
            $_SESSION['id'] = $returnUser['id'];
            $_SESSION['tipo'] = 'user';
            $_SESSION['ativa'] = TRUE;
            header("Location: ../pages/tabela.php"); // Redirecionar para o painel do usuário
        } else {
            $_SESSION['erro_login'] = "Login ou senha incorretos";
            header("Location: ../pages/login.php"); // Redirecionar de volta para o formulário de login
        }
    }
}

if (isset($_POST['acessar'])) {
    login($connect);
}
?>
