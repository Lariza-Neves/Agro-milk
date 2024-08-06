<?php
session_start();
require_once("../config/conecta.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $entrega_id = intval($_POST['id']);

    // Verificar se o ID da entrega é válido
    if ($entrega_id > 0) {
        $query = "UPDATE entregas SET pago = TRUE WHERE id = '$entrega_id'";
        $executar = mysqli_query($connect, $query);

        if ($executar) {
            $_SESSION['mensagem'] = "Entrega marcada como paga com sucesso.";
        } else {
            $_SESSION['mensagem'] = "Erro ao marcar entrega como paga: " . mysqli_error($connect);
        }
    } else {
        $_SESSION['mensagem'] = "ID de entrega inválido.";
    }
} else {
    $_SESSION['mensagem'] = "Formulário não submetido corretamente.";
}

// Redirecionar de volta para a página de detalhes do funcionário
header("Location: ../pages/tabela.php?id=" . $_POST['usuario_id']);
exit();
?>
