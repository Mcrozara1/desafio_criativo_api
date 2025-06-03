<!DOCTYPE html>
<html>
<head>
    <title>Novo Desafio</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        form label { display: block; margin-bottom: 5px; }
        form input[type="text"], form textarea { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        form button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        form button:hover { background-color: #45a049; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>🎨 Criar Novo Desafio</h1>
    <form method="POST" action="<?= $basePath ?>/desafios/salvar_form">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Título do Desafio" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" placeholder="Detalhes do Desafio" rows="5" required></textarea>

        <button type="submit">Salvar Desafio</button>
    </form>
    <p><a href="<?= $basePath ?>/desafios_html">Voltar para a Listagem</a></p>
</body>
</html>
