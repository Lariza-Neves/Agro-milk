<?php
require_once("../config/conecta.php");
require_once("../actions/verifica_usuario.php");

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Atualizar a entrega para marcar como paga
    $query = "UPDATE entregas SET pago = TRUE WHERE id = $id";
    if (mysqli_query($connect, $query)) {
        $_SESSION['mensagem'] = "Entrega marcada como paga com sucesso.";
    } else {
        $_SESSION['mensagem'] = "Erro ao marcar a entrega como paga.";
    }
} else {
    $_SESSION['mensagem'] = "Nenhum ID de entrega fornecido.";
}

header("Location: ../pages/gerencia.php");
exit();
?>
