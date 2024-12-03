<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Web</title>
    <style>
        /* Configurações globais */
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a2e; /* Fundo escuro */
            color: #eaeaea; /* Texto claro */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container principal */
        .container {
            text-align: center;
            padding: 20px;
            border: 1px solid #4e4e60; /* Borda mais escura */
            border-radius: 10px;
            background-color: #222831; /* Fundo da área central */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra para destacar */
            max-width: 600px;
            width: 100%;
        }

        h1 {
            font-size: 2rem;
            color: #00adb5; /* Azul claro */
            margin-bottom: 20px;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            margin: 15px 0;
        }

        nav ul li a {
            display: inline-block;
            text-decoration: none;
            color: #ffffff;
            font-weight: bold;
            font-size: 1.2rem;
            padding: 10px 20px;
            border: 2px solid #00adb5; /* Borda azul */
            border-radius: 5px;
            transition: all 0.3s ease;
            background-color: #393e46; /* Fundo do link */
        }

        nav ul li a:hover {
            background-color: #00adb5;
            color: #222831;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Sistema Web</h1>
        <nav>
            <ul>
                <li><a href="gerenciar_imagens.php">Gerenciar Imagens</a></li>
                <li><a href="gerenciar_textos.php">Gerenciar Textos</a></li>
                <li><a href="listar_itens.php">Listar Itens</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
