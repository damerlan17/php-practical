<?php
$title = 'Список должностей';
ob_start();
?>
    <h1>Должности</h1>
    <a href="<?= app()->route->getUrl('/create_position') ?>" class="btn">+ Добавить должность</a>
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
                    <a href="<?= app()->route->getUrl('/edit_position') ?>?id=<?= $pos->position_id ?>">Ред.</a>
                    <form action="<?= app()->route->getUrl('/delete') ?>" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $pos->position_id ?>">
                        <button type="submit" onclick="return confirm('Удалить?')">Уд</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>