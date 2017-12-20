<?php
/*************************
* kernel.php v3.0.1     **
* for project Kernel    **
* Rapoo (c) 28.08.2017  **
*************************/

class Manifest{

    public $title,$meta,$head,$body; //default variables
    public $css = array(); //default CSS
    public $js = array(); //default JavaScript

	function _getManifest(){

		$data = file_get_contents(PATH.'/core/manifest.json');
		$manifest = json_decode($data);

		return $manifest;
	}

	function _getMySQLi(){
        $mysqli = new mysqli(
            $this->_getManifest()->db_config->db_host,
            $this->_getManifest()->db_config->db_user,
            $this->_getManifest()->db_config->db_pass,
            $this->_getManifest()->db_config->db_name );

        mysqli_set_charset($mysqli, 'utf8');

        return $mysqli;
    }

	function _getJQ($key){

		$jq = ["jquery-1.12.3.min.js","jquery-2.2.3.min.js","jquery-3.2.1.min.js"]; //JQuery versions

		return $jq[$key];
	}

	function _startPage(){
        $time = microtime(); $time = explode(' ', $time); $time = $time[1] + $time[0]; $start = $time;

        return $start;
    }

    function _endPage($start){
        $time = microtime(); $time = explode(' ', $time); $time = $time[1] + $time[0];
        $finish = $time; $total_time = round(($finish - $start), 4);

        return $total_time;
    }

    function _getPages($link = "", $_pages = ""){

        $handle = fopen(PATH."/pages.txt", "r");

        while (!feof($handle)) {
            $buffer = fgets($handle, 4096);
            $buffer = explode("::", $buffer);

            $other = new Kernel();
            $other->_setHtml(PATH."/web/pages.tpl.html");

            $other->_setVar("link", $buffer[0]);
            $other->_setVar("name_link", $buffer[1]);

            if($link==$buffer[0])
                $link = $buffer[1];

            $_pages .= $other->_getHtml();
        }

        fclose($handle);

        return (!empty($link)) ? $link : $_pages;

    }

}

$_config = new Manifest;

foreach(glob(PATH."/core/module/*.php") as $_module)
{
    require_once $_module;
}