<?php

//************************** HEADERS *******************************//

$TITLE = "Welcome! ".$_config->_getManifest()->base->name; //SET TITLE
$HEAD .= '<link href="/web/assets/css/index.css" rel="stylesheet">'; //SET STYLESHEET

//**************************** END *******************************//

$object = new Kernel();
$object->_setHtml(_DIR_.'index/welcome.tpl.html');
$BODY = $object->_getHtml();