<?php

//************************** HEADERS *******************************//

$TITLE = "Welcome! ".$_config->_getManifest()->base->name; //SET TITLE
$HEAD .= '<link href="'._ASSETS_.'/css/base.css" rel="stylesheet">'; //SET STYLESHEET

//**************************** END *******************************//

$object = new Kernel();
$object->_setHtml(_DIR_._VIEW_.'/welcome.tpl.html');
$BODY = $object->_getHtml();