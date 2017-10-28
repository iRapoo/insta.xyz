<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("category");

$ID = $_POST['data'];
$res = category::findById($ID)->delete();

echo $res;