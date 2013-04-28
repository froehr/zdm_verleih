<?php

$nachricht="";
$abfrage="";

//Benachrichtigung vor dem löschen
$achtung='<script>
					alertify.alert("Achtung, das L&ouml;schen von Verleihern kann nicht r&uuml;ckg&auml;ngig gemacht werden!");
		  </script>';
		  
		  
//Dropdown füllen
	$query = query("SELECT verleiher_vorname, verleiher_name, verleiher_id FROM `verleiher` ORDER BY `verleiher_vorname`");
	if (mysql_num_rows($query) != 0) {
		while ($row = mysql_fetch_object($query)) {
			$tpl = copy_code("verleiher");
 			$name = $row->vorname;
			if ($row->vorname != 0) {
				$name .= $row->vorname;
			}
			$replace = $row->verleiher_vorname." ".$row->verleiher_name." ".$row->verleiher_id;
			$tpl = tpl_replace_once("verleiher_name", $replace);
		}
	}
	$tpl = clean_code("verleiher");


if ((isset($_POST["verleiher_drop"]))){
	$verleiher = htmlentities(mysql_real_escape_string($_POST["verleiher_drop"]));
	$array = explode(" ", $verleiher);
	$verleiher_id = end($array);	
	
	$abfrage = '<script type="text/javascript">	
					alertify.confirm("Soll der Verleiher wirklich gelöscht werden?",function (e){
						if(e){
							var http = new XMLHttpRequest();
							http.open("POST", "inc/verleiher_loeschen_helper.inc.php", false);
							http.setRequestHeader(
      							"Content-Type",
    							"application/x-www-form-urlencoded");
							http.send("verleiher_id='.$verleiher_id.'");
							var help;
							help = http.responseText;
    						if(help == 1){
    							alertify.success("'.$array[0].' '.$array[1].' wurde erfolgreich aus der Datenbank gel&ouml;scht!");
    						}
    						else{
    							alertify.error("'.$array[0].' '.$array[1].' '.'wurde bereits aus der Datenbank gel&ouml;scht!");
    						}
   						} 
   						else {
   						 	alertify.error("L&ouml;schen wurde vom Benutzer abgebrochen!");
   					 	}
					});
				</script>';
				
	$tpl = tpl_replace("abfrage", $abfrage);
	
	//Abfrage ob wirklich etwas gelöscht wurde oder, ob versucht wurde einen Verleiher 2mal zu löschen
	$achtung="";
	
	//wenn keine löschung möglich dann keine Abfrage ob gelöscht werden darf 
	echo $abfrage;
	}
	echo $abfrage;
	
	$tpl = tpl_replace("nachricht", $nachricht);
	$tpl = tpl_replace("achtung", $achtung);
	$tpl = tpl_replace("abfrage", $abfrage);
?>