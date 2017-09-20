<?php

//************************** HEADERS *******************************//

$_config->title = "Welcome! ".$_config->_getManifest()->base->name; //SET TITLE
$_config->head .= '<link href="'._ASSETS_.'/css/base.css" rel="stylesheet">'; //SET STYLESHEET

//**************************** END *******************************//

$object = new Kernel();
$object->_setHtml(_DIR_._VIEW_.'/welcome.tpl.html');
$_config->body = $object->_getHtml();