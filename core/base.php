<?php
/*************************
* base.php v1.0.1       **
* for project Kernel    **
* Rapoo (c) 09.05.2016  **
*************************/

$base = new Kernel();
$base->_setHtml(PATH."/web/".$_config->_getManifest()->assets->template);

$META = '<META HTTP-EQUIV="Content-language" content ="'.$_config->_getManifest()->clanguage.'">
		<meta http-equiv="Content-Type" content="text/html; charset='.$_config->_getManifest()->ctype.'" />';

$jq = intval(explode(".",$_config->_getManifest()->assets->jquery)[0]-1);
$JQUERY = '<script src="/core/libs/'.$_config->_getJQ($jq).'"></script>';

foreach ($_config->_getManifest()->assets->css as $key => $value) {
	$ASSETS .= '<link href="/web/assets/'.$value.'" rel="stylesheet">';
}

foreach ($_config->_getManifest()->assets->js as $key => $value) {
	$ASSETS .= '<script src="/web/assets/'.$value.'"></script>';
}

$base->_setVar("title", $TITLE);
$base->_setVar("meta", $META);
$base->_setVar("stylesheet", $JQUERY.$ASSETS.$HEAD);
$base->_setVar("body", (empty($BODY)) ? "<center>Created view: ".$_NGET.'</center>' : $BODY);

echo $base->_getHtml();
unset($__config);

?>