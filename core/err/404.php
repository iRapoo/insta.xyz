<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
include_once(PATH.'/core/kernel.php');

http_response_code(404);

$TITLE = 'Ошибка 404';
$BODY = '<div id="ERR_CONTENT"><img src="/web/assets/img/error.png" /><br><br><b>Ой... Ошибка 404!</b><br>Страницы не существует...</div>';

include_once(PATH.'/core/base.php');
?>