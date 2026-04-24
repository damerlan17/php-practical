<h1>Редактировать начисление</h1>
<form method="POST" action="<?= app()->route->getUrl('/allowances/update') ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
    <input type="hidden" name="id" value="<?= $allowance->allowance_id ?>">
    <label>Название: <input type="text" name="name_allowance" value="<?= htmlspecialchars($allowance->name_allowance) ?>"></label><br>
    <label>Процент надбавки: <input type="number" step="0.01" name="precent_allowance" value="<?= htmlspecialchars($allowance->precent_allowance) ?>"></label><br>
    <button type="submit">Обновить</button>
    <a href="<?= app()->route->getUrl('/allowances') ?>">Отмена</a>
</form>