<?php
$page_name = "Подписчики";

$_config->css[] = _ASSETS_."/css/toggle.css";
$_config->js[] = _ASSETS_."/js/catalog/follow-data.js";

Atom::model("follower");

$p_now = (isset($_GET['p'])) ? $_GET['p'] : 1;
$p_count = 20;
$p_start = ($p_count*$p_now)-$p_count;

$p_active = true;

$follower = follower::findAll("ORDER BY `id` AND `active` DESC LIMIT $p_start, $p_count");

$num = 1;
if(!empty($follower))
    foreach ($follower as $_follow)
    {
        if(!empty($_follow->id))
        {
            $html = new Kernel();
            $html->_setHtml(_DIR_ . _VIEW_ . "/follower/item.tpl.html");
            $html->_setVar("follower_id", $_follow->id);
            $html->_setVar("follower_num", $num++);
            $html->_setVar("follower_email", $_follow->email);

            $html->_setVar("follower_active", ($_follow->active=="1") ? "checked" : "" );
            $_follower .= $html->_getHtml();
        }
    }
else
{
    $_follower .= "<tr><td colspan='9'>Еще никто не подписался...</td></tr>";
    $p_active = false;
}
unset($html);

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_."/follower/table.tpl.html");
$html->_setVar("items", $_follower);
$content_block = $html->_getHtml();

if($p_active) {
    $p_sum = follower::calcRows();
    $p_total = round($p_sum / $p_count);

    if ($p_now < $p_now + 2) {
        $paging = "";
        for ($i = 1; $i < $p_now + 5; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=follower&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=follower&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > 5 AND $p_now + 2 < $p_total) {
        $paging = "";
        for ($i = $p_now - 2; $i <= $p_now + 2; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=follower&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=follower&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > $p_total - 5) {
        $paging = "";
        for ($i = $p_total - 5; $i <= $p_total; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=follower&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=follower&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_total < 5) {
        $paging = "";
        for ($i = 1; $i <= $p_total; $i++)
            if ($p_now == $i)
                $paging .= '<li class="active"><a href="/control?page=follower&p=' . $i . '">' . $i . '</a></li>';
            else $paging .= '<li><a href="/control?page=follower&p=' . $i . '">' . $i . '</a></li>';
    }

    if ($p_now > 1)
        $paging_back = '<li><a href="/control?page=follower&p=' . ($p_now - 1) . '">«</a></li>';
    else
        $paging_back = '<li class="disabled"><a href="javascript://">«</a></li>';

    if ($p_now < $p_total)
        $paging_next = '<li><a href="/control?page=follower&p=' . ($p_now + 1) . '">»</a></li>';
    else
        $paging_next = '<li class="disabled"><a href="javascript://">»</a></li>';

    $paging_start = '<li><a href="/control?page=follower&p=1">««</a></li>';
    $paging_total = '<li><a href="/control?page=follower&p=' . $p_total . '">»»</a></li>';

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