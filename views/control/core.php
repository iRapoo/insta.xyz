<?php
define("_PAGE_", $_GET['page']);

Atom::setup($_config->_getMySQLi());
Atom::model("category");
Atom::model("subsections");
Atom::model("users");

if($_SESSION['rank']!='a' AND users::calcRows()>0){
    header("Location: /auth");
    exit();
}

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

        $subsection = subsections::findByTag("cid", $_cat->id);

        $_category_main .= '<li class="dropdown-submenu"><a href="javascript://">' . $_cat->name . '</a><ul class="dropdown-menu">';

        if(!empty($subsection)) {
            foreach ($subsection as $_sub) {
                if (!empty($_sub->id)) {

                    $_category_main .= '<li><a href="?page=sorted&cat='.$_cat->id.'&sub='.$_sub->id.'">' . $_sub->name . '</a>';

                }
            }
        }

        $_category_main .= '</li></ul>';

        //$cat_menu .= '<li><a href="?page=sorted&cat='.$_cat->id.'">'.$_cat->name.'</a></li>';
        $cat_count++;
    }
}

$dashboard->_setVar("cat_count", $cat_count);
$dashboard->_setVar("cat_menu", $_category_main);

$_config->body .= $dashboard->_getHtml();