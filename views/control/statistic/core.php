<?php

Atom::setup($_config->_getMySQLi());
Atom::model("nosorted");
Atom::model("profiles");

$_config->js[] = _ASSETS_."/js/raphael-min.js";
$_config->js[] = _ASSETS_."/js/morris.min.js";

$page_name = "Статистика";

//$_config->title .= ". ".$page_name;

$SQL = $_config->_getMySQLi()->query("SELECT uid, COUNT(*) as total FROM `nosorted` WHERE `datetime` > (NOW() - INTERVAL 7 DAY) GROUP BY `uid`");

while($item = $SQL->fetch_assoc()) {
    $n += intval($item['total']);

    $donut = new Kernel();
    $donut->_setHtml(_DIR_._VIEW_.'/statistic/donut.tpl.html');

    $u_name = profiles::findById($item['uid']);

    $donut->_setVar("TEXT", $u_name->name);
    $arr_version .= ";,".$item['uid'];
    $donut->_setVar("COUNT", $item['total']);
    $donuts .= $donut->_getHtml();

}

$SQL = $_config->_getMySQLi()->query("SELECT uid, COUNT(*) as total FROM `nosorted` WHERE `datetime` > (NOW() - INTERVAL 1 MONTH) GROUP BY `uid`");

while($item = $SQL->fetch_assoc()) {
    $n += intval($item['total']);

    $donut = new Kernel();
    $donut->_setHtml(_DIR_._VIEW_.'/statistic/donut.tpl.html');

    $u_name = profiles::findById($item['uid']);

    $donut->_setVar("TEXT", $u_name->name);
    $arr_version .= ";,".$item['uid'];
    $donut->_setVar("COUNT", $item['total']);
    $donuts2 .= $donut->_getHtml();

}

$SQL = $_config->_getMySQLi()->query("SELECT uid, COUNT(*) as total FROM `nosorted` WHERE `datetime` > (NOW() - INTERVAL 180 DAY) GROUP BY `uid`");

while($item = $SQL->fetch_assoc()) {
    $n += intval($item['total']);

    $donut = new Kernel();
    $donut->_setHtml(_DIR_._VIEW_.'/statistic/donut.tpl.html');

    $u_name = profiles::findById($item['uid']);

    $donut->_setVar("TEXT", $u_name->name);
    $arr_version .= ";,".$item['uid'];
    $donut->_setVar("COUNT", $item['total']);
    $donuts3 .= $donut->_getHtml();

}

$SQL = $_config->_getMySQLi()->query("SELECT EXTRACT(YEAR_MONTH FROM datetime) AS ym, COUNT(*) AS qty
                                             FROM `nosorted`
                                             GROUP BY EXTRACT(YEAR_MONTH FROM datetime)");

while($item = $SQL->fetch_assoc()) {
    $line = new Kernel();
    $line->_setHtml(_DIR_._VIEW_.'/statistic/line.tpl.html');

    $YEAR = substr($item['ym'], 0, 4);
    $MONTH = substr($item['ym'], 4, 6);

    $line->_setVar("DATE", $YEAR."-".$MONTH);
    $line->_setVar("COUNT", $item['qty']);
    $lines .= $line->_getHtml();
}

$items = new Kernel();
$items->_setHtml(_DIR_._VIEW_.'/statistic/items.tpl.html');

$items->_setVar("DONUT", $donuts);
$items->_setVar("DONUT2", $donuts2);
$items->_setVar("DONUT3", $donuts3);
$items->_setVar("LINE", $lines);

$content_block .= $items->_getHtml();