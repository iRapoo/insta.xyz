<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("profiles");

use InstagramScraper\Instagram;

$resault = false;

$profile = new profiles();

$instagram = new Instagram();
$account = $instagram->getAccount($_POST['name']);

$profile->name = $_POST['name'];
$profile->photo = $account->getProfilePicUrl();
$profile->city = (empty($_POST['city'])) ? "*" : $_POST['city'];
$profile->contact = (empty($_POST['contact'])) ? "*" : $_POST['contact'];
$profile->email = (empty($_POST['email'])) ? "*" : $_POST['email'];
$profile->phone = (empty($_POST['phone'])) ? "*" : $_POST['phone'];
$profile->date = date("y-m-d");
$profile->status = 0;

if(!empty($_POST['name']))
if($profile->insert())
{
    $resault = true;
}

echo $resault;