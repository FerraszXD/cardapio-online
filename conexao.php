<?php
function conexao() {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "cardapio";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Erro FDP na conexão: " . $conn->connect_error);
    }

    return $conn;
}
?>
