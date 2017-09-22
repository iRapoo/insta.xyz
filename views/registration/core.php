<?php

$_config->title = "Регистрация";

$_config->css[] = _ASSETS_."/css/reg.css";

$_config->js[] = _ASSETS_."/js/bootstrap-libs/bootstrap-formhelpers-phone.js";

$access = (empty($_POST)) ? true : false;

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_."/reg.tpl.html");

$html->_setIf("post", $access);

$_config->body .= $html->_getHtml();