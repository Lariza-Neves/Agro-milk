<?php
// Incluir o arquivo de conexão com o banco de dados
require_once("../config/conecta.php");

/**
 * Função para buscar o histórico de um usuário específico
 *
 * @param mysqli $connect Conexão com o banco de dados
 * @param int $userId ID do usuário
 * @return mysqli_result Resultado da consulta
 */
function buscarHistorico($connect, $userId) {
    // Prepara a consulta SQL
    $query = "SELECT * FROM historico WHERE usuario_id = ? AND status = 'pago' ORDER BY data DESC";

    // Prepara a declaração
    if ($stmt = $connect->prepare($query)) {
        // Vincula o parâmetro
        $stmt->bind_param('i', $userId);

        // Executa a declaração
        $stmt->execute();

        // Obtém o resultado
        $result = $stmt->get_result();

        // Fecha a declaração
        $stmt->close();

        // Retorna o resultado
        return $result;
    } else {
        // Caso a declaração falhe, retorna um erro
        die("Erro na preparação da consulta: " . $connect->error);
    }
}

// Inclua o arquivo de conexão com o banco de dados
require_once 'db_connect.php'; // Ajuste o caminho conforme necessário

// Verifica se o ID do usuário foi passado
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = intval($_GET['id']);
    $historico = buscarHistorico($connect, $userId);
} else {
    die("ID do usuário inválido.");
}
?>
