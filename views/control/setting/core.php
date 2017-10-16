<?php
Atom::model("subsections");
Atom::model("profiles");

$_config->js[] = _ASSETS_."/js/setting/push-data.js";

$page_name = "Настройки";

$profiles = profiles::findAll("ORDER BY `id` DESC");

$_category = "";
$_profiles = "";

if(!empty($category))
foreach ($category as $_cat)
{
    if(!empty($_cat->id))
    {
        $html = new Kernel(); $sub_item = "";
        $html->_setHtml(_DIR_ . _VIEW_ . "/setting/cat_elements.tpl.html");

        $subsection = subsections::findByTag("cid", $_cat->id);
        if(!empty($subsection))
        foreach ($subsection as $_sub)
        {
            if(!empty($_sub->id))
                $sub_item .= '<li><a href="javascript://">'.$_sub->name.'</a></li>';
        }

        $html->_setVar("subsections", $sub_item);
        $html->_setVar("category_name", $_cat->name);
        $_category .= $html->_getHtml();
    }
}
else
{
    $_category .= "Разделы еще не добавлены";
}
unset($html);

if(!empty($profiles))
foreach ($profiles as $_prof)
{
    if(!empty($_prof->id))
    {
        $html = new Kernel();
        $html->_setHtml(_DIR_ . _VIEW_ . "/setting/prof_elements.tpl.html");
        $html->_setVar("profile_image", $_prof->photo);
        $html->_setVar("profile_status", ($_prof->status=="1") ? "success" : "danger" );
        $html->_setIf("profile_status", ($_prof->status=="1"));
        $html->_setVar("profile_name", $_prof->name);
        $_profiles .= $html->_getHtml();
    }
}
else
{
        $_profiles .= "Страницы еще не добавлены";
}
unset($html);

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_."/setting/setting.tpl.html");
$html->_setVar("category_elements", $_category);
$html->_setVar("profiles_elements", $_profiles);
$content_block = $html->_getHtml();