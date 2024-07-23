<?php session_start();
$seguranca = isset($_SESSION['ativa']) ? TRUE : header("location:login.php");
require_once ("../confing/conecta.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>padm-users</title>
    
</head>
<body>
<?php 
    if($seguranca){

   
?>
            <h1>gerenciador de ususarios</h1>
            <h2>bem vindo, <?php echo $_SESSION['login_adm']; ?></h2>

            
            <nav>
                <div>
                    <a href="tabela.php">painel</a>
                    <a href="users.php">gerenciador de usuarios</a>
                    <a href="../actions/logout.php">sair</a>
                </div>
            </nav>
<?php 
require_once("../actions/inserirUsuario.php");
    $tabela = "USUARIO_ADM";
    $order = "login_adm";
    $usuarios = buscar($connect, $tabela, 1, $order );
    inserirUsuarios($connect);
?>

            <form action="" method= "post">
                <fieldset>
                    <legend>inserir usuarios</legend>
                    <input type="text" name= "login_adm" placeholder= "login">
                    <input type="password" name= "senha_adm" placeholder= "senha">
                    <input type="password" name= "repetesenha_adm" placeholder= "confirme sua senha">
                    <input type="submit" name="cadastrar" value = "cadastrar">

                </fieldset>
            </form>
            <div class="container">
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>QUANTIDADE DE LEITE</th>
                            <th>REMUNERAÇÃO FINAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($usuarios as $usuario): ?>
                                <tr>
                                    <td><?php echo $usuario['cod_adm'];?></td>
                                    <td><?php echo $usuario['login_adm'];?></td>
                                    <td><?php echo $usuario['quant_leite'];?></td>
                                </tr>
                            <?php endforeach;
                        ?>
                    </tbody>
                </table>
            </div>

<?php } 
?>
</body>
</html>
