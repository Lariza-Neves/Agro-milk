<?php
    $dbHost = 'Localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'agro_leite';

    $connect = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($connect->connect_error) {
        die("Conexão falhou: " . $connect->connect_error);
    }
?>
