<?php
session_start();
include "conexao.php";
$conn = conexao();

if ($_POST) {
    $usuario = $_POST['usuario'];
    $senha = md5($_POST['senha']);

    $sql = "SELECT * FROM admin WHERE NOME_adm='$usuario' AND SENHA_adm='$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = true;
        header("Location: adm.php");
        exit;
    } else {
        $erro = "Usuário ou senha errados, genio.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
</head>
<body>

<h2>Login do Administrador</h2>

<form method="post">
    <input type="text" name="usuario" placeholder="Usuário" required><br><br>
    <input type="password" name="senha" placeholder="Senha" required><br><br>
    <button type="submit">Entrar</button>
</form>

<?php if(!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

</body>
</html>
