<h1>Список пользователей</h1>
<a href="<?= app()->route->getUrl('/users/create') ?>">Добавить пользователя</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Логин</th>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user->id) ?></td>
            <td><?= htmlspecialchars($user->login) ?></td>
            <td><?= htmlspecialchars($user->first_name) ?></td>
            <td><?= htmlspecialchars($user->last_name) ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/users/edit?id=' . $user->id) ?>">Ред.</a>
                <a href="<?= app()->route->getUrl('/users/delete?id=' . $user->id) ?>" onclick="return confirm('Удалить?')">Уд.</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>