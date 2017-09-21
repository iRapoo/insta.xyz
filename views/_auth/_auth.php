<?php

$_config->css[] = _ASSETS_."/css/_auth.css";

$html = new Kernel();
$html->_setHtml(_DIR_."_auth/_auth.tpl.html");
$_config->body .= $html->_getHtml();