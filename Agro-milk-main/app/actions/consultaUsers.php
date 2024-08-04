<?php
require_once("../config/conecta.php");

function buscarUsuarios($connect, $search = '') {
    // Adiciona proteção contra SQL Injection
    $search = mysqli_real_escape_string($connect, $search);

    // Se não houver busca, mostra todos os usuários
    if ($search === '') {
        $query = "SELECT id, login, data_cadastro FROM usuarios ORDER BY data_cadastro DESC";
    } else {
        // Caso contrário, faz uma busca com o parâmetro fornecido
        $query = "SELECT id, login, data_cadastro FROM usuarios WHERE login LIKE '%$search%' ORDER BY data_cadastro DESC";
    }

    $result = mysqli_query($connect, $query);

    if (!$result) {
        die("Erro na consulta: " . mysqli_error($connect));
    }

    return $result;
}
?>
