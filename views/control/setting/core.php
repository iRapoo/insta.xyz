<?php
Atom::model("profiles");

$page_name = "Настройки";

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


$html = new Kernel();
$html->_setHtml(_DIR_ . _VIEW_ . "/setting/access.tpl.html");

$html->_setVar("login", $_SESSION['login']);

$_access .= $html->_getHtml();
unset($html);

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_."/setting/setting.tpl.html");
$html->_setVar("category_elements", $_category);
$html->_setVar("access_elements", $_access);
$content_block = $html->_getHtml();