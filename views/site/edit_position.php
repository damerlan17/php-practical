<?php
$title = 'Редактирование должности';
ob_start();
?>
    <h1>Редактирование должности</h1>
    <form action="<?= app()->route->getUrl('/positions/update') ?>" method="POST">
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
