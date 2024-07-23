<?php

require_once("../confing/conecta.php");


function inserirUsuarios($connect){

    if(isset($_POST['cadastrar']) AND !empty($_POST['login_adm']) AND !empty($_POST['senha_adm'])){
        $erros = array();
        $loginAdm = filter_input(INPUT_POST, 'login_adm'); 
        //$nome = mysqli_real_escape_string($connect, $_POST['login_adm']); //retira caracteries especiais
        $senha = sha1($_POST['senha_adm']);

        if ($_POST['senha_adm'] != ($_POST['repetesenha_adm'])){
            $erro[]= "Senhas diferentes!";
        }
        $queryLogin = "SELECT login_adm FROM USUARIO_ADM WHERE login_adm = '$loginAdm'";
        $buscaLogin= mysqli_query($connect, $queryLogin);
        $verifica = mysqli_num_rows($buscaLogin);


        if (!empty($verifica)){
            $erro[]= "esse login ja esta sendo usado";
        }

        if (empty($erros)){
            $query = "INSERT INTO USUARIO_ADM (login_adm, senha_adm) VALUES ('$loginAdm', '$senha')";
            $executar = mysqli_query($connect, $query);
        
        if ($executar){
            echo "usuario inserido com sucesso";
        }else{
            echo "erro ao inserir usuario";
        }

        }else{
            foreach($erros as $erro){
                echo "<p>$erro</p>";
            }
        }
    }
}
?>