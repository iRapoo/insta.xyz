<?php

Atom::setup($_config->_getMySQLi());
Atom::model("profiles");
Atom::model("catalog");

$_config->js[] = _ASSETS_."/js/catalog/edit-data.js";

$SID = $_GET['sub'];

if(empty($_GET['sub'])) {
    $page_name = "Каталог";
    $content_block .= "Выберите раздел";
}
else {

    $page_name = category::findById($_GET['cat'])->name.' -> '.subsections::findById($_GET['sub'])->name;

    $p_now = (isset($_GET['p'])) ? $_GET['p'] : 1;
    $p_count = 20;
    $p_start = ($p_count*$p_now)-$p_count;

    $nosorted = catalog::findAll("WHERE `sid` = '{$SID}' AND `active` = 1 ORDER BY `datetime` DESC LIMIT $p_start, $p_count");
    $p_active = true;

    $content_block .= '<div class="container">
    <div class="row">';

    $html_block = new Kernel();
    $html_block->_setHtml(_DIR_._VIEW_."/sorted/block.tpl.html");

    $image_block = "";

    if(!empty($nosorted))
    {
        foreach ($nosorted as $item)
        {
            if(!empty($item->id))
            {

                $html = new Kernel();
                $html->_setHtml(_DIR_._VIEW_."/sorted/image.tpl.html");

                $html->_setVar("img_id", Generate::setHideKey($item->id));
                $html->_setVar("category", $_category);
                $html->_setVar("image_link", $item->link);
                $html->_setVar("image", "/data/sorted/".$item->imageHighResolutionUrl);

                $image_block .= $html->_getHtml();

            }
        }
    }else{
        $image_block = "В этом подразделе еще нет записей!";
        $p_active = false;
    }

    $html_block->_setVar("image_page", $p_now);
    $html_block->_setVar("image_block", $image_block);

    $content_block .= $html_block->_getHtml();

    $content_block .= '</div></div>';

}

if($p_active) {
    $p_sum = catalog::calcRows("WHERE `sid` = '{$SID}' AND `active` = 1");
    $p_total = round($p_sum / $p_count);

    if ($p_now < $p_now + 2) {
        $paging = "";
        for ($i = 1; $i < $p_now + 5; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > 5 AND $p_now + 2 < $p_total) {
        $paging = "";
        for ($i = $p_now - 2; $i <= $p_now + 2; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > $p_total - 5) {
        $paging = "";
        for ($i = $p_total - 5; $i <= $p_total; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_total < 5) {
        $paging = "";
        for ($i = 1; $i <= $p_total; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > 1)
        $paging_back = '<li><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . ($p_now - 1) . '">«</a></li>';
    else
        $paging_back = '<li class="disabled"><a href="javascript://">«</a></li>';

    if ($p_now < $p_total)
        $paging_next = '<li><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . ($p_now + 1) . '">»</a></li>';
    else
        $paging_next = '<li class="disabled"><a href="javascript://">»</a></li>';

    $paging_start = '<li><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=1">««</a></li>';
    $paging_total = '<li><a href="/control?page=sorted&cat='. $_GET['cat'] .'&sub='. $_GET['sub'] .'&p=' . $p_total . '">»»</a></li>';

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