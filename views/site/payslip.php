<h1>Среднемесячная зарплата по должностям</h1>
<table border="1">
    <tr>
        <th>Месяц</th>
        <th>Должность</th>
        <th>Средняя зарплата</th>
    </tr>
    <?php foreach ($reports as $report): ?>
        <tr>
            <td><?= htmlspecialchars($report->month) ?></td>
            <td><?= htmlspecialchars($report->user->position->title ?? 'Не указана') ?></td>
            <td><?= number_format($report->avg_salary, 2) ?> ₽</td>
        </tr>
    <?php endforeach; ?>
</table>