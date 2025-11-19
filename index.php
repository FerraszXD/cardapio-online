<?php
session_start();
include "conexao.php";
$conn = conexao();

if ($_POST) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha']; 

    
    $sql = "SELECT * FROM adm WHERE NOME_adm = ? AND SENHA_adm = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usuario, $senha]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['admin'] = true;
        header("Location: menu_adm.php");
        exit;
    } else {
        $erro = "Usuário ou senha errados, genio.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="estilo.css">
    <meta charset="UTF-8">
    <title>Login Admin</title>
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
</head>
<body>

<h2>Login do Administrador</h2>

<form method="post">
    <input type="text" name="usuario" placeholder="Usuário" required value=""><br><br>
    <input type="password" name="senha" placeholder="Senha" required value=""><br><br>
    <button type="submit">Entrar</button>
</form>

<div style="margin-top: 20px; text-align: center;">
    <h3>Entrar sem login?</h3>
    <button onclick="window.location.href='menu.php'">Clique aqui para ver o cardápio</button>
</div>

<?php if(!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

</body>
</html>