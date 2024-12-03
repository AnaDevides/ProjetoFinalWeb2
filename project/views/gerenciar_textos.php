<?php
include '../db_config.php';
include '../includes/Texto';

$database = new Database();
$db = $database->connect();
$texto = new Texto($db);

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        $acao = $_POST['acao'];

        if ($acao === 'inserir') {
            $titulo = $_POST['titulo'];
            $conteudo = $_POST['conteudo'];
            $texto->inserir($titulo, $conteudo);
            echo "Texto adicionado com sucesso!";
        } elseif ($acao === 'deletar') {
            $texto->deletar($_POST['id']);
            echo "Texto deletado com sucesso!";
        }
    }
}

// Listar textos
$textos = $texto->listar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Textos</title>
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

        form {
            margin-bottom: 20px;
        }

        input, textarea, button {
            padding: 10px;
            margin: 5px;
            border: 1px solid #00adb5;
            border-radius: 5px;
            background-color: #393e46;
            color: #eaeaea;
            width: 100%;
            box-sizing: border-box;
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
            flex-direction: column;
            align-items: center;
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

        textarea {
            height: 150px;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Botão para voltar -->
        <a href="index.php" class="back-button">Voltar</a>

        <h1>Gerenciar Textos</h1>

        <!-- Formulário para inserir texto -->
        <h2>Adicionar Texto</h2>
        <form method="POST">
            <input type="hidden" name="acao" value="inserir">
            <input type="text" name="titulo" placeholder="Título" required>
            <textarea name="conteudo" placeholder="Conteúdo do texto" required></textarea>
            <button type="submit">Adicionar</button>
        </form>

        <!-- Listagem de textos -->
        <h2>Textos Cadastrados</h2>
        <ul>
            <?php foreach ($textos as $txt): ?>
                <li>
                    <h3><?= $txt['titulo'] ?></h3>
                    <p><?= $txt['conteudo'] ?></p>
                    <form method="POST">
                        <input type="hidden" name="acao" value="deletar">
                        <input type="hidden" name="id" value="<?= $txt['id'] ?>">
                        <button type="submit">Deletar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
