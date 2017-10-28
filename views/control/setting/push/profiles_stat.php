<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("profiles");

$ID = $_POST['data'];
$STAT = $_POST['data_stat'];

$SQLi = $_config->_getMySQLi()->query("UPDATE `profiles` SET `status` = '{$STAT}' WHERE `id` = '{$ID}' ");

echo $SQLi;