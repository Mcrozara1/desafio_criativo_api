<!DOCTYPE html>
<html>

<head>
    <title>Respostas do Desafio</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        .desafio-info {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .resposta {
            border: 1px solid #e0e0e0;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            background-color: #fff;
        }

        .resposta p {
            margin: 5px 0;
        }

        .resposta .autor {
            font-weight: bold;
            color: #555;
        }

        .resposta .conteudo {
            color: #333;
        }

        .resposta .votos {
            font-size: 0.9em;
            color: #007bff;
        }

        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #dc3545;
        }

        .actions a.vote {
            color: #28a745;
        }

        a.button-like {
            display: inline-block;
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            margin-bottom: 15px;
        }

        a.button-like:hover {
            background-color: #218838;
        }

        h1,
        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>📝 Respostas para o Desafio</h1>

    <?php if (isset($desafio) && $desafio): ?>
        <div class="desafio-info">
            <h2><?= htmlspecialchars($desafio->titulo) ?></h2>
            <p><?= nl2br(htmlspecialchars($desafio->descricao)) ?></p>
        </div>

        <p><a class="button-like" href="<?= $basePath ?>/desafios_html/<?= htmlspecialchars($desafio->id) ?>/respostas/formulario_html">Adicionar Nova Resposta</a></p>

        <h3>Respostas Enviadas:</h3>
        <?php if (isset($respostas) && !empty($respostas)): ?>
            <table>
                <tr>
                    <th>Autor</th>
                    <th>Resposta</th>
                    <th>Votos</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($respostas as $resposta): ?>
                    <tr>
                        <td><?= htmlspecialchars($resposta->autor) ?></td>
                        <td><?= nl2br(htmlspecialchars($resposta->conteudo)) ?></td>
                        <td><?= htmlspecialchars($resposta->votos) ?></td>
                        <td><?= htmlspecialchars(isset($resposta->criado_em) ? date('d/m/Y H:i', strtotime($resposta->criado_em)) : 'N/A') ?></td>
                        <td> <a class="vote" href="<?= $basePath ?>/respostas_html/<?= htmlspecialchars($resposta->id) ?>/votar_form?desafio_id=<?= htmlspecialchars($desafio->id) ?>">Votar 👍</a>
                            <a href="<?= $basePath ?>/respostas_html/<?= htmlspecialchars($resposta->id) ?>/formulario_edicao_html">Editar</a> {/* NOVO LINK */}
                            <a href="<?= $basePath ?>/respostas_html/<?= htmlspecialchars($resposta->id) ?>/excluir_form?desafio_id=<?= htmlspecialchars($desafio->id) ?>" onclick="return confirm('Tem certeza que deseja excluir esta resposta?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Nenhuma resposta ainda. Seja o primeiro!</p>
        <?php endif; ?>

    <?php else: ?>
        <p>Desafio não encontrado.</p>
    <?php endif; ?>
    <p style="margin-top: 20px;"><a href="<?= $basePath ?>/desafios_html">Voltar para Listagem de Desafios</a></p>
</body>

</html>