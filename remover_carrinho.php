<?php
session_start();

if ($_POST && isset($_SESSION['carrinho'])) {
    $index = $_POST['index'];
    
    if (isset($_SESSION['carrinho'][$index])) {
        $NOME_itens = $_SESSION['carrinho'][$index]['NOME_itens'];
        unset($_SESSION['carrinho'][$index]);
        // Reindexa o array
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
        
        $_SESSION['mensagem_carrinho'] = "'$NOME_itens' removido do carrinho!";
    }
}

header("Location: carrinho.php");
exit;
?>