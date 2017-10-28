<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("profiles");

$ID = $_POST['data'];
$res = profiles::findById($ID)->delete();

echo $res;