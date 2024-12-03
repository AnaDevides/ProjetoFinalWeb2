<?php
include '../db_config.php';
include '../includes/Imagem';

$database = new Database();
$db = $database->connect();
$imagem = new Imagem($db);

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        $acao = $_POST['acao'];

        if ($acao === 'inserir') {
            $nome = $_POST['nome'];
            $caminho = '../uploads/' . $_FILES['imagem']['name'];

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
                $imagem->inserir($nome, $caminho);
                echo "Imagem cadastrada com sucesso!";
            } else {
                echo "Erro ao fazer upload da imagem.";
            }
        } elseif ($acao === 'deletar') {
            $imagem->deletar($_POST['id']);
            echo "Imagem deletada com sucesso!";
        }
    }
}

// Listar imagens
$imagens = $imagem->listar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Imagens</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a2e; /* Fundo escuro */
            color: #eaeaea; /* Texto claro */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            text-align: center;
            padding: 20px;
            background-color: #222831; /* Fundo da área */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra */
            max-width: 800px;
            width: 100%;
        }

        h1 {
            color: #00adb5;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        input, button {
            padding: 10px;
            margin: 5px;
            border: 1px solid #00adb5;
            border-radius: 5px;
            background-color: #393e46;
            color: #eaeaea;
        }

        button {
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #00adb5;
            color: #222831;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin: 15px 0;
            padding: 10px;
            background-color: #393e46;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        img {
            border-radius: 5px;
            margin-right: 10px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #eaeaea;
            padding: 10px 15px;
            background-color: #00adb5;
            border-radius: 5px;
            border: none;
        }

        .back-button:hover {
            background-color: #007f8c;
            color: #eaeaea;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Botão para voltar -->
        <a href="index.php" class="back-button">Voltar</a>

        <h1>Gerenciar Imagens</h1>

        <!-- Formulário para inserir imagem -->
        <h2>Adicionar Imagem</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="acao" value="inserir">
            <input type="text" name="nome" placeholder="Nome da imagem" required>
            <input type="file" name="imagem" required>
            <button type="submit">Adicionar</button>
        </form>

        <!-- Listagem de imagens -->
        <h2>Imagens Cadastradas</h2>
        <ul>
            <?php foreach ($imagens as $img): ?>
                <li>
                    <img src="<?= $img['caminho'] ?>" alt="<?= $img['nome'] ?>" width="100">
                    <p><?= $img['nome'] ?></p>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="acao" value="deletar">
                        <input type="hidden" name="id" value="<?= $img['id'] ?>">
                        <button type="submit">Deletar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
