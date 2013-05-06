<?php

//Datum von heute abfragen
$today = date("d.m.Y", time());

//Datum für SQL-Abfrage
$heute = date("Y-m-d", time());
$heuteplus = date("d.m.Y", time()+ 604800);

//MySQL abfrgaen aufgeteilt nach Überzogen, etc.
$ueberzogen = query("SELECT DISTINCT * FROM `ausleihe` INNER JOIN `ausleiher` ON (ausleihe.matrikel = ausleiher.matrikel) INNER JOIN `verleiher` ON (ausleihe.verleiher_id = verleiher.verleiher_id) WHERE `bis` < '".$heute."' AND `abgeschlossen` = '0000-00-00'");
$faellig = query("SELECT DISTINCT * FROM `ausleihe` INNER JOIN `ausleiher` ON (ausleihe.matrikel = ausleiher.matrikel) INNER JOIN `verleiher` ON (ausleihe.verleiher_id = verleiher.verleiher_id) WHERE `bis` = '".$heute."' AND `abgeschlossen` = '0000-00-00'");
$nochzeit = query("SELECT DISTINCT * FROM `ausleihe` INNER JOIN `ausleiher` ON (ausleihe.matrikel = ausleiher.matrikel) INNER JOIN `verleiher` ON (ausleihe.verleiher_id = verleiher.verleiher_id) WHERE `bis` > '".$heute."' AND `abgeschlossen` = '0000-00-00'");

//Tabelle mit Daten für Überzogen füllen
if (mysql_num_rows($ueberzogen) != 0) {
		while ($row = mysql_fetch_object($ueberzogen)) {
			$tpl = copy_code("ueberzogen");
			
			//Zeitstempel formatieren
			$array = explode("-",$row->bis);
			$bis = $array[2].".".$array[1].".".$array[0];
			
			//2 Date objekte erzeugen
			$datetime1 = new DateTime($row->bis);
			$datetime2 = new DateTime(date("Y-m-d", time()));
			
			//Intervall berechnen und in INt umformen
			$interval = date_diff($datetime1, $datetime2);
			$gebuehr = $interval->format('%R%a days');
			
			if($gebuehr <= 5){
				$gebuehr = $gebuehr * 1;
			}
			else{
				$gebuehr = 5 + ($gebuehr - 5) * 2;
			}
				
			$tpl = tpl_replace_once("ausgeliehenvon1", $row->vorname." ".$row->name);
			
			//Direkter Email-Versand mit Standardtext
			$tpl = tpl_replace_once("emailadresse1", $row->email);
			$tpl = tpl_replace_once("mahngebuehr1", $gebuehr."&euro;");
			$tpl = tpl_replace_once("matrikelnummer1", $row->matrikel);
			$tpl = tpl_replace_once("ausgeliehenbis1", $bis);
			$tpl = tpl_replace_once("anzahlverlaengerung1", $row->verlaengert);
			$tpl = tpl_replace_once("bisherigeverspaetungen1", $row->verspaetungen);
			$tpl = tpl_replace_once("verliehenvon1", $row->verleiher_vorname." ".$row->verleiher_name);
			$tpl = tpl_replace_once("aktionen1",   '<img src="img/rueckgabe.png" alt="rueckgabe" onClick=
			
			\'alertify.confirm("Soll die Ausleihe wirklich beendet werden?",function (e){
						if(e){
							var http = new XMLHttpRequest();
							http.open("POST", "inc/ueberzogen_helper.inc.php", false);
							http.setRequestHeader(
      							"Content-Type",
    							"application/x-www-form-urlencoded");
							http.send("ausleih_id='.$row->ausleih_id.'&rueckgabe=1");
							var help;
							help = http.responseText;
    						if(help == 1){
    							alertify.success("Die Ausleihe wurde erfolgreich aus der Datenbank gel&ouml;scht!");
    						}
    						else{
    							alertify.error("Die Ausleihe wurde bereits aus der Datenbank gel&ouml;scht!");
    						}
   						} 
   						else {
   						 	alertify.error("R&uuml;ckgabe wurde vom Benutzer abgebrochen!");
   					 	}
					});\'>
													
					<a href="mailto:'.$row->email.'?cc=zdm@uni-muenster.de&bcc=&subject=&Uuml;berzogene Ausleihe&body=Hallo '.$row->vorname.',%0D%0D
						die Ausleihfrist f&uuml;r dein Transkriptionspedal ist am '.$bis.' abgelaufen. Bring das Pedal doch 
						bitte m&ouml;glichst schnell vorbei.%0D%0D 1 - 5 Tage Versp&auml;tung pro Tag jeweils 1 &euro;%0D 6 - 10 Tage 
						Versp&auml;tung pro Tag jeweils 2 &euro;%0Dzu zahlen dann mit Mensakarte.  %0D%0DGru&szlig;, %0D ZDM 
						Geowissenschaften"><img src="img/mahnung.png" alt="mahnung"></a>
						
					<img src="img/verlaengerung.png" alt="verlaengerung" onClick=
			
			\'alertify.prompt("Bis wann soll die Ausleihe verl&auml;ngert werden?", function (e, str) {
						if(e){
							var http = new XMLHttpRequest();
							var data = str;
							http.open("POST", "inc/ueberzogen_helper.inc.php", false);
							http.setRequestHeader(
      							"Content-Type",
    							"application/x-www-form-urlencoded");
							http.send("ausleih_id='.$row->ausleih_id.'&verlaengert=1&bis=" + data);
							var help;
							help = http.responseText;
							alert(help);
    						if(help == 1){
    							alertify.success("Die Ausleihe wurde erfolgreich verl&auml;ngert! Bitte Seite neu laden.");
    						}
    						else{
    							alertify.error("Die Ausleihe konnte nicht verl&auml;ngert werden!");
    						}
   						} 
   						else {
   						 	alertify.error("Verl&auml;ngerung wurde vom Benutzer abgebrochen!");
   					 	}
					}, "'.$heuteplus.'");\'>
			
			');
		}
	}
	$tpl = clean_code("ueberzogen");
	
//Tabelle mit Daten für fällig füllen
if (mysql_num_rows($faellig) != 0) {
		while ($row = mysql_fetch_object($faellig)) {
			$tpl = copy_code("faellig");
			
			//Zeitstempel formatieren
			$array = explode("-",$row->bis);
			$bis = $array[2].".".$array[1].".".$array[0];
			
			$tpl = tpl_replace_once("ausgeliehenvon2", $row->vorname." ".$row->name);
			$tpl = tpl_replace_once("emailadresse2", $row->email);
			$tpl = tpl_replace_once("matrikelnummer2", $row->matrikel);
			$tpl = tpl_replace_once("ausgeliehenbis2", $bis);
			$tpl = tpl_replace_once("anzahlverlaengerung2", $row->verlaengert);
			$tpl = tpl_replace_once("bisherigeverspaetungen2", $row->verspaetungen);
			$tpl = tpl_replace_once("verliehenvon2", $row->verleiher_vorname." ".$row->verleiher_name);
			
			$tpl = tpl_replace_once("aktionen2",   '<img src="img/rueckgabe.png" alt="rueckgabe" onClick=
			
			\'alertify.confirm("Soll die Ausleihe wirklich beendet werden?",function (e){
						if(e){
							var http = new XMLHttpRequest();
							http.open("POST", "inc/ueberzogen_helper.inc.php", false);
							http.setRequestHeader(
      							"Content-Type",
    							"application/x-www-form-urlencoded");
							http.send("ausleih_id='.$row->ausleih_id.'&rueckgabe=1");
							var help;
							help = http.responseText;
    						if(help == 1){
    							alertify.success("Die Ausleihe wurde erfolgreich beendet!");
    						}
    						else{
    							alertify.error("Die Ausleihe wurde bereits abgeschlossen!");
    						}
   						} 
   						else {
   						 	alertify.error("R&uuml;ckgabe wurde vom Benutzer abgebrochen!");
   					 	}
					});\'>
													
					<a href="mailto:'.$row->email.'?cc=zdm@uni-muenster.de"><img src="img/mahnung.png" alt="mahnung"></a>
						
					<img src="img/verlaengerung.png" alt="verlaengerung" onClick=
			
			\'alertify.prompt("Bis wann soll die Ausleihe verl&auml;ngert werden?", function (e, str) {
						if(e){
							var http = new XMLHttpRequest();
							var data = str;
							http.open("POST", "inc/ueberzogen_helper.inc.php", false);
							http.setRequestHeader(
      							"Content-Type",
    							"application/x-www-form-urlencoded");
							http.send("ausleih_id='.$row->ausleih_id.'&verlaengert=1&bis=" + data);
							var help;
							help = http.responseText;
    						if(help == 1){
    							alertify.success("Die Ausleihe wurde erfolgreich verl&auml;ngert! Bitte Seite neu laden.");
    						}
    						else{
    							alertify.error("Die Ausleihe konnte nicht verl&auml;ngert werden!");
    						}
   						} 
   						else {
   						 	alertify.error("Verl&auml;ngerung wurde vom Benutzer abgebrochen!");
   					 	}
					}, "'.$heuteplus.'");\'>
			
			');
		}
	}
	$tpl = clean_code("faellig");

//Tabelle mit Daten für noch Zeit füllen
if (mysql_num_rows($nochzeit) != 0) {
		while ($row = mysql_fetch_object($nochzeit)) {
			$tpl = copy_code("nochzeit");
			
			//Zeitstempel formatieren
			$array = explode("-",$row->bis);
			$bis = $array[2].".".$array[1].".".$array[0];
			
			$tpl = tpl_replace_once("ausgeliehenvon3", $row->vorname." ".$row->name);
			$tpl = tpl_replace_once("emailadresse3", $row->email);
			$tpl = tpl_replace_once("matrikelnummer3", $row->matrikel);
			$tpl = tpl_replace_once("ausgeliehenbis3", $bis);
			$tpl = tpl_replace_once("anzahlverlaengerung3", $row->verlaengert);
			$tpl = tpl_replace_once("bisherigeverspaetungen3", $row->verspaetungen);
			$tpl = tpl_replace_once("verliehenvon3", $row->verleiher_vorname." ".$row->verleiher_name);
			
			$tpl = tpl_replace_once("aktionen3",   '<img src="img/rueckgabe.png" alt="rueckgabe" onClick=
			
			\'alertify.confirm("Soll die Ausleihe wirklich beendet werden?",function (e){
						if(e){
							var http = new XMLHttpRequest();
							http.open("POST", "inc/ueberzogen_helper.inc.php", false);
							http.setRequestHeader(
      							"Content-Type",
    							"application/x-www-form-urlencoded");
							http.send("ausleih_id='.$row->ausleih_id.'&rueckgabe=1");
							var help;
							help = http.responseText;
    						if(help == 1){
    							alertify.success("Die Ausleihe wurde erfolgreich beendet!");
    						}
    						else{
    							alertify.error("Die Ausleihe wurde bereits abgeschlossen!");
    						}
   						} 
   						else {
   						 	alertify.error("R&uuml;ckgabe wurde vom Benutzer abgebrochen!");
   					 	}
					});\'>
													
					<a href="mailto:'.$row->email.'?cc=zdm@uni-muenster.de"><img src="img/email.png" alt="email"></a>
						
					<img src="img/verlaengerung.png" alt="verlaengerung" onClick=
			
			\'alertify.prompt("Bis wann soll die Ausleihe verl&auml;ngert werden?", function (e, str) {
						if(e){
							var http = new XMLHttpRequest();
							var data = str;
							http.open("POST", "inc/ueberzogen_helper.inc.php", false);
							http.setRequestHeader(
      							"Content-Type",
    							"application/x-www-form-urlencoded");
							http.send("ausleih_id='.$row->ausleih_id.'&verlaengert=1&bis=" + data);
							var help;
							help = http.responseText;
    						if(help == 1){
    							alertify.success("Die Ausleihe wurde erfolgreich verl&auml;ngert! Bitte Seite neu laden.");
    						}
    						else{
    							alertify.error("Die Ausleihe konnte nicht verl&auml;ngert werden!");
    						}
   						} 
   						else {
   						 	alertify.error("Verl&auml;ngerung wurde vom Benutzer abgebrochen!");
   					 	}
					}, "'.$heuteplus.'");\'>
			
			');
		}
	}
	$tpl = clean_code("nochzeit");
?>