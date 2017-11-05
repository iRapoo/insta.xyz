<?php

Atom::setup($_config->_getMySQLi());
Atom::model("category");
Atom::model("subsections");
Atom::model("catalog");
Atom::model("views");

$ID = Generate::getHideKey($_GET['id']);

$SORT = (!empty($_GET['sort'])) ? $_GET['sort'] : 30;

$category = category::findAll();

$p_now = (isset($_GET['p'])) ? $_GET['p'] : 1;
$p_count = 20;
$p_start = ($p_count*$p_now)-$p_count;

$catalog = catalog::findById($ID);
$p_active = true;

$_config->css[] = _ASSETS_."/css/base.css";

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_.'/main.tpl.html');

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

                        $menu_subs .= '<li><a href="/catalog/'.strtolower(Generate::rus2translit($_cat->name)).'/'.strtolower(Generate::rus2translit($_sub->name)).'">'.$_sub->name.'</a></li>';

                    }
                }
            }

            $nav_menu->_setVar("menu_subs", $menu_subs);

            $menu .= $nav_menu->_getHtml();
        }
    }
}

$views = new views();

$views->cid = $ID;
$now = new DateTime;
$views->datetime = $now->format( 'Y-m-d H:i:s' );

$views->insert();

$rus_months = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая',
    'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');

$content = "";
if(!empty($catalog->id))
{
    $c_html = new Kernel();
    $c_html->_setHtml(_DIR_._VIEW_.'/items.tpl.html');

    $c_html->_setVar("image_src", $catalog->imageHighResolutionUrl);
    $c_html->_setVar("item_caption", $catalog->caption);
    $c_html->_setVar("count_view", views::calcRows("WHERE `cid` = '{$ID}'"));

    $f = new Datetime($catalog->datetime);
    $month = $f->format('n');
    $c_html->_setVar("item_date", $f->format('j ' . $rus_months[$month-1] . ' Y'));

    $content .= $c_html->_getHtml();
}

$html->_setVar("nav_menu", $menu);
$html->_setVar("content", $content);

$_config->body .= $html->_getHtml();