<?php
/*************************
* kernel.php v3.0.1     **
* for project Kernel    **
* Rapoo (c) 28.08.2017  **
*************************/

class Manifest{

	function _getManifest(){

		$data = file_get_contents(PATH.'/core/manifest.json');
		$manifest = json_decode($data);

		return $manifest;

	}

	function _getJQ($key){

		$jq = ["jquery-1.12.3.min.js","jquery-2.2.3.min.js","jquery-3.2.1.min.js"]; //JQuery versions

		return $jq[$key];
	}

}

$_config = new Manifest;

foreach ($_config->_getManifest()->module as $key => $value) {
	include_once(PATH.'/core/base/'.$value.'.php');
}

?>