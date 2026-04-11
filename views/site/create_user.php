<h1>Добавить пользователя</h1>

<form method="POST" action="<?= app()->route->getUrl('/store') ?>">
    <label>Логин: <input type="text" name="login" value="<?= htmlspecialchars($old['login'] ?? '') ?>"></label><br>
    <label>Пароль: <input type="password" name="password"></label><br>
    <label>Имя: <input type="text" name="first_name" value="<?= htmlspecialchars($old['first_name'] ?? '') ?>"></label><br>
    <label>Фамилия: <input type="text" name="last_name" value="<?= htmlspecialchars($old['last_name'] ?? '') ?>"></label><br>
    <label>Отчество: <input type="text" name="surname" value="<?= htmlspecialchars($old['surname'] ?? '') ?>"></label><br>
    <label>Роль:
        <select name="role_id">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role->role_id ?>" <?= ($old['role_id'] ?? '') == $role->id ? 'selected' : '' ?>><?= $role->role_name ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Должность:
        <select name="position_id">
            <?php foreach ($positions as $position): ?>
                <option value="<?= $position->position_id ?>">Должность #<?= $position->position_id ?> (оклад <?= $position->base_salary ?>)</option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Документ:
        <input type="text" name="inn" placeholder="ИНН">
        <input type="text" name="snils" placeholder="СНИЛС">
        <input type="text" name="payment_account" placeholder="Расчётный счёт">
        <input type="text" name="tabel_name" placeholder="Табельный номер">
    </label><br>
    <button type="submit">Сохранить</button>
</form>