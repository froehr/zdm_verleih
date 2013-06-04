<?php
	$errormessage = "";
	$successmessage = "";
	$name = "";
	$number = 1;
	$zubehoer = "";
	if ( !isset($_GET["geraet"]) ) {
		$errormessage = "Kein Ger&auml;t angegeben!";
	}
	else {
		$geraet_objekt_id = intval($_GET["geraet"]);
		$query = query("SELECT * FROM `ausleihobjekt` WHERE `objekt_id`=".$geraet_objekt_id);
		if (mysql_num_rows($query) != 0) {
			$row = mysql_fetch_object($query);
			$name = $row->geraet_typ;
			$number = $row->geraet_typ_id;
			if ($row->zubehoer != "") {
				$zubehoerteile = query("SELECT `name` FROM `zubehoer` WHERE `objekt_id`=".$geraet_objekt_id." ORDER BY `zubehoer_id`");
				if (mysql_num_rows($zubehoerteile) != 0) {
					while ( $row2 = mysql_fetch_object($zubehoerteile) ) {
						$zubehoer .= $row2->name."\n";
					}
				}
			}
		}
		if ( isset($_POST["geraet_name"]) AND isset($_POST["geraet_nummer"]) AND isset($_POST["geraet_zubehoer"]) ) {
			$name = htmlentities(mysql_real_escape_string($_POST["geraet_name"]));
			$nummer = intval($_POST["geraet_nummer"]);
			if ( mysql_num_rows(query("SELECT `objekt_id` FROM `ausleihobjekt` WHERE `objekt_id`=".$geraet_objekt_id)) == 0 ) {
				$errormessage = "Das Gerät gibt es nicht!";
			}
			else {
				$zubehoer_form = htmlentities(mysql_real_escape_string($_POST["geraet_zubehoer"]));
				$zubehoer_array = explode("\\r\\n", $zubehoer_form);
				query("UPDATE `ausleihobjekt` SET `geraet_typ`='".$name."',`geraet_typ_id`=".$nummer." WHERE `objekt_id`=".$geraet_objekt_id);
				query("DELETE FROM `zubehoer` WHERE `objekt_id`=".$geraet_objekt_id);
				$successmessage = "Objektdaten Erfolgreich eingetragen";
				$zubehoer_objekt = "";
				foreach ($zubehoer_array AS $zubehoer) {
					query("INSERT INTO `zubehoer`(`objekt_id`, `name`) VALUES (".$geraet_objekt_id.",'".$zubehoer."')");
					if ($zubehoer_objekt == "") {
						$zubehoer_objekt = mysql_insert_id();
					}
					else {
						$zubehoer_objekt .= ",".mysql_insert_id();
					}
					$successmessage .= "<br>Zubeh&ouml;robjekt ".$zubehoer." eingetragen.";
				}
				query("UPDATE `ausleihobjekt` SET `zubehoer`='".$zubehoer_objekt."' WHERE `objekt_id`=".$geraet_objekt_id);
				$successmessage .= "<br>Eintrag erfolgreich abgeschlossen";
			}
		}
	}
	$tpl = tpl_replace("name", $name);
	$tpl = tpl_replace("number", $number);
	$tpl = tpl_replace("zubehoer", $zubehoer);
	$tpl = tpl_replace("errormessage", $errormessage);
	$tpl = tpl_replace("successmessage", $successmessage);
?>