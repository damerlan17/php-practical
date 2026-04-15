<h1>Расчёт зарплаты за месяц</h1>
<form method="POST">
    <label>Выберите месяц: <input type="month" name="month" required></label><br>
    <button type="submit">Рассчитать</button>
</form>
<a href="<?= app()->route->getUrl('/payroll/reports') ?>">Посмотреть отчёты</a>