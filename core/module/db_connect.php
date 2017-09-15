<?php
/*************************
* db_connect.php v2.0.0 **
* for project Kernel    **
* Rapoo (c) 05.05.2016  **
*************************/

$mysqli = new mysqli(
			$_config->_getManifest()->db_config->db_host,
			$_config->_getManifest()->db_config->db_user,
			$_config->_getManifest()->db_config->db_pass,
			$_config->_getManifest()->db_config->db_name ); 

if (mysqli_connect_errno()) { 
   printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error()); 
   exit; 
}