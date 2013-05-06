<?php

//Datum von heute abfragen
$today = date("d.m.Y", time());

//MySQL abfrgaen aufgeteilt nach Überzogen, etc.
$alt = query("SELECT DISTINCT * FROM `ausleihe` INNER JOIN `ausleiher` ON (ausleihe.matrikel = ausleiher.matrikel) INNER JOIN `verleiher` ON (ausleihe.verleiher_id = verleiher.verleiher_id) WHERE `abgeschlossen` != '0000-00-00'");

//Tabelle mit Daten für alt füllen
if (mysql_num_rows($alt) != 0) {
		while ($row = mysql_fetch_object($alt)) {
			$tpl = copy_code("historisch");
			
			//2 Date objekte erzeugen
			$datetime1 = new DateTime($row->bis);
			$datetime2 = new DateTime($row->abgeschlossen);
			
			//Intervall berechnen und in INt umformen
			$interval = date_diff($datetime1, $datetime2);
			$gebuehr = $interval->format('%R%a days');
			
		if($gebuehr >= 0){
			if($gebuehr <= 5){
				$gebuehr = $gebuehr * 1;
			}
			else{
				$gebuehr = 5 + ($gebuehr - 5) * 2;
			}
		}
		else($gebuehr = 0);
		
			
			$tpl = tpl_replace_once("ausgeliehenzwischen", date("d.m.Y", strtotime($row->von))." - ".date("d.m.Y", strtotime($row->bis)));	
			$tpl = tpl_replace_once("ausgeliehenvon", $row->vorname." ".$row->name);
			$tpl = tpl_replace_once("verliehenvon", $row->verleiher_vorname." ".$row->verleiher_name);
			$tpl = tpl_replace_once("mahngebuehr", $gebuehr."&euro;");
			$tpl = tpl_replace_once("emailadresse", '<a href="mailto:'.$row->email.'?cc=zdm@uni-muenster.de">'.$row->email.'</a>');
			$tpl = tpl_replace_once("matrikelnummer", $row->matrikel);
			$tpl = tpl_replace_once("anzahlverlaengerung", $row->verlaengert);
			
		}
	}
	$tpl = clean_code("historisch");
?>