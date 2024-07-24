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
        th, td {
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
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>NOME DO FUNCIONARIO</th>
                <th>Litros Do dia</th>
                <th>Valor do Leite</th>
                <th>Total em R$</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>José dos Santos</td>
                <td>100</td>
                <td>R$ 3,50</td>
                <td>R$ 350,00</td>
                <td>
                    <button class="btn btn-detail">editar</button>
                    <button class="btn btn-delete">Excluir</button>
                </td>
            </tr>

        </tbody>
    </table>
</body>
</html>
