
    <h1>Должности</h1>
    <a href="<?= app()->route->getUrl('/positions/create_position') ?>">+ Добавить должность</a>
    <table border="1">
        <thead>
        <tr><th>ID</th><th>Оклад</th><th>Надбавка</th><th>Действия</th></tr>
        </thead>
        <tbody>
        <?php foreach ($positions as $pos): ?>
            <tr>
                <td><?= $pos->position_id ?></td>
                <td><?= $pos->base_salary ?></td>
                <td>
                    <?php
                    $allowance = $pos->positionAllowance->allowance ?? null;
                    echo $allowance ? htmlspecialchars($allowance->name_allowance) . ' (' . $allowance->precent_allowance . ')' : '—';
                    ?>
                </td>
                <td>
                    <a href="<?= app()->route->getUrl('/positions/edit_position') ?>?id=<?= $pos->position_id ?>">Ред.</a>
                    <a href="<?= app()->route->getUrl('/positions/delete?id=' . $pos->position_id) ?>" onclick="return confirm('Удалить?')">Уд.</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
