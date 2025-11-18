<?php
include "conexao.php";
$conn = conexao();

$sql = "SELECT * FROM itens";
$stmt = $conn->query($sql);
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
</header>

<section class="cardapio">

<?php
while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
?>
    <div class="item">
        <img src="<?php echo $row['IMG_itens']; ?>" alt="foto">
        <h2><?php echo $row['NOME_itens']; ?></h2>
        <p class="desc"><?php echo $row['DCC_itens']; ?></p>
        <p class="preco">R$ <?php echo number_format($row['PRECO_itens'],2,",","."); ?></p>
    </div>
<?php endwhile; ?>

</section>

</body>
</html>
