<?php
session_start();
require_once("../config/conecta.php");

function inserirUsuarios($connect) {
    if (isset($_POST['cadastrar']) && !empty($_POST['login']) && !empty($_POST['senha']) && !empty($_POST['confirmar_senha'])) {
        $erros = array();
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $senha = $_POST['senha'];
        $confirmar_senha = $_POST['confirmar_senha'];

        if ($senha != $confirmar_senha) {
            $erros[] = "Senhas diferentes!";
        }

        // Verificar se o login já existe na tabela de administradores
        $queryLoginAdm = "SELECT login FROM administradores WHERE login = ?";
        $stmtAdm = $connect->prepare($queryLoginAdm);
        $stmtAdm->bind_param("s", $login);
        $stmtAdm->execute();
        $stmtAdm->store_result();
        $verificaAdm = $stmtAdm->num_rows;

        // Verificar se o login já existe na tabela de usuários
        $queryLoginUser = "SELECT login FROM usuarios WHERE login = ?";
        $stmtUser = $connect->prepare($queryLoginUser);
        $stmtUser->bind_param("s", $login);
        $stmtUser->execute();
        $stmtUser->store_result();
        $verificaUser = $stmtUser->num_rows;

        if (!empty($verificaAdm) || !empty($verificaUser)) {
            $erros[] = "Esse login já está sendo usado";
        }

        if (empty($erros)) {
            $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
            $dataCadastro = date('Y-m-d H:i:s'); // Obtém a data atual
            $query = "INSERT INTO usuarios (login, senha, data_cadastro) VALUES (?, ?, ?)";
            $stmtInsert = $connect->prepare($query);
            $stmtInsert->bind_param("sss", $login, $hashSenha, $dataCadastro);
            $executar = $stmtInsert->execute();

            if ($executar) {
                $_SESSION['mensagem'] = "Usuário inserido com sucesso";
            } else {
                $_SESSION['mensagem'] = "Erro ao inserir usuário: " . $stmtInsert->error;
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
