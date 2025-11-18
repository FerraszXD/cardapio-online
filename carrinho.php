<?php
session_start();

// Inicializar carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adicionar item ao carrinho
if (isset($_POST['adicionar'])) {
    $ID_itens = $_POST['ID_itens'];
    $NOME_itens = $_POST['NOME_itens'];
    $PRECO_itens = $_POST['PRECO_itens'];
    $quantidade = $_POST['quantidade'];
    
    // Verificar se o item já existe no carrinho
    $item_existente = false;
    foreach ($_SESSION['carrinho'] as &$item) {
        if ($item['ID_itens'] == $ID_itens) {
            $item['quantidade'] += $quantidade;
            $item_existente = true;
            break;
        }
    }
    
    if (!$item_existente) {
        $_SESSION['carrinho'][] = [
            'ID_itens' => $ID_itens,
            'NOME_itens' => $NOME_itens,
            'PRECO_itens' => $PRECO_itens,
            'quantidade' => $quantidade
        ];
    }
}

// Remover item do carrinho
if (isset($_GET['remover'])) {
    $id = $_GET['remover'];
    foreach ($_SESSION['carrinho'] as $key => $item) {
        if ($item['ID_itens'] == $id) {
            unset($_SESSION['carrinho'][$key]);
            break;
        }
    }
    // Reindexar array
    $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
}

// Calcular total
$total = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $total += $item['PRECO_itens'] * $item['quantidade'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <style>
        .carrinho {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px 0;
        }
        .item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .total {
            font-weight: bold;
            font-size: 1.2em;
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Seu Carrinho de Compras</h1>

    <div class="carrinho">
        <?php if (empty($_SESSION['carrinho'])): ?>
            <p>Carrinho vazio</p>
        <?php else: ?>
            <?php foreach ($_SESSION['carrinho'] as $item): ?>
                <div class="item">
                    <span><?= $item['nome'] ?></span>
                    <span>R$ <?= number_format($item['PRECO_itens'], 2, ',', '.') ?></span>
                    <span>Quantidade: <?= $item['quantidade'] ?></span>
                    <span>Subtotal: R$ <?= number_format($item['PRECO_itens'] * $item['quantidade'], 2, ',', '.') ?></span>
                    <a href="?remover=<?= $item['ID_itens'] ?>">Remover</a>
                </div>
            <?php endforeach; ?>
            
            <div class="total">
                Total: R$ <?= number_format($total, 2, ',', '.') ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Exemplo de formulário para adicionar produtos (normalmente estaria em outra página) -->
    <h2>Adicionar Produto</h2>
    <form method="post">
        <input type="hidden" name="produto_id" value="1">
        <input type="hidden" name="nome" value="Produto Exemplo">
        <input type="hidden" name="preco" value="29.90">
        Quantidade: <input type="number" name="quantidade" value="1" min="1">
        <button type="submit" name="adicionar">Adicionar ao Carrinho</button>
    </form>

</body>
</html>