<div class="form-container">
    <h2>Редактирование документов</h2>
    <form action="/edit" method="POST">
        <?php $doc = $user->document ?? null; ?>
        <label>ИНН:</label>
        <input type="text" name="inn" value="<?= htmlspecialchars($doc->inn ?? '') ?>"><br>
        <label>СНИЛС:</label>
        <input type="text" name="snils" value="<?= htmlspecialchars($doc->snils ?? '') ?>"><br>
        <label>Расчетный счет:</label>
        <input type="text" name="payment_account" value="<?= htmlspecialchars($doc->payment_account ?? '') ?>"><br>
        <label>Табельный номер:</label>
        <input type="text" name="tabel_name" value="<?= htmlspecialchars($doc->tabel_name ?? '') ?>"><br>
        <button type="submit">Сохранить</button>
        <a href="/profile">Отмена</a>
    </form>
</div>