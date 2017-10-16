<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("category");

$category = new category();

$category->name = $_POST['data'];

if(!empty($_POST['data']))
if($category->insert())
{
    echo true;
}
else
{
    echo false;
}