<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("nosorted");

$ID = $_POST['data'];

$num = 0;
foreach (nosorted::findAll("WHERE `active` = 1") as $item)
{
    $ID = $item->id;

    if($item->id > $_POST['data']){
        break;
    }
}

$nosorted = nosorted::findById($ID);

$id = $nosorted->id;
$image = "/data/unsorted/".$nosorted->imageHighResolutionUrl;
$caption = $nosorted->caption;

$json = array("id" => $id, "image" => $image, "caption" => $caption);

echo json_encode($json);