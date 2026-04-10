<h1>Список пользователей</h1>
<a href="<?= app()->route->getUrl('/create_users') ?>">Добавить</a>
<table border="1">
    <tr><th>ID</th><th>Логин</th><th>Имя</th><th>Действия</th></tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= htmlspecialchars($user->login) ?></td>
            <td><?= htmlspecialchars($user->first_name) ?></td>
            <td>

                <a href="<?= app()->route->getUrl('/edit_user') ?>?id=<?= $user->id ?>">Ред.</a>
                <a href="<?= app()->route->getUrl('/deleteUsers') ?>?id=<?= $user->id ?>" onclick="return confirm('Удалить?')">Уд.</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>