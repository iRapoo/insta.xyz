<?php
http_response_code(404);

$_config->title = ' Ошибка 404';
$_config->body .= '<div id="ERR_CONTENT"><img src="/web/assets/img/error.png" /><br><br><b>Ой... Ошибка 404!</b><br>Страницы не существует...</div>';