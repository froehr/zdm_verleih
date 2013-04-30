<?php

//Datum von heute abfragen
$today = date("d.m.Y", time());

//MySQL abfrgaen aufgeteilt nach Überzogen, etc.
$ueberzogen = query("SELECT DISTINCT * FROM `ausleihe` JOIN `ausleiher` INNER JOIN `verleiher` ON (ausleihe.verleiher_id = verleiher.verleiher_id) WHERE `bis` < '".$today."'");
$faellig = query("SELECT DISTINCT * FROM `ausleihe` JOIN `ausleiher` INNER JOIN `verleiher` ON (ausleihe.verleiher_id = verleiher.verleiher_id) WHERE `bis` = '".$today."'");
$nochzeit = query("SELECT DISTINCT * FROM `ausleihe` JOIN `ausleiher` INNER JOIN `verleiher` ON (ausleihe.verleiher_id = verleiher.verleiher_id) WHERE `bis` > '".$today."'");

//Tabelle mit Daten für Überzogen füllen
if (mysql_num_rows($ueberzogen) != 0) {
		while ($row = mysql_fetch_object($ueberzogen)) {
			$tpl = copy_code("ueberzogen");
			
			//Zeitstempel formatieren
			$array = explode("-",$row->bis);
			$bis = $array[2].".".$array[1].".".$array[0];
			
			//Mahngebühr berechnen
			$gebuehr = $today - $bis;
			if($gebuehr <= 5){
				$gebuehr = $gebuehr * 1;
			}
			else{
				$gebuehr = 5 + ($gebuehr - 5) * 2;
			}
				
			$tpl = tpl_replace_once("ausgeliehenvon1", $row->vorname." ".$row->name);
			
			//Direkter Email-Versand mit Standardtext
			$tpl = tpl_replace_once("emailadresse1", '<a href="mailto:'.$row->email.'?cc=zdm@uni-muenster.de&bcc=&subject=&Uuml;berzogene Ausleihe&body=Hallo '.$row->vorname.',%0D%0D
				die Ausleihfrist f&uuml;r dein Transkriptionspedal ist am '.$bis.' abgelaufen. Bring das Pedal doch 
				bitte m&ouml;glichst schnell vorbei.%0D%0D 1 - 5 Tage Versp&auml;tung pro Tag jeweils 1 &euro;%0D 6 - 10 Tage 
				Versp&auml;tung pro Tag jeweils 2 &euro;%0Dzu zahlen dann mit Mensakarte.  %0D%0DGru&szlig;, %0D ZDM 
				Geowissenschaften">'.$row->email.'</a>');
			$tpl = tpl_replace_once("mahngebuehr1", $gebuehr."&euro;");
			$tpl = tpl_replace_once("matrikelnummer1", $row->matrikel);
			$tpl = tpl_replace_once("ausgeliehenbis1", $bis);
			$tpl = tpl_replace_once("anzahlverlaengerung1", $row->verlaengert);
			$tpl = tpl_replace_once("bisherigeverspätungen1", $row->verspaetungen);
			$tpl = tpl_replace_once("verliehenvon1", $row->verleiher_name);
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
			$tpl = tpl_replace_once("bisherigeverspätungen2", $row->verspaetungen);
			$tpl = tpl_replace_once("verliehenvon2", $row->verleiher_name);
		}
	}
	$tpl = clean_code("faellig");

//Tabelle mit Daten für noch Zeit füllen
if (mysql_num_rows($nochzeit) != 0) {
		while ($row = mysql_fetch_object($faellig)) {
			$tpl = copy_code("nochzeit");
			
			//Zeitstempel formatieren
			$array = explode("-",$row->bis);
			$bis = $array[2].".".$array[1].".".$array[0];
			
			$tpl = tpl_replace_once("ausgeliehenvon3", $row->vorname." ".$row->name);
			$tpl = tpl_replace_once("emailadresse3", $row->email);
			$tpl = tpl_replace_once("matrikelnummer3", $row->matrikel);
			$tpl = tpl_replace_once("ausgeliehenbis3", $bis);
			$tpl = tpl_replace_once("anzahlverlaengerung3", $row->verlaengert);
			$tpl = tpl_replace_once("bisherigeverspätungen3", $row->verspaetungen);
			$tpl = tpl_replace_once("verliehenvon3", $row->verleiher_name);
		}
	}
	$tpl = clean_code("nochzeit");
?>