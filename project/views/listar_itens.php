<?php
include '../db_config.php';
include '../includes/Imagem';
include '../includes/Texto';

$database = new Database();
$db = $database->connect();
$imagem = new Imagem($db);
$texto = new Texto($db);

$imagens = $imagem->listar();
$textos = $texto->listar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Itens</title>
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

        h2, h3 {
            color: #eaeaea;
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
            flex-direction: column;
            align-items: center;
        }

        a {
            text-decoration: none;
            color: #00adb5;
            margin-top: 10px;
            padding: 5px 10px;
            border: 1px solid #00adb5;
            border-radius: 5px;
        }

        a:hover {
            background-color: #00adb5;
            color: #222831;
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

        <h1>Listar Itens</h1>

        <h2>Imagens</h2>
        <ul>
            <?php foreach ($imagens as $img): ?>
                <li>
                    <img src="<?= $img['caminho'] ?>" alt="<?= $img['nome'] ?>" width="100">
                    <p><?= $img['nome'] ?></p>
                    <a href="detalhes_item.php?id=<?= $img['id'] ?>&tipo=imagem">Ver detalhes</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>Textos</h2>
        <ul>
            <?php foreach ($textos as $txt): ?>
                <li>
                    <h3><?= $txt['titulo'] ?></h3>
                    <p><?= $txt['conteudo'] ?></p>
                    <a href="detalhes_item.php?id=<?= $txt['id'] ?>&tipo=texto">Ver detalhes</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
