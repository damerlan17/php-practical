<?php
$title = 'Должность добавлена';
ob_start();
?>
    <div style="text-align: center; padding: 50px;">
        <h1>✓ Должность успешно добавлена!</h1>
        <p><strong>Оклад:</strong> <?= $position->base_salary ?></p>
        <p><strong>Надбавка:</strong>
            <?= $position->positionAllowance->allowance->name_allowance ?? 'не назначена' ?>
        </p>
        <a href="/positions" class="btn">Вернуться к списку</a>
        <a href="/positions/create" class="btn">Добавить ещё</a>
    </div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';