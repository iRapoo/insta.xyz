<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("subsections");

$subsections = new subsections();

$subsections->cid = $_POST['data'];
$subsections->name = $_POST['data_name'];

if(!empty($_POST['data']))
    if($subsections->insert())
    {
        echo true;
    }
    else
    {
        echo false;
    }