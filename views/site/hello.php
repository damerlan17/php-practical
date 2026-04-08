<h2><?= $message ?? ''; ?></h2>

<p>Фамилия: <?= app()->auth::user()->last_name ?></p>
<p>Имя: <?= app()->auth::user()->first_name ?></p>
<p>Отчество: <?= app()->auth::user()->surname ?></p>

<h2>Ваши документы:</h2>
<p>ИНН:</p>
<p>СНИЛС:</p>
<p>Расчетный счет:</p>
<p>Табельный номер:</p>

<a href="">Редактировать</a>