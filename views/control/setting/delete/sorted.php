<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("catalog");

$ID = $_POST['data'];

$catalog = catalog::findById($ID);

$res = $_config->_getMySQLi()->query("DELETE FROM `catalog` WHERE `id` = '{$ID}'");

if($res){
    unlink(PATH."/data/sorted/".$catalog->imageHighResolutionUrl);
    echo true;
}else echo false;