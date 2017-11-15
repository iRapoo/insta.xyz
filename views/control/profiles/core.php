<?php
$page_name = "Профили инстаграм";

$_config->css[] = _ASSETS_."/css/toggle.css";
$_config->js[] = _ASSETS_."/js/setting/push-profiles.js";

Atom::model("profiles");

$profiles = profiles::findAll("ORDER BY `id` DESC");

if(!empty($profiles))
    foreach ($profiles as $_prof)
    {
        if(!empty($_prof->id))
        {
            $html = new Kernel();
            $html->_setHtml(_DIR_ . _VIEW_ . "/profiles/item.tpl.html");
            $html->_setVar("profile_id", $_prof->id);
            $html->_setVar("profile_name", $_prof->name);
            $html->_setVar("profile_date", $_prof->date);
            $html->_setVar("profile_city", $_prof->city);
            $html->_setVar("profile_load", "256");
            $html->_setVar("profile_public", "144");
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