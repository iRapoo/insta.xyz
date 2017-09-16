<?php

http_response_code(403);

$TITLE = "Ошибка 403"; 
$BODY .= '<div id="ERR_CONTENT"><img src="/web/assets/img/error.png" /><br><br><b>403 Forbidden</b><br>Нет доступа...</div>';
