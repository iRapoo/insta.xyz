<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("nosorted");

$nosorted = nosorted::findById($_POST['data']);

$id = $nosorted->id;
$image = "/data/unsorted/".$nosorted->imageHighResolutionUrl;
$caption = $nosorted->caption;

$json = array("id" => $id, "image" => $image, "caption" => $caption);

echo json_encode($json);