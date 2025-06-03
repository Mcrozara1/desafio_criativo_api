<!DOCTYPE html>
<html>
<head>
    <title>Editar Resposta</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        form label { display: block; margin-bottom: 5px; }
        form input[type="text"], form textarea { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        form button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        form button:hover { background-color: #0069d9; }
        h1 { color: #333; }
        .info-desafio { background-color: #f0f0f0; padding: 10px; margin-bottom: 15px; border-left: 3px solid #007bff; }
    </style>
</head>
<body>
    <h1>✏️ Editar Resposta</h1>

    <?php if (isset($resposta) && $resposta && isset($desafio) && $desafio): ?>
        <div class="info-desafio">
            <p><strong>Desafio:</strong> <?= htmlspecialchars($desafio->titulo) ?></p>
        </div>

        <form method="POST" action="<?= $basePath ?>/respostas_html/<?= htmlspecialchars($resposta->id) ?>/atualizar_form?desafio_id=<?= htmlspecialchars($desafio->id) ?>">
            <input type="hidden" name="id_resposta" value="<?= htmlspecialchars($resposta->id) ?>">
            <input type="hidden" name="desafio_id" value="<?= htmlspecialchars($desafio->id) ?>"> {/* Para redirecionamento e contexto */}

            <label for="autor">Seu Nome/Apelido:</label>
            <input type="text" id="autor" name="autor" value="<?= htmlspecialchars($resposta->autor) ?>" required>

            <label for="conteudo">Sua Resposta:</label>
            <textarea id="conteudo" name="conteudo" rows="5" required><?= htmlspecialchars($resposta->conteudo) ?></textarea>

            <button type="submit">Atualizar Resposta</button>
        </form>
    <?php elseif (isset($resposta) && !$resposta): ?>
        <p>Resposta não encontrada.</p>
    <?php else: ?>
        <p>Informações da resposta ou do desafio não disponíveis.</p>
    <?php endif; ?>

    <p style="margin-top: 20px;">
        <?php if (isset($desafio) && $desafio): ?>
            <a href="<?= $basePath ?>/desafios_html/<?= htmlspecialchars($desafio->id) ?>/respostas">Voltar para Respostas do Desafio</a> |
        <?php endif; ?>
        <a href="<?= $basePath ?>/desafios_html">Voltar para Listagem de Desafios</a>
    </p>
</body>
</html>
