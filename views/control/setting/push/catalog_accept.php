<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("catalog");
Atom::model("nosorted");

$ID = $_POST['data-id'];

$nosorted = nosorted::findById($ID);

$catalog = new catalog();

$catalog->sid = $_POST['sub'];
$catalog->uid = $nosorted->uid;
$catalog->imageHighResolutionUrl = $nosorted->imageHighResolutionUrl;
$catalog->link = $nosorted->link;
$catalog->type = $nosorted->type;
$catalog->caption = $nosorted->caption;
$catalog->color = $_POST['color'];
$catalog->datetime = $nosorted->datetime;
$catalog->active = 1;

if($catalog->insert()){
    rename(PATH."/data/unsorted/".$nosorted->imageHighResolutionUrl, PATH."/data/sorted/".$nosorted->imageHighResolutionUrl);
    $_config->_getMySQLi()->query("UPDATE `nosorted` SET `active` = 0 WHERE `id` = '{$ID}' ");
    echo true;
}else echo false;