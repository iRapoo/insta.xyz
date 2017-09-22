<?php

$_config->css[] = _ASSETS_."/css/_auth.css";
$_config->js[] = _ASSETS_."/js/_auth_panel.js";

$html = new Kernel();
$html->_setHtml(_DIR_."_auth/_auth.tpl.html");
$_config->body .= $html->_getHtml();