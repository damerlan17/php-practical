<?php
$title = 'Редактирование пользователя';
ob_start();
?>
    <h1>Редактирование пользователя</h1>

<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

    <form action="/users/update" method="POST">
        <input type="hidden" name="id" value="<?= $editUser->id ?>">

        <label>Логин:</label>
        <input type="text" name="login" value="<?= htmlspecialchars($editUser->login) ?>" required><br>

        <label>Новый пароль (оставьте пустым, если не менять):</label>
        <input type="password" name="password"><br>

        <label>Фамилия:</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($editUser->last_name) ?>"><br>

        <label>Имя:</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($editUser->first_name) ?>" required><br>

        <label>Отчество:</label>
        <input type="text" name="surname" value="<?= htmlspecialchars($editUser->surname) ?>"><br>

        <label>Роль:</label>
        <select name="role_id" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role->role_id ?>" <?= ($editUser->role_id == $role->role_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($role->role_name) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Должность:</label>
        <select name="position_id">
            <option value="">— нет —</option>
            <?php foreach ($positions as $pos): ?>
                <option value="<?= $pos->position_id ?>" <?= ($editUser->position_id == $pos->position_id) ? 'selected' : '' ?>>
                    Должность #<?= $pos->position_id ?> (оклад <?= $pos->base_salary ?>)
                </option>
            <?php endforeach; ?>
        </select><br>

        <hr>
        <h3>Документы</h3>
        <?php $doc = $editUser->document; ?>
        <label>ИНН:</label>
        <input type="text" name="inn" value="<?= htmlspecialchars($doc->inn ?? '') ?>"><br>
        <label>СНИЛС:</label>
        <input type="text" name="snils" value="<?= htmlspecialchars($doc->snils ?? '') ?>"><br>
        <label>Расчётный счёт:</label>
        <input type="text" name="payment_account" value="<?= htmlspecialchars($doc->payment_account ?? '') ?>"><br>
        <label>Табельный номер:</label>
        <input type="text" name="tabel_name" value="<?= htmlspecialchars($doc->tabel_name ?? '') ?>"><br>

        <button type="submit">Обновить</button>
        <a href="/users">Отмена</a>
    </form>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';