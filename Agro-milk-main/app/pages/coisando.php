<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros das Fichas de Escuta Especializada</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .sidebar {
            width: 220px;
            background-color: #fff;
            position: fixed;
            height: 100%;
            padding-top: 20px;
            border-right: 1px solid #ddd;
        }
        .sidebar h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px;
            text-align: center;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            display: block;
        }
        .sidebar ul li a:hover {
            background-color: #f4f4f9;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .header button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f4f4f9;
        }
        .actions button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .actions .view {
            background-color: #ffc107;
            color: white;
        }
        .actions .edit {
            background-color: #007bff;
            color: white;
        }
        .actions .delete {
            background-color: #dc3545;
            color: white;
        }
        .actions .forward {
            background-color: #28a745;
            color: white;
        }
        .actions button:hover {
            opacity: 0.8;
        }
        .main-content{
            font-size: larger;
        }
        .botoes{
            font-size: large;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>PROTEÇÃO</h1>
        <ul>
            <li><a href="#">Início</a></li>
            <li><a href="#">Espontânea</a></li>
            <li><a href="#">Especializada</a></li>
            <li><a href="#">Exibir Espontânea</a></li>
            <li><a href="#">Exibir Especializada</a></li>
            <li><a href="#">Encaminhamento</a></li>
            <li><a href="#">Usuários</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <h2>Registros das Fichas de Escuta Especializada</h2>
            <button class="botoes">Adicionar registro</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>07/02/2024</td>
                    <td>José dos Santos</td>
                    <td class="actions">
                        <button class="botoes" class="edit">Ver mais</button>
                        <button class="botoes" class="delete">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
