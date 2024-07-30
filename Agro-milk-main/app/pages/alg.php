<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin-right: 20px;
        }
        .buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .buttons button {
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .buttons button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile">
            <img src="profile-placeholder.png" alt="Perfil">
            <h2>PERFIL</h2>
        </div>
        <div class="buttons">
            <button onclick="showDados()">MEUS DADOS</button>
            <button onclick="showHistorico()">HISTÓRICO</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>DIAS</th>
                    <th>LITROS</th>
                    <th>VALOR DO LEITE</th>
                    <th>TOTAL EM R$</th>
                </tr>
            </thead>
            <tbody>
                <!-- Linhas de dados -->
            </tbody>
        </table>
    </div>

    <script>
        function showDados() {
            alert('Mostrar dados do usuário');
        }

        function showHistorico() {
            alert('Mostrar histórico dos meses anteriores');
        }
    </script>
</body>
</html>