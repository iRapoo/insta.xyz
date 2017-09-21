<?php

//************************** HEADERS *******************************//

$_config->title = "Welcome! ".$_config->_getManifest()->base->name; //SET TITLE
$_config->css[] = _ASSETS_."/css/base.css"; //SET STYLESHEET

//**************************** END *******************************//

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_.'/welcome.tpl.html');
$_config->body .= $html->_getHtml();