<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
include_once(PATH.'/core/kernel.php');

$TITLE = "Ошибка 403"; 
$BODY = '<div id="ERR_CONTENT"><img src="/web/assets/img/error.png" /><br><br><b>403 Forbidden</b><br>Нет доступа...</div>';

include_once(PATH.'/core/base.php');
?>