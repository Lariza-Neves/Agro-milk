<?php session_start();
//$seguranca = isset($_SESSION['ativa']) ? TRUE : header("location:login.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações de Pagamento</title>
    
</head>
<body>
<?php 
    //if($seguranca){

   
?>
            <h1>adm</h1>
            <h2>bem vindo, <?php echo $_SESSION['login_adm']; ?></h2>
            
            <nav>
                <div>
                    <a href="tabela.php">painel</a>
                    <a href="users.php">gerenciador de usuarios</a>
                    <a href="../actions/logout.php">sair</a>
                </div>
            </nav>
        

<?php //} 
?>
</body>
</html>
