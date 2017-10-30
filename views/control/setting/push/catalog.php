<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("catalog");
Atom::model("nosorted");

$ID_IMG = $_POST['data-img'];
$ID_SUB = $_POST['data'];

$nosorted = nosorted::findById($ID_IMG);

$catalog = new catalog();

$catalog->sid = $ID_SUB;
$catalog->uid = $nosorted->uid;
$catalog->imageHighResolutionUrl = $nosorted->imageHighResolutionUrl;
$catalog->link = $nosorted->link;
$catalog->type = $nosorted->type;
$catalog->caption = $nosorted->caption;
$catalog->datetime = $nosorted->datetime;
$catalog->active = 1;

if($catalog->insert()){
    rename(PATH."/data/unsorted/".$nosorted->imageHighResolutionUrl, PATH."/data/sorted/".$nosorted->imageHighResolutionUrl);
    $_config->_getMySQLi()->query("UPDATE `nosorted` SET `active` = 0 WHERE `id` = '{$ID_IMG}' ");
    echo true;
}else echo false;