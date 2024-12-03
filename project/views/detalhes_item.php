<?php
include '../db_config.php';
include '../includes/Imagem';
include '../includes/Texto';
include '../includes/Comentario';
include '../includes/Pontuacao';

$database = new Database();
$db = $database->connect();

$comentario = new Comentario($db);
$pontuacao = new Pontuacao($db);

$id = $_GET['id'] ?? null; // Validação de id
$tipo = $_GET['tipo'] ?? null; // Validação de tipo
$item = null;

// Verifica se id e tipo foram informados
if ($id && $tipo) {
    if ($tipo === 'imagem') {
        $imagem = new Imagem($db);
        $item = $imagem->buscarPorId($id); // Busca imagem específica
    } elseif ($tipo === 'texto') {
        $texto = new Texto($db);
        $item = $texto->buscarPorId($id); // Busca texto específico
    }
}

// Processar comentários
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario'])) {
    if ($comentario->inserir($id, $tipo, $_POST['comentario'])) {
        echo "<p>Comentário adicionado com sucesso!</p>";
    } else {
        echo "<p>Erro ao adicionar comentário.</p>";
    }
}

// Processar pontuação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pontuacao'])) {
    if ($pontuacao->adicionar($id, $tipo, $_POST['pontuacao'])) {
        echo "<p>Pontuação registrada com sucesso!</p>";
    } else {
        echo "<p>Erro ao registrar pontuação.</p>";
    }
}

// Listar comentários
$comentarios = $comentario->listar($id, $tipo);

// Obter pontuação total
$pontuacao_total = $pontuacao->listar($id, $tipo);  // Pegando soma e quantidade

// Calcular a média, se houver pontuações
if ($pontuacao_total['quantidade'] > 0) {
    $media_pontuacao = $pontuacao_total['soma_pontuacao'] / $pontuacao_total['quantidade'];
} else {
    $media_pontuacao = 0;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Item</title>
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

        .share-button {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #eaeaea;
            padding: 10px 15px;
            background-color: #00adb5;
            border-radius: 5px;
        }

        .share-button:hover {
            background-color: #007f8c;
            color: #eaeaea;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Botão para voltar -->
        <a href="index.php" class="back-button">Voltar</a>

        <h1>Detalhes do Item</h1>

        <!-- Exibe os detalhes do item -->
        <?php if ($item): ?>
            <h2><?= $tipo === 'imagem' && isset($item['nome']) ? $item['nome'] : ($item['titulo'] ?? 'Sem título') ?></h2>
            <?php if ($tipo === 'imagem' && isset($item['caminho'])): ?>
                <img src="<?= $item['caminho'] ?>" alt="<?= $item['nome'] ?? 'Imagem sem nome' ?>" width="300">
            <?php elseif ($tipo === 'texto' && isset($item['conteudo'])): ?>
                <p><?= $item['conteudo'] ?></p>
            <?php else: ?>
                <p>Conteúdo não disponível.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Item não encontrado.</p>
        <?php endif; ?>

        <!-- Formulário de comentários -->
        <h3>Comentários</h3>
        <form method="POST">
            <textarea name="comentario" placeholder="Deixe um comentário..." required></textarea>
            <button type="submit">Enviar</button>
        </form>
        <ul>
            <?php if ($comentarios && is_array($comentarios)): ?>
                <?php foreach ($comentarios as $com): ?>
                    <li><?= htmlspecialchars($com['comentario']) ?> - 
                        <small><?= htmlspecialchars($com['data_comentario']) ?></small>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Nenhum comentário encontrado.</li>
            <?php endif; ?>
        </ul>

        <!-- Formulário de pontuação -->
        <h3>Pontuação</h3>
        <form method="POST">
            <input type="number" name="pontuacao" min="1" max="5" placeholder="Nota (1-5)" required>
            <button type="submit">Enviar</button>
        </form>

        <p>Pontuação média: <?= $media_pontuacao > 0 ? number_format($media_pontuacao, 2) : 'Nenhuma pontuação registrada' ?></p>
        <!-- Botão de Compartilhar -->
        <button class="share-button" onclick="copyLink()">Compartilhar</button>
        <p id="copiedMessage">Link copiado com sucesso!</p>
    </div>
    <script>
        function copyLink() {
            var link = window.location.href; // Obtém o URL atual
            navigator.clipboard.writeText(link) // Copia o link para a área de transferência
                .then(function() {
                    // Exibe a mensagem de confirmação
                    var message = document.getElementById('copiedMessage');
                    message.style.display = 'block'; // Exibe a mensagem
                    setTimeout(function() {
                        message.style.display = 'none'; // Esconde a mensagem após 3 segundos
                    }, 3000);
                })
                .catch(function(error) {
                    console.error('Erro ao copiar o link: ', error);
                });
        }
    </script>
</body>
</html>
