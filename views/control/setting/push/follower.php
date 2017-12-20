<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("follower");

$result = false;

$follower = new follower();

$follower->email = $_POST['email'];
$follower->active = 1;

if(!empty($_POST['email']))
{
    if ($follower->insert())
    {
        $result = true;
    }
}

echo $result;