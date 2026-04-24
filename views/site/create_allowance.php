<h1>Добавить начисление</h1>
<form method="POST" action="<?= app()->route->getUrl('/allowances/store') ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
    <label>Название: <input type="text" name="name_allowance" value="<?= htmlspecialchars($old['name_allowance'] ?? '') ?>"></label><br>
    <label>Процент надбавки: <input type="number" step="0.01" name="precent_allowance" value="<?= htmlspecialchars($old['precent_allowance'] ?? '') ?>"></label><br>
    <button type="submit">Сохранить</button>
    <a href="<?= app()->route->getUrl('/allowances') ?>">Отмена</a>
</form>