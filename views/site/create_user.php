<h1>Добавить пользователя</h1>
<?php if (!empty($errors)): ?>
    <div style="color:red; border:1px solid red; padding:10px; margin:10px 0;">
        <?php foreach ($errors as $field => $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
                <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?= app()->route->getUrl('/users/store') ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
    <label>Логин: <input type="text" name="login" value="<?= htmlspecialchars($old['login'] ?? '') ?>"></label><br>
    <label>Пароль: <input type="password" name="password"></label><br>
    <label>Имя: <input type="text" name="first_name" value="<?= htmlspecialchars($old['first_name'] ?? '') ?>"></label><br>
    <label>Фамилия: <input type="text" name="last_name" value="<?= htmlspecialchars($old['last_name'] ?? '') ?>"></label><br>
    <label>Отчество: <input type="text" name="surname" value="<?= htmlspecialchars($old['surname'] ?? '') ?>"></label><br>
    <label>Роль:
        <select name="role_id">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role->role_id ?>" <?= (($old['role_id'] ?? '') == $role->role_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($role->role_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Должность:
        <select name="position_id">
            <option value="">— нет —</option>
            <?php foreach ($positions as $pos): ?>
                <option value="<?= $pos->position_id ?>" <?= (($old['position_id'] ?? '') == $pos->position_id) ? 'selected' : '' ?>>
                    Должность #<?= $pos->position_id ?> (оклад <?= htmlspecialchars($pos->base_salary) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <h3>Документы</h3>
    <label>ИНН: <input type="text" name="inn" value="<?= htmlspecialchars($old['inn'] ?? '') ?>"></label><br>
    <label>СНИЛС: <input type="text" name="snils" value="<?= htmlspecialchars($old['snils'] ?? '') ?>"></label><br>
    <label>Расчётный счёт: <input type="text" name="payment_account" value="<?= htmlspecialchars($old['payment_account'] ?? '') ?>"></label><br>
    <label>Табельный номер: <input type="text" name="tabel_name" value="<?= htmlspecialchars($old['tabel_name'] ?? '') ?>"></label><br>
    <button type="submit">Сохранить</button>
    <a href="<?= app()->route->getUrl('/users') ?>">Отмена</a>
</form>