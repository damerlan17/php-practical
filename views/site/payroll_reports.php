<h1>Среднемесячная зарплата по должностям</h1>
<table border="1">
    <tr>
        <th>Месяц</th>
        <th>Должность</th>
        <th>Средняя зарплата</th>
        <a href="<?= app()->route->getUrl('/payroll/clear') ?>"
                                    onclick="return confirm('Удалить все отчёты безвозвратно?')">Очистить</a>
    </tr>
    <?php foreach ($reports as $report): ?>
        <tr>
            <td><?= htmlspecialchars($report->month ?? '') ?></td>
            <td><?= htmlspecialchars($report->position_title ?? 'Не указана') ?></td>
            <td><?= number_format($report->avg_salary ?? 0, 2) ?> ₽</td>

        </tr>
    <?php endforeach; ?>
</table>