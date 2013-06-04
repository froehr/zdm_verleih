<?php
	$errormessage = "";
	$successmessage = "";
	if ( isset($_GET["geraet"]) ) {
		$geraet_objekt_id = intval($_GET["geraet"]);
		if ( isset($_POST[""])){
		$name = htmlentities(mysql_real_escape_string($_POST["geraet_name"]));
		$nummer = intval($_POST["geraet_nummer"]);
		if ( mysql_num_rows(query("SELECT `name` FROM `ausleihobjekt` WHERE `geraet_typ`='".$name."' AND `geraet_typ_id`=".$nummer)) != 0 ) {
			$errormessage = "Der Name ist schon vergeben";
		}
		else {
			$zubehoer_form = htmlentities(mysql_real_escape_string($_POST["geraet_zubehoer"]));
			$zubehoer_array = explode("\\r\\n", $zubehoer_form);
			query("INSERT INTO `ausleihobjekt`(`geraet_typ`,`geraet_typ_id`) VALUES ('".$name."',".$nummer.")");
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
	}
	$tpl = tpl_replace("errormessage", $errormessage);
	$tpl = tpl_replace("successmessage", $successmessage);
?>