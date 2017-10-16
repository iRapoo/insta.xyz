<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

use InstagramScraper\Instagram;

Atom::setup($_config->_getMySQLi());
Atom::model("profiles");
Atom::model("nosorted");

echo json_encode(Instagram::getMedias($_POST['name'], $_POST['count']));
