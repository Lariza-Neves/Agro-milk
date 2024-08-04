<?php
include '../config/conecta.php';
session_start();

function login($connect) {
    if (isset($_POST['acessar']) && !empty($_POST['login']) && !empty($_POST['senha'])) {
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $senha = $_POST['senha'];

        // Verificar login em administradores
        $queryAdm = $connect->prepare("SELECT * FROM administradores WHERE login = ?");
        $queryAdm->bind_param("s", $login);
        $queryAdm->execute();
        $resultAdm = $queryAdm->get_result();
        
        if ($resultAdm->num_rows > 0) {
            $returnAdm = $resultAdm->fetch_assoc();
            if (password_verify($senha, $returnAdm['senha'])) {
                $_SESSION['login'] = $returnAdm['login'];
                $_SESSION['id'] = $returnAdm['id'];
                $_SESSION['tipo'] = 'admin';
                $_SESSION['ativa'] = TRUE;
                header("Location: ../pages/gerencia.php");
                exit();
            }
        }

        // Verificar login em usuários
        $queryUser = $connect->prepare("SELECT * FROM usuarios WHERE login = ?");
        $queryUser->bind_param("s", $login);
        $queryUser->execute();
        $resultUser = $queryUser->get_result();

        if ($resultUser->num_rows > 0) {
            $returnUser = $resultUser->fetch_assoc();
            if (password_verify($senha, $returnUser['senha'])) {
                $_SESSION['login'] = $returnUser['login'];
                $_SESSION['id'] = $returnUser['id'];
                $_SESSION['tipo'] = 'user';
                $_SESSION['ativa'] = TRUE;
                header("Location: ../pages/tabela.php?id={$returnUser['id']}");
                exit();
            }
        }

        $_SESSION['msgLogin'] = "Login ou senha incorretos";
        header("Location: ../pages/login.php");
        exit();
    } else {
        $_SESSION['msgLogin'] = "Preencha todos os campos";
        header("Location: ../pages/login.php");
        exit();
    }
}

if (isset($_POST['acessar'])) {
    login($connect);
}

// Fechar a conexão com o banco de dados
$connect->close();
?>
