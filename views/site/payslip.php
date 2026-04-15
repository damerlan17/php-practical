<h1>Расчётный листок сотрудника</h1>
<p><strong>Сотрудник:</strong> <?= htmlspecialchars($user->last_name . ' ' . $user->first_name) ?></p>
<p><strong>Месяц:</strong> <?= htmlspecialchars($month) ?></p>
<?php if ($report): ?>
    <p><strong>Начислено:</strong> <?= number_format($report->total_accued, 2) ?> ₽</p>
    <p><strong>Удержано (вычеты):</strong> <?= number_format($report->total_deducted, 2) ?> ₽</p>
    <p><strong>Итого к выплате:</strong> <?= number_format($report->final_sum, 2) ?> ₽</p>
<?php else: ?>
    <p>За выбранный месяц расчёт ещё не произведён.</p>
<?php endif; ?>
<a href="/payroll/calculate">Рассчитать зарплату</a>