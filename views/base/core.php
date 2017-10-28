<?php

Atom::setup($_config->_getMySQLi());
Atom::model("category");
Atom::model("subsections");
Atom::model("catalog");

$category = category::findAll();
$catalog = catalog::findAll("ORDER BY `id` DESC");

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

                        $menu_subs .= '<li><a href="/catalog?id='.$_sub->id.'">'.$_sub->name.'</a></li>';

                    }
                }
            }

            $nav_menu->_setVar("menu_subs", $menu_subs);

            $menu .= $nav_menu->_getHtml();
        }
    }
}

$rus_months = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая',
    'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');

$content = "";
if(!empty($catalog))
{
    foreach ($catalog as $item)
    {
        if(!empty($item->id))
        {
            $c_html = new Kernel();
            $c_html->_setHtml(_DIR_._VIEW_.'/items.tpl.html');

            $c_html->_setVar("image_src", $item->imageHighResolutionUrl);
            $c_html->_setVar("item_caption", $item->caption);

            $f = new Datetime($item->datetime);
            $month = $f->format('n');
            $c_html->_setVar("item_date", $f->format('j ' . $rus_months[$month-1] . ' Y'));

            $content .= $c_html->_getHtml();
        }
    }
}

$html->_setVar("nav_menu", $menu);
$html->_setVar("content", $content);

$_config->body .= $html->_getHtml();