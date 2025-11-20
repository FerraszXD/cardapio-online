<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php";
$conn = conexao();

// Adicionar novo item
if ($_POST && isset($_POST['adicionar'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $imagem = $_POST['imagem'];

    $sql = "INSERT INTO itens (NOME_itens, DCC_itens, PRECO_itens, IMG_itens) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$nome, $descricao, $preco, $imagem])) {
        $msg = "Prato adicionado com sucesso!";
    } else {
        $msg = "Erro: " . implode(", ", $stmt->errorInfo());
    }
}

// Verificar mensagem de exclusão
if (isset($_SESSION['msg_adm'])) {
    $msg = $_SESSION['msg_adm'];
    unset($_SESSION['msg_adm']);
}


// Buscar todos os itens
$sql_itens = "SELECT * FROM itens ORDER BY ID_itens";
$stmt_itens = $conn->query($sql_itens);
$itens = $stmt_itens->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel do Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            display: flex;
            gap: 30px;
        }
        .form-section, .list-section {
            flex: 1;
        }
        .form-section {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
        }
        .list-section {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
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
        .btn-editar {
            background: #28a745;
        }
        .btn-excluir {
            background: #dc3545;
        }
        .item-list {
            margin-top: 20px;
        }
        .item-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: white;
        }
        .item-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            float: left;
            margin-right: 15px;
        }
        .item-info {
            overflow: hidden;
        }
        .item-actions {
            margin-top: 10px;
            text-align: right;
        }
        .msg {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<h1>Painel do Administrador</h1>

<div class="container">
    <div class="form-section">
        <h2>Adicionar Novo Prato</h2>
        <form method="post">
            <input type="text" name="nome" placeholder="Nome do prato" required><br>
            <textarea name="descricao" placeholder="Descrição" rows="3"></textarea><br>
            <input type="number" step="0.01" name="preco" placeholder="Preço" required><br>
            <input type="text" name="imagem" placeholder="URL da imagem"><br>
            <button type="submit" name="adicionar">Cadastrar Prato</button>
        </form>
        
        <?php if(!empty($msg)): ?>
            <div class="msg <?php echo strpos($msg, 'Erro') !== false ? 'error' : 'success'; ?>">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 20px;">
            <a href="menu_adm.php" style="color: #5a1fa3;">voltar</a>
        </div>
    </div>

    <div class="list-section">
        <h2>Pratos Cadastrados</h2>
        
        <?php if(count($itens) > 0): ?>
            <div class="item-list">
                <?php foreach($itens as $item): ?>
                    <div class="item-card">
                        <img src="<?php echo $item['IMG_itens']; ?>" alt="<?php echo $item['NOME_itens']; ?>">
                        <div class="item-info">
                            <h3><?php echo $item['NOME_itens']; ?></h3>
                            <p><?php echo $item['DCC_itens']; ?></p>
                            <p><strong>R$ <?php echo number_format($item['PRECO_itens'], 2, ',', '.'); ?></strong></p>
                            <div class="item-actions">
                                <a href="editar.php?id=<?php echo $item['ID_itens']; ?>">
                                    <button class="btn-editar">Editar</button>
                                </a>
                                <a href="apagar.php?id=<?php echo $item['ID_itens']; ?>" onclick="return confirm('Tem certeza que deseja excluir este item?')">
                                    <button class="btn-excluir">Excluir</button>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nenhum prato cadastrado ainda.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>