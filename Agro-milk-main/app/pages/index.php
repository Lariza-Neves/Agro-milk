<!DOCTYPE html>
<html lang="Pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <title>Agro-milk</title>
    <link rel="stylesheet" href="../public/css/index.css">
   
</head>
<body>
    <header>
        <nav class="navigation">
            <a href="#" class="logo">A<span>gr</span>o M<span>il</span>K</a>
            <ul class="nav-menu">
                <li class="nav-item"><a href="area_conste.php">Conscientização</a></li>
            </ul>
            <div class="menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>
    <main>
        <section class="home">
            <div class="home-text">
                <h4 class="text-h4">Bem vindo a Agro-milk</h4>
                <h1 class="text-h1">Seu sistema financeiro de laticíneos</h1>
                <p></p>
                <a href="login.php" class="home-btn">Entrar</a>
            </div>
            <div class="home-img">
                <img src="../public/img/img-inicial-removebg-preview.png" alt="imagem que representa administração">
            </div>
        </section>
    </main>
    <script>
        const menu = document.querySelector('.menu');
        const NavMenu = document.querySelector('.nav-menu');

        menu.addEventListener('click', () => {
            menu.classList.toggle('ativo');
            NavMenu.classList.toggle('ativo');
        })
    </script>
</body>
</html>
