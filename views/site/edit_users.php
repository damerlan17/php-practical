<h1>Редактировать пользователя: <?= htmlspecialchars($user->login) ?></h1>
<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <?php foreach ($errors as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form method="POST" action="/users/update/<?= $user->id ?>">
    <label>Логин: <input type="text" name="login" value="<?= htmlspecialchars($user->login) ?>"></label><br>
    <label>Новый пароль (оставьте пустым, если не менять): <input type="password" name="password"></label><br>
    <label>Имя: <input type="text" name="first_name" value="<?= htmlspecialchars($user->first_name) ?>"></label><br>
    <label>Фамилия: <input type="text" name="last_name" value="<?= htmlspecialchars($user->last_name) ?>"></label><br>
    <label>Отчество: <input type="text" name="surname" value="<?= htmlspecialchars($user->surname) ?>"></label><br>
    <button type="submit">Обновить</button>
</form>