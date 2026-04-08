<h2>Регистрация нового пользователя</h2>
<h3><?= $message ?? ''; ?></h3>
<form method="post">
    <label>Фамилия <input type="text" name="last_name"></label>
    <label>Имя <input type="text" name="first_name"></label>
    <label>Отчество <input type="text" name="surname"></label>

    <label>Логин <input type="text" name="login"></label>
    <label>Пароль <input type="password" name="password"></label>

    <button>Зарегистрироваться</button>
</form>