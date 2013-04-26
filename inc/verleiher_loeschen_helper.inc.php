<?php
include("config.inc.php");
include("database.inc.php");
include("functions_general.inc.php");


$verleiher = $_POST["verleiher_id"];

query("DELETE FROM `verleiher` WHERE `verleiher_id` = '".$verleiher."'");
if(mysql_affected_rows() == 1){
	echo 1;
	}
		
	else{
	echo 0;
	}
?>