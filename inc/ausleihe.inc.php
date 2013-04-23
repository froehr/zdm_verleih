<?php

$errormessage ="";
$successmessage ="";
$vorname="";
$nachname="";
$email="";
$telefon="";
$strasse="";
$hausnummer="";
$plz="";
$matrikelform2="";


if (isset($_POST["matrikel"])){
	$matrikel = htmlentities(mysql_real_escape_string($_POST["matrikel"]));
	$result = query("select * from ausleiher where matrikel =".$matrikel);
	if (mysql_num_rows($result) == 0){
	$errormessage ="Matrikel noch nicht in der Datenbank";
	$matrikelform2=$matrikel;
	
	
	}
	
	else{
	$row = mysql_fetch_object($result);
	$vorname=$row->vorname;
	$nachname=$row->nachname;
	$email=$row->email;
	$telefon=$row->telefon;
	$strasse=$row->strasse;
	$hausnummer=$row->hausnummer;
	$plz=$row->postleitzahl;
	
	$tpl = tpl_replace("matrikelform2", $row->matrikel);
	}
}

else if (isset($_POST["matrikel2"])){
	$matrikel2 = htmlentities(mysql_real_escape_string($_POST["matrikel2"]));
	$vorname = htmlentities(mysql_real_escape_string($_POST["vorname"]));
	$nachname = htmlentities(mysql_real_escape_string($_POST["nachname"]));
	$email = htmlentities(mysql_real_escape_string($_POST["email"]));
	$telefon = htmlentities(mysql_real_escape_string($_POST["telefon"]));
	$strasse = htmlentities(mysql_real_escape_string($_POST["strasse"]));
	$hausnummer = htmlentities(mysql_real_escape_string($_POST["nummer"]));
	$plz = htmlentities(mysql_real_escape_string($_POST["plz"]));
	$anfang = htmlentities(mysql_real_escape_string($_POST["anfang"]));
	$ende = htmlentities(mysql_real_escape_string($_POST["ende"]));
	$successmessage ="Neue Ausleihe gespeichert!";
	
	query(
	"insert into`ausleiher`(`matrikel`, `name`, `vorname`, `email`, `telefon`, `postleitzahl`, `strasse`, `hausnummer`)
	values(".$matrikel2.", ".$nachname.", ".$vorname.", ".$email.", ".$telefon.", ".$plz.", ".$strasse.", ".$hausnummer.")");
	
	query(
	"inser into`ausleihe`(`matrikel`, `verleiher_id`, `von`, `bis`, `objekte`)
	values(".$matrikel2.", ".$verleiher.", ".$anfang.", ".$ende.", ".objekte.")");
}

$tpl = tpl_replace("vorname", $vorname);
$tpl = tpl_replace("nachname", $nachname);
$tpl = tpl_replace("email", $email);
$tpl = tpl_replace("telefon", $telefon);
$tpl = tpl_replace("strasse", $strasse);
$tpl = tpl_replace("hausnummer", $hausnummer);
$tpl = tpl_replace("plz", $plz);
$tpl = tpl_replace("matrikelform3", $matrikel2);
$tpl =tpl_replace("matrikelform2", $matrikelform2);
$tpl =tpl_replace("errormessage", $errormessage);
$tpl =tpl_replace("successmassage", $successmessage);
?>