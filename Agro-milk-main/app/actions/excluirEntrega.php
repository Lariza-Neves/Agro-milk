<?php
require_once("../config/conecta.php");
require_once("verifica_usuario.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $usuario_id = intval($_POST['usuario_id']); // Capturar o usuário_id do formulário

    if ($id > 0) {
        $queryDeleta = "DELETE FROM entregas WHERE id = $id";
        if (mysqli_query($connect, $queryDeleta)) {
            $_SESSION['mensagem'] = "Entrega excluída com sucesso.";
        } else {
            $_SESSION['mensagem'] = "Erro ao excluir entrega.";
        }
    } else {
        $_SESSION['mensagem'] = "ID de entrega inválido.";
    }
} else {
    $_SESSION['mensagem'] = "Método de requisição inválido.";
}

// Redirecionar de volta para a página de tabelas
header("Location: ../pages/tabela.php?id=$usuario_id");
exit();
?>
