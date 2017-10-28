<?php

Atom::setup($_config->_getMySQLi());
Atom::model("category");
Atom::model("subsections");

$category = category::findAll();

$_config->title = $_config->_getManifest()->base->name.". Каталог";
$_config->css[] = _ASSETS_."/css/base.css";

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_.'/main.tpl.html');

$menu = "";
if(!empty($category)) {
    foreach ($category as $_cat) {
        if (!empty($_cat->id)) {

            $nav_menu = new Kernel();
            $nav_menu->_setHtml(_DIR_._VIEW_."/menu.tpl.html");

            $nav_menu->_setVar("menu_name", $_cat->name);

            $subsections = subsections::findAll("WHERE `cid` = '{$_cat->id}'");

            $menu_subs = "";
            if(!empty($subsections)) {
                foreach ($subsections as $_sub) {
                    if (!empty($_sub->id)) {

                        $menu_subs .= '<li><a href="/sub?type='.$_sub->id.'">'.$_sub->name.'</a></li>';

                    }
                }
            }

            $nav_menu->_setVar("menu_subs", $menu_subs);

            $menu .= $nav_menu->_getHtml();
        }
    }
}

$html->_setVar("nav_menu", $menu);

$_config->body .= $html->_getHtml();