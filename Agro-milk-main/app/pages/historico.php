<?php
require_once("../config/conecta.php");
require_once("../actions/verifica_usuario.php"); // Inclui a verificação de acesso

$usuario = null;
$resultadoEntregas = null;
$filtroAno = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$filtroMes = isset($_GET['month']) ? str_pad(intval($_GET['month']), 2, '0', STR_PAD_LEFT) : date('m');

// Definição do array de meses
$months = [
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março',
    '04' => 'Abril',
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro'
];

// Verificar se o mês é válido
$mesReferencia = array_key_exists($filtroMes, $months) ? $months[$filtroMes] : "Mês inválido";

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

            // Busca as entregas pagas do funcionário
            $queryEntregas = "SELECT * FROM entregas WHERE usuario_id = $id AND pago = 1 AND YEAR(data_entrega) = $filtroAno AND MONTH(data_entrega) = $filtroMes";
            $resultadoEntregas = mysqli_query($connect, $queryEntregas);

            // Consulta para obter os anos com entregas registradas
            $queryAnos = "SELECT DISTINCT YEAR(data_entrega) AS ano FROM entregas WHERE usuario_id = $id ORDER BY ano DESC";
            $resultadoAnos = mysqli_query($connect, $queryAnos);
            $anosDisponiveis = [];
            while ($row = mysqli_fetch_assoc($resultadoAnos)) {
                $anosDisponiveis[] = $row['ano'];
            }
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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Leite Fornecido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9f5f9;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #0077b6;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            height: 100vh;
            position: fixed;
            color: white;
        }

        .sidebar img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            display: block;
            margin: 0 auto 20px;
            border: 2px solid #fff;
        }

        .sidebar h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 10px;
        }

        .sidebar p {
            text-align: center;
            color: #ddd;
            margin-bottom: 5px;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
        }

        .content h1 {
            text-align: center;
            color: #0077b6;
        }

        .filter-form {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-form select {
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
        }

        .filter-form button {
            padding: 10px 20px;
            background-color: #0077b6;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .filter-form button:hover {
            background-color: #005f8a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0077b6;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .month-info {
            margin: 20px 0;
            font-size: 18px;
            color: #555;
        }

        .total-amount {
            color: #0077b6;
            font-weight: bold;
        }
    </style>
    <script>
        function filterHistory() {
            var year = document.getElementById('year').value;
            var month = document.getElementById('month').value;
            window.location.href = `historico.php?id=<?php echo $id; ?>&year=${year}&month=${month}`;
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <img src="../public/assets/person-circle.svg" alt="Foto de Perfil">
        <h2><?php echo htmlspecialchars($usuario['login'] ?? ''); ?></h2>
    </div>
    <div class="content">
        <h1>Histórico de Leite Fornecido</h1>
        <div class="filter-form">
            <label for="year">Ano:</label>
            <select id="year" name="year">
                <?php
                if (!empty($anosDisponiveis)) {
                    foreach ($anosDisponiveis as $ano) {
                        $selected = $ano == $filtroAno ? 'selected' : '';
                        echo "<option value='$ano' $selected>$ano</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum ano disponível</option>";
                }
                ?>
            </select>
            <label for="month">Mês:</label>
            <select id="month" name="month">
                <?php
                foreach ($months as $num => $name) {
                    $selected = $num == $filtroMes ? 'selected' : '';
                    echo "<option value='$num' $selected>$name</option>";
                }
                ?>
            </select>
            <button type="button" onclick="filterHistory()">Filtrar</button>
        </div>
        <div class="month-info">
            <strong>Mês Referente:</strong> <?php echo htmlspecialchars($mesReferencia); ?><br>
            
        </div>
        <table>
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Quantidade de Leite (litros)</th>
                    <th>Preço</th>
                    <th>Total (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultadoEntregas && mysqli_num_rows($resultadoEntregas) > 0) {
                    while ($entrega = mysqli_fetch_assoc($resultadoEntregas)) {
                        $total = $entrega['quantidade_leite'] * 3.50; // Atualize com o valor correto se necessário
                        echo "<tr>";
                        echo "<td>" . date('d', strtotime($entrega['data_entrega'])) . "</td>";
                        echo "<td>" . htmlspecialchars($entrega['quantidade_leite']) . "</td>";
                        echo "<td>" . htmlspecialchars($entrega['preco_dia']) .  " R$ </td>";
                        echo "<td class='total-amount'>R$ " . number_format($total, 2, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhuma entrega registrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>