<?php

include("config.inc.php");
include("database.inc.php");
include("functions_general.inc.php");

if ( isset($_POST["inkasso_id"]) ) {

$inkasso_id = htmlentities(mysql_real_escape_string($_POST["inkasso_id"]));

query("UPDATE `inkassoliste` SET `bezahlt`= '1' WHERE `inkasso_id` ='".$inkasso_id."'");

if(mysql_affected_rows() == 1){
	echo 1;
	}
		
	else{
	echo 0;
	}
}



?>