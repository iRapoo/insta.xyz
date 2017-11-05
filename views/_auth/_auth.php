<?php

if(!empty($_COOKIE['_ak']) AND
    empty($_SESSION))
    header("Location: /_auth");

$_config->css[] = _ASSETS_."/css/_auth.css";

$rus_months = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая',
    'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');

$html = new Kernel();
$html->_setHtml(_DIR_."_auth/_auth.tpl.html");

$html->_setVar("user_login", $_SESSION['login']);
$html->_setVar("user_email", $_SESSION['email']);
$html->_setVar("user_phone", $_SESSION['phone']);

$f = new DateTime($_SESSION['birthday']);
$month = $f->format('n');
$html->_setVar("user_birthday", $f->format('j ' . $rus_months[$month-1] . ' Y'));

$_config->body .= $html->_getHtml();