<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php";
$conn = conexao();

if ($_POST) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $imagem = $_POST['imagem'];

    // Correção: usar PDO prepared statements
    $sql = "INSERT INTO itens (NOME_itens, DCC_itens, PRECO_itens, IMG_itens) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$nome, $descricao, $preco, $imagem])) {
        $msg = "Prato adicionado com sucesso carai!";
    } else {
        $msg = "Deu ruim: " . implode(", ", $stmt->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel do Admin</title>
</head>
<style>
        body {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        form {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }
        button {
            background: #5a1fa3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }
    </style>
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