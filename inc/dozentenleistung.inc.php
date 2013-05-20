<?php

$today = date("d.m.Y", time());

$dozent = query("SELECT * FROM `dozent` ORDER BY `dozent_name` ASC");

if (mysql_num_rows($dozent) != 0) {
		while ($row = mysql_fetch_object($dozent)) {	
				$tpl = tpl_replace("anfangsdatum", $today);
		
				$tpl = copy_code("option");
				$tpl = tpl_replace_once("dozentoption", $row->dozent_name);
		}
}
		
if(isset($_POST["datum"])){
		$dropdown = html_entity_decode(mysql_real_escape_string($_POST["dropdown"]));
		$leistung = htmlentities(mysql_real_escape_string($_POST["leistung"]));
		$name = mysql_real_escape_string($_POST["name"]);
		$datum = htmlentities(mysql_real_escape_string($_POST["datum"]));
		$betrag = str_replace(",", ".", mysql_real_escape_string($_POST["betrag"]));
		
		
		$number = query("SELECT * FROM `dozent` WHERE `dozent_name` = '".$dropdown."' ");
		
		$datum = date("Y-m-d", strtotime($datum));
		
		if (mysql_num_rows($number) != 0) {
		$row1 = mysql_fetch_object($number);
		
		query("INSERT INTO `dozentenleistungen`(`datum`, `benutzername`, `dozent_id`, `leistung`, `betrag`) VALUES ('".$datum."','".$name."','".$row1->dozent_id."','".$leistung."','".$betrag."')");
		
		}		
}

//Tabelle fŸllen
$aktuell = query("SELECT * FROM `dozent` INNER JOIN `dozentenleistungen` ON (dozent.dozent_id = dozentenleistungen.dozent_id) GROUP BY `dozent_name`");

if (mysql_num_rows($aktuell) != 0) {
		while ($row = mysql_fetch_object($aktuell)) {
				
				$gesamtbetrag = query("SELECT `betrag` FROM `dozentenleistungen` WHERE dozent_id = '".$row->dozent_id."'");
				$betrag = 0;
				
				while ($row1 = mysql_fetch_object($gesamtbetrag)) {
						$betrag += $row1->betrag;
				}
		
				$tpl = copy_code("dozent");
				$tpl = tpl_replace_once("dozentname", $row->dozent_name);
				$tpl = tpl_replace_once("gesamtbetrag", str_replace(".", ",", $betrag));
				$tpl = tpl_replace_once("dozent_id", $row->dozent_id);
				$tpl = tpl_replace_once("dozent_id", $row->dozent_id);
				$tpl = tpl_replace_once("dozent_id", $row->dozent_id);
				
				$detail = query("SELECT * FROM `dozentenleistungen` WHERE `dozent_id` = '".$row->dozent_id."'");
				
				$details = "";
				
				if (mysql_num_rows($detail) != 0) {
						while ($row2 = mysql_fetch_object($detail)) {
								
						$details .= "<tr>
								<td>
								    ".date("d.m.Y", strtotime($row2->datum))."
								</td>
								 <td>
								    ".$row2->benutzername."
								</td>
								<td>
								    ".$row2->leistung."
								</td>
								<td>
								    ".str_replace(".", ",", $row2->betrag)." &euro;
								</td>
						            </tr>";
							
							
							
						}
				}
				$tpl = tpl_replace_once("details1", $details);
				$details = "";
		}
}
		$tpl = clean_code("dozent");
		$tpl = clean_code("option");
		


?>