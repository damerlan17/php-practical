<?php
$title = 'Управление должностями';
ob_start();
?>

<?php if (!isset($mode) || $mode === 'list'): ?>
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
                    <a href="/positions?action=edit&id=<?= $pos->position_id ?>">Ред.</a>
                    <form action="/positions?action=delete" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $pos->position_id ?>">
                        <button type="submit" onclick="return confirm('Удалить?')">Уд</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php elseif ($mode === 'create'): ?>
    <h1>Новая должность</h1>
    <form action="/positions?action=store" method="POST">
        <label>Базовый оклад:</label>
        <input type="number" step="0.01" name="base_salary" required><br>
        <label>Надбавка:</label>
        <select name="allowance_id">
            <option value="">— без надбавки —</option>
            <?php foreach ($allowances as $a): ?>
                <option value="<?= $a->allowance_id ?>"><?= htmlspecialchars($a->name_allowance) ?> (<?= $a->precent_allowance ?>)</option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit">Сохранить</button>
        <a href="/positions">Отмена</a>
    </form>

<?php elseif ($mode === 'edit'): ?>
    <h1>Редактирование должности</h1>
    <form action="/positions?action=update" method="POST">
        <input type="hidden" name="id" value="<?= $position->position_id ?>">
        <label>Базовый оклад:</label>
        <input type="number" step="0.01" name="base_salary" value="<?= $position->base_salary ?>" required><br>
        <label>Надбавка:</label>
        <select name="allowance_id">
            <option value="">— без надбавки —</option>
            <?php
            $currentAllowanceId = $position->positionAllowance->allowance_id ?? null;
            foreach ($allowances as $a): ?>
                <option value="<?= $a->allowance_id ?>" <?= ($currentAllowanceId == $a->allowance_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a->name_allowance) ?> (<?= $a->precent_allowance ?>)
                </option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit">Обновить</button>
        <a href="/positions">Отмена</a>
    </form>

<?php endif; ?>
