<?php
$title = 'Новая должность';
ob_start();
?>
    <h1>Новая должность</h1>
    <form action="<?= app()->route->getUrl('/stored') ?>" method="POST">
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