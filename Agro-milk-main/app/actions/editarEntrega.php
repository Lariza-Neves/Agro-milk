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
    $usuario_id = intval($_POST['usuario_id']); // Captura o usuario_id do formulário

    $queryAtualiza = "UPDATE entregas SET quantidade_leite = $quantidade_leite, preco_dia = $preco_dia WHERE id = $id";
    if (mysqli_query($connect, $queryAtualiza)) {
        $_SESSION['mensagem'] = "Entrega atualizada com sucesso.";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar entrega.";
    }

    // Redirecionar para a página de tabela com o ID do usuário
    header("Location: ../pages/tabela.php?id=$usuario_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Entrega</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9f5f9; /* Fundo azul claro */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Largura máxima para a div */
        }
        h2 {
            text-align: center;
            color: #0077b6;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
        .input-group input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .input-group span {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #555;
            pointer-events: none;
        }
        button {
            padding: 10px 20px;
            background-color: #0077b6;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #005f8a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Entrega</h2>
        <form action="editarEntrega.php?id=<?php echo $entrega['id']; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $entrega['id']; ?>">
            <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($_GET['usuario_id']); ?>"> <!-- Captura o ID do usuário -->
            <div class="input-group">
                <label for="quantidade_leite">Quantidade de Leite:</label>
                <input type="number" name="quantidade_leite" id="quantidade_leite" value="<?php echo htmlspecialchars($entrega['quantidade_leite']); ?>" step="0.01" required>
            </div>
            <div class="input-group">
                <label for="preco_dia">Preço do Leite:</label>
                <input type="number" name="preco_dia" id="preco_dia" value="<?php echo htmlspecialchars($entrega['preco_dia']); ?>" step="0.01" required>
            </div>
            <button type="submit">Salvar</button>
        </form>
    </div>
</body>
</html>
