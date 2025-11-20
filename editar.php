<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php";
$conn = conexao();

$msg = '';
$item = null;

// Buscar dados do item se ID foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM itens WHERE ID_itens = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$item) {
        $msg = "Item não encontrado!";
    }
}

// Atualizar item
if ($_POST && isset($_POST['atualizar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $imagem = $_POST['imagem'];

    $sql = "UPDATE itens SET NOME_itens = ?, DCC_itens = ?, PRECO_itens = ?, IMG_itens = ? WHERE ID_itens = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$nome, $descricao, $preco, $imagem, $id])) {
        $msg = "Prato atualizado com sucesso!";
        // Atualizar dados do item
        $item = [
            'ID_itens' => $id,
            'NOME_itens' => $nome,
            'DCC_itens' => $descricao,
            'PRECO_itens' => $preco,
            'IMG_itens' => $imagem
        ];
    } else {
        $msg = "Erro ao atualizar: " . implode(", ", $stmt->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-container {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
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
        .btn-voltar {
            background: #6c757d;
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
        .preview-img {
            max-width: 200px;
            max-height: 200px;
            margin: 10px 0;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<h1>Editar Item</h1>

<div class="form-container">
    <?php if($item): ?>
        <?php if(!empty($msg)): ?>
            <div class="msg <?php echo strpos($msg, 'Erro') !== false ? 'error' : 'success'; ?>">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        
        <?php if(!empty($item['IMG_itens'])): ?>
            <div>
                <strong>Imagem atual:</strong><br>
                <img src="<?php echo $item['IMG_itens']; ?>" alt="Preview" class="preview-img" id="previewImage">
            </div>
        <?php endif; ?>
        
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $item['ID_itens']; ?>">
            
            <label for="nome">Nome do prato:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($item['NOME_itens']); ?>" required>
            
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="3"><?php echo htmlspecialchars($item['DCC_itens']); ?></textarea>
            
            <label for="preco">Preço:</label>
            <input type="number" step="0.01" id="preco" name="preco" value="<?php echo $item['PRECO_itens']; ?>" required>
            
            <label for="imagem">URL da imagem:</label>
            <input type="text" id="imagem" name="imagem" value="<?php echo $item['IMG_itens']; ?>" onchange="updatePreview()">
            
            <div style="margin-top: 15px;">
                <button type="submit" name="atualizar">Atualizar Prato</button>
                <a href="adm.php"><button type="button" class="btn-voltar">Voltar</button></a>
            </div>
        </form>
        
        <script>
            function updatePreview() {
                var url = document.getElementById('imagem').value;
                var preview = document.getElementById('previewImage');
                if (preview && url) {
                    preview.src = url;
                }
            }
        </script>
    <?php else: ?>
        <div class="msg error">
            <?php echo !empty($msg) ? $msg : "Item não encontrado!"; ?>
        </div>
        <a href="adm.php"><button type="button" class="btn-voltar">Voltar</button></a>
    <?php endif; ?>
</div>

</body>
</html>