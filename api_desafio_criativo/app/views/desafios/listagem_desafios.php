<!DOCTYPE html>
<html>
<head>
    <title>Desafios Criativos</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: #007bff; }
        a:hover { text-decoration: underline; }
        .actions a { margin-right: 10px; }
        .button-like { display: inline-block; padding: 8px 12px; background-color: #28a745; color: white; border-radius: 4px; text-align: center; }
        .button-like:hover { background-color: #218838; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>🎨 Desafios Criativos</h1>
    <p><a class="button-like" href="<?= $basePath ?>/desafios/formulario_cadastro_html">Criar Novo Desafio</a></p>
    
    <?php if (isset($desafios) && !empty($desafios)): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Criado em</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($desafios as $item):?>
        <tr>
            <td><?= htmlspecialchars($item->id) ?></td>
            <td><?= htmlspecialchars($item->titulo) ?></td>
            <td><?= nl2br(htmlspecialchars($item->descricao)) ?></td>
            <td><?= htmlspecialchars(isset($item->criado_em) ? date('d/m/Y H:i', strtotime($item->criado_em)) : 'N/A') ?></td>
            <td class="actions">
                <a href="<?= $basePath ?>/desafios_html/<?= htmlspecialchars($item->id) ?>/respostas">Ver/Adicionar Respostas</a>
                <a href="<?= $basePath ?>/desafios/formulario_edicao_html/<?= htmlspecialchars($item->id) ?>">Editar</a>
                <a href="<?= $basePath ?>/desafios/excluir_html/<?= htmlspecialchars($item->id) ?>" onclick="return confirm('Tem certeza que deseja excluir este desafio e todas as suas respostas?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Nenhum desafio encontrado.</p>
    <?php endif; ?>
</body>
</html>