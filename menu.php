<?php
// ...existing code...
if (session_status() === PHP_SESSION_NONE) session_start();

include "conexao.php";
$conn = conexao();

$sql = "SELECT * FROM itens";
$stmt = $conn->query($sql);

$total_carrinho = 0;
if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $total_carrinho += $item['quantidade'];
    }
}


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
    <title>Cardápio Digital</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<header>
    <h1>Restaurante do Rafa</h1>
    <a href="index.php" style="color:white;float:right;margin-right:20px;">Admin</a>
    <a href="carrinho.php" class="carrinho-link">
        Carrinho (<?php echo $total_carrinho; ?>)
    </a>
</header>

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

<section class="cardapio">

<?php
while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
?>
    <div class="item">
        <img src="<?php echo $row['IMG_itens']; ?>" alt="foto">
        <h2><?php echo $row['NOME_itens']; ?></h2>
        <p class="desc"><?php echo $row['DCC_itens']; ?></p>
        <p class="preco">R$ <?php echo number_format($row['PRECO_itens'],2,",","."); ?></p>
        <form method="post" action="adicionar_carrinho.php">
            <input type="hidden" name="ID_itens" value="<?php echo $row['ID_itens']; ?>">
            <input type="hidden" name="NOME_itens" value="<?php echo $row['NOME_itens']; ?>">
            <input type="hidden" name="PRECO_itens" value="<?php echo $row['PRECO_itens']; ?>">
            <input type="hidden" name="IMG_itens" value="<?php echo $row['IMG_itens']; ?>">
             <button type="submit" class="btn-carrinho">Adicionar ao Carrinho</button>
        </form>
    </div>
<?php endwhile; ?>

</section>

</body>
</html>
