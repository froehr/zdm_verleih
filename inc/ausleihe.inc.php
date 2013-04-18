<?php

$errormessage ="";
$successmessage ="";

if isset($_POST["matrikel"]){
	$matrikel = htmlentities(mysql_real_escape_string($_POST["matrikel"]));
	$result = query("select * from ausleiher where matrikel =".$matrikel)
	if mysql_num_rows($result) == 0{
	$errormessage ="Matrikel noch nicht in der Datenbank";
	$tpl = tpl_replace("matrikelform2", "");
	$tpl = tpl_replace("vorname", "");
	$tpl = tpl_replace("nachname", "");
	$tpl = tpl_replace("email", "");
	$tpl = tpl_replace("telefon", "");
	$tpl = tpl_replace("strasse", "");
	$tpl = tpl_replace("hausnummer", "");
	$tpl = tpl_replace("plz", "");
	$tpl = tpl_replace("anfangsdatum", "");
	$tpl = tpl_replace("enddatum", "");
	}
	else
	$row = mysql_fetch_object($result);
	$tpl = tpl_replace("matrikelform2", $row->matrikel);
	$tpl = tpl_replace("vorname", $row->vorname);
	$tpl = tpl_replace("nachname", $row->nachname);
	$tpl = tpl_replace("email", $row->email);
	$tpl = tpl_replace("telefon", $row->telefon);
	$tpl = tpl_replace("strasse", $row->strasse);
	$tpl = tpl_replace("hausnummer", $row->hausnummer);
	$tpl = tpl_replace("plz", $row->plz);
	$tpl = tpl_replace("anfangsdatum", $row->anfangsdatum);
	$tpl = tpl_replace("enddatum", $row->enddatum);
}




?>