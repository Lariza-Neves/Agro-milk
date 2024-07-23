<?php
    $dbHost = 'Localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'agro_leite';

    $connect = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    function login($connect){
        if(isset($_POST['acessar']) AND !empty($_POST['login_adm']) AND !empty($_POST['senha_adm'])){
            $loginAdm = filter_input(INPUT_POST, 'login_adm'); 
            $senhaAdm = sha1($_POST['senha_adm']);
            $query = "SELECT* FROM USUARIO_ADM WHERE login_adm ='$loginAdm' AND senha_adm = '$senhaAdm'";
            $executar = mysqli_query($connect, $query);
            $return = mysqli_fetch_assoc($executar);

            if (!empty($return['login_adm'])){
                //echo $return['login_adm'];
                session_start();
                $_SESSION['login_adm'] = $return['login_adm'];
                $_SESSION['cod_adm'] = $return['cod_adm'];
                $_SESSION['ativa'] = TRUE;
                header("location: tabela.php");
                //testa isso daqui depois (qquando conseguir cadastrar o usuario)
            
            }else{
                echo "tem login aq n";
            }
        } 
    }
/* seleciona(busca) no bd apenas um resultado com base no ID */
function buscaUnica($connect, $tabela, $id){
    $query = "SELECT * FROM $tabela WHERE id =". (int) $id; //transfoma strig en valor int
    $execute = mysqli_query($connect, $query);
    $reuslt =  mysqli_fetch_assoc($execute);
    return $reuslt;
} //pode servir para outras tabelas
/* seleciona(busca) no bd todos os resultado com base no ID */
function buscar($connect, $tabela, $where = 1, $order = ""){
    if (!empty($order)){
        $order = "ORDER BY $order";
    }
    $query = "SELECT * FROM $tabela WHERE $where $order";
    $execute = mysqli_query($connect, $query);
    $reuslts =  mysqli_fetch_all($execute, MYSQLI_ASSOC);
    return $reuslts;
}
?>