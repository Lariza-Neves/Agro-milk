<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

</head>

<style>
    /* Seus estilos personalizados aqui */

    .theme-list {
        display: none;
        
    }

    .show {
        display: block;
    }

    body.light-theme {
        background-color: #ffffff;
        color: #000000;
    }

    body.dark-theme {
        background-color: #000000;
        color: #ffffff;
    }

    body.dark-theme .sidebar {
        background-color: #333333;
    }

    body.dark-theme .sidebar ul li a {
        color: white;
    }

    body.dark-theme .sidebar button {
        color: white;
    }

    body.dark-theme .sidebar ul li a:hover {
        background-color: #444444;
    }

    #themeList button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        margin: 0;
        text-align: center;
        width: 100%;
        font-weight: bold;
    }

    #themeButton:hover {
        background-color: #9acfa2;
    }

    #themeButton {
        width: 100%;
        font-weight: bold;
    }

    body.dark-theme #themeButton:hover {
        background-color: #444444;
        color: white;
    }

    #themeList button:hover {
        background-color: #9acfa2;
    }

    body.dark-theme #themeList button:hover {
        background-color: #444444;
        color: white;
    }

    .sidebar {
        width: 220px;
        background-color: #a7dbb6;
        height: 100vh;
        padding-top: 20px;
        border-right: 1px solid #ddd;
        font-weight: bold;
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

    .sidebar ul li a i {
        margin-right: 10px;
    }

    .sidebar button {
        background: none;
        border: none;
        width: 100%;
        padding-bottom: 20px;
    }
    .sidebar ul li button:hover {
        background-color: #9acfa2;
    }
    .sidebar ul li a:hover {
        background-color: #9acfa2;
    }
    .view{
    font-weight: bold !important;
    }

</style>

<div class="sidebar">
    <ul> <?php 
    if ($_SESSION['tipo'] === 'admin') {
        echo '<li><a href="tabela.php"><i class="fas fa-users"></i>Painel</a></li>';
    }
    ?>
        
        <li><button class='view' class='btn btn-delete' onclick='window.location.href="../pages/historico.php?id=<?php echo $id; ?>"'>Histórico</button>
        </li>
        <button id="themeButton"><i class="fas fa-palette"></i>Tema</button>
        <ul id="themeList" class="theme-list">
            <li><button id="lightTheme">Claro <i class="bi bi-sun-fill"></i></button></li>
            <li><button id="darkTheme">Escuro <i class="bi bi-moon-stars-fill"></i></button></li>
        </ul>
        <li><a href="../actions/logout.php"><i class="fas fa-sign-out-alt"></i>Sair</a></li>
    </ul>
</div>

<script>
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

    function setTheme(theme) {
        if (theme === 'light') {
            document.body.classList.add('light-theme');
            document.body.classList.remove('dark-theme');
        } else if (theme === 'dark') {
            document.body.classList.add('dark-theme');
            document.body.classList.remove('light-theme');
        }
        localStorage.setItem('theme', theme);
    }

    function loadTheme() {
        var theme = localStorage.getItem('theme');
        if (theme) {
            setTheme(theme);
        }
    }

    window.addEventListener('load', loadTheme);
</script>
