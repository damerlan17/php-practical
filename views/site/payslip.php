<h1>Расчётный листок сотрудника</h1>
<p><strong>Сотрудник:</strong> <?= htmlspecialchars($user->last_name . ' ' . $user->first_name . ' ' . $user->surname) ?></p>
<p><strong>Месяц:</strong> <?= htmlspecialchars($month) ?></p>

<?php if ($report): ?>
    <h3>Начисления</h3>
    <table border="1">
        <tr><th>Оклад</th><td><?= number_format($user->position->base_salary ?? 0, 2) ?> ₽</td></tr>
        <tr><th>Надбавка (<?= $user->position->positionAllowance->allowance->precent_allowance ?? 0 ?>%)</th>
            <td><?= number_format(($report->total_accued - ($user->position->base_salary ?? 0)), 2) ?> ₽</td></tr>
        <tr><th>Всего начислено</th><td><?= number_format($report->total_accued, 2) ?> ₽</td></tr>
    </table>

    <h3>Вычеты</h3>
    <table border="1">
        <tr><th>Название</th><th>Сумма</th></tr>
        <?php foreach ($deductions as $ded): ?>
            <tr><td><?= htmlspecialchars($ded->deduction_name) ?></td><td><?= number_format($ded->amount_deduction, 2) ?> ₽</td></tr>
        <?php endforeach; ?>
        <tr><th>Итого удержано</th><td><?= number_format($report->total_deducted, 2) ?> ₽</td></tr>
    </table>

    <h2>Итого к выплате: <?= number_format($report->final_sum, 2) ?> ₽</h2>
<?php else: ?>
    <h1>Тест</h1>
    <p>Month: <?= $month ?? 'нет' ?></p>
    <p>User: <?= $user->id ?? 'нет' ?></p>
    <p>Report: <?= $report ? 'есть' : 'нет' ?></p>
    <p>Расчёт за указанный месяц ещё не произведён. Пожалуйста, выполните расчёт зарплаты.</p>
    <a href="<?= app()->route->getUrl('/payroll/calculate') ?>">Перейти к расчёту</a>
<?php endif; ?>

<br>
<a href="<?= app()->route->getUrl('/payroll/reports') ?>">К отчётам</a>



<?php if (app()->auth::user()->role->role_name === 'admin'): ?>
    <h2>Выберите сотрудника</h2>
    <form method="GET">
        <select name="user_id">
            <?php foreach ($users as $u): ?>
                <option value="<?= $u->id ?>" <?= ($user->id == $u->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($u->last_name . ' ' . $u->first_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Месяц: <input type="month" name="month" value="<?= $month ?>"></label>
        <button type="submit">Показать</button>
    </form>
    <hr>
<?php endif; ?>


