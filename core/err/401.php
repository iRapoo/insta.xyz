<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
include_once(PATH.'/core/kernel.php');

http_response_code(401);

$TITLE = "Ошибка 401"; 
$BODY = '<div id="ERR_CONTENT"><img src="/web/assets/img/error.png" /><br><br><b>401 Unauthorized</b><br>Запрос требует идентификации пользователя...</div>';

include_once(PATH.'/core/base.php');
?>