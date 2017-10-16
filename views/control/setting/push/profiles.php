<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("profiles");

use InstagramScraper\Instagram;

$profile = new profiles();
$account = Instagram::getAccount($_POST['data']);

$profile->name = $_POST['data'];
$profile->photo = $account->profilePicUrl;
$profile->status = 0;

if(!empty($_POST['data']))
if($profile->insert())
{
    echo true;
}
else
{
    echo false;
}