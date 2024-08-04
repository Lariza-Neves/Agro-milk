<?php
require_once("../config/conecta.php");
require_once("verifica_usuario.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);

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

header("Location: ../pages/gerencia.php");
exit();
?>
