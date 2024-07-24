<?php
require_once("../config/conecta.php");

function buscarUsuarios($connect) {
    $query = "SELECT id, login, data_cadastro FROM usuarios ORDER BY data_cadastro DESC";
    $result = mysqli_query($connect, $query);

    if (!$result) {
        die("Erro na consulta: " . mysqli_error($connect));
    }

    return $result;
}
?>
