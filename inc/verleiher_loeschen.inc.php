<?php

$nachricht="";
//Dropdown füllen
	$query = query("SELECT vorname, name, verleiher_id FROM `verleiher` ORDER BY `vorname`");
	if (mysql_num_rows($query) != 0) {
		while ($row = mysql_fetch_object($query)) {
			$tpl = copy_code("verleiher");
 			$name = $row->vorname;
			if ($row->vorname != 0) {
				$name .= $row->vorname;
			}
			$replace = $row->vorname." ".$row->name." ".$row->verleiher_id;
			$tpl = tpl_replace_once("verleiher_name", $replace);
		}
	}
	$tpl = clean_code("verleiher");


if ((isset($_POST["verleiher_drop"]))){
	$verleiher = htmlentities(mysql_real_escape_string($_POST["verleiher_drop"]));
	$array = explode(" ", $verleiher);
	query("DELETE FROM `verleiher` WHERE `verleiher_id` = '".$array[2]."'");
	$nachricht = "Verleiher erfolgreich gelöscht";
	
	
	}
	
	$tpl = tpl_replace_once("nachricht", $nachricht);
?>
