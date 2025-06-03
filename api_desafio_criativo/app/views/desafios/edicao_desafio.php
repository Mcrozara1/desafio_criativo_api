<!DOCTYPE html>
<html>
<head>
    <title>Editar Desafio</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        form label { display: block; margin-bottom: 5px; }
        form input[type="text"], form textarea { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        form button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        form button:hover { background-color: #0069d9; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>✏️ Editar Desafio</h1>
    <?php if (isset($desafio) && $desafio): ?>
    <form method="POST" action="<?= $basePath ?>/desafios/atualizar_form/<?= htmlspecialchars($desafio->id) ?>">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($desafio->titulo) ?>" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="5" required><?= htmlspecialchars($desafio->descricao) ?></textarea>

        <button type="submit">Atualizar Desafio</button>
    </form>
    <?php else: ?>
        <p>Desafio não encontrado.</p>
    <?php endif; ?>
    <p><a href="<?= $basePath ?>/desafios_html">Voltar para a Listagem</a></p>
</body>
</html>