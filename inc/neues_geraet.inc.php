<?php
	$errormessage = "";
	$successmessage = "";
	if ( isset($_POST["geraet_name"]) && isset($_POST["geraet_zubehoer"]) ) {
		$name = htmlentities(mysql_real_escape_string($_POST["geraet_name"]));
		if ( mysql_num_rows(query("SELECT `name` FROM `ausleihobjekt` WHERE `name`='".$name."'")) != 0 ) {
			$errormessage = "Der Name ist schon vergeben";
		}
		else {
			$zubehoer_form = htmlentities(mysql_real_escape_string($_POST["geraet_zubehoer"]));
			$zubehoer_array = explode("\\r\\n", $zubehoer_form);
			query("INSERT INTO `ausleihobjekt`(`name`) VALUES ('".$name."')");
			$successmessage = "Objekt Erfolgreich eingetragen";
			$objekt_id = mysql_insert_id();
			$zubehoer_objekt = "";
			foreach ($zubehoer_array AS $zubehoer) {
				query("INSERT INTO `zubehoer`(`objekt_id`, `name`) VALUES (".$objekt_id.",'".$zubehoer."')");
				if ($zubehoer_objekt == "") {
					$zubehoer_objekt = mysql_insert_id();
				}
				else {
					$zubehoer_objekt .= ",".mysql_insert_id();
				}
				$successmessage .= "<br>Zubehörobjekt ".$zubehoer." eingetragen.";
			}
			query("UPDATE `ausleihobjekt` SET `zubehoer`='".$zubehoer_objekt."' WHERE `objekt_id`=".$objekt_id);
			$successmessage .= "<br>Eintrag erfolgreich abgeschlossen";
		}
	}
	$tpl = tpl_replace("errormessage", $errormessage);
	$tpl = tpl_replace("successmessage", $successmessage);
?>