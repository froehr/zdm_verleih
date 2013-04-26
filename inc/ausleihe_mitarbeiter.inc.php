<?php
$verleiher_name="";

//Dropdown für den Verleiher füllen
	$query = query("SELECT vorname FROM `verleiher` ORDER BY `vorname`");
	if (mysql_num_rows($query) != 0) {
		while ($row = mysql_fetch_object($query)) {
			$tpl = copy_code("verleiher");
 			$name = $row->vorname;
			if ($row->vorname != 0) {
				$name .= " ".$row->vorname;
			}
			$tpl = tpl_replace_once("verleiher_name", $row->vorname);
		}
	}
	$tpl = clean_code("verleiher");
//Anfangsdatum mit heute füllen
$tpl =tpl_replace("anfangsdatum", date("d.m.Y"));
?>