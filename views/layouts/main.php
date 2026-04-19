<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Бухгалтерия / Расчёт зарплаты</title>
    <link rel="stylesheet" href="<?= app()->route->getUrl('/css/style.css') ?>">
</head>
<body>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
        <?php if (app()->auth::check()): ?>
            <?php $user = app()->auth::user(); ?>
            <?php if ($user->role && $user->role->role_name === 'admin'): ?>
                <a href="<?= app()->route->getUrl('/positions') ?>">Должности</a>
                <a href="<?= app()->route->getUrl('/users') ?>">Пользователи</a>
                <a href="<?= app()->route->getUrl('/allowances') ?>">Начисления</a>
                <a href="<?= app()->route->getUrl('/deductions') ?>">Вычеты</a>
            <?php endif; ?>
            <a href="<?= app()->route->getUrl('/payroll/calculate') ?>">Расчёт ЗП</a>
            <a href="<?= app()->route->getUrl('/payroll/reports') ?>">Отчёты</a>
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= htmlspecialchars($user->last_name) ?>)</a>
        <?php else: ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
        <?php endif; ?>
    </nav>
</header>
<main>
    <?= $content ?? '' ?>
</main>
</body>
</html>