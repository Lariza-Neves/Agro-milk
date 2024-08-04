<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['ativa']) || $_SESSION['ativa'] !== TRUE) {
    $_SESSION['msgLogin'] = "Você precisa estar logado para acessar esta página.";
    header("Location: ../pages/login.php");
    exit();
}

// Se necessário, verifique se o usuário é administrador
 if ($_SESSION['tipo'] !== 'admin') {
     $_SESSION['msgLogin'] = "Você não tem permissão para acessar esta página.";
     header("Location: ../pages/login.php");
     exit();
 }
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Funcionarios</title>
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
            margin-top: 20px;
            margin-bottom: 10px;
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

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
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
            font-size: large;
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

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .modal-content input[type="text"],
        .modal-content input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;

        }

        .modal-content button {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;

        }

        .modal-content button:hover {
            background-color: #0056b3;

        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .main-content {
            font-size: larger;
        }
    </style>

</head>

<body>
    <?php require_once ("../actions/consultaUsers.php"); ?>
    <div class="sidebar">
        <h1>PROTEÇÃO</h1>
        <ul>
            <li><a href="tabela.php">painel</a></li>
            <li><a href="users.php">gerenciador de usuarios</a></li>
            <li><a href="../actions/logout.php">sair</a></li>

        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <h2>Registros de Funcionarios</h2>
            <button style="font-size: large;" id="addRecordBtn">Adicionar registro</button>
            <div>
                <h2>Lista de Usuários</h2>
                <?php
                        if (isset($_SESSION['mensagem'])) {
                            echo "<p>{$_SESSION['mensagem']}</p>";
                            unset($_SESSION['mensagem']); // Limpa a mensagem após exibir
                        }
                        ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data de Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $usuarios = buscarUsuarios($connect);
                        if (mysqli_num_rows($usuarios) > 0) {
                            while ($usuario = mysqli_fetch_assoc($usuarios)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($usuario['login']) . "</td>";
                                echo "<td>" . date('d/m/Y ', strtotime($usuario['data_cadastro'])) . "</td>";
                                echo "<td class='actions'>
                                <button class='edit' onclick='window.location.href=\"../pages/tabela.php?id={$usuario['id']}\"'>Detalhar</button>
                                <button class='delete' onclick='confirmarExclusao({$usuario['id']})'>Excluir</button>
                              </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum usuário cadastrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- The Modal -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Registro</h2>
                    <form action="../actions/inserirUsuario.php" method="POST">
                        
                        <input type="text" name="login" placeholder="Login" required>
                        <input type="password" name="senha" placeholder="Senha" required>
                        <input type="password" name="confirmar_senha" placeholder="Confirmar Senha" required>
                        <button type="submit" name="cadastrar">Registrar</button>
                    </form>

                </div>
            </div>

            <script>
                var modal = document.getElementById("myModal");
                var btn = document.getElementById("addRecordBtn");
                var span = document.getElementsByClassName("close")[0];

                btn.onclick = function () {
                    modal.style.display = "block";
                }

                span.onclick = function () {
                    modal.style.display = "none";
                }

                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }

                function confirmarExclusao(userId) {
                    if (confirm("Tem certeza que deseja excluir este usuário?")) {
                        window.location.href = "../actions/deletarUsuario.php?id=" + userId;
                    }
                }
            </script>
</body>

</html>