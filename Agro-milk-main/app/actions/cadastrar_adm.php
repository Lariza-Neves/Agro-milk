<?php 
require_once("../config/conecta.php");

function cadastrarAdmin($connect, $login, $senha) {
    // Sanitizar e validar o login
    $login = filter_var($login, FILTER_SANITIZE_STRING);

    // Encriptar a senha
    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

    // Verificar se o login já existe usando Prepared Statements
    $queryCheck = $connect->prepare("SELECT * FROM administradores WHERE login = ?");
    $queryCheck->bind_param("s", $login);
    $queryCheck->execute();
    $resultCheck = $queryCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        echo "O login já existe.";
    } else {
        // Inserir novo administrador usando Prepared Statements
        $queryInsert = $connect->prepare("INSERT INTO administradores (login, senha) VALUES (?, ?)");
        $queryInsert->bind_param("ss", $login, $senhaHash);
        
        if ($queryInsert->execute()) {
            echo "Administrador cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar administrador: " . $connect->error;
        }
    }

    // Fechar as consultas preparadas
    $queryCheck->close();
    $queryInsert->close();
}

$login = "lariz";
$senha = "ailula";

cadastrarAdmin($connect, $login, $senha);

// Fechar a conexão com o banco de dados
$connect->close();
?>
