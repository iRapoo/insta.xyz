<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

use InstagramScraper\Instagram;

Atom::setup($_config->_getMySQLi());
Atom::model("profiles");
Atom::model("nosorted");


$_config->css[] = _ASSETS_."/css/cron/scriptoffset.css";
$_config->js[] = _ASSETS_."/js/cron/scriptoffset.js";

$profiles = profiles::findAll("WHERE `status` = 1");

$_config->body .= '<div class="_cron_cont">';

$c = 0;

if(!empty($profiles))
{
    foreach ($profiles as $item)
    {
        if(!empty($item->id))
        {
            $SQLi = $_config->_getMySQLi()->query("SELECT * FROM `nosorted` WHERE `uid` = '{$item->id}'");
            $count = mysqli_num_rows($SQLi);

            $account = Instagram::getAccount($item->name);

            if(!empty($_COOKIE['_offset'.$item->id])){
                $offset = $_COOKIE['_offset'.$item->id]+($account->mediaCount-$count);
                setcookie("_offset".$item->id, $offset, time() + 18000, "/");
            }

            $need = (!empty($_COOKIE['_offset'.$item->id])) ? $account->mediaCount : ($account->mediaCount-$count);

            $html = new Kernel();
            $html->_setHtml(_DIR_ . _VIEW_ . "/cron.tpl.html");
            $html->_setVar("uid", $item->id);
            $html->_setVar("name", $item->name);
            $html->_setVar("count", $need);
            $_config->body .= $html->_getHtml();

            $c++;

        }
    }
}

$_config->body .= '<c>'.$c.'</c></div>';


