<?php

Atom::setup($_config->_getMySQLi());
Atom::model("category");
Atom::model("subsections");
Atom::model("catalog");

$SORT = (!empty($_GET['sort'])) ? $_GET['sort'] : 30;

$category = category::findAll();

if(!empty($category)) {
    foreach ($category as $_cat) {
        if (!empty($_cat->id)) {

            if(strtolower(Generate::rus2translit($_cat->name))==$_GET['cat']) {
                $CID = $_cat->id;
                $_config->title .= $_cat->name;
                $subsections = subsections::findByTag("cid", $CID);
            }

            if (!empty($subsections)) {
                foreach ($subsections as $_sub) {
                    if (!empty($_sub->id)) {
                        if (strtolower(Generate::rus2translit($_sub->name)) == $_GET['sub'])
                            $SID = $_sub->id;
                    }
                }
            }

        }
    }
}

$p_now = (isset($_GET['p'])) ? $_GET['p'] : 1;
$p_count = 20;
$p_start = ($p_count*$p_now)-$p_count;

$catalog = catalog::findAll("WHERE `sid` = '{$SID}' AND `datetime` > (NOW() - INTERVAL $SORT DAY) AND `active` = 1 ORDER BY `datetime` DESC LIMIT $p_start, $p_count");
$p_active = true;

$_config->css[] = _ASSETS_."/css/base.css";

$html = new Kernel();
$html->_setHtml(_DIR_.'/base/main.tpl.html');

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
            $c_html->_setHtml(_DIR_.'/base/items.tpl.html');

            $c_html->_setVar("image_src", $item->imageHighResolutionUrl);
            $c_html->_setVar("item_caption", $item->caption);

            $f = new Datetime($item->datetime);
            $month = $f->format('n');
            $c_html->_setVar("item_date", $f->format('j ' . $rus_months[$month-1] . ' Y'));

            $content .= $c_html->_getHtml();
        }
    }
}

if($p_active) {
    $p_sum = catalog::calcRows("WHERE `sid` = '{$SID}' AND `datetime` > (NOW() - INTERVAL $SORT DAY) AND `active` = 1");
    $p_total = round($p_sum / $p_count);

    if ($p_now < $p_now + 2) {
        $paging = "";
        for ($i = 1; $i < $p_now + 5; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > 5 AND $p_now + 2 < $p_total) {
        $paging = "";
        for ($i = $p_now - 2; $i <= $p_now + 2; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > $p_total - 5) {
        $paging = "";
        for ($i = $p_total - 5; $i <= $p_total; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_total < 5) {
        $paging = "";
        for ($i = 1; $i <= $p_total; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > 1)
        $paging_back = '<li><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . ($p_now - 1) . '">«</a></li>';
    else
        $paging_back = '<li class="disabled"><a href="javascript://">«</a></li>';

    if ($p_now < $p_total)
        $paging_next = '<li><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . ($p_now + 1) . '">»</a></li>';
    else
        $paging_next = '<li class="disabled"><a href="javascript://">»</a></li>';

    $paging_start = '<li><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=1">««</a></li>';
    $paging_total = '<li><a href="/catalog/'.$_GET['cat'].'/'.$_GET['sub'].'?sort='. $SORT .'&p=' . $p_total . '">»»</a></li>';

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