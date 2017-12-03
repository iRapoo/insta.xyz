<?php

Atom::setup($_config->_getMySQLi());
Atom::model("category");
Atom::model("subsections");
Atom::model("catalog");
Atom::model("views");

$SORT = (!empty($_GET['sort'])) ? $_GET['sort'] : 7;

$category = category::findAll();

$p_now = (isset($_GET['p'])) ? $_GET['p'] : 1;
$p_count = 20;
$p_start = ($p_count*$p_now)-$p_count;

$catalog = catalog::findAll("WHERE `datetime` > (NOW() - INTERVAL $SORT DAY) AND `active` = 1 ORDER BY `datetime` DESC LIMIT $p_start, $p_count");
$p_active = true;

$_config->title = "Главная";
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

                        $cat_count = catalog::calcRows("WHERE `sid` = '{$_sub->id}'");
                        $cat_count = (!empty($cat_count)) ? $cat_count : 0;

                        $menu_subs .= '<li><a href="/catalog/'.strtolower(Generate::rus2translit($_cat->name)).'/'.strtolower(Generate::rus2translit($_sub->name)).'">'.$_sub->name." (".$cat_count.')</a></li>';

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

            $c_html->_setVar("p_link", Generate::sethideKey($item->id));
            $c_html->_setVar("image_src", $item->imageHighResolutionUrl);
            $c_html->_setVar("item_caption", substr($item->caption, 0, 140));
            $c_html->_setVar("count_view", views::calcRows("WHERE `cid` = '{$item->id}'"));

            $f = new Datetime($item->datetime);
            $month = $f->format('n');
            $c_html->_setVar("item_date", $f->format('j ' . $rus_months[$month-1] . ' Y'));
            $c_html->_setVar("item_category", category::findById(subsections::findById($item->sid)->cid)->name." / ".subsections::findById($item->sid)->name);

            $content .= $c_html->_getHtml();
        }
    }
}

if($p_active) {
    $p_sum = catalog::calcRows("WHERE `datetime` > (NOW() - INTERVAL $SORT DAY) AND `active` = 1");
    $p_total = round($p_sum / $p_count);

    if ($p_now < $p_now + 2) {
        $paging = "";
        for ($i = 1; $i < $p_now + 5; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > 5 AND $p_now + 2 < $p_total) {
        $paging = "";
        for ($i = $p_now - 2; $i <= $p_now + 2; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > $p_total - 5) {
        $paging = "";
        for ($i = $p_total - 5; $i <= $p_total; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_total < 5) {
        $paging = "";
        for ($i = 1; $i <= $p_total; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > 1)
        $paging_back = '<li><a href="/?sort='. $SORT .'&p=' . ($p_now - 1) . '">«</a></li>';
    else
        $paging_back = '<li class="disabled"><a href="javascript://">«</a></li>';

    if ($p_now < $p_total)
        $paging_next = '<li><a href="/?sort='. $SORT .'&p=' . ($p_now + 1) . '">»</a></li>';
    else
        $paging_next = '<li class="disabled"><a href="javascript://">»</a></li>';

    $paging_start = '<li><a href="/?sort='. $SORT .'&p=1">««</a></li>';
    $paging_total = '<li><a href="/?sort='. $SORT .'&p=' . $p_total . '">»»</a></li>';

    $pagination = new Kernel();
    $pagination->_setHtml(PATH . "/web/pagination.tpl.html");
    $pagination->_setVar("paging_start", $paging_start);
    $pagination->_setVar("paging_back", $paging_back);
    $pagination->_setVar("paging", $paging);
    $pagination->_setVar("paging_next", $paging_next);
    $pagination->_setVar("paging_total", $paging_total);

    $pagination->_setVar("paging-size", 11);

    if($p_total>0) $content .= "<div>".$pagination->_getHtml()."</div>";
}

$html->_setVar("nav_menu", $menu);
$html->_setVar("content", $content);

$_config->body .= $html->_getHtml();