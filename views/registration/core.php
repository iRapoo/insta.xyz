<?php

$_config->title = "Регистрация";

$_config->css[] = _ASSETS_."/css/reg.css";

$_config->js[] = _ASSETS_."/js/bootstrap-libs/bootstrap-formhelpers-phone.js";

echo $_POST['firstName'];

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_."/reg.tpl.html");
$_config->body .= $html->_getHtml();