<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$title = 'Тест';
ob_start();
?>
    <h1>Шаблон positions работает</h1>
    <p>Если вы видите этот текст, значит ошибка была в логике шаблона.</p>
<?php
$content = ob_get_clean();
include __DIR__ . '/layouts/main.php';