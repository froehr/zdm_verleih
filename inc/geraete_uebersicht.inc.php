<?php
$geraet = query("SELECT * FROM `ausleihobjekt` ORDER BY `geraet_typ`");

//Tabelle mit Daten für Geräte füllen
if (mysql_num_rows($geraet) != 0) {
		while ($row = mysql_fetch_object($geraet)) {
				
			$tpl = copy_code("uebersicht");
			
			$zubehör = query("SELECT DISTINCT `name` FROM `zubehoer` INNER JOIN `ausleihobjekt` WHERE zubehoer.objekt_id = ".$row->objekt_id."");
			if (mysql_num_rows($zubehör) != 0) {
				while ($row2 = mysql_fetch_object($zubehör)) {
				
				$text .= $row2->name."</br>";
				}
			}
					
			$tpl = tpl_replace_once("name", $row->geraet_typ." (".$row->geraet_typ_id.")");
			$tpl = tpl_replace_once("zubehoer", $text." ");
			$text ="";
			$tpl = tpl_replace_once("verliehen", $row->geraet_typ." ".$row->gereate_typ_id);
			
		}
	}
	$tpl = clean_code("uebersicht");


?>