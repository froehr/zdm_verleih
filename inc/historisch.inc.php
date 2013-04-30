<?php

//Datum von heute abfragen
$today = date("d.m.Y", time());

//MySQL abfrgaen aufgeteilt nach Überzogen, etc.
$historisch = query("SELECT DISTINCT * FROM `ausleihe` JOIN `ausleiher` INNER JOIN `verleiher` ON (ausleihe.verleiher_id = verleiher.verleiher_id) WHERE 'abgeschlossen' = 0000-00-00");

//Tabelle mit Daten für historisch füllen
if (mysql_num_rows($historisch) != 0) {
		while ($row = mysql_fetch_object($historisch)) {
			$tpl = copy_code("historisch");
			
			
			//Zeitstempel formatieren
			$bis = date("d.m.Y", strtotime($row->bis));
			$von = date("d.m.Y", strtotime($row->von));
			$abgeschlossen = date("d.m.Y", strtotime($row->abgeschlossen));
			
			//Mahngebühr berechnen
			$gebuehr = $abgeschlossen - $bis;
			
			if($gebuehr <= 5){
				$gebuehr = $gebuehr * 1;
			}
			else{
				$gebuehr = 5 + ($gebuehr - 5) * 2;
			}
				
			$tpl = tpl_replace_once("ausgeliehenvon", $row->vorname." ".$row->name);
			
			//Direkter Email-Versand mit Standardtext
			$tpl = tpl_replace_once("emailadresse", '<a href="mailto:'.$row->email.'?cc=zdm@uni-muenster.de">'.$row->email.'</a>');
			$tpl = tpl_replace_once("mahngebuehr", $gebuehr."&euro;");
			$tpl = tpl_replace_once("matrikelnummer", $row->matrikel);
			$tpl = tpl_replace_once("ausgeliehenzwischen", $von." - ".$bis);
			$tpl = tpl_replace_once("anzahlverlaengerung", $row->verlaengert);
			$tpl = tpl_replace_once("bisherigeverspätungen", $row->verspaetungen);
			$tpl = tpl_replace_once("verliehenvon", $row->verleiher_name);
		}
	}
	$tpl = clean_code("historisch");

?>