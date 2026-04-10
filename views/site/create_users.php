<h1>Добавить пользователя</h1>
<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <?php foreach ($errors as $error): echo "<p>$error</p>"; endforeach; ?>
    </div>
<?php endif; ?>
<form method="POST" action="/users/store">
    <label>Логин: <input type="text" name="login" value="<?= htmlspecialchars($old['login'] ?? '') ?>"></label><br>
    <label>Пароль: <input type="password" name="password"></label><br>
    <label>Имя: <input type="text" name="first_name" value="<?= htmlspecialchars($old['first_name'] ?? '') ?>"></label><br>
    <label>Фамилия: <input type="text" name="last_name" value="<?= htmlspecialchars($old['last_name'] ?? '') ?>"></label><br>
    <label>Отчество: <input type="text" name="surname" value="<?= htmlspecialchars($old['surname'] ?? '') ?>"></label><br>
    <label>Роль:
        <select name="role_id">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role->id ?>" <?= ($old['role_id'] ?? '') == $role->id ? 'selected' : '' ?>><?= $role->name ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Должность:
        <select name="position_id">
            <?php foreach ($positions as $position): ?>
                <option value="<?= $position->position_id ?>"><?= $position->title ?? $position->position_id ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Документ:
        <select name="document_id">
            <?php foreach ($documents as $document): ?>
                <option value="<?= $document->id ?>"><?= $document->series_number ?? $document->id ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <button type="submit">Сохранить</button>
</form>