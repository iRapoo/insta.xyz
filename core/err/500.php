<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
include_once(PATH.'/core/kernel.php');

http_response_code(500);

$_config->title = "Ошибка 500";
$_config->body .= '<div id="ERR_CONTENT"><img src="/web/assets/img/error.png" /><br><br><b>500 Internal Server Error</b><br>Внутренняя ошибка сервера...</div>';

include_once(PATH.'/core/base.php');