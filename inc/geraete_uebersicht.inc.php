<?php
$geraet = query("SELECT * FROM `ausleihobjekt` ORDER BY `geraet_typ`");

//Tabelle mit Daten für Geräte füllen
if (mysql_num_rows($geraet) != 0) {
		while ($row = mysql_fetch_object($geraet)) {
				
			$tpl = copy_code("uebersicht");
			$text ="";
			
			$zubehör = query("SELECT DISTINCT `name` FROM `zubehoer` INNER JOIN `ausleihobjekt` WHERE zubehoer.objekt_id = ".$row->objekt_id."");
			if (mysql_num_rows($zubehör) != 0) {
				while ($row2 = mysql_fetch_object($zubehör)) {
				
				
				$text .= $row2->name."</br>";
				}
			}
					
			$tpl = tpl_replace_once("name", $row->geraet_typ." (".$row->geraet_typ_id.")");
			$tpl = tpl_replace_once("zubehoer", $text." ");
			$text ="";
			
			
			$ausgeliehen = query("SELECT * FROM `ausleihe` WHERE `objekte` LIKE '%".$row->objekt_id."%' AND `abgeschlossen` = '0000-00-00'");
			$name = query("SELECT * FROM `ausleiher` INNER JOIN `ausleihe` WHERE `ausleihe`.`objekte` LIKE '%".$row->objekt_id."%' AND `abgeschlossen` = '0000-00-00'");
			
			if(mysql_num_rows($ausgeliehen) != 0){
				$row1 = mysql_fetch_object($ausgeliehen);
			}
			
			if(mysql_num_rows($name) != 0){
				$row2 = mysql_fetch_object($name);
			}
			
			if(mysql_num_rows($ausgeliehen) == 1){
				$tpl = tpl_replace_once("verliehen","Verliehen bis: ".date("d.m.Y", strtotime($row1->bis))."<br /> Verliehen an: ".$row2->vorname." ".$row2->name);
				$tpl = tpl_replace_once("color","#ff4444");
				$tpl = tpl_replace_once("aktion", '<img src="img/rueckgabe.png" alt="rueckgabe" title="bla"> <a href="mailto:'.$row2->email.'?cc=zdm@uni-muenster.de&bcc=&subject=Ausleihe '.$row->geraet_typ.'&body=Hallo '.$row2->vorname.',%0D%0D
						%0D%0DGru&szlig;, %0D ZDM Geowissenschaften"><img src="img/email.png" alt="mahnung"></a>');
			}
			else{
				$tpl = tpl_replace_once("verliehen","Ger&auml;t ist nicht verliehen");
				$tpl = tpl_replace_once("color","#55aa55");
				$tpl = tpl_replace_once("aktion", '<img src="img/aendern.png" alt="aendern"> <img src="img/verlaengerung.png" alt="ausleihen">');
			}
			
			
		}
	}
	$tpl = clean_code("uebersicht");


?>