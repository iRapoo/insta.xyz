<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("nosorted");

$ID = $_POST['data'];

$nosorted = nosorted::findById($ID);

$res = $_config->_getMySQLi()->query("UPDATE `nosorted` SET `active` = 0 WHERE `id` = '{$ID}'");

if($res){
    unlink(PATH."/data/unsorted/".$nosorted->imageHighResolutionUrl);
    echo true;
}else echo false;