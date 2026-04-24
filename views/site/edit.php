<h1>Форма редактирования</h1>
<p>Пользователь: <?= $user->last_name ?> <?= $user->first_name ?></p>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
    <label>ИНН: <input type="text" name="inn" value="<?= htmlspecialchars($user->document->inn ?? '') ?>"></label><br>
    <label>СНИЛС: <input type="text" name="snils" value="<?= htmlspecialchars($user->document->snils ?? '') ?>"></label><br>
    <label>Расчётный счёт: <input type="text" name="payment_account" value="<?= htmlspecialchars($user->document->payment_account ?? '') ?>"></label><br>
    <label>Табельный номер: <input type="text" name="tabel_name" value="<?= htmlspecialchars($user->document->tabel_name ?? '') ?>"></label><br>
    <button type="submit">Сохранить</button>
</form>
<a href="<?= app()->route->getUrl('/hello') ?>">Назад</a>