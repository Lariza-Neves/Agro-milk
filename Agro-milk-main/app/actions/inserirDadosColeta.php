<?php
session_start();
require_once("../config/conecta.php");

if (isset($_POST['inserir'])) {
    $usuario_id = intval($_POST['usuario_id']);
    $quantidade_leite = floatval($_POST['quantidade_leite']);
    $preco_dia = floatval($_POST['preco_dia']); // Usar o nome correto da coluna
    $data_entrega = date('Y-m-d'); // Data atual sem hora

    // Verificar se os valores são válidos
    if ($usuario_id > 0 && $quantidade_leite >= 0 && $preco_dia >= 0) {
        $query = "INSERT INTO entregas (usuario_id, quantidade_leite, preco_dia, data_entrega) VALUES ('$usuario_id', '$quantidade_leite', '$preco_dia', '$data_entrega')";
        $executar = mysqli_query($connect, $query);

        if ($executar) {
            $_SESSION['mensagem'] = "Dados de coleta inseridos com sucesso.";
        } else {
            $_SESSION['mensagem'] = "Erro ao inserir dados de coleta: " . mysqli_error($connect);
        }
    } else {
        $_SESSION['mensagem'] = "Dados inválidos. Verifique se todos os campos estão preenchidos corretamente.";
    }
} else {
    $_SESSION['mensagem'] = "Formulário não submetido corretamente.";
}

header("Location: ../pages/tabela.php?id=$usuario_id");
exit();
?>
