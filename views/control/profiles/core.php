<?php
$page_name = "Профили инстаграм";

$_config->css[] = _ASSETS_."/css/toggle.css";
$_config->js[] = _ASSETS_."/js/setting/push-profiles.js";

Atom::model("profiles");
Atom::model("nosorted");
Atom::model("catalog");

$profiles = profiles::findAll("ORDER BY `id` AND `status` DESC");

$rus_months = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая',
    'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');

$num = 1;
if(!empty($profiles))
    foreach ($profiles as $_prof)
    {
        if(!empty($_prof->id))
        {
            $profile_load = nosorted::calcRows("WHERE `uid` = '{$_prof->id}' ");
            $profile_public = catalog::calcRows("WHERE `uid` = '{$_prof->id}' ");

            $html = new Kernel();
            $html->_setHtml(_DIR_ . _VIEW_ . "/profiles/item.tpl.html");
            $html->_setVar("profile_id", $_prof->id);
            $html->_setVar("profile_num", $num++);
            $html->_setVar("profile_name", $_prof->name);
            $html->_setVar("profile_photo", $_prof->photo);

            $f = new Datetime($_prof->date);
            $month = $f->format('n');
            $html->_setVar("profile_date", $f->format('j ' . $rus_months[$month-1] . ' Y'));

            $html->_setVar("profile_city", $_prof->city);
            $html->_setVar("profile_load", (empty($profile_load)) ? "0" : $profile_load);
            $html->_setVar("profile_public", (empty($profile_public)) ? "0" : $profile_public);
            $html->_setVar("profile_phone", $_prof->phone);
            $html->_setVar("profile_email", $_prof->email);

            $html->_setVar("profile_status", ($_prof->status=="1") ? "checked" : "" );
            $_profiles .= $html->_getHtml();
        }
    }
else
{
    $_profiles .= "<tr><td colspan='9'>Страницы еще не добавлены</td></tr>";
}
unset($html);

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_."/profiles/table.tpl.html");
$html->_setVar("items", $_profiles);
$content_block = $html->_getHtml();