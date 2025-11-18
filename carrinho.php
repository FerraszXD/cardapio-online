<?php
session_start();
// Verificar se há mensagem para exibir
$mensagem = '';
if (isset($_SESSION['mensagem_carrinho'])) {
    $mensagem = $_SESSION['mensagem_carrinho'];
    // Limpa a mensagem para não exibir novamente
    unset($_SESSION['mensagem_carrinho']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        .carrinho-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .carrinho-item {
            display: flex;
            align-items: center;
            background: white;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        .carrinho-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }
        .carrinho-info {
            flex-grow: 1;
        }
        .carrinho-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantidade-btn {
            background: #5a1fa3;
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
        }
        .quantidade {
            font-size: 18px;
            margin: 0 10px;
        }
        .remover-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .total {
            text-align: right;
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
        }
        .empty-cart {
            text-align: center;
            padding: 40px;
            font-size: 18px;
        }
        .btn-continuar {
            background: #5a1fa3;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php if (!empty($mensagem)): ?>
    <div class="mensagem-carrinho" id="mensagemCarrinho">
        <?php echo $mensagem; ?>
    </div>
    
    <script>
        // Remove a mensagem após a animação
        setTimeout(function() {
            var mensagem = document.getElementById('mensagemCarrinho');
            if (mensagem) {
                mensagem.remove();
            }
        }, 3000);
    </script>
<?php endif; ?>

<header>
    <h1>Restaurante do Rafa - Carrinho</h1>
    <div style="float:right;">
        <a href="menu.php" style="color:white;margin-right:20px;">Voltar ao Cardápio</a>
    </div>
</header>

<div class="carrinho-container">
    <?php if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0): ?>
        <div class="empty-cart">
            <p>Seu carrinho está vazio</p>
            <a href="menu.php" class="btn-continuar">Continuar Comprando</a>
        </div>
    <?php else: ?>
        <?php
        $total = 0;
        foreach ($_SESSION['carrinho'] as $index => $item):
            $subtotal = $item['PRECO_itens'] * $item['quantidade'];
            $total += $subtotal;
        ?>
            <div class="carrinho-item">
                <img src="<?php echo $item['IMG_itens']; ?>" alt="<?php echo $item['NOME_itens']; ?>">
                <div class="carrinho-info">
                    <h3><?php echo $item['NOME_itens']; ?></h3>
                    <p>R$ <?php echo number_format($item['PRECO_itens'], 2, ',', '.'); ?></p>
                </div>
                <div class="carrinho-actions">
                    <form method="post" action="atualizar_carrinho.php" style="display:inline;">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <input type="hidden" name="action" value="decrease">
                        <button type="submit" class="quantidade-btn">-</button>
                    </form>
                    
                    <span class="quantidade"><?php echo $item['quantidade']; ?></span>
                    
                    <form method="post" action="atualizar_carrinho.php" style="display:inline;">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <input type="hidden" name="action" value="increase">
                        <button type="submit" class="quantidade-btn">+</button>
                    </form>
                    
                    <form method="post" action="remover_carrinho.php" style="display:inline;">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" class="remover-btn">Remover</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div class="total">
            Total: R$ <?php echo number_format($total, 2, ',', '.'); ?>
        </div>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="menu.php" class="btn-continuar">Continuar Comprando</a>
            <button style="background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; margin-left: 10px; cursor: pointer;">
                Finalizar Pedido
            </button>
        </div>
    <?php endif; ?>
</div>

</body>
</html>