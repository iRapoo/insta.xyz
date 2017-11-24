<?php
Atom::model("profiles");

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
            if(!empty($_sub->id)) {

                $sub_item .= '<li class="dropdown-submenu">
                                    <a tabindex="-1" href="javascript://">' . $_sub->name . '</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript://" class="btn-del" data-del="subsection" data-id="' . $_sub->id . '">Удалить</a></li>
                                    </ul>
                                </li>';

            }
        }

        $html->_setVar("category_id", $_cat->id);
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
        $html->_setVar("profile_id", $_prof->id);
        $_profiles .= $html->_getHtml();
    }
}
else
{
        $_profiles .= "Страницы еще не добавлены";
}
unset($html);

$html = new Kernel();
$html->_setHtml(_DIR_ . _VIEW_ . "/setting/access.tpl.html");

$html->_setVar("login", $_SESSION['login']);

$_access .= $html->_getHtml();
unset($html);

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_."/setting/setting.tpl.html");
$html->_setVar("category_elements", $_category);
//$html->_setVar("profiles_elements", $_profiles);
$html->_setVar("access_elements", $_access);
$content_block = $html->_getHtml();