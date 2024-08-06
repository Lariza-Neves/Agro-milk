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

// Incluir o arquivo de consulta
require_once ("../actions/consultaUsers.php");

// Capturar o parâmetro de busca
$search = isset($_GET['search']) ? $_GET['search'] : '';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Funcionarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        
    header {
        background-color: #108237;
        padding: 10px 20px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 50px;
    }

    header .logo {
        display: flex;
        align-items: center;
    }

    header .logo img {
        height: 40px;
        margin-right: 10px;
    }

    header .logo h1 {
        margin: 0;
        font-size: 24px;
    }

    header .user-icon i {
        font-size: 24px;
    }

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
            background-color: #a7dbb6 ;
        }

        .sidebar h1 {
            color: #2E7D32; 
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
        padding: 0;
        
        }

        .sidebar ul li {
            margin: 5px 0;
            text-align: center;
        }

        .sidebar ul li a {
            color: black;
        text-decoration: none;
        font-size: 18px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: background-color 0.3s;
        }

        .sidebar ul li a i{
            margin-right: 10px;
            margin-left: 10px;
        }
        .sidebar button {
            font-size: large;
            background: none;
            border: none;
        }

        .sidebar button i {
            font-size: large;
            background: none;
            border: none;
        }

        .sidebar ul li a:hover {
            background-color: #066226;
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
            color: #2E7D32;
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

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header button:hover {
            background-color: #0056b3;
        }

        #lista table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #lista table,
        #lista th,
        #lista td {
            border: 1px solid #ddd;
        }

        body.dark-theme #lista h2 {
            color: #ffffff;
        }

        body.dark-theme #lista th,
        td {
            color: #000000;
        }

        #lista th,
        #lista td {
            padding: 15px;
            text-align: left;
        }

        #lista th {
            background-color: #f4f4f9;
        }

        #lista .actions button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: large;
        }

        #lista .actions .view {
            background-color: #ffc107;
            color: white;
        }

        #lista .actions .edit {
            background-color: #007bff;
            color: white;
        }

        #lista .actions .delete {
            background-color: #dc3545;
            color: white;
        }

        #lista .actions .forward {
            background-color: #28a745;
            color: white;
        }

        #lista .actions button:hover {
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

        /* Estilos adicionais para o input de busca e botão de submit */
        form input[type="text"] {
            padding: 10px;
            font-size: large;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
            width: 200px;
        }

        form button[type="submit"] {
            padding: 10px 20px;
            font-size: large;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        form button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .theme-list {
            display: none;
            /* Inicialmente escondido */
        }

        .show {
            display: block;
            /* Mostra a lista quando ativada */
        }

        body.light-theme {
            background-color: #ffffff;
            color: #000000;
        }

        body.dark-theme {
            background-color: #000000;
            color: #ffffff;
        }

        /* Estilo da sidebar no modo dark */
        body.dark-theme .sidebar {
            background-color: #053917;
            /* Cinza escuro */
        }

        /* Estilo dos links na sidebar no modo dark */
        body.dark-theme .sidebar ul li a {
            color: white;
            /* Cor branca para os links */
        }

        body.dark-theme .sidebar button {
            color: white;
        }

        /* Estilo de hover para os links na sidebar no modo dark */
        body.dark-theme .sidebar ul li a:hover {
            background-color: #066226;
            /* Um pouco mais claro que o fundo da sidebar */
        }

        /* Estilo dos botões Claro e Escuro */
        #themeList button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            margin: 0;
            text-align: center;
            width: 100%;
        }

        #themeButton:hover {
            background-color: #066226;
        }
        #themeButton{width: 100%;}

        /* Estilo de hover para o botão de tema no modo escuro */
        body.dark-theme #themeButton:hover {
            background-color: #066226;
            color: white;
        }

        #themeList button:hover {
            background-color: #066226;
        }

        /* Estilo dos botões Claro e Escuro no modo escuro */
        body.dark-theme #themeList button:hover {
            background-color: #066226;
            color: white;
        }
        body.dark-theme .header h2{
            color: #a7dbb6;
        }
    </style>
</head>

<body class="light-theme">
<header>
        <div class="logo">
            <img src="logo.png" alt="Logo Agro Milk">
            <h1>Agro Milk</h1>
        </div>
    </header>
    <div class="sidebar">
        <ul>
            <li><a href="tabela.php"><i class="fas fa-users"></i>Painel</a></li>
                <button id="themeButton"><i class="fas fa-palette"></i> Tema</button>
                <ul id="themeList" class="theme-list">
                    <li><button id="lightTheme">Claro <i class="bi bi-sun-fill"></i></button></li>
                    <li><button id="darkTheme">Escuro <i class="bi bi-moon-stars-fill"></i></button></li>
                </ul>
            </li>
            <li><a href="../actions/logout.php"><i class="fas fa-sign-out-alt"></i>Sair</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <h2>Gerenciador de funcionários</h2>
            <div class="header-content">
                <button id="addRecordBtn">Adicionar Registro</button>
                <form method="GET" action="gerencia.php">
                    <input type="text" name="search" placeholder="Buscar por nome" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">Buscar</button>
                </form>
            </div>
            <div id="lista">
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
                        $usuarios = buscarUsuarios($connect, $search);
                        if (mysqli_num_rows($usuarios) > 0) {
                            while ($usuario = mysqli_fetch_assoc($usuarios)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($usuario['login']) . "</td>";
                                echo "<td>" . date('d/m/Y ', strtotime($usuario['data_cadastro'])) . "</td>";
                                echo "<td class='actions'>
                                    <button class='edit' onclick='window.location.href=\"../pages/tabela.php?id={$usuario['id']}\"'>Detalhar</button>
                                    <button class='delete' onclick='confirmarExclusao({$usuario['id']})'>Excluir</button>
                                    <button class='view' onclick='window.location.href=\"../pages/historico.php?id={$usuario['id']}\"'>Histórico</button>
                                  </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum usuário encontrado.</td></tr>";
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

                document.getElementById('themeButton').addEventListener('click', function () {
                    var themeList = document.getElementById('themeList');
                    themeList.classList.toggle('show');
                });

                document.getElementById('lightTheme').addEventListener('click', function () {
                    setTheme('light');
                });

                document.getElementById('darkTheme').addEventListener('click', function () {
                    setTheme('dark');
                });

                // Função para definir o tema
                function setTheme(theme) {
                    if (theme === 'light') {
                        document.body.classList.add('light-theme');
                        document.body.classList.remove('dark-theme');
                    } else if (theme === 'dark') {
                        document.body.classList.add('dark-theme');
                        document.body.classList.remove('light-theme');
                    }
                    // Armazenar o tema no local storage
                    localStorage.setItem('theme', theme);
                }

                // Função para carregar o tema ao carregar a página
                function loadTheme() {
                    var theme = localStorage.getItem('theme');
                    if (theme) {
                        setTheme(theme);
                    }
                }

                // Carregar o tema ao carregar a página
                window.addEventListener('load', loadTheme);
            </script>
</body>
</html>
