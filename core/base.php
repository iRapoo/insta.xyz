<?php
/*************************
* base.php v1.0.1       **
* for project Kernel    **
* Rapoo (c) 09.05.2016  **
*************************/

$base = new Kernel();
$base->_setHtml(PATH."/web/".$_config->_getManifest()->assets->template);

$_config->meta = '<META HTTP-EQUIV="Content-language" content ="'.$_config->_getManifest()->base->language.'">
		<meta http-equiv="Content-Type" content="text/html; charset='.$_config->_getManifest()->base->encoding.'" >';

foreach ($_config->_getManifest()->assets->css as $key => $value) {
    $_config->head .= '<link href="/web/assets/'.$value.'" rel="stylesheet">';
}

foreach ($_config->css as $key => $value){

    //$_config->head .= (strripos($value, "web")) ? '<link href="'.$value.'" rel="stylesheet">' : '<link href="/web/assets/css/'.$value.'" rel="stylesheet">';
    $_config->head .= '<link href="'.$value.'" rel="stylesheet">';
}

$jq = intval(explode(".",$_config->_getManifest()->assets->jquery)[0]-1);
$_config->head .= '<script src="/core/jquery/'.$_config->_getJQ($jq).'"></script>';

foreach ($_config->_getManifest()->assets->js as $key => $value) {
	$_config->head .= '<script src="/web/assets/'.$value.'"></script>';
}

foreach ($_config->js as $key => $value){
    $_config->head .= (strripos($value, "web")) ? '<script src="'.$value.'"></script>' : '<script src="/web/assets/js/'.$value.'"></script>';
}

$base->_setVar("title", $_config->title);
$base->_setVar("meta", $_config->meta);
$base->_setVar("stylesheet", $_config->head);
$base->_setVar("body", $_config->body);

echo $base->_getHtml();
unset($_config);