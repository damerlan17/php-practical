<h1>Добавить начисление</h1>
<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form method="POST" action="<?= app()->route->getUrl('/allowances/store') ?>">
    <label>Название: <input type="text" name="name_allowance" value="<?= htmlspecialchars($old['name_allowance'] ?? '') ?>"></label><br>
    <label>Процент надбавки: <input type="number" step="0.01" name="precent_allowance" value="<?= htmlspecialchars($old['precent_allowance'] ?? '') ?>"></label><br>
    <button type="submit">Сохранить</button>
    <a href="<?= app()->route->getUrl('/allowances') ?>">Отмена</a>
</form>