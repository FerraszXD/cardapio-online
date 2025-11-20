<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php";
$conn = conexao();

$msg = '';

// Deletar item se ID foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Verificar se o item existe
    $sql_check = "SELECT * FROM itens WHERE ID_itens = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->execute([$id]);
    $item = $stmt_check->fetch(PDO::FETCH_ASSOC);
    
    if ($item) {
        // Deletar o item
        $sql = "DELETE FROM itens WHERE ID_itens = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute([$id])) {
            $msg = "Item excluído com sucesso!";
        } else {
            $msg = "Erro ao excluir: " . implode(", ", $stmt->errorInfo());
        }
    } else {
        $msg = "Item não encontrado!";
    }
} else {
    $msg = "ID do item não especificado!";
}

// Redirecionar de volta para o painel admin com mensagem
$_SESSION['msg_adm'] = $msg;
header("Location: adm.php");
exit;
?>