<?php

Atom::setup($_config->_getMySQLi());

$_config->js[] = _ASSETS_."/js/test.js";

$_config->title = "Панель управления";

$control = new Kernel();
$control->_setHtml(_DIR_._VIEW_."/template.tpl.html");
$_config->body = $control->get_html();