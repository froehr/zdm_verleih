<?php

$nachricht="";

if ((isset($_POST["verleiher_vorname"]))){
		$verleiher_vorname = htmlentities(mysql_real_escape_string($_POST["verleiher_vorname"]));
		$verleiher_nachname = htmlentities(mysql_real_escape_string($_POST["verleiher_nachname"]));
		query(
			"insert into verleiher(`verleiher_name`, `verleiher_vorname`)
			values('".$verleiher_nachname."', '".$verleiher_vorname."')");
			
		

			
		//Abfrage ob wirklich etwas eingefügt wurde
		if(mysql_affected_rows() ==1){
	
		$nachricht ='<script>
						alertify.success("'.$verleiher_vorname.' '.$verleiher_nachname.' '.'wurde erfolgreich in die Datenbank eingef&uuml;gt!");
					</script>';
		}
		else{
		$nachricht ='<script>
						alertify.error("'.$verleiher_vorname.' '.$verleiher_nachname.' '.'konnte nicht in die Datenbank eingef&uuml;gt werden!");
					</script>';
		//wenn keine löschung möglich dann keine Abfrage ob gelöscht werden darf 
		$abfrage ="";
		}	
}
			
			
			
$tpl = tpl_replace_once("nachricht", $nachricht);
	

?>