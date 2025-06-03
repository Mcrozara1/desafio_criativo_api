<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Resposta</title>
     <style>
        body { font-family: sans-serif; margin: 20px; }
        form label { display: block; margin-bottom: 5px; }
        form input[type="text"], form textarea { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        form button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        form button:hover { background-color: #45a049; }
        h1, h2 { color: #333; }
        .desafio-info { background-color: #f9f9f9; border: 1px solid #eee; padding: 15px; margin-bottom: 20px; border-radius: 4px;}
    </style>
</head>
<body>
    <h1>⭐ Submeter Resposta</h1>

    <?php if (isset($desafio) && $desafio): ?>
        <div class="desafio-info">
            <h2>Desafio: <?= htmlspecialchars($desafio->titulo) ?></h2>
            <p><?= nl2br(htmlspecialchars($desafio->descricao)) ?></p>
        </div>

        <form method="POST" action="<?= $basePath ?>/desafios_html/<?= htmlspecialchars($desafio->id) ?>/respostas/salvar_form">
            <input type="hidden" name="desafio_id" value="<?= htmlspecialchars($desafio->id) ?>">
            
            <label for="autor">Seu Nome/Apelido:</label>
            <input type="text" id="autor" name="autor" placeholder="Autor da Resposta" required>

            <label for="conteudo">Sua Resposta:</label>
            <textarea id="conteudo" name="conteudo" placeholder="Escreva sua resposta criativa aqui" rows="5" required></textarea>

            <button type="submit">Enviar Resposta</button>
        </form>
    <?php else: ?>
        <p>Desafio não encontrado ou não especificado.</p>
    <?php endif; ?>
    <p><a href="<?= $basePath ?>/desafios_html/<?= isset($desafio) ? htmlspecialchars($desafio->id) : '' ?>/respostas">Voltar para Respostas do Desafio</a></p>
    <p><a href="<?= $basePath ?>/desafios_html">Voltar para Listagem de Desafios</a></p>
</body>
</html>