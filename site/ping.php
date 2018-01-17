<?php
//Config Database information
$host = "127.0.0.1";	//MySQL Host address
$user = "root";		//MySQL Username
$pass = "root";	//MySQL Password
$db = "evemu";		//Databse name
$port = 26000;		//Server port

$img = "";

function ping_evedb(){
global $host, $port;
$s = @fsockopen("$host", $port, $ERROR_NO, $ERROR_STR,(float)0.5);
if($s){@fclose($s);return true;} else return false;
}

if (ping_evedb()) {
	($img = "imgs/on.jpg");
}else{
	($img = "imgs/off.jpg");
}
?>