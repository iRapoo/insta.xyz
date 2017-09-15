<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
include_once(PATH.'/core/kernel.php');

http_response_code(500);

$TITLE = "Ошибка 500"; 
$BODY .= '<div id="ERR_CONTENT"><img src="/web/assets/img/error.png" /><br><br><b>500 Internal Server Error</b><br>Внутренняя ошибка сервера...</div>';

include_once(PATH.'/core/module/_status/core.php');
include_once(PATH.'/core/base.php');