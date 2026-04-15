<h1>Список вычетов</h1>
<a href="<?= app()->route->getUrl('/deductions/create') ?>">Добавить вычет</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Сумма (руб.)</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($deductions as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d->deduction_id) ?></td>
            <td><?= htmlspecialchars($d->deduction_name) ?></td>
            <td><?= htmlspecialchars($d->amount_deduction) ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/deductions/edit?id=' . $d->deduction_id) ?>">Ред.</a>
                <a href="<?= app()->route->getUrl('/deductions/delete?id=' . $d->deduction_id) ?>" onclick="return confirm('Удалить?')">Уд.</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>