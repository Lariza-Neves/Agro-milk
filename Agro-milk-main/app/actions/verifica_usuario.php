<?php
session_start();
if ($_SESSION['tipo'] !== 'admin') {
    if (!isset($_SESSION['id']) || !isset($_GET['id']) || $_SESSION['id'] != $_GET['id']) {
        header("Location: tabela.php?id={$_SESSION['id']}");
        exit();
    }
}
?>
