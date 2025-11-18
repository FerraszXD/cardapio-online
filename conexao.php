<?php
function conexao() {
    $dns = "mysql:host=localhost;dbname=cardapio;charset=utf8";
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO($dns, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo; // Faltava este return
    } catch (PDOException $erro) {
        die("Falha na conexão: " . $erro->getMessage());
    }
}
?>
