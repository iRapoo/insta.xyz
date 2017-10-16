<?php
/*************************
* controller.php v0.1.3 **
* for project Kernel    **
* Rapoo (c) 15.09.2017  **
*************************/

define('PATH', $_SERVER['DOCUMENT_ROOT']);
define('_DIR_', PATH.'/views/');
define('_VIEW_', $_GET['view']);
define('_ASSETS_', '/web/assets');

require_once PATH.'/core/kernel.php';

$start = $_config->_startPage();

//require_once _DIR_.'/_auth/_auth.php';

if(!file_exists(_DIR_._VIEW_))
{
    require_once PATH.'/core/err/404.php';
}

if(file_exists(_DIR_._VIEW_)
    AND !file_exists(_DIR_._VIEW_.'/core.php'))
{
    require_once PATH.'/core/err/403.php';
}

if(file_exists(_DIR_._VIEW_.'/core.php'))
{
    require_once _DIR_._VIEW_.'/core.php';
}

if($_config->_getManifest()->_status->enabled)
    require_once _DIR_.'/_status/_status.php';

require_once PATH.'/core/base.php';