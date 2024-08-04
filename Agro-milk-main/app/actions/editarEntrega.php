<?php
require_once("../config/conecta.php");
require_once("verifica_usuario.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id > 0) {
        $queryEntrega = "SELECT * FROM entregas WHERE id = $id";
        $resultadoEntrega = mysqli_query($connect, $queryEntrega);

        if (mysqli_num_rows($resultadoEntrega) > 0) {
            $entrega = mysqli_fetch_assoc($resultadoEntrega);
        } else {
            $_SESSION['mensagem'] = "Entrega não encontrada.";
            header("Location: ../pages/gerencia.php");
            exit();
        }
    } else {
        $_SESSION['mensagem'] = "ID de entrega inválido.";
        header("Location: ../pages/gerencia.php");
        exit();
    }
} else {
    $_SESSION['mensagem'] = "Nenhum ID de entrega fornecido.";
    header("Location: ../pages/gerencia.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $quantidade_leite = floatval($_POST['quantidade_leite']);
    $preco_dia = floatval($_POST['preco_dia']);

    $queryAtualiza = "UPDATE entregas SET quantidade_leite = $quantidade_leite, preco_dia = $preco_dia WHERE id = $id";
    if (mysqli_query($connect, $queryAtualiza)) {
        $_SESSION['mensagem'] = "Entrega atualizada com sucesso.";
        header("Location: ../pages/gerencia.php");
        exit();
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar entrega.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Entrega</title>
</head>
<body>
    <h2>Editar Entrega</h2>
    <form action="editarEntrega.php?id=<?php echo $entrega['id']; ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $entrega['id']; ?>">
        <label for="quantidade_leite">Quantidade de Leite:</label>
        <input type="number" name="quantidade_leite" value="<?php echo htmlspecialchars($entrega['quantidade_leite']); ?>" step="0.01" required><br>
        <label for="preco_dia">Preço do Leite:</label>
        <input type="number" name="preco_dia" value="<?php echo htmlspecialchars($entrega['preco_dia']); ?>" step="0.01" required><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
