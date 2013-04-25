<?php

$nachricht="";

if ((isset($_POST["verleiher_vorname"]))){
		$verleiher_vorname = htmlentities(mysql_real_escape_string($_POST["verleiher_vorname"]));
		$verleiher_nachname = htmlentities(mysql_real_escape_string($_POST["verleiher_nachname"]));
		query(
			"insert into verleiher(`name`, `vorname`)
			values('".$verleiher_nachname."', '".$verleiher_vorname."')");
			
		$nachricht = "Neuer Verleiher erfolgreich eingetragen!";
		}
			
$tpl = tpl_replace_once("nachricht", $nachricht);
	

?>