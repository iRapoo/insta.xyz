<?php
/**
 * Created by PhpStorm.
 * User: Rapoo
 * Date: 15.09.2017
 * Time: 16:50
 */

$_devPanel = new Kernel();
$_devPanel->_setHtml(_DIR_.'devPanel/panel.tpl.html');

$_devPanel->_setVar("http_response_code", http_response_code());
$_devPanel->_setVar("php_version", phpversion());
$_devPanel->_setVar("proj_version", $_config->_getManifest()->base->version);
$_devPanel->_setVar("load_speed", $_config->_endPage($start));
$_devPanel->_setVar("this_view", _VIEW_);

if($_config->_getManifest()->base->devPanel)
    $BODY .= $_devPanel->_getHtml();