<?php
/**
 * Created by PhpStorm.
 * User: Rapoo
 * Date: 15.09.2017
 * Time: 16:50
 */

$_config->head .= '<link href="/views/_status/_status.css" rel="stylesheet">';

$_devPanel = new Kernel();
$_devPanel->_setHtml(_DIR_.'_status/_status.tpl.html');

$_devPanel->_setVar("http_response_code", http_response_code());
$_devPanel->_setVar("php_version", phpversion());
$_devPanel->_setVar("proj_version", $_config->_getManifest()->base->version);
$_devPanel->_setVar("load_speed", $_config->_endPage($start));
$_devPanel->_setVar("this_view", _VIEW_);
$_devPanel->_setVar("data_base", $_config->_getManifest()->db_config->db_name);

$jq = intval(explode(".",$_config->_getManifest()->assets->jquery)[0]-1);
$_devPanel->_setVar("jq_version", $_config->_getJQ($jq));

$_config->body .= $_devPanel->_getHtml();