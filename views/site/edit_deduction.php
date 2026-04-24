<h1>Редактировать вычет</h1>
<form method="POST" action="<?= app()->route->getUrl('/deductions/update') ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
    <input type="hidden" name="id" value="<?= $deduction->deduction_id ?>">
    <label>Название вычета: <input type="text" name="deduction_name" value="<?= htmlspecialchars($deduction->deduction_name) ?>"></label><br>
    <label>Сумма (руб.): <input type="number" step="0.01" name="amount_deduction" value="<?= htmlspecialchars($deduction->amount_deduction) ?>"></label><br>
    <button type="submit">Обновить</button>
    <a href="<?= app()->route->getUrl('/deductions') ?>">Отмена</a>
</form>