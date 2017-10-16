<?php

$page_name = "Статистика";

//$_config->title .= ". ".$page_name;

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_."/statistic/statistic.tpl.html");

$content_block = $html->_getHtml();
