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
            margin-left: 270px; /* Largura da sidebar + espaçamento */
            padding: 20px;
            width: calc(100% - 270px); /* Largura da página menos a largura da sidebar */
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
        th, td {
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
</head>
<body>
    <div class="sidebar">
        <img src="foto_perfil.jpg" alt="Foto de Perfil">
        <h2>Nome do Funcionário</h2>
        <p>Contato: (XX) XXXX-XXXX</p>
    </div>
    <div class="content">
        <h1>Histórico de Leite Fornecido</h1>
        <div class="filter-form">
            <label for="year">Ano:</label>
            <select id="year" name="year">
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
            </select>
            <label for="month">Mês:</label>
            <select id="month" name="month">
                <option value="01">Janeiro</option>
                <option value="02">Fevereiro</option>
                <option value="03">Março</option>
                <option value="04">Abril</option>
                <option value="05">Maio</option>
                <option value="06">Junho</option>
                <option value="07">Julho</option>
                <option value="08">Agosto</option>
                <option value="09">Setembro</option>
                <option value="10">Outubro</option>
                <option value="11">Novembro</option>
                <option value="12">Dezembro</option>
            </select>
            <button type="button" onclick="filterHistory()">Filtrar</button>
        </div>
        <div class="month-info">
            <strong>Mês Referente:</strong> Janeiro<br>
            <strong>Valor do Leite no Mês:</strong> R$ 3,50
        </div>
        <table>
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Quantidade de Leite (litros)</th>
                    <th>Total (R$)</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemplo de dados -->
                <tr>
                    <td>01</td>
                    <td>50</td>
                    <td class="total-amount">R$ 175,00</td>
                </tr>
                <tr>
                    <td>02</td>
                    <td>45</td>
                    <td class="total-amount">R$ 157,50</td>
                </tr>
                <tr>
                    <td>03</td>
                    <td>55</td>
                    <td class="total-amount">R$ 192,50</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        function filterHistory() {
            var year = document.getElementById('year').value;
            var month = document.getElementById('month').value;
            alert('Filtrando histórico para ' + month + '/' + year);
        }
    </script>
</body>
</html>
