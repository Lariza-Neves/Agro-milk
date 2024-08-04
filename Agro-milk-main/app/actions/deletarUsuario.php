<?php
session_start();
require_once("../config/conecta.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Verifica se o ID é válido
    if ($id > 0) {
        // Deleta entradas na tabela `entregas` associadas ao usuário
        $queryEntregas = "DELETE FROM entregas WHERE usuario_id = $id";
        $executarEntregas = mysqli_query($connect, $queryEntregas);

        if ($executarEntregas) {
            // Agora deleta o usuário na tabela `usuarios`
            $queryUsuario = "DELETE FROM usuarios WHERE id = $id";
            $executarUsuario = mysqli_query($connect, $queryUsuario);

            if ($executarUsuario) {
                $_SESSION['mensagem'] = "Usuário e suas entregas foram excluídos com sucesso.";
            } else {
                $_SESSION['mensagem'] = "Erro ao excluir usuário: " . mysqli_error($connect);
            }
        } else {
            $_SESSION['mensagem'] = "Erro ao excluir entregas associadas: " . mysqli_error($connect);
        }
    } else {
        $_SESSION['mensagem'] = "ID de usuário inválido.";
    }
} else {
    $_SESSION['mensagem'] = "Nenhum ID de usuário fornecido.";
}

header("Location: ../pages/gerencia.php");
exit();
?>
