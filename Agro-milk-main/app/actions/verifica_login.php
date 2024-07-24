<?php
include '../config/conecta.php';
    function login($connect){
        if(isset($_POST['acessar']) AND !empty($_POST['login']) AND !empty($_POST['senha'])){
            $login = filter_input(INPUT_POST, 'login'); 
            $senha = sha1($_POST['senha']);
            $queryAdm = "SELECT * FROM administradores WHERE login ='$login' AND senha = '$senha'";
            $queryUser = "SELECT * FROM usuarios WHERE login ='$login' AND senha = '$senha'";
            
            $executarAdm = mysqli_query($connect, $queryAdm);
            $returnAdm = mysqli_fetch_assoc($executarAdm);

            $executarUser = mysqli_query($connect, $queryUser);
            $returnUser = mysqli_fetch_assoc($executarUser);

            if (!empty($returnAdm['login'])){
                session_start();
                $_SESSION['login'] = $returnAdm['login'];
                $_SESSION['id'] = $returnAdm['id'];
                $_SESSION['tipo'] = 'admin';
                $_SESSION['ativa'] = TRUE;
                header("location: admin_dashboard.php"); // Redirecionar para o painel do admin
            } elseif (!empty($returnUser['login'])) {
                session_start();
                $_SESSION['login'] = $returnUser['login'];
                $_SESSION['id'] = $returnUser['id'];
                $_SESSION['tipo'] = 'user';
                $_SESSION['ativa'] = TRUE;
                header("location: user_dashboard.php"); // Redirecionar para o painel do usuário
            } else {
                echo "Login ou senha incorretos";
            }
        } 
    }

    /* seleciona(busca) no bd apenas um resultado com base no ID */
    function buscaUnica($connect, $tabela, $id){
        $query = "SELECT * FROM $tabela WHERE id =". (int) $id; //transforma string em valor int
        $execute = mysqli_query($connect, $query);
        $reuslt = mysqli_fetch_assoc($execute);
        return $reuslt;
    }

    /* seleciona(busca) no bd todos os resultado com base no ID */
    function buscar($connect, $tabela, $where = 1, $order = ""){
        if (!empty($order)){
            $order = "ORDER BY $order";
        }
        $query = "SELECT * FROM $tabela WHERE $where $order";
        $execute = mysqli_query($connect, $query);
        $reuslts = mysqli_fetch_all($execute, MYSQLI_ASSOC);
        return $reuslts;
    }
?>
