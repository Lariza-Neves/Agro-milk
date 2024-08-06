<?php
require_once("../config/conecta.php");
require_once("../actions/verifica_usuario.php"); // Inclui a verificação de acesso

$usuario = null;
$resultadoEntregas = null;
$mensagem = null;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Verifica se o ID é válido
    if ($id > 0) {
        // Busca o nome do funcionário
        $queryUsuario = "SELECT login FROM usuarios WHERE id = $id";
        $resultadoUsuario = mysqli_query($connect, $queryUsuario);

        // Verifica se a consulta retornou algum resultado
        if (mysqli_num_rows($resultadoUsuario) > 0) {
            $usuario = mysqli_fetch_assoc($resultadoUsuario);

            // Busca as entregas do funcionário que não estão pagas
            $queryEntregas = "SELECT * FROM entregas WHERE usuario_id = $id AND pago = FALSE";
            $resultadoEntregas = mysqli_query($connect, $queryEntregas);
        } else {
            $_SESSION['mensagem'] = "Usuário não encontrado.";
            header("Location: ../pages/gerencia.php");
            exit();
        }
    } else {
        $_SESSION['mensagem'] = "ID de usuário inválido.";
        header("Location: ../pages/gerencia.php");
        exit();
    }
} else {
    $_SESSION['mensagem'] = "Nenhum ID de usuário fornecido.";
    header("Location: ../pages/gerencia.php");
    exit();
}

if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações de Pagamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        th[colspan="4"] {
            text-align: center;
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            color: white;
            cursor: pointer;
        }

        .btn-detail {
            background-color: #007bff;
            margin-right: 5px;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-paid {
            background-color: #28a745;
            margin-right: 5px;
        }
    </style>
    <script>
        function confirmDelete(event) {
            if (!confirm('Tem certeza que deseja excluir esta entrega?')) {
                event.preventDefault();
            }
        }

        function confirmPago(event) {
            if (!confirm('Tem certeza que deseja marcar esta entrega como paga?')) {
                event.preventDefault();
            }
        }
    </script>
</head>

<body>
    <h2>Detalhes do Funcionário: <?php echo htmlspecialchars($usuario['login'] ?? ''); ?></h2>
    <li><a href="../actions/logout.php">Sair</a></li>
    <?php if ($mensagem): ?>
        <p><?php echo htmlspecialchars($mensagem); ?></p>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Litros do Dia</th>
                <th>Valor do Leite</th>
                <th>Total em R$</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultadoEntregas && mysqli_num_rows($resultadoEntregas) > 0) {
                while ($entrega = mysqli_fetch_assoc($resultadoEntregas)) {
                    $total = $entrega['quantidade_leite'] * $entrega['preco_dia'];
                    echo "<tr>";
                    echo "<td>" . date('d/m/Y', strtotime($entrega['data_entrega'])) . "</td>";
                    echo "<td>" . htmlspecialchars($entrega['quantidade_leite']) . "</td>";
                    echo "<td>R$ " . number_format($entrega['preco_dia'], 2, ',', '.') . "</td>";
                    echo "<td>R$ " . number_format($total, 2, ',', '.') . "</td>";
                    echo "<td class='actions'>
                            <a href='../actions/editarEntrega.php?id=" . $entrega['id'] . "&usuario_id=" . $id . "' class='btn btn-detail'>Editar</a>

                            <form action='../actions/excluirEntrega.php' method='POST' style='display:inline;' onsubmit='confirmDelete(event)'>
                                <input type='hidden' name='id' value='" . $entrega['id'] . "'>
                                <input type='hidden' name='usuario_id' value='" . $id . "'>
                                <button type='submit' class='btn btn-delete'>Excluir</button>
                            </form>
                            <form action='../actions/marcarPago.php' method='POST' style='display:inline;' onsubmit='confirmPago(event)'>
                                <input type='hidden' name='id' value='" . $entrega['id'] . "'>
                                <input type='hidden' name='usuario_id' value='" . $id . "'>
                                <button type='submit' class='btn btn-paid'>Pago</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhuma entrega registrada.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h3>Inserir Dados de Coleta</h3>
    <form action="../actions/inserirDadosColeta.php" method="POST">
        <input type="hidden" name="usuario_id" value="<?php echo $id; ?>">
        <input type="number" name="quantidade_leite" placeholder="Quant. Leite do dia" step="0.01" required>
        <input type="number" name="preco_dia" placeholder="Preço por litro do leite" step="0.01" required>
        <button type="submit" name="inserir">Inserir</button>
    </form>

</body>

</html>
