<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("catalog");

$ID = Generate::getHideKey($_POST['data-id']);
$CAPTION = $_POST['data-caption'];

$SQLi = $_config->_getMySQLi()->query("UPDATE `catalog` SET `caption` = '{$CAPTION}' WHERE `id` = '{$ID}' ");

if($SQLi) echo true;
else echo false;