<?php
/*************************
* controller.php v0.0.1 **
* for project Kernel    **
* Rapoo (c) 29.08.2017  **
*************************/

define('PATH', $_SERVER['DOCUMENT_ROOT']);
define('_DIR_', PATH.'/views/');

include_once(PATH.'/core/kernel.php');

$_NGET = explode('/', $_SERVER["REQUEST_URI"])[1];

$_NGET = (empty($_NGET)) ? "index" : $_NGET;

include_once(_DIR_.$_NGET.'/core.php');

include_once(PATH.'/core/base.php');
?>