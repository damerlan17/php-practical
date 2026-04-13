<h1>Список начислений (надбавок)</h1>
<a href="<?= app()->route->getUrl('/allowances/create') ?>">Добавить начисление</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Процент (%)</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($allowances as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a->allowance_id) ?></td>
            <td><?= htmlspecialchars($a->name_allowance) ?></td>
            <td><?= htmlspecialchars($a->precent_allowance) ?>%</td>
            <td>
                <a href="<?= app()->route->getUrl('/allowances/edit?id=' . $a->allowance_id) ?>">Ред.</a>
                <a href="<?= app()->route->getUrl('/allowances/delete?id=' . $a->allowance_id) ?>" onclick="return confirm('Удалить?')">Уд.</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>