<h1>Личный кабинет</h1>

<div class="profile-card">
    <h2><?= htmlspecialchars($user->last_name . ' ' . $user->first_name . ' ' . $user->surname) ?></h2>
    <p><strong>Логин:</strong> <?= htmlspecialchars($user->login) ?></p>
    <p><strong>Роль:</strong> <?= htmlspecialchars($role->role_name ?? 'не назначена') ?></p>
    <p><strong>Должность:</strong>
        <?php if ($user->position): ?>
            <?= htmlspecialchars($user->position->title ?? 'Должность #' . $user->position->position_id) ?>
            (оклад <?= number_format($user->position->base_salary, 2) ?> ₽)
        <?php else: ?>
            не назначена
        <?php endif; ?>
    </p>
</div>

<div class="profile-card">
    <h3>Документы</h3>
    <?php $doc = $user->document; ?>
    <?php if ($doc): ?>
        <p><strong>ИНН:</strong> <?= htmlspecialchars($doc->inn ?? '—') ?></p>
        <p><strong>СНИЛС:</strong> <?= htmlspecialchars($doc->snils ?? '—') ?></p>
        <p><strong>Расчётный счёт:</strong> <?= htmlspecialchars($doc->payment_account ?? '—') ?></p>
        <p><strong>Табельный номер:</strong> <?= htmlspecialchars($doc->tabel_name ?? '—') ?></p>
    <?php else: ?>
        <p>Документы не заполнены.</p>
    <?php endif; ?>
    <a href="<?= app()->route->getUrl('/edit') ?>" class="btn btn-sm">Редактировать документы</a>
</div>

<div class="profile-card">
    <h3>Постоянные вычеты</h3>
    <?php if ($user->deductions && count($user->deductions) > 0): ?>
        <ul>
            <?php foreach ($user->deductions as $deduction): ?>
                <li><?= htmlspecialchars($deduction->deduction_name) ?> — <?= number_format($deduction->amount_deduction, 2) ?> ₽</li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Нет постоянных вычетов.</p>
    <?php endif; ?>
</div>

<div class="profile-card">
    <h3>Действия</h3>
    <a href="<?= app()->route->getUrl('/edit') ?>" class="btn">Редактировать профиль</a>
    <a href="<?= app()->route->getUrl('/payroll/calculate') ?>" class="btn">Рассчитать зарплату</a>
    <a href="<?= app()->route->getUrl('/payroll/reports') ?>" class="btn">Мои отчёты</a>
</div>