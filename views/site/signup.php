<h2>Регистрация нового пользователя</h2>
<h3><?= $message ?? ''; ?></h3>
<form method="post">
    <label>Фамилия <input type="text" name="last_name"></label><br>
    <label>Имя <input type="text" name="first_name"></label><br>
    <label>Отчество <input type="text" name="surname"></label><br>

    <label>Логин <input type="text" name="login"></label><br>
    <label>Пароль <input type="password" name="password"></label><br>

    <input type="text" name="inn" placeholder="ИНН">
    <input type="text" name="snils" placeholder="СНИЛС">
    <input type="text" name="payment_account" placeholder="Расчётный счёт">
    <input type="text" name="tabel_name" placeholder="Табельный номер">
    <button>Зарегистрироваться</button>
</form>