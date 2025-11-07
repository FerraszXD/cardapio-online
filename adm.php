<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php";
$conn = conexao();

if ($_POST) {
    $nome = $_POST['NOME_itens'];
    $descricao = $_POST['DCC_itens'];
    $preco = $_POST['PRECO_itens'];
    $imagem = $_POST['IMG_itens'];

    $sql = "INSERT INTO pratos (NOME_itens, DCC_itens, PRECO_itens, IMG_itens) 
            VALUES ('$nome', '$descricao', '$preco', '$imagem')";

    if ($conn->query($sql)) {
        $msg = "Prato adicionado com sucesso carai!";
    } else {
        $msg = "Deu ruim: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel do Admin</title>
</head>
<body>

<h2>Adicionar Prato ao Cardápio</h2>

<form method="post">
    <input type="text" name="nome" placeholder="Nome do prato" required><br><br>
    <textarea name="descricao" placeholder="Descrição"></textarea><br><br>
    <input type="number" step="0.01" name="preco" placeholder="Preço" required><br><br>
    <input type="text" name="imagem" placeholder="URL da imagem"><br><br>

    <button type="submit">Cadastrar</button>
</form>

<?php if(!empty($msg)) echo "<p>$msg</p>"; ?>

<a href="menu.php">Voltar ao Cardápio</a>

</body>
</html>
