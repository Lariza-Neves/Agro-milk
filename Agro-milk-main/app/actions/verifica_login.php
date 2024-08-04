<?php
include '../config/conecta.php';
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['ativa']) && $_SESSION['ativa'] === TRUE) {
    if ($_SESSION['tipo'] === 'admin') {
        header("Location: ../pages/gerencia.php");
    } else {
        header("Location: ../pages/tabela.php?id=" . $_SESSION['id']);
    }
    exit();
}

function login($connect) {
    if (isset($_POST['acessar']) && !empty($_POST['login']) && !empty($_POST['senha'])) {
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $senha = sha1($_POST['senha']); // Usando sha1 para compatibilidade com o método de inserção

        // Verificar login em administradores
        $queryAdm = $connect->prepare("SELECT * FROM administradores WHERE login = ? AND senha = ?");
        $queryAdm->bind_param("ss", $login, $senha);
        $queryAdm->execute();
        $resultAdm = $queryAdm->get_result();

        if ($resultAdm->num_rows > 0) {
            $returnAdm = $resultAdm->fetch_assoc();
            $_SESSION['login'] = $returnAdm['login'];
            $_SESSION['id'] = $returnAdm['id'];
            $_SESSION['tipo'] = 'admin';
            $_SESSION['ativa'] = TRUE;
            header("Location: ../pages/gerencia.php");
            exit();
        }

        // Verificar login em usuários
        $queryUser = $connect->prepare("SELECT * FROM usuarios WHERE login = ? AND senha = ?");
        $queryUser->bind_param("ss", $login, $senha);
        $queryUser->execute();
        $resultUser = $queryUser->get_result();

        if ($resultUser->num_rows > 0) {
            $returnUser = $resultUser->fetch_assoc();
            $_SESSION['login'] = $returnUser['login'];
            $_SESSION['id'] = $returnUser['id'];
            $_SESSION['tipo'] = 'user';
            $_SESSION['ativa'] = TRUE;
            header("Location: ../pages/tabela.php?id={$returnUser['id']}");
            exit();
        }

        // Se nenhum login foi bem-sucedido
        $_SESSION['msgLogin'] = "Login ou senha incorretos";
        header("Location: ../pages/login.php");
        exit();
    } else {
        // Se os campos de login ou senha estiverem vazios
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
