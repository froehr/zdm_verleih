<?php
	$errormessage = "";
	$successmessage = "";
	if ( isset($_POST["geraet_name"]) && isset($_POST["geraet_nummer"]) && isset($_POST["geraet_zubehoer"]) ) {
		$name = htmlentities(mysql_real_escape_string($_POST["geraet_name"]));
		$nummer = intval($_POST["geraet_nummer"]);
		$result = query("SELECT `geraet_typ`, `geraet_typ_id` FROM `ausleihobjekt` WHERE `geraet_typ`='".$name."' AND `geraet_typ_id`=".$nummer);
		if (mysql_num_rows($result) != 0 ) {
		$errormessage = '<script>
							alertify.error("Der Name '.$name.' '.$nummer.' ist bereits vergeben!");
						</script>';
		}
		
		else {
			$zubehoer_form = htmlentities(mysql_real_escape_string($_POST["geraet_zubehoer"]));
			$zubehoer_array = explode("\\r\\n", $zubehoer_form);
			query("INSERT INTO `ausleihobjekt`(`geraet_typ`,`geraet_typ_id`) VALUES ('".$name."',".$nummer.")");
			$successmessage = '<script>
									alertify.success("Objekt '.$name.' '.$nummer.' erfolgreich eingetragen!");
							   </script>';
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
				$successmessage .= '<script>
										alertify.log("Das Zubehšr '.$zubehoer.'</br> wurde erfolgreich eingetragen!");
									</script>';
			}
			query("UPDATE `ausleihobjekt` SET `zubehoer`='".$zubehoer_objekt."' WHERE `objekt_id`=".$objekt_id);
			$successmessage .= '<script>
									alertify.success("Eintrag erfolgreich abgeschlossen!");
								</script>';
		}
	}
	$tpl = tpl_replace("errormessage", $errormessage);
	$tpl = tpl_replace("successmessage", $successmessage);
?>