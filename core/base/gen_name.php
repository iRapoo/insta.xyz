<?php

function genName($chars,$max){
	$chars=(!$chars)?"1234567890qazxswedcvfrtgbnhyujmkiolp":$chars; 
	$max=(!$max)?10:$max; 
	$size=StrLen($chars)-1; 
	$name=null; 

		while($max--) 
		$name.= $chars[rand(0,$size)];
		
	return "qx_".$name;
}

?>