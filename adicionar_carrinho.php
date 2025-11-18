<?php
session_start();

if ($_POST) {
    $item = [
        'ID_itens' => $_POST['ID_itens'],
        'NOME_itens' => $_POST['NOME_itens'],
        'PRECO_itens' => $_POST['PRECO_itens'],
        'IMG_itens' => $_POST['IMG_itens'],
        'quantidade' => 1
    ];
    
    // Inicializa o carrinho se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    
    // Verifica se o item já está no carrinho
    $item_existente = false;
    foreach ($_SESSION['carrinho'] as &$carrinho_item) {
        if ($carrinho_item['ID_itens'] == $item['ID_itens']) {
            $carrinho_item['quantidade']++;
            $item_existente = true;
            $mensagem = "'$quantidade' , '$nome' adicionado(a) ao carrinho!";
            break;
        }
    }
    
    // Se não existe, adiciona ao carrinho
    if (!$item_existente) {
        $_SESSION['carrinho'][] = $item;
         $mensagem = "'$nome' adicionado(a) ao carrinho!";
    }
    
 $_SESSION['mensagem_carrinho'] = $mensagem;

    header("Location: menu.php");
    exit;
}
?>

//oi