<?php

define("_PAGE_",$_GET['page']);
Atom::setup($_config->_getMySQLi());
Atom::model("category");

require_once _DIR_._VIEW_."/assets.php";

$_config->title = "Панель управления";

$category = category::findAll();

if(file_exists(_DIR_ . _VIEW_. "/" . _PAGE_ . "/core.php") AND !empty(_PAGE_))
    require_once _DIR_ . _VIEW_ . "/" . _PAGE_ . "/core.php";
else
    require_once _DIR_ . _VIEW_ . "/statistic/core.php";

$dashboard = new Kernel();
$dashboard->_setHtml(_DIR_._VIEW_."/dashboard.tpl.html");

$dashboard->_setVar("site_name", $_config->title);
$dashboard->_setVar("page_name", $page_name);
$dashboard->_setVar("page_link", _PAGE_);
$dashboard->_setVar("content_block", $content_block);

$cat_count = 0;
if(!empty($category))
foreach ($category as $_cat)
{
    if(!empty($_cat->id))
    {
        $cat_menu .= '<li><a href="?page=category&id='.$_cat->id.'">'.$_cat->name.'</a></li>';
        $cat_count++;
    }
}

$dashboard->_setVar("cat_count", $cat_count);
$dashboard->_setVar("cat_menu", $cat_menu);

$_config->body .= $dashboard->_getHtml();