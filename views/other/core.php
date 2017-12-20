<?php

try {
    Atom::setup($_config->_getMySQLi());
    Atom::model("category");
    Atom::model("subsections");
    Atom::model("catalog");
} catch (Exception $e) {
    exit("Ошибка базы данных или построения модели!!!");
}

$_config->title = (new Manifest)->_getPages($_GET['obj']);

$ID = (new Generate)->getHideKey($_GET['id']);

$SORT = (!empty($_GET['sort'])) ? $_GET['sort'] : 30;

$category = category::findAll();

$catalog = catalog::findById($ID);
$p_active = true;

$_config->css[] = _ASSETS_."/css/base.css";

$html = new Kernel();
$html->_setHtml(_DIR_.'/p/main.tpl.html');

$menu = "";
if(!empty($category)) {
    foreach ($category as $_cat) {
        if (!empty($_cat->id)) {

            $nav_menu = new Kernel();
            $nav_menu->_setHtml(_DIR_."/base/menu.tpl.html");

            $nav_menu->_setVar("menu_name", $_cat->name);

            $subsections = subsections::findAll("WHERE `cid` = '{$_cat->id}'");

            $menu_subs = "";
            if(!empty($subsections)) {
                foreach ($subsections as $_sub) {
                    if (!empty($_sub->id)) {

                        $cat_count = catalog::calcRows("WHERE `sid` = '{$_sub->id}'");
                        $cat_count = (!empty($cat_count)) ? $cat_count : 0;

                        $menu_subs .= '<li><a href="/catalog/'.strtolower((new Generate)->rus2translit($_cat->name)).'/'.strtolower((new Generate)->rus2translit($_sub->name)).'">'.$_sub->name." (".$cat_count.')</a></li>';

                    }
                }
            }

            $nav_menu->_setVar("menu_subs", $menu_subs);

            $menu .= $nav_menu->_getHtml();
        }
    }
}

$content = new Kernel();
$content->_setHtml(_DIR_._VIEW_."/content.tpl.html");
$html->_setVar("content", $content->_getHtml());

$html->_setVar("nav_menu", $menu);
//$html->_setVar("content", $content);

$html->_setVar("page_links", (new Manifest)->_getPages());

$_config->body .= $html->_getHtml();