<?php
session_start();

if ($_POST && isset($_SESSION['carrinho'])) {
    $index = $_POST['index'];
    $action = $_POST['action'];
    
    if (isset($_SESSION['carrinho'][$index])) {
        $NOME_itens = $_SESSION['carrinho'][$index]['NOME_itens'];
        if ($action == 'increase') {
            $_SESSION['carrinho'][$index]['quantidade']++;
            $_SESSION['mensagem_carrinho'] = "Quantidade de '$NOME_itens' aumentada!";
        } elseif ($action == 'decrease') {
            if ($_SESSION['carrinho'][$index]['quantidade'] > 1) {
                $_SESSION['carrinho'][$index]['quantidade']--;
                $_SESSION['mensagem_carrinho'] = "Quantidade de '$NOME_itens' diminuída!";
            }
        }
    }
}

header("Location: carrinho.php");
exit;
?>