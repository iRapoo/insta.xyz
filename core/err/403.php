<?php

http_response_code(403);

$_config->title = "Ошибка 403";
$_config->body .= '<div id="ERR_CONTENT"><img src="/web/assets/img/error.png" /><br><br><b>403 Forbidden</b><br>Нет доступа...</div>';
