
    <h2><?= htmlspecialchars($message ?? 'Ваш профиль') ?></h2>

    <p><strong>Фамилия:</strong> <?= htmlspecialchars(app()->auth::user()->last_name ?? '—') ?></p>
    <p><strong>Имя:</strong> <?= htmlspecialchars(app()->auth::user()->first_name ?? '—') ?></p>
    <p><strong>Отчество:</strong> <?= htmlspecialchars(app()->auth::user()->surname ?? '—') ?></p>

    <p>Роль: <?= htmlspecialchars($role->role_name ?? 'не назначена') ?></p>
    <h2>Ваши документы:</h2>
    <?php
    $doc = app()->auth::user()->document; // предполагается связь document()
    if ($doc): ?>
        <p><strong>ИНН:</strong> <?= htmlspecialchars($doc->inn ?? '—') ?></p>
        <p><strong>СНИЛС:</strong> <?= htmlspecialchars($doc->snils ?? '—') ?></p>
        <p><strong>Расчетный счет:</strong> <?= htmlspecialchars($doc->payment_account ?? '—') ?></p>
        <p><strong>Табельный номер:</strong> <?= htmlspecialchars($doc->tabel_name ?? '—') ?></p>
    <?php else: ?>
        <p>Документы не заполнены.</p>
    <?php endif; ?>

    <a href="<?= app()->route->getUrl('/edit') ?>" class="edit-link">Редактировать документы</a>
