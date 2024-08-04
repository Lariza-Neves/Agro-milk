<?php
session_start();
require_once("../config/conecta.php");

function inserirUsuarios($connect) {
    if (isset($_POST['cadastrar']) && !empty($_POST['login']) && !empty($_POST['senha']) && !empty($_POST['confirmar_senha'])) {
        $erros = array();
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $senha = sha1($_POST['senha']);
        $confirmar_senha = sha1($_POST['confirmar_senha']);

        if ($senha != $confirmar_senha) {
            $erros[] = "Senhas diferentes!";
        }

        // Verificar se o login já existe na tabela de administradores
        $queryLoginAdm = "SELECT login FROM administradores WHERE login = '$login'";
        $buscaLoginAdm = mysqli_query($connect, $queryLoginAdm);
        $verificaAdm = mysqli_num_rows($buscaLoginAdm);

        // Verificar se o login já existe na tabela de usuários
        $queryLoginUser = "SELECT login FROM usuarios WHERE login = '$login'";
        $buscaLoginUser = mysqli_query($connect, $queryLoginUser);
        $verificaUser = mysqli_num_rows($buscaLoginUser);

        if (!empty($verificaAdm) || !empty($verificaUser)) {
            $erros[] = "Esse login já está sendo usado";
        }

        if (empty($erros)) {
            $dataCadastro = date('Y-m-d H:i:s'); // Obtém a data atual
            $query = "INSERT INTO usuarios (login, senha, data_cadastro) VALUES ('$login', '$senha', '$dataCadastro')";
            $executar = mysqli_query($connect, $query);

            if ($executar) {
                $_SESSION['mensagem'] = "Usuário inserido com sucesso";
            } else {
                $_SESSION['mensagem'] = "Erro ao inserir usuário: " . mysqli_error($connect);
            }
        } else {
            $_SESSION['mensagem'] = implode('<br>', $erros);
        }
    } else {
        $_SESSION['mensagem'] = "Preencha todos os campos.";
    }
    header("Location: ../pages/gerencia.php"); // Redireciona de volta para o formulário
    exit();
}

// Chamar a função para inserir o usuário
inserirUsuarios($connect);
?>
