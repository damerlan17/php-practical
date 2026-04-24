<h1>Добавить вычет</h1>
<form method="POST" action="<?= app()->route->getUrl('/deductions/store') ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
    <label>Название вычета: <input type="text" name="deduction_name" value="<?= htmlspecialchars($old['deduction_name'] ?? '') ?>"></label><br>
    <label>Сумма (руб.): <input type="number" step="0.01" name="amount_deduction" value="<?= htmlspecialchars($old['amount_deduction'] ?? '') ?>"></label><br>
    <button type="submit">Сохранить</button>
    <a href="<?= app()->route->getUrl('/deductions') ?>">Отмена</a>
</form>