<?php

Atom::setup($_config->_getMySQLi());
Atom::model("profiles");
Atom::model("nosorted");

$page_name = "Несортированные";

$p_now = (isset($_GET['p'])) ? $_GET['p'] : 1;
$p_count = 20;
$p_start = ($p_count*$p_now)-$p_count;

$nosorted = nosorted::findAll("WHERE `active` = 1 ORDER BY `datetime` DESC LIMIT $p_start, $p_count");
$p_active = true;

$content_block .= '<div class="container">
    <div class="row">';

$html_block = new Kernel();
$html_block->_setHtml(_DIR_._VIEW_."/unsorted/block.tpl.html");

$image_block = "";

$_category = '<ul class="dropdown-menu">';

if(!empty($category)) {
    foreach ($category as $_cat) {
        if (!empty($_cat->id)) {
            $subsection = subsections::findByTag("cid", $_cat->id);

            $_category .= '<li class="dropdown-submenu"><a href="javascript://">' . $_cat->name . '</a><ul class="dropdown-menu">';

            if(!empty($subsection)) {
                foreach ($subsection as $_sub) {
                    if (!empty($_sub->id)) {

                        $_category .= '<li><a href="javascript://" class="btn-send" data-id="'.$_sub->id.'">' . $_sub->name . '</a>';

                    }
                }
            }

            $_category .= '</li></ul>';

        }
    }
}

$_category .= '</ul>';

if(!empty($nosorted))
{
    foreach ($nosorted as $item)
    {
        if(!empty($item->id))
        {

            $html = new Kernel();
            $html->_setHtml(_DIR_._VIEW_."/unsorted/image.tpl.html");

            $html->_setVar("img_id", $item->id);
            $html->_setVar("category", $_category);
            $html->_setVar("image_link", $item->link);
            $html->_setVar("image", "/data/unsorted/".$item->imageHighResolutionUrl);

            $image_block .= $html->_getHtml();

        }
    }
}else{
    $image_block = "Запустите парсер чтобы загрузить изображнеия";
    $p_active = false;
}

$html_block->_setVar("image_page", $p_now);
$html_block->_setVar("image_block", $image_block);

$content_block .= $html_block->_getHtml();

$content_block .= '</div></div>';

if($p_active) {
    $p_sum = nosorted::calcRows("WHERE `active` = 1");
    $p_total = round($p_sum / $p_count);

    if ($p_now < $p_now + 2) {
        $paging = "";
        for ($i = 1; $i < $p_now + 5; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=unsorted&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=unsorted&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > 5 AND $p_now + 2 < $p_total) {
        $paging = "";
        for ($i = $p_now - 2; $i <= $p_now + 2; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=unsorted&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=unsorted&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > $p_total - 5) {
        $paging = "";
        for ($i = $p_total - 5; $i <= $p_total; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=unsorted&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=unsorted&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_total < 5) {
        $paging = "";
        for ($i = 1; $i <= $p_total; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=unsorted&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=unsorted&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > 1)
        $paging_back = '<li><a href="/control?page=unsorted&p=' . ($p_now - 1) . '">«</a></li>';
    else
        $paging_back = '<li class="disabled"><a href="javascript://">«</a></li>';

    if ($p_now < $p_total)
        $paging_next = '<li><a href="/control?page=unsorted&p=' . ($p_now + 1) . '">»</a></li>';
    else
        $paging_next = '<li class="disabled"><a href="javascript://">»</a></li>';

    $paging_start = '<li><a href="/control?page=unsorted&p=1">««</a></li>';
    $paging_total = '<li><a href="/control?page=unsorted&p=' . $p_total . '">»»</a></li>';

    $pagination = new Kernel();
    $pagination->_setHtml(PATH . "/web/pagination.tpl.html");
    $pagination->_setVar("paging_start", $paging_start);
    $pagination->_setVar("paging_back", $paging_back);
    $pagination->_setVar("paging", $paging);
    $pagination->_setVar("paging_next", $paging_next);
    $pagination->_setVar("paging_total", $paging_total);

    $pagination->_setVar("paging-size", 8);

    if($p_total>0) $content_block .= $pagination->_getHtml();
}